<template>
  <div v-if="detailsData!=undefined">
    <!-- 更新测试提示框 -->
    <div class="modal-box">
      <el-dialog title="提示"
                 :visible.sync="dialogVisible"
                 width="380px">
        <div class="radio_box">
          <div class="contxt">确定该需求可以 <span style="color:#3CCDA7">开始测试</span>?</div>
        </div>
        <div slot="footer"
             class="dialog-footer tac">
          <el-button type="primary"
                     @click="testDemand">确 定</el-button>
          <el-button @click="dialogVisible = false">取 消</el-button>
        </div>
      </el-dialog>
    </div>

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
                 :visible.sync="dialogVisible4"
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
          <el-button @click="dialogVisible4 = false, $refs['stopDemandform'].resetFields(),textarea=''">取 消</el-button>
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
                 :visible.sync="dialogVisible5"
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
          <el-button @click="dialogVisible5 = false, $refs['revokeDemandform'].resetFields(),textarea=''">取 消</el-button>
          <el-button type="primary"
                    :loading="btnLoad"
                     @click="revokeDemand('revokeDemandform')">确 定</el-button>
        </span>
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
                        @click="ok">确 定</el-button>
            <el-button @click="dialogVisible_1 = false">取 消</el-button>
        </div>
        </el-dialog>

    </div>
    <!-- 验收完成弹框 -->
    <div class="modal-box">
      <el-dialog title="验收完成"
                 :visible.sync="dialogVisible2"
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
          <el-button @click="dialogVisible2 = false,textarea=''">取 消</el-button>
          <el-button type="primary"
                     @click="completeDemand">确 定</el-button>
        </span>
      </el-dialog>

    </div>
    <!-- 操作记录弹框 -->
    <div class="modal-box">
      <el-dialog title="状态变动记录"
                 :visible.sync="dialogVisible3"
                 width="700px">
        <div class="radio_box"
             style="padding-bottom: 10px;margin-top: -20px;">
          <a-table :dataSource="data"
                   :columns="columns"
                   :pagination="false"
                   :rowKey="(record, index) => index">
            <div slot="comment"
                 class="comment"
                 slot-scope="comment">
              {{comment}}</div>
              <div slot="status"
                   slot-scope="status,record">
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

    <div class="box">
      <div class="header">
        <h1>需求详情</h1>
        <a-dropdown :trigger="['click']"
                    placement='bottomCenter'>
          <div class="operation">
            <i class="icon iconfont">&#xe632;</i>
            <span class="cz">操作</span>
          </div>
          <a-menu slot="overlay"
                  style="width:120px;text-align: left;">
            <a-menu-item v-if="detailsData.demand.policies.verifyDemand">
              <a @click="dialogVisible6=true"><span class="iconfont fz12">&#xe63d;</span>立项审核</a>
            </a-menu-item>
            <a-menu-item v-if="detailsData.demand.policies.confirmDemand">
              <a @click="confirm"><span class="iconfont fz12">&#xe647;</span>确认</a>
            </a-menu-item>
            <a-menu-item v-if="detailsData.demand.policies.cancelConfirmDemand">
              <a @click="disconfirm"><span class="iconfont fz12" style="color:#FEBC2E">&#xe647;</span>取消确认</a>
            </a-menu-item>
            <a-menu-item v-if="detailsData.demand.policies.pushDemand">
              <a @click="dialogVisible_1 = true"><span class="iconfont fz12">&#xe64e;</span>推送</a>
            </a-menu-item>
            <a-menu-item v-if="detailsData.demand.policies.beginTestDemand">
              <a @click="dialogVisible=true"><span class="iconfont fz12">&#xe63c;</span>更新测试</a>
            </a-menu-item>
            <a-menu-item v-if="detailsData.demand.policies.completeDemand">
              <a @click="dialogVisible2=true"><span class="iconfont fz12">&#xe647;</span>验收完成</a>
            </a-menu-item>
            <a-menu-item v-if="detailsData.demand.policies.updateDemand">
              <a @click="toEdit"><span class="iconfont fz12">&#xe637;</span>编辑需求</a>
            </a-menu-item>
            <a-menu-item v-if="detailsData.demand.policies.pauseDemand">
              <a @click="dialogVisible4=true"><span class="iconfont fz12">&#xe64c;</span>暂停</a>
            </a-menu-item>
            <a-menu-item v-if="detailsData.demand.policies.continueDemand">
              <a @click="continueDemands"><span class="iconfont fz12">&#xe635;</span>继续开启</a>
            </a-menu-item>
            <a-menu-item v-if="detailsData.demand.policies.revocationDemand">
              <a @click="dialogVisible5=true"><span class="iconfont fz12">&#xe657;</span>撤销</a>
            </a-menu-item>
            <a-menu-item>
              <a @click="attention(detailsData.demand.id)">
                <span v-if="!detailsData.demand.is_attention"><span class="iconfont fz12"
                        style="color:#FEBC2E">&#xe64f;</span>标记关注 </span>
                <span v-else><span class="iconfont fz12 sign">&#xe64f;</span>取消关注 </span>
              </a>
            </a-menu-item>
          </a-menu>
        </a-dropdown>
      </div>

      <div class="con">
        <div class="top">
          <div style="margin-bottom: 10px;">
            <span class="proName">{{detailsData.demand.name}}</span>

          </div>
          <div style="position: relative;">
            <span class="button_box_text"
                  v-if="detailsData.demand.priority===1">1</span>
            <span class="button_box_text button_box_color2"
                  v-if="detailsData.demand.priority===2">2</span>
            <span class="button_box_text button_box_color3"
                  v-if="detailsData.demand.priority===3">3</span>
            <span class="button_box_text button_box_color4"
                  v-if="detailsData.demand.priority===4">4</span>
            <span class="button_box_text button_box_color5"
                  v-if="detailsData.demand.priority===5">5</span>
            <span class="short-line" v-if="detailsData.demand.priority"></span>
            <span class="tip_button">
              <span v-for="(its,ind) in detailsData.demand.labels"
                 :key="ind"
                 :style="{'background':its.style}">{{its.name}}</span>
            </span>
            <span class="short-line" v-if="detailsData.demand.labels&&detailsData.demand.labels.length"></span>
            <span>{{detailsData.demand.number}}</span>
            <span class="short-line" v-if="detailsData.demand.number"></span>
            <span>{{detailsData.demand.created_at}}</span>
            <span class="short-line" v-if="detailsData.demand.created_at"></span>
            <span style="cursor: pointer;">
                <span class="icon iconfont ico-color"
                    @click="getLogs"
                    style="color:#FF4A4A;font-size:13px"
                    v-if="detailsData.demand.status===0">&#xe654; <span class="status_txt">待审核</span> </span>
                <span class="icon iconfont ico-color"
                    @click="getLogs"
                    style="color:#BBBBBB;font-size:13px"
                    v-if="detailsData.demand.status===1">&#xe654; <span class="status_txt">审核驳回</span></span>
                <span class="icon iconfont ico-color"
                    @click="getLogs"
                    style="color:#FF4A4A;font-size:13px"
                    v-if="detailsData.demand.status===2">&#xe654; <span class="status_txt">待推送</span></span>
                <span class="icon iconfont ico-color"
                    @click="getLogs"
                    style="color:#FF4A4A;font-size:13px"
                    v-if="detailsData.demand.status===3">&#xe654; <span class="status_txt">待指派</span></span>
                <span class="icon iconfont ico-color"
                    @click="getLogs"
                    style="color:#FF4A4A;font-size:13px"
                    v-if="detailsData.demand.status===4">&#xe654; <span class="status_txt">未处理</span></span>
                <span class="icon iconfont ico-color"
                    @click="getLogs"
                    style="color:#FEBC2E;font-size:13px"
                    v-if="detailsData.demand.status===5">&#xe654; <span class="status_txt">研发中</span></span>
                <span class="icon iconfont ico-color"
                    @click="getLogs"
                    style="color:#FEBC2E;font-size:13px"
                    v-if="detailsData.demand.status===6">&#xe653; <span class="status_txt">已提交</span></span>
                <span class="icon iconfont ico-color"
                    @click="getLogs"
                    style="color:#FEBC2E;font-size:13px"
                    v-if="detailsData.demand.status===7">&#xe654; <span class="status_txt">待测试</span></span>
                <span class="icon iconfont ico-color"
                    @click="getLogs"
                    style="color:#FEBC2E;font-size:13px"
                    v-if="detailsData.demand.status===8">&#xe654; <span class="status_txt">测试中</span></span>
                <span class="icon iconfont ico-color"
                    @click="getLogs"
                    style="color:#3DCCA6;font-size:13px"
                    v-if="detailsData.demand.status===9">&#xe653; <span class="status_txt">已完成</span></span>
                <span class="icon iconfont ico-color"
                    @click="getLogs"
                    style="color:#FEBC2E;font-size:13px"
                    v-if="detailsData.demand.status===10">&#xe654;<span class="status_txt">已暂停</span></span>
                <span class="icon iconfont ico-color"
                    @click="getLogs"
                    style="color:#BBBBBB;font-size:13px"
                    v-if="detailsData.demand.status===11">&#xe654;<span class="status_txt">已撤销</span></span>
            </span>
          </div>
        </div>
      </div>
      <div class="con">
        <el-tabs type="border-card"
                 class="tab-boxs">
          <el-tab-pane>
            <span slot="label"><i class="tabs-ico"></i> 基本信息</span>
            <div class="info-detial">
                <p>
                  <span class="info-detial-left">项目来源：</span>
                  <span style="color:#378EEF;"
                        v-if="detailsData.demand.project">
                        <router-link :to="{ name: 'proDetails', query: { id: detailsData.demand.project.id }}" target="_blank">{{detailsData.demand.project.number}}</router-link>
                  </span>
                  <span v-else>--</span>
                </p>
                <p>
                    <span class="info-detial-left"
                        >所属产品线：</span>
                    <span v-if="detailsData.demand.product_category">{{detailsData.demand.product_category.product_line.name}}</span>
                <p>
                <p>
                    <span class="info-detial-left"
                        >所属产品：</span>
                    <span v-if="detailsData.demand.product_category">{{detailsData.demand.product_category.product.name}}</span>
                <p>
                <p>
                    <span class="info-detial-left"
                        >所属模块：</span>
                    <span v-if="detailsData.demand.product_category.product_modules&&detailsData.demand.product_category.product_modules.length >0">
                                <span v-for="(its,ind) in detailsData.demand.product_category.product_modules"
                                    style="margin-right:10px"
                                    :key="ind"
                                    >{{detailsData.demand.product_category.product.name}}/{{its.name}}
                                    <span v-if="its.product_labels.length">
                                            (<span v-for="(item,index) in its.product_labels" :key="index"> {{item.name}} <span v-if="index!==its.product_labels.length-1">,</span></span>)
                                    </span>
                                    <span>;</span>
                                </span>
                    </span>
                <p>
                <span class="info-detial-left">需要ta关注：</span>
                <span v-if="detailsData.demand.user_attention.length">
                <span style="margin-right:20px;"
                        v-for="(user,index) in detailsData.demand.user_attention"
                        :key="index">{{user.user_name}}
                </span>
                </span>
                <span v-else>--</span>
                </p>
            </div>

          </el-tab-pane>
          <el-tab-pane>
            <span slot="label"><i class="tabs-ico"></i> 受理情况</span>
            <div class="info-detial">

                <p>
                  <span class="info-detial-left">诉求来源：</span>
                  <span v-if="detailsData.demand.appeals.length">
                    <span
                          v-for="(appeal,index) in detailsData.demand.appeals"
                          :key="index">
                           <router-link :to="{ name: 'claimDetail', query: { id: appeal.id }}" target="_blank">{{appeal.number}}</router-link>
                           <span v-if="index!==detailsData.demand.appeals.length-1"> /</span>
                    </span>
                  </span>
                  <span v-else>--</span>
                </p>
                <p>
                  <span class="info-detial-left">由谁发布：</span>
                  <span>{{detailsData.demand.promulgator_name}} 于 {{detailsData.demand.created_at}}</span>
                </p>
                <p>
                  <span class="info-detial-left">预计交付：</span>
                  <span>{{detailsData.demand.expiration_date ? detailsData.demand.expiration_date : '--'}}</span>
                </p>
                <p>
                  <span class="info-detial-left">由谁审核：</span>
                  <span>{{detailsData.demand.principal_user_name}}</span>
                </p>
                <p>
                  <span class="info-detial-left">由谁负责：</span>
                  <span v-for="item in detailsData.demand.demand_links" :key="item.id" style="margin-right:20px;">
                      <span v-if="item.type===1">设计负责人:</span>
                      <span v-if="item.type===2">开发负责人:</span>
                      <span v-if="item.type===3">测试负责人:</span>
                  {{item.principal_user_name}}</span>
                </p>
                <p>
                  <span class="info-detial-left">当前状态：</span>
                  <span class="icon iconfont ico-color"
                        style="color:#FF4A4A;font-size:13px"
                        v-if="detailsData.demand.status===0">&#xe654; <span class="status_txt">待审核</span> </span>
                  <span class="icon iconfont ico-color"
                        style="color:#BBBBBB;font-size:13px"
                        v-if="detailsData.demand.status===1">&#xe654; <span class="status_txt">审核驳回</span></span>
                  <span class="icon iconfont ico-color"
                        style="color:#FF4A4A;font-size:13px"
                        v-if="detailsData.demand.status===2">&#xe654; <span class="status_txt">待推送</span></span>
                  <span class="icon iconfont ico-color"
                        style="color:#FF4A4A;font-size:13px"
                        v-if="detailsData.demand.status===3">&#xe654; <span class="status_txt">待指派</span></span>
                  <span class="icon iconfont ico-color"
                        style="color:#FF4A4A;font-size:13px"
                        v-if="detailsData.demand.status===4">&#xe654; <span class="status_txt">未处理</span></span>
                  <span class="icon iconfont ico-color"
                        style="color:#FEBC2E;font-size:13px"
                        v-if="detailsData.demand.status===5">&#xe654; <span class="status_txt">研发中</span></span>
                  <span class="icon iconfont ico-color"
                        style="color:#FEBC2E;font-size:13px"
                        v-if="detailsData.demand.status===6">&#xe653; <span class="status_txt">已提交</span></span>
                  <span class="icon iconfont ico-color"
                        style="color:#FEBC2E;font-size:13px"
                        v-if="detailsData.demand.status===7">&#xe654; <span class="status_txt">待测试</span></span>
                  <span class="icon iconfont ico-color"
                        style="color:#FEBC2E;font-size:13px"
                        v-if="detailsData.demand.status===8">&#xe654; <span class="status_txt">测试中</span></span>
                  <span class="icon iconfont ico-color"
                        style="color:#3DCCA6;font-size:13px"
                        v-if="detailsData.demand.status===9">&#xe653; <span class="status_txt">已完成</span></span>
                  <span class="icon iconfont ico-color"
                        style="color:#FEBC2E;font-size:13px"
                        v-if="detailsData.demand.status===10">&#xe654;<span class="status_txt">已暂停</span></span>
                  <span class="icon iconfont ico-color"
                        style="color:#BBBBBB;font-size:13px"
                        v-if="detailsData.demand.status===11">&#xe654;<span class="status_txt">已撤销</span></span>
                </p>
            </div>
          </el-tab-pane>
          <el-tab-pane>
            <span slot="label"><i class="tabs-ico"></i> 任务进展</span>

            <div class="info-detial">
                <p style="color:#FEBC2E;"
                   class="mb20 color">
                <!-- 设计类型；0：分阶段设计；1：同时设计；2：设计优先； -->
                   <span v-if="detailsData.demand.design_type===0">【分阶段设计】</span>
                   <span v-if="detailsData.demand.design_type===1">【同时设计】</span>
                   <span v-if="detailsData.demand.design_type===2">【设计优先】</span>
                   <span v-for="(item,index) in detailsData.demand.design_roles" :key="index">
                       <span v-if="item==0">交互</span>
                       <span v-if="item==1">视觉</span>
                       <span v-if="item==2">美工</span>
                       <span v-if="item==3">前端</span>
                       <span v-if="item==4">移动端</span>
                       <span v-if="index!==detailsData.demand.design_roles.length-1"> + </span>
                   </span>
                </p>
                <table style="width:620px"
                       class="table">
                  <thead>
                    <tr>
                      <th>研发环节</th>
                      <th>任务ID</th>
                      <th>负责人</th>
                      <th>跟进人</th>
                      <th>状态</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item,index) in taskData"
                        :key="index">
                      <th v-if="item.type==='design'">设计
                        <span v-if="item.role_type===0">(交互)</span>
                        <span v-if="item.role_type===1">(视觉)</span>
                        <span v-if="item.role_type===2">(美工)</span>
                        <span v-if="item.role_type===3">(前端)</span>
                        <span v-if="item.role_type===4">(移动端)</span>
                      </th>
                      <th v-if="item.type==='dev'">开发</th>
                      <th v-if="item.type==='test'">测试</th>
                      <th>
                            <span  class="tree" v-if="item.task_type===1">总</span>
                            <span v-if="item.type==='design'">
                                <span  class="tree" style="background:rgba(62,204,166,.2);color:rgba(62,204,166,1)" v-if="item.task_type===3">子</span>
                                <span  class="tree" style="background:rgba(254,188,46,.2);color:rgba(254,188,46,1)" v-if="item.task_type===2">子</span>
                            </span>
                            <span v-else>
                                <span  class="tree" style="background:rgba(62,204,166,.2);color:rgba(62,204,166,1)" v-if="item.task_type===3">子</span>
                            </span>
                          {{item.number}}
                      </th>
                      <th>{{item.principal_user_name}}</th>
                      <th>{{item.follower_name}}</th>
                      <th>
                            <span style="color:#FF4A4A;" v-if="item.status_desc=='待审核'">{{item.status_desc}}</span>
                            <span style="color:#FF4A4A;" v-if="item.status_desc=='待发布'">{{item.status_desc}}</span>
                            <span style="color:#FF4A4A;" v-if="item.status_desc=='待指派'">{{item.status_desc}}</span>
                            <span style="color:#FF4A4A;" v-if="item.status_desc=='等待中'">{{item.status_desc}}</span>
                            <span style="color:#FEBC2E;" v-if="item.status_desc=='未开始'">{{item.status_desc}}</span>
                            <span style="color:#FEBC2E;" v-if="item.status_desc=='进行中'">{{item.status_desc}}</span>
                            <span style="color:#FEBC2E;" v-if="item.status_desc=='待测试'">{{item.status_desc}}</span>
                            <span style="color:#FEBC2E;" v-if="item.status_desc=='测试中'">{{item.status_desc}}</span>
                            <span style="color:#FEBC2E;" v-if="item.status_desc=='已提交'">{{item.status_desc}}</span>
                            <span style="color:#FEBC2E;" v-if="item.status_desc=='已暂停'">{{item.status_desc}}</span>
                            <span style="color:#3DCCA6;" v-if="item.status_desc=='已完成'">{{item.status_desc}}</span>
                            <span style="color:#BBBBBB;" v-if="item.status_desc=='已撤销'">{{item.status_desc}}</span>
                      </th>
                    </tr>
                  </tbody>
                </table>
            </div>
          </el-tab-pane>
        </el-tabs>
        <div class="con info-description">
          <h3 style="margin-bottom: 30px">
            <i class="tabs-ico"></i>
            需求描述
          </h3>
          <p class="mb10">需求描述: </p>
          <myViewer :html="detailsData.demand.content"></myViewer>
        </div>
        <div class="con" style="padding:10px 0;margin-bottom: 0px;">
          <h3 style="margin-bottom: 30px"><i class="tabs-ico"></i> 其他信息</h3>
          <div class="info">
            <h4 class="mb20">原型/需求文档</h4>
            <p class="mb20">url共享: <span  v-if="!detailsData.demand.share_address" style="margin-left:20px">暂无数据</span></p>
            <div v-if="detailsData.demand.share_address">
                  <div class="mb10"  v-for="(item,index) in detailsData.demand.share_address" :key="index">
                    <a  style="word-break:break-all;" :href="item" target="_blank" >{{item}}</a>
                  </div>
            </div>

            <p style="margin-bottom:10px">附件:
              <span @click="toggle"
                    class="cup"
                    style="margin-left:20px"
                    v-if="detailsData.demand.media.length>0">
                <span v-if="expand"
                      >收起 <span class="iconfont cup fz12" style="color:#BBBBBB">&#xe607;</span></span>
                <span v-else
                      >展开 <span class="iconfont cup fz12" style="color:#BBBBBB">&#xe605;</span></span>
              </span>
              <span style="margin-left:20px"
                    v-else>暂无数据</span>
            </p>
            <downMedia :media="detailsData.demand.media"
                       v-if="detailsData.demand.media.length>0"
                       v-show="expand"></downMedia>

          </div>
          <div class="info" v-if="detailsData.docs.design">
            <h4 class="mb20">设计文稿</h4>
            <p class="mb20">url共享:<span style="margin-left:20px" v-if="!detailsData.docs.design.share_address">暂无数据</span></p>
            <div  v-if="detailsData.docs.design.share_address">
                    <div class="mb10"
                        v-for="(item,index) in detailsData.docs.design.share_address"
                        :key="index">
                    <a :href="item" target="_blank" >{{item}}</a>
                    </div>
            </div>

            <p style="margin-bottom:10px">附件:
              <span @click="toggle2"
                    class="cup"
                    style="margin-left:20px"
                    v-if="detailsData.docs.design.media.length>0">
                <span v-if="expand2"
                      >收起 <span class="iconfont cup fz12" style="color:#BBBBBB">&#xe607;</span></span>
                <span v-else
                      >展开 <span class="iconfont cup fz12" style="color:#BBBBBB">&#xe605;</span></span>
              </span>
              <span style="margin-left:20px"
                    v-else>暂无数据</span>
            </p>
            <downMedia :media="detailsData.docs.design.media"
                       v-if="detailsData.docs.design.media.length>0"
                       v-show="expand2"></downMedia>
          </div>
          <div class="info" v-if="detailsData.docs.dev">
            <h4 class="mb20">开发文档</h4>
            <p class="mb20">url共享:<span style="margin-left:20px" v-if="!detailsData.docs.dev.share_address">暂无数据</span></p>
            <div v-if="detailsData.docs.dev.share_address">
                <div class="mb10"
                    v-for="(item,index) in detailsData.docs.dev.share_address"
                    :key="index">
                <a :href="item" target="_blank" >{{item}}</a>
                </div>
            </div>
            <p style="margin-bottom:10px">附件:
              <span @click="toggle3"
                    class="cup"
                    style="margin-left:20px"
                    v-if="detailsData.docs.dev.media.length>0">
                <span v-if="expand3"
                      >收起 <span class="iconfont cup fz12" style="color:#BBBBBB">&#xe607;</span></span>
                <span v-else
                      >展开 <span class="iconfont cup fz12" style="color:#BBBBBB">&#xe605;</span></span>
              </span>
              <span style="margin-left:20px"
                    v-else>暂无数据</span>
            </p>
            <downMedia :media="detailsData.docs.dev.media"
                       v-if="detailsData.docs.dev.media.length>0"
                       v-show="expand3"></downMedia>
          </div>
          <div class="info" v-if="detailsData.docs.test">
            <h4 class="mb20">测试文档</h4>
            <p class="mb20">url共享:<span style="margin-left:20px" v-if="!detailsData.docs.test.share_address">暂无数据</span></p>
            <div class="mb10"
                 v-for="(item,index) in detailsData.docs.test.share_address"
                 :key="index">
              <a :href="item" target="_blank" >{{item}}</a>
            </div>

            <p style="margin-bottom:10px">附件:
              <span @click="toggle4"
                    style="margin-left:20px"
                    class="cup"
                    v-if="detailsData.docs.test.media.length>0">
                <span v-if="expand4"
                      >收起 <span class="iconfont cup fz12" style="color:#BBBBBB">&#xe607;</span></span>
                <span v-else
                      >展开 <span class="iconfont cup fz12" style="color:#BBBBBB">&#xe605;</span></span>
              </span>
              <span style="margin-left:20px"
                    v-else>暂无数据</span>
            </p>
            <downMedia :media="detailsData.docs.test.media"
                       v-if="detailsData.docs.test.media.length>0"
                       v-show="expand4"></downMedia>
          </div>
          <div class="info" style="margin-bottom:0;">
            <h3 style="margin-bottom: 30px">操作记录：</h3>
            <operationLogs :data="detailsData.demand.operation_logs"></operationLogs>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>
