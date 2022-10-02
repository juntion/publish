<template>
  <div>
    <div class="tabslist">
      <a-tabs class="tabs_bg"
              defaultActiveKey="2"
              v-model="searchData.tabs">
        <a-tab-pane :key="-1">
          <span slot="tab">
            All
          </span>
        </a-tab-pane>
        <a-tab-pane :key="8">
          <span slot="tab" title="未分配产品跟进人的诉求">
            待分配
            <a-badge :count="remind.status8" />
          </span>

        </a-tab-pane>
        <a-tab-pane :key="0">
          <span slot="tab" title="已分配跟进人但未处理的诉求">
            待受理
            <a-badge :count="remind.status0" />
          </span>

        </a-tab-pane>
        <a-tab-pane :key="1">
          <span slot="tab" title="跟进人正在处理的诉求">
            跟进中
            <a-badge :count="remind.status1" />
          </span>

        </a-tab-pane>
        <a-tab-pane :key="2">
          <span slot="tab" title="正在排期中的诉求">
            排期中
             <a-badge :count="remind.status2" />
          </span>

        </a-tab-pane>
        <a-tab-pane :key="3">
          <span slot="tab" title="等待负责人审核立项的诉求">
            申请立项
             <a-badge :count="remind.status3" />
          </span>

        </a-tab-pane>
        <a-tab-pane :key="4">
          <span slot="tab"  title="已经立项给研发的诉求">
            已立项
            <a-badge :count="remind.status4" />
          </span>
        </a-tab-pane>
        <a-tab-pane :key="5">
          <span slot="tab" title="已处理的诉求">
            已完成
          </span>

        </a-tab-pane>
        <a-tab-pane :key="6">
          <span slot="tab">
            已驳回
          </span>

        </a-tab-pane>
        <a-tab-pane :key="7">
          <span slot="tab">
            已撤销
          </span>

        </a-tab-pane>

      </a-tabs>
      <!-- 选择筛选 -->
      <div class="select-box">
        <a-select placeholder="部门"
                  labelInValue
                  showSearch
                  optionFilterProp="children"
                  v-model="searchData.departments"
                  style="width: 7%;margin-right: 10px;">
          <a-select-option v-for="item in options"
                           :key="item.id">{{item.name}}</a-select-option>
        </a-select>
        <!--
        <a-select placeholder="诉求人"
                  labelInValue
                  optionFilterProp="children"
                  showSearch
                   @search="handleSearch"
                  v-model="searchData.promulgator"
                  style="width: 7%;margin-right: 10px;">
          <a-select-option v-for="item in options2"
                           :key="item.id">{{item.name}}</a-select-option>
        </a-select>
        -->
        <allPersonSelect :autoFocus="false"
                         @getSelectValue="handleSearch"
                         :selectValue="promulgatorID"
                         :searchData="promulgatorArr"
                         ref="promulgatorRef"
                         placeholder="诉求人(请输入英文名搜索)"
                         style="width: 7%;margin-right: 10px;">
        </allPersonSelect>
        <!--
         <a-select placeholder="产品负责人"
                  labelInValue
                  showSearch
                  optionFilterProp="children"
                  v-model="searchData.productPrincipal"
                  style="width: 7%;margin-right: 10px;">
          <a-select-option v-for="item in options3"
                           :key="item.id">{{item.name}}</a-select-option>
        </a-select>
        -->
        <allPersonSelect :autoFocus="false"
                         @getSelectValue="handleSearch4"
                         :selectValue="productPrincipalID"
                         :searchData="productPrincipalArr"
                         ref="productPrincipalRef"
                         placeholder="产品负责人(请输入英文名搜索)"
                         style="width: 7%;margin-right: 10px;">
        </allPersonSelect>
        <!--
         <a-select placeholder="跟进人"
                  labelInValue
                   showSearch
                  optionFilterProp="children"
                  v-model="searchData.productFollower"
                  style="width: 7%;margin-right: 10px;">
          <a-select-option v-for="item in options4"
                           :key="item.id">{{item.name}}</a-select-option>
        </a-select>
        -->
        <allPersonSelect :autoFocus="false"
                         @getSelectValue="handleSearch5"
                         :selectValue="productFollowerID"
                         :searchData="productFollowerArr"
                         ref="productFollowerRef"
                         placeholder="跟进人(请输入英文名搜索)"
                         style="width: 7%;margin-right: 10px;">
        </allPersonSelect>
        <a-range-picker
                    style="width:14%;margin-right: 10px;"
                    v-model="searchData.created_at"
                    :allowClear="false"
                    format="YYYY/MM/DD"
                    >
                    <span class="iconfont" slot="suffixIcon" style="font-size:12px;margin-top: -6px;">&#xe659;</span>
        </a-range-picker>
        <a-input-search placeholder="名称/简述/编号"
                        style="width: 14%;position: relative;"
                        v-model="searchValue"
                        @search="onSearch" />
        <span style="margin-left:10px;color: #378eef">
            <mySearch @search="moreSearch" ref="search" :department="options"></mySearch>
        </span>
        <div class="upload_box">
          <p class="selet-serch">筛选：</p>
          <div class="popup_opinion_submit_box after">
            <ul class="popup_opinion_submit_file">
              <li v-if="searchData.departments"><b>部门：{{searchData.departments.label}}</b>
                <i class="icon iconfont"
                   @click="reset(1)">&#xe631;</i>
              </li>
              <li v-if="searchData.promulgator"><b>诉求人：{{searchData.promulgator.label}}</b>
                <i class="icon iconfont"
                   @click="reset(2)">&#xe631;</i>
              </li>
              <li v-if="searchData.productPrincipal"><b>产品负责人：{{searchData.productPrincipal.label}}</b>
                <i class="icon iconfont"
                   @click="reset(4)">&#xe631;</i>
              </li>
              <li v-if="searchData.productFollower"><b>跟进人：{{searchData.productFollower.label}}</b>
                <i class="icon iconfont"
                   @click="reset(5)">&#xe631;</i>
              </li>
              <li v-if="searchData.created_at"><b>时间：{{ searchData.created_at[0].format('YYYY/MM/DD') + ' 至 ' + searchData.created_at[1].format('YYYY/MM/DD')}}</b>
                <i class="icon iconfont"
                   @click="reset(3)">&#xe631;</i>
              </li>
              <li v-if="mySearch"><b>高级筛选</b>
                <i class="icon iconfont"
                   @click="reset(6)">&#xe631;</i>
              </li>
            </ul>

          </div>
        </div>
        <!-- 撤销提示 -->
        <!-- <el-button type="text" @click="dialogVisible = true">点击打开 Dialog</el-button> -->
        <div class="modal-box">
          <el-dialog
                     class="modal-box-four"
                     title="提示"
                     :visible.sync="dialogVisible"
                     width="380px"
                     @close="dialogVisible = false,$refs['revokeForm'].resetFields(),textarea3=''"
                     :close-on-click-modal="false"
                     :before-close="handleClose">
            <div class="radio_box">
              <!-- <p>是否撤销</p> -->
              <el-form :model="{textarea3}" :rules="revokeRules" ref="revokeForm" >
                 <el-form-item prop="textarea3">
                    <p><span>*</span>备注</p>
                    <el-input type="textarea"
                                :autosize="{ minRows: 3, maxRows: 3}"
                                placeholder="请输入备注"
                                v-model="textarea3"
                                resize="none">

                    </el-input>
                </el-form-item>
              </el-form>
            </div>
            <span slot="footer"
                  class="dialog-footer">
              <el-button @click="dialogVisible = false,$refs['revokeForm'].resetFields(),textarea3=''">取 消</el-button>
              <el-button type="primary"
                         @click="cofigRevocation">确 定</el-button>
            </span>

          </el-dialog>

        </div>
        <!-- <el-button type="text" @click="dialogVisible2 = true">提示2</el-button> -->
        <!-- 提示 -->
        <div class="modal-box-two">
          <el-dialog title="提示"
                     :visible.sync="dialogVisible2"
                     width="380px"
                     :before-close="handleCloseTwo">

            <div class="tip-text">
              <p class="text-text-1"> 确定要将诉求 <span>删除</span></p>
              <p class="text-text-2">
                删除后不可恢复，请谨慎操作
              </p>
            </div>
            <span slot="footer"
                  class="dialog-footer">
              <el-button type="primary"
                         @click="cofigDel">确 定</el-button>
              <el-button @click="dialogVisible2 = false">取 消</el-button>

            </span>
          </el-dialog>

        </div>
         <a-modal title="诉求转移"
                   class="modal-pms"
                   :maskClosable="false"
                   v-model="transferShow"
                   :confirmLoading="btnLoad"
                   @cancel="cancel(3)"
                   @ok="ok(3)"
                   width="380px">
                   <p style="margin-bottom:20px;color:#f88d49" v-if="receiver_id"> * 即将转移{{selectedRowKeys.length}}个诉求至{{receiver_name}},请注意确认</p>
                   <div style="display:flex">
                       <div>
                           <p style="margin-bottom:10px">诉求转移账号: </p>
                            <a-input
                            disabled
                            v-model="transferPeople"
                            style="width:150px"/>
                       </div>
                        <div style="flex:1;text-align: center;position: relative;top:34px">
                             <span class="iconfont fz12" style="color:#BBBBBB">&#xe6fb;</span>
                        </div>
                        <div>
                            <p style="margin-bottom:10px">诉求接收账号: </p>
                            <peopleSelect @getValue2="getTransferID" :valueData="receiver_id" style="width:150px" ref="peopleSelect"></peopleSelect>
                        </div>
                   </div>
        </a-modal>
        <!-- 操作记录 -->
        <a-modal title="状态变动记录"
                 v-model="dialogVisible3"
                 @ok="handleOk"
                 width="746px"
                 class="eidt-model3">
          <a-table :columns="columns2"
                   :dataSource="data2"
                   :pagination="false"
                   :rowKey="(record, index) => index"
                   class="eidt-form-width">
              <div slot="status" slot-scope="status,record">
                  <span style="color:#BBBBBB;" v-if="record.status=='待分配'">{{record.status}}</span>
                  <span style="color:#FF4A4A;" v-if="record.status=='待受理'">{{record.status}}</span>
                  <span style="color:#FEBC2E;" v-if="record.status=='跟进中'">{{record.status}}</span>
                  <span style="color:#FF4A4A;" v-if="record.status=='排期中'">{{record.status}}</span>
                  <span style="color:#FFB400;" v-if="record.status=='申请立项'">{{record.status}}</span>
                  <span style="color:#FFB400;" v-if="record.status=='已立项'">{{record.status}}</span>
                  <span style="color:#FFB400;" v-if="record.status=='立项待审核'">{{record.status}}</span>
                  <span style="color:#3DCCA6;" v-if="record.status=='已完成'">{{record.status}}</span>
                  <span style="color:#FF4A4A;" v-if="record.status=='已驳回'">{{record.status}}</span>
                  <span style="color:#BBBBBB;" v-if="record.status=='已撤销'">{{record.status}}</span>
              </div>
          </a-table>
          <div slot="footer"></div>

        </a-modal>
        <!-- 发布诉求时候提示一个框并且需要备注 -->
        <div class="modal-box">
          <el-dialog title="提示"
                     :visible.sync="dialogVisible4"
                     width="380px"
                     :before-close="handleCloseTree">
            <div class="eidt-tips">
              <p>
                注意：使用拆解功能，会把一个诉求拆成至少两个新的诉求，原诉求将被置灰无法使用；被拆解后，将无法恢复，请务必谨慎操作；
                <span class="icon iconfont down">&#xe631;</span>
              </p>
            </div>
            <div class="radio_box">
              <p>备注:</p>
              <el-input type="textarea"
                        :autosize="{ minRows: 3, maxRows: 3}"
                        placeholder="请输入备注"
                        v-model="textarea2"
                        resize="none">

              </el-input>
            </div>
            <span slot="footer"
                  class="dialog-footer">
              <el-button @click="dialogVisible4 = false">取 消</el-button>
              <el-button type="primary">确 定</el-button>
            </span>
          </el-dialog>

        </div>
        <!-- 发布诉求 -->
        <div class="btn-right">
          <p @click="labShow" style="cursor: pointer;" v-if="canDo('pm.labels.labelsManagement')"><i class="icon iconfont"></i>标签管理</p>
         <a-popover trigger="click" placement="bottomLeft">
                <div slot="content" >
                    <div style="padding:10px 10px 0">
                          <a-radio-group name="radioGroup" v-model="excelRadio">
                            <a-radio :value="1">
                            诉求信息表
                            </a-radio>
                        </a-radio-group>

                    </div>
                    <div class="ok" >
                        <a-button type="primary" @click="handleExport">确定</a-button>
                    </div>
                </div>
                 <p style="cursor: pointer;">
                    <i class="icon iconfont"
                    style="font-size: 12px;">&#xe65a;</i>导出</p>
        </a-popover>
          <a-button type="primary"
                    v-if="canDo('pm.appeals.store')"
                    @click="loacalclaim(2)">
            <a-icon type="plus" />发布诉求</a-button>

        </div>
        <!-- 诉求审核 -->
        <a-modal
                 title="诉求审核"
                 :maskClosable="false"
                 :visible="dialogVisible5"
                 @ok="handleOk2"
                 :confirmLoading="confirmLoading"
                 @cancel="handleCancel"
                 class="eidt-model4"
                 width="380px">
         <a-form-model
            ref="ruleForm2"
            :model="{textinfos,textinfos2}"
            :rules="rules2"
        >
          <a-form-model-item>
          <span slot="label"> <span style="color:red">*</span>审核状态:</span>
          <a-select style="width:100%"
                    v-model="claimStatus"
                    placeholder="请选择">
            <a-select-option :value="0">待受理</a-select-option>
            <a-select-option :value="1">跟进中</a-select-option>
            <a-select-option :value="2">排期中</a-select-option>
            <a-select-option :value="5">已完成</a-select-option>
            <a-select-option :value="6">已驳回</a-select-option>
          </a-select>
        </a-form-model-item>
        <div class="radio_box"
             v-if="claimStatus==1">
          <p>症结点：</p>
          <a-form-model-item prop="textinfos">
          <a-textarea v-model="textinfos"
                      style="height:80px !important;"
                      placeholder="可描述下这个需求的症结点有哪些"
                      :rows="5" />
          </a-form-model-item>
        </div>
        <div class="radio_box">
          <p>备注：</p>
          <a-form-model-item prop="textinfos2">
          <a-textarea v-model="textinfos2"
                      style="height:80px !important;"
                      :placeholder="claimStatus==2?'简单排期说明安排（大致的时间安排)':'请输入备注'"
                      :rows="5" />
          </a-form-model-item>
        </div>
         </a-form-model>
        </a-modal>
        <!-- 诉求产品修改指定人 -->
        <div class="modal-box">
          <a-modal title="编辑产品跟进人"
                    @cancel="taskcancel"
                    :maskClosable="false"
                   v-model="dialogVisible6"
                   width="700px">
            <a-form :form="allotForm">
              <div class="radio_box">
                <a-row class="form-row">
                  <a-col :lg="12"
                         :md="12"
                         :sm="24"
                         style="padding-right: 20px">
                    <a-form-item>
                      <span slot="label"> 指定处理人</span>
                        <!--
                        <a-select placeholder="跟进人"
                                 showSearch
                                optionFilterProp="children"
                                v-decorator="['follower_id', { rules: [{ required: true, message: '请选择处理人' }] }]"
                                >
                        <a-select-option v-for="item in options4"
                                        :key="item.id">{{item.name}}</a-select-option>
                        </a-select>
                        -->
                        <allPersonSelect :autoFocus="false"
                                        @getSelectValue="handleModalFollow"
                                        :selectValue="modalFollowerID ? modalFollowerID : undefined"
                                        :searchData="modalFollowerArr"
                                        ref="modalFollowerRef"
                                        v-decorator="['follower_id', { rules: [{ required: true, message: '请选择处理人' }] }]"
                                        style="width: 100%;">
                        </allPersonSelect>
                    </a-form-item>
                  </a-col>
                  <a-col :lg="12"
                         :md="12"
                         :sm="24">
                    <a-form-item label="预计交付日期">
                      <a-date-picker style="width:245px"
                                     format="YYYY-MM-DD"
                                     :disabledDate="disabledDate"
                                     v-decorator="['expiration_date']"
                                     type="date"
                                     placeholder="选择日期">
                      </a-date-picker>
                    </a-form-item>
                  </a-col>
                </a-row>
                <a-form-item label="备注">
                  <a-textarea v-decorator="['comment']"
                              :autosize="{ minRows: 3, maxRows: 3}"
                              placeholder="请输入备注"
                              resize="none">
                  </a-textarea>
                </a-form-item>
              </div>
            </a-form>
            <span slot="footer"
                  class="dialog-footer">
              <el-button @click="taskcancel">取 消</el-button>
              <el-button type="primary"
                         @click="ok(1)">确 定</el-button>
            </span>
          </a-modal>
        </div>
        <!-- 修改产品分类 -->
        <div class="modal-box">
          <a-modal
                  class="modal-box-tree"
                  title="产品分类"
                  :maskClosable="false"
                  @cancel="taskcancel2"
                   v-model="dialogVisible7"
                   width="700px">
            <a-form-model ref="ruleForm"
                :model="pro_form"
                :rules="rules">
                 <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right:10px;"
                    >
                    <a-form-model-item prop="productsLine_id">
                        <span slot="label">所属产品线</span>
                        <a-select
                                    v-model="pro_form.productsLine_id"
                                    @change="handleProvinceChange"
                                    placeholder="请选择">
                            <a-select-option v-for="k in productsLine2"
                                            :key="k.id">{{k.name}}</a-select-option>
                        </a-select>
                    </a-form-model-item>
                 </a-col>
                  <a-col :lg="12"
                     :md="12"
                     :sm="24"
                    >
                    <a-form-model-item prop="product_id">
                        <span slot="label">产品名称</span>
                        <a-select
                                    placeholder="请选择"
                                    v-model="pro_form.product_id"
                                    @change="handleProvinceChange2">
                            <a-select-option v-for="item in products"
                                            :key="item.id">{{item.name}}</a-select-option>
                        </a-select>
                    </a-form-model-item>
                  </a-col>
                  <!--
                   <div>
                 <span class="add" @click="addModules"><a-icon type="plus" />添加</span>
                 <a-row v-for="(item,index) in pro_form.product_modules" :key="index" class="form-row">
                    <a-col
                        :lg="12"
                        :md="12"
                        :sm="24"
                        style="padding-right:10px">
                        <a-form-model-item>
                            <span slot="label" v-if="index===0">模块名称</span>
                            <a-select   v-model="item.module_id"
                                        allowClear
                                        @change="handleProvinceChange3($event,index)"
                                        placeholder="请选择">
                                <a-select-option v-for="item in modules"
                                                :title="item.description"
                                                :key="item.id">{{item.name}}</a-select-option>
                            </a-select>
                        </a-form-model-item>
                     </a-col>
                    <a-col :lg="12"
                        :md="12"
                        :sm="24"
                        >
                        <a-form-model-item>
                        <span slot="label" v-if="index===0">模块标签</span>
                        <a-select   v-model="item.label_ids"
                                    mode="multiple"
                                    allowClear
                                    :style="{width:pro_form.product_modules.length > 1 ? '93%': '100%'}"
                                    placeholder="请选择">
                            <a-select-option v-for="item2 in item.moduleTags"
                                            :title="item2.description"
                                            :key="item2.id">{{item2.name}}</a-select-option>
                        </a-select>
                        </a-form-model-item>
                    </a-col>
                      <span class="iconfont del"
                            v-if="pro_form.product_modules.length > 1"
                            @click="() => remove(index)">&#xe631;</span>
               </a-row>
            </div>
            -->
            </a-form-model>
            <div class="clearFl"></div>
            <div slot="footer"
                  style="margin-top: 0"
                  class="dialog-footer">
              <el-button @click="taskcancel2()">取 消</el-button>
              <el-button type="primary"
                         @click="ok(2)">确 定</el-button>
            </div>
          </a-modal>
        </div>
        <!-- 标签管理 -->
        <a-modal title="标签管理"
                 :maskClosable="false"
                 :visible="dialogVisible8"
                 :confirmLoading="confirmLoading"
                 width="700px"
                 class="eidt_modal"
                 :footer="null"
                 @cancel="handleCancel2">
          <div class="lab_content">
            <ul style="width:42%;"  >
              <div class="lab_content_header">
                <p>类别</p>
                <p >
                  <span class="addProduct" @click="addLabClass" v-if="canDo('pm.labelCategories.store')">
                    <a-icon type="plus" /> 新增类别</span>
                </p>
              </div>
              <draggable :options="dragOptions"
                         @end="onEnd"
                         @start="onStart"
                         @change="change"
                         :list="productsData"
                         class="eidt-dra-list">
                <li v-for="(objs,ins) in productsData"
                    style="cursor: pointer;"
                    :style="{background: activeIndex==ins ? '#e6f7ff' : '' ,border: activeIndex==ins ?  '1px solid #378eef' : ''}"
                    :key="ins">
                  <div class="lab_content_left"
                       @click="pointlabList(objs.id,ins)">
                    <span class="iconfont drag-icon">&#xe646;</span>
                    <span style="margin-right:6px;"
                          class="input-none"
                          v-bind:class="{ showActive2:ins==inputVisible}">
                      <a-input ref="input"
                               type="text"
                               size="small"
                               :style="{ width: '130px' ,height:'24px'}"
                               v-model="inputValue"
                               @blur="handleInputConfirm(objs,0)"
                               @keyup.enter="$event.target.blur"
                                />

                    </span>
                    <p @dblclick="showInput(ins,objs.name)"
                       v-bind:class="{ showActive:ins==inputVisible}">{{objs.name}}</p>
                  </div>
                  <div class="lab_content_right">

                    <!-- 下拉颜色选择框 -->
                    <el-dropdown trigger="click" >
                      <div class="color-button-box">
                        <div class="color-button"
                             :style="{'background':objs.style}">
                        </div>
                        <div class="color-button-min"
                             :style="{'background':objs.style}"></div>
                      </div>
                      <el-dropdown-menu slot="dropdown" style="width:100px;padding: 3px 0">
                        <el-dropdown-item v-for="(item5,index5) in colorList"
                                          :key="index5">
                          <div @click="selectColor(objs,item5.color)" style="padding: 8px 42px;">
                              <span class="colorLi"
                                :style="{'background':item5.color}"
                                >

                            </span>
                          </div>
                        </el-dropdown-item>
                      </el-dropdown-menu>
                    </el-dropdown>
                    <el-switch :active-value="1"
                               active-color="RGBA(58, 205, 167, 1)"
                               :inactive-value="0"
                               class="mb"
                               @change="changeMsg(objs.is_open,objs,ins)"
                               v-model="objs.is_open" />

                    <i style="cursor: pointer;margin-left:6px;"
                       class="icon iconfont"
                       v-if="canDo('pm.labelCategories.destroy')"
                       @click="delThetag(objs.id)">&#xe631;</i>
                  </div>

                </li>
              </draggable>
            </ul>
            <ul style="width:58%;">
              <div class="lab_content_header">
                <p>标签</p>
                <p >
                  <span class="addProduct" @click="addlab" v-if="canDo('pm.labels.store')">
                    <a-icon type="plus" /> 新增标签</span>
                </p>
              </div>
              <draggable :options="dragOptions"
                         @change="change2"
                         :list="productsData2"
                         class="eidt-dra-list">
                <li v-for="(objs2,ins2) in productsData2"
                    style="cursor: pointer;"
                    :key="ins2">
                  <div class="lab_content_left">
                    <span class="iconfont drag-icon">&#xe646;</span>
                    <span style="margin-right:6px;"
                          class="input-none"
                          v-bind:class="{ showActive2:ins2==inputVisible2}">
                      <a-input ref="input"
                               type="text"
                               size="small"
                               :style="{ width: '130px' ,height:'24px'}"
                               v-model="inputValue2"
                               @blur="handleInputConfirm(objs2,1)"
                              @keyup.enter="$event.target.blur"
                              />
                    </span>
                    <p @dblclick="showInput2(ins2,objs2.name)"
                       v-bind:class="{ showActive:ins2==inputVisible2}">{{objs2.name}}</p>

                  </div>
                  <div class="lab_content_right">
                    <el-switch :active-value="1"
                               active-color="RGBA(58, 205, 167, 1)"
                               :inactive-value="0"
                               class="mb"
                               @change="changeMsg2(objs2.is_open,objs2,ins2)"
                               v-model="objs2.is_open" />
                    <i style="cursor: pointer;margin-left:6px;"
                       class="icon iconfont"
                       v-if="canDo('pm.labels.destroy')"
                       @click="delThelab(objs2.id)">&#xe631;</i>
                  </div>

                </li>
              </draggable>
            </ul>
          </div>
        </a-modal>
        <!-- 贴标签 -->
        <a-modal title="贴标签"
                 :maskClosable="false"
                 :visible="dialogVisible9"
                 :confirmLoading="confirmLoading"
                 width="700px"
                 class="eidt_modal eidt_modal_footer"
                 @ok="handleOk3"
                 @cancel="handleCancel3">
          <div class="lab_content_all">
            <div class="lab-select-arr">
              <template v-for="(tag) in tags">
                <a-tag
                       :key="tag.id"
                       :closable="true"
                       @close="handleClose3(tag)"
                       :style="{'background':tag.style}">
                  {{tag.name}}
                </a-tag>

              </template>
            </div>
            <div class="labmain-box">
                    <div class="labmains"
                   v-for="(item3,index3) in productsData3"
                   :key="index3">
                <h3 >{{item3.name}}</h3>
                <div class="pointLab">
                 <span  v-for="(item4,index4) in item3.labels"
                         :key="index4">
                  <a-tag @click="selectLab(item4)"
                         :style="{'background':item4.style,'color':'#fff'}">
                    {{item4.name}}
                  </a-tag>
                 </span>
                </div>

              </div>
            </div>
          </div>

        </a-modal>

      </div>

      <div class="table-list" id="table-list">
        <a-table :rowSelection="{selectedRowKeys: selectedRowKeys, onChange: onSelectChange}"
                 :rowKey="(record, index) => record.id"
                 :columns="columns"
                 :scroll="{ x: 1300 }"
                 :loading="loading"
                 :pagination="pagination1"
                 :dataSource="data">

          <div slot="number"
               slot-scope="number,record"
               class="pro">
            <p class="text-p">{{record.number}}</p>
             <p class="text-p">
                 <!-- 诉求类型；1：规则调整；2：新增功能；3：迭代建议；4：数据提取；5：Bug修复；6：其他； -->
                 <span v-if="record.type===1">规则调整</span>
                 <span v-if="record.type===2">新增功能</span>
                 <span v-if="record.type===3">迭代建议</span>
                 <span v-if="record.type===4">数据提取</span>
                 <span v-if="record.type===5">Bug修复</span>
                  <span v-if="record.type===7">设计样式</span>
                 <span v-if="record.type===6">其他</span>
            </p>
            <div class="text-button"
                 v-if="record.questions">
              <a-popover placement="bottomLeft"
                         :getPopupContainer="triggerNode => triggerNode.parentNode"
                         arrowPointAtCenter>
                <template slot="content"
                          v-if="JSON.parse(record.questions).urgent">
                  <div style="padding:10px">
                    <p style="color:#bbb">{{JSON.parse(record.questions).urgent[0].question}}:</p>
                    <p>{{JSON.parse(record.questions).urgent[0].answer}}</p>
                    <p style="color:#bbb">{{JSON.parse(record.questions).urgent[1].question}}:</p>
                    <p>{{JSON.parse(record.questions).urgent[1].answer}}</p>
                  </div>
                </template>
                <img v-if="record.is_urgent"
                     src="@/assets/images/urg.png"
                     alt="IMG">
              </a-popover>
              <a-popover placement="bottomLeft"
                         :getPopupContainer="triggerNode => triggerNode.parentNode"
                         arrowPointAtCenter>
                <template slot="content"
                          v-if="JSON.parse(record.questions).important">
                  <div style="padding:10px">
                    <p style="color:#bbb">{{JSON.parse(record.questions).important[0].question}}:</p>
                    <p>{{JSON.parse(record.questions).important[0].answer}}</p>
                  </div>
                </template>
                <img v-if="record.is_important"
                     src="@/assets/images/imp.png"
                     alt="URG">
              </a-popover>
            </div>

          </div>
          <div slot="messages"
               slot-scope="messages,record"
               class="pro_status">
            <p class="text-p">{{record.dept_name}}</p>
            <p class="text-p">{{record.promulgator_name}}</p>
            <p class="text-p">{{record.created_at}}</p>
          </div>
          <div slot="source_project_name"
               slot-scope="source_project_name,record"
               class="pro_status">
            <p class="text-p text-p-blue"
               v-if="source_project_name">
                <router-link class="text-p-overflow" :to="{ name: 'proDetails', query: { id: record.source_project_id }}" target="_blank" :title="source_project_name" style="max-width:200px"> {{source_project_name}}</router-link>
               </p>
            <p v-else>--</p>

          </div>
          <div slot="name"
               slot-scope="name,record"
               class="pro_tips">
            <p class="text-p text-p-blue text-p-flex"
              >
              <span class="rideo"
                    v-if="record.is_updated &&record.status_desc!=='已完成' && record.status_desc!=='已驳回' && record.status_desc!=='已撤销'"></span>
              <router-link :to="{ name: 'claimDetail', query: { id: record.id }}" target="_blank" class="text-p-overflow" :title="name" style="position: relative;">{{name}}</router-link>
              <span v-if="record.status_desc!=='已完成' && record.status_desc!=='已驳回' && record.status_desc!=='已撤销'">
                <span v-if="record.remaining_days">
                    <span style="color:rgb(242, 141, 73);" v-if="record.remaining_days>0  || record.remaining_days==0">(还剩{{record.remaining_days}}天)</span>
                    <span style="color:#FF4A4A;" v-if="record.remaining_days<0">(超时{{Math.abs(record.remaining_days)}}天)</span>
                </span>
              </span>
            </p>

          </div>
          <div slot="media"
               slot-scope="media"
               class="pro_annex">
            <a-popover placement="bottomLeft"
                       v-if="media.length>0"
                       :getPopupContainer="triggerNode => triggerNode.parentNode"
                       arrowPointAtCenter>
              <template slot="content">
                <div class="download-list">
                  <p>附件</p>
                  <downPrd :media="media"
                           :span="24"></downPrd>
                </div>
              </template>
              <span class="icon iconfont">&#xe656;</span>
            </a-popover>
            <div v-else>--</div>

          </div>
          <div slot="principal_user_name"
               slot-scope="principal_user_name,record"
               class="pro_principal">
            <!-- <span class="icon iconfont">&#xe615;</span> -->

            <div @click="showHandler2(record)">
              <a-popover placement="bottomLeft"
                         style="cursor: pointer;"
                            arrowPointAtCenter>
                <template slot="content"
                            >
                    <div>
                        <p >{{record.product_category.product_line.name}} </p>
                    </div>
                </template>
                <p class="text-p text-p-overflow2"  style="display:block">{{record.product_category.product_line.name}}</p>
              </a-popover>

             <a-popover placement="bottomLeft"
                        style="cursor: pointer;"
                       arrowPointAtCenter>
              <template slot="content"
                        >
                <div>
                  <p v-for="(its,ind) in record.product_category.product_modules"
                     :key="ind"
                      >
                    {{record.product_category.product.name}}/{{its.name}}
                   <span v-if="its.product_labels.length">
                        (<span v-for="(item,index) in its.product_labels" :key="index"> {{item.name}} <span v-if="index!==its.product_labels.length-1">,</span></span>)
                   </span>
                  </p>
                  <p v-if="record.product_category.product_modules.length===0" >
                         {{record.product_category.product.name}}
                  </p>
                </div>
              </template>
              <p class="text-p text-p-overflow2" >{{record.product_category.product.name}} <span style="color:#666;font-size: 12px;" v-if="record.product_category.product_modules.length >0">{{'/'+ record.product_category.product_modules[0].name}}</span> </p>
            </a-popover>

            </div>
              <div>
              <p @click="handbutton(record)" class="text-p eidt-pir" :title="principal_user_name">
              <span style="color:#666666;font-size: 12px;" v-if="!record.select">{{principal_user_name}}</span>
              <a-select style="width: 120px;font-size: 14px;"
              autoFocus
              @blur="handleBlur(record)"
              @change="handleChange($event,record)"
              :defaultOpen="true"
              v-if="record.select"
              :value="principal_user_name"
              >
              <a-select-option v-for="item4 in options5"
              :key="item4.id"><span>{{item4.name}}</span></a-select-option>
              </a-select>

              </p>
              <span style="cursor: pointer;" v-if="!principal_user_name">--</span>
              </div>
             <!--<p class="text-p" :title="principal_user_name">{{principal_user_name}}</p>-->
          </div>

          <div slot="follower_name"
               slot-scope="follower_name,record"
               class="pro_note">
            <p class="text-p follower-css"
               @click="showHandler(record)"
               v-if="record.policies.follow">
              {{record.follower_name?record.follower_name:'--'}}
            </p>
            <p class="text-p follower-css-statas"
               v-else>
              {{record.follower_name?record.follower_name:'--'}}
            </p>
            <p v-if="record.follow_time" class="text-p follower-css-statas">
              {{record.follow_time}}
            </p>
          </div>
          <div slot="comment"
               slot-scope="comment,record"
               class="pro_note">
             <a-popover placement="bottomLeft"
                        style="cursor: pointer;"
                        v-if="record.labels.length >0"
                       arrowPointAtCenter>
              <template slot="content"
                        >
                <div class="tip_button">
                  <p v-for="(its,ind) in record.labels"
                     :key="ind"
                     :style="{'background':its.style}">{{its.name}}</p>
                </div>
              </template>

              <span class="icon iconfont">&#xe636;</span>
            </a-popover>
            <div>
                <a-popover placement="bottomLeft"
                       :getPopupContainer="triggerNode => triggerNode.parentNode"
                       arrowPointAtCenter>
                    <template slot="content" style="max-width:300px">
                        <p v-if="record.comment_follower" style="word-break: break-all;">跟进人 : {{record.comment_follower}}</p>
                        <p v-if="comment" style="padding-bottom: 10px;word-break:break-all;">负责人 : {{comment}}</p>
                    </template>
                <div class="overflow-3 cup" style="color:#666"
                >
                    <span v-if="record.comment_follower">跟进人 : {{record.comment_follower}}</span>
                    <br v-if="record.comment_follower">
                    <span v-if="comment">负责人 : {{comment}}</span>
                </div>
                </a-popover>
                <p v-if="!comment && !record.comment_follower">--</p>
            </div>
          </div>
          <div slot="status"
               slot-scope="status,record"
               style="cursor: pointer;"
               @click="recordEidtlist(record)"
               class="pro_status pro_status_eidt">
            <span class="icon iconfont ico-color"
                  style="color:#BBBBBB;"
                  v-if="record.status_desc=='待分配'"
                  >&#xe654;</span>
            <span class="icon iconfont ico-color"
                  style="color:#FF4A4A;"
                  v-if="record.status_desc=='待受理'">&#xe654;</span>
            <span class="icon iconfont ico-color"
                  style="color:#FEBC2E;"
                  v-if="record.status_desc=='跟进中'">&#xe654;</span>
            <span class="icon iconfont ico-color"
                  style="color:#FF4A4A;"
                  v-if="record.status_desc=='排期中'">&#xe654;</span>
            <span class="icon iconfont ico-color"
                  style="color:#FFB400;"
                  v-if="record.status_desc=='申请立项'">&#xe654;</span>
            <span class="icon iconfont ico-color"
                  style="color:#FFB400;"
                  v-if="record.status_desc=='已立项'">&#xe654;</span>
            <span class="icon iconfont ico-color"
                  style="color:#FFB400;"
                  v-if="record.status_desc=='立项待审核'">&#xe654;</span>
            <span class="icon iconfont ico-color"
                  style="color:#3DCCA6;"
                  v-if="record.status_desc=='已完成'">&#xe654;</span>
            <span class="icon iconfont ico-color"
                  style="color:#FF4A4A;"
                  v-if="record.status_desc=='已驳回'">&#xe654;</span>
            <span class="icon iconfont ico-color"
                  style="color:#BBBBBB;"
                  v-if="record.status_desc=='已撤销'">&#xe654;</span>

            <span class="text-p">{{record.status_desc}}</span>

          </div>
          <div slot="operate"
               slot-scope="operate,record"
               class="pro_operate">
            <!-- 操作 -->
            <span v-for="(item,index) in record.operation" :key="index" >
                    <span v-if="item==='认领'" :title="item" class="icon iconfont" @click="clickSuccess(1,record.id)">&#xe644;</span>
                    <span v-if="item==='取消认领'" :title="item" class="icon iconfont" style="color:#FEBC2E;" @click="clickSuccess(2,record.id)">&#xe644;</span>
                    <span v-if="item==='更新审核'" :title="item" class="icon iconfont" @click="appeaRreview(record,record.id)">&#xe63d;</span>
                    <span v-if="item==='立项'" :title="item" class="icon iconfont" @click="clickSuccess(4,record.id,record)">&#xe63a;</span>
                    <span v-if="item==='取消立项'" :title="item" class="icon iconfont" style="color:#FEBC2E;" @click="clickSuccess(3,record.id)">&#xe63a;</span>
                    <a-popover placement="bottomLeft"
                    v-if="record.demand"
                    :getPopupContainer="triggerNode => triggerNode.parentNode"
                    arrowPointAtCenter>
                    <template slot="content">
                            <div style="display:flex;">
                            <p style="color:#bbb;width:52px;white-space: nowrap;margin-right: 10px;">需求信息: </p>
                            <div>
                                <router-link :to="{ name: 'demandDetails', query: { id: record.demand_id }}" target="_blank" >{{record.demand.number}}</router-link>
                            </div>
                        </div>
                    </template>
                        <span v-if="item==='立项详情'"  class="icon iconfont" >&#xe62a;</span>
                    </a-popover>
                    <span v-if="item==='拆解诉求'" :title="item" class="icon iconfont" @click="loacalDslclaim(record.id)">&#xe63b;</span>
                    <span v-if="item==='贴标签'" :title="item" class="icon iconfont" @click="pasteShow(record)"></span>
                    <span v-if="item==='编辑'" :title="item" class="icon iconfont" @click="loacalclaim(1,record.id)">&#xe637;</span>
                    <span v-if="item==='撤销'" :title="item" class="icon iconfont" @click="dialogChange(record.id,record)">&#xe657;</span>
                    <span v-if="item==='删除'" :title="item" class="icon iconfont" @click="dialogDel(record.id,record)">&#xe64d;</span>
            </span>
             <!-- 超过3个展示这个下拉 -->
            <div class="eidtDropdown" v-if="record.operation2 && record.operation2.length">
                    <a-dropdown :trigger="['click']" placement="bottomCenter" :getPopupContainer="triggerNode => triggerNode.parentNode">
                    <a class="ant-dropdown-link" href="#" v-if="record.operation2 && record.operation2.length">
                      <span  title="更多" class="icon iconfont">&#xe634;</span>
                    </a>
                    <a-menu slot="overlay" style="padding: 5px 2px;" class="edit-icon">
                      <a-menu-item v-for="(item,index) in record.operation2" :key="index" >
                            <span v-if="item==='认领'" :title="item" class="icon iconfont" @click="clickSuccess(1,record.id)">&#xe644; <span class="eidt-text">{{item}}</span></span>
                            <span v-if="item==='取消认领'" :title="item" class="icon iconfont" style="color:#FEBC2E;" @click="clickSuccess(2,record.id)">&#xe644; <span class="eidt-text">{{item}}</span></span>
                            <span v-if="item==='更新审核'" :title="item" class="icon iconfont" @click="appeaRreview(record,record.id)">&#xe63d; <span class="eidt-text">{{item}}</span></span>
                            <span v-if="item==='立项'" :title="item" class="icon iconfont" @click="clickSuccess(4,record.id,record)">&#xe63a; <span class="eidt-text">{{item}}</span></span>
                            <span v-if="item==='取消立项'" :title="item" class="icon iconfont" style="color:#FEBC2E;" @click="clickSuccess(3,record.id)">&#xe63a; <span class="eidt-text">{{item}}</span></span>
                            <span v-if="item==='立项详情'" :title="item" class="icon iconfont" @click="goDemand(record.demand_id)">&#xe62a; <span class="eidt-text">{{item}}</span></span>
                            <span v-if="item==='拆解诉求'" :title="item" class="icon iconfont" @click="loacalDslclaim(record.id)">&#xe63b; <span class="eidt-text">{{item}}</span></span>
                            <span v-if="item==='贴标签'" :title="item" class="icon iconfont" @click="pasteShow(record)"> <span class="eidt-text">{{item}}</span></span>
                            <span v-if="item==='编辑'" :title="item" class="icon iconfont" @click="loacalclaim(1,record.id)">&#xe637; <span class="eidt-text">{{item}}</span></span>
                            <span v-if="item==='撤销'" :title="item" class="icon iconfont" @click="dialogChange(record.id,record)">&#xe657; <span class="eidt-text">{{item}}</span></span>
                            <span v-if="item==='删除'" :title="item" class="icon iconfont" @click="dialogDel(record.id)">&#xe64d; <span class="eidt-text">{{item}}</span></span>
                      </a-menu-item>
                    </a-menu>
                  </a-dropdown>
            </div>
          </div>

        </a-table>

        <div style="margin-bottom: 16px">
          <div class="table-eidt" :style="{width:screenWidth+'px',height:'64px'}" v-if="data.length>0">
            <a-table :rowSelection="{selectedRowKeys: selectedRowKeys, onChange: onSelectChange}"
                     :columns="columns"
                     :dataSource="data"
                     :pagination="pagination1"
                     @change="changePage"
                     :rowKey="record=> record.id">
            </a-table>
            <span class="select-lengs select-lengs-eidt">
              全选
            </span>
            <span class="select-lengs">
                <a-button type="primary" @click="pushAll(selectedRowKeys)" v-if="canDo('pm.appeals.mergeCreateDemand')" style="margin-right:10px">合并立项</a-button>
                <a-button type="primary" @click="transfer(selectedRowKeys)" v-if="canDo('pm.appeals.transfer')" style="margin-right:10px">诉求转移</a-button>
                <template v-if="hasSelected">
                    <span style="color:#bbb">{{`选中 ${selectedRowKeys.length} 个诉求`}}</span>
                </template>
            </span>
          </div>
        </div>
      </div>
    </div>
    <!-- 选择筛选 -->

  </div>
