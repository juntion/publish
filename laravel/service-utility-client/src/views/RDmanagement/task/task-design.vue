<template>
  <div>
    <addFollower :postType="3" ref="addFollower" :title="title" :id="subtasks_id"></addFollower>
    <allTaskInfo  ref="allTaskInfo" :id="demand_id" title="其他环节信息"></allTaskInfo>
     <!-- 更改版本信息 -->
    <editVersonModal type="design"></editVersonModal>
    <!-- 操作记录弹框 -->
    <div class="modal-box">
      <el-dialog title="状态变动记录"
                 :visible.sync="dialogVisible"
                 width="700px">
        <div class="radio_box"
             style="padding-bottom: 10px;margin-top: -20px;">
          <a-table :dataSource="data2"
                   :columns="columns2"
                   :pagination="false"
                   :rowKey="(record, index) => index">
                <div slot="status" slot-scope="status,record">
                    <span style="color:#FF4A4A;" v-if="record.status=='待审核'">{{record.status}}</span>
                    <span style="color:#FF4A4A;" v-if="record.status=='待指派'">{{record.status}}</span>
                    <span style="color:#FF4A4A;" v-if="record.status=='等待中'">{{record.status}}</span>
                    <span style="color:#FEBC2E;" v-if="record.status=='未开始'">{{record.status}}</span>
                    <span style="color:#FEBC2E;" v-if="record.status=='进行中'">{{record.status}}</span>
                    <span style="color:#FEBC2E;" v-if="record.status=='已提交'">{{record.status}}</span>
                    <span style="color:#FEBC2E;" v-if="record.status=='已暂停'">{{record.status}}</span>
                    <span style="color:#3DCCA6;" v-if="record.status=='已完成'">{{record.status}}</span>
                    <span style="color:#BBBBBB;" v-if="record.status=='已撤销'">{{record.status}}</span>
                </div>
            </a-table>
        </div>
      </el-dialog>
    </div>

    <div class="tabslist">
      <a-tabs class="tabs_bg"
              v-model="searchData.tabs">
        <a-tab-pane :key="200">
          <span slot="tab">
            All
          </span>
        </a-tab-pane>
        <!-- 状态；0：等待中；1：待审核；2：待指派；3：未开始；4：进行中；5：已提交；6：已完成；7：已暂停；8：已撤销； -->
        <a-tab-pane :key="1">
          <span slot="tab" title="需要设计主负责人审核的任务">
            待审核
            <a-badge :count="remind.status1" />
          </span>
        </a-tab-pane>
        <a-tab-pane :key="2">
          <span slot="tab" title="未指定跟进人的任务">
            待指派
            <a-badge :count="remind.status2" />
          </span>
        </a-tab-pane>
        <a-tab-pane :key="0">
          <span slot="tab" title="上一个环节未完成的任务">
            等待中
            <a-badge :count="remind.status0" />
          </span>
        </a-tab-pane>
        <a-tab-pane :key="3">
          <span slot="tab" title="未开始的任务">
            未开始
            <a-badge :count="remind.status3" />
          </span>
        </a-tab-pane>
        <a-tab-pane :key="4">
          <span slot="tab" title="正在进行的任务">
            进行中
            <a-badge :count="remind.status4" />
          </span>
        </a-tab-pane>
        <a-tab-pane :key="5">
          <span slot="tab" title="已提交成果的任务">
            已提交
            <a-badge :count="remind.status5" />
          </span>
        </a-tab-pane>
        <a-tab-pane :key="6">
          <span slot="tab" title="负责人验收完成的任务">
            已完成
          </span>
        </a-tab-pane>
        <a-tab-pane :key="100">
          <span slot="tab" title="需要设计走查的任务">
            设计走查
            <a-badge :count="remind.review2" />
          </span>
        </a-tab-pane>
        <a-tab-pane :key="7">
          <span slot="tab">
            已暂停
            <a-badge :count="remind.status7" />
          </span>
        </a-tab-pane>
        <a-tab-pane :key="8">
          <span slot="tab">
            已撤销
          </span>
        </a-tab-pane>
      </a-tabs>
      <!-- 选择筛选 -->
      <div class="select-box">
        <!-- <a-select placeholder="发布人"
                  labelInValue
                  showSearch
                  optionFilterProp="children"
                  v-model="searchData.TaskPublisher"
                  style="width: 7%;margin-right: 10px;">
          <a-select-option v-for="item in options"
                           :key="item.id">{{item.name}}</a-select-option>
        </a-select> -->
        <allPersonSelect :autoFocus="false"
                         @getSelectValue="handleSearch1"
                         :selectValue="TaskPublisherID"
                         :searchData="TaskPublisherArr"
                         ref="TaskPublisherRef"
                         placeholder="发布人(请输入英文名搜索)"
                         style="width: 7%;margin-right: 10px;">
        </allPersonSelect>
        <!-- <a-select placeholder="负责人"
                  labelInValue
                  showSearch
                  optionFilterProp="children"
                  v-model="searchData.Principal"
                  style="width: 7%;margin-right: 10px;">
          <a-select-option v-for="item in options2"
                           :key="item.id">{{item.name}}</a-select-option>
        </a-select> -->
        <allPersonSelect :autoFocus="false"
                         @getSelectValue="handleSearch4"
                         :selectValue="PrincipalID"
                         :searchData="PrincipalArr"
                         ref="PrincipalRef"
                         placeholder="负责人(请输入英文名搜索)"
                         style="width: 7%;margin-right: 10px;">
        </allPersonSelect>
        <!-- <a-select placeholder="处理人"
                  labelInValue
                  showSearch
                  optionFilterProp="children"
                  v-model="searchData.TaskHandler"
                  style="width: 7%;margin-right: 10px;">
          <a-select-option v-for="item in options3"
                           :key="item.id">{{item.name}}</a-select-option>
        </a-select> -->
        <allPersonSelect :autoFocus="false"
                         @getSelectValue="handleSearch5"
                         :selectValue="TaskHandlerID"
                         :searchData="TaskHandlerArr"
                         ref="TaskHandlerRef"
                         placeholder="处理人(请输入英文名搜索)"
                         style="width: 7%;margin-right: 10px;">
        </allPersonSelect>
         <a-select placeholder="处理人状态"
                  style="width: 7%;margin-right: 10px;"
                  labelInValue
                  v-model="searchData.subTasks_status">
                  <!-- 0：未开始；1：进行中；2：已提交；3：已完成；4：已暂停；5：已撤销；6：关闭中； -->
                <a-select-option :value="0"> 未开始</a-select-option>
                <a-select-option :value="1"> 进行中</a-select-option>
                <a-select-option :value="2"> 已提交</a-select-option>
                <a-select-option :value="3"> 已完成</a-select-option>
                <a-select-option :value="4"> 已暂停</a-select-option>
                <a-select-option :value="5"> 已撤销</a-select-option>
                <a-select-option :value="6"> 关闭中</a-select-option>
        </a-select>
        <a-select placeholder="优先级"
                  style="width: 7%;margin-right: 10px;"
                  v-model="searchData.priority">
                <a-select-option :value="1"><span class="button_box_text"> 1</span><span class="after" style="color:#FF4A4A;float:right">高</span></a-select-option>
                <a-select-option :value="2"><span class="button_box_text button_box_color2"> 2</span></a-select-option>
                <a-select-option :value="3"><span class="button_box_text button_box_color3"> 3</span></a-select-option>
                <a-select-option :value="4"><span class="button_box_text button_box_color4"> 4</span></a-select-option>
                <a-select-option :value="5"><span class="button_box_text button_box_color5"> 5</span><span  class="after" style="color:#BBBBBB;float:right">低</span></a-select-option>
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
                        style="width: 14%;"
                        v-model="searchMsg"
                        @search="onSearch" />
        <span style="margin-left:10px;color: #378eef">
            <mySearch @search="moreSearch" ref="search" type="design"></mySearch>
        </span>
        <div class="upload_box">
          <div class="popup_opinion_submit_box after">
            <ul class="popup_opinion_submit_file">
                <span>筛选：</span>
                 <li v-if="searchData.TaskPublisher"><b>发布人：{{searchData.TaskPublisher.label}}</b>
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
              <li v-if="searchData.Principal"><b>负责人：{{searchData.Principal.label}}</b>
                <i class="icon iconfont"
                   @click="reset(4)">&#xe631;</i>
              </li>
              <li v-if="searchData.TaskHandler"><b>处理人：{{searchData.TaskHandler.label}}</b>
                <i class="icon iconfont"
                   @click="reset(5)">&#xe631;</i>
              </li>
               <li v-if="searchData.subTasks_status"><b>处理人状态：{{searchData.subTasks_status.label}}</b>
                <i class="icon iconfont"
                   @click="reset(7)">&#xe631;</i>
              </li>
              <li v-if="mySearch"><b>高级筛选</b>
                <i class="icon iconfont"
                   @click="reset(6)">&#xe631;</i>
              </li>
            </ul>

          </div>
        </div>

        <!-- 开始任务 -->
        <div class="modal-box">
          <el-dialog title="开始任务"
                     :visible.sync="dialogVisible2"
                      :close-on-click-modal="false"
                     width="380px">
            <div class="radio_box">
              <p>备注</p>
              <el-input type="textarea"
                        :autosize="{ minRows: 3, maxRows: 3}"
                        placeholder="请输入备注"
                        v-model="comment"
                        resize="none">
              </el-input>
            </div>
            <span slot="footer"
                  class="dialog-footer">
              <el-button @click="cancel(2)">取 消</el-button>
              <el-button type="primary"
                        :loading="btnLoad"
                         @click="ok(2)">确 定</el-button>
            </span>
          </el-dialog>
        </div>

        <!-- 验收 -->
         <a-modal title="验收"
                    class="modal-pms"
                   v-model="dialogVisible3"
                   :confirmLoading="btnLoad"
                   @cancel="cancel(3)"
                   @ok="ok(3)"
                   :maskClosable="false"
                   destroyOnClose
                   width="380px">
                        <div>
                              <a-form-model
                                :model="checkForm"
                                ref="checkForm">
                                <a-form-model-item style="margin-bottom:20px" label="发版信息" v-if="designType===4">
                                    <span v-if="checkInfo.release_type===0">
                                                     <a-popover placement="bottom" >
                                                        <template slot="content" >
                                                            <div class="pms-publishing-info" v-if="checkInfo.version">
                                                                <h3>版本信息</h3>
                                                                <div class="details version-details">
                                                                        <div class="marginB10">
                                                                            <span class="left-details">版本号:</span>
                                                                            <span class="right-details">{{checkInfo.version.product.name}}({{checkInfo.version.full_version}})</span>
                                                                        </div>
                                                                        <div class="marginB10">
                                                                            <span class="left-details">状态:</span>
                                                                            <span class="right-details" :style="{color:checkInfo.version.status ===2 ? '#FEBC2E': '#3DCCA6'}">{{checkInfo.version.status_desc}}</span>
                                                                        </div>
                                                                        <div class="marginB10">
                                                                            <span class="left-details">创建人:</span>
                                                                            <span class="right-details">{{checkInfo.version.creator_name}}</span>
                                                                        </div>
                                                                        <div class="marginB10">
                                                                            <span class="left-details">预计发布测试时间:</span>
                                                                            <span class="right-details">{{checkInfo.version.expected_release_test_time}}（{{getWeek(checkInfo.version.expected_release_test_time)}}）</span>
                                                                        </div>
                                                                        <div class="marginB10">
                                                                            <span class="left-details">实际发布测试:</span>
                                                                            <span class="right-details">
                                                                                <span v-if="checkInfo.version.release_test_time">
                                                                                    {{checkInfo.version.release_test_time}}（{{getWeek(checkInfo.version.release_test_time)}}）
                                                                                    <p>{{checkInfo.version.release_test_comment}}</p>
                                                                                </span>
                                                                                <span v-else> -- </span>
                                                                            </span>
                                                                        </div>
                                                                        <div class="marginB10">
                                                                            <span class="left-details">预计发布上线时间:</span>
                                                                            <span class="right-details">{{checkInfo.version.expected_release_online_time}}（{{getWeek(checkInfo.version.expected_release_online_time)}}）</span>
                                                                        </div>
                                                                        <div class="marginB10">
                                                                            <span class="left-details">实际发布上线:</span>
                                                                            <span class="right-details">
                                                                                <span v-if="checkInfo.version.release_online_time">
                                                                                    {{checkInfo.version.release_online_time}}（{{getWeek(checkInfo.version.release_online_time)}}）
                                                                                    <p>{{checkInfo.version.release_online_comment}}</p>
                                                                                </span>
                                                                                <span v-else> -- </span>
                                                                            </span>
                                                                        </div>
                                                                        <div class="marginB10" style="margin-bottom:0">
                                                                            <span class="left-details">功能统计:</span>
                                                                            <span class="right-details">共{{checkInfo.version.feature_count}}个</span>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <div class="pms-publishing-info">
                                                                    --
                                                            </div>
                                                        </template>
                                                       <span class="version-tag-2 cup">跟随版本</span>
                                                    </a-popover>
                                    </span>
                                    <span v-else-if="checkInfo.release_type===2">
                                            <a-popover placement="bottom" >
                                                        <template slot="content">
                                                            <div class="pms-publishing-info">
                                                                <h3>版本信息</h3>
                                                                <div class="details version-details">
                                                                        <div class="marginB10" style="margin-bottom:0">
                                                                            <span class="left-details" style="width:51px">开发说明:</span>
                                                                            <span class="right-details">{{checkInfo.release_comment ? checkInfo.release_comment : '--'}}</span>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        </template>
                                                      <span class="version-tag-1 cup">无需发版</span>
                                                    </a-popover>
                                    </span>
                                    <span v-else>
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
                                                                            <span class="right-details">{{checkInfo.release_comment ? checkInfo.release_comment : '--'}}</span>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        </template>
                                                      <span  class="version-tag-1 cup"> Hotfix</span>
                                                    </a-popover>
                                    </span>
                                 </a-form-model-item>
                                 <a-form-model-item prop="radio" style="margin-bottom:20px" label="验收结果">
                                        <a-radio-group name="radioGroup" v-model="checkForm.result">
                                            <a-radio :value="1"> 验收合格</a-radio>
                                            <a-radio :value="0">验收不合格，继续修改</a-radio>
                                        </a-radio-group>
                                         <p style="color:#F88D49;margin-top:10px"
                                            v-if="checkForm.result===1">* 验收合格后，此任务确定为已完成，不可修改！</p>
                                        <p style="color:#F88D49;margin-top:10px"
                                            v-if="checkForm.result===0">* 不合格的任务，确认后将会变为进行中，可继续提交!</p>
                                 </a-form-model-item>
                                 <a-form-model-item prop="finish_type" style="margin-bottom:20px" label="完成情况" v-if="checkForm.result"
                                    :rules="[{ required: true, message: '请选择完成情况', trigger: 'change' }]">
                                        <a-radio-group name="radioGroup2" v-model="checkForm.finish_type">
                                            <a-radio :value="1">按时完成</a-radio>
                                            <a-radio :value="2">提前完成</a-radio>
                                            <a-radio :value="3">超时完成</a-radio>
                                        </a-radio-group>
                                        <div class="tips">
                                            此任务预计交付时间为{{expiration_date}}，系统计算为
                                            <span style="color:#FF0000">
                                                <span v-if="systemTime<0 && checkForm.finish_type!==2">提前{{Math.abs(systemTime)}}天</span>
                                                <span v-if="systemTime>0 && checkForm.finish_type!==3">超时{{systemTime}}天</span>
                                                <span v-if="systemTime==0 && checkForm.finish_type!==1">按时完成</span>
                                             </span>
                                             <span style="color:#3DCCA6">
                                                <span v-if="systemTime<0 && checkForm.finish_type===2">提前完成</span>
                                                <span v-if="systemTime>0 && checkForm.finish_type===3">超时完成</span>
                                                <span v-if="systemTime==0 && checkForm.finish_type===1">按时完成</span>
                                             </span>
                                        </div>
                                         <p style="color:#F88D49;margin-top:10px">* 此完成情况将用于部门考核，请谨慎选择！</p>
                                 </a-form-model-item>
                                <a-form-model-item
                                     v-if="(checkForm.result && systemTime<0 && checkForm.finish_type!==2) || (checkForm.result &&  systemTime>0 && checkForm.finish_type!==3) || ( systemTime==0 && checkForm.finish_type!==1  && checkForm.result )"
                                     prop="difference_reason" style="margin-bottom:20px" label="差异原因说明" :rules="[{ required: true, message: '请输入差异原因', trigger: 'blur' }]">
                                    <a-textarea placeholder="请输入差异原因" v-model="checkForm.difference_reason" style="height:80px" />
                                </a-form-model-item>
                                <a-form-model-item prop="comment" label="备注">
                                    <a-textarea placeholder="请输入备注" v-model="checkForm.comment" style="height:80px" />
                                </a-form-model-item>
                              </a-form-model>
                        </div>
            </a-modal>

        <!-- 提交 -->
        <div class="modal-box">
        <a-modal   :title="type===1 ? '提交' : '信息更新'"
                     :maskClosable="false"
                     destroyOnClose
                     v-model="dialogVisible4"
                     width="700px">

            <div class="radio_box">
              <a-form-model
                                :model="submitForm"
                                ref="submitForm">
                        <div   v-if="type===1 && designType===4">
                            <div class="tips-box" v-if="tipsShow">
                                检测到此任务同时存在移动端开发，请注意是否需要同时发版，保持充足沟通！
                                <span class="iconfont fz12" @click="closeTips">&#xe631;</span>
                            </div>
                            <a-row class="marginB20">
                                    <a-col :lg="12"
                                        :md="12"
                                        :sm="12"
                                        style="padding-right: 20px"
                                        >
                                        <a-form-model-item prop="release_type" label="发版信息"  :rules="[{ required: true, message: '请选择', trigger: 'change' }]">
                                            <a-radio-group v-model="submitForm.release_type">
                                                <a-radio :value="0">跟随版本发布</a-radio>
                                                <a-radio :value="1">hotfix上线</a-radio>
                                                <a-radio :value="2">无需发布</a-radio>
                                            </a-radio-group>
                                    </a-form-model-item>
                                    </a-col>
                                    <a-col :lg="12"
                                        :md="12"
                                        :sm="12"
                                        >
                                        <a-form-model-item class="colon" v-if="!isMainFollower && submitForm.release_type===0">
                                            <span class="fz12" slot="label">分支选择：<span style="color:#f88d49;margin-left:10px">若与主任务同一分支请勿勾选填写此信息！ </span></span>
                                            <a-checkbox v-model="submitForm.independentBranch">独立分支</a-checkbox>
                                        </a-form-model-item>
                                    </a-col>
                                </a-row>

                            <div v-if="(submitForm.release_type===0 && isMainFollower) || (!isMainFollower && submitForm.release_type===0 && submitForm.independentBranch)">
                                <a-row class="marginB20">
                                    <a-col :lg="12"
                                        :md="12"
                                        :sm="24"
                                        style="padding-right: 20px"
                                        >
                                        <a-form-model-item prop="branch_name" label="分支名" :rules="[{ required: true, message: '请输入', trigger: 'blur' }]">
                                                <a-input placeholder="请输入" v-model="submitForm.branch_name" />
                                        </a-form-model-item>
                                    </a-col>
                                    <a-col :lg="12"
                                        :md="12"
                                        :sm="24"
                                        >

                                        <a-form-model-item prop="release_version_id" label="纳入版本" :rules="[{ required: true,  message: '请选择', trigger: 'change' }]">
                                                <a-popover
                                                    :getPopupContainer="triggerNode => triggerNode.parentNode"
                                                    trigger="click">
                                                    <template slot="content">
                                                        <div style="width:300px">
                                                            <div>
                                                                <span style="color:#bbb"> 检测到此需求预计交付为: </span>
                                                                <span style="color:#666"> {{versions.expiration_date}}</span>
                                                            </div>
                                                            <div>
                                                                <span style="color:#bbb"> 预计纳入版本: </span>
                                                                <span style="color:#666" v-for="(v,index) in versions.expected_versions" :key="index">
                                                                    {{v.product.name}} ({{v.full_version}})
                                                                </span>
                                                            </div>
                                                            <div><span style="color:#FF4A4A">*</span> 注意：需求所选仅作为参考，实际发版将以此任务提交信息为准，请谨慎选择； </div>
                                                        </div>
                                                    </template>
                                                    <GroupSelect mode="default" v-model="submitForm.release_version_id" @change="checkTestStatus"></GroupSelect>
                                                </a-popover>

                                        </a-form-model-item>
                                    </a-col>
                                </a-row>
                                <a-row class="marginB20">
                                    <a-col :lg="12"
                                        :md="12"
                                        :sm="24"
                                        style="padding-right: 20px"
                                        >
                                        <a-form-model-item prop="has_sql" label="SQL" :rules="[{ required: true, message: '请选择', trigger: 'change' }]">
                                                <a-select  placeholder="请选择" v-model="submitForm.has_sql">
                                                    <a-select-option :value="1">有 </a-select-option>
                                                    <a-select-option :value="0">无 </a-select-option>
                                                </a-select>
                                        </a-form-model-item>
                                    </a-col>
                                    <a-col :lg="12"
                                        :md="12"
                                        :sm="24"
                                        >
                                        <a-form-model-item prop="stress_test" label="压力测试" :rules="[{ required: true, message: '请选择', trigger: 'change' }]">
                                                <a-select v-model="submitForm.stress_test" placeholder="请选择">
                                                    <a-select-option :value="1">需要 </a-select-option>
                                                    <a-select-option :value="0">不需要 </a-select-option>
                                                </a-select>
                                        </a-form-model-item>
                                    </a-col>
                                </a-row>
                            </div>
                            <a-form-model-item prop="release_comment" label="说明" >
                                            <a-textarea placeholder="请输入" v-model="submitForm.release_comment" :rows="4" />
                            </a-form-model-item>
                         </div>
             </a-form-model>
              <p>URL共享</p>
              <a-radio-group v-model="value1">
                <a-radio :value="0">无</a-radio>
                <a-radio :value="1">有</a-radio>
              </a-radio-group>
              <div v-if="value1" class="pst-abs">
                <a-row style="margin-bottom:10px" class="eidt-mb">
                  <span @click="addUrlInputList"
                        class="addFile">
                    <a-icon type="plus" />添加</span>
                </a-row>
                <div v-for="(item, index) in form1.shared_address"
                     :key="index"
                     style="display:flex;margin-bottom:10px">
                  <div style="margin-right: 10px;width:1118px">
                    <a-input addonBefore="地址"
                             v-model="item.value" />
                  </div>
                  <div @click="() => removeUrlInputList(index)"
                       class="delFile"> <span class="iconfont">&#xe64d;</span></div>
                </div>
              </div>

              <a-row style="margin-bottom:10px;margin-top:20px">
                <span>附件 :</span>
                <!-- <span style="color:#F88D49;margin-left:20px;">* 请开发务必上传开发文档！</span> -->
                <span @click="addFileInputList"
                      class="addFile">
                  <a-icon type="plus" />添加</span>
              </a-row>
              <div v-for="(item, index) in fileInputList"
                   :key="index"
                   style="display:flex;margin-bottom:10px">
                <div class="fileInput">
                  <a-input :value="item.name"
                           disabled />
                </div>
                <div style="width: 68px;margin-right: 10px;">
                  <a-upload :showUploadList="false"
                            :beforeUpload="(file) => beforeUpload(file, index)">
                    <a-button size="small">选择文件</a-button>
                  </a-upload>
                </div>
                <div @click="() => removeFileInputList(index)"
                     class="delFile"> <span class="iconfont">&#xe64d;</span></div>
              </div>
              <p style="margin-top:20px">备注</p>
              <a-textarea placeholder="请输入备注"   v-model="comment" :rows="4" />
            </div>
            <span slot="footer"
                  class="dialog-footer">
              <el-button @click="cancel(4)">取 消</el-button>
              <el-button type="primary"
                         :loading="btnLoad"
                         @click="ok(4)">确 定</el-button>
            </span>
        </a-modal>
        </div>

        <!-- 撤销提交 -->
        <div class="modal-box">
          <el-dialog title="撤销提交"
                     :visible.sync="dialogVisible5"
                      :close-on-click-modal="false"
                     width="380px">
            <div class="radio_box">
              <p style="color:#F88D49">* 撤回后，回到进行中，相关内容将无法恢复，确认撤销？</p>
              <p>备注</p>
              <el-input type="textarea"
                        :autosize="{ minRows: 3, maxRows: 3}"
                        placeholder="请输入备注"
                        v-model="comment"
                        resize="none">
              </el-input>
            </div>
            <span slot="footer"
                  class="dialog-footer">
              <el-button @click="cancel(5)">取 消</el-button>
              <el-button type="primary"
                         :loading="btnLoad"
                         @click="ok(5)">确 定</el-button>
            </span>
          </el-dialog>
        </div>

        <!-- 暂停 -->
        <div class="modal-box">
          <el-dialog title="暂停"
                      :close-on-click-modal="false"
                     :visible.sync="dialogVisible6"
                     width="380px">
            <div class="radio_box">
              <el-form :model="{comment}"
                       ref="stopForm">
                <p><span>*</span>原因</p>
                <el-form-item :rules="[{ required: true, message: '原因不能为空'} ]"
                              prop="comment">
                  <el-input type="textarea"
                            :autosize="{ minRows: 3, maxRows: 3}"
                            placeholder="请输入暂停原因"
                            v-model="comment"
                            resize="none">
                  </el-input>
                </el-form-item>
              </el-form>
            </div>
            <span slot="footer"
                  class="dialog-footer">
              <el-button @click="cancel(6)">取 消</el-button>
              <el-button type="primary"
                        :loading="btnLoad"
                         @click="ok(6)">确 定</el-button>
            </span>
          </el-dialog>
        </div>

        <!-- 撤销 -->
        <div class="modal-box">
          <el-dialog title="撤销"
                       :close-on-click-modal="false"
                     :visible.sync="dialogVisible7"
                     width="380px">
            <div class="radio_box">
              <el-form :model="{comment}"
                       ref="revocationForm">
                <p><span>*</span>原因</p>
                <el-form-item :rules="[{ required: true, message: '原因不能为空'} ]"
                              prop="comment">
                  <el-input type="textarea"
                            :autosize="{ minRows: 3, maxRows: 3}"
                            placeholder="请输入撤销原因"
                            v-model="comment"
                            resize="none">
                  </el-input>
                </el-form-item>
              </el-form>
            </div>
            <span slot="footer"
                  class="dialog-footer">
              <el-button @click="cancel(7)">取 消</el-button>
              <el-button type="primary"
                        :loading="btnLoad"
                         @click="ok(7)">确 定</el-button>
            </span>
          </el-dialog>
        </div>
        <!-- 分配任务 -->
        <div class="modal-box">
          <a-modal title="指派跟进人"
                     destroyOnClose
                    :maskClosable="false"
                   v-model="dialogVisible8"
                   @cancel="cancel(8)"
                   width="700px">
            <a-form :form="allotForm">
              <div class="radio_box">
                <a-row class="form-row" style="margin-bottom:15px">
                  <a-col :lg="12"
                         :md="12"
                         :sm="24"
                         style="padding-right: 20px">
                    <a-form-item>
                      <span slot="label"> 主要跟进人</span>
                      <!-- <peopleSelect ref="handleMen2"
                                    v-decorator="['user_id', { rules: [{ required: true, message: '请选择处理人' }] }]"
                                    @getValue2="getChargeValue2"></peopleSelect> -->
                     <!-- <a-select placeholder="请选择跟进人"
                         showSearch
                         optionFilterProp="children"
                         v-decorator="['user_id', { rules: [{ required: true, message: '请选择跟进人' }] }]"
                       >
                            <a-select-option v-for="item in options3"
                                :key="item.id">{{item.name}}</a-select-option>
                    </a-select> -->
                    <allPersonSelect :autoFocus="false"
                                    @getSelectValue="handleModalSearch"
                                    :selectValue="followerModalID"
                                    :searchData="followerModalArr"
                                    ref="followerModalRef"
                                    placeholder="请选择跟进人(请输入英文名搜索)"
                                    v-decorator="['user_id', { rules: [{ required: true, message: '请选择跟进人' }] }]"
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
                                     v-decorator="['expiration_date', { rules: [{ required: true, message: '请选择截止时间' }] }]"
                                     type="date"
                                     placeholder="选择日期">
                      </a-date-picker>
                      <span v-if="allotForm.getFieldValue('expiration_date')" style="margin-left:10px">
                           还剩<span style="color:#F88D49"> {{moment(allotForm.getFieldValue('expiration_date')).diff(moment().startOf('day'), 'day')}} </span>天
                      </span>
                    </a-form-item>
                  </a-col>
                </a-row>
                <a-form-item label="任务分工要求">
                  <a-textarea v-decorator="['comment']"
                              style="margin-bottom: -5px;"
                              :autosize="{ minRows: 3, maxRows: 3}"
                              placeholder="请输入任务分工要求"
                              resize="none">
                  </a-textarea>
                </a-form-item>
              </div>
            </a-form>
            <span slot="footer"
                  class="dialog-footer">
              <el-button @click="cancel(8)">取 消</el-button>
              <el-button type="primary"
                         :loading="btnLoad"
                         @click="ok(8)">确 定</el-button>
            </span>
          </a-modal>
        </div>

        <!-- 设计走查 -->
          <a-modal title="设计走查"
                    class="modal-pms"
                  :maskClosable="false"
                   v-model="dialogVisible9"
                   width="700px">
            <a-form :form="designForm">
              <div class="radio_box">
                <p><span>*</span>走查结果</p>
                <div class="marginB20">
                  <el-radio v-model="radio4"
                            :label="0">无差异</el-radio>
                  <el-radio v-model="radio4"
                            :label="1">差异已调整</el-radio>
                  <el-radio v-model="radio4"
                            :label="2">差异未全部调整</el-radio>
                </div>
              </div>
              <div class="radio_box">
                <a-form-item>
                  <p class="marginB10"><span style="color:red">*</span> 备注：</p>
                  <a-textarea v-decorator="['review_comment', { rules: [{ required: true, message: '请输入备注' }] }]"
                              :autosize="{ minRows: 3, maxRows: 3}"
                              placeholder="请输入备注"
                              resize="none">
                  </a-textarea>
                </a-form-item>
                <a-row style="margin-bottom:10px;margin-top:20px">
                  <span>附件 :</span>
                  <span @click="addFileInputList"
                        class="addFile">
                    <a-icon type="plus" />添加</span>
                </a-row>
                <div v-for="(item, index) in fileInputList"
                     :key="index"
                     style="display:flex;margin-bottom:10px">
                  <div class="fileInput">
                    <a-input :value="item.name"
                             disabled />
                  </div>
                  <div style="width: 68px;margin-right: 10px;">
                    <a-upload :showUploadList="false"
                              :beforeUpload="(file) => beforeUpload(file, index)">
                      <a-button size="small">选择文件</a-button>
                    </a-upload>
                  </div>
                  <div @click="() => removeFileInputList(index)"
                       class="delFile"> <span class="iconfont">&#xe64d;</span></div>
                </div>
              </div>
            </a-form>
            <span slot="footer"
                  class="dialog-footer">
              <el-button @click="cancel(9)">取消</el-button>
              <el-button type="primary"
                        :loading="btnLoad"
                         @click="ok(10)">发布</el-button>
            </span>
          </a-modal>

        <!-- 审核弹框 -->
        <div class="modal-box">
          <a-modal title="审核"
                  :maskClosable="false"
                  @ok="ok(9)"
                  @cancel="cancel(10)"
                  :confirmLoading="btnLoad"
                   v-model="dialogVisible10"
                   width="380px">
            <a-form :form="verifyForm">
              <div class="radio_box">
                <p><span>*</span>设计类型</p>
                <div class="radio_box_button">
                  <el-radio v-model="radio3"
                            :label="0">分阶段设计</el-radio>
                  <el-radio v-model="radio3"
                            :label="1">同时设计</el-radio>
                  <el-radio v-model="radio3"
                            :label="2">设计优先</el-radio>
                </div>
              </div>
              <div class="radio_box">
                  <p><span>*</span>参与角色：</p>
                <a-form-item >
                  <a-checkbox-group v-decorator="[  'parts',{ rules: [{ required: true, message: '请至少选择一个参与角色' }] },]">
                          <a-col :span="6">
                            <a-checkbox :value="0">
                              交互
                            </a-checkbox>
                          </a-col>
                          <a-col :span="6">
                            <a-checkbox :value="1">
                              视觉
                            </a-checkbox>
                          </a-col>
                          <a-col :span="6">
                              <a-checkbox :value="2">
                              美工
                            </a-checkbox>
                          </a-col>
                          <a-col :span="6">
                              <a-checkbox :value="3">
                              前端
                            </a-checkbox>
                          </a-col>
                          <a-col :span="6">
                            <a-checkbox :value="4">
                              移动端
                            </a-checkbox>
                          </a-col>
                  </a-checkbox-group>
                </a-form-item>
              </div>
            </a-form>
          </a-modal>
        </div>
        <!-- 更改审核 -->
        <div class="modal-box">
          <a-modal title="更改设计环节顺序"
                  :maskClosable="false"
                  @ok="ok(11)"
                  @cancel="cancel(11)"
                  :confirmLoading="btnLoad"
                   v-model="dialogVisible11"
                   width="380px">
            <a-form :form="verifyForm2">
              <div class="radio_box">
                <p><span>*</span>设计类型</p>
                <div class="radio_box_button">
                  <el-radio v-model="radio3_1"
                            :label="0">分阶段设计</el-radio>
                  <el-radio v-model="radio3_1"
                            :label="1">同时设计</el-radio>
                  <el-radio v-model="radio3_1"
                            :label="2">设计优先</el-radio>
                </div>
              </div>
              <div class="radio_box">
                <a-form-item>
                  <p><span>*</span>参与角色：</p>
                  <a-checkbox-group v-decorator="[  'parts',{ rules: [{ required: true, message: '请至少选择一个参与角色' }] },]" >
                          <a-col :span="6" style="line-height: 1;padding-bottom: 10px;">
                            <a-checkbox :value="0">
                              交互
                            </a-checkbox>
                          </a-col>
                          <a-col :span="6" style="line-height: 1;padding-bottom: 10px;">
                            <a-checkbox :value="1">
                              视觉
                            </a-checkbox>
                          </a-col>
                          <a-col :span="6" style="line-height: 1;padding-bottom: 10px;">
                              <a-checkbox :value="2">
                              美工
                            </a-checkbox>
                          </a-col>
                          <a-col :span="6" style="line-height: 1;padding-bottom: 10px;">
                              <a-checkbox :value="3">
                              前端
                            </a-checkbox>
                          </a-col>
                          <a-col :span="6">
                            <a-checkbox :value="4">
                              移动端
                            </a-checkbox>
                          </a-col>
                  </a-checkbox-group>
                </a-form-item>
              </div>
            </a-form>
          </a-modal>
        </div>
        <!-- 任务详情 -->

        <a-drawer width="1100"
                  placement="right"
                  :closable="true"
                   class="modal-pms"
                  @close="onClose"
                  :visible="taskDetails">
           <div slot="title" class="top-title">任务基本信息
                <a-dropdown :trigger="['click']"
                    placement='bottomCenter'>
                     <!-- v-if="taskMsg.policies.update || taskMsg.policies.verify || taskMsg.policies.sequence || taskMsg.policies.review" -->
                <div class="operation">
                    <i class="icon iconfont">&#xe632;</i>
                    <span class="cz">操作</span>
                    <i class="line"></i>
                </div>
                <a-menu slot="overlay"
                        style="min-width:120px;text-align:left;max-height:250px;overflow-y:auto;">
                    <a-menu-item  v-if="taskMsg.policies.update">
                        <a   @click="goEdit(taskMsg)"><span class="iconfont fz12">&#xe637;</span>编辑任务</a>
                    </a-menu-item>
                     <a-menu-item  v-if="taskMsg.policies.verify">
                        <a   @click="dialogVisible10=true,taskId=taskMsg.id"><span class="iconfont fz12">&#xe63d;</span>审核</a>
                    </a-menu-item>
                     <a-menu-item  v-if="taskMsg.policies.sequence">
                        <a   @click="sequence(taskMsg)"><span class="iconfont fz12" style="color:rgba(254, 188, 46, 1)">&#xe63d;</span>更改设计环节顺序</a>
                    </a-menu-item>
                    <a-menu-item  v-if="taskMsg.policies.review">
                        <a   @click="dialogVisible9=true,taskId=taskMsg.id"><span class="iconfont fz12">&#xe648;</span>设计走查</a>
                    </a-menu-item>
                   <a-menu-item  v-if="!taskMsg.policies.update && !taskMsg.policies.verify && !taskMsg.policies.sequence && !taskMsg.policies.review" class="tac">
                        <a >暂无操作</a>
                    </a-menu-item>
                </a-menu>
                </a-dropdown>
              </div>
          <div class="content">
             <div class="top">
                            <span class="text-p-overflow dept" :title="taskMsg.title" style="max-width:422px">{{taskMsg.title}}</span>
                            <i class="line" v-if="taskMsg.title"></i>
                            <span>
                                <span class="button_box_text"
                                v-if="taskMsg.priority===1"
                                >{{taskMsg.priority}}</span>
                                <span class="button_box_text button_box_color2"
                                    v-if="taskMsg.priority===2"
                                    >{{taskMsg.priority}}</span>
                                <span class="button_box_text button_box_color3"
                                    v-if="taskMsg.priority===3"
                                    >{{taskMsg.priority}}</span>
                                <span class="button_box_text button_box_color4"
                                    v-if="taskMsg.priority===4"
                                    >{{taskMsg.priority}}</span>
                                <span class="button_box_text button_box_color5"
                                    v-if="taskMsg.priority===5"
                                    >{{taskMsg.priority}}</span>
                            </span>
                            <i class="line" v-if="taskMsg.priority"></i>
                            <span>{{taskMsg.number}}</span>
                            <i class="line"></i>
                            <span><span style="color:#bbb">创建人:  </span> {{taskMsg.promulgator_name}}</span>
                            <i class="line"></i>
                            <span>{{taskMsg.created_at}}</span>
                            <i class="line"></i>
                            <span><span style="color:#bbb">主负责人:  </span> {{taskMsg.principal_user_name ? taskMsg.principal_user_name : '--'}}</span>
                            <i class="line"></i>
                            <span class="status">
                                <span  v-if="taskMsg.status_desc=='待审核'"><span style="color:#FF4A4A;" class="iconfont fz13">&#xe654;</span> {{taskMsg.status_desc}}</span>
                                <span  v-if="taskMsg.status_desc=='待指派'"><span style="color:#FF4A4A;" class="iconfont fz13">&#xe654;</span> {{taskMsg.status_desc}}</span>
                                <span  v-if="taskMsg.status_desc=='等待中'"><span style="color:#FF4A4A;" class="iconfont fz13">&#xe654;</span> {{taskMsg.status_desc}}</span>
                                <span  v-if="taskMsg.status_desc=='未开始'"><span style="color:#FEBC2E;" class="iconfont fz13">&#xe654;</span> {{taskMsg.status_desc}}</span>
                                <span  v-if="taskMsg.status_desc=='进行中'"><span style="color:#FEBC2E;" class="iconfont fz13">&#xe654;</span> {{taskMsg.status_desc}}</span>
                                <span  v-if="taskMsg.status_desc=='已提交'"><span style="color:#FEBC2E;" class="iconfont fz13">&#xe653;</span> {{taskMsg.status_desc}}</span>
                                <span  v-if="taskMsg.status_desc=='已暂停'"><span style="color:#FEBC2E;" class="iconfont fz13">&#xe654;</span> {{taskMsg.status_desc}}</span>
                                <span  v-if="taskMsg.status_desc=='已完成'"><span style="color:#3DCCA6;" class="iconfont fz13">&#xe653;</span> {{taskMsg.status_desc}}</span>
                                <span  v-if="taskMsg.status_desc=='已撤销'"><span style="color:#BBBBBB;" class="iconfont fz13">&#xe654;</span> {{taskMsg.status_desc}}</span>
                            </span>
            </div>
            <div class="con">
                        <a-tabs type="card" v-model="activeKey">
                                <a-tab-pane key="1">
                                    <span slot="tab" class="tab">
                                        <i class="tabs-ico"></i> 主要信息
                                    </span>
                                    <div style="margin-bottom:20px">
                                        <span class="left">任务性质:</span>
                                        <span class="right">
                                            <span v-if="taskMsg.demand">需求任务/设计</span>
                                            <span v-else>内部任务</span>
                                        </span>
                                    </div>
                                    <div style="margin-bottom:20px">
                                        <span class="left">项目来源:</span>
                                        <span class="right">
                                            <span v-if="taskMsg.project">
                                                {{taskMsg.project.number}}
                                            </span>
                                            <span v-else>--</span>
                                        </span>
                                    </div>
                                    <div style="margin-bottom:20px;display:flex;" >
                                        <span class="left">产品分类:</span>
                                        <span  class="right">
                                            <a-popover placement="bottomLeft"
                                                style="cursor: pointer;"
                                                v-if="taskMsg.product_category"
                                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                                                arrowPointAtCenter>
                                                <template slot="content"
                                                            >
                                                    <div>
                                                        <p v-for="(its,ind) in taskMsg.product_category.product_modules"
                                                            :key="ind"
                                                            >
                                                            {{taskMsg.product_category.product_line.name}}/{{taskMsg.product_category.product.name}}/{{its.name}}
                                                        <span v-if="its.product_labels.length">
                                                                (<span v-for="(label,index) in its.product_labels" :key="index"> {{label.name}} <span v-if="index!==its.product_labels.length-1">,</span></span>)
                                                        </span>
                                                        </p>
                                                        <p v-if="taskMsg.product_category.product_modules.length===0">
                                                                {{taskMsg.product_category.product_line.name}}/{{taskMsg.product_category.product.name}}
                                                        </p>
                                                    </div>
                                                </template>
                                                <p class="text-p text-p-overflow2" style="max-width:230px;height:14px">{{taskMsg.product_category.product_line.name}}/{{taskMsg.product_category.product.name}} <span style="color:#666;font-size: 12px;" v-if="taskMsg.product_category.product_modules.length >0">{{'/'+ taskMsg.product_category.product_modules[0].name}}</span> </p>
                                            </a-popover>
                                            <span v-if="!taskMsg.product_category">
                                                --
                                            </span>
                                        </span>

                                    </div>
                                    <div>
                                        <span class="left">总任务截止时间:</span>
                                        <span class="right">{{taskMsg.expiration_date ? taskMsg.expiration_date : '--'}}</span>
                                    </div>
                                    <div class="con">
                                        <h3 style="font-weight:bold;margin-bottom:10px"><i class="tabs-ico"></i> 描述信息</h3>
                                        <div v-if="taskMsg.demand">
                                            <p style="margin-bottom:10px;">需求描述:</p>
                                            <div style="margin-bottom: 20px;" v-if="taskMsg.demand">
                                                <router-link :to="{ name: 'demandDetails', query: { id: taskMsg.demand.id }}" target="_blank" style="color:#378EEF;">{{taskMsg.demand.number}} {{taskMsg.demand.name}}</router-link>
                                            </div>
                                        </div>
                                        <div v-if="taskMsg.demand">
                                             <p style="margin-bottom:10px;">产品备注:</p>
                                             <span v-if="taskMsg.demand.demand_links && taskMsg.demand.demand_links.length">{{taskMsg.demand.demand_links[0].comment}}</span>
                                        </div>
                                        <div v-if="!taskMsg.demand">
                                             <p style="margin-bottom:10px">任务描述:</p>
                                            <myViewer :html="taskMsg.content"></myViewer>
                                        </div>
                                    </div>
                                    <div class="con">
                                        <h3 style="font-weight:bold;margin-bottom:10px"><i class="tabs-ico"></i> 其他信息</h3>
                                        <div v-if="!taskMsg.demand">
                                            <p style="margin-bottom:10px;">URL/共享:<span v-if="!taskMsg.share_address" style="margin-left:20px">暂无数据</span></p>
                                            <div style="margin-bottom: 20px;">
                                                <div  v-if="taskMsg.share_address">
                                                    <p v-for="(url,index) in JSON.parse(taskMsg.share_address)" :key="index" style="margin-bottom:10px">
                                                        <span style="color:#bbb;margin-right:10px" v-if="url.name">{{url.name}}:</span>
                                                        <a :href="url.value" target="_blank" style="word-break: break-all;">{{url.value}}</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <p style="margin-top:20px;margin-bottom:10px">
                                                附件:<span v-if="taskMsg.media.length>0" @click="mediaShow=!mediaShow" style="margin-left:20px" class="cup">
                                                        <span v-if="mediaShow">收起 <span class="icon iconfont cup">&#xe607;</span></span>
                                                        <span v-else>展开 <span class="icon iconfont cup">&#xe605;</span></span>
                                                </span>
                                                <span v-else style="margin-left:20px">暂无数据</span>
                                            </p>
                                            <downMedia :media="taskMsg.media"
                                                        v-show="mediaShow"
                                                        v-if="taskMsg.media.length>0"
                                            ></downMedia>
                                        </div>
                                        <div v-else>
                                            <p style="margin-bottom:10px;">URL/共享:<span v-if="!taskMsg.demand.share_address" style="margin-left:20px">暂无数据</span></p>
                                            <div style="margin-bottom: 20px;">
                                                <div  v-if="taskMsg.demand.share_address">
                                                    <p v-for="(url,index) in taskMsg.demand.share_address" :key="index" style="margin-bottom:10px">
                                                        <a :href="url" target="_blank" style="word-break: break-all;color:">{{url}}</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <p style="margin-top:20px;margin-bottom:10px">
                                                附件:<span v-if="taskMsg.demand.media.length>0" @click="mediaShow=!mediaShow" style="margin-left:20px" class="cup">
                                                        <span v-if="mediaShow">收起 <span class="icon iconfont cup">&#xe607;</span></span>
                                                        <span v-else>展开 <span class="icon iconfont cup">&#xe605;</span></span>
                                                </span>
                                                <span v-else style="margin-left:20px">暂无数据</span>
                                            </p>
                                            <downMedia :media="taskMsg.demand.media"
                                                        v-show="mediaShow"
                                                        v-if="taskMsg.demand.media.length>0"
                                            ></downMedia>
                                        </div>

                                    </div>
                                </a-tab-pane>
                                <a-tab-pane key="2">
                                    <span slot="tab"  class="tab">
                                        <i class="tabs-ico"></i> 任务情况
                                    </span>
                                    <div v-for="(part,index) in taskMsg.parts" :key="index" class="marginB20">
                                        <div class="header">
                                        <i class="iconfont fz12 pdR10 cup" v-if="!part.open" @click="part.open=!part.open">&#xe650;</i>
                                        <i class="iconfont fz12 pdR10 cup" v-else @click="part.open=!part.open">&#xe642;</i>
                                        <span class="pdR10">
                                            <span v-if="part.type===0">交互负责人</span>
                                            <span v-if="part.type===1">视觉负责人</span>
                                            <span v-if="part.type===2">美工负责人</span>
                                            <span v-if="part.type===3">前端负责人</span>
                                            <span v-if="part.type===4">移动端负责人</span>
                                        :</span>
                                        <span>{{part.principal_user_name}}</span>
                                        <span class="pdR10" style="margin-left:90px">任务ID:</span><span>{{part.number}}</span>
                                    </div>
                                    <div class="subtask" v-if="part.open">
                                        <div  v-for="(task,index) in part.subtasks" :key="index" style="padding:30px 0" :style="{'border-bottom': index === part.subtasks.length-1 ? '0' : '1px solid #EBF3FD' }">
                                            <div class="marginB20">
                                                <span class="main cup"
                                                    :style="{color: task.is_main ? 'rgba(61, 204, 166, 1)' : 'rgba(254, 188, 46, 1)', background:task.is_main ? 'rgba(61, 204, 166, .2)' : 'rgba(254, 188, 46, .2)'}"
                                                    >{{task.is_main ? '主' :'次' }}</span>
                                                <span style="font-weight:bold">{{task.is_main ? '主要跟进人:' :'次要跟进人:'}}</span>
                                                <span style="margin-left:10px;font-weight:bold">{{task.handler_name}}</span>
                                                <span class="icon iconfont cup"
                                                    title="信息更新"
                                                    v-if="task.policies.submitUpdate"
                                                    style="margin-left:10px;color:rgba(55, 142, 239, 1)"
                                                    @click="submitModal(task,2)">&#xe645;</span>
                                                 <span class="icon iconfont cup"
                                                    title="更改版本信息"
                                                    v-if="task.policies.updateVersion"
                                                    style="margin-left:10px;color:rgba(55, 142, 239, 1)"
                                                    @click="editVersonModal(task)"> &#xe723;</span>
                                            </div>
                                            <div class="marginB20" style="display:flex">
                                                <div style="flex:1" >
                                                    <span class="left-txt">任务状态:</span>
                                                    <span style="color:#FF4A4A;" v-if="task.status_desc=='待审核'">{{task.status_desc}}</span>
                                                    <span style="color:#FF4A4A;" v-if="task.status_desc=='待指派'">{{task.status_desc}}</span>
                                                    <span style="color:#FF4A4A;" v-if="task.status_desc=='等待中'">{{task.status_desc}}</span>
                                                    <span style="color:#FEBC2E;" v-if="task.status_desc=='未开始'">{{task.status_desc}}</span>
                                                    <span style="color:#FEBC2E;" v-if="task.status_desc=='进行中'">{{task.status_desc}}</span>
                                                    <span style="color:#FEBC2E;" v-if="task.status_desc=='已提交'">{{task.status_desc}}</span>
                                                    <span style="color:#FEBC2E;" v-if="task.status_desc=='已暂停'">{{task.status_desc}}</span>
                                                    <span style="color:#3DCCA6;" v-if="task.status_desc=='已完成'">{{task.status_desc}}</span>
                                                    <span style="color:#BBBBBB;" v-if="task.status_desc=='已撤销'">{{task.status_desc}}</span>
                                                </div>
                                                <div style="flex:1">
                                                    <span class="left-txt">时间:</span>
                                                     <a-popover placement="bottomLeft"
                                                        :getPopupContainer="triggerNode => triggerNode.parentNode"
                                                        arrowPointAtCenter>
                                                        <template slot="content">
                                                            <p>
                                                                <span style="margin-right:10px">预计完成时间:</span><span>{{task.expiration_date ? task.expiration_date : '--'}}</span>
                                                            </p>
                                                             <p >
                                                                <span style="margin-right:10px">实际完成时间:</span><span>{{task.finish_time ? task.finish_time : '--'}}</span>
                                                            </p>
                                                             <p>
                                                                <span style="margin-right:10px">预计消耗时间:</span>
                                                                <span v-if="task.expect_finish_days">{{task.expect_finish_days}}天</span>
                                                                <span v-else>--</span>
                                                            </p>
                                                             <p>
                                                                <span style="margin-right:10px">实际消耗时间:</span>
                                                                <span v-if="task.fact_finish_days">{{task.fact_finish_days}}天</span>
                                                                <span v-else>--</span>
                                                            </p>
                                                        </template>
                                                        <span class="iconfont fz12 cup" style="color: #378EEF">&#xe6fa;</span>
                                                    </a-popover>
                                                </div>
                                                <div style="flex:1">
                                                    <span class="left-txt">附件:</span>
                                                    <a-popover placement="bottomLeft"
                                                        v-if="taskMsg.review_media.length>0 && task.handler_id === taskMsg.reviewer_id"
                                                        :getPopupContainer="triggerNode => triggerNode.parentNode"
                                                        arrowPointAtCenter>
                                                        <template slot="content">
                                                            <div class="download-list">
                                                                <p>设计走查附件</p>
                                                                <downPrd :media="taskMsg.review_media"
                                                                        style="margin-bottom:-10px"
                                                                        :span="24"></downPrd>
                                                            </div>
                                                        </template>
                                                        <span class="iconfont fz12 cup" style="color: #378EEF">&#xe656;</span>
                                                    </a-popover>
                                                     <a-popover placement="bottomLeft"
                                                        v-else-if="task.media.length>0"
                                                        :getPopupContainer="triggerNode => triggerNode.parentNode"
                                                        arrowPointAtCenter>

                                                        <template slot="content">
                                                            <div class="download-list">
                                                                <p>提交附件</p>
                                                                <downPrd :media="task.media"
                                                                        style="margin-bottom:-10px"
                                                                        :span="24"></downPrd>
                                                            </div>
                                                        </template>
                                                        <span class="iconfont fz12 cup" style="color: #378EEF">&#xe656;</span>
                                                    </a-popover>
                                                    <span v-else>--</span>
                                                </div>
                                            </div>
                                            <div class="marginB20" style="display:flex">
                                                <span class="left-txt">URL/共享:</span>
                                                <span v-if="task.share_address">
                                                     <p v-for="(url,index) in JSON.parse(task.share_address)" :key="index"  :style="{'margin-top':index ? '10px' : '0px'}">
                                                        <a :href="url" style="word-break: break-all;color: #378EEF;" target="_blank">{{url}}</a>
                                                    </p>
                                                </span>
                                                <span v-else>--</span>
                                            </div>
                                            <div>
                                                <span class="left-txt">提交备注:</span>
                                                <span>{{task.submit_comment ? task.submit_comment : '--'}}</span>
                                            </div>
                                            <div style="display:flex;margin-top:20px" v-if="part.type===4">
                                                <span class="left-txt">发版信息:</span>
                                                <span v-if="task.version">
                                                    <p>{{task.version.product.name}} ({{task.version.full_version}})</p>
                                                    <p>{{task.branch_name}}</p>
                                                    <p>{{task.has_sql ? '有SQL' : '无SQL'}}</p>
                                                    <p>{{task.stress_test ? '需要压力测试' : '无需压力测试'}}</p>
                                                </span>
                                                <span v-else>--</span>
                                            </div>
                                            <div v-if="part.type===0 || part.type===1">
                                                <div style="margin-top:20px" v-if="task.handler_id === taskMsg.reviewer_id || task.principal_user_id === taskMsg.reviewer_id">
                                                    <span class="left-txt" style="vertical-align: middle;">走查结果:</span>
                                                    <span>
                                                        <img src="../../../assets/images/review-result-0.png" v-if="taskMsg.review_result===0">
                                                        <img src="../../../assets/images/review-result-1.png" v-if="taskMsg.review_result===1">
                                                        <img src="../../../assets/images/review-result-2.png" v-if="taskMsg.review_result===2">
                                                    </span>
                                                </div>
                                                <div style="margin-top:20px" v-if="task.handler_id === taskMsg.reviewer_id || task.principal_user_id === taskMsg.reviewer_id">
                                                    <span class="left-txt">走查备注:</span>
                                                    <span>{{taskMsg.review_comment ? taskMsg.review_comment  : '--'}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="!part.subtasks.length">
                                            <a-empty :image="simpleImage" description="暂未审核"/>
                                        </div>
                                    </div>
                                    </div>
                                    <div v-if="taskMsg.parts && taskMsg.parts.length===0" style="padding-top:30px">
                                        <a-empty :image="simpleImage" description="暂无数据"/>
                                    </div>

                                </a-tab-pane>
                                <a-tab-pane key="3">
                                    <span slot="tab"  class="tab">
                                        <i class="tabs-ico"></i> 操作记录
                                    </span>
                                    <operationLogs :data="taskMsg.operation_log"></operationLogs>
                                </a-tab-pane>
                            </a-tabs>
                        </div>
          </div>

        </a-drawer>

        <div class="btn-right">
           <a-popover trigger="click" placement="bottomLeft">
                <div slot="content" >
                    <div style="padding:10px 10px 0">
                          <a-radio-group name="radioGroup" v-model="excelRadio">
                            <a-radio :value="1">
                            设计任务信息表
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
                    v-if="canDo('pm.tasks.design.store')"
                    @click="releaseTask">
            <a-icon type="plus" />发布任务</a-button>
        </div>

      </div>

    </div>
    <!-- 选择筛选 -->
     <div class="table-list2">
        <div class="table-header" :class="{isFixed:isFixed}" :style="{width:isFixed ? screenWidth+'px' : '100%'}">
            <table>
                <thead>
                    <tr>
                        <th style="width:1.3%" >
                            <span class="iconfont fz12 cup" style="color:#bcbcbc" @click="showAll" v-if="!allOpen">&#xe650;</span>
                            <span class="iconfont fz12 cup" style="color:#bcbcbc" @click="closeAll" v-else>&#xe642;</span>
                        </th>
                        <th style="width:5%">优先级</th>
                        <th style="width:7.5%">任务ID</th>
                        <th style="width:7%">负责人</th>
                        <th style="width:15%">发布信息</th>
                        <th style="width:18%">需求/任务标题</th>
                        <th style="width:17%">产品分类</th>
                        <th style="width:8%">其他环节</th>
                        <th style="width:9%">预计完成时间</th>
                        <th style="width:7%">状态</th>
                        <th style="width:100px">操作</th>
                    </tr>
                  </thead>
            </table>
        </div>
         <a-spin :spinning="loading">
            <div class="table-card" v-for="item in data" :key="item.number">
                <div class="top">
                      <table>
                        <thead>
                            <tr>
                                <th style="width:1.3%" @click="item.open=!item.open">
                                    <span class="iconfont fz12 cup" style="color:#bcbcbc" v-if="!item.open">&#xe650;</span>
                                    <span class="iconfont fz12 cup" style="color:#bcbcbc" v-else>&#xe642;</span>
                                </th>
                                <th style="width:5%">
                                       <div
                                        style="cursor: pointer;"
                                        :class="{button_box: item.policies.priority}"
                                        @click="handbutton(item)">
                                        <span>
                                            <span class="button_box_text"
                                            v-if="item.priority===1"
                                            >{{item.priority}}</span>
                                            <span class="button_box_text button_box_color2"
                                                v-if="item.priority===2"
                                                >{{item.priority}}</span>
                                            <span class="button_box_text button_box_color3"
                                                v-if="item.priority===3"
                                                >{{item.priority}}</span>
                                            <span class="button_box_text button_box_color4"
                                                v-if="item.priority===4"
                                                >{{item.priority}}</span>
                                            <span class="button_box_text button_box_color5"
                                                v-if="item.priority===5"
                                                >{{item.priority}}</span>
                                            <span v-if="!item.priority">--</span>
                                            <span class="iconfont tips" style="display:none">&#xe6fe;</span>
                                        </span>
                                        <a-select style="width: 80px"
                                                :value="item.priority"
                                                autoFocus
                                                @focus="handleFocus"
                                                @blur="handleBlur(item)"
                                                @change="handleChange($event,item)"
                                                :defaultOpen="true"
                                                v-if="item.select">
                                            <a-select-option :value="1"><span class="button_box_text"> 1</span><span class="after" style="color:#FF4A4A;float:right">高</span></a-select-option>
                                            <a-select-option :value="2"><span class="button_box_text button_box_color2"> 2</span></a-select-option>
                                            <a-select-option :value="3"><span class="button_box_text button_box_color3"> 3</span></a-select-option>
                                            <a-select-option :value="4"><span class="button_box_text button_box_color4"> 4</span></a-select-option>
                                            <a-select-option :value="5"><span class="button_box_text button_box_color5"> 5</span><span class="after" style="color:#BBBBBB;float:right">低</span></a-select-option>
                                        </a-select>

                                    </div>
                                </th>
                                <th style="width:7.5%">{{item.number}}</th>
                                <th style="width:7%">
                                    <!-- 点击修改负责人 -->
                                    <div @click="showpeopleSelect(item)">
                                        <a-select    placeholder="请选择负责人"
                                                    style="width:95px"
                                                    :value="principal_user"
                                                    showSearch
                                                    optionFilterProp="children"
                                                    v-if="item.peopleSelect"
                                                    autoFocus
                                                    @change="handleChange2($event,item)"
                                                    @blur="handleBlur2(item)"
                                            >
                                            <a-select-option v-for="user in options4"
                                                            :key="user.team_id">
                                                <a-popover placement="right"
                                                    style="cursor: pointer;"
                                                        arrowPointAtCenter>
                                                    <template slot="content"
                                                                >
                                                        <div>
                                                            <p> 交互 : {{user.members.interaction ? user.members.interaction : "--"}} </p>
                                                            <p> 视觉 : {{user.members.vision ? user.members.vision : "--"}} </p>
                                                            <p> 前端 : {{user.members.frontend ? user.members.frontend : '--'}} </p>
                                                            <p> 移动端 : {{user.members.mobile ? user.members.mobile : '--'}} </p>
                                                            <p> 美工 : {{user.members.artist ? user.members.artist : '--'}} </p>
                                                        </div>
                                                    </template>
                                                    <p style="width:110%">{{user.user_name}}</p>
                                                </a-popover>

                                            </a-select-option>
                                        </a-select>
                                        <span :class="{'hover-hand': item.policies.principal}">
                                                 <span class="text"
                                                v-if="!item.peopleSelect">{{item.principal_user_name ? item.principal_user_name : '--'}}</span>
                                                <span class="iconfont tips" style="display:none">&#xe6fe;</span>
                                            </span>
                                    </div>

                                </th>
                                <th style="width:15%">
                                     <p v-if="item.demand" style="margin-bottom:4px">
                                        <router-link :to="{ name: 'demandDetails', query: { id: item.demand.id }}" target="_blank" style="color:#378EEF;" class="text-p-overflow" :title="item.demand.name">{{item.demand.number}}</router-link>
                                        <span class="task-type-1">需求任务</span>
                                    </p>
                                    <p v-else style="margin-bottom:4px">
                                        <span class="task-type-2">内部任务</span>
                                    </p>
                                    {{item.promulgator_name}} / {{item.created_at}}
                                </th>
                                <th style="width:18%">

                                    <div>
                                        <span class="version-tag-1" v-if="item.stress_test">压测</span>
                                        <span  v-for="(k,index) in item.task_versions" :key="index">
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
                                                                        <span class="right-details">{{k.product.name}}({{k.full_version}})</span>
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
                                        <span v-if="item.task_versions.length===0">
                                                <span  v-for="(k,index) in item.expected_versions" :key="index">
                                                    <a-popover placement="bottom" >
                                                    <template slot="content">
                                                        <div class="pms-publishing-info">
                                                            <h3>版本信息</h3>
                                                            <div class="details version-details">
                                                                    <div class="marginB10">
                                                                        <span class="left-details">版本号:</span>
                                                                        <span class="right-details">{{k.product.name}}({{k.full_version}})</span>
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
                                    <span v-if="item.demand">
                                         <p @click="showTask(item)" style="color:#378EEF;" class="text-p-overflow cup" :title="item.demand.name">
                                             <span class="rideo" v-if="item.demand.is_updated &&item.status_desc!=='已完成' && item.status_desc!=='已驳回' && item.status_desc!=='已撤销'"></span>
                                             {{item.demand.name}}</p>
                                    </span>
                                   <p @click="showTask(item)" style="color:#378EEF;" class="text-p-overflow cup" :title="item.title">{{item.title}}</p>
                                   <p @click="showTask(item)" class="cup"  style="color:#378EEF;" v-if="!item.title && !item.demand">--</p>
                                </th>
                                <th style="width:17%">
                                      <a-popover placement="bottomLeft"
                                                style="cursor: pointer;"
                                                v-if="item.product_category"
                                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                                                arrowPointAtCenter>
                                        <template slot="content"
                                                    >
                                                <div>
                                                    <p>{{item.product_category.product_line.name}} </p>
                                                </div>
                                        </template>
                                        <p class="text-p text-p-overflow2"  style="max-width:230px;margin-bottom:4px;height:14px">{{item.product_category.product_line.name}}</p>
                                        <br>
                                    </a-popover>
                                    <a-popover placement="bottomLeft"
                                                style="cursor: pointer;"
                                                v-if="item.product_category"
                                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                                                arrowPointAtCenter>
                                    <template slot="content"
                                                >
                                        <div>
                                            <p v-for="(its,ind) in item.product_category.product_modules"
                                                :key="ind"
                                                >
                                                {{item.product_category.product.name}}/{{its.name}}
                                            <span v-if="its.product_labels.length">
                                                    (<span v-for="(label,index) in its.product_labels" :key="index"> {{label.name}} <span v-if="index!==its.product_labels.length-1">,</span></span>)
                                            </span>
                                            </p>
                                            <p v-if="item.product_category.product_modules.length===0" >
                                                    {{item.product_category.product.name}}
                                            </p>
                                        </div>
                                    </template>
                                    <p class="text-p text-p-overflow2" style="max-width:230px;height:14px">{{item.product_category.product.name}} <span style="color:#666;font-size: 12px;" v-if="item.product_category.product_modules.length >0">{{'/'+ item.product_category.product_modules[0].name}}</span> </p>
                                    </a-popover>

                                </th>
                                <th style="width:8%">
                                   <span class="cup" style="color:#378EEF" v-if="item.demand_id" @click="showAllTask(item.demand_id)">查看</span>
                                    <span v-else>--</span>
                                </th>
                                <th style="width:9%">
                                    <div
                                            class="cup"
                                            @click="showDateSelect(item)">
                                            <a-date-picker
                                                v-if="item.dateSelect"
                                                style="width:120px"
                                                :disabledDate="disabledDate"
                                                @change="changeDate($event,item)"
                                              @openChange="blurDate($event,item)"/>
                                            <span :class="{'hover-hand': item.policies.expirationDate}">
                                                 <span class="text"
                                                v-if="!item.dateSelect">{{item.expiration_date ? item.expiration_date : '--'}}</span>
                                                <span class="iconfont tips" style="display:none">&#xe6fe;</span>
                                            </span>
                                        </div>
                                </th>
                                <th style="width:7%">
                                     <span class="cup status"  @click="getLogs(item)">
                                            <span  v-if="item.status_desc=='待审核'" title="点击查看状态详情"><span style="color:#FF4A4A;" class="iconfont fz13">&#xe654;</span> {{item.status_desc}}</span>
                                            <span  v-if="item.status_desc=='待指派'" title="点击查看状态详情"><span style="color:#FF4A4A;" class="iconfont fz13">&#xe654;</span> {{item.status_desc}}</span>
                                            <span  v-if="item.status_desc=='等待中'" title="点击查看状态详情"><span style="color:#FF4A4A;" class="iconfont fz13">&#xe654;</span> {{item.status_desc}}</span>
                                            <span  v-if="item.status_desc=='未开始'" title="点击查看状态详情"><span style="color:#FEBC2E;" class="iconfont fz13">&#xe654;</span> {{item.status_desc}}</span>
                                            <span  v-if="item.status_desc=='进行中'" title="点击查看状态详情"><span style="color:#FEBC2E;" class="iconfont fz13">&#xe654;</span> {{item.status_desc}}</span>
                                            <span  v-if="item.status_desc=='已提交'" title="点击查看状态详情"><span style="color:#FEBC2E;" class="iconfont fz13">&#xe653;</span> {{item.status_desc}}</span>
                                            <span  v-if="item.status_desc=='已暂停'" title="点击查看状态详情"><span style="color:#FEBC2E;" class="iconfont fz13">&#xe654;</span> {{item.status_desc}}</span>
                                             <a-popover placement="bottomLeft"
                                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                                                arrowPointAtCenter>
                                                <template slot="content">
                                                    <div>
                                                        <!-- 设计走查结果；0：无差异；1：差异已调整；2：差异未全部调整； -->
                                                        <p>走查结果:
                                                            <span v-if="item.review_result===0">无差异</span>
                                                            <span v-if="item.review_result===1">差异已调整</span>
                                                            <span v-if="item.review_result===2">差异未全部调整</span>
                                                        </p>
                                                        <p>备注：{{item.review_comment}}</p>
                                                        <p>{{item.review_name}} {{item.review_time}}</p>
                                                    </div>
                                                </template>
                                            <span  v-if="item.status_desc=='已完成'"><span style="color:#3DCCA6;" class="iconfont fz13">&#xe653;</span> {{item.status_desc}}</span>
                                            </a-popover>
                                            <span  v-if="item.status_desc=='已撤销'" title="点击查看状态详情"><span style="color:#BBBBBB;" class="iconfont fz13">&#xe654;</span> {{item.status_desc}}</span>
                                        </span>
                                </th>
                                <th style="width:100px">
                                     <div class="pro_operate">
                                            <span class="icon iconfont"
                                                title="编辑任务"
                                                style="margin:4px 10px 4px 0"
                                                v-if="item.policies.update"
                                                @click="goEdit(item)">&#xe637;</span>
                                                 <!-- v-if="item.policies.verify" -->
                                            <span class="icon iconfont"
                                                title="审核"
                                                style="margin:4px 10px 4px 0"
                                                v-if="item.policies.verify"
                                                @click="dialogVisible10=true,taskId=item.id">&#xe63d;</span>
                                            <span class="icon iconfont"
                                                title="更改设计环节顺序"
                                                v-if="item.policies.sequence"
                                                style="color:rgba(254, 188, 46, 1);margin:4px 10px 4px 0"
                                                @click="sequence(item)">&#xe63d;</span>
                                             <span class="icon iconfont"
                                                title="设计走查"
                                                style="margin:4px 10px 4px 0"
                                                v-if="item.policies.review"
                                                @click="dialogVisible9=true,taskId=item.id">&#xe648;</span>
                                        </div>
                                        <span class="cup" @click="showTask(item,2)">
                                                    <img src="../../../assets/images/review-result-0.png" v-if="item.review_result===0">
                                                    <img src="../../../assets/images/review-result-1.png" v-if="item.review_result===1">
                                                    <img src="../../../assets/images/review-result-2.png" v-if="item.review_result===2">
                                        </span>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div v-if="item.open" style="border-top: 1px solid rgba(188, 188, 188, .3);padding-bottom:15px">
                    <div v-if="item.subtasks && item.subtasks.length">
                        <table  class="inner-table">
                            <thead>
                                <tr>
                                    <th style="width:1.3%;position: relative" class="tac">
                                             <span class="circular"></span>
                                             <span class="vertical-line-bottom"></span>
                                    </th>
                                    <th style="width:5%">
                                        <span style="color:#F28D49">
                                            <span v-if="item.design_type===0">
                                                分阶段设计
                                            </span>
                                            <span v-if="item.design_type===1">
                                                同时设计
                                            </span>
                                            <span v-if="item.design_type===2">
                                                设计优先
                                            </span>
                                        </span>
                                    </th>
                                    <th style="width:7.5%">任务ID</th>
                                    <th style="width:7%">负责人</th>
                                    <th style="width:15%">跟进人</th>
                                    <th style="width:18%">任务分工要求</th>
                                    <th style="width:17%">操作人备注</th>
                                    <th style="width:8%">完成情况</th>
                                    <th style="width:9%">预计完成时间</th>
                                    <th style="width:7%">状态</th>
                                    <th style="width:100px">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item2,index) in item.subtasks" :key="item2.number">
                                    <td style="width:1.3%;position: relative"
                                        class="tac"
                                        v-if="item2.type || item2.type===0" :rowspan="(item2.type || item2.type===0) ? item2.type_length : '0'"
                                        >
                                            <span class="vertical-line-top" ></span>
                                            <span class="circular"></span>
                                            <span class="vertical-line-bottom" v-if="index!== item.subtasks.length - item2.type_length"></span>
                                    </td>
                                    <!-- v-if="item2.type || item2.type===0" :rowspan="(item2.type || item2.type===0) ? item2.type_length : '0'" -->
                                    <!-- 判断角色类型合并单元格 -->
                                    <td style="width:5%"  v-if="item2.type || item2.type===0" :rowspan="(item2.type || item2.type===0) ? item2.type_length : '0'">
                                        <span style="color:#F28D49">
                                            <span v-if="item2.type===0">
                                                交互
                                            </span>
                                            <span v-if="item2.type===1">
                                                视觉
                                            </span>
                                            <span v-if="item2.type===2">
                                                美工
                                            </span>
                                            <span v-if="item2.type===3">
                                                前端
                                            </span>
                                            <span v-if="item2.type===4">
                                                移动端
                                            </span>
                                            <span   class="iconfont fz12 cup"
                                                    v-if="item2.policies.createSubTask"
                                                    @click="addFollowers(item2.part_id,item2.type)"
                                                    title="添加跟进人" style="color:#378EEF;margin-left:4px">&#xe6fd;</span>
                                        </span>
                                    </td>
                                    <td style="width:7.5%" :class="{'bbb' : item2.status_desc==='已撤销'}">
                                        {{item2.number}}
                                    </td>
                                    <td style="width:7%" :class="{'bbb' : item2.status_desc==='已撤销'}">
                                        {{item2.principal_user_name}}
                                    </td>
                                    <td style="width:15%" :class="{'bbb' : item2.status_desc==='已撤销'}">
                                        <div @click="showHandler(item2)" >
                                            <span class="main cup"
                                                 :title="item2.is_main ? '主要跟进人' :'次要跟进人'"
                                                 :class="{'bgcBBB' : item2.status_desc==='已撤销'}"
                                                 :style="{color: item2.is_main ? 'rgba(61, 204, 166, 1)' : 'rgba(254, 188, 46, 1)', background:item2.is_main ? 'rgba(61, 204, 166, .2)' : 'rgba(254, 188, 46, .2)'}"
                                                 >{{item2.is_main ? '主' :'次' }}</span>
                                            <span :class="{'hover-hand': item2.policies.setPartHandler && item2.is_main}">
                                                <span class="text">{{item2.handler_name}}</span>
                                                <span  class="text" v-if="!item2.handler_name && item2.policies.setPartHandler" style="color: #378EEF;">指派跟进人</span>
                                                <span class="text" v-if="!item2.handler_name && !item2.policies.setPartHandler">--</span>
                                                <span class="iconfont tips" style="display:none">&#xe6fe;</span>
                                            </span>
                                        </div>
                                    </td>
                                    <td style="width:18%" :class="{'bbb' : item2.status_desc==='已撤销'}">
                                         <a-popover placement="bottomLeft"
                                                style="cursor: pointer;"
                                                v-if="item2.description"
                                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                                                arrowPointAtCenter>
                                            <template slot="content"
                                                        >
                                                <div>
                                                    {{item2.description}}
                                                </div>
                                            </template>
                                            <p class="text-p-overflow">
                                                {{item2.description}}
                                            </p>
                                        </a-popover>
                                        <p v-else>--</p>
                                    </td>
                                    <td style="width:17%" :class="{'bbb' : item2.status_desc==='已撤销'}">
                                         <a-popover placement="bottomLeft"
                                                style="cursor: pointer;"
                                                v-if="item2.last_comment"
                                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                                                arrowPointAtCenter>
                                            <template slot="content"
                                                        >
                                                <div>
                                                    {{item2.last_comment}}
                                                </div>
                                            </template>
                                            <p class="text-p-overflow">
                                                {{item2.last_comment}}
                                            </p>
                                        </a-popover>
                                        <p v-else>--</p>
                                    </td>
                                   <td style="width:8%" :class="{'bbb' : item2.status_desc==='已撤销'}">
                                         <span v-if="item2.status_desc!=='待指派' &&item2.status_desc!=='已暂停'">
                                                <span v-if="item2.remaining_days_type==0">
                                                    <span style="color:#F28D49" v-if="item2.remaining_days>0 || item2.remaining_days===0"><span class="iconfont fz13">&#xe65f;</span> 还剩{{item2.remaining_days}}天</span>
                                                    <span style="color:#F28D49;" v-if="item2.remaining_days<0"><span class="iconfont fz13">&#xe65f;</span> 超时{{Math.abs(item2.remaining_days)}}天</span>
                                                </span>
                                                <span v-if="item2.remaining_days_type==1">
                                                    <span style="color:#3DCCA6" v-if="item2.remaining_days>0"><span class="iconfont fz13" >&#xe663;</span> 提前{{item2.remaining_days}}天</span>
                                                    <span style="color:#3DCCA6" v-if="item2.remaining_days===0"><span class="iconfont fz13" >&#xe65e;</span> 按时提交</span>
                                                    <span style="color:#FF4A4A;" v-if="item2.remaining_days<0"><span class="iconfont fz13" >&#xe65d;</span> 超时{{Math.abs(item2.remaining_days)}}天</span>
                                                </span>

                                                <span v-if="item2.remaining_days_type==2">
                                                        <span  v-if="(item2.finish_type==2 && item2.remaining_days>0) || (item2.finish_type==3 && item2.remaining_days<0) || (item2.finish_type==1 && item2.remaining_days==0)|| !item2.finish_type">
                                                            <span style="color:#3DCCA6" v-if="item2.remaining_days>0"><span class="iconfont" style="font-size: 13px;">&#xe663;</span> 提前{{item2.remaining_days}}天</span>
                                                            <span style="color:#3DCCA6" v-if="item2.remaining_days===0"><span class="iconfont" style="font-size: 13px;">&#xe65e;</span> 按时完成</span>
                                                            <span style="color:#FF4A4A;" v-if="item2.remaining_days<0"><span class="iconfont" style="font-size: 13px;">&#xe65d;</span> 超时{{Math.abs(item2.remaining_days)}}天</span>
                                                        </span>
                                                        <span v-else class="cup">
                                                            <!-- 1：按时完成；2：提前完成；3：超时完成 -->
                                                            <a-popover placement="bottomLeft"
                                                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                                                                arrowPointAtCenter>
                                                                <template slot="content">
                                                                    <div>
                                                                        <p>{{item2.difference_reason ? item2.difference_reason : '--'}}</p>
                                                                    </div>
                                                                </template>
                                                                    <span style="color:#3DCCA6"  v-if="item2.finish_type===2"><span class="iconfont" style="font-size: 13px;">&#xe663;</span> 提前完成</span>
                                                                    <span style="color:#3DCCA6"  v-if="item2.finish_type===1"><span class="iconfont" style="font-size: 13px;">&#xe65e;</span> 按时完成</span>
                                                                    <span style="color:#FF4A4A"  v-if="item2.finish_type===3"><span class="iconfont" style="font-size: 13px;">&#xe65d;</span> 超时完成</span>
                                                            </a-popover>
                                                        </span>
                                                </span>
                                        </span>
                                    </td>
                                    <td style="width:9%" :class="{'bbb' : item2.status_desc==='已撤销'}">
                                        <div
                                            class="cup"
                                            @click="showDateSelect(item2)">
                                            <a-date-picker
                                                v-if="item2.dateSelect"
                                                style="width:120px"
                                                :disabledDate="disabledDate"
                                                @change="changeDate($event,item2)"
                                                @openChange="blurDate($event,item2)"/>
                                             <span :class="{'hover-hand': item2.policies.expirationDate}">
                                                 <span class="text"
                                                v-if="!item2.dateSelect">{{item2.expiration_date ? item2.expiration_date : '--'}}</span>
                                                <span class="iconfont tips" style="display:none">&#xe6fe;</span>
                                            </span>
                                        </div>
                                    </td>
                                    <td style="width:7%" :class="{'bbb' : item2.status_desc==='已撤销'}">
                                        <span class="cup status" title="点击查看状态详情" @click="getLogs(item2)">
                                            <span  v-if="item2.status_desc=='待审核'"><span style="color:#FF4A4A;" class="iconfont fz13">&#xe654;</span> {{item2.status_desc}}</span>
                                            <span  v-if="item2.status_desc=='待指派'"><span style="color:#FF4A4A;" class="iconfont fz13">&#xe654;</span> {{item2.status_desc}}</span>
                                            <span  v-if="item2.status_desc=='等待中'"><span style="color:#FF4A4A;" class="iconfont fz13">&#xe654;</span> {{item2.status_desc}}</span>
                                            <span  v-if="item2.status_desc=='未开始'"><span style="color:#FEBC2E;" class="iconfont fz13">&#xe654;</span> {{item2.status_desc}}</span>
                                            <span  v-if="item2.status_desc=='进行中'"><span style="color:#FEBC2E;" class="iconfont fz13">&#xe654;</span> {{item2.status_desc}}</span>
                                            <span  v-if="item2.status_desc=='已提交'"><span style="color:#FEBC2E;" class="iconfont fz13">&#xe653;</span> {{item2.status_desc}}</span>
                                            <span  v-if="item2.status_desc=='已暂停'"><span style="color:#FEBC2E;" class="iconfont fz13">&#xe654;</span> {{item2.status_desc}}</span>
                                            <span  v-if="item2.status_desc=='已完成'"><span style="color:#3DCCA6;" class="iconfont fz13">&#xe653;</span> {{item2.status_desc}}</span>
                                            <span  v-if="item2.status_desc=='已撤销'"><span style="color:#BBBBBB;" class="iconfont fz13">&#xe654;</span> {{item2.status_desc}}</span>
                                        </span>
                                    </td>
                                    <td style="width:100px">
                                        <div  class="pro_operate">
                                            <span class="icon iconfont"
                                                title="开始任务"
                                                v-if="item2.policies.start"
                                                @click="startModal(item2)">&#xe635;</span>
                                            <span class="icon iconfont"
                                                title="验收"
                                                v-if="item2.policies.complete"
                                                @click="completeModal(item2,item)">&#xe647;</span>
                                            <span class="icon iconfont"
                                                title="提交"
                                                v-if="item2.policies.submit"
                                                @click="submitModal(item2,1,item)">&#xe65b;</span>
                                            <span class="icon iconfont"
                                                title="撤销提交"
                                                v-if="item2.policies.submitCancel"
                                                @click="submitCancelModal(item2)">&#xe65c;</span>
                                            <span class="icon iconfont"
                                                title="暂停"
                                                v-if="item2.policies.pause"
                                                @click="stopModal(item2)">&#xe64c;</span>
                                            <span class="icon iconfont"
                                                title="撤销"
                                                v-if="item2.policies.revocation"
                                                @click="revocationModal(item2)">&#xe657;</span>
                                            <!-- <span class="icon iconfont"
                                                title="信息更新"
                                                v-if="item2.policies.submitUpdate"
                                                @click="submitModal(item2,2)">&#xe645;</span> -->
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else>
                        <a-empty :image="simpleImage" description="暂未审核"/>
                    </div>
                </div>
            </div>
            <div style="padding: 20px;background: #fff;" v-if="data.length===0">
                 <a-empty  :image="simpleImage"/>
            </div>
         </a-spin>
        <div style="margin-bottom: 16px">
          <div class="table-eidt"
               style="displa:flex;" :style="{width:screenWidth+'px',height:'64px'}" v-if="data.length>0">
            <a-table
                     :rowKey="(record, index) => record.number"
                     :columns="columns"
                     :pagination="pagination1"
                     @change="changePage"
                     :dataSource="data">
            </a-table>
          </div>

        </div>
      </div>
  </div>
