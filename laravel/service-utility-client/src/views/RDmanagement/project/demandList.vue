<template>
  <div>
      <!-- Task信息弹框 -->
    <allTaskInfo  ref="allTaskInfo" :id="demand_id"></allTaskInfo>
    <div class="top-select">
      <a-select showSearch
                placeholder="请选择项目"
                style="width:240px"
                class="select-btn"
                @search="serchFocus"
                :filterOption="false"
                v-model="searchData.source_project_id"
                @popupScroll="popupScroll">
        <a-select-option v-for="item in projectsData.projectList"
                         :key="item.id">
        <img src="@/assets/images/daily.png" v-if="item.type == 0">
        <img src="@/assets/images/key.png" v-if="item.type == 1">
        {{item.name}}
          </a-select-option>
      </a-select>
    </div>
     <a-modal title="需求转移"
                   :maskClosable="false"
                   class="modal-pms"
                   :confirmLoading="btnLoad"
                   v-model="transferShow"
                   @cancel="cancel(3)"
                   @ok="ok(3)"
                   width="380px">
                   <p style="margin-bottom:20px;color:#f88d49" v-if="receiver_id"> * 即将转移{{selectedRowKeys.length}}个需求至{{receiver_name}},请注意确认</p>
                   <div style="display:flex">
                       <div>
                           <p style="margin-bottom:10px">需求转移账号: </p>
                            <a-input
                            disabled
                            v-model="transferPeople"
                            style="width:150px"/>
                       </div>
                        <div style="flex:1;text-align: center;position: relative;top:34px">
                             <span class="iconfont fz12" style="color:#BBBBBB">&#xe6fb;</span>
                        </div>
                        <div>
                            <p style="margin-bottom:10px">需求接收账号: </p>
                            <peopleSelect @getValue2="getTransferID" :valueData="receiver_id" style="width:150px" ref="peopleSelect"></peopleSelect>
                        </div>
                   </div>
        </a-modal>
     <!-- 立项审核弹框 -->
    <div class="modal-box">
      <el-dialog title="立项审核"
                 :close-on-click-modal="false"
                 :visible.sync="dialogVisible6"
                 width="380px">
        <div class="radio_box">
          <el-form style=" margin-bottom: 20px;">
            <p><span>*</span> 审核结果:</p>
            <el-radio v-model="radio"
                      :label="1">通过</el-radio>
            <el-radio v-model="radio"
                      :label="0">驳回</el-radio>
          </el-form>
          <el-form :model="{textarea}">
            <p>备注:</p>
            <el-form-item>
              <el-input type="textarea"
                        :autosize="{ minRows: 3, maxRows: 3}"
                        placeholder="请输入备注"
                        v-model="textarea"
                        resize="none">
              </el-input>
            </el-form-item>
          </el-form>
        </div>
        <span slot="footer"
              class="dialog-footer">
          <el-button @click="dialogVisible6 = false,textarea=''">取 消</el-button>
          <el-button type="primary"
                     :loading="btnLoad"
                     @click="verifyDemand()">确 定</el-button>
        </span>
      </el-dialog>

    </div>
    <!-- 暂停弹框 -->
    <div class="modal-box">
      <el-dialog title="暂停"
                 :close-on-click-modal="false"
                 :visible.sync="dialogVisible"
                 width="380px">
        <div class="radio_box">
          <el-form :model="{textarea}"
                   ref="stopDemandform">
            <p><span>*</span>原因:</p>
            <el-form-item :rules="[{ required: true, message: '原因不能为空'} ]"
                          prop="textarea">
              <el-input type="textarea"
                        :autosize="{ minRows: 3, maxRows: 3}"
                        placeholder="请输入暂停原因"
                        v-model="textarea"
                        resize="none">
              </el-input>
            </el-form-item>
          </el-form>
        </div>
        <span slot="footer"
              class="dialog-footer">
          <el-button @click="dialogVisible = false, $refs['stopDemandform'].resetFields(),textarea=''">取 消</el-button>
          <el-button type="primary"
                    :loading="btnLoad"
                     @click="stopDemand('stopDemandform')">确 定</el-button>
        </span>
      </el-dialog>

    </div>
    <!-- 撤销弹框 -->
    <div class="modal-box">
      <el-dialog title="撤销"
                :close-on-click-modal="false"
                 :visible.sync="dialogVisible2"
                 width="380px">
        <div class="radio_box">
          <el-form :model="{textarea}"
                   ref="revokeDemandform">
            <p><span>*</span>原因:</p>
            <el-form-item :rules="[{ required: true, message: '原因不能为空'} ]"
                          prop="textarea">
              <el-input type="textarea"
                        :autosize="{ minRows: 3, maxRows: 3}"
                        placeholder="请输入撤销原因"
                        v-model="textarea"
                        resize="none">
              </el-input>
            </el-form-item>
          </el-form>
        </div>
        <span slot="footer"
              class="dialog-footer">
          <el-button @click="dialogVisible2 = false, $refs['revokeDemandform'].resetFields(),textarea=''">取 消</el-button>
          <el-button type="primary"
                    :loading="btnLoad"
                     @click="revokeDemand('revokeDemandform')">确 定</el-button>
        </span>
      </el-dialog>
    </div>
    <!-- 验收完成弹框 -->
    <div class="modal-box">
      <el-dialog title="验收完成"
                 :close-on-click-modal="false"
                 :visible.sync="dialogVisible3"
                 width="380px">
        <div class="radio_box">
          <p style="color:#F88D49">* 确认验收完成后，状态将不可修改！</p>
          <p>备注:</p>
          <el-input type="textarea"
                    :autosize="{ minRows: 3, maxRows: 3}"
                    placeholder="请输入请输入备注"
                    v-model="textarea"
                    resize="none">

          </el-input>
        </div>
        <span slot="footer"
              class="dialog-footer">
          <el-button @click="dialogVisible3 = false,textarea=''">取 消</el-button>
          <el-button type="primary"
                        :loading="btnLoad"
                     @click="completeDemand">确 定</el-button>
        </span>
      </el-dialog>

    </div>
    <!-- 更新测试提示框 -->
    <div class="modal-box">
      <el-dialog title="提示"
                 :close-on-click-modal="false"
                 :visible.sync="dialogVisible4"
                 width="380px">
        <div class="radio_box">
          <div class="contxt">确定该需求可以 <span style="color:#3CCDA7">开始测试</span>?</div>
        </div>
        <div slot="footer"
             class="dialog-footer tac">
          <el-button type="primary"
                    :loading="btnLoad"
                     @click="testDemand">确 定</el-button>
          <el-button @click="dialogVisible4 = false">取 消</el-button>
        </div>
      </el-dialog>
    </div>
    <!-- 操作记录弹框 -->
    <div class="tabslist">
      <a-tabs class="tabs_bg"
              v-model="searchData.tabs">
        <a-tab-pane :key="-1">
          <span slot="tab">
            All
          </span>
        </a-tab-pane>
        <a-tab-pane :key="0">
          <span slot="tab" title="需要负责人审核的需求">
            申请立项
            <a-badge :count="remind.status0+remind.status1" v-if="remind.status0"/>
          </span>
        </a-tab-pane>
        <a-tab-pane :key="2">
          <span slot="tab" title="需要项目负责人确认和推送的需求">
            待推送
            <a-badge :count="remind.status2" />
          </span>
        </a-tab-pane>
        <a-tab-pane :key="3">
          <span slot="tab" title="审核通过且研发任务均没指定跟进人的需求">
            待指派
            <a-badge :count="remind.status3" />
          </span>
        </a-tab-pane>
        <a-tab-pane :key="4">
          <span slot="tab" title="已有研发任务指定了跟进人的需求">
            未处理
            <a-badge :count="remind.status4" />
          </span>
        </a-tab-pane>
        <a-tab-pane :key="5">
          <span slot="tab" title="研发任务已经开始的需求">
            研发中
            <a-badge :count="remind.status5" />
          </span>
        </a-tab-pane>
        <a-tab-pane :key="6">
          <span slot="tab" title="研发任务已完成未发布测试站的需求">
            已提交
            <a-badge :count="remind.status6" />
          </span>
        </a-tab-pane>
        <a-tab-pane :key="7">
          <span slot="tab" title="已发布测试站还未开始测试的需求">
            待测试
            <a-badge :count="remind.status7" />
          </span>
        </a-tab-pane>
        <a-tab-pane :key="8">
          <span slot="tab" title="测试任务已开始的需求">
            测试中
            <a-badge :count="remind.status8" />
          </span>
        </a-tab-pane>
        <a-tab-pane :key="9">
          <span slot="tab" title="已上线正式站的需求">
            已完成
          </span>
        </a-tab-pane>
        <a-tab-pane :key="10">
          <span slot="tab">
            已暂停
            <a-badge :count="remind.status10" />
          </span>
        </a-tab-pane>
        <a-tab-pane :key="11">
          <span slot="tab">
            已撤销
          </span>
        </a-tab-pane>
      </a-tabs>
      <!-- 选择筛选 -->
      <div class="select-box">
        <!--
        <a-select placeholder="项目负责人"
                  labelInValue
                  showSearch
                  @search="searchUser"
                  optionFilterProp="children"
                  v-model="searchData.projectPrincipal"
                  style="width: 7%;margin-right: 10px;">
          <a-select-option v-for="item in options"
                           :key="item.id">{{item.name}}</a-select-option>
        </a-select>
        -->
        <allPersonSelect :autoFocus="false"
                         @getSelectValue="handleSearch"
                         :selectValue="projectPrincipalID"
                         :searchData="projectPrincipalArr"
                         ref="projectPrincipalRef"
                         placeholder="项目负责人(请输入英文名搜索)"
                         style="width: 7%;margin-right: 10px;">
        </allPersonSelect>

        <!-- <a-select placeholder="产品负责人"
                  labelInValue
                  showSearch
                  optionFilterProp="children"
                  v-model="searchData.productPrincipal"
                  style="width: 7%;margin-right: 10px;">
          <a-select-option v-for="item in options2"
                           :key="item.id">{{item.name}}</a-select-option>
        </a-select> -->
        <allPersonSelect :autoFocus="false"
                         @getSelectValue="handleSearch1"
                         :selectValue="productPrincipalID"
                         :searchData="productPrincipalArr"
                         ref="productPrincipalRef"
                         placeholder="产品负责人(请输入英文名搜索)"
                         style="width: 7%;margin-right: 10px;">
        </allPersonSelect>

        <a-cascader
                        style="width: 7%;margin-right: 10px;"
                        changeOnSelect
                        :allowClear="false"
                        :fieldNames="fields"
                        v-model="searchData.productCategory"
                        :loadData="loadData"
                        :options="products"
                        placeholder="产品类别"
                    />

        <!--<a-select placeholder="发布人员"
                  labelInValue
                  showSearch
                  optionFilterProp="children"
                  v-model="searchData.demandPublisher"
                  style="width: 7%;margin-right: 10px;">
          <a-select-option v-for="item in options3"
                           :key="item.id">{{item.name}}</a-select-option>
        </a-select> -->
        <allPersonSelect :autoFocus="false"
                         @getSelectValue="handleSearch4"
                         :selectValue="demandPublisherID"
                         :searchData="demandPublisherArr"
                         ref="demandPublisherRef"
                         placeholder="发布人员(请输入英文名搜索)"
                         style="width: 7%;margin-right: 10px;">
        </allPersonSelect>

        <a-select placeholder="优先级"
                  style="width: 7%;margin-right: 10px;"
                  v-model="searchData.priority">
                <a-select-option :value="1"><span class="button_box_text"> 1</span><span class="after" style="color:#FF4A4A;float:right">高</span></a-select-option>
                <a-select-option :value="2"><span class="button_box_text button_box_color2"> 2</span></a-select-option>
                <a-select-option :value="3"><span class="button_box_text button_box_color3"> 3</span></a-select-option>
                <a-select-option :value="4"><span class="button_box_text button_box_color4"> 4</span></a-select-option>
                <a-select-option :value="5"><span class="button_box_text button_box_color5"> 5</span><span class="after" style="color:#BBBBBB;float:right">低</span></a-select-option>
        </a-select>

       <a-range-picker
                    style="width:14%;margin-right: 10px;"
                    v-model="searchData.created_at"
                    :allowClear="false"
                    format="YYYY/MM/DD"
                    >
                    <span class="iconfont" slot="suffixIcon" style="font-size:12px;margin-top: -6px;">&#xe659;</span>
        </a-range-picker>
        <a-input-search placeholder="名称/简述/编号"
                        style="width: 14%;position:relative;top: 0px;"
                        v-model="searchMsg"
                        @search="onSearch" />
         <span style="margin-left:10px;color: #378eef">
            <mySearch @search="moreSearch" top="335px" ref="search"></mySearch>
        </span>
        <div class="upload_box">
          <div class="popup_opinion_submit_box after">
            <ul class="popup_opinion_submit_file">
              <span>筛选：</span>
              <li v-if="searchData.projectPrincipal"><b>项目负责人：{{searchData.projectPrincipal.label}}</b>
                <i class="icon iconfont"
                   @click="reset(0)">&#xe631;</i>
              </li>
              <li v-if="searchData.productPrincipal"><b>产品负责人：{{searchData.productPrincipal.label}}</b>
                <i class="icon iconfont"
                   @click="reset(1)">&#xe631;</i>
              </li>
              <li v-if="searchData.created_at"><b>时间：{{ searchData.created_at[0].format('YYYY/MM/DD') + ' 至 ' + searchData.created_at[1].format('YYYY/MM/DD')}}</b>
                <i class="icon iconfont"
                   @click="reset(2)">&#xe631;</i>
              </li>
              <li v-if="searchData.priority"><b>优先级：{{searchData.priority}}</b>
                <i class="icon iconfont"
                   @click="reset(3)">&#xe631;</i>
              </li>
              <li v-if="searchData.demandPublisher"><b>发布人：{{searchData.demandPublisher.label}}</b>
                <i class="icon iconfont"
                   @click="reset(4)">&#xe631;</i>
              </li>
               <li v-if="searchData.productCategory&&searchData.productCategory.length>0"><b>产品类别：{{label}}</b>
                <i class="icon iconfont"
                   @click="reset(5)">&#xe631;</i>
              </li>
               <li v-if="mySearch"><b>高级筛选</b>
                <i class="icon iconfont"
                   @click="reset(6)">&#xe631;</i>
              </li>
            </ul>

          </div>
        </div>
            <!-- 操作记录弹框 -->
        <div class="modal-box">
            <el-dialog title="状态变动记录"
                        :visible.sync="dialogVisible5"
                        width="700px">
                <div class="radio_box"
                    style="padding-bottom: 10px;margin-top: -20px;">
                <a-table :dataSource="data2"
                        :columns="columns2"
                        :pagination="false"
                        :rowKey="(record, index) => index">
                    <div slot="status" slot-scope="status,record">
                        <span style="color:#FF4A4A;" v-if="record.status=='待审核'">{{record.status}}</span>
                        <span style="color:#FF4A4A;" v-if="record.status=='待推送'">{{record.status}}</span>
                        <span style="color:#FF4A4A;" v-if="record.status=='待指派'">{{record.status}}</span>
                        <span style="color:#FF4A4A;" v-if="record.status=='未处理'">{{record.status}}</span>
                        <span style="color:#FEBC2E;" v-if="record.status=='研发中'">{{record.status}}</span>
                        <span style="color:#FEBC2E;" v-if="record.status=='已提交'">{{record.status}}</span>
                        <span style="color:#FEBC2E;" v-if="record.status=='待测试'">{{record.status}}</span>
                        <span style="color:#FEBC2E;" v-if="record.status=='测试中'">{{record.status}}</span>
                        <span style="color:#FEBC2E;" v-if="record.status=='已暂停'">{{record.status}}</span>
                        <span style="color:#3DCCA6;" v-if="record.status=='已完成'">{{record.status}}</span>
                        <span style="color:#BBBBBB;" v-if="record.status=='审核驳回'">{{record.status}}</span>
                        <span style="color:#BBBBBB;" v-if="record.status=='已撤销'">{{record.status}}</span>
                    </div>
                </a-table>
                </div>
            </el-dialog>
        </div>

    <!-- 推送弹框 -->
    <div class="modal-box">
        <el-dialog title="提示"
                    :close-on-click-modal="false"
                    :visible.sync="dialogVisible_1"
                    width="380px">
        <div class="radio_box">
            <p style="text-align: center;padding: 20px;font-size: 16px;">确定将需求 <span style="color:#3DCCA6">推送</span> 给后续研发环节？</p>
        </div>
        <div slot="footer"
                class="dialog_footer">
            <el-button type="primary"
                        :loading="btnLoad"
                        @click="ok(1)">确 定</el-button>
            <el-button @click="dialogVisible_1 = false">取 消</el-button>
        </div>
        </el-dialog>

    </div>

    <!-- 一键推送弹框 -->
    <div class="modal-box">
        <el-dialog title="提示"
                :close-on-click-modal="false"
                    :visible.sync="dialogVisible2_1"
                    width="380px">
        <div class="radio_box">
            <p style="text-align: center;padding: 20px;font-size: 16px;">确定将需求 <span style="color:#3DCCA6">推送</span> 给后续研发环节？</p>
        </div>
        <div slot="footer"
                class="dialog_footer">
            <el-button type="primary"
                        :loading="btnLoad"
                        @click="ok(2)">确 定</el-button>
            <el-button @click="dialogVisible2_1 = false">取 消</el-button>
        </div>
        </el-dialog>

    </div>

    <!-- 发布需求 -->
    <div class="btn-right">
            <a-popover v-model="visible" trigger="click" placement="bottomLeft">
                <div slot="content" >
                    <div style="padding:10px 10px 0">
                          <a-radio-group name="radioGroup" v-model="excelRadio">
                            <a-radio :value="1">
                            需求信息表
                            </a-radio>
                            <a-radio :value="2" v-if="canDo('pm.excel.assessment.analysis')">
                            考核统计表
                            </a-radio>
                        </a-radio-group>
                         <a-form-model
                            :model="kpi"
                            :rules="rules"
                            ref="ruleForm">
                            <div v-if="excelRadio===2">
                                <div style="margin-top:20px">
                                <a-form-model-item prop="kpi_date">
                                    <a-range-picker
                                    v-model="kpi.kpi_date"
                                    format="YYYY/MM/DD"
                                    >
                                        <span slot="suffixIcon" class="iconfont" style="font-size:12px;top: 16px;">&#xe659;</span>
                                    </a-range-picker>
                                </a-form-model-item>
                                </div>
                                <div style="margin-top:20px">
                                    <!-- <a-select placeholder="所有人员"
                                        v-model="kpi.kpi_people"
                                        mode="multiple"
                                        showSearch
                                        optionFilterProp="children"
                                        style="width: 100%"
                                        >
                                        <a-select-option v-for="item in options_kpi"
                                                    :key="item.id">{{item.name}}</a-select-option>
                                    </a-select> -->
                                    <allPersonSelectMultiple :autoFocus="false"
                                                             @getSelectValue="modalHandle"
                                                             ref="modalHandleRef"
                                                             placeholder="所有成员(请输入英文名搜索)"
                                                             style="width: 100%;">
                                    </allPersonSelectMultiple>
                                </div>
                            </div>
                         </a-form-model>
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
                v-if="canDo('pm.demand.create')"
                @click="releaseDemand">
        <a-icon type="plus" />发布需求</a-button>
    </div>

      </div>

      <div class="table-list">
        <a-table :rowSelection="{selectedRowKeys: selectedRowKeys, onChange: onSelectChange}"
                 :rowKey="(record, index) => record.id"
                 :columns="columns"
                 :scroll="{ x: 1300 }"
                 :loading="loading"
                 :pagination="pagination1"
                 :dataSource="data">
          <div class="public_message"
               slot="customTitle2">P级别
            <div class="pull-down">
              <span class="icon iconfont down">&#xe607;</span>
              <span class="icon iconfont up">&#xe605;</span>
            </div>

          </div>
          <div slot="buttons"
               slot-scope="buttons,record"
               class="button_box">
            <span class="button_box_text"
                  v-if="buttons===1"
                  @click="handbutton(record)">{{buttons}}</span>
            <span class="button_box_text button_box_color2"
                  v-if="buttons===2"
                  @click="handbutton(record)">{{buttons}}</span>
            <span class="button_box_text button_box_color3"
                  v-if="buttons===3"
                  @click="handbutton(record)">{{buttons}}</span>
            <span class="button_box_text button_box_color4"
                  v-if="buttons===4"
                  @click="handbutton(record)">{{buttons}}</span>
            <span class="button_box_text button_box_color5"
                  v-if="buttons===5"
                  @click="handbutton(record)">{{buttons}}</span>
            <a-select style="width: 80px"
                      :value="buttons"
                      autoFocus
                      @focus="handleFocus"
                      @blur="handleBlur(record)"
                      @change="handleChange($event,record)"
                      :defaultOpen="true"
                      v-if="record.select">
                 <a-select-option :value="1"><span class="button_box_text"> 1</span><span class="after" style="color:#FF4A4A;float:right">高</span></a-select-option>
                <a-select-option :value="2"><span class="button_box_text button_box_color2"> 2</span></a-select-option>
                <a-select-option :value="3"><span class="button_box_text button_box_color3"> 3</span></a-select-option>
                <a-select-option :value="4"><span class="button_box_text button_box_color4"> 4</span></a-select-option>
                <a-select-option :value="5"><span class="button_box_text button_box_color5"> 5</span><span class="after" style="color:#BBBBBB;float:right">低</span></a-select-option>
            </a-select>
             <span style="cursor: pointer;" v-if="!buttons">--</span>
          </div>

          <!-- <div class="public_message"
               slot="customTitle"> 发布信息
            <div class="pull-down">
              <span class="icon iconfont down">&#xe607;</span>
              <span class="icon iconfont up">&#xe605;</span>
            </div>
          </div> -->
          <div slot="messages"
               slot-scope="messages,record"
               class="pro_status">
            <p class="text-p">{{messages}}</p>
            <p class="text-p">{{record.promulgator_name}}</p>
            <p class="text-p">{{record.created_at}}</p>
          </div>
          <div slot="address"
               slot-scope="address,record"
               class="pro_status">
            <p v-if="address"
               class="text-p text-p-blue">
                <router-link :to="{ name: 'proDetails', query: { id: record.source_project_id }}" target="_blank" class="text-p-overflow" :title="address" style="max-width:200px">  {{address}}</router-link>
            </p>
            <p v-else>--</p>
          </div>
          <div slot="project_principal_name"
               slot-scope="name">
            <p v-if="name"
               class="text-p">
              {{name}}
            </p>
            <p v-else>--</p>
          </div>
          <div slot="tips"
               slot-scope="title,record"
               class="pro_tips">
            <p class="text-p text-p-blue text-p-flex">
              <span class="rideo"
                    v-if="record.is_updated &&record.status_desc!=='已完成' && record.status_desc!=='已驳回' && record.status_desc!=='已撤销'"></span>
                <router-link :to="{ name: 'demandDetails', query: { id: record.id }}" target="_blank" class="text-p-overflow" :title="title"> {{title}}</router-link>
              <div v-if="(record.remaining_days || record.remaining_days===0)&&record.status_desc!=='已完成' && record.status_desc!=='已驳回' && record.status_desc!=='已撤销'">
                <span style="color:rgb(242, 141, 73);" v-if="record.remaining_days>0 || record.remaining_days==0">{{record.expiration_date}} (还剩{{record.remaining_days}}天)</span>
                 <span style="color:#FF4A4A;" v-if="record.remaining_days<0">{{record.expiration_date}} (超时{{Math.abs(record.remaining_days)}}天)</span>
              </div>
              <div v-else>
                 <span style="color:#999;">{{record.expiration_date}}</span>
             </div>
             <div>
                                        <span class="version-tag-1" v-if="record.stress_test">压测</span>
                                        <span  v-for="(k,index) in record.task_versions" :key="index">
                                            <span  v-if="k.release_type===2">
                                                <a-popover placement="bottom" >
                                                    <template slot="content">
                                                        <div class="pms-publishing-info">
                                                            <h3>版本信息</h3>
                                                            <div class="details version-details">
                                                                    <div class="marginB10" style="margin-bottom:0">
                                                                        <span class="left-details" style="width:51px">开发说明:</span>
                                                                        <span class="right-details">{{k.release_comment ? k.release_comment : '--'}}</span>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </template>
                                                    <span class="version-tag-1 cup">无需发版</span>
                                                </a-popover>
                                            </span>
                                            <span v-else-if="k.release_type===1">
                                                <a-popover placement="bottom" >
                                                    <template slot="content">
                                                        <div class="pms-publishing-info">
                                                            <h3>版本信息</h3>
                                                            <div class="details version-details">
                                                                    <div class="marginB10">
                                                                        <span class="left-details" style="width:51px">Hotfix:</span>
                                                                        <span class="right-details">热修复上线代码</span>
                                                                    </div>
                                                                    <div class="marginB10" style="margin-bottom:0">
                                                                        <span class="left-details" style="width:51px">开发说明:</span>
                                                                        <span class="right-details">{{k.release_comment ? k.release_comment : '--'}}</span>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </template>
                                                    <span  class="version-tag-1 cup"> Hotfix</span>
                                                </a-popover>
                                            </span>
                                            <span  v-else>
                                                    <a-popover placement="bottom" >
                                                    <template slot="content">
                                                        <div class="pms-publishing-info">
                                                            <h3>版本信息</h3>
                                                            <div class="details version-details">
                                                                    <div class="marginB10">
                                                                        <span class="left-details">版本号:</span>
                                                                        <span class="right-details" v-if="k.product">{{k.product.name}}({{k.full_version}})</span>
                                                                    </div>
                                                                    <div class="marginB10">
                                                                        <span class="left-details">状态:</span>
                                                                        <span class="right-details" :style="{color:k.status ===2 ? '#FEBC2E': '#3DCCA6'}">{{k.status_desc}}</span>
                                                                    </div>
                                                                    <div class="marginB10">
                                                                        <span class="left-details">创建人:</span>
                                                                        <span class="right-details">{{k.creator_name}}</span>
                                                                    </div>
                                                                    <div class="marginB10">
                                                                        <span class="left-details">预计发布测试时间:</span>
                                                                        <span class="right-details">{{k.expected_release_test_time}}（{{getWeek(k.expected_release_test_time)}}）</span>
                                                                    </div>
                                                                    <div class="marginB10">
                                                                        <span class="left-details">实际发布测试:</span>
                                                                        <span class="right-details">
                                                                            <span v-if="k.release_test_time">
                                                                                {{k.release_test_time}}（{{getWeek(k.release_test_time)}}）
                                                                                <p>{{k.release_test_comment}}</p>
                                                                            </span>
                                                                            <span v-else> -- </span>
                                                                        </span>
                                                                    </div>
                                                                    <div class="marginB10">
                                                                        <span class="left-details">预计发布上线时间:</span>
                                                                        <span class="right-details">{{k.expected_release_online_time}}（{{getWeek(k.expected_release_online_time)}}）</span>
                                                                    </div>
                                                                    <div class="marginB10">
                                                                        <span class="left-details">实际发布上线:</span>
                                                                        <span class="right-details">
                                                                            <span v-if="k.release_online_time">
                                                                                {{k.release_online_time}}（{{getWeek(k.release_online_time)}}）
                                                                                <p>{{k.release_online_comment}}</p>
                                                                            </span>
                                                                            <span v-else> -- </span>
                                                                        </span>
                                                                    </div>
                                                                    <div class="marginB10" style="margin-bottom:0">
                                                                        <span class="left-details">功能统计:</span>
                                                                        <span class="right-details">共{{k.feature_count}}个</span>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </template>
                                                    <span class="version-tag-2 cup">{{k.full_version}}</span>
                                                </a-popover>
                                            </span>
                                        </span>
                                        <span v-if="record.task_versions.length===0">
                                                <span  v-for="(k,index) in record.expected_versions" :key="index">
                                                    <a-popover placement="bottom" >
                                                    <template slot="content">
                                                        <div class="pms-publishing-info">
                                                            <h3>版本信息</h3>
                                                            <div class="details version-details">
                                                                    <div class="marginB10">
                                                                        <span class="left-details">版本号:</span>
                                                                        <span class="right-details" v-if="k.product">{{k.product.name}}({{k.full_version}})</span>
                                                                    </div>
                                                                    <div class="marginB10">
                                                                        <span class="left-details">状态:</span>
                                                                        <span class="right-details" style="color:#FF4A4A">计划版本</span>
                                                                    </div>
                                                                    <div class="marginB10">
                                                                        <span class="left-details">创建人:</span>
                                                                        <span class="right-details">{{k.creator_name}}</span>
                                                                    </div>
                                                                    <div class="marginB10">
                                                                        <span class="left-details">预计发布测试时间:</span>
                                                                        <span class="right-details">{{k.expected_release_test_time}}（{{getWeek(k.expected_release_test_time)}}）</span>
                                                                    </div>
                                                                    <div class="marginB10">
                                                                        <span class="left-details">实际发布测试:</span>
                                                                        <span class="right-details">
                                                                            <span v-if="k.release_test_time">
                                                                                {{k.release_test_time}}（{{getWeek(k.release_test_time)}}）
                                                                                <p>{{k.release_test_comment}}</p>
                                                                            </span>
                                                                            <span v-else> -- </span>
                                                                        </span>
                                                                    </div>
                                                                    <div class="marginB10">
                                                                        <span class="left-details">预计发布上线时间:</span>
                                                                        <span class="right-details">{{k.expected_release_online_time}}（{{getWeek(k.expected_release_online_time)}}）</span>
                                                                    </div>
                                                                    <div class="marginB10">
                                                                        <span class="left-details">实际发布上线:</span>
                                                                        <span class="right-details">
                                                                            <span v-if="k.release_online_time">
                                                                                {{k.release_online_time}}（{{getWeek(k.release_online_time)}}）
                                                                                <p>{{k.release_online_comment}}</p>
                                                                            </span>
                                                                            <span v-else> -- </span>
                                                                        </span>
                                                                    </div>
                                                                    <div class="marginB10" style="margin-bottom:0">
                                                                        <span class="left-details">功能统计:</span>
                                                                        <span class="right-details">共{{k.feature_count}}个</span>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </template>
                                                    <span class="version-tag-2 cup">{{k.full_version}}</span>
                                                </a-popover>
                                            </span>
                                        </span>
                                    </div>
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
                  <downPrd :media="media"></downPrd>
                </div>

              </template>
              <span class="icon iconfont">&#xe656;</span>
            </a-popover>
            <div v-else>--</div>
          </div>
          <div slot="demand_links"
               slot-scope="demand_links">
            <p v-for="(item,index) in demand_links"
               :key="index">
              <span v-if="item.type===1">设计</span>
              <span v-if="item.type===2">开发</span>
              <span v-if="item.type===3">测试</span>
              ({{item.principal_user_name}})</p>
            <p class="text-p"
               v-if="demand_links.length===0">
              --
            </p>
          </div>
        <div slot="principal"
               slot-scope="principal,record"
               class="pro_principal">
            <a-popover placement="bottomLeft"
                        style="cursor: pointer;"
                        arrowPointAtCenter>
                <template slot="content"
                            >
                    <div>
                        <p>{{record.product_category.product_line.name}} </p>
                    </div>
                </template>
                <p class="text-p text-p-overflow2"  style="display:block;">{{record.product_category.product_line.name}}</p>
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
              <p class="text-p text-p-overflow2" >{{record.product_category.product.name}} <span style="color:#666;font-size: 12px;vertical-align: middle;" v-if="record.product_category.product_modules.length >0">{{'/'+ record.product_category.product_modules[0].name}}</span> </p>
            </a-popover>
              <!--新增加修改产品负责人修改-->
            <!--<p class="text-p">{{record.principal_user_name}}33333</p>-->
              <div>
                  <p @click="handbutton2(record)" class="text-p eidt-pir" :title="record.principal_user_name">
                      <span style="color:#666666;font-size: 12px;" v-if="!record.select2">{{record.principal_user_name}}</span>
                      <a-select style="width: 120px;font-size: 14px;"
                                autoFocus
                                @blur="handleBlur2(record)"
                                @change="handleChange2($event,record)"
                                :defaultOpen="true"
                                v-if="record.select2"
                                :value="record.principal_user_name"
                      >
                          <a-select-option v-for="item4 in options3"
                                           :key="item4.id"><span>{{item4.name}}</span></a-select-option>
                      </a-select>

                  </p>
                  <span style="cursor: pointer;" v-if="!record.principal_user_name">--</span>
              </div>
          </div>
          <div slot="task"
               slot-scope="task,record"
               class="pro_note">
            <p class="text-p"
              style="color:#378eef"
               @click="showTask(record.id)"
               v-if="task">
              <!-- {{task}} -->
              查看
            </p>
            <p class="text-p"
               v-if="task===0">
              --
            </p>
          </div>
          <div slot="status"
               slot-scope="status,record"
               style="cursor: pointer;"
               @click="getLogs(record.id)"
               class="pro_status">
            <span class="icon iconfont ico-color"
                  style="color:#FF4A4A;"
                  v-if="status===0">&#xe654; <span class="status_txt">待审核</span> </span>
            <span class="icon iconfont ico-color"
                  style="color:#BBBBBB;"
                  v-if="status===1">&#xe654; <span class="status_txt">审核驳回</span></span>
            <span class="icon iconfont ico-color"
                  style="color:#FF4A4A"
                  v-if="status===2">&#xe654; <span class="status_txt">待推送</span></span>
            <span class="icon iconfont ico-color"
                  style="color:#FF4A4A"
                  v-if="status===3">&#xe654; <span class="status_txt">待指派</span></span>
            <span class="icon iconfont ico-color"
                  style="color:#FF4A4A"
                  v-if="status===4">&#xe654; <span class="status_txt">未处理</span></span>
            <span class="icon iconfont ico-color"
                  style="color:#FEBC2E"
                  v-if="status===5">&#xe654; <span class="status_txt">研发中</span></span>
            <span class="icon iconfont ico-color"
                  style="color:#FEBC2E"
                  v-if="status===6">&#xe653; <span class="status_txt">已提交</span></span>
            <span class="icon iconfont ico-color"
                  style="color:#FEBC2E"
                  v-if="status===7">&#xe654; <span class="status_txt">待测试</span></span>
            <span class="icon iconfont ico-color"
                  style="color:#FEBC2E"
                  v-if="status===8">&#xe654; <span class="status_txt">测试中</span></span>
            <span class="icon iconfont ico-color"
                  style="color:#3DCCA6"
                  v-if="status===9">&#xe653; <span class="status_txt">已完成</span></span>
            <span class="icon iconfont ico-color"
                  style="color:#FEBC2E"
                  v-if="status===10">&#xe654; <span class="status_txt">已暂停</span></span>
            <span class="icon iconfont ico-color"
                  style="color:#BBBBBB"
                  v-if="status===11">&#xe654; <span class="status_txt">已撤销</span></span>
            <span class="confirm"
                  v-if="record.confirmed===1">已确认</span>
          </div>
          <!-- 操作 -->
          <div slot="operate"
               slot-scope="operate,record"
               class="pro_operate">
              <!-- 立项审核 -->
            <span class="icon iconfont"
                  v-if="record.policies.verifyDemand"
                  @click="dialogVisible6=true,demandId=record.id"
                  title="立项审核">&#xe63d;</span>
              <span class="icon iconfont"
                  title="确认"
                  @click="confirm(record.id)"
                  v-if="record.policies.confirmDemand">&#xe647;</span>
            <span class="icon iconfont"
                  title="取消确认"
                  @click="disconfirm(record.id)"
                  style="color:#FEBC2E"
                  v-if="record.policies.cancelConfirmDemand">&#xe647;</span>
            <span class="icon iconfont"
                  title="推送"
                  v-if="record.policies.pushDemand"
                  @click="showModal(record.id)">&#xe64e;</span>

            <!-- 更新测试 -->
            <span class="icon iconfont"
                  title="更新测试"
                  v-if="record.policies.beginTestDemand"
                  @click="dialogVisible4=true,demandId=record.id">&#xe63c;</span>
             <!-- 验收完成 -->
            <span class="icon iconfont"
                  title="验收完成"
                  v-if="record.policies.completeDemand"
                  @click="dialogVisible3=true,demandId=record.id">&#xe647;</span>
                <!-- 诉求信息 -->
            <a-popover placement="bottomLeft"
                    v-if="record.appeals.length"
                    :getPopupContainer="triggerNode => triggerNode.parentNode"
                    arrowPointAtCenter>
                    <template slot="content">
                            <div style="display:flex" v-if="record.appeals.length">
                                    <p style="color:#bbb;width:52px;white-space: nowrap;margin-right: 10px;">诉求信息:</p>
                                    <div>
                                        <div  v-for="item in record.appeals" :key="item.id" style="margin-bottom:10px">
                                            <router-link :to="{ name: 'claimDetail', query: { id: item.id }}" target="_blank" >  {{item.number}}</router-link>
                                        </div>
                                    </div>
                            </div>
                    </template>
                         <span class="icon iconfont"  v-if="record.appeals.length"> &#xe62a;</span>
            </a-popover>
            <!-- 编辑 -->
            <span class="icon iconfont"
                  title="编辑"
                  v-if="record.policies.updateDemand"
                  @click="toEdit(record.id)">&#xe637;</span>
            <!-- 暂停 -->
            <span class="icon iconfont"
                  title="暂停"
                  v-if="record.policies.pauseDemand"
                  @click="dialogVisible=true,demandId=record.id">&#xe64c;</span>
            <!-- 继续开启 -->
            <span class="icon iconfont"
                  title="继续开启"
                  v-if="record.policies.continueDemand"
                  @click="continueDemands(record.id)">&#xe635;</span>
            <!-- 撤销 -->
            <span class="icon iconfont"
                  title="撤销"
                  v-if="record.policies.revocationDemand"
                  @click="dialogVisible2=true,demandId=record.id,appeals=record.appeals">&#xe657;</span>

          </div>

        </a-table>

        <div style="margin-bottom: 16px">
          <div class="table-eidt"
               style="displa:flex;" :style="{width:screenWidth+'px',height:'64px'}" v-if="data.length>0">
            <a-table :rowSelection="{selectedRowKeys: selectedRowKeys, onChange: onSelectChange}"
                     :rowKey="(record, index) => record.id"
                     :columns="columns"
                     :pagination="pagination1"
                     @change="changePage"
                     :dataSource="data">
            </a-table>
            <span class="select-lengs-eidt">
              全选
            </span>
            <span class="select-lengs">
              <a-button type="primary"
                        style="margin-right:10px"
                        v-if="canDo('pm.projects.batchConfirm')"
                        @click="confirmAll">一键确认</a-button>
              <a-button type="primary"
                        style="margin-right:10px"
                         v-if="canDo('pm.projects.batchPush')"
                        @click="pushAll">一键推送</a-button>
              <a-button type="primary" @click="transfer(selectedRowKeys)" v-if="canDo('pm.demand.transfer')" style="margin-right:10px">需求转移</a-button>
              <template v-if="hasSelected">
                {{`选中 ${selectedRowKeys.length} 个需求`}}
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
import { canDo, filtering } from '@/plugins/common'
import peopleSelect from '@/components/peopleSelect'
import qs from 'qs'
import Cookies from 'js-cookie'
import moment from 'moment'
import _ from 'lodash'
import downPrd from '@/components/downPrd'
import mySearch from '../product/components/search'
import allTaskInfo from '@/components/allTaskInfo'
import allPersonSelect from '@/components/allPersonSelect'
import allPersonSelectMultiple from '@/components/allPersonSelectMultiple'
import { getProductPrincipal, getDemandPublisher, getProjectPrincipal, getAnalysisPeople, getExcel, exportKpiExcel, getDemandsPrincipal, eidtDemandsPrincipal } from '@/api/RDmanagement/dropDown'
import { getAllprojects, searchProjects } from '@/api/RDmanagement/project'
import { getProducts } from '@/api/RDmanagement/ProductMaintenance/index.js'
import { searchUserList } from '@/api/userManage/index.js'
import { getDemands, confirmDemands, pushDemands, cancelConfirmDemands, pushDemandsAll, confirmDemandsAll, pushPriority, demandChangeLog, continueDemands, stopDemands, testDemands, revokeDemands, completeDemands, verifyDemands, demandsTransfer } from '../../../api/RDmanagement/product/index'
const columns = [
  {
    title: 'P级别',
    dataIndex: 'priority',
    key: 'priority',
    width: 100,
    slots: { title: 'customTitle2' },
    scopedSlots: { customRender: 'buttons' }

  },
  {
    title: '发布信息',
    dataIndex: 'number',
    key: 'number',
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
    },
    width: 130
  },
  {
    title: '产品类别/负责人',
    key: 'principal',
    dataIndex: 'principal',
    scopedSlots: { customRender: 'principal' },
    width: 140
  },
  {
    title: '项目来源',
    key: 'source_project_name',
    dataIndex: 'source_project_name',
    scopedSlots: { customRender: 'address' },
    width: 180
  },
  {
    title: '需求标题/目标交付',
    key: 'name',
    dataIndex: 'name',
    scopedSlots: { customRender: 'tips' },
    width: 250
  },
  {
    title: '项目负责人',
    key: 'project_principal_name',
    dataIndex: 'project_principal_name',
    scopedSlots: { customRender: 'project_principal_name' },
    width: 130
  },
  {
    title: '需求文档',
    key: 'media',
    dataIndex: 'media',
    scopedSlots: { customRender: 'media' },
    width: 90
  },
  {
    title: '研发环节/负责人',
    key: 'demand_links',
    dataIndex: 'demand_links',
    scopedSlots: { customRender: 'demand_links' },
    width: 160
  },
  {
    title: '研发进度',
    key: 'task_num',
    dataIndex: 'task_num',
    scopedSlots: { customRender: 'task' },
    width: 80

  },
  {
    title: '需求状态',
    key: 'status',
    dataIndex: 'status',
    width: 110,
    scopedSlots: { customRender: 'status' }

  },
  {
    title: `操作`,
    key: 'operate',
    dataIndex: 'operate',
    scopedSlots: { customRender: 'operate' }
  }

]
const columns2 = [
  {
    title: '时间',
    key: 'created_at',
    dataIndex: 'created_at'
  },
  {
    title: '状态',
    key: 'status',
    dataIndex: 'status',
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
export default {
  components: { downPrd, mySearch, peopleSelect, allTaskInfo, allPersonSelect, allPersonSelectMultiple },
  data () {
    return {
      excelRadio: 1,
      demand_id: undefined,
      kpi: {
        kpi_date: undefined,
        kpi_people: undefined
      },
      mySearch: false,
      searchMsg: '',
      btnLoad: false,
      appeals: [],
      remind: {},
      options: [],
      options2: [],
      options3: [],
      options_kpi: [],
      products: [],
      projectPrincipalArr: [],
      projectPrincipalID: undefined,
      productPrincipalArr: [],
      productPrincipalID: undefined,
      demandPublisherArr: [],
      demandPublisherID: undefined,
      label: '',
      fields: { label: 'name', value: 'id', children: 'children' },
      searchData: {
        tabs: -1,
        priority: undefined,
        source_project_id: this.$route.query.id || -1,
        created_at: undefined,
        products_id: undefined,
        projectPrincipal: undefined,
        productPrincipal: undefined,
        demandPublisher: undefined,
        productCategory: undefined
      },
      projectsData: {
        projectList: [{ id: this.$route.query.id || -1, name: this.$route.query.name || '所有项目' }],
        total: '',
        page: 1,
        totalPages: null
      },
      rules: {
        kpi_date: [{ required: true, message: '请选择时间', trigger: 'change' }]
      },
      data: [],
      columns,
      columns2,
      data2: [],
      selectedRowKeys: [], // Check here to configure the default column
      loading: true,
      pagination1: {
        showSizeChanger: true,
        pageSizeOptions: ['10', '20', '30', '50'],
        total: 10,
        current: 1,
        pageSize: Number(localStorage.getItem('demandPage')) || 10
      },
      value: '',
      visible: false,
      dialogVisible_1: false,
      dialogVisible2_1: false,
      dialogVisible: false,
      dialogVisible2: false,
      dialogVisible3: false,
      dialogVisible4: false,
      dialogVisible5: false,
      dialogVisible6: false,
      dialogVisible7: false,
      transferShow: false,
      transferPeople: undefined,
      receiver_id: undefined,
      receiver_name: undefined,
      radio: 1,
      textarea: '',
      demandId: '',
      screenWidth: this.$store.state.recount.pageWidth

    }
  },

  created () {
    if (!this.$route.query.id) {
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
        this.demandPublisherArr = userCache.id ? [{ name: userCache.name, id: userCache.id }] : []
        this.demandPublisherID = userCache.id ? userCache.id : undefined
        this.searchData.demandPublisher = { label: user.name, key: user.id }
      } else if (userType.product_analyst) {
        this.demandPublisherArr = userCache.id ? [{ name: userCache.name, id: userCache.id }] : []
        this.demandPublisherID = userCache.id ? userCache.id : undefined
        this.searchData.demandPublisher = { label: user.name, key: user.id }
      } else if (userType.project_manager) {
        this.projectPrincipalArr = userCache.id ? [{ name: userCache.name, id: userCache.id }] : []
        this.projectPrincipalID = userCache.id ? userCache.id : undefined
        this.searchData.projectPrincipal = { label: user.name, key: user.id }
      }
    }
    getAnalysisPeople().then(res => {
      if (res.code === 200) {
        this.options_kpi = res.data.users
      }
    })
    getProjectPrincipal().then(res => {
      if (res.code === 200) {
        this.options = res.data.users
      }
    })
    getProductPrincipal().then(res => {
      if (res.code === 200) {
        this.options2 = res.data.users
      }
    })
    getDemandPublisher().then(res => {
      if (res.code === 200) {
        this.options3 = res.data.users
      }
    })
    search = []
    search['related_project'] = 1
    if (this.$route.query.id) {
      this.$nextTick(() => {
        search['source_project_id'] = this.$route.query.id
      })
    }
    getDemands({ limit: 10, filters: search }).then(res => {
      this.remind = res.data.remind
      this.data = res.data.data.map(item => {
        return { select: false, select2: false, ...item }
      })
      this.pagination1.total = res.data.total
      this.pagination1.current = res.data.current_page
      this.pagination1.pageSize = res.data.per_page
      this.loading = false
    }).catch(error => {
      this.$message.error(error.response ? error.response.data.message : error.message)
    })
    getProducts().then(res => {
      this.products = res.data.products.map(item => {
        return { ...item, isLeaf: false }
      })
    })
    // 获取项目列表
    this.$store.dispatch('getProjects').then(res => {
      this.projectsData.projectList = res.data
      this.projectsData.projectList.unshift({ id: -1, name: '所有项目' })
      this.projectsData.total = res.total
      this.projectsData.totalPages = res.last_page
    })
  },
  watch: {
    '$store.state.recount.pageWidth' (newVal) {
      this.screenWidth = newVal
    },
    searchData: {
      handler (newVal, oldVal) {
        if (!this.searchMsg) {
          search['keyword'] = undefined
        }
        search['status'] = newVal.tabs
        search['priority'] = newVal.priority
        if (newVal.source_project_id === -1) {
          search['source_project_id'] = undefined
        } else {
          search['source_project_id'] = newVal.source_project_id
        }
        if (newVal.tabs === -1) {
          search['status'] = undefined
        }
        if (newVal.tabs === 0) {
          search['status'] = '0,1'
        }
        if (newVal.projectPrincipal) {
          search['project.principal_user_id'] = newVal.projectPrincipal.key
        } else {
          search['project.principal_user_id'] = undefined
        }
        if (newVal.productPrincipal) {
          search['principal_user_id'] = newVal.productPrincipal.key
        } else {
          search['principal_user_id'] = undefined
        }
        if (newVal.demandPublisher) {
          search['promulgator_id'] = newVal.demandPublisher.key
        } else {
          search['promulgator_id'] = undefined
        }
        if (newVal.created_at) {
          search['created_at'] = newVal.created_at[0].format('YYYY/MM/DD') + ',' + newVal.created_at[1].format('YYYY/MM/DD')
        } else {
          search['created_at'] = undefined
        }
        if (newVal.productCategory && newVal.productCategory.length > 0) {
          this.$nextTick(() => {
            this.label = document.getElementsByClassName('ant-cascader-picker-label')[0].textContent
          })
          search['products.id'] = newVal.productCategory[newVal.productCategory.length - 1]
        } else {
          search['products.id'] = undefined
        }
        this.loading = true
        let params = { filters: search,
          may,
          must,
          limit: this.pagination1.pageSize || 10 }
        getDemands(params).then(res => {
          this.remind = res.data.remind
          this.data = res.data.data.map(item => {
            return { select: false, select2: false, ...item }
          })
          this.pagination1.total = res.data.total
          this.pagination1.current = res.data.current_page
          this.pagination1.pageSize = res.data.per_page
          this.loading = false
        })
      },
      deep: true
    }
  },
  computed: {
    hasSelected () {
      return this.selectedRowKeys.length > 0
    },
    appealsMsg () {
      let a = this.appeals.map(item => {
        return item.number
      })
      return a.toString()
    }
  },
  methods: {
    canDo,
    filtering,
    moment,
    handleSearch (e) {
      this.searchData.projectPrincipal = e.id === undefined ? undefined : { key: e.id, label: e.name }
    },
    handleSearch1 (e) {
      this.searchData.productPrincipal = e.id === undefined ? undefined : { key: e.id, label: e.name }
    },
    handleSearch4 (e) {
      this.searchData.demandPublisher = e.id === undefined ? undefined : { key: e.id, label: e.name }
    },
    modalHandle (e) {
      this.kpi.kpi_people = e
    },
    getWeek (date) { // 参数时间戳
      let week = moment(date).day()
      switch (week) {
        case 1:
          return '星期一'
        case 2:
          return '星期二'
        case 3:
          return '星期三'
        case 4:
          return '星期四'
        case 5:
          return '星期五'
        case 6:
          return '星期六'
        case 0:
          return '星期日'
      }
    },
    moreSearch (e) {
      may = []
      must = []
      filtering(e, may, must)

      let params = {
        may,
        must,
        limit: 10,
        'search[related_project]': 1
      }
      search = []
      this.mySearch = true
      this.projectPrincipalArr = []
      this.projectPrincipalID = undefined
      this.$refs.projectPrincipalRef.value = undefined
      this.productPrincipalArr = []
      this.productPrincipalID = undefined
      this.$refs.productPrincipalRef.value = undefined
      this.demandPublisherArr = []
      this.demandPublisherID = undefined
      this.$refs.demandPublisherRef.value = undefined
      for (let key in this.searchData) {
        if (key === 'projectPrincipal' || key === 'productPrincipal' || key === 'demandPublisher') {
          this.searchData[key] = undefined
        } else {
          delete this.searchData[key]
        }
      }

      getDemands(params).then(res => {
        this.$refs.search.showSearch = false
        this.remind = res.data.remind
        this.data = res.data.data.map(item => {
          return { select: false, select2: false, ...item }
        })
        this.pagination1.total = res.data.total
        this.pagination1.current = res.data.current_page
        this.pagination1.pageSize = res.data.per_page
        this.loading = false
      })
    },
    loadData (selectedOptions) {
      const targetOption = selectedOptions[selectedOptions.length - 1]
      // 加载数据
      targetOption.loading = true
      getProducts(targetOption.id).then(res => {
        targetOption.loading = false
        targetOption.children = res.data.products.map(item => {
          if (selectedOptions.length > 2) {
            return { id: item.id, name: item.name, isLeaf: true }
          } else {
            return { id: item.id, name: item.name, isLeaf: false }
          }
        })
        this.products = [...this.products]
      })
    },
    showModal (id) {
      this.demandId = id
      this.dialogVisible_1 = true
    },
    showTask (id) {
      this.$refs.allTaskInfo.dialogVisible = true
      this.demand_id = id
    },
    goTask (e) {
      this.$router.push({ name: 'task', query: { number: e.number, type: e.type } })
    },
    getLogs (id) {
      demandChangeLog(id).then(res => {
        this.dialogVisible5 = true
        if (res.code === 200) {
          this.data2 = res.data.status_logs
        }
      })
    },
    cancel (index) {
      if (index === 3) {
        this.transferShow = false
        this.receiver_id = undefined
        this.receiver_name = undefined
        this.$nextTick(() => {
          this.$refs.peopleSelect.show = false
          this.$refs.peopleSelect.value1 = undefined
          this.$refs.peopleSelect.value2 = undefined
        })
      }
    },
    ok (index) {
      if (index === 1) {
        this.push(this.demandId)
        this.dialogVisible_1 = false
      } else if (index === 2) {
        this.btnLoad = true
        pushDemandsAll(this.selectedRowKeys).then(res => {
          if (res.code === 200) {
            this.$message.success('批量推送成功')
            this.selectedRowKeys = []
            this.getDemndsAll()
            this.btnLoad = false
          }
        }).catch(error => {
          this.btnLoad = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
        this.dialogVisible2_1 = false
      } else if (index === 3) {
        if (this.receiver_name === this.transferPeople) {
          this.$message.error('转移账号与接收账号不能为同一个')
        } else {
          let params = {
            demand_ids: this.selectedRowKeys,
            receiver_id: this.receiver_id
          }
          this.btnLoad = true
          demandsTransfer(params).then(res => {
            if (res.code === 200) {
              this.btnLoad = false
              this.$message.success('转移成功')
              this.transferShow = false
              this.getDemndsAll()
              this.receiver_id = undefined
              setTimeout(() => {
                this.receiver_name = undefined
              }, 0)
              this.selectedRowKeys = []
              this.$nextTick(() => {
                this.$refs.peopleSelect.show = false
                this.$refs.peopleSelect.value1 = undefined
                this.$refs.peopleSelect.value2 = undefined
              })
            }
          }).catch(error => {
            this.btnLoad = false
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        }
      }
    },
    reset (index) {
      if (index === 0) {
        this.projectPrincipalArr = []
        this.projectPrincipalID = undefined
        this.$refs.projectPrincipalRef.value = undefined
        this.searchData.projectPrincipal = undefined
      } else if (index === 1) {
        this.productPrincipalArr = []
        this.productPrincipalID = undefined
        this.$refs.productPrincipalRef.value = undefined
        this.searchData.productPrincipal = undefined
      } else if (index === 2) {
        this.searchData.created_at = undefined
      } else if (index === 3) {
        this.searchData.priority = undefined
      } else if (index === 4) {
        this.demandPublisherArr = []
        this.demandPublisherID = undefined
        this.$refs.demandPublisherRef.value = undefined
        this.searchData.demandPublisher = undefined
      } else if (index === 5) {
        this.searchData.productCategory = undefined
      } else if (index === 6) {
        this.mySearch = false
        this.loading = true
        may = []
        must = []
        this.$refs.search.data = {
          andOr: 'and',
          form: [
            { condition: undefined, judge: undefined, value: '' },
            { condition: undefined, judge: undefined, value: '' },
            { condition: undefined, judge: undefined, value: '' }
          ]
        }
        this.getDemndsAll()
      }
    },
    handleExport () {
      if (this.excelRadio === 2) {
        this.$refs.ruleForm.validate(valid => {
          if (valid) {
            let params = { }
            params.start = this.kpi.kpi_date[0].format('YYYY-MM-DD')
            params.end = this.kpi.kpi_date[1].format('YYYY-MM-DD')
            params.token = Cookies.get('token').replace('Bearer', '')
            params.user_ids = this.kpi.kpi_people
            params = qs.stringify(params)
            exportKpiExcel(params)
          } else {
            return false
          }
        })
      } else if (this.excelRadio === 1) {
        let params = { may, must, search }
        params = qs.stringify(params)
        getExcel(params)
      }
    },
    //      项目列表的分页滚动
    proJectList (value) {
      this.loading = true
      this.projectsData.page = this.projectsData.page += 1
      let params = {}
      let search = []
      search['keyword'] = value
      search['status'] = 1
      if (this.projectsData.projectList.length === this.projectsData.total) {
        this.loading = false
        return false
      } else {
        if (value) {
          params = {
            page: this.projectsData.page,
            limit: 30,
            filters: search
          }
        } else {
          search['keyword'] = undefined
          params = {
            page: this.projectsData.page,
            limit: 30,
            filters: search
          }
        }
        getAllprojects(params).then(res => {
          if (res.code === 200) {
            this.projectsData.totalPages = res.data.last_page
            this.projectsData.projectList.push(...res.data.data)
            this.loading = false
          }
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      }
    },
    popupScroll (e) {
      if (e.target.scrollTop + e.target.offsetHeight === e.target.scrollHeight) {
        this.proJectList(null)
      }
    },
    serchFocus (value) {
      this.projectsData.page = 0
      this.projectsData.projectList = []
      let values = '%' + value + '%'
      //   this.proJectList(values)
      this.$nextTick(() => {
        let self = this
        this.timer = searchProjects(1, this.timer, values, function (res) {
          self.projectsData.projectList = res.data.data
          self.projectsData.totalPages = res.data.last_page
        })
      })
    },
    releaseDemand () {
      this.$router.push({ name: 'projectReleaseDemand' })
    },
    confirm (id) {
      confirmDemands(id).then(res => {
        if (res.code === 200) {
          if (res.code === 200) {
            this.$message.success('确认成功')
            this.getDemndsAll()
          }
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    confirmAll () {
      if (this.selectedRowKeys.length > 1) {
        confirmDemandsAll(this.selectedRowKeys).then(res => {
          if (res.code === 200) {
            this.getDemndsAll()
            this.$message.success('批量确认成功')
            this.selectedRowKeys = []
          }
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else {
        this.$message.error('请勾选2个及以上')
      }
    },
    disconfirm (id) {
      cancelConfirmDemands(id).then(res => {
        if (res.code === 200) {
          this.$message.success('取消确认')
          this.getDemndsAll()
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    push (id) {
      this.btnLoad = true
      pushDemands(id).then(res => {
        if (res.code === 200) {
          this.$message.success('推送成功')
          this.getDemndsAll()
          this.btnLoad = false
        }
      }).catch(error => {
        this.btnLoad = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    pushAll () {
      if (this.selectedRowKeys.length > 1) {
        this.dialogVisible2_1 = true
      } else {
        this.$message.error('请勾选2个及以上')
      }
    },
    changeData (e) {
      //   console.log(e)
      this.loading = true

      let params = { filters: search, limit: this.pagination1.pageSize || 10 }
      getDemands(params).then(res => {
        this.remind = res.data.remind
        this.data = res.data.data.map(item => {
          return { select: false, select2: false, ...item }
        })
        this.pagination1.total = res.data.total
        this.pagination1.current = res.data.current_page
        this.pagination1.pageSize = res.data.per_page
        this.loading = false
      })
    },
    toEdit (id) {
      this.$router.push({ name: 'editDemand', query: { id: id } })
    },
    // 立项审核
    verifyDemand () {
      let params = { result: this.radio }
      if (this.textarea) {
        params.comment = this.textarea
      }
      this.btnLoad = true
      verifyDemands(this.demandId, params).then(res => {
        if (res.code === 200) {
          this.$message.success('审核完成')
          this.dialogVisible6 = false
          this.textarea = ''
          this.getDemndsAll()
          this.btnLoad = false
        }
      }).catch(error => {
        this.btnLoad = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    // 验收完成
    completeDemand () {
      this.btnLoad = true
      completeDemands(this.demandId, this.textarea).then(res => {
        if (res.code === 200) {
          this.$message.success('需求已验收完成')
          this.dialogVisible3 = false
          this.getDemndsAll()
          this.btnLoad = false
          this.textarea = ''
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    // 撤销需求
    revokeDemand (formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          if (this.appeals.length) {
            if (confirm(`检测到已关联${this.appealsMsg}，继续操作将清除关联，诉求将回到“待受理”状态，请重新受理！`)) {
              this.btnLoad = true
              revokeDemands(this.demandId, this.textarea).then(res => {
                if (res.code === 200) {
                  this.$message.success('需求已撤销')
                  this.dialogVisible2 = false
                  this.textarea = ''
                  this.getDemndsAll()
                  this.btnLoad = false
                }
              }).catch(error => {
                this.btnLoad = false
                this.$message.error(error.response ? error.response.data.message : error.message)
              })
            }
          } else {
            this.btnLoad = true
            revokeDemands(this.demandId, this.textarea).then(res => {
              if (res.code === 200) {
                this.$message.success('需求已撤销')
                this.dialogVisible2 = false
                this.textarea = ''
                this.getDemndsAll()
                this.btnLoad = false
              }
            }).catch(error => {
              this.btnLoad = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          }
        } else {
          return false
        }
      })
    },
    // 测试
    testDemand () {
      this.btnLoad = true
      testDemands(this.demandId).then(res => {
        if (res.code === 200) {
          this.$message.success('需求开始测试')
          this.dialogVisible4 = false
          this.getDemndsAll()
          this.btnLoad = true
        }
      }).catch(error => {
        this.btnLoad = true
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    // 需求暂停
    stopDemand (formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          this.btnLoad = true
          stopDemands(this.demandId, this.textarea).then(res => {
            if (res.code === 200) {
              this.dialogVisible = false
              this.$message.success('需求暂停')
              this.getDemndsAll()
              this.btnLoad = false
            }
          }).catch(error => {
            this.btnLoad = false
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        } else {
          return false
        }
      })
    },
    // 需求继续
    continueDemands (id) {
      this.btnLoad = true
      continueDemands(id).then(res => {
        if (res.code === 200) {
          this.$message.success('需求继续')
          this.getDemndsAll()
          this.btnLoad = false
        }
      }).catch(error => {
        this.btnLoad = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    toClaimDetail (id) {
      this.$router.push({ name: 'recountindex', params: { id: id } })
    },
    onSelectChange (selectedRowKeys) {
      // console.log('selectedRowKeys changed: ', selectedRowKeys)
      this.selectedRowKeys = selectedRowKeys
    },
    onSearch (value) {
      if (value) {
        search['keyword'] = '%' + value.trim() + '%'
      } else {
        search['keyword'] = undefined
      }
      let params = { filters: search, limit: 10 }
      getDemands(params).then(res => {
        this.remind = res.data.remind
        this.data = res.data.data.map(item => {
          return { select: false, select2: false, ...item }
        })
        this.pagination1.total = res.data.total
        this.pagination1.current = res.data.current_page
        this.pagination1.pageSize = res.data.per_page
        this.loading = false
      })
    },
    handleClose () {
      this.dialogVisible = false
    },
    getDemndsAll () {
      let may = []
      may['name, like'] = 'O'
      if (this.$route.query.id) {
        search['source_project_id'] = this.$route.query.id
      }
      let params = {
        filters: search,
        limit: this.pagination1.pageSize || 10,
        page: this.pagination1.current || 1
        // may: may
      }
      getDemands(params).then(res => {
        // console.log(res)
        this.remind = res.data.remind
        this.data = res.data.data.map(item => {
          return { select: false, select2: false, ...item }
        })
        this.pagination1.total = res.data.total
        this.pagination1.current = res.data.current_page
        this.pagination1.pageSize = res.data.per_page
        this.loading = false
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    // 修改p级别
    handleChange (e, k) {
      // console.log(e, k)
      k.select = false
      k.priority = e
      pushPriority(k.id, e).then(res => {
        if (res.code === 200) {
          this.$message.success('修改P级别成功')
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    handleChange2 (e, k) {
      k.select2 = false
      let param = {
        user_id: e
      }
      eidtDemandsPrincipal(param, k.id).then(res => {
        if (res.code === 200) {
          this.$message.success('您已经修改了产品负责人')
          this.getDemndsAll()
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    handleBlur (k) {
      // console.log('失去焦点')
      k.select = false
    },
    handleBlur2 (k) {
      k.select2 = false
    },
    handleFocus () {
      // console.log('获得焦点')
    },
    handbutton (k) {
      if (k.policies.priority) {
        k.select = true
      }
    },
    handbutton2 (k) {
      if (k.policies.setPrincipal) {
        k.select2 = true
        getDemandsPrincipal(k.id).then(res => {
          if (res.code === 200) {
            this.options3 = res.data.users
          }
        })
      }
    },
    transfer (ids) {
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
              if (item2.status === 9) {
                this.$message.error('已完成需求,不可操作转移!')
              } else if (item2.status === 11) {
                this.$message.error('已撤销需求,不可操作转移!')
              }
              user.push(item2.promulgator_name)
            }
          })
          return obj
        })
        let result = user.some(function (value, index) {
          return value !== user[0]
        })
        let arr2 = arr.map(item => {
          return item.status
        })
        if (result) {
          this.$message.error('请确认需转移的需求发布人为同一人!')
        }
        if (!result && arr2.indexOf(9) === -1 && arr2.indexOf(11) === -1) {
          this.transferShow = true
          this.transferPeople = user[0]
        }
      } else {
        this.$message.error('请勾选')
      }
    },
    getTransferID (e, name) {
      this.receiver_id = e
      this.receiver_name = name
    },
    changePage (e) {
      this.loading = true
      localStorage.setItem('demandPage', e.pageSize)
      let params = {}
      search['related_project'] = 1
      params = { filters: search, may, must, page: e.current, limit: e.pageSize }
      getDemands(params).then(res => {
        this.remind = res.data.remind
        this.data = res.data.data.map(item => {
          return { select: false, select2: false, ...item }
        })
        this.pagination1.total = res.data.total
        this.pagination1.current = res.data.current_page
        this.pagination1.pageSize = res.data.per_page
        this.loading = false
      })
    },
    searchUser (e) {
      this.$nextTick(() => {
        let self = this
        this.timer = searchUserList(this.timer, e, function (data) {
          self.options = data.data.users
        })
      })
    }

  }
}
</script>
<style lang="less" scoped>
 .ok{
      text-align: right;
      padding: 20px 10px;
      width: 280px;
  }
  .eidt-expend /deep/.expend{
    top:6px
}
  /deep/.ant-form-item-control{
  line-height: 1 !important;
}
/deep/.table-list .ant-table-tbody > tr > td {
    padding: 0 30px 0 0;
}
/deep/.table-list .ant-table-tbody > tr > td:nth-child(2) {
    padding: 0 20px 0 0;
}
.confirm {
  display: inline-block;
  border: 1px solid #3dcca6;
  width: 40px;
  height: 18px;
  line-height: 18px;
  color: #3dcca6;
}
.status_txt {
  font-size: 12px;
  color: rgba(102, 102, 102, 1);
}
.tree {
  line-height: 18px;
  display: inline-block;
  width: 18px;
  height: 18px;
  text-align: center;
  background: rgba(255, 74, 74, 0.2);
  color: #ff4a4a;
}
.top-select {
  margin-bottom: 30px;
  /deep/.ant-select-selection {
    border: 0;
    box-shadow: none;
    border-radius: 0;
  }
  /deep/.ant-select-selection--single {
    height: 32px;
  }
  /deep/.ant-select-selection-selected-value {
    margin-left: 5px;
  }
  .select-btn {
    margin-right: 10px;
  }
  .select-btn::after {
    position: absolute;
    top: -1px;
    right: -7px;
    display: block;
    width: 0;
    height: 0;
    border-width: 17px 0 17px 8px;
    border-style: solid;
    border-color: transparent transparent transparent #fff;
    content: " ";
  }
  .select-btn2::before {
    position: absolute;
    top: 0;
    left: 0;
    display: block;
    width: 0;
    height: 0;
    z-index: 10;
    border-width: 17px 0 17px 8px;
    border-style: solid;
    border-color: transparent transparent transparent #f0f2f5;
    content: " ";
  }
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
      //     font-size: 14px;
      //     font-weight:bold;
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
  .pro_status .ico-color {
    margin-right: 6px;
    color: #ff4a4a;
  }
  .pro_operate {
    display: flex;
  }
  .pro_operate .icon {
    color: #378eef;
    font-size: 14px;
    margin-right: 10px;
    cursor: pointer;
  }
  .pro_principal{
//    padding:10px 0;
  }
 .pro_annex span,
  .pro_principal span {
    color: #378eef;
    font-size: 14px;
      cursor: pointer;
      position: relative;
      top: -2px;
      margin-right: 4px;
  }

  .pro_note{
      cursor: pointer;
  }
  .pro_note span {
    color: #378eef;
    font-size: 12px;
  }
  .pro_operate span {
    display: inline-block;
    margin-right: 4px;
  }
  .ant-table-wrapper {
    box-shadow: 0px 5px 15px 0px rgba(223, 226, 230, 0.8);
    border-radius: 5px;
    margin-bottom: 30px;
    background: #fff;
  }
  /deep/.ant-table-pagination {
    display: none;
  }
  /deep/.ant-table-body {
    margin: 0px 20px 30px 20px;
  }
  /deep/.ant-table-body tr:nth-child(odd) {
    background: #fff;
  }
  /deep/.ant-table-body tr:nth-child(even) {
    background: #f8f8f8;
  }

  .button_box_text {
    width: 18px;
    display: inline-block;
    height: 18px;
    border: 1px solid #ff4a4a;
    background: rgba(255, 74, 74, 0.2);
    color: #ff4a4a;
    border-radius: 2px;
    font-size: 12px;
    text-align: center;
    line-height: 16px;
    cursor: pointer;
  }
  .button_box_color2 {
    border: 1px solid rgba(248, 141, 73, 1);
    background: rgba(248, 141, 73, 0.2);
    color: rgba(248, 141, 73, 1);
  }
  .button_box_color3 {
    border: 1px solid rgba(254, 188, 46, 1);
    background: rgba(254, 188, 46, 0.2);
    color: rgba(254, 188, 46, 1);
  }
  .button_box_color4 {
    border: 1px solid rgba(61, 204, 166, 1);
    background: rgba(61, 204, 166, 0.2);
    color: rgba(61, 204, 166, 1);
  }
  .button_box_color5 {
    border: 1px solid rgba(187, 187, 187, 1);
    background: rgba(187, 187, 187, 0.2);
    color: rgba(187, 187, 187, 1);
  }
  .button_box {
    cursor: pointer;
    // margin-left: 10px;
    width: 70px;
    height: 20px;
    position: relative;
    /deep/.ant-select {
      position: absolute;
      left: -2px;
      top: -6px;
    }
  }
  .button_box:hover {
    width: 70px;
    height: 20px;
    background: #eee;
  }
}
.table-list /deep/ .ant-table-thead {
  height: 46px;
  background: #f8f8f8;
  border-radius: 5px;
}

.ant-table-tbody > tr:hover:not(.ant-table-expanded-row) > td {
  &:nth-child(2) div{
    animation: disappear2 3s;
    animation-fill-mode:forwards
  }
   &:nth-child(4) .eidt-pir{
    animation: disappear2 3s;
    animation-fill-mode:forwards
  }
   &:nth-child(10) div{
    animation: disappear2 3s;
    animation-fill-mode:forwards
  }
   &:nth-child(11) div{
    animation: disappear2 3s;
    animation-fill-mode:forwards
  }
}
// .table-list /deep/ .ant-table-thead th:nth-child(2){
//     width: 6%;
// }
// .table-list /deep/ .ant-table-thead th:nth-child(3){
//     width: 10%;
// }
// .table-list /deep/ .ant-table-thead th:nth-child(4){
//     width: 11%;
// }
// .table-list /deep/ .ant-table-thead th:nth-child(5){
//     width: 11%;
// }
// .table-list /deep/ .ant-table-thead th:nth-child(6){
//     width: 12%;
// }
// .table-list /deep/ .ant-table-thead th:nth-child(7){
//     width: 7%;
// }
// .table-list /deep/ .ant-table-thead th:nth-child(8){
//     width: 6%;
// }
// .table-list /deep/ .ant-table-thead th:nth-child(9){
//     width: 10%;
// }
// .table-list /deep/ .ant-table-thead th:nth-child(11){
//     width: 10%;
// }
.table-list /deep/ .ant-table-thead th:nth-child(12){
    width: 140px;
}

.table-eidt /deep/.ant-table-tbody {
  display: none;
}
.table-eidt /deep/ .ant-table-thead th {
  display: none;
}
.table-eidt /deep/ .ant-table-thead .ant-table-selection-column {
  display: block;
  background: #fff !important;
  width:auto;
}
.table-eidt /deep/ .ant-table {
  float: left;
  // display: none;
}
.table-eidt /deep/.ant-table-placeholder {
  display: none;
}
.table-list /deep/ .ant-table-thead > tr > th {
  border-bottom: none;
  /*background:#fff !important;*/
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
    position: absolute;
    color: #bbb;
    font-size: 12px;
    left: 45px;
    top: 26px;
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
  display: flex;
  align-items: center;
  p {
    color: #378eef;
    font-size: 12px;
    margin-right: 20px;
    i {
      display: inline-block;
      margin-right: 4px;
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
    position: relative;
    top: 1px;
  .el-input__inner {
    width: 100%;
    height: 32px;
    line-height: 32px;
    padding: 0px 10px;
    border-color: #ccc;
  }
}
/deep/ .el-date-editor .el-range-separator {
  width: 9%;
}
.upload_box {
  display: flex;
  padding: 20px 0 30px 0;
}
.popup_opinion_submit_file span {
  float: left;
  margin-top: 8px;
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
  // width: 145px;
  overflow: hidden;
}
.popup_opinion_submit_file li i {
  vertical-align: middle;
  font-size: 12px;
  margin-left: 10px;
  display: block;
  float: right;
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
  color: #26a3e0;
  font-size: 12px;
  border-radius: 3px;
    margin:0px 10px 10px 0px;
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

.radio_box .contxt {
  padding: 30px 0;
  font-size: 16px;
  text-align: center;
  line-height: 1;
}
.dialog_footer {
  text-align: center;
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
.download-list{
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
// .el-select-eidt /deep/ .popper__arrow{
//   display: none;
// }
</style>

 <style>
.ant-select-selection--single {
  height: 32px !important;
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
.eidt-pir{
    width: 120px;
    height: 32px;
    line-height: 32px;
}
</style>
