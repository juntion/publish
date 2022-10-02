<template>
  <div>
    <div class="box">
      <div class="header">
        <h1>诉求详情</h1>
        <p>
          <a-dropdown :trigger="['click']"
                      placement='bottomCenter'>
            <div class="operation">
              <i class="icon iconfont"
                 style="color:#378EEF;font-size:12px;vertical-align: top;">&#xe632;</i>
              <span class="cz"
                    style="position: relative;top: -1px;color: #378EEF">操作</span>
            </div>
            <a-menu slot="overlay"
                    style="width:120px;text-align: left;">
              <a-menu-item v-if="datas.policies.apply">
                <a @click="clickSuccess(1,datas.id)"><span class="iconfont fz12">&#xe644;</span>认领</a>
              </a-menu-item>
                <a-menu-item v-if="datas.policies.applyCancel">
                <a @click="clickSuccess(2,datas.id)"><span class="iconfont fz12" style="color:#FEBC2E;">&#xe644;</span>取消认领</a>
              </a-menu-item>
                <a-menu-item v-if="datas.policies.verify">
                <a @click="dialogVisible4 = true"><span class="iconfont fz12">&#xe645;</span>更新审核</a>
              </a-menu-item>
                <a-menu-item v-if="datas.policies.createDemand">
                <a @click="clickSuccess(4,datas.id,datas)"><span class="iconfont fz12">&#xe63a;</span>立项</a>
              </a-menu-item>
                <a-menu-item v-if="datas.policies.cancelDemand">
                <a @click="clickSuccess(3,datas.id)"><span class="iconfont fz12" style="color:#FEBC2E;">&#xe63a;</span>取消立项</a>
              </a-menu-item>
                <a-menu-item v-if="datas.demand_id">
                <a @click="clickSuccess(5,datas.demand_id)"><span class="iconfont fz12">&#xe62a;</span>立项详情</a>
              </a-menu-item>
              <a-menu-item v-if="datas.policies.disassemble">
                <a @click="clickSuccess(6,datas.id)"><span class="iconfont fz12">&#xe63b;</span>拆解诉求</a>
              </a-menu-item>
               <a-menu-item v-if="datas.policies.labels">
                <a  @click="clickSuccess(7,datas)"><span class="iconfont fz12"></span>贴标签</a>
              </a-menu-item>
               <a-menu-item v-if="datas.policies.edit">
                <a @click="loacalclaim"><span class="iconfont fz12">&#xe637;</span>编辑诉求</a>
              </a-menu-item>
               <a-menu-item v-if="datas.policies.revocation">
                <a @click="clickSuccess(8,datas.id)"><span class="iconfont fz12">&#xe657;</span>撤销</a>
              </a-menu-item>
              <a-menu-item>
                <a @click="attention(datas.id)">
                  <span v-if="!datas.is_attention"><span class="iconfont fz12"
                          style="color:#FEBC2E">&#xe64f;</span>标记关注 </span>
                  <span v-else><span class="iconfont fz12 sign">&#xe64f;</span>取消关注 </span>
                </a>
              </a-menu-item>
            </a-menu>
          </a-dropdown>

        </p>
      </div>

      <div class="con"
           style="margin-bottom:17px;">
        <div class="top">
          <div style="margin-bottom: 10px;">
            <span class="proName">{{datas.name}}</span>
            <div data-v-1618823f=""
                 v-if="datas.questions"
                 class="text-button">
              <a-popover placement="bottomLeft"
                         :getPopupContainer="triggerNode => triggerNode.parentNode"
                         arrowPointAtCenter>
                <template slot="content"
                          v-if="JSON.parse(datas.questions).urgent">
                  <div style="padding:10px">
                    <p style="color:#bbb">{{JSON.parse(datas.questions).urgent[0].question}}:</p>
                    <p>{{JSON.parse(datas.questions).urgent[0].answer}}</p>
                    <p style="color:#bbb">{{JSON.parse(datas.questions).urgent[1].question}}:</p>
                    <p>{{JSON.parse(datas.questions).urgent[1].answer}}</p>
                  </div>
                </template>
                <img v-if="datas.is_urgent"
                     src="@/assets/images/urg.png"
                     alt="IMG">
              </a-popover>
              <a-popover placement="bottomLeft"
                         :getPopupContainer="triggerNode => triggerNode.parentNode"
                         arrowPointAtCenter>
                <template slot="content"
                          v-if="JSON.parse(datas.questions).important">
                  <div style="padding:10px">
                    <p style="color:#bbb">{{JSON.parse(datas.questions).important[0].question}}:</p>
                    <p>{{JSON.parse(datas.questions).important[0].answer}}</p>
                  </div>
                </template>
                <img v-if="datas.is_important"
                     src="@/assets/images/imp.png"
                     alt="URG">
              </a-popover>

            </div>
          </div>
          <div style="position: relative;">
            <span class="tip_button">
              <span v-for="(its,ind) in datas.labels"
                    :key="ind"
                    :style="{'background':its.style}">{{its.name}}</span>
            </span>
            <span class="short-line" v-if="datas.labels&&datas.labels.length"></span>
            <span>{{datas.number}}</span>
            <span class="short-line" v-if="datas.number"></span>
            <span>{{datas.created_at}}</span>
            <span class="short-line" v-if="datas.created_at"></span>
            <span @click="recordEidtlist" style="cursor: pointer">
              <span class="icon iconfont ico-color"
                    style="color:#FF4A4A;font-size:13px"
                    v-if="datas.status===0">&#xe654; <span class="status_txt">待受理</span> </span>
              <span class="icon iconfont ico-color"
                    style="color:#FEBC2E;font-size:13px"
                    v-if="datas.status===1">&#xe654; <span class="status_txt">跟进中</span></span>
              <span class="icon iconfont ico-color"
                    style="color:#FF4A4A;font-size:13px"
                    v-if="datas.status===2">&#xe654; <span class="status_txt">排期中</span></span>
              <span class="icon iconfont ico-color"
                    style="color:#FF4A4A;font-size:13px"
                    v-if="datas.status===3">&#xe654; <span class="status_txt">立项待审核</span></span>
              <span class="icon iconfont ico-color"
                    style="color:#FF4A4A;font-size:13px"
                    v-if="datas.status===4">&#xe654; <span class="status_txt">已立项</span></span>
              <span class="icon iconfont ico-color"
                    style="color:#3DCCA6;font-size:13px"
                    v-if="datas.status===5">&#xe653; <span class="status_txt">已完成</span></span>
              <span class="icon iconfont ico-color"
                    style="color:#FEBC2E;font-size:13px"
                    v-if="datas.status===6">&#xe654; <span class="status_txt">已驳回</span></span>
              <span class="icon iconfont ico-color"
                    style="color:#FEBC2E;font-size:13px"
                    v-if="datas.status===7">&#xe653; <span class="status_txt">已撤销</span></span>
              <span class="icon iconfont ico-color"
                    style="color:#FEBC2E;font-size:13px"
                    v-if="datas.status===8">&#xe654; <span class="status_txt">待分配</span></span>
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
                <span style="color:#378EEF;"  v-if="datas.source_project_name">
                    <router-link :to="{ name: 'proDetails', query: { id: datas.source_project_id }}" target="_blank">{{datas.source_project_name}}</router-link>
                </span>
                <span v-else>--</span>
              </p>
                <p>
                    <span class="info-detial-left"
                        >所属产品线：</span>
                    <span v-if="datas.product_category">{{datas.product_category.product_line.name}}</span>
                <p>
                <p>
                    <span class="info-detial-left"
                        >所属产品：</span>
                    <span v-if="datas.product_category">{{datas.product_category.product.name}}</span>
                <p>
                <p>
                    <span class="info-detial-left"
                        >所属模块：</span>
                    <span v-if="datas.product_category&&datas.product_category.product_modules&&datas.product_category.product_modules.length >0">
                                <span v-for="(its,ind) in datas.product_category.product_modules"
                                    style="margin-right:10px"
                                    :key="ind"
                                    >{{datas.product_category.product.name}}/{{its.name}}
                                    <span v-if="its.product_labels.length">
                                            (<span v-for="(item,index) in its.product_labels" :key="index"> {{item.name}} <span v-if="index!==its.product_labels.length-1">,</span></span>)
                                    </span>
                                    <span>;</span>
                                </span>
                    </span>
                <p>
              <p>
                <span class="info-detial-left">需要ta关注：</span>
                <span v-if="datas.user_attentions.length">
                  <span v-for="(item , index) in datas.user_attentions"
                        :key="index">
                    {{item.user_name}};&nbsp;&nbsp;
                  </span>
                </span>
              </p>
            </div>
          </el-tab-pane>
          <el-tab-pane>
            <span slot="label"><i class="tabs-ico"></i> 受理情况</span>
            <div class="info-detial">

                <p>
                  <span class="info-detial-left">由谁发布：</span>
                  <span>{{datas.promulgator_name}} <span v-if="datas.promulgator_name">于</span> {{datas.created_at}}</span>
                </p>
                <p>
                  <span class="info-detial-left">由谁负责：</span>
                  <span>{{datas.principal_user_name}} <span v-if="datas.principal_user_name">于</span> {{datas.created_at}}</span>
                </p>
                 <p>
                  <span class="info-detial-left">预计交付：</span>
                  <span>{{datas.expiration_date ? datas.expiration_date : '--'}}</span>
                </p>
                <p>
                  <span class="info-detial-left">由谁跟进：</span>
                  <span v-if="datas.follower_name">{{datas.follower_name}} <span >于</span> {{datas.follow_time}}</span>
                  <span v-if="!datas.follower_name">--</span>
                  <span
                    class="iconfont fz12 cup"
                    style="color:#378EEF;margin-left:10px"
                    v-if="datas.policies.follow"
                    @click="showHandler(datas)">&#xe637;</span>
                </p>
                <p v-if="datas.demand">
                  <span class="info-detial-left">立项情况：</span>
                  <span>{{datas.demand.status_desc}} {{datas.verify_time}}</span> <router-link :to="{ name: 'demandDetails', query: { id: datas.demand.id }}" target="_blank">查看详情</router-link>
                </p>
                <p>
                  <span class="info-detial-left">当前状态：</span>
                  <span class="icon iconfont ico-color"
                        style="color:#FF4A4A;font-size:13px"
                        v-if="datas.status===0">&#xe654; <span class="status_txt">待受理</span> </span>
                  <span class="icon iconfont ico-color"
                        style="color:#FEBC2E;font-size:13px"
                        v-if="datas.status===1">&#xe654; <span class="status_txt">跟进中</span></span>
                  <span class="icon iconfont ico-color"
                        style="color:#FF4A4A;font-size:13px"
                        v-if="datas.status===2">&#xe654; <span class="status_txt">排期中</span></span>
                  <span class="icon iconfont ico-color"
                        style="color:#FF4A4A;font-size:13px"
                        v-if="datas.status===3">&#xe654; <span class="status_txt">立项待审核</span></span>
                  <span class="icon iconfont ico-color"
                        style="color:#FF4A4A;font-size:13px"
                        v-if="datas.status===4">&#xe654; <span class="status_txt">已立项</span></span>
                  <span class="icon iconfont ico-color"
                        style="color:#3DCCA6;font-size:13px"
                        v-if="datas.status===5">&#xe653; <span class="status_txt">已完成</span></span>
                  <span class="icon iconfont ico-color"
                        style="color:#FEBC2E;font-size:13px"
                        v-if="datas.status===6">&#xe654; <span class="status_txt">已驳回</span></span>
                  <span class="icon iconfont ico-color"
                        style="color:#FEBC2E;font-size:13px"
                        v-if="datas.status===7">&#xe653; <span class="status_txt">已撤销</span></span>
                  <span class="icon iconfont ico-color"
                        style="color:#FEBC2E;font-size:13px"
                        v-if="datas.status===8">&#xe654; <span class="status_txt">待分配</span></span>
                   <span style="margin-left:20px" v-if="datas.crux">症结点：{{datas.crux}}</span> <span style="margin-left:20px" v-if="datas.comment">备注：{{datas.comment}}</span>
                </p>

            </div>
          </el-tab-pane>

        </el-tabs>
        <!-- 详情描述 -->
        <div class="con info-description">
          <h3 style="margin-bottom: 30px">
            <i class="tabs-ico"></i>
            诉求描述
          </h3>

          <p style="margin-bottom:10px">
            <myViewer :html="datas.content"></myViewer>
           </p>
        </div>
        <div class="con" style="padding:10px 0;">
          <h3 style="margin-bottom: 30px"><i class="tabs-ico"></i> 其他信息</h3>
          <div class="info">
            <p style="margin-bottom:10px">附件:
              <span @click="toggle" style="cursor: pointer;margin-left:20px"
                  v-if="datas.media.length>0">
                 <span v-if="expand"
                    >收起 <span class="iconfont cup fz12" style="color:#BBBBBB">&#xe607;</span></span>
                 <span v-else
                    >展开 <span class="iconfont cup fz12" style="color:#BBBBBB">&#xe605;</span></span>
              </span>
              <span v-else style="margin-left:20px">暂无数据</span>
            </p>
            <downMedia :media="datas.media"
                        v-show="expand"
                        v-if="datas.media.length>0"></downMedia>
          </div>
          <div class="info">
            <h3 style="margin-bottom: 20px">操作记录：</h3>
            <operationLogs :data="datas.operation_logs"></operationLogs>
          </div>
        </div>
      </div>
      <!-- 操作记录 -->
      <a-modal title="状态变动记录"
              class="logModal"
               v-model="dialogVisible3"
               @ok="handleOk"
               width="746px">
        <a-table :columns="columns2"
                 :dataSource="data2"
                 :pagination="false"
                 :rowKey="(record, index) => index">
          <div slot="status"
               slot-scope="status,record">
            <span class="status_txt"
                  style="color:#FF4A4A"
                  v-if="record.status==='待受理'">待受理</span>
            <span class="status_txt"
                  style="color:#FEBC2E"
                  v-if="record.status==='待审核'">待审核</span>
            <span class="status_txt"
                  style="color:#FEBC2E"
                  v-if="record.status==='跟进中'">跟进中</span>
            <span class="status_txt"
                  style="color:#FEBC2E"
                  v-if="record.status==='排期中'">排期中</span>
            <span class="status_txt"
                  style="color:#FEBC2E"
                  v-if="record.status==='立项待审核'">立项待审核</span>
            <span class="status_txt"
                  style="color:#FEBC2E"
                  v-if="record.status==='已立项'">已立项</span>
            <span class="status_txt"
                  style="color:#3DCCA6"
                  v-if="record.status==='已完成'">已完成</span>
            <span class="status_txt"
                  style="color:#FF4A4A"
                  v-if="record.status==='已驳回'">已驳回</span>
            <span class="status_txt"
                  style="color:#BBBBBB"
                  v-if="record.status==='已撤销'">已撤销</span>
            <span class="status_txt"
                  style="color:#FF4A4A"
                  v-if="record.status==='待分配'">待分配</span>
          </div>
        </a-table>
        <div slot="footer"></div>
      </a-modal>
      <!-- 诉求审核 -->
      <a-modal title="诉求审核"
               :maskClosable="false"
                width="380px"
                class="eidt-model4"
               :visible="dialogVisible4"
               @ok="handleOk2"
               :confirmLoading="confirmLoading"
               @cancel="handleCancel">
        <a-form-item>
          <span slot="label"> <span style="color:red">*</span> 审核状态:</span>
          <a-select style="width:100%"
                    v-model="claimStatus"
                    placeholder="请选择">
            <a-select-option :value="0">待受理</a-select-option>
            <a-select-option :value="1">跟进中</a-select-option>
            <a-select-option :value="2">排期中</a-select-option>
            <a-select-option :value="5">已完成</a-select-option>
            <a-select-option :value="6">已驳回</a-select-option>
          </a-select>
        </a-form-item>
        <div class="radio_box"
             v-if="claimStatus==1">
          <p>症结点：</p>
          <a-textarea v-model="textinfos"
                      placeholder="可描述下这个需求的症结点有哪些"
                      :rows="3" />
        </div>
        <div class="radio_box">
          <p>备注：</p>
          <a-textarea v-model="textinfos2"
                      :placeholder="claimStatus==2?'简单排期说明安排（大致的时间安排)':'请输入备注'"
                      :rows="3" />

        </div>
      </a-modal>
     <!--诉求撤销 -->
        <a-modal title="提示"
                    :visible="dialogVisible5"
                    width="380px"
                    class="eidt-model4"
                    @cancel="dialogVisible5 = false,revokeForm.resetFields();"
                    @ok="cofigRevocation"
                    :maskClosable="false"
                    >
         <div class="radio_box" style="margin-bottom:-20px">
          <a-form :form="revokeForm">
            <a-form-item label="备注">
                 <a-textarea v-decorator="['note', { rules: [{ required: true, message: '请输入备注' }] }]"
                        placeholder="请输入备注"
                        :rows="3" />
            </a-form-item>

           </a-form>
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

    <!-- 编辑产品跟进人 -->
      <a-modal title="编辑产品跟进人"
                    @cancel="taskcancel"
                    @ok="editFollow"
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
                        <!-- <a-select placeholder="跟进人"
                                 showSearch
                                optionFilterProp="children"
                                v-decorator="['follower_id', { rules: [{ required: true, message: '请选择处理人' }] }]"
                                >
                        <a-select-option v-for="item in options4"
                                        :key="item.id">{{item.name}}</a-select-option>
                        </a-select> -->
                        <allPersonSelect  :autoFocus="false" :selectValue="follower_id === '' ? undefined : follower_id"
                                          @getSelectValue="getFollowerID"
                                          :searchData="searchD"
                                          ref="modalFollowerRef"
                                          v-decorator="['follower_id', { rules: [{ required: true, message: '请选择处理人' }] }]"
                                          style="width: 100%;"
                                          >
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
          </a-modal>
    </div>
  </div>