</template>

<script>

import { canDo, filtering, objToFd, removeProperty } from '@/plugins/common'
import { Empty } from 'ant-design-vue'
import moment from 'moment'
import _ from 'lodash'
import myViewer from '@/components/myViewer'
import mySearch from './components/search'
import qs from 'qs'
import addFollower from './components/addFollower'
import allTaskInfo from '@/components/allTaskInfo'
import editVersonModal from './components/editVersionModal'
import downMedia from '@/components/downMedia'
import operationLogs from '@/components/operationLogs'
import downPrd from '@/components/downPrd'
import allPersonSelect from '@/components/allPersonSelect'
import { bus } from '@/plugins/bus'
import { designTaskPublisher, getdesignPrincipal, designTaskHandler, getBindPeople } from '@/api/RDmanagement/dropDown'
import { submitUpdate, getExcel, handlerTask, getDesignTask, setPriority, setSubtasksPriority, statsuChangeLog, startTask, getNewPrincipal, sequenceTasks, partsChangeLog, subtasksChangeLog,
  completeTask, submitTask, dissubmitTask, revocationTask, stopTask, changeTaskPeople, changeTaskDate, changeSubtasksDate, reviewTasks, designWalk } from '@/api/RDmanagement/task/design'
import { allow, allowSize } from '@/plugins/common.js'
import GroupSelect from '@/components/GroupSelect'
const columns = [
  {
    dataIndex: 'open',
    key: 'open',
    width: '1.3%',
    slots: { title: 'openTitle' },
    scopedSlots: { customRender: 'open' }
  },

  {
    dataIndex: 'id',
    key: 'id',
    width: '5%',
    customRender: (value, row, index) => {
      const obj = {
        children: row.type,
        attrs: {}
      }
      if (index === 0) {
        obj.attrs.rowSpan = 2
      }
      // These two are merged into above cell
      if (index === 1) {
        obj.attrs.rowSpan = 0
      }
      return obj
    },
    slots: { title: 'priorityTitle' },
    scopedSlots: { customRender: 'priority' }
  },
  {
    title: '任务ID',
    key: 'number',
    dataIndex: 'number',
    scopedSlots: { customRender: 'number' },
    slots: { title: 'customTitle' },
    width: '7.5%'
  },
  {
    title: '负责人',
    dataIndex: 'principal_user_name',
    key: 'principal_user_name',
    scopedSlots: { customRender: 'principal_user_name' },
    width: '7%'
  },
  {
    title: '跟进人',
    key: 'handler_name',
    dataIndex: 'handler_name',
    scopedSlots: { customRender: 'handler_name' },
    width: '15%'
  },
  {
    title: '任务分工要求',
    key: 'demand',
    dataIndex: 'demand',
    scopedSlots: { customRender: 'demand' },
    width: '17%'
  },
  {
    title: '操作人备注',
    key: 'principal',
    dataIndex: 'principal',
    scopedSlots: { customRender: 'principal' },
    width: '17%'
  },
  {
    title: '完成情况',
    key: 'remaining_days',
    dataIndex: 'remaining_days',
    scopedSlots: { customRender: 'remaining_days' },
    width: '8%'
  },
  {
    title: '预计完成时间',
    key: 'expect_finish_days',
    dataIndex: 'expect_finish_days',
    scopedSlots: { customRender: 'expect_finish_days' },
    width: '9%'
  },
  {
    title: '状态',
    key: 'status',
    dataIndex: 'status',
    scopedSlots: { customRender: 'status' },
    width: '7%'
  },
  {
    title: `操作`,
    key: 'operate',
    dataIndex: 'operate',
    scopedSlots: { customRender: 'operate' },
    width: 90
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
    dataIndex: 'comment',
    width: 308
  }
]
let search = []
let may = []
let must = []
let sort = []
const plainOptions = ['交互设计', '视觉设计', '前端', '移动端', '美工']