</template>
<script>
/* eslint-disable */
import mySearch from './components/search'
import peopleSelect from '@/components/peopleSelect'
import allPersonSelect from '@/components/allPersonSelect'
import qs from 'qs'
import { canDo, filtering } from '@/plugins/common'
import { searchUserList } from '@/api/userManage/index.js'
import _ from 'lodash'

import { getAppealsExcel,getProducts, claimList, revocation, delClaim, getClaimLog, updateReview, sendClaim,
  cancelClaim, cancelProject, eidtTaskPeople, eidtIcation, addTagClass, eidtTagClass, delTagClass, getTagClassList,
  sortTagClass, addTag, eidtTag, delTag, pasteTag, getTagList, sortTag, getlabclassAll, getlDepartment, getClaimant,
  getProductPrincipal, getProductFollower,eidtProductPrincipal,getClaimPrincipall,claimDetial,appealsTransfer
} from '../../../api/recount'
import moment from 'moment'
import downPrd from '@/components/downPrd'
import draggable from 'vuedraggable'
const columns = [
  {
    title: '诉求ID/类型/紧急程度',
    dataIndex: 'number',
    key: 'number',
    width:150,
    scopedSlots: { customRender: 'number' }
  },
  {
    title: '发布信息',
    dataIndex: 'created_at',
    key: 'created_at',
    width:120,
    scopedSlots: { customRender: 'messages' },
    slots: { title: 'customTitle' },
    sorter: function (a, b) {
      let aTimeString = a.created_at
      let bTimeString = b.created_at
      aTimeString = aTimeString.replace(/-/g, '/')
      bTimeString = bTimeString.replace(/-/g, '/')
      let aTime = new Date(aTimeString).getTime()
      let bTime = new Date(bTimeString).getTime()
      return bTime - aTime
    }
  },
  {
    title: '项目来源',
    key: 'source_project_name',
    dataIndex: 'source_project_name',
    scopedSlots: { customRender: 'source_project_name' },
    width: 190
  },
  {
    title: '诉求标题',
    key: 'name',
    dataIndex: 'name',
    width: 250,
    scopedSlots: { customRender: 'name' }
  },
  {
    title: '附件',
    key: 'media',
    width:60,
    dataIndex: 'media',
    scopedSlots: { customRender: 'media' }
  },
  {
    title: '产品/模块(标签)/负责人',
    key: 'principal_user_name',
    dataIndex: 'principal_user_name',
    width:170,
    scopedSlots: { customRender: 'principal_user_name' }
  },
  {
    title: '产品跟进人/时间',
    key: 'follower_name',
    dataIndex: 'follower_name',
    width:120,
    scopedSlots: { customRender: 'follower_name' }
  },
  {
    title: '标签/备注',
    key: 'comment',
    width:210,
    dataIndex: 'comment',
    scopedSlots: { customRender: 'comment' }

  },
  {
    title: '状态',
    key: 'status',
    dataIndex: 'status',
    width:105,
    scopedSlots: { customRender: 'status' }

  },
  {
    title: `操作`,
    key: 'operate',
    dataIndex: 'operate',
    scopedSlots: { customRender: 'operate' },
  }

]