<style lang="less" scoped>
    /deep/.ant-dropdown-menu-item a {
            padding-left:20px !important;
            span{
                margin-right:10px;
            }
    }
    .status_txt{
        vertical-align: baseline;
        padding-left: 4px;
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

    /deep/.el-popover {
    border-radius: 4px;
    }
    /deep/ .el-dialog__header {
    padding: 12px 20px;
    border-bottom: 1px solid #eeeeee;
    background: #eee;
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
    .tip_button {
    //   width: 300px;
    //   display: flex;
    // box-shadow:0px 5px 15px 0px rgba(223,226,230,0.8);
    //   border-radius: 4px;
    //   flex-wrap: wrap;
    }
    .tip_button span {
    padding: 0 6px;
    margin: 0 0 6px 6px;
    height: 24px;
    line-height: 22px;
    color: #fff;
    font-size: 12px;
    border-radius: 3px;
    }
    .comment {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
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
    .radio_box .contxt {
    padding: 30px 0;
    font-size: 16px;
    text-align: center;
    line-height: 1;
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
    .radio_box_button {
    padding-bottom: 10px;
    }
    .modal-box /deep/.el-dialog__footer {
    padding: 20px;
    }
    .modal-box-two /deep/ .el-dialog__footer {
    text-align: center;
    }
    .downLoad {
    font-size: 12px;
    color: #378eef;
    margin-right: 4px;
    }
    .fz12 {
    font-size: 12px;
    }
    .tac {
    text-align: center;
    }
    .mb10 {
    margin-bottom: 10px;
    }
    .mb20 {
    margin-bottom: 20px;
    }
    .cup {
    cursor: pointer;
    }
    .download {
    margin-left: 12px;
    margin-right: 4px;
    vertical-align: middle;
    }
    .fl {
    float: left;
    margin-top: 6px;
    margin-right: 10px;
    }
    .flr {
    float: left;
    }

    .showFile {
    padding: 20px;
    width: 100%;
    // height: 201px;
    background: rgba(248, 248, 248, 1);
    border-radius: 3px;
    .fileList {
        display: flex;
        flex-wrap: wrap;
        .txt {
        position: relative;
        top: -30px;
        left: 30px;
        }
    }
    .fileDown {
        line-height: 1;
        width: 33.3%;
        height: 30px;
        margin-bottom: 20px;
    }
    .flieAction {
        position: relative;
        bottom: 0;
        border-top: 1px solid #f8f8f8;
        height: 32px;
        line-height: 32px;
        a {
        margin-left: 20px;
        }
    }
    }

    h3 {
    font-size: 14px;
    font-family: Microsoft YaHei;
    font-weight: bold;
    color: rgba(51, 51, 51, 1);
    }
    h4 {
    font-weight: bold;
    color: #666666;
    }
    h1 {
    font-size: 16px;
    font-family: Microsoft YaHei;
    font-weight: bold;
    color: rgba(51, 51, 51, 1);
    }
    span {
    color: #666;
    }
    .short-line {
    display: inline-block;
    margin: 0 10px;
    width: 1px;
    height: 14px;
    background: rgba(238, 238, 238, 1);
    position: relative;
    top: 2px;
    }
    .box {
    padding: 0 20px;
    position: relative;
    left: 50%;
    transform: translateX(-50%);
    width: 1200px;
    // height:1511px;
    background: rgba(255, 255, 255, 1);
    box-shadow: 0px 5px 15px 0px rgba(223, 226, 230, 0.8);
    border-radius: 4px;
    .header {
        margin-bottom: 22px;
        height: 54px;
        border-bottom: 1px solid rgba(238, 238, 238, 1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        .operation {
            cursor: pointer;
            color: rgba(55, 142, 239, 1);
            i {
                font-size: 12px;
            }
            .cz {
                margin-left: 4px;
                color: rgba(55, 142, 239, 1);
            }
            }
            p {
            color: #378eef;
            cursor: pointer;
            font-size: 12px;
            i {
                display: inline-block;
                margin-right: 4px;
            }
        }
    }
    }
    .con {
    padding: 10px;
    margin-bottom: 20px;
    .top {
        position: relative;
        height: 62px;
        .text-button {
        display: inline-block;
        margin-left: 4px;
        img {
            width: 20px;
            height: 10px;
            display: inline-block;
        }
        }
        .imPro {
        display: inline-block;
        text-align: center;
        line-height: 18px;
        padding: 0 4px;
        height: 18px;
        background: rgba(255, 74, 74, 0.2);
        margin-right: 4px;
        border-radius: 2px;
        font-size: 12px;
        color: rgba(255, 74, 74, 1);
        }
        .imPro-blue {
        background: rgba(55, 142, 239, 0.2);
        border-radius: 3px;
        color: #378eef;
        }
        .proName {
        display: inline-block;

        font-size: 14px;
        font-family: Microsoft YaHei;
        font-weight: bold;
        color: rgba(51, 51, 51, 1);
        }

        .level {
        display: inline-block;
        width: 14px;
        height: 14px;
        text-align: center;
        line-height: 14px;
        background: rgba(255, 74, 74, 0.2);
        border-radius: 2px;
        font-size: 12px;
        color: rgba(255, 74, 74, 1);
        }
    }
    }
    /deep/ .el-tabs--border-card > .el-tabs__header {
    background-color: #fff;
    }
    /deep/.el-tabs--border-card {
    box-shadow: none;
    border: none;
    }
    .tab-boxs/deep/ .el-tabs__header .el-tabs__item {
    border: 1px solid #eee;
    border-top: 2px solid #eee;
    background: #f8f8f8;
    margin-left: 2px;
        border-top-right-radius: 8px;

    span {
        color: #232323;
        font-size: 14px;
        font-weight: bold;
    }

    /* background: #ddd; */
    }
    .tab-boxs/deep/ .el-tabs__header .el-tabs__item:first-child {
    margin-left: 0px;
    }
    .tab-boxs/deep/ .el-tabs__header .el-tabs__item.is-active {
    background: #fff;
    border-bottom: 1px solid #fff;
    }
    .tab-boxs /deep/ .el-tabs__content {
    padding: 30px 0px;
        margin-bottom:10px;
    }
    .tabs-ico {
    display: inline-block;
    width: 15px;
    height: 20px;
    background: url("../../../assets/images/tabs-01.png") no-repeat;
    background-position: 0px 8px;
    }
    .table {
    thead {
        color: #bbbbbb;
        tr {
        height: 30px;
        }
    }
    tbody {
        .son {
        display: inline-block;
        width: 18px;
        height: 18px;
        text-align: center;
        line-height: 18px;
        background: rgba(62, 204, 166, 0.2);
        border-radius: 3px;
        color: rgba(62, 204, 166, 1);
        }
        tr {
        height: 30px;
        }
    }
    }
    .info-detial {
    height: 142px;
    overflow-y: auto;
    .color{
        span{
            color:#FEBC2E;
        }
    }
    p {
        margin-bottom: 20px;
        span {
        color: #666;
        font-size: 12px;
        }
        .info-detial-left {
        text-align: right;
        display: inline-block;
        margin-right: 14px;
        min-width: 72px;
        }
    }
    }
    .info-description {
        margin-bottom: 0px;
        padding:10px 0;
    ul {
        display: flex;
        li {
        height: 150px;
        margin: 10px 10px 10px 0;
        img {
            height: 100%;
        }
        }
    }
    }
    .info {
    margin-bottom: 30px;
    p {
        font-size: 12px;
        font-family: Microsoft YaHei;
        font-weight: 400;
        color: rgba(102, 102, 102, 1);
    }
    .Mperson {
        background: rgba(253, 218, 66, 1);
        margin-right: 12px;
        display: inline-block;
        padding-right: 10px;
        height: 34px;
        border-radius: 17px;
        line-height: 34px;
        .avatar {
        margin-right: 10px;
        vertical-align: middle;
        margin-bottom: 2px;
        }
    }
    .info-time-box {
        li {
        display: flex;
        padding-bottom: 0px;
        .info-time {
            display: inline-block;
        }
        .info-time-line {
            position: relative;
            margin-left: 20px;
        }
        .el-timeline-item__wrapper {
            top: -1px;
        }
        .line-detial-box {
            p {
            color: #666;
            font-size: 12px;
            padding-bottom: 10px;
            span {
                font-size: 12px;
            }
            }
            .line-detial {
            display: none;
            padding: 0px 10px 0 10px;
            p {
                color: #666;
                font-size: 12px;
                padding-bottom: 10px;
                span {
                cursor: pointer;
                }
            }
            }
        }
        .el-timeline .el-timeline-item:last-child .el-timeline-item__tail {
            display: none;
        }
        }
        .el-timeline-item.active .line-detial {
        display: block;
        }
    }
    }
</style>
<script>
import myViewer from '@/components/myViewer'
import downMedia from '@/components/downMedia'
import operationLogs from '@/components/operationLogs'
import { attentionDemands, getDemandsDetails, testDemands, completeDemands, demandChangeLog, getDemandsTask, cancelConfirmDemands, confirmDemands, pushDemands, continueDemands, revokeDemands, verifyDemands, stopDemands } from '@/api/RDmanagement/product'
const columns = [
  {
    title: '时间',
    dataIndex: 'created_at',
    key: 'created_at'
  },
  {
    title: '状态',
    dataIndex: 'status',
    key: 'status',
    width: 80,
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
    dataIndex: 'comment',
    scopedSlots: { customRender: 'comment' }
  }
]
export default {
  components: { downMedia, operationLogs, myViewer },
  data () {
    return {
      dialogVisible: false,
      dialogVisible2: false,
      dialogVisible3: false,
      dialogVisible4: false,
      dialogVisible5: false,
      dialogVisible6: false,
      dialogVisible_1: false,
      data: [],
      taskData: {
      },
      btnLoad: false,
      columns,
      textarea: '',
      expand: true,
      expand2: true,
      expand3: true,
      expand4: true,
      showline: true,
      activeClass: 0,
      radio: 1,
      detailsData: undefined
    }
  },
  mounted () {
    this.$nextTick(() => {
      this.getDetails()
    })
    getDemandsTask(this.$route.query.id).then(res => {
      this.taskData = res.data
    })
  },
  methods: {
    ok () {
      this.btnLoad = true
      pushDemands(this.$route.query.id).then(res => {
        if (res.code === 200) {
          this.$message.success('推送成功')
          this.getDetails()
          this.btnLoad = false
          this.dialogVisible_1 = false
        }
      }).catch(error => {
        this.btnLoad = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    // 撤销需求
    revokeDemand (formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          this.btnLoad = true
          revokeDemands(this.$route.query.id, this.textarea).then(res => {
            if (res.code === 200) {
              this.$message.success('需求已撤销')
              this.dialogVisible5 = false
              this.getDetails()
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
    // 需求暂停
    stopDemand (formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          this.btnLoad = true
          stopDemands(this.$route.query.id, this.textarea).then(res => {
            if (res.code === 200) {
              this.dialogVisible4 = false
              this.$message.success('需求暂停')
              this.getDetails()
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
    // 立项审核
    verifyDemand () {
      let params = { result: this.radio }
      if (this.textarea) {
        params.comment = this.textarea
      }
      this.btnLoad = true
      verifyDemands(this.$route.query.id, params).then(res => {
        if (res.code === 200) {
          this.$message.success('审核完成')
          this.dialogVisible6 = false
          this.textarea = ''
          this.getDetails()
          this.btnLoad = false
        }
      }).catch(error => {
        this.btnLoad = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    continueDemands () {
      continueDemands(this.$route.query.id).then(res => {
        if (res.code === 200) {
          this.$message.success('需求继续')
          this.getDetails()
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    confirm () {
      confirmDemands(this.$route.query.id).then(res => {
        if (res.code === 200) {
          if (res.code === 200) {
            this.$message.success('确认成功')
            this.getDetails()
          }
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    disconfirm () {
      cancelConfirmDemands(this.$route.query.id).then(res => {
        if (res.code === 200) {
          this.$message.success('取消确认')
          this.getDetails()
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    getLogs () {
      demandChangeLog(this.$route.query.id).then(res => {
        this.dialogVisible3 = true
        if (res.code === 200) {
          this.data = res.data.status_logs
        }
      })
    },
    toEdit () {
      this.$router.push({ name: 'editDemand', query: { id: this.detailsData.demand.id } })
    },
    // 验收完成
    completeDemand () {
      completeDemands(this.$route.query.id, this.textarea).then(res => {
        if (res.code === 200) {
          this.$message.success('需求已验收完成')
          this.dialogVisible2 = false
          this.textarea = ''
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    // 测试
    testDemand () {
      testDemands(this.$route.query.id).then(res => {
        if (res.code === 200) {
          this.dialogVisible = false
          this.$message.success('需求开始测试')
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    getDetails () {
      getDemandsDetails(this.$route.query.id).then(res => {
        if (res.code === 200) {
          this.detailsData = res.data
          this.detailsData.demand.operation_logs = this.detailsData.demand.operation_logs.map(item => {
            return { show: false, ...item }
          })
        }
      })
    },
    // 关注,取消关注
    attention (id) {
      attentionDemands(id).then(res => {
        if (res.code === 200) {
          this.detailsData.demand.is_attention = !this.detailsData.demand.is_attention
          if (this.detailsData.demand.is_attention) {
            this.$message.success('关注成功')
          } else {
            this.$message.error('取消关注')
          }
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    toggle () {
      this.expand = !this.expand
    },
    toggle2 () {
      this.expand2 = !this.expand2
    },
    toggle3 () {
      this.expand3 = !this.expand3
    },
    toggle4 () {
      this.expand4 = !this.expand4
    },
    toggleClass (index) {
      this.activeClass = index // 把当前点击元素的index，赋值给activeClass
    }
  }
}
</script>