export default {
  components: { downMedia, operationLogs, mySearch, addFollower, myViewer, downPrd, allTaskInfo, GroupSelect, editVersonModal, allPersonSelect },
  data () {
    return {
      isTest: undefined, // 选择的版本是否在测试中
      tipsShow: true,
      expiration_date: undefined,
      type: 1,
      excelRadio: 1,
      mediaShow: true,
      title: undefined,
      mySearch: false,
      searchMsg: '',
      disabled1: false,
      disabled2: false,
      expandRow: [],
      remind: {},
      pickerOptions: {
        // 设置日期时间在今天以后
        disabledDate (time) {
          return time.getTime() < Date.now() - 24 * 60 * 60 * 1000
        }
      },
      isFixed: false,
      options: [],
      options2: [],
      options3: [],
      options4: [],
      bindPeople: [],
      TaskPublisherArr: [],
      TaskPublisherID: undefined,
      PrincipalArr: [],
      PrincipalID: undefined,
      TaskHandlerArr: [],
      TaskHandlerID: undefined,
      followerModalArr: [],
      followerModalID: undefined,
      check1: false,
      check2: false,
      check3: false,
      check4: false,
      check5: false,
      activeKey: '1',
      taskMsg: {
        media: [],
        review_media: [],
        policies: {}
      },
      // checkedList: ['交互设计'],
      plainOptions,
      subtasks_id: undefined,
      demand_id: undefined,
      designForm: this.$form.createForm(this, { name: 'task' }),
      allotForm: this.$form.createForm(this, { name: 'allotTask' }),
      addForm: this.$form.createForm(this, { name: 'addTask' }),
      verifyForm: this.$form.createForm(this, { name: 'verifyTask' }),
      verifyForm2: this.$form.createForm(this, { name: 'changeVerify' }),
      change_expiration_date: '',
      taskId: '',
      comment: '',
      fileInputList: [{ name: '', file: null }],
      fileList: [],
      form1: {
        shared_address: [
          { value: '' }
        ]
      },
      checkForm: {
        comment: undefined,
        difference_reason: undefined,
        result: 1,
        finish_type: undefined
      },
      submitForm: {
        independentBranch: undefined,
        release_type: undefined,
        branch_name: undefined,
        has_sql: undefined,
        release_version_id: undefined,
        stress_test: 0,
        release_comment: undefined
      },
      radio: '1',
      radio2: 0,
      radio3: 0,
      radio4: 0,
      radio3_1: 0,
      searchData: {
        tabs: 200,
        created_at: undefined,
        TaskPublisher: undefined,
        subTasks_status: undefined,
        Principal: undefined,
        TaskHandler: undefined,
        proId: undefined,
        priority: undefined,
        valueDesign: this.designValue
      },
      data: [],
      columns,
      data2: [],
      columns2,
      selectedRowKeys: [], // Check here to configure the default column
      loading: true,
      modalLoading: false,
      pagination1: {
        showSizeChanger: true,
        pageSizeOptions: ['10', '20', '30', '50'],
        total: 10,
        current: 1,
        pageSize: Number(localStorage.getItem('designPage')) || 10
      },
      value1: 1,
      value3: '',
      principal_user: '',
      taskDetails: false,
      dialogVisible: false,
      dialogVisible1: false,
      dialogVisible2: false,
      dialogVisible3: false,
      dialogVisible4: false,
      dialogVisible5: false,
      dialogVisible6: false,
      dialogVisible7: false,
      dialogVisible8: false,
      dialogVisible9: false,
      dialogVisible10: false,
      dialogVisible11: false,
      checkAll: false,
      selectshow: false,
      parts: [],
      screenWidth: this.$store.state.recount.pageWidth,
      btnLoad: false,
      isMainFollower: false,
      designType: undefined,
      versions: { expected_versions: [] },
      checkInfo: {},
      checkMainInfo: {}
    }
  },
  props: {
    proId: {
      type: Number
    },
    designValue: {
      type: Array
    }
  },
  beforeCreate () {
    this.simpleImage = Empty.PRESENTED_IMAGE_SIMPLE
  },
  created () {
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
    if (userType.link_type === 'design') {
      if (userType.task_leader && !this.$route.query.number) {
        this.PrincipalArr = userCache.id ? [{ name: userCache.name, id: userCache.id }] : []
        this.PrincipalID = userCache.id ? userCache.id : undefined
        this.searchData.Principal = { label: user.name, key: user.id }
      } else if (userType.task_follower && !this.$route.query.number) {
        this.TaskHandlerArr = userCache.id ? [{ name: userCache.name, id: userCache.id }] : []
        this.TaskHandlerID = userCache.id ? userCache.id : undefined
        this.searchData.TaskHandler = { label: user.name, key: user.id }
      } else if (userType.product_analyst && !this.$route.query.number) {
        this.TaskPublisherArr = userCache.id ? [{ name: userCache.name, id: userCache.id }] : []
        this.TaskPublisherID = userCache.id ? userCache.id : undefined
        this.searchData.TaskPublisher = { label: user.name, key: user.id }
      }
    }
    search = []
    if (this.$route.query.project) {
      search['related_project'] = 1
    }
    if (this.searchData.proId === -1) {
      search['source_project_id'] = undefined
    } else {
      search['source_project_id'] = this.searchData.proId
    }
    this.getTaskAll()
    getBindPeople().then(res => {
      if (res.code === 200) {
        this.bindPeople = res.data.users
      }
    })
    designTaskPublisher().then(res => {
      if (res.code === 200) {
        this.options = res.data.users
      }
    })
    getdesignPrincipal().then(res => {
      if (res.code === 200) {
        this.options2 = res.data.users
      }
    })
    designTaskHandler().then(res => {
      if (res.code === 200) {
        this.options3 = res.data.users
      }
    })
  },
  mounted () {
    window.addEventListener('scroll', this.handleScroll, true) // 监听（绑定）滚轮滚动事件
  },
  destroyed () {
    window.removeEventListener('scroll', this.handleScroll, true) //  离开页面清除（移除）滚轮滚动事件
  },

  watch: {
    '$store.state.recount.pageWidth' (newVal) {
      this.screenWidth = newVal
    },
    proId: {
      handler (newVal) {
        this.searchData.proId = newVal
      },
      immediate: true
    },
    designValue (newVal, oldVal) {
      this.searchData.valueDesign = newVal
    },
    searchData: {
      handler (newVal, oldVal) {
        if (!this.searchMsg && !this.$route.query.number) {
          search['keyword'] = undefined
        }
        if (this.searchData.proId === -1) {
          search['source_project_id'] = undefined
        } else {
          search['source_project_id'] = this.searchData.proId
        }
        search['priority'] = newVal.priority
        // eslint-disable-next-line
        if (newVal.valueDesign == 'all' || newVal.valueDesign === undefined) {
          search['parts.type'] = undefined
        } else {
          search['parts.type'] = newVal.valueDesign.toString()
        }

        if (newVal.subTasks_status) {
          search['subTaskStatus'] = newVal.subTasks_status.key
        } else {
          search['subTaskStatus'] = undefined
        }
        if (newVal.tabs === 200) {
          search['status'] = undefined
          search['review'] = undefined
        } else if (newVal.tabs === 100) {
          search['review'] = 2
          search['status'] = undefined
        } else {
          search['status'] = newVal.tabs
          search['review'] = undefined
        }
        if (newVal.created_at) {
          search['created_at'] = newVal.created_at[0].format('YYYY/MM/DD') + ',' + newVal.created_at[1].format('YYYY/MM/DD')
        } else {
          search['created_at'] = undefined
        }
        if (newVal.TaskPublisher) {
          search['promulgator_id'] = newVal.TaskPublisher.key
        } else {
          search['promulgator_id'] = undefined
        }
        if (newVal.Principal) {
          search['principal_user'] = newVal.Principal.key
        } else {
          search['principal_user'] = undefined
        }
        if (newVal.TaskHandler) {
          search['parts.subTasks.handler_id'] = newVal.TaskHandler.key
        } else {
          search['parts.subTasks.handler_id'] = undefined
        }
        this.loading = true
        let params = { filters: search,
          may,
          must,
          append: ['operation_log'],
          limit: this.pagination1.pageSize || 10 }
        this.getTask(params)
      },
      deep: true
    //   immediate: true
    }
  },
  computed: {
    allOpen () {
      let result = this.data.some(function (value, index) {
        return value.open
      })
      return result
    },
    sortDataDown () {
      return this.data.slice().sort(
        function (a, b) {
          let aTimeString = a.created_at
          let bTimeString = b.created_at
          aTimeString = aTimeString.replace(/-/g, '/')
          bTimeString = bTimeString.replace(/-/g, '/')
          let aTime = new Date(aTimeString).getTime()
          let bTime = new Date(bTimeString).getTime()
          return aTime - bTime
        })
    },
    sortDataUp () {
      return this.data.slice().sort(
        function (a, b) {
          let aTimeString = a.created_at
          let bTimeString = b.created_at
          aTimeString = aTimeString.replace(/-/g, '/')
          bTimeString = bTimeString.replace(/-/g, '/')
          let aTime = new Date(aTimeString).getTime()
          let bTime = new Date(bTimeString).getTime()
          return bTime - aTime
        })
    },
    systemTime: {
      get () {
        return moment().startOf('day').diff(moment(this.expiration_date), 'day')
      },
      set () {

      }
    },
    hasSelected () {
      return this.selectedRowKeys.length > 0
    },
    allRow () {
      let arr = []
      this.data.map(item => {
        arr.push(item.id)
      })
      return arr
    }
  },
  methods: {
    canDo,
    moment,
    filtering,
    removeProperty,
    handleSearch1 (e) {
      this.searchData.TaskPublisher = e.id === undefined ? undefined : { key: e.id, label: e.name }
    },
    handleSearch4 (e) {
      this.searchData.Principal = e.id === undefined ? undefined : { key: e.id, label: e.name }
    },
    handleSearch5 (e) {
      this.searchData.TaskHandler = e.id === undefined ? undefined : { key: e.id, label: e.name }
    },
    handleModalSearch (e) {
      this.allotForm.setFieldsValue({ user_id: e.id })
    },
    addFollowers (id, type) {
      this.$nextTick(() => {
        this.$refs.addFollower.modalVisible = true
        this.subtasks_id = id
        if (type === 0) {
          this.title = '交互跟进人'
        } else if (type === 1) {
          this.title = '视觉跟进人'
        } else if (type === 2) {
          this.title = '美工跟进人'
        } else if (type === 3) {
          this.title = '前端跟进人'
        } else if (type === 4) {
          this.title = '移动端跟进人'
        }
      })
    },
    checkTestStatus (e) {
      // 判断选择版本是否在测试
      if (e.status === 2) {
        this.isTest = true
      } else {
        this.isTest = false
      }
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
        limit: 10
      }
      this.TaskPublisherArr = []
      this.TaskPublisherID = undefined
      this.$refs.TaskPublisherRef.value = undefined
      this.PrincipalArr = []
      this.PrincipalID = undefined
      this.$refs.PrincipalRef.value = undefined
      this.TaskHandlerArr = []
      this.TaskHandlerID = undefined
      this.$refs.TaskHandlerRef.value = undefined
      for (let key in this.searchData) {
        if (key === 'TaskPublisher' || key === 'Principal' || key === 'TaskHandler') {
          this.searchData[key] = undefined
        } else {
          delete this.searchData[key]
        }
      }
      search = []
      this.mySearch = true
      this.getTask(params)
      setTimeout(() => {
        this.$refs.search.showSearch = false
      }, 0)
    },
    // 在methods监控滚动时间
    handleScroll () {
      this.$nextTick(() => {
        let scrollTop = document.querySelector('.task-content').scrollTop
        // let scrollTop = document.documentElement.scrollTop || document.body.scrollTop || window.pageYOffset
        if (scrollTop > 293) {
          this.isFixed = true
        } else {
          this.isFixed = false
        }
      })
    },
    closeTips () {
      this.tipsShow = false
    },
    expandedChange (e) {
      this.expandRow = e
    },
    expand () {
      this.data.map(item => {
        this.expandRow.push(item.number)
      })
    },
    disexpand () {
      this.expandRow = []
    },
    disabledDate (current) {
      // 不能选择今天以前的日期
      return current && current < moment().startOf('day')
    },
    reset (index) {
      if (index === 1) {
        this.TaskPublisherArr = []
        this.TaskPublisherID = undefined
        this.$refs.TaskPublisherRef.value = undefined
        this.searchData.TaskPublisher = undefined
      } else if (index === 2) {
        this.searchData.created_at = undefined
      } else if (index === 3) {
        this.searchData.priority = undefined
      } else if (index === 4) {
        this.PrincipalArr = []
        this.PrincipalID = undefined
        this.$refs.PrincipalRef.value = undefined
        this.searchData.Principal = undefined
      } else if (index === 5) {
        this.TaskHandlerArr = []
        this.TaskHandlerID = undefined
        this.$refs.TaskHandlerRef.value = undefined
        this.searchData.TaskHandler = undefined
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
        this.getTaskAll()
      } else if (index === 7) {
        this.searchData.subTasks_status = undefined
      }
    },
    onChange (e) {
      this.taskDetails = false
      this.activeKey = '1'
      this.getTaskAll()
    },
    handleExport () {
      let params = { may, must, search }
      params = qs.stringify(params)
      getExcel(params)
    },
    showAllTask (id) {
      this.$refs.allTaskInfo.dialogVisible = true
      this.demand_id = id
    },
    showTask (e, type) {
      e.review_media = []
      e.media.forEach(item => {
        if (item.collection_name === 'reviewDesignTask') {
          e.review_media.push(item)
        }
      })
      this.taskMsg = e
      if (type === 2) {
        this.activeKey = '2'
      } else {
        this.activeKey = '1'
      }
      if (this.taskMsg.operation_log) {
        if (this.taskMsg.operation_log.length > 0) {
          this.taskMsg.operation_log = this.taskMsg.operation_log.map(item => {
            return { show: false, ...item }
          })
        }
      }
      this.taskDetails = true
    },
    onClose () {
      this.taskDetails = false
      if (this.$refs.design) {
        this.$refs.design.form.resetFields()
      }
      this.activeKey = '1'
    },
    showpeopleSelect (record) {
      if (record.policies.principal) {
        this.principal_user = record.principal_user_name
        getNewPrincipal(record.id).then(res => {
          if (res.code === 200) {
            this.options4 = res.data.users
          }
        })
        record.peopleSelect = true
      }
    },
    showDateSelect (record) {
      if (record.policies.expirationDate) {
        this.change_expiration_date = record.expiration_date
        record.dateSelect = true
      }
    },
    blurDate (e, record) {
      if (!e) {
        record.dateSelect = false
      }
    },
    changeDate (e, k) {
      k.dateSelect = false
      let params = { }
      if (e) {
        params = { expiration_date: e.format('YYYY-MM-DD') }
      }
      if (k.promulgator_id) {
        changeTaskDate(k.id, params).then(res => {
          if (res.code === 200) {
            this.$message.success('修改成功')
            this.getTaskAll()
          }
        })
      } else {
        changeSubtasksDate(k.id, params).then(res => {
          if (res.code === 200) {
            this.$message.success('修改成功')
            this.getTaskAll()
          }
        })
      }
    },
    showHandler (record) {
      if (record.policies.setPartHandler && record.is_main) {
        this.dialogVisible8 = true
        var day = ''
        if (record.expiration_date) {
          day = moment(record.expiration_date)
        } else {
          day = undefined
        }
        if (!record.handler_id) {
          record.handler_id = undefined
        }
        this.taskId = record.part_id
        this.followerModalID = record.handler_id
        this.followerModalArr = record.handler_id ? [{ id: record.handler_id, name: record.handler_name }] : []
        setTimeout(() => {
          this.allotForm.setFieldsValue({
            'user_id': record.handler_id,
            'comment': record.description,
            'expiration_date': day
          })
        }, 0)
      }
    },
    sequence (record) {
      if (record.policies.sequence) {
        this.dialogVisible11 = true
        this.taskId = record.id
        this.radio3_1 = record.design_type
        let parts = record.parts.map(item => {
          if (item.status !== 7) {
            return item.type
          }
        })
        setTimeout(() => {
          this.verifyForm2.setFieldsValue({ 'parts': parts })
        }, 100)
      }
    },
    startModal (record) {
      this.dialogVisible2 = true
      this.taskId = record.id
    },
    completeModal (record, item) {
      this.checkMainInfo = item
      this.checkInfo = record
      this.dialogVisible3 = true
      this.taskId = record.id
      this.designType = record.type || record.part_type
      this.expiration_date = record.expiration_date
    },
    submitModal (record, status, mainTask) {
      if (status === 2) {
        this.comment = record.submit_comment

        if (record.media.length) {
          this.fileInputList = record.media
        } else {
          this.fileInputList = [{ name: '', file: null }]
        }
        if (record.share_address) {
          this.form1.shared_address = JSON.parse(record.share_address).map(item => {
            return { value: item }
          })
        } else {
          this.form1.shared_address = [ { value: '' } ]
        }
      }
      this.type = status
      this.dialogVisible4 = true
      this.taskId = record.id
      this.designType = record.type || record.part_type
      this.isMainFollower = record.is_main
      this.versions = mainTask
    },
    editVersonModal (record) {
      bus.$emit('editVersionModalShow', record)
    },
    submitCancelModal (record) {
      this.dialogVisible5 = true
      this.taskId = record.id
    },
    stopModal (record) {
      this.dialogVisible6 = true
      this.taskId = record.id
    },
    revocationModal (record) {
      this.dialogVisible7 = true
      this.taskId = record.id
    },
    releaseTask () {
      this.$router.push({ name: this.$route.query.project ? 'projectReleaseDesignTask' : 'releaseDesignTask', query: { link: 'design', project: this.$route.query.project ? 1 : undefined } })
    },
    goEdit (e) {
      this.$router.push({ name: this.$route.query.project ? 'projectReleaseDesignTask' : 'releaseDesignTask', query: { link: 'design', id: e.id, project: this.$route.query.project ? 1 : undefined } })
    },
    cancel (index) {
      if (index === 1) {
        this.dialogVisible1 = false
        this.addForm.resetFields()
        this.parts = []
        this.radio2 = 0
        this.check1 = false
        this.check2 = false
        this.check3 = false
        this.check4 = false
        this.check5 = false
        this.fileInputList = [{ name: '', file: null }]
      } else if (index === 2) {
        this.dialogVisible2 = false
        this.taskId = ''
        this.comment = ''
      } else if (index === 3) {
        this.dialogVisible3 = false
        this.taskId = ''
        this.$refs.checkForm.resetFields()
      } else if (index === 4) {
        this.dialogVisible4 = false
        this.taskId = ''
        this.comment = ''
        this.value1 = 1
        this.fileInputList = [{ name: '', file: null }]
        this.form1.shared_address = [ { value: '' } ]
        this.$refs.submitForm.resetFields()
      } else if (index === 5) {
        this.dialogVisible5 = false
        this.taskId = ''
        this.comment = ''
      } else if (index === 6) {
        this.$refs['stopForm'].resetFields()
        this.comment = ''
        this.dialogVisible6 = false
      } else if (index === 7) {
        this.$refs['revocationForm'].resetFields()
        this.comment = ''
        this.dialogVisible7 = false
      } else if (index === 8) {
        this.dialogVisible8 = false
        this.followerModalArr = []
        this.followerModalID = undefined
        this.$refs.followerModalRef.value = undefined
        this.allotForm.setFieldsValue({ 'user_id': undefined })
        this.allotForm.resetFields()
      } else if (index === 9) {
        this.dialogVisible9 = false
        this.designForm.resetFields()
        this.fileInputList = [{ name: '', file: null }]
      } else if (index === 10) {
        this.dialogVisible10 = false
        this.verifyForm.resetFields()
        this.radio3 = 0
      } else if (index === 11) {
        this.dialogVisible11 = false
        this.verifyForm2.resetFields()
        this.radio3_1 = 0
      }
    },
    ok (index) {
      let params = {
        comment: this.comment
      }
      if (!this.comment) {
        delete params.comment
      }
      if (index === 1) {
      } else if (index === 2) {
        this.btnLoad = true
        startTask(this.taskId, params).then(res => {
          if (res.code === 200) {
            this.taskId = ''
            this.comment = ''
            this.$message.success('开始任务')
            this.dialogVisible2 = false
            this.getTaskAll()
            this.btnLoad = false
          }
        }).catch(error => {
          this.btnLoad = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else if (index === 3) {
        this.$refs.checkForm.validate(valid => {
          if (valid) {
            this.removeProperty(this.checkForm)
            params = this.checkForm
            this.btnLoad = true
            completeTask(this.taskId, params).then(res => {
              if (res.code === 200) {
                this.taskId = ''
                this.$nextTick(() => {
                  this.$refs.checkForm.resetFields()
                })
                this.$message.success('验收成功')
                this.dialogVisible3 = false
                this.getTaskAll()
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
      } else if (index === 4) {
        this.$refs.submitForm.validate(valid => {
          if (valid) {
            var urlArr = []
            this.form1.shared_address.forEach(item => {
              urlArr.push(item.value)
            })
            const formData = objToFd(this.submitForm)
            urlArr.map(item => {
              if (item) {
                formData.append('share_address[]', item)
              }
            })
            if (this.comment) {
              formData.append('comment', this.comment)
            }

            if (this.type === 1) {
              this.fileInputList.map(item => {
                if (item.file) {
                  formData.append('media[]', item.file)
                }
              })

              // 提交时选择的版本在测试中时,用系统弹框进行二次确认
              let canSubmit
              if (this.submitForm.release_type === 0) {
                if (this.isTest) {
                  if (confirm('所选版本已发布至测试站,确认继续提交后将会发送邮件给版本管理员')) {
                    canSubmit = true
                  } else {
                    canSubmit = false
                  }
                } else {
                  canSubmit = true
                }
              } else {
                canSubmit = true
              }
              if (canSubmit) {
                this.btnLoad = true
                submitTask(this.taskId, formData).then(res => {
                  if (res.code === 200) {
                    this.btnLoad = false
                    this.taskId = ''
                    this.comment = ''
                    this.value1 = 1
                    this.form1.shared_address = [{ value: '' }]
                    this.fileInputList = [{ name: '', file: null }]
                    this.$message.success('提交成功')
                    this.dialogVisible4 = false
                    this.getTaskAll()
                    this.$refs.submitForm.resetFields()
                  }
                }).catch(error => {
                  this.btnLoad = false
                  this.$message.error(error.response ? error.response.data.message : error.message)
                })
              }
            } else {
              this.fileInputList.forEach(item => {
                if (item.file) {
                  formData.append('new_media[]', item.file)
                } else if (item.id) {
                  formData.append('old_media[]', item.id)
                }
              })
              this.btnLoad = true
              submitUpdate(this.taskId, formData).then(res => {
                if (res.code === 200) {
                  this.btnLoad = false
                  this.taskId = ''
                  this.comment = ''
                  this.form1.shared_address = [{ value: '' }]
                  this.fileInputList = [{ name: '', file: null }]
                  this.$message.success('更新信息成功')
                  this.dialogVisible4 = false
                  this.getTaskAll()
                  this.taskDetails = false
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
      } else if (index === 5) {
        this.btnLoad = true
        dissubmitTask(this.taskId, params).then(res => {
          if (res.code === 200) {
            this.taskId = ''
            this.comment = ''
            this.$message.success('撤销提交成功')
            this.dialogVisible5 = false
            this.getTaskAll()
            this.btnLoad = false
          }
        }).catch(error => {
          this.btnLoad = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else if (index === 6) {
        this.$refs['stopForm'].validate((valid) => {
          if (valid) {
            this.btnLoad = true
            stopTask(this.taskId, params).then(res => {
              if (res.code === 200) {
                this.comment = ''
                this.$message.success('暂停成功')
                this.dialogVisible6 = false
                this.getTaskAll()
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
      } else if (index === 7) {
        this.$refs['revocationForm'].validate((valid) => {
          if (valid) {
            this.btnLoad = true
            revocationTask(this.taskId, params).then(res => {
              if (res.code === 200) {
                this.comment = ''
                this.$message.success('撤销成功')
                this.dialogVisible7 = false
                this.getTaskAll()
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
      } else if (index === 8) {
        this.allotForm.validateFields((err, values) => {
          if (!err) {
            if (!values.comment) {
              delete values.comment
            }
            values.expiration_date = values['expiration_date'].format('YYYY-MM-DD')
            this.btnLoad = true
            handlerTask(this.taskId, values).then(res => {
              if (res.code === 200) {
                this.$message.success('分配任务成功')
                this.dialogVisible8 = false
                this.getTaskAll()
                this.allotForm.resetFields()
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
      } else if (index === 9) {
        this.verifyForm.validateFields((err, values) => {
          let result = true
          let result2 = true
          if (this.radio3 === 2) {
            if (values.parts.indexOf(3) === -1 && values.parts.indexOf(4) === -1) {
              this.$message.error('前端和移动端必须选择一个')
              result = false
            } else {
              result = true
            }
            if (values.parts.indexOf(0) === -1 && values.parts.indexOf(1) === -1 && values.parts.indexOf(2) === -1) {
              this.$message.error('交互,视觉,美工必须选择一个')
              result2 = false
            } else {
              result2 = true
            }
          }
          if (!err && result && result2) {
            let parts = values.parts.filter(d => { return d !== 'undefined' })
            let params = { parts: parts, design_type: this.radio3 }
            this.btnLoad = true
            reviewTasks(this.taskId, params).then(res => {
              if (res.code === 200) {
                this.$message.success('您已经审核此任务')
                this.dialogVisible10 = false
                this.getTaskAll()
                this.verifyForm.resetFields()
                this.radio2 = 0
                this.btnLoad = false
                this.taskDetails = false
              }
            }).catch(error => {
              this.btnLoad = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          }
        })
      } else if (index === 10) {
        this.designForm.validateFields((err, values) => {
          if (!err) {
            const formData = new FormData()
            formData.append('id', this.taskId)
            formData.append('review_result', this.radio4)
            formData.append('review_comment', values.review_comment)
            this.fileInputList.map(item => {
              if (item.file) {
                formData.append('media[]', item.file)
              }
            })
            this.btnLoad = true
            designWalk(this.taskId, formData).then(res => {
              if (res.code === 200) {
                this.$message.success('走查成功')
                this.dialogVisible9 = false
                this.designForm.resetFields()
                this.fileInputList = [{ name: '', file: null }]
                this.getTaskAll()
                this.btnLoad = false
                this.taskDetails = false
              }
            }).catch(error => {
              this.btnLoad = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          }
        })
      } else if (index === 11) {
        this.verifyForm2.validateFields((err, values) => {
          let result = true
          let result2 = true
          if (this.radio3_1 === 2) {
            if (values.parts.indexOf(3) === -1 && values.parts.indexOf(4) === -1) {
              this.$message.error('前端和移动端必须选择一个')
              result = false
            } else {
              result = true
            }
            if (values.parts.indexOf(0) === -1 && values.parts.indexOf(1) === -1 && values.parts.indexOf(2) === -1) {
              this.$message.error('交互,视觉,美工必须选择一个')
              result2 = false
            } else {
              result2 = true
            }
          }
          if (!err && result && result2) {
            if (confirm('已选状态将发生变化，确定？')) {
              // 按确认后做什么
              let parts = values.parts.filter(d => { return d !== 'undefined' })
              let params = { parts: parts, design_type: this.radio3_1 }
              this.btnLoad = true
              sequenceTasks(this.taskId, params).then(res => {
                if (res.code === 200) {
                  this.$message.success('您已经修改此任务环节')
                  this.dialogVisible11 = false
                  this.getTaskAll()
                  this.btnLoad = false
                  this.taskDetails = false
                }
              }).catch(error => {
                this.btnLoad = false
                this.$message.error(error.response ? error.response.data.message : error.message)
              })
            } else {
              // 按否做些什么

            }
          }
        })
      }
    },
    addFileInputList () {
      const object = {
        name: '',
        file: null
      }
      const { fileInputList } = this
      fileInputList.push(object)
      this.fileInputList = fileInputList
    },
    beforeUpload (file, index) {
      const size = file.size / (1024 * 1024)
      const name = file.name.substring(file.name.lastIndexOf('.'))
      if (size > allowSize) {
        this.$message.error('上传文件不得超过' + allowSize + 'm')
      } else if (allow.indexOf(name) === -1) {
        this.$message.error('上传文件格式不正确')
      } else {
        const { fileInputList } = this
        fileInputList[index].file = file
        fileInputList[index].name = file.name
        this.fileInputList = fileInputList
      }
      return false
    },
    removeFileInputList (index) {
      const { fileInputList } = this
      fileInputList.splice(index, 1)
      this.fileInputList = fileInputList
    },
    addUrlInputList () {
      this.form1.shared_address.push({ value: '' })
    },
    removeUrlInputList (index) {
      this.form1.shared_address.splice(index, 1)
    },
    showAll () {
      this.data.forEach(item => {
        item.open = true
      })
    },
    closeAll () {
      this.data.forEach(item => {
        item.open = false
      })
    },
    getLogs (record) {
      if (record.promulgator_id) {
        statsuChangeLog(record.id).then(res => {
          this.dialogVisible = true
          if (res.code === 200) {
            this.data2 = res.data.status_logs
          }
        })
      } else {
        if (!record.handler_id) {
          partsChangeLog(record.part_id).then(res => {
            this.dialogVisible = true
            if (res.code === 200) {
              this.data2 = res.data.status_logs
            }
          })
        } else {
          subtasksChangeLog(record.id).then(res => {
            this.dialogVisible = true
            if (res.code === 200) {
              this.data2 = res.data.status_logs
            }
          })
        }
      }
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
      let params = { filters: search, append: ['operation_log'], limit: 10 }
      this.getTask(params)
    },
    getTaskAll () {
      if (this.$route.query.number) {
        search['keyword'] = this.$route.query.number
      }
      let params = {
        filters: search,
        append: ['operation_log'],
        limit: this.pagination1.pageSize || 10,
        page: this.pagination1.current
      }
      this.getTask(params)
    },
    getTask (params) {
      getDesignTask(params).then(res => {
        this.remind = res.data.remind
        this.data = res.data.data.map(item => {
          item.open = true
          item.subtasks = []
          item.parts.forEach(k => {
            k.subtasks = [...k.main_subtask, ...k.other_subtasks]
            k.main_subtask.forEach(k2 => {
              if (k.type === 0) {
                let a = [...k.main_subtask, ...k.other_subtasks]
                k2.type_length = a.length
              } else if (k.type === 1) {
                let a = [...k.main_subtask, ...k.other_subtasks]
                k2.type_length = a.length
              } else if (k.type === 2) {
                let a = [...k.main_subtask, ...k.other_subtasks]
                k2.type_length = a.length
              } else if (k.type === 3) {
                let a = [...k.main_subtask, ...k.other_subtasks]
                k2.type_length = a.length
              } else if (k.type === 4) {
                let a = [...k.main_subtask, ...k.other_subtasks]
                k2.type_length = a.length
              }
              if (!k2.handler_id) {
                k2.status_desc = k.status_desc
              }
              k2.type = k.type
              k2.policies = { ...k.policies, ...k2.policies }
              k2.dateSelect = false
              k2.peopleSelect = false
              k2.select = false
            })
            k.other_subtasks.forEach(k2 => {
              if (!k2.handler_id) {
                k2.status_desc = k.status_desc
              }
              k2.dateSelect = false
              k2.peopleSelect = false
              k2.select = false
            })
            item.subtasks.push(...k.main_subtask, ...k.other_subtasks)

            k.dateSelect = false
            k.peopleSelect = false
            k.select = false
            k.open = true
          })
          return { select: false, peopleSelect: false, open: true, dateSelect: false, ...item }
        })

        this.pagination1.total = res.data.total
        this.pagination1.current = res.data.current_page
        this.pagination1.pageSize = res.data.per_page
        this.loading = false
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    handbutton (k) {
      if (k.policies.priority) {
        k.select = true
      }
    },
    // 修改p级别
    handleChange (e, k) {
      k.select = false
      if (k.promulgator_id) {
        setPriority(k.id, e).then(res => {
          if (res.code === 200) {
            this.$message.success('修改P级别成功')
            this.getTaskAll()
          }
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else {
        setSubtasksPriority(k.id, e).then(res => {
          if (res.code === 200) {
            this.$message.success('修改P级别成功')
            this.getTaskAll()
          }
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      }
    },
    handleBlur (k) {
      k.select = false
    },
    handleFocus () {
    },

    // 修改负责人
    handleBlur2 (k) {
      k.peopleSelect = false
    },
    handleChange2 (e, k) {
      let params = { team_id: e }
      changeTaskPeople(k.id, params).then(res => {
        if (res.code === 200) {
          this.$message.success('修改负责人成功')
          k.peopleSelect = false
          this.getTaskAll()
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    changePage (e, filters, sorter) {
      if (sorter.field === 'priority' && sorter.order === 'ascend') {
        sort = 'priority'
      } else if (sorter.field === 'priority' && sorter.order === 'descend') {
        sort = '-priority'
      } else if (sorter.field === 'created_at' && sorter.order === 'ascend') {
        sort = 'created_at'
      } else if (sorter.field === 'created_at' && sorter.order === 'descend') {
        sort = '-created_at'
      }
      this.loading = true
      let params = {}
      if (this.$route.query.project) {
        search['related_project'] = 1
      }
      localStorage.setItem('designPage', e.pageSize)
      params = { may, must, filters: search, append: ['operation_log'], page: e.current, limit: e.pageSize, sort }
      this.getTask(params)
    },
    // 参与角色验证
    checkUser (e, index) {
      if (index === 1) {
        this.check1 = e.target.checked
        this.$nextTick(() => {
          this.addForm.validateFields(['user1'], { force: true })
        })
      } else if (index === 2) {
        this.check2 = e.target.checked
        this.$nextTick(() => {
          this.addForm.validateFields(['user2'], { force: true })
        })
      } else if (index === 3) {
        this.check3 = e.target.checked
        this.$nextTick(() => {
          this.addForm.validateFields(['user3'], { force: true })
        })
      } else if (index === 4) {
        this.check4 = e.target.checked
        this.$nextTick(() => {
          this.addForm.validateFields(['user4'], { force: true })
        })
      } else if (index === 5) {
        this.check5 = e.target.checked
        this.$nextTick(() => {
          this.addForm.validateFields(['user5'], { force: true })
        })
      }
    }
  }
}
</script>

<style lang="less" scoped>
  /deep/.ant-dropdown-menu-item a {
            padding-left:20px !important;
            span{
                margin-right:10px;
            }
    }

.ant-table-tbody > tr:hover:not(.ant-table-expanded-row) > td {
  &:nth-child(2) div{
    animation: disappear2 3s;
    animation-fill-mode:forwards
  }
   &:nth-child(3) span{
    animation: disappear2 3s;
    animation-fill-mode:forwards
  }
   &:nth-child(7) .principal_user{
    animation: disappear2 3s;
    animation-fill-mode:forwards
  }
   &:nth-child(9) .principal_user{
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
.tips-box{
        position: relative;
        width: 500px;
        background: #FFF2EA;
        color: #F88D49;
        padding:8px 30px 10px 10px;
        border: 1px solid #FFD8BF;
        border-radius: 5px;
        margin-bottom: 20px;
        & >.iconfont{
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
    }
.expand{
    cursor: pointer;
    font-size: 12px;
    margin-right: 4px;
}
.eidt-btn-6 {
  margin-bottom: 0px;
  display: inline-block;
}
/deep/.ant-drawer-body {
  padding: 20px !important;
}
 .operation {
    cursor: pointer;
    color: rgba(55, 142, 239, 1);
    font-weight: normal;
    float: right;
    margin-right: 20px;
    height: 35px;
    i {
        font-size: 12px;
        display: inline-block;
        margin-right: 4px;
    }
    .cz {
        margin-left: 4px;
        color: rgba(55, 142, 239, 1);
    }
    .line{
        display: inline-block;
        height: 18px;
        width: 1px;
        background: rgba(238, 238, 238, 1);
        margin: 0 10px;
        vertical-align: sub;
    }
}
.content{
.line{
display: inline-block;
position: relative;
top: 4px;
height: 18px;
width: 1px;
background: rgba(238, 238, 238, 1);
margin: 0 10px;
}
.top .dept{
font-size:14px;
font-family:Microsoft YaHei;
font-weight:bold;
vertical-align: -5px;
color:rgba(51,51,51,1);
}
.con{
padding-top: 40px;
.header{
    width: 100%;
    height: 40px;
    line-height: 40px;
    padding:0 20px;
    background: #EBF3FD;
    border-radius: 2px 2px 0px 0px;
    .iconfont{
        color: #bbb;
    }
    span{
        font-weight: bold;
        color: #666666;
    }
}
.subtask{
    padding:0 20px;
    background: #FDFEFF;
    border: 1px solid #EBF3FD;
    border-radius: 0px 0px 2px 2px;
    .left-txt{
        display: inline-block;
        min-width: 55px;
        text-align: right;
        margin-right: 10px;
        font-size: 12px;
        color: #BBBBBB;
    }
}
.icon{
font-size: 12px;
color: #BBBBBB;
}
div {
  line-height: 1;
}
.tab{
color: #232323;
font-size: 14px;
font-weight: bold;
}
.left{
  text-align: right;
  margin-right: 20px;
  color:#BBBBBB;
  min-width: 87px;
  display: inline-block;
}
.right{
  display: inline-block;
}
}
}
.mb20 {
  margin-bottom: 20px;
}
.eidtflex div{
    display: flex;
}
.eidt-title{
    display: flex;
    align-items: center;
    .iconfont{
        position: relative;
        top: 2px;
        .status_txt{
            position: relative;
            bottom: 2px;
            vertical-align: baseline;
        }
    }
}
.main{
    display: inline-block;
    width: 18px;
    height: 18px;
    text-align: center;
    line-height: 18px;
    margin-right: 5px;
    background: rgba(61, 204, 166, .2);
    color:rgba(61, 204, 166, 1);
    border-radius: 3px;
}
.line {
  display: inline-block;
  height: 18px;
  width: 1px;
  background: rgba(238, 238, 238, 1);
  margin: 0 10px;
}
.principal_user:hover {
  background: #eee;
}
.fileInput {
  width: 1040px;
  margin-right: 10px;
}
.addFile {
  cursor: pointer;
  float: right;
  color: rgba(55, 142, 239, 1);
}
.delFile {
  cursor: pointer;
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
.son {
  color: #3dcca6;
  background: rgba(61, 204, 166, 0.2);
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
.table-list2 {

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
      position: relative;
      top: -5px;
      left: 0px;
    }
    .up {
      position: relative;
      top: 3px;
      left: -12px;
    }
  }
    .text-button img:nth-child(1) {
        width: 40px;
        height: 20px;
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
  }
   .rideo {
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
  .pro_annex span,
  .pro_principal span {
    color: #378eef;
    font-size: 14px;
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
    // margin-left: 10px;
    width: 40px;
    height: 20px;
    position: relative;
    .tips{
        color:#378EEF;
        font-size: 15px;
        position: absolute;
        right: -20px;
        display: none;
    }
    /deep/.ant-select {
      position: absolute;
      left: -2px;
      top: -6px;
    }
  }
  .button_box:hover {
    width: 40px;
    height: 20px;
    background: #eeeeee;
    .tips{
        display: inline !important;
    }
  }
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
//   height: 32px;
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
  display: block;
  margin-left: 10px;
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

.radio_box > p {
  color: #666;
  font-size: 12px;
  padding-bottom: 10px;
  span {
    color: #ff4a4a;
    display: inline-block;
    padding-right: 6px;
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
/deep/ .ant-table-thead > tr > th .ant-table-column-sorter{
      margin-top: -10.5px !important;
}

/deep/ .ant-modal-body{
    padding:20px !important;
}
.ok{
      text-align: right;
      padding: 20px 10px;
      width: 280px;
  }

</style>
<style>
    .el-textarea__inner::placeholder{
        color:#bbb !important;
        font-size:12px !important;
    }
    .el-textarea__inner {
        padding: 5px 10px;
    }
    .ant-modal-header{
        padding: 12.5px 20px;
        background: #f8f8f8;
    }
    .ant-modal-content .ant-modal-body{
               padding:20px 20px 20px 20px;
    }
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
.eidt-ant-col-8 {
  width: 33.333333%;
  margin-bottom: 6px;
}
    .a-row-flex{
        display: flex;
        flex-wrap: wrap;
    }
    .a-row-flex div:nth-child(3) .ant-form-item{
        padding-right:0px;
    }
    .a-row-flex .ant-form-item{
        padding-right:10px;
    }
    .ant-form-item-control{
        line-height:24px;
    }
    .ant-form-item-label{
        line-height:1;
        margin-bottom:10px;
    }
    .ant-form-item{
        margin-bottom: 5px;
    }
    .ant-modal-footer{
        border-top:0;
        padding-bottom:20px;
        padding-top:0;
    }
    .pst-abs{
        position: relative;
        margin-top: 10px;
    }
    .eidt-mb{
        margin-bottom: 10px;
        position: absolute;
        right: 0px;
        top: -23px;
    }
</style>