const columns2 = [
  {
    title: '时间',
    dataIndex: 'created_at',
    key: 'created_at'
  },
  {
    title: '状态',
    dataIndex: 'status',
    key: 'status',
    scopedSlots: { customRender: 'status' }

  },
  {
    title: '操作人',
    key: 'user_name',
    dataIndex: 'user_name'
  },
  {
    title: '描述',
    key: 'comment',
    width: 308,
    dataIndex: 'comment'
  }
]
let search = []
let may = []
let must = []
const productsLine = [
  {
    type: '0',
    name: '待受理'
  },
  {
    type: '1',
    name: '跟进中'
  },
  {
    type: '2',
    name: '排期中'
  },
  {
    type: '5',
    name: '已完成'
  },
  {
    type: '6',
    name: '已驳回'
  }
]
const dragOptions = {
  sort: true,
  scroll: true,
  scrollSpeed: 2,
  animation: 150,
  ghostClass: 'dragable-ghost',
  chosenClass: 'dragable-chose',
  dragClass: 'dragable-drag'
}
export default {
  components: { mySearch, downPrd, draggable, peopleSelect, allPersonSelect },
  data () {
    return {
      excelRadio: 1,
      searchValue:'',
      btnLoad: false,
      isFixed: false,
      remind: {},
      dragOptions,
      data: [],
      mySearch:false,
      rules2: { textinfos: [ { max: 255, message: '不能超过255个字符', trigger: 'blur' } ], textinfos2: [ { max: 255, message: '不能超过255个字符', trigger: 'blur' } ] },
      revokeRules: { textarea3: [ { required: true, message: '请输入备注', trigger: 'blur' } ] },
      allotForm: this.$form.createForm(this, { name: 'allotTask' }),
      columns,
      selectedRowKeys: [], // Check here to configure the default column
      loading: false,
      options: [],
      options2: [],
      options3: [],
      options4: [],
      options5:[],
      value: '',
      value2: '',
      value3: '',
      promulgatorArr: [],
      promulgatorID: undefined,
      productPrincipalArr: [],
      productPrincipalID: undefined,
      productFollowerArr: [],
      productFollowerID: undefined,
      modalFollowerArr: [],
      modalFollowerID: undefined,
      dialogVisible: false,
      dialogVisible2: false,
      dialogVisible3: false,
      dialogVisible4: false,
      dialogVisible5: false,
      dialogVisible6: false,
      dialogVisible7: false,
      dialogVisible8: false,
      dialogVisible9: false,
      transferShow:false,
      transferPeople:undefined,
      receiver_id:undefined,
      receiver_name:undefined,
      textarea2: '',
      textarea3: '',
      rct_id: '',
      del_id: '',
      demand_id:'',
      activeIndex: 0,
      isIndeterminate: true,
      checkAll: false,
      form: {
        dept_id: 1,
        promulgator_id: 1,
        follower_id: 1,
        status: 1
      },
      isaclive: true,
      claim_id: '',
      data2: [],
      columns2,
      searchData: {
        tabs: -1,
        priority: undefined,
        created_at: undefined,
        departments: undefined,
        promulgator: undefined,
        productPrincipal: undefined,
        productFollower: undefined
      },
      pagination1: {
        showSizeChanger: true,
        pageSizeOptions: ['10', '20', '30', '50'],
        total: 10,
        current: 1,
        pageSize: 10
      },
      confirmLoading: false,
      claimStatus: '',
      productsLine,
      productsLine2: [],
      products: [],
      modules: [],
      moduleTags: [],
      textinfos: '',
      textinfos2: '',
      status_desc: '',
      status_desc_id: '',
      taskId: '',

      taskComment: '',
      pro_form: {
        productsLine_id: undefined,
        product_id: undefined,
        // product_modules: [{ module_id: undefined, label_ids: [],moduleTags: [] }],
      },
      rules: {
        productsLine_id: [ { required: true, message: '请选择', trigger: 'change' } ],
        product_id: [ { required: true, message: '请选择', trigger: 'change' } ]
      },
      productsData: [],
      productsData2: [],
      productsData3: [],
      inputValue: '',
      inputValue2: '',
      inputVisible: -1,
      inputVisible2: -1,
      lab_category_id: '',
      tags: [],
      check1: 0,
      check2: 1,
      colorList: [
        { color: '#378EEF' },
        { color: '#0AA658' },
        { color: '#EC354B' },
        { color: '#6E4DE8' },
        { color: '#F28D49' },
        { color: '#E34F8D' },
        { color: '#0F8B90' },
        { color: '#2578BE' },
        { color: '#3DCCA6' }
      ],
      colorCode: '',
      screenWidth: this.$store.state.recount.pageWidth,

    }
  },
  created () {
    if (localStorage.getItem('isReload1')) {
      this.$store.commit('changeGuide1', false)
    } else {
      this.$store.commit('changeGuide1', true)
      localStorage.setItem('isReload1', true)
    }
    getProducts().then(res => {
      this.productsLine2 = res.data.products
    })
    getlDepartment().then(res => {
      if (res.code === 200) {
        this.options = res.data.departments
      }
    })
    getClaimant().then(res => {
      if (res.code === 200) {
        this.options2 = res.data.users
      }
    })
    getProductPrincipal().then(res => {
      if (res.code === 200) {
        this.options3 = res.data.users

      }
    })
    getProductFollower().then(res => {
      if (res.code === 200) {
        this.options4 = res.data.users
      }
    })
  },
  watch: {
    '$store.state.recount.pageWidth' (newVal) {
      this.screenWidth = newVal
    },
    // receiver_id(newVal){
    //     console.log(newVal);
    //     this.$nextTick(()=>{
    //          this.receiver_name=document.getElementsByClassName('ant-select-selection-selected-value')[0].textContent
    //     })

    // },
    searchData: {
      handler (newVal, oldVal) {
        if (!this.searchValue) {
            search['keyword'] = undefined
        }
        search['status'] = newVal.tabs
        if (newVal.tabs === -1) {
          search['status'] = undefined
        }
        if (newVal.created_at) {
          search['created_at'] = newVal.created_at[0].format('YYYY/MM/DD') + ',' + newVal.created_at[1].format('YYYY/MM/DD')
        } else {
          search['created_at'] = undefined
        }
        if (newVal.departments) {
          search['dept_id'] = newVal.departments.key
        } else {
          search['dept_id'] = undefined
        }
        if (newVal.promulgator) {
          search['promulgator_id'] = newVal.promulgator.key
        } else {
          search['promulgator_id'] = undefined
        }
        if (newVal.productPrincipal) {
          search['principal_user_id'] = newVal.productPrincipal.key
        } else {
          search['principal_user_id'] = undefined
        }
        if (newVal.productFollower) {
          search['follower_id'] = newVal.productFollower.key
        } else {
          search['follower_id'] = undefined
        }
        if (this.$route.params.id) {
        search['demand.id'] = this.$route.params.id
       }
        this.loading = true
        let params = { filters: search, may,
        must,limit: this.pagination1.pageSize || 10 }
        claimList(params).then(res => {
          this.remind = res.data.remind
          this.data = res.data.data.map(item => {
            return { show: false, select: false, ...item }
          })
            this.data.forEach(item => {
             let arr=[item.policies.apply ? '认领': '',item.policies.applyCancel ? '取消认领' : '',item.policies.verify ? '更新审核': '' ,item.policies.createDemand ? '立项' :'',
                item.policies.cancelDemand ? '取消立项' :'', item.demand_id ? '立项详情' : '',item.policies.disassemble ? '拆解诉求' : '',item.policies.labels ? '贴标签' : '',
                item.policies.edit ? '编辑' : '',item.policies.revocation ? '撤销' : '',item.policies.delete ? '删除' : ''].filter(Boolean)
                if (arr.length>2) {
                    item.operation = arr.slice(0,3)
                    item.operation2=arr.splice(3)

                }else{
                    item.operation = arr
                }
            })


          this.pagination1.total = res.data.total
          this.pagination1.current = res.data.current_page
          this.pagination1.pageSize = res.data.per_page
          this.loading = false
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      },
      deep: true
    }
  },
  mounted () {
    if (!this.$route.params.id) {
        let userType = {}
        let user = {}
        let userCache = {}
        if (localStorage.getItem('userType')) {
          userType = JSON.parse(localStorage.getItem('userType'))
        }
        if (localStorage.getItem('user')) {
          user = JSON.parse(localStorage.getItem('user'))
          userCache = _.cloneDeep(user)
        }
        if (userType.product_owner) {
          this.productPrincipalArr = userCache.id ? [{ name: userCache.name, id: userCache.id }] : []
          this.productPrincipalID = userCache.id ? userCache.id : undefined
          this.searchData.productPrincipal = { label: user.name, key: user.id }
        } else if (userType.product_followers) {
          this.productFollowerArr = userCache.id ? [{ name: userCache.name, id: userCache.id }] : []
          this.productFollowerID = userCache.id ? userCache.id : undefined
          this.searchData.productFollower = { label: user.name, key: user.id }
        } else if (userType.it_matchmaker) {
          this.promulgatorArr = userCache.id ? [{ name: userCache.name, id: userCache.id }] : []
          this.promulgatorID = userCache.id ? userCache.id : undefined
          this.searchData.promulgator = { label: user.name, key: user.id }
        } else if (userType.product_analyst) {
          this.productFollowerArr = userCache.id ? [{ name: userCache.name, id: userCache.id }] : []
          this.productFollowerID = userCache.id ? userCache.id : undefined
          this.searchData.productFollower = { label: user.name, key: user.id }
        }else{
            this.loading = true
            search = []
            this.getclaimlist()
        }
    }else{
        this.loading = true
        search = []
        this.getclaimlist()
    }

    window.addEventListener('scroll', this.handleScroll, true) // 监听（绑定）滚轮滚动事件
  },
  destroyed () {
    window.removeEventListener('scroll', this.handleScroll, true) //  离开页面清除（移除）滚轮滚动事件
  },
  computed: {
    hasSelected () {
      return this.selectedRowKeys.length > 0
    },
  },
  methods: {
    canDo,
    moment,
    filtering,
    handleSearch(e, type){
        this.searchData.promulgator = e.id === undefined ? undefined : { key: e.id, label: e.name }
        if (e) {
             this.$nextTick(() => {
            let self = this
            this.timer = searchUserList(this.timer, e, function (data) {
                self.options2 = data.data.users
                })
            })
        }else{
             getClaimant().then(res => {
                if (res.code === 200) {
                    this.options2 = res.data.users
                }
            })
        }
    },
    handleSearch4 (e) {
      this.searchData.productPrincipal = e.id === undefined ? undefined : { key: e.id, label: e.name }
    },
    handleSearch5 (e) {
      this.searchData.productFollower = e.id === undefined ? undefined : { key: e.id, label: e.name }
    },
    handleModalFollow (e) {
      this.allotForm.setFieldsValue({ 'follower_id': e.id })
    },
    moreSearch (e) {
      may = []
      must = []
      filtering(e, may, must)
      let params = {
        may,
        must,
        limit: 10
      }
      this.promulgatorArr = []
      this.promulgatorID = undefined
      this.$refs.promulgatorRef.value = undefined
      this.productPrincipalArr = []
      this.productPrincipalID = undefined
      this.$refs.productPrincipalRef.value = undefined
      this.productFollowerArr = []
      this.productFollowerID = undefined
      this.$refs.productFollowerRef.value = undefined
      for (let key in this.searchData) {
        if (key === 'promulgator' || key === 'productPrincipal' || key === 'productFollower') {
          this.searchData[key] = undefined
        } else {
          delete this.searchData[key]
        }
      }
      search = []
      this.mySearch=true
      claimList(params).then(res => {
        this.$refs.search.showSearch = false
        this.remind = res.data.remind
        this.data = res.data.data.map(item => {
          return { show: false, select: false, ...item }
        })
           this.data.forEach(item => {
            let arr=[item.policies.apply ? '认领': '',item.policies.applyCancel ? '取消认领' : '',item.policies.verify ? '更新审核': '' ,item.policies.createDemand ? '立项' :'',
            item.policies.cancelDemand ? '取消立项' :'', item.demand_id ? '立项详情' : '',item.policies.disassemble ? '拆解诉求' : '',item.policies.labels ? '贴标签' : '',
            item.policies.edit ? '编辑' : '',item.policies.revocation ? '撤销' : '',item.policies.delete ? '删除' : ''].filter(Boolean)
            if (arr.length>2) {
                item.operation = arr.slice(0,3)
                item.operation2=arr.splice(3)

            }else{
                item.operation = arr
            }
        })
        this.pagination1.total = res.data.total
        this.pagination1.current = res.data.current_page
        this.pagination1.pageSize = res.data.per_page
        this.loading = false
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    // 在methods监控滚动时间
    handleScroll () {
      this.$nextTick(() => {
        let scrollTop = document.documentElement.scrollTop || document.body.scrollTop || window.pageYOffset
        // let header = document.getElementsByClassName('table-list')[0].style.width
        if (scrollTop > 10) {
          this.isFixed = true
        } else {
          this.isFixed = false
        }
      })
    },
    handleExport(){
        let params={ may, must, search}
        params = qs.stringify(params)
        getAppealsExcel(params)
    },
    /* addModules () {
      this.pro_form.product_modules.push({ module_id: undefined, label_ids: [] ,moduleTags: []})
    },
    remove (e) {
      this.pro_form.product_modules.splice(e, 1)
    }, */
    disabledDate (current) {
      // 不能选择今天以前的日期
      return current && current < moment().startOf('day')
    },
    transfer(ids){
        if (ids.length > 0) {
        // 根据勾选数组匹配data中的属性
            let user = []
            let arr = ids.map(item => {
                let obj = {}
                this.data.forEach(item2 => {
                    if (item2.id == item) {
                        obj.id = item
                        obj.status_desc = item2.status_desc
                        obj.status = item2.status
                        if (item2.status===5) {
                            this.$message.error('已完成诉求,不可操作转移!')
                        }else if(item2.status===6){
                            this.$message.error('已驳回诉求,不可操作转移!')
                        }else if(item2.status===7){
                            this.$message.error('已撤销诉求,不可操作转移!')
                        }
                        user.push(item2.promulgator_name)
                    }
                })
                return obj
            })
            let result=user.some(function (value, index) {
                return value !== user[0];
            })
            let arr2 =arr.map(item=>{
                return item.status
            })
            if (result) {
                this.$message.error('请确认需转移的诉求发布人为同一人!')
            }
            if (!result && arr2.indexOf(5)===-1 && arr2.indexOf(6)===-1 && arr2.indexOf(7)===-1) {
                this.transferShow=true
                this.transferPeople=user[0]
            }

        }else{
            this.$message.error('请勾选')
        }
    },
    getTransferID(e,name){
        this.receiver_id=e
        this.receiver_name=name
    },
    pushAll (ids) {
      if (ids.length > 1) {
        // 根据勾选数组匹配data中的属性
        let user = []
        let numbers =[]
        let products =[]
        let arr = ids.map(item => {
          let obj = {}
          this.data.forEach(item2 => {
            if (item2.id == item) {
              obj.id = item
              obj.verify = item2.policies.verify
              user.push(item2.principal_user_id)
              numbers.push(item2.number)
              products.push(item2.product_category)
            }
          })
          return obj
        })
        // 产品负责人不相同,不可合并立项
        let result=user.some(function (value, index) {
              return value !== user[0];
          })
        // 如果数组中有一个不能立项,就不能合并立项
        let notAllow = arr.some(value => {
          return value.verify === false
        })
        if (!notAllow && !result) {
          this.$router.push({ name: 'releaseDemand', query: { sqId: ids,sqNumber:numbers } })
          localStorage.setItem('sqProduct',JSON.stringify(products))
        } else if(result){
          this.$message.error('产品负责人不相同,不可合并立项')
        }else{
            this.$message.error('勾选的诉求不能合并立项,请重新勾选')
        }
      } else {
        this.$message.error('请勾选两个及以上诉求')
      }
    },
    goDemand (id) {
      this.$router.push({ name: 'demandDetails', query: { id } })
    },
    // 分页
    changePage (e) {
      this.loading = true
      let params = {}
      params = { may, must, filters: search, page: e.current, limit: e.pageSize }
      claimList(params).then(res => {
        this.remind = res.data.remind
        this.data = res.data.data.map(item => {
          return { show: false, select: false, ...item }
        })
        this.data.forEach(item => {
            let arr=[item.policies.apply ? '认领': '',item.policies.applyCancel ? '取消认领' : '',item.policies.verify ? '更新审核': '' ,item.policies.createDemand ? '立项' :'',
            item.policies.cancelDemand ? '取消立项' :'', item.demand_id ? '立项详情' : '',item.policies.disassemble ? '拆解诉求' : '',item.policies.labels ? '贴标签' : '',
            item.policies.edit ? '编辑' : '',item.policies.revocation ? '撤销' : '',item.policies.delete ? '删除' : ''].filter(Boolean)
            if (arr.length>2) {
                item.operation = arr.slice(0,3)
                item.operation2=arr.splice(3)

            }else{
                item.operation = arr
            }
        })
        this.pagination1.total = res.data.total
        this.pagination1.current = res.data.current_page
        this.pagination1.pageSize = res.data.per_page
        this.loading = false
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    removeProperty (object) {
      for (let key in object) {
        if (object[key] === '') {
          delete object[key]
        }
      }
    },
    reset (index) {
      if (index === 1) {
        this.searchData.departments = undefined
      } else if (index === 2) {
        this.promulgatorArr = []
        this.promulgatorID = undefined
        this.$refs.promulgatorRef.value = undefined
        this.searchData.promulgator = undefined
      } else if (index === 3) {
        this.searchData.created_at = undefined
      } else if (index === 4) {
        this.productPrincipalArr = []
        this.productPrincipalID = undefined
        this.$refs.productPrincipalRef.value = undefined
        this.searchData.productPrincipal = undefined
      } else if (index === 5) {
        this.productFollowerArr = []
        this.productFollowerID = undefined
        this.$refs.productFollowerRef.value = undefined
        this.searchData.productFollower = undefined
      }else if (index === 6) {
          this.mySearch=false
          this.loading = true
          may = []
          must = []
          this.$refs.search.data= {
            andOr: 'and',
            form: [
            { condition: undefined, judge: undefined, value: '' },
            { condition: undefined, judge: undefined, value: '' },
            { condition: undefined, judge: undefined, value: '' }
            ]
          }
          this.getclaimlist()
      }
    },
    async handleTableChange (pagination) {
      await this.$store.dispatch('TableChange', pagination).catch(error => {
        this.$store.commit('SET_PAGE_LOADING', false)
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    start () {
      this.loading = true
      // ajax request after empty completing
      setTimeout(() => {
        this.loading = false
        this.selectedRowKeys = []
      }, 1000)
    },
    onSelectChange (selectedRowKeys) {
      this.selectedRowKeys = selectedRowKeys
    },
    onSearch (value) {
      if (value) {
        search['keyword'] = '%' + value.trim() + '%'
      } else {
        search['keyword'] = undefined
      }
      let params = { filters: search, limit: 10 }
      claimList(params).then(res => {
        this.remind = res.data.remind
        this.data = res.data.data.map(item => {
          return { select: false, ...item }
        })
        this.data.forEach(item => {
            let arr=[item.policies.apply ? '认领': '',item.policies.applyCancel ? '取消认领' : '',item.policies.verify ? '更新审核': '' ,item.policies.createDemand ? '立项' :'',
            item.policies.cancelDemand ? '取消立项' :'', item.demand_id ? '立项详情' : '',item.policies.disassemble ? '拆解诉求' : '',item.policies.labels ? '贴标签' : '',
            item.policies.edit ? '编辑' : '',item.policies.revocation ? '撤销' : '',item.policies.delete ? '删除' : ''].filter(Boolean)
            if (arr.length>2) {
                item.operation = arr.slice(0,3)
                item.operation2=arr.splice(3)

            }else{
                item.operation = arr
            }
        })
        this.pagination1.total = res.data.total
        this.pagination1.current = res.data.current_page
        this.pagination1.pageSize = res.data.per_page
        this.loading = false
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    setModal1Visible (modal1Visible) {
      this.modal1Visible = modal1Visible
    },
    handleClose (done) {
      this.dialogVisible = false
    },
    handleCloseTwo (done) {
      this.dialogVisible2 = false
    },
    handleCloseTree (done) {
      this.dialogVisible4 = false
    },
    loacalclaim (types, id) {
      //      this.$router.push('postclaim')
      if (id) {
        this.$router.push({ path: 'eidtClaim', query: { type: types, id: id } })
      } else {
        this.$router.push({ path: 'postclaim', query: { type: types } })
      }
    },
    loacalDslclaim (id) {
      this.$router.push({ path: 'claimDismantling', query: { id: id } })
    },
    loacalclaimDetail (id) {
      this.$router.push({ path: 'claimDetail', query: { id: id } })
    },
    loacaldismantlclaim () {
      this.$router.push('dismantlclaim')
    },
    dialogChange (id,record) {
      this.dialogVisible = true
      this.rct_id = id
      claimDetial(id).then(res=>{
          this.demand_id=res.data.appeals.demand_id
      })

    },
    dialogDel (id,record) {
      this.dialogVisible2 = true
      this.del_id = id
       claimDetial(id).then(res=>{
          this.demand_id=res.data.appeals.demand_id
      })
    },
    cofigDel () {
        if (this.demand_id) {
             if (confirm('检测到此诉求已存在立项XQ编号，继续操作立项信息将被删除！')) {
                    delClaim(this.del_id).then(data => {
                        if (data.code === 200) {
                            this.dialogVisible2 = false
                            this.$message.success('删除成功')
                            this.getclaimlist()
                        }
                    }).catch(error => {
                        this.dialogVisible2 = false
                        this.$message.error(error.response ? error.response.data.message : error.message)
                    })
             }

        }else{
            delClaim(this.del_id).then(data => {
                if (data.code === 200) {
                    this.dialogVisible2 = false
                    this.$message.success('删除成功')
                    this.getclaimlist()
                }
            }).catch(error => {
                this.dialogVisible2 = false
                this.$message.error(error.response ? error.response.data.message : error.message)
            })
        }

    },
    cofigRevocation () {
      this.$refs['revokeForm'].validate((valid) => {
        if (valid) {
            if (this.demand_id) {
                if (confirm('检测到此诉求已存在立项XQ编号，继续操作立项信息将被删除！')) {
                     let params = {
                    comment: this.textarea3
                    }
                     revocation(params, this.rct_id).then(data => {
                        this.$message.success('撤销成功')
                        this.dialogVisible = false
                        this.getclaimlist()
                    }).catch(error => {
                        this.dialogVisible = false
                        this.$message.error(error.response ? error.response.data.message : error.message)
                    })
                }

            }else{
                let params = {
                comment: this.textarea3
                }
                 revocation(params, this.rct_id).then(data => {
                    this.$message.success('撤销成功')
                    this.dialogVisible = false
                    this.getclaimlist()
                }).catch(error => {
                    this.dialogVisible = false
                    this.$message.error(error.response ? error.response.data.message : error.message)
                })
            }

        } else {
          return false
        }
      })
    },
    getclaimlist () {
      if (this.$route.params.id) {
        this.searchData = {}
        search['demand.id'] = this.$route.params.id
      }
      let params = {
        limit: this.pagination1.pageSize || 10,
        page: this.pagination1.current || 1,
        filters: search
      }
      claimList(params).then(res => {
        this.remind = res.data.remind
        this.data = res.data.data.map(item => {
          return { show: false, select: false, ...item }
        })

          this.data.forEach(item => {
             let arr=[item.policies.apply ? '认领': '',item.policies.applyCancel ? '取消认领' : '',item.policies.verify ? '更新审核': '' ,item.policies.createDemand ? '立项' :'',
                item.policies.cancelDemand ? '取消立项' :'', item.demand_id ? '立项详情' : '',item.policies.disassemble ? '拆解诉求' : '',item.policies.labels ? '贴标签' : '',
                item.policies.edit ? '编辑' : '',item.policies.revocation ? '撤销' : '',item.policies.delete ? '删除' : ''].filter(Boolean)
                if (arr.length>2) {
                     item.operation = arr.slice(0,3)
                     item.operation2=arr.splice(3)

                }else{
                    item.operation = arr
                }


            })

        this.pagination1.total = res.data.total
        this.pagination1.current = res.data.current_page
        this.pagination1.pageSize = res.data.per_page
        this.loading = false
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    showAclive (record) {
      record.show = !record.show
    },
    handleOk (e) {
      this.dialogVisible3 = false
    },
    async recordEidtlist (datas) {
      await getClaimLog(datas.id).then(data => {
        this.dialogVisible3 = true
        this.data2 = data.data.status_logs
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    handleOk2 (e) {
      this.$refs.ruleForm2.validate(valid => {
        if (valid) {
            let params = {
            status: this.claimStatus,
            crux: this.textinfos,
            comment: this.textinfos2
          }
          this.removeProperty(params)
            if (this.demand_id) {
                if ( this.claimStatus === 5 || this.claimStatus===6) {
                    if (confirm('检测到此诉求已存在立项XQ编号，继续操作立项信息将被删除！')) {
                         updateReview(params, this.status_desc_id).then(data => {
                        this.$message.success('审核成功')
                        this.textinfos2=''
                        this.dialogVisible5 = false
                        this.getclaimlist()
                        }).catch(error => {
                            this.dialogVisible5 = false
                            this.$message.error(error.response ? error.response.data.message : error.message)
                        })
                    }
                }else{
                    updateReview(params, this.status_desc_id).then(data => {
                    this.$message.success('审核成功')
                    this.textinfos2=''
                    this.dialogVisible5 = false
                    this.getclaimlist()
                    }).catch(error => {
                        this.dialogVisible5 = false
                        this.$message.error(error.response ? error.response.data.message : error.message)
                    })
                }
            }else{
                 updateReview(params, this.status_desc_id).then(data => {
                    this.$message.success('审核成功')
                    this.textinfos2=''
                    this.dialogVisible5 = false
                    this.getclaimlist()
                }).catch(error => {
                    this.dialogVisible5 = false
                    this.$message.error(error.response ? error.response.data.message : error.message)
                })
            }
        } else {
          return false
        }
      })
    },
    handleCancel (e) {
      this.$refs.ruleForm2.resetFields()
      this.textinfos = ''
      this.textinfos2 = ''
      this.dialogVisible5 = false
    },
    handleCancel2 (e) {
      this.dialogVisible8 = false
    },
    handleCancel3 (e) {
      this.dialogVisible9 = false
    },
    handleStatusChange (value) {
      this.claimStatus = value
    },
    appeaRreview (record, id) {
      this.claimStatus = record.status
      this.textinfos =record.crux
      this.textinfos2 =record.comment_follower
      this.status_desc_id = id
      claimDetial(id).then(res=>{
          this.demand_id=res.data.appeals.demand_id
      })
      this.dialogVisible5 = true
    },
    clickSuccess (status, id,record) {
      if (status == 1) {
        sendClaim(id).then(res => {
          this.$message.success('认领成功')
          this.getclaimlist()
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      }
      if (status == 2) {
        cancelClaim(id).then(res => {
          this.$message.success('取消认领')
          this.getclaimlist()
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      }
      if (status == 3) {
        cancelProject(id).then(res => {
          this.$message.success('取消立项')
          this.getclaimlist()
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      }
      if (status == 4) {
        if (record.demand_id) {
            this.$router.push({ name: 'editDemand', query: { id: record.demand_id,sqNumber:record.number } })
            localStorage.setItem('sqProduct',JSON.stringify([record.product_category]))
        }else{
            this.$router.push({ name: 'releaseDemand', query: { sqId: id ,sqNumber:record.number} })
            localStorage.setItem('sqProduct',JSON.stringify([record.product_category]))
        }
      }

      // this.$message.success('This is a message of success');
    },
    cancel(index){
        if (index===3) {
            this.transferShow = false
            this.receiver_id=undefined
            this.receiver_name=undefined
            this.$nextTick(()=>{
                    this.$refs.peopleSelect.show=false
                    this.$refs.peopleSelect.value1=undefined
                    this.$refs.peopleSelect.value2=undefined
            })
        }
    },
    ok (index) {
      if (index === 1) {
        this.allotForm.validateFields((err, values) => {
          if (!err) {
            if (values.expiration_date) {
              values.expiration_date = values['expiration_date'].format('YYYY-MM-DD')
            } else {
              delete values.expiration_date
            }
            if (!values.comment) {
              delete values.comment
            }
            eidtTaskPeople(values, this.taskId).then(res => {
              if (res.code === 200) {
                this.$message.success('更改跟进人成功')
                this.allotForm.resetFields()
                this.dialogVisible6 = false
                this.getclaimlist()
              }
            }).catch(error => {
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          } else {
            return false
          }
        })
      }else if (index === 2) {
        this.$refs.ruleForm.validate(valid => {
          if (valid) {
          /* this.pro_form.product_modules.map(item=>{
                 if (!item.module_id) {
                    this.pro_form.product_modules=[]
                 }
                }
            ) */
            eidtIcation(this.pro_form, this.taskId).then(res => {
              if (res.code === 200) {
                this.$message.success('更改产品分类成功')
                this.dialogVisible7 = false
                this.getclaimlist()
              }
            }).catch(error => {
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          } else {
            return false
          }
        })
      }else if(index===3){
          if (this.receiver_name===this.transferPeople) {
              this.$message.error('转移账号与接收账号不能为同一个')
          }else{
               let params ={
                appeal_ids:this.selectedRowKeys,
                receiver_id:this.receiver_id
            }
                 this.btnLoad = true
               appealsTransfer(params).then(res=>{
               if (res.code === 200) {
                this.btnLoad = false
                this.$message.success('转移成功')
                this.transferShow = false
                this.getclaimlist()
                this.receiver_id=undefined
                setTimeout(() => {
                    this.receiver_name=undefined
                }, 0);
                this.selectedRowKeys=[]
                this.$nextTick(()=>{
                    this.$refs.peopleSelect.show=false
                    this.$refs.peopleSelect.value1=undefined
                    this.$refs.peopleSelect.value2=undefined
                })

              }
          }).catch(error => {
               this.btnLoad = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          }

      }

    },
    showHandler (record) {
      this.dialogVisible6 = true
      var day = ''
      if (record.expiration_date) {
        day = moment(record.expiration_date)
      } else {
        day = undefined
      }
      this.modalFollowerID = record.follower_id
      this.modalFollowerArr = record.follower_id ? [{ id: record.follower_id, name: record.follower_name }] : []
      setTimeout(() => {
        this.allotForm.setFieldsValue({
          'follower_id': record.follower_id,
          'comment': record.comment,
          'expiration_date': day
        })
      }, 100)

      this.taskId = record.id
    },
    showHandler2 (record) {
      if (record.policies.products) {
        this.dialogVisible7 = true
        this.pro_form.productsLine_id=record.product_category.product_line.id
        this.pro_form.product_id=record.product_category.product.id
        getProducts(record.product_category.product_line.id).then(res => {
            this.products = res.data.products
        })
        getProducts(record.product_category.product.id).then(res => {
            this.modules = res.data.products
        })
        /* if (record.product_category.product_modules.length>0) {
            let a = []
           record.product_category.product_modules.forEach(k=>{
                k.product_labels=k.product_labels.map(e=>{
                    return e.id
                })
                getProducts(k.id).then(res => {
                    k.moduleTags = res.data.products
                    a.push({module_id:k.id,label_ids:k.product_labels,moduleTags:k.moduleTags})
                })
            })
             this.pro_form.product_modules=a
        }else{
            this.pro_form.product_modules=[{ module_id: undefined, label_ids: [] ,moduleTags: []}]
        } */

      }
      this.taskId = record.id
    },
    taskcancel () {
      this.dialogVisible6 = false
      this.modalFollowerID = undefined
      this.modalFollowerArr = []
      this.$refs.modalFollowerRef.value = undefined
      this.allotForm.setFieldsValue({ 'follower_id': undefined })
      this.allotForm.resetFields()
    },
    taskcancel2 () {
      this.dialogVisible7 = false
      this.getclaimlist()
    },
    handleProvinceChange (value) {
      this.pro_form.product_id=undefined
      /* const data = this.pro_form.product_modules
      this.pro_form.product_modules = data.map((item, key) => {
        return { module_id: undefined, label_ids: [] ,moduleTags: []}
      }) */
      this.modules=[]
      this.moduleTags=[]
      getProducts(value).then(res => {
        this.products = res.data.products
      })
    },
    handleProvinceChange2 (value) {
      /* const data = this.pro_form.product_modules
      this.pro_form.product_modules = data.map((item, key) => {
        return { module_id: undefined, label_ids: [] ,moduleTags: []}
      }) */
      this.modules=[]
      getProducts(value).then(res => {
        this.modules = res.data.products
      })
    },
    /* handleProvinceChange3 (value,index) {
      const data = this.pro_form.product_modules
      this.pro_form.product_modules = data.map((item, key) => {
        if (key === index) {
          return { module_id: item.module_id, label_ids: [] ,moduleTags: item.moduleTags}
        } else {
          return item
        }
      })
      if (value) {
           getProducts(value).then(res => {
            this.pro_form.product_modules[index].moduleTags = res.data.products
          })
      }else{
          this.pro_form.product_modules[index].moduleTags=[]
      }
    },*/
    // loadData (selectedOptions) {
    //   const targetOption = selectedOptions[selectedOptions.length - 1]
    //   targetOption.loading = true
    //   // 加载数据
    //   getProducts(targetOption.value).then(res => {
    //     targetOption.loading = false
    //     targetOption.children = res.data.products.map(item => {
    //       return { value: item.id, label: item.name, isLeaf: true }
    //     })
    //     this.modules = [...this.modules]
    //   })
    // },
    labShow (status_desc, id) {
      this.activeIndex = 0
      this.dialogVisible8 = true
      this.getLabClassList(0)
      setTimeout(() => {
        this.lab_category_id = this.productsData[0].id
        this.getLabList(0)
      }, 1000)
    },
    pasteShow (item) {
      this.labclassAll()
      this.tags = item.labels.map(k => {
        if (k.pivot) {
          delete k.pivot
        }
        return { ...k }
      })
      //   this.tags = item.labels
      this.dialogVisible9 = true
      this.claim_id = item.id
    },
    onEnd (e) {
    },
    onStart (e) {
    },
    change (evt) {
      let sort = this.productsData.map((item, index) => {
        return { label_category_id: item.id, sort: index }
      })
      let params = { label_categories_sort: sort }
      sortTagClass(params).then(res => {
        this.$message.success('您已对标签分类重新排序')
      })
    },
    change2 () {
      let sort = this.productsData2.map((item, index) => {
        return { label_id: item.id, sort: index }
      })
      let params = { labels_sort: sort }
      sortTag(params).then(res => {
        this.$message.success('您已对标签重新排序')
      })
    },
    handleInputConfirm (objs, type) {
      if (type === 0) {
        this.eidtClass(objs.is_open, objs.id, objs.name, objs.style, '修改标签名字成功')
      } else {
        this.eidtlabs(objs.is_open, objs.id, objs.name, '修改标签名字成功')
      }
    },
    getLabClassList (status) {
      let params = {
        is_open: status
      }
      getTagClassList(params).then(res => {
        if (res.code === 200) {
          this.productsData = res.data.categories
          // this.$message.success('新增标签分类成功')
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    getLabList (status) {
      let params = {
        is_open: status
      }
      getTagList(params, this.lab_category_id).then(res => {
        if (res.code === 200) {
          this.productsData2 = res.data.labels
          // this.$message.success('新增标签分类成功')
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    addLabClass () {
      let params = {
        name: '请输入类别',
        is_open: 1,
        style: '#6E4DE8',
        sort: this.productsData.length
      }
      addTagClass(params).then(res => {
        if (res.code === 200) {
          this.$message.success('新增标签分类成功')
          this.getLabClassList(0)
        //   this.getLabList(0)
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    addlab () {
      let params = {
        name: '请输入类别',
        label_category_id: this.lab_category_id,
        comment: '注解',
        is_open: 1,
        sort: this.productsData2.length
      }
      addTag(params).then(res => {
        if (res.code === 200) {
          this.$message.success('新增标签成功')
          this.getLabList(0)
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    pointlabList (id, index) {
      this.activeIndex = index
      this.lab_category_id = id
      this.getLabList(0)
    },
    eidtClass (open, id, name, color, msg) {
      if (this.canDo('pm.labelCategories.update')) {
        let params = {
          name: this.inputValue == '' ? name : this.inputValue,
          is_open: open,
          style: this.colorCode == '' ? color : this.colorCode
        }
        eidtTagClass(params, id).then(res => {
          if (res.code === 200) {
            this.inputVisible = -1
            this.getLabClassList(0)
            this.getLabList(0)
            this.$message.success(msg)
          }
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      }
    },
    changeMsg (status, scope, index) {
      let newData = scope
      newData.is_open = newData.is_open == 0 ? '1' : '0'
      this.check1 = status
      this.productsData[index] = newData
      this.eidtClass(status, scope.id, scope.name, scope.style, '修改标签状态成功')
    },
    changeMsg2 (status, scope, index) {
      let newData = scope
      newData.is_open = newData.is_open == 0 ? '1' : '0'
      this.check2 = status
      this.productsData2[index] = newData
      this.eidtlabs(status, scope.id, scope.name, '修改标签状态成功')
    },
    eidtlabs (open, id, name, msg) {
      if (this.canDo('pm.labels.update')) {
        let params = {
          label_category_id: this.lab_category_id,
          name: this.inputValue2 == '' ? name : this.inputValue2,
          is_open: open,
          comment: '注解'
        }
        eidtTag(params, id).then(res => {
          if (res.code === 200) {
            this.inputVisible2 = -1
            this.getLabList(0)
            this.getLabClassList(0)
            this.$message.success(msg)
          }
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      }
    },
    delThetag (id) {
      delTagClass(id).then(res => {
        if (res.code === 200) {
          this.$message.success('删除标签分类成功')
          this.getLabClassList(0)
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    delThelab (id) {
      delTag(id).then(res => {
        if (res.code === 200) {
          this.$message.success('删除标签成功')
          this.getLabList(0)
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    showInput (index, name) {
      this.inputValue = name
      this.inputVisible = index
    },
    showInput2 (index, name) {
      this.inputValue2 = name
      this.inputVisible2 = index
    },
    labclassAll () {
      let params = {
        is_open: 1
      }
      getlabclassAll(params).then(res => {
        if (res.code === 200) {
          this.productsData3 = res.data.categories
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    handleClose3 (removedTag) {
      const tags = this.tags.filter(tag => tag !== removedTag)
      this.tags = tags
    },
    selectLab (item) {
      // 判断tags中是否存在要添加的元素
      if (JSON.stringify(this.tags).indexOf(JSON.stringify(item)) == -1) {
        this.tags.push(item)
      } else {
        this.$message.error('该标签已存在')
      }
    },
    handleOk3 () {
      this.confirmLoading = true
      let sort = this.tags.map((item, index) => {
        return item.id
      })
      let params = { label_ids: sort }
      pasteTag(params, this.claim_id).then(data => {
        this.confirmLoading = false
        this.$message.success('贴标签成功')
        this.getclaimlist()
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
      this.dialogVisible9 = false
    },
    selectColor (objs, color) {
      this.colorCode = color
      this.eidtClass(objs.is_open, objs.id, objs.name, objs.color, '修改标签颜色成功')
    },
    handleChange (e, k) {
      k.select = false
      let param = {
          user_id:e
      }
        eidtProductPrincipal(param ,k.id).then(res => {
          if (res.code === 200) {
              this.$message.success('您已经修改了产品负责人')
              this.getclaimlist()
          }
      }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    handbutton (k) {
      if (k.policies.setPrincipal) {
          k.select = true
          getClaimPrincipall(k.id).then(res => {
              if (res.code === 200) {
                  this.options5 = res.data.users
              }
          })
      }
    },
    handleBlur (k) {
      k.select = false
    },
  }
}
</script>
<style lang="less" scoped>
.ok{
      text-align: right;
      padding: 20px 10px;
      width: 280px;
  }
/deep/.table-list .ant-table-tbody > tr > td {
    // padding: 0 30px 0 0;
}
.overflow-3{
    display: -webkit-box;
    overflow: hidden;
    white-space: normal !important;
    text-overflow: ellipsis;
    word-wrap: break-word;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    max-width: 190px;
    span{
        font-size: 12px !important;
        color: #666666 !important;
        word-break: break-all;
    }
}
.isFixed{
            position: fixed;
            top: 0px;
            z-index: 4;
            width: 100%;
        }

.tabslist {
  /deep/.ant-tabs-top-bar {
    background: #fff;
    margin: 0;
    padding: 0 10px;
  }
  /deep/.ant-tabs-nav-container {
    height: 54px !important;
    .anticon-apple {
      display: none;
    }
    .anticon-android {
      display: none;
    }
    .ant-tabs-tab {
      color: #666;
      font-size: 14px;
      font-weight: bold;
    }
    .ant-tabs-nav .ant-tabs-tab-active {
      color: #378eef;
    }

    .ant-tabs-bar {
      border-bottom: 1px solid #eee;
    }
    .ant-tabs-nav .ant-tabs-tab {
      padding: 17px 10px;
    }
    .shop-size {
      display: inline-block;
      width: 23px;
      height: 15px;
      background: #ff4a4a;
      border-radius: 7px;
      font-size: 10px;
      color: #fff;
      font-weight: 400;
      text-align: center;
      line-height: 12px;
      position: relative;
      top: -2px;
      left: 4px;
    }
  }
}

.table-list {
  .pull-down {
    width: 10px;
    height: 12px;
    display: inline-block;
    position: relative;
    span {
      display: block;
      font-size: 12px;
      cursor: pointer;
    }
    .down {
      position: absolute;
      top: -5px;
      left: 0px;
    }
    .up {
      position: absolute;
      top: 3px;
      left: 0px;
    }
  }
  .text-button img:nth-child(1) {
      width: 40px;
      height: 21px;
      position: relative;
      top: 1px;
      cursor: pointer;
  }
    .text-button img:nth-child(2) {
        width: 36px;
        height: 19px;
        cursor: pointer;
    }
  .text-p {
    color: #666666;
    font-size: 12px;
    // max-width: 128px;
  }
  .actived{
      background: red !important;
  }
  .text-p.active {
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
  }
  .text-p-blue {
    color: #378eef;
    cursor: pointer;
  }
  .pro_tips .rideo {
    display: inline-block;
    width: 6px;
    height: 6px;
    background: #ff4a4a;
    border-radius: 50%;
  }
  .pro_status_eidt {
    display: flex;
    align-items: center;
  }
  .pro_status .ico-color {
    margin-right: 4px;
    color: #ff4a4a;
  }
  .pro_operate {
    display: flex;
        span {
        display: inline-block;
        margin-right: 4px;
    }
        .icon {
        color: #378eef;
        font-size: 14px;
        margin-right: 10px;
        cursor: pointer;
    }
   .edit-icon .icon{
        color:#666;
        }
  }

  .pro_annex span,
  .pro_principal span {
    color: #378eef;
    font-size: 14px;
    cursor: pointer;

  }
  .pro_note span {
    color: #378eef;
    font-size: 14px;
  }

  .ant-table-wrapper {
    box-shadow: 0px 5px 15px 0px rgba(223, 226, 230, 0.8);
    border-radius: 5px;
    /*margin-bottom: 30px;*/
    background: #fff;
  }
  /*/deep/.ant-table-pagination {*/
  /*display: none;*/
  /*}*/
  /deep/.ant-table-body {
    margin: 0px 20px 30px 20px;
  }
  /deep/.ant-table-body tr:nth-child(odd) {
    background: #fff;
  }
  /deep/.ant-table-body tr:nth-child(even) {
    background: #f8f8f8;
  }
}
/deep/.ant-table-pagination {
  display: none;
}
.table-list /deep/ .ant-table-thead {
  height: 46px;
  background: #f8f8f8;
  border-radius: 5px;
}
.eidt-expend /deep/.expend{
    top:6px
}
// .table-list /deep/ .ant-table-thead th:nth-child(2){
//     width: 10%;
// }
// .table-list /deep/ .ant-table-thead th:nth-child(3){
//     width: 10%;
// }
// .table-list /deep/ .ant-table-thead th:nth-child(4){
//     width: 10%;
// }
// .table-list /deep/ .ant-table-thead th:nth-child(5){
//   width: 12%;
// }
// .table-list /deep/ .ant-table-thead th:nth-child(6){
//     width: 6%;
// }
// .table-list /deep/ .ant-table-thead th:nth-child(7){
//     width: 10%;
// }
// .table-list /deep/ .ant-table-thead th:nth-child(8){
//     width: 12%;
// }
// .table-list /deep/ .ant-table-thead th:nth-child(9){
//     width: 6%;
// }
.table-list /deep/ .ant-table-thead th:nth-child(11){
    width: 160px;
}


.table-eidt /deep/.ant-table-tbody {
  display: none;
}
.table-eidt /deep/ .ant-table-thead th {
  display: none;
}
.table-eidt /deep/ .ant-table-thead .ant-table-selection-column {
  display: block;

}
.table-eidt /deep/ .ant-table {
  float: left;
  // display: none;
}
.table-eidt /deep/.ant-table-placeholder {
  display: none;
}
.table-eidt /deep/ .ant-table-thead > tr > th {
  border-bottom: none;
  background: #fff !important;
}
.table-eidt /deep/ .ant-table-body {
  margin: 10px 0px 0px 0px;
}
.table-list /deep/ .ant-table-thead > tr > th {
  border-bottom: none;
//   background: #f8f8f8 !important;
}
.table-eidt /deep/ .ant-table-body {
  margin: 10px 0px 0px 0px;
}
.select-lengs {
    line-height: 32px;
    height: 32px;
    position: absolute;
    left: 89px;
    top: 16px;
    color: #bbb;
    font-size: 12px;
}
.select-lengs-eidt {
  left: 45px;
//   top: 27px;
}
.table-eidt /deep/ .ant-table-pagination {
  display: block;
}
.select-box {
  position: relative;
  background: #fff;
  padding: 30px 20px 0 20px;
}
.select-box .el-select {
  width: 120px;
  height: 32px;
  /deep/ .el-input__inner::placeholder {
    color: #666;
  }
  /deep/ .el-input__inner {
    border: 1px solid #ccc;
    height: 32px;
    line-height: 32px;
    font-size: 12px;
  }
  /deep/ .el-input__icon {
    line-height: 32px;
  }
}
.btn-right {
  position: absolute;
  right: 20px;
  top: 30px;
  display: flex;
  align-items: center;
  p {
    color: #378eef;
    font-size: 12px;
    margin-right: 20px;
    cursor: pointer;

    i {
      display: inline-block;
      margin-right: 4px;
      font-size: 12px;
      position: relative;
    }
  }
}
/deep/.ant-input {
  height: 32px;
}
.data-picker-box {
  width: 14%;
  display: inline-block;
  margin-right: 10px;
  .el-input__inner {
    width: 100%;
    height: 32px;
    line-height: 32px;
    padding: 0px 10px;
    border-color: #ccc;
    cursor: pointer;
  }
}
/deep/ .el-date-editor .el-range-separator {
  width: 9%;
  font-size: 12px;
}
.upload_box {
  display: flex;
  padding: 20px 0 30px 0;
  align-items: center;
  .selet-serch {
    font-size: 12px;
    color: #666666;
    margin-right: 4px;
  }
}
.del{
    font-size: 12px;
    cursor: pointer;
    position: relative;
    left:647px;
    top: -22px;
}
.popup_opinion_submit_file li {
  float: left;
  height: 30px;
  line-height: 28px;
  vertical-align: middle;
  box-sizing: border-box;
  color: #666;
  font-size: 12px;
  border: 1px solid #d5dae3;
  border-radius: 3px;
  padding: 0 10px 0 12px;
  cursor: default;
  margin-right: 16px;
  position: relative;
  background: #f8f8f8;
}
.popup_opinion_submit_file li b {
  display: inline-block;
  font-weight: 400;
  text-overflow: ellipsis;
  white-space: nowrap;
//   width: 145px;
  overflow: hidden;
}
.popup_opinion_submit_file li i {
  vertical-align: middle;
  font-size: 12px;
  display: block;
  float: right;
   margin-left: 10px;
  color: #999999;
  font-weight: 600;
  cursor: pointer;
}
.tip_button {
  max-width: 300px;
  display: flex;
  // box-shadow:0px 5px 15px 0px rgba(223,226,230,0.8);
  border-radius: 4px;
  flex-wrap: wrap;
}
.tip_button p {
  padding: 0 6px;
  height: 24px;
  line-height: 22px;
  background: rgba(38, 163, 224, 0.2);
  color: #fff;
  font-size: 12px;
    margin:0px 10px 10px 0px;
  border-radius: 3px;
}

/deep/.el-popover {
  border-radius: 4px;
}

/deep/ .el-dialog__header {
  padding: 12px 20px;
  border-bottom: 1px solid #eeeeee;
}
.modal-box /deep/ .el-dialog__body {
  padding: 20px 20px 0 20px;
}
.modal-box /deep/ .el-dialog__title {
  color: #666;
  font-size: 16px;
  font-weight: bold;
}
/deep/ .el-dialog__headerbtn .el-dialog__close {
  color: #999;
  font-size: 20px;
}
/deep/ .el-dialog__headerbtn {
  top: 14px;
}
.radio_box p {
  color: #666;
  font-size: 12px;
  padding-bottom: 15px;
  span {
    color: #ff4a4a;
    display: inline-block;
    padding-right: 6px;
  }
}
.ant-table-tbody > tr:hover:not(.ant-table-expanded-row) > td {
  &:nth-child(7) p{
    animation: disappear2 3s;
    animation-fill-mode:forwards
  }
   &:nth-child(8) p:nth-child(1){
    animation: disappear2 3s;
    animation-fill-mode:forwards
  }
   &:nth-child(10) div{
    animation: disappear2 3s;
    animation-fill-mode:forwards
  }
}
.radio_box_button {
  padding-bottom: 10px;
}
.modal-box /deep/.el-dialog__footer {
  padding: 20px;
}
.modal-box-two /deep/ .el-dialog__footer {
  text-align: center;
}
.tip-text p {
  color: #666;
  font-size: 16px;
  text-align: center;
}
.text-text-1 span {
  color: #ff4a4a;
  display: inline-block;
  padding-left: 4px;
}
.tip-text .text-text-2 {
  margin-top: 12px;
  color: #f88d49;
  font-size: 12px;
}
/deep/ .el-button {
  padding: 9px 20px;
}

.dropdown-box.el-dropdown-menu {
  background: rgba(255, 255, 255, 1);
  border: 1px solid rgba(238, 238, 238, 1);
  box-shadow: 0px 5px 15px 0px rgba(223, 226, 230, 0.8);
  border-radius: 4px;
  padding: 10px;
}
.download-list {
  /*padding: 10px;*/
}
.download-list > p {
  color: #666;
  font-size: 12px;
  margin-bottom: 10px;
}
.download-list .el-checkbox {
  display: block;
  margin-bottom: 10px;
}
.download-list .el-checkbox span {
  display: inline-block;
  margin-right: 3px;
}

/deep/.el-select-dropdown {
  right: 30px;
}
/deep/.el-select-eidt {
  margin-top: 0px !important;
}
.eidt-model3 /deep/.ant-modal-body {
  padding: 20px;
}


/deep/ .ant-modal-footer{
    border-color:red
}
/deep/.ant-select-selection--single {
    height: 32px;
}
/deep/ .ant-form-item-label{
    line-height: 24px;
 }
/deep/ .ant-form-item{
    margin-bottom: 0;
}
.eidt-model /deep/ .ant-modal-footer{
    padding:20px;
}
</style>

 <style>
     .ant-checkbox + span{
         font-size: 12px;
     }
.el-select-eidt.el-select-dropdown,
.el-select-eidt-02.el-select-dropdown {
  margin-top: 0px !important;
  top: 258px !important;
  box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.1);
}
.el-select-eidt .popper__arrow,
.el-select-eidt-02 .popper__arrow {
  display: none;
}
.el-select-eidt .el-select-dropdown__item,
.el-select-eidt-02 .el-select-dropdown__item {
  color: #666;
  font-size: 14px;
}
.el-select-eidt .el-select-dropdown__item.hover,
.el-select-eidt .el-select-dropdown__item:hover {
  background-color: #f8f8f8;
}
.el-select-eidt-02 .el-select-dropdown__item.hover,
.el-select-eidt-02 .el-select-dropdown__item:hover {
  background-color: #f8f8f8;
}
.eidt-text {
  display: inline-block;
  padding-left: 10px;
  bottom: 1px;
   color:#666666;
}
.eidt-tips p {
  position: relative;
  color: #f88d49;
  font-size: 12px;
  background: #fff2ea;
  border: 1px solid #ffd8bf;
  border-radius: 5px;
  padding: 8px 8px;
  padding-right: 16px;
  margin-bottom: 15px;
}
.eidt-tips .down {
  cursor: pointer;
  display: inline-block;
  right: 0;
  position: absolute;
  top: 33%;
  right: 6px;
}
.follower-css {
  padding: 8px 0 8px 0px;
}
.follower-css-statas {
  padding: 8px 0 8px 0px;
}
.follower-css:hover {
    background: rgba(187,187,187,0.2);
  cursor: pointer;
}
.add{
    position: relative;
    left: 623px;
    top: 23px;
    cursor: pointer;
    z-index: 100;
    color: rgba(55, 142, 239, 1);
}

.addProduct {
  margin-left: 90px;
  color:#378EEF;
  cursor: pointer;
}
/* 标签css */
.lab_content {
  display: flex;
  max-height: 425px;
  overflow-y: scroll;
}
.lab_content ul {
  min-height: 208px;
}
.lab_content ul:nth-child(1){
    border-right: 1px solid #eee;
}
.eidt_modal .ant-modal-body {
  padding: 0 ;
}

.lab_content_header {
  display: flex;
  justify-content: space-between;
  padding: 14px 20px;
  border-bottom: 1px solid #eeeeee;
}
.lab_content_header p {
  color: #666;
  font-size: 14px;
}
.lab_content .drag-icon {
  font-size: 12px;
  color: #c6c6c6;
  margin-right: 6px;
}
.lab_content ul li {
  display: flex;
  justify-content: space-between;
  padding: 4px 20px;
}
.lab_content_left,
.lab_content_right {
  display: flex;
  align-items: center;
}
.color-button-box {
  width: 19px;
  height: 19px;
  position: relative;
  overflow: hidden;
  margin-right: 10px;
}
.color-button {
  width: 19px;
  height: 19px;
  border-radius: 50%;
  background: #6e4de8;
  margin-right: 10px;
  opacity: 0.5;
}
.color-button-min {
  background: #6e4de8;
  border-radius: 50%;
  width: 11px;
  height: 11px;
  position: absolute;
  right: 0;
  left: 0;
  top: 0;
  bottom: 0;
  margin: auto;
}
/* .eidt-switch{
  margin-right:10px;
}
.lab_content_right .ant-switch-checked{
  background: #0AA658;
}
.lab_content_right .ant-switch{
      height: 16px;
    min-width: 28px;
    line-height: 16px;
}
.lab_content_right .ant-switch:after{
    width: 13px;
    height: 13px;
    top: 0px;
} */
.showActive {
  display: none;
}
.input-none {
  display: none;
}
.showActive2 {
  display: block;
}
.lab_content_all {
  padding: 12px 20px 0px 20px;
    max-height: 576px;
    overflow-y: scroll;
}
.labmains {
  margin-bottom: 14px;
}
.labmains h3 {
  color: #666666;
  font-size: 14px;
  margin-bottom: 8px;
  margin-top: 15px;
    font-weight: bold;
}
.pointLab .ant-tag {
  line-height: 28px;
  height: 30px;
  padding: 0 8px;
  border-radius: 3px;
}
.colorLi {
  display: block;
  width: 14px;
  height: 14px;
  /* background:rgba(55,142,239,1); */
  border: 1px solid rgba(255, 255, 255, 1);
  border-radius: 50%;
}
.el-dropdown-menu .el-dropdown-menu__item {
  /* padding: 7px 42px; */
  padding: 0;
}

.lab-select-arr {
  padding: 10px 0 10px 0;
  border-bottom: 1px solid #eee;
}
.lab-select-arr .ant-tag {
  color: #fff;
  font-size: 12px;
  line-height: 28px;
  height: 30px;
  border-radius: 3px;
  margin-bottom: 10px;
  position: relative;
}
.lab-select-arr .ant-tag::after {
  display: block;
  content: "";
  width: 1px;
  height: 30px;
  background: rgba(255, 255, 255, 1);
  opacity: 0.3;
  position: absolute;
  right: 24px;
  top: -1px;
}
.lab-select-arr .ant-tag .anticon-close {
  color: #fff;
  margin-left: 12px;
}
.ant-btn {
  padding: 0 10px;
}
.eidt-form-width .ant-table-tbody > tr > td {
  width: 25%;
}
.eidt-model4 .ant-modal-body {
  padding: 14px 20px 0 20px;
}
.eidt-model4 .ant-form-item {
  margin-bottom: 13px;
}
.eidt-model4 .ant-modal-footer {
  border-top: none;
}
     .eidt-model3 .ant-modal-body {
         padding: 0 20px 10px 20px;
     }
     .eidt-model3 .ant-modal-footer{
         display: none;
     }
     .eidt-model3 .ant-table-thead > tr > th{
         background: none;
         border-bottom:1px solid #eee;
     }
     .eidt-model3 .ant-table-thead > tr > th span{
         /* color:#bbb; */
     }
.labmain-box {
  min-height: 452px;
  height: 452px;
  overflow-y: auto;
}
 .select-box /deep/ .ant-input {
      height: 32px;
  }
  .eidt-model4 /deep/.ant-modal-footer{
    padding:2px 20px 20px 20px;
   }
     .eidt_modal /deep/ .ant-modal-footer{
         padding:20px;
         border-top: none !important;
     }

     /deep/ .ant-modal-close-icon{
        font-size: 16px;
        top: -4px;
        position: relative;
     }
     .eidt-pir{
         width: 120px;
         height: 32px;
         line-height: 32px;
     }
     .eidt-pir:hover{
        background: rgba(187,187,187,0.2);
     }

</style>
<style>
.ant-table-tbody > tr > td.ant-table-selection-column {
  min-width: 0px;
  width: auto;
  padding: 12px 10px 12px 0 !important;
  text-align: center;
}
.table-eidt .ant-table-thead .ant-table-selection-column{
    width: auto !important;
}
.ant-modal-header {
  background: #f8f8f8;
}
.lab_content .eidt-dra-list li:hover{
background: #e6f7ff;
}
.eidt-dra-list li:nth-child(odd) {
  background: #fff;
}
.eidt-dra-list li:nth-child(even) {
  background: #f8f8f8;
}
.ant-table-thead > tr > th .ant-table-column-sorter{
  left: 50px !important;
}
.downLoad{
  margin-right: 10px;
    font-size:12px;
}
.download-list .showFile .fileList{
      margin-bottom: 6px;
}

.ant-table-tbody>tr>td.ant-table-column-sort {
    background: none;
}
.modal-box-tree  .ant-modal-header{
    padding: 12.5px 20px;
}
.modal-box-tree .ant-modal-footer{
    padding: 20px !important;
    border-top:none;
}
.modal-box-tree .ant-form-item {
    margin-bottom: -8px;
}
.modal-box-tree .ant-modal-body{
    padding: 16px 20px 5px 20px;
}
.modal-box-tree .ant-select-selection--single{
    height: 32px;
}
.modal-box-four .el-form-item__content{
    line-height: normal;
}
.modal-box-four .radio_box p{
    padding-bottom: 10px;
}
.eidt-model4 .radio_box p{
    padding-bottom: 8px;
}
</style>