</template>
<style lang="less">
    .info_img img {
    width: 250px;
    height: 150px;
    }
    .eidt_modal .ant-modal-body {
    padding: 0 ;
    }
     .eidt_modal /deep/ .ant-modal-footer{
         padding:20px;
         border-top: none !important;
     }
    .eidt-model4{
        .radio_box p{
            padding-bottom: 10px;
        }
        .ant-modal-body {
            padding: 10px 20px 0 20px;
            .ant-form-item{
                margin-bottom: 13px;
            }
        }
        .ant-modal-footer{
            padding: 20px;
        }
    }
</style>
<style lang="less" scoped>
    .status_txt{
        vertical-align: baseline;
    }
    .lab-select-arr {
  padding: 10px 0 10px 0;
  border-bottom: 1px solid #eee;
}

.lab_content_all {
  padding: 12px 20px 0px 20px;
}
.labmains {
  margin-bottom: 14px;
}
.labmain-box {
  min-height: 452px;
  height: 452px;
  overflow-y: auto;
}
.labmains h3 {
  color: #666666;
  font-size: 14px;
  margin-bottom: 8px;
  margin-top: 16px;
    font-weight: bold;
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
.lab-select-arr .ant-tag /deep/.anticon-close {
  color: #fff;
  margin-left: 12px;
}
    /deep/.ant-dropdown-menu-item a {
        padding-left:20px !important;
        span{
            margin-right:10px;
        }
    }
    .modal-box /deep/ .el-dialog__body {
    padding: 20px 20px 0 20px;
    }
    .modal-box /deep/ .el-dialog__title {
    color: #666;
    font-size: 16px;
    font-weight: bold;
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
        border-top: 1px solid #EEEEEE;
        height: 34px;
        line-height: 34px;
    }
    }

    h3 {
    font-size: 14px;
    font-family: Microsoft YaHei;
    font-weight: bold;
    color: rgba(51, 51, 51, 1);
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
    .fz12 {
    font-size: 12px;
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
        margin-bottom: 20px;
        height: 54px;
        border-bottom: 1px solid rgba(238, 238, 238, 1);
        display: flex;
        justify-content: space-between;
        align-items: center;
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
    margin-bottom: 40px;
    .top {
        position: relative;
        height: 62px;
        .text-button {
        display: inline-block;
        margin-left: 4px;
            img:nth-child(1) {
                width: 40px;
                height: 21px;
                position: relative;
                top: 1px;
                cursor: pointer;
            }
            img:nth-child(2) {
                width: 36px;
                height: 19px;
                cursor: pointer;
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
    border-top-right-radius:8px;
    span {
        color: #232323;
        font-size: 14px;
        font-weight: bold;
    }
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
    }
    .tabs-ico {
    display: inline-block;
    width: 15px;
    height: 20px;
    background: url("../../../assets/images/tabs-01.png") no-repeat;
    background-position: 0px 8px;
    }
    .info-detial {
        height: 142px;
        overflow-y: auto;
    p {
        margin-bottom: 20px;
        span {
        color: #666;
        font-size: 12px;
        }
        .info-detial-left {
        text-align: left;
        display: inline-block;
        margin-right: 10px;
        min-width: 72px;
        }
    }
    }
    .info-description {
    padding: 20px 0 0px 0;
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
    margin-bottom: 20px;
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
import operationLogs from '@/components/operationLogs'
import downMedia from '@/components/downMedia'
import allPersonSelect from '@/components/allPersonSelect'
import moment from 'moment'
import { attentionDemands, claimDetial, updateReview, getClaimLog, sendClaim, cancelClaim, cancelProject, revocation, getlabclassAll, pasteTag, getProductFollower, eidtTaskPeople } from '../../../api/recount'
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

export default {
  components: { downMedia, operationLogs, myViewer, allPersonSelect },
  data () {
    return {
      datas: { policies: {}, user_attentions: [], media: [] },
      revokeForm: this.$form.createForm(this, { name: 'revokeForm' }),
      allotForm: this.$form.createForm(this, { name: 'allotTask' }),
      tags: [],
      options4: [],
      productsData3: [],
      expand: true,
      expand2: true,
      showline: true,
      activeClass: 0,
      dialogVisible4: false,
      dialogVisible3: false,
      dialogVisible5: false,
      dialogVisible9: false,
      dialogVisible6: false,
      columns2,
      data2: [],
      textarea2: '',
      textarea3: '',
      confirmLoading: false,
      claimStatus: '',
      textinfos: '',
      textinfos2: '',
      follower_id: undefined,
      follower_n: '',
      searchD: []
    }
  },
  methods: {
    moment,
    editFollow () {
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
              this.getclaimdetial()
            }
          }).catch(error => {
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        } else {
          return false
        }
      })
    },
    taskcancel () {
      this.dialogVisible6 = false
      this.allotForm.setFieldsValue({ 'follower_id': undefined })
      this.follower_id = undefined
      this.follower_n = ''
      this.searchD = []
      this.$refs.modalFollowerRef.value = undefined
      this.$nextTick(() => {
        this.allotForm.resetFields()
      })
    },
    showHandler (record) {
      this.dialogVisible6 = true
      this.follower_id = JSON.parse(JSON.stringify(record.follower_id))
      this.follower_n = JSON.parse(JSON.stringify(record.follower_name))
      this.searchD = this.follower_n ? [{ name: this.follower_n, id: this.follower_id }] : []
      var day = ''
      if (record.expiration_date) {
        day = moment(record.expiration_date)
      } else {
        day = undefined
      }
      setTimeout(() => {
        this.allotForm.setFieldsValue({
          'follower_id': record.follower_id,
          'comment': record.comment,
          'expiration_date': day
        })
      }, 100)

      this.taskId = record.id
    },
    handleClose3 (removedTag) {
      const tags = this.tags.filter(tag => tag !== removedTag)
      this.tags = tags
    },
    disabledDate (current) {
      // 不能选择今天以前的日期
      return current && current < moment().startOf('day')
    },
    selectLab (item) {
      // 判断tags中是否存在要添加的元素
      if (JSON.stringify(this.tags).indexOf(JSON.stringify(item)) === -1) {
        this.tags.push(item)
      } else {
        this.$message.error('该标签已存在')
      }
    },
    handleCancel3 (e) {
      this.dialogVisible9 = false
    },
    handleOk3 () {
      this.confirmLoading = true
      let sort = this.tags.map((item, index) => {
        return item.id
      })
      let params = { label_ids: sort }
      pasteTag(params, this.$route.query.id).then(data => {
        this.confirmLoading = false
        this.$message.success('贴标签成功')
        this.getclaimdetial()
      }).catch(error => {
        this.confirmLoading = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
      this.dialogVisible9 = false
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
    clickSuccess (status, id, record) {
      if (status === 1) {
        sendClaim(id).then(res => {
          this.$message.success('认领成功')
          this.getclaimdetial()
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else if (status === 2) {
        cancelClaim(id).then(res => {
          this.$message.success('取消认领')
          this.getclaimdetial()
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else if (status === 3) {
        cancelProject(id).then(res => {
          this.$message.success('取消立项')
          this.getclaimdetial()
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else if (status === 4) {
        if (record.demand_id) {
          this.$router.push({ name: 'editDemand', query: { id: record.demand_id, sqNumber: record.number } })
          localStorage.setItem('sqProduct', JSON.stringify([record.product_category]))
        } else {
          this.$router.push({ name: 'releaseDemand', query: { sqId: id, sqNumber: record.number } })
          localStorage.setItem('sqProduct', JSON.stringify([record.product_category]))
        }
      } else if (status === 5) {
        this.$router.push({ name: 'demandDetails', query: { id } })
      } else if (status === 6) {
        this.$router.push({ path: 'claimDismantling', query: { id: id } })
      } else if (status === 7) {
        // 贴标签
        this.labclassAll()
        this.tags = id.labels.map(k => {
          if (k.pivot) {
            delete k.pivot
          }
          return { ...k }
        })
        this.dialogVisible9 = true
      } else if (status === 8) {
        // 撤销
        this.dialogVisible5 = true
      }
    },
    cofigRevocation () {
      this.revokeForm.validateFields((err, values) => {
        if (!err) {
          let params = {
            comment: values.note
          }
          revocation(params, this.$route.query.id).then(data => {
            this.$message.success('撤销成功')
            this.getclaimdetial()
            this.dialogVisible5 = false
          }).catch(error => {
            this.dialogVisible5 = false
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        }
      })
    },
    toggle () {
      this.expand = !this.expand
    },
    toggle2 () {
      this.expand2 = !this.expand2
    },
    toggle3 (index) {
      // 把当前点击元素的index，赋值给activeClass
      this.activeClass = index
    },
    async getclaimdetial () {
      let lisId = this.$route.query.id
      await claimDetial(lisId).then(data => {
        this.datas = data.data.appeals
        this.datas.operation_logs = this.datas.operation_logs.map(item => {
          return { show: false, ...item }
        })
        this.claimStatus = data.data.appeals.status
        this.textinfos = data.data.appeals.crux
        this.textinfos2 = data.data.appeals.comment_follower
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    handleOk (e) {
      this.dialogVisible3 = false
    },
    handleOk2 (e) {
      let params = {
        status: this.claimStatus
      }
      if (this.textinfos) {
        params.crux = this.textinfos
      }
      if (this.textinfos2) {
        params.comment = this.textinfos2
      }
      let id = this.$route.query.id

      updateReview(params, id).then(data => {
        if (data.code === 200) {
          this.$message.success('审核成功')
          this.dialogVisible4 = false
          this.getclaimdetial()
          this.textinfos2 = ''
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    recordEidtlist () {
      this.dialogVisible3 = true
    },
    handleClose (done) {
      this.dialogVisible5 = false
    },
    handleCancel (e) {
      this.dialogVisible4 = false
      this.textinfos = ''
      this.textinfos2 = ''
    },
    toggleClass (index) {
      this.activeClass = index // 把当前点击元素的index，赋值给activeClass
    },
    // 取消关注
    attention (id) {
      attentionDemands(id).then(res => {
        if (res.code === 200) {
          this.datas.is_attention = !this.datas.is_attention
          if (this.datas.is_attention) {
            this.$message.success('关注成功')
          } else {
            this.$message.error('取消关注')
          }
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    // 跳转编辑
    loacalclaim () {
      this.$router.push({ path: 'eidtClaim', query: { type: 1, id: this.datas.id } })
    },
    getFollowerID (e) {
      this.allotForm.setFieldsValue({ 'follower_id': e.id })
    }
  },
  created () {
    getProductFollower().then(res => {
      if (res.code === 200) {
        this.options4 = res.data.users
      }
    })
    getClaimLog(this.$route.query.id).then(data => {
      this.data2 = data.data.status_logs
    }).catch(error => {
      this.$message.error(error.response ? error.response.data.message : error.message)
    })
  },
  async mounted () {
    await this.getclaimdetial()
  }
}
</script>
