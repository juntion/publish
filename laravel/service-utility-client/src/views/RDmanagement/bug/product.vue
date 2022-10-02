<template>
    <div>
        <viewer :images="images"
            class="viewer" ref="viewer"
            @inited="inited"
        >
        <img v-for="src in images" :src="src" :key="src" class="image">
        </viewer>
        <!-- bug详情弹出层 -->
          <a-drawer width="1200"
               class="modal-pms"
               placement="right"
               :closable="true"
               :keyboard="false"
                @close="onClose"
              :visible="visible">
              <div slot="title" class="top-title">Bug基本信息
                <a-dropdown :trigger="['click']"
                    placement='bottomCenter'>
                <div class="operation" >
                    <i class="icon iconfont">&#xe632;</i>
                    <span class="cz">操作</span>
                    <i class="line"></i>
                </div>
                <a-menu slot="overlay"
                        style="width:120px;text-align:left;max-height:250px;overflow-y:auto;">
                    <a-menu-item  v-if="bugMsg.policies.update">
                        <a  @click="caozuo(1,bugMsg)"><span class="iconfont fz12">&#xe637;</span>编辑Bug</a>
                    </a-menu-item>
                    <a-menu-item  v-if="bugMsg.policies.revocation">
                        <a  @click="caozuo(2,bugMsg)"><span class="iconfont fz12">&#xe657;</span>撤销Bug</a>
                    </a-menu-item>
                    <a-menu-item  v-if="bugMsg.policies.publishAppeal">
                        <a  @click="caozuo(3,bugMsg)"><span class="iconfont fz12">&#xe6f5;</span>发布诉求</a>
                    </a-menu-item>
                     <!-- <a-menu-item  v-if="bugMsg.appeals.length || bugMsg.demands.length">
                        <a-popover placement="bottomLeft"
                        v-if="bugMsg.appeals.length || bugMsg.demands.length"
                        :getPopupContainer="triggerNode => triggerNode.parentNode"
                        arrowPointAtCenter>
                        <template slot="content">
                            <div style="display:flex" v-if="bugMsg.appeals.length">
                                <p style="color:#bbb;width:52px">诉求信息: </p>
                                <div>
                                    <div  v-for="item in bugMsg.appeals" :key="item.id">
                                        <p>{{item.number}}</p>
                                        <p>{{item.name}}</p>
                                    </div>
                                </div>
                            </div>
                             <div style="display:flex" v-if="bugMsg.demands.length">
                                <p style="color:#bbb;width:52px">需求信息: </p>
                                <div>
                                    <div  v-for="item in bugMsg.demands" :key="item.id">
                                        <p>{{item.number}}</p>
                                        <p>{{item.name}}</p>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <a ><span class="iconfont fz12">&#xe62a;</span>诉求/需求信息</a>
                      </a-popover>
                    </a-menu-item> -->
                    <a-menu-item  v-if="bugMsg.policies.applyExamine">
                        <a  @click="caozuo(4,bugMsg)"><span class="iconfont fz12">&#xe6fc;</span>申请审批</a>
                    </a-menu-item>
                    <a-menu-item  v-if="bugMsg.policies.applyExamineCancel">
                        <a  @click="caozuo(5,bugMsg)"><span  style="color:#FEBC2E" class="iconfont fz12">&#xe6fc;</span>撤销审批申请</a>
                    </a-menu-item>
                    <a-menu-item  v-if="bugMsg.policies.financeExamine">
                        <a  @click="caozuo(6,bugMsg)"><span class="iconfont fz12">&#xe63d;</span>财务审批</a>
                    </a-menu-item>
                    <a-menu-item  v-if="bugMsg.policies.internalControlExamine">
                        <a  @click="caozuo(7,bugMsg)"><span class="iconfont fz12">&#xe63d;</span>内控审批</a>
                    </a-menu-item>
                    <a-menu-item  v-if="bugMsg.policies.start">
                        <a  @click="caozuo(8,bugMsg)"><span class="iconfont fz12">&#xe635;</span>开始</a>
                    </a-menu-item>
                     <a-menu-item  v-if="bugMsg.policies.submitHandleResult">
                        <a  @click="caozuo(9,bugMsg)"><span class="iconfont fz12">&#xe65b;</span>提交</a>
                    </a-menu-item>
                     <a-menu-item  v-if="bugMsg.policies.submitHandleResultCancel">
                        <a  @click="caozuo(10,bugMsg)"><span class="iconfont fz12">&#xe65c;</span>撤销提交</a>
                    </a-menu-item>
                    <a-menu-item  v-if="bugMsg.policies.reexamine">
                        <a  @click="caozuo(11,bugMsg)"><span class="iconfont fz12">&#xe6f6;</span>复核</a>
                    </a-menu-item>
                    <a-menu-item  v-if="bugMsg.policies.acceptTest">
                        <a  @click="caozuo(12,bugMsg)"><span class="iconfont fz12">&#xe647;</span>测试验收</a>
                    </a-menu-item>
                    <a-menu-item  v-if="bugMsg.policies.acceptPromulgator">
                        <a  @click="caozuo(13,bugMsg)"><span class="iconfont fz12">&#xe647;</span>提bug人验收</a>
                    </a-menu-item>
                    <a-menu-item  v-if="bugMsg.policies.acceptProduct">
                        <a  @click="caozuo(14,bugMsg)"><span class="iconfont fz12">&#xe647;</span>产品验收</a>
                    </a-menu-item>
                    <a-menu-item  v-if="bugMsg.policies.publishDemand">
                        <a  @click="caozuo(15,bugMsg)"><span class="iconfont fz12">&#xe63a;</span>发布需求</a>
                    </a-menu-item>
                    <a-menu-item  v-if="bugMsg.policies.close">
                        <a  @click="caozuo(16,bugMsg)"><span class="iconfont fz12">&#xe6f8;</span>关闭bug</a>
                    </a-menu-item>
                    <a-menu-item  v-if="bugMsg.policies.appendInfo">
                        <a  @click="caozuo(17,bugMsg)"><span class="iconfont fz12">&#xe6f7;</span>补充信息</a>
                    </a-menu-item>

                    <a-menu-item   v-if="!bugMsg.policies.update && !bugMsg.policies.revocation && !bugMsg.policies.publishAppeal
                        && !bugMsg.policies.applyExamine && !bugMsg.policies.applyExamineCancel && !bugMsg.policies.financeExamine && !bugMsg.policies.internalControlExamine
                        && !bugMsg.policies.start && !bugMsg.policies.submitHandleResult && !bugMsg.policies.submitHandleResultCancel && !bugMsg.policies.reexamine && !bugMsg.policies.acceptTest
                        && !bugMsg.policies.acceptPromulgator && !bugMsg.policies.acceptProduct && !bugMsg.policies.publishDemand && !bugMsg.policies.close && !bugMsg.policies.appendInfo" class="tac">
                        <a >暂无操作</a>
                    </a-menu-item>
                </a-menu>
                </a-dropdown>
              </div>
              <a-spin :spinning="msgLoad">
                <div class="content">
                    <div class="loading">

                    </div>
                        <div class="top">
                            <span class="dept">{{bugMsg.dept_name}} </span>
                            <span v-if="bugMsg.is_urgent" class="is_urgent cup" title="加急">加急</span>
                            <i class="line"></i>
                            <span>{{bugMsg.number}}</span>
                            <i class="line"></i>
                            <span>{{bugMsg.created_at}}</span>
                            <i class="line"></i>
                            <span class="status">
                                <!-- 0：待指派；1：待受理；2：处理中；3：待复核；4：排期处理；5：已处理；6：不处理；7：已撤销；8：申请审批； -->
                                <span v-if="bugMsg.status===0"><span class="iconfont fz12" style="color:#FF4A4A">&#xe654;</span> {{bugMsg.status_desc}}</span>
                                <span v-if="bugMsg.status===1"><span class="iconfont fz12" style="color:#FF4A4A">&#xe654;</span> {{bugMsg.status_desc}}</span>
                                <span v-if="bugMsg.status===2"><span class="iconfont fz12" style="color:#FFB400">&#xe654;</span> {{bugMsg.status_desc}}</span>
                                <span v-if="bugMsg.status===3"><span class="iconfont fz12" style="color:#FFB400">&#xe654;</span> {{bugMsg.status_desc}}</span>
                                <span v-if="bugMsg.status===4"><span class="iconfont fz12" style="color:#FFB400">&#xe654;</span> {{bugMsg.status_desc}}</span>
                                <span v-if="bugMsg.status===5"><span class="iconfont fz12" style="color:#3DCCA6">&#xe653;</span> {{bugMsg.status_desc}}</span>
                                <span v-if="bugMsg.status===6"><span class="iconfont fz12" style="color:#FF4A4A">&#xe653;</span> {{bugMsg.status_desc}}</span>
                                <span v-if="bugMsg.status===7"><span class="iconfont fz12" style="color:#BBBBBB">&#xe654;</span> {{bugMsg.status_desc}}</span>
                                <span v-if="bugMsg.status===9"><span class="iconfont fz12" style="color:#FF4A4A">&#xe654;</span> {{bugMsg.status_desc}}</span>
                                <span v-if="bugMsg.status===10"><span class="iconfont fz12" style="color:#FF4A4A">&#xe654;</span> {{bugMsg.status_desc}}</span>
                            </span>
                            <i class="line" v-if="bugMsg.labels.length"></i>
                            <span  v-for="item in bugMsg.labels" :key="item.id" style="vertical-align: text-bottom;">
                                <img style="margin-right:4px" v-if="item.name==='财务审批通过'" src="../../../assets/images/tag-1.png">
                                <img style="margin-right:4px" v-if="item.name==='财务审批驳回'" src="../../../assets/images/tag-2.png">
                                <img style="margin-right:4px" v-if="item.name==='内控审批通过'" src="../../../assets/images/tag-3.png">
                                <img style="margin-right:4px" v-if="item.name==='内控审批驳回'" src="../../../assets/images/tag-4.png">
                                <img style="margin-right:4px" v-if="item.name==='验收不合格'" src="../../../assets/images/tag-5.png">
                                <img style="margin-right:4px" v-if="item.name==='已验收'" src="../../../assets/images/tag-6.png">
                                <img style="margin-right:4px" v-if="item.name==='Bug已关闭'" src="../../../assets/images/tag-7.png">
                            </span>
                        </div>
                        <div class="con">
                            <a-tabs type="card" v-model="activeKey">
                                <a-tab-pane key="1">
                                    <span slot="tab" class="tab">
                                        <i class="tabs-ico"></i> 主要信息
                                    </span>
                                    <div style="margin-bottom:20px">
                                        <span class="left">浏览器:</span>
                                        <span class="right" v-for="(item,index) in bugMsg.browser" :key="index">{{item}}; </span>
                                    </div>
                                    <div style="margin-bottom:20px">
                                        <span class="left">操作平台:</span>
                                        <span class="right">
                                            <span v-if="bugMsg.operation_platform===2">后台PC端</span>
                                            <span v-if="bugMsg.operation_platform===3">PDA</span>
                                            <span v-if="bugMsg.operation_platform===1">FS平台</span>
                                            <span v-if="bugMsg.operation_platform===5">Community中文</span>
                                            <span v-if="bugMsg.operation_platform===6">Community英文</span>
                                            <span v-if="bugMsg.operation_platform===7">Arms</span>
                                            <span v-if="bugMsg.operation_platform===4">APP</span>
                                            <span v-if="bugMsg.operation_platform===5">Community中文</span>
                                            <span v-if="bugMsg.operation_platform===6">Community英文</span>
                                            <span v-if="bugMsg.operation_platform===7">Arms</span>
                                        </span>
                                    </div>
                                    <div style="margin-bottom:20px">
                                        <span class="left">操作账号:</span>
                                        <span class="right" v-for="(item,index) in bugMsg.operation_account" :key="index">{{item.name}}; </span>
                                    </div>
                                    <div style="margin-bottom:20px;display:flex;" >
                                         <span class="left" v-if="bugMsg.operation_platform===2 || bugMsg.operation_platform===1 || bugMsg.operation_platform===5 || bugMsg.operation_platform===6">页面链接:</span>
                                        <span class="left" v-if="bugMsg.operation_platform===3 || bugMsg.operation_platform===4 || bugMsg.operation_platform===7">版本号:</span>
                                        <span  class="right">
                                            <p v-for="(item,index) in bugMsg.links" :key="index"  style="margin-bottom:10px;">
                                                <a :href="item" style="word-break: break-all" target="_blank">{{item}};</a>
                                            </p>
                                        </span>
                                        <span class="right">{{bugMsg.version}} </span>
                                    </div>
                                    <div>
                                        <span class="left">产生时间:</span>
                                        <span class="right"><span>{{bugMsg.start_time}}</span> 至 <span>{{bugMsg.end_time}}</span></span>
                                    </div>
                                    <div class="con">
                                        <h3 style="font-weight:bold;margin-bottom:20px">故障内容</h3>
                                        <p style="margin-bottom:10px">故障描述</p>
                                        <myViewer :html="bugMsg.description"></myViewer>
                                        <p style="margin-top:20px;margin-bottom:10px">
                                            附件:<span v-if="bugMsg.media.length>0" @click="mediaShow=!mediaShow" style="margin-left:20px" class="cup">
                                                    <span v-if="mediaShow">收起 <span class="icon iconfont cup">&#xe607;</span></span>
                                                    <span v-else>展开 <span class="icon iconfont cup">&#xe605;</span></span>
                                            </span>
                                            <span v-else style="margin-left:20px">暂无数据</span>
                                        </p>
                                        <downMedia :media="bugMsg.media"
                                        v-show="mediaShow"
                                        v-if="bugMsg.media.length>0"
                                        ></downMedia>
                                    </div>

                                </a-tab-pane>
                                <a-tab-pane key="2">
                                    <span slot="tab"  class="tab">
                                        <i class="tabs-ico"></i> 附加信息
                                    </span>
                                    <div style="margin-bottom:20px">
                                        <span class="left"  style="width:64px">所属产品线:</span>
                                        <span class="right" v-if="bugMsg.product_category.product_line&&bugMsg.product_category.product_line.name">{{bugMsg.product_category.product_line.name}}</span>
                                        <span v-else>--</span>
                                    </div>
                                    <div style="margin-bottom:20px">
                                        <span class="left" style="width:64px">所属产品:</span>
                                        <span class="right" v-if="bugMsg.product_category.product&&bugMsg.product_category.product.name">{{bugMsg.product_category.product.name}}</span>
                                        <span v-else>--</span>
                                    </div>
                                    <div style="margin-bottom:20px">
                                        <span class="left" style="width:64px">所属需求:</span>
                                        <span class="right" v-if="bugMsg.demand&&bugMsg.demand.name">{{bugMsg.demand.name}}</span>
                                        <span v-else>--</span>
                                    </div>
                                    <div>
                                        <span class="left" style="width:64px">所属项目:</span>
                                        <span class="right" v-if="bugMsg.project&&bugMsg.project.name">{{bugMsg.project.name}}</span>
                                        <span v-else>--</span>
                                    </div>
                                </a-tab-pane>
                                <a-tab-pane key="3">
                                    <span slot="tab"  class="tab">
                                        <i class="tabs-ico"></i> 受理情况
                                    </span>
                                    <div style="margin-bottom:20px">
                                        <span class="left" style="min-width:75px">由谁提交:</span>
                                        <span class="right">{{bugMsg.promulgator_name}}</span>
                                    </div>
                                    <div style="margin-bottom:20px">
                                        <span class="left" style="min-width:75px">由谁负责:</span>
                                        <span class="right">
                                            <span style="margin-right:10px">产品负责人: {{bugMsg.product_principal_name ? bugMsg.product_principal_name: '--'}}</span>
                                            <span style="margin-right:10px">开发负责人: {{bugMsg.program_principal_name ? bugMsg.program_principal_name: '--'}}</span>
                                            <span style="margin-right:10px">测试负责人: {{bugMsg.test_principal_name ? bugMsg.test_principal_name :'--'}}</span>
                                        </span>
                                    </div>
                                    <div style="margin-bottom:20px">
                                        <span class="left" style="min-width:75px">由谁跟进:</span>
                                        <span class="right">开发跟进人: <span v-for="item in bugMsg.handlers" :key="item.id">{{item.handler_name}} ; </span>
                                            <span v-if="bugMsg.handlers&&bugMsg.handlers.length===0">--</span>
                                        </span>
                                    </div>
                                    <div style="margin-bottom:20px">
                                        <span class="left" style="min-width:75px">当前状态:</span>
                                        <span class="right">
                                            <span v-if="bugMsg.status===0"><span class="iconfont fz12" style="color:#FF4A4A">&#xe654;</span> {{bugMsg.status_desc}}</span>
                                            <span v-if="bugMsg.status===1"><span class="iconfont fz12" style="color:#FF4A4A">&#xe654;</span> {{bugMsg.status_desc}}</span>
                                            <span v-if="bugMsg.status===2"><span class="iconfont fz12" style="color:#FFB400">&#xe654;</span> {{bugMsg.status_desc}}</span>
                                            <span v-if="bugMsg.status===3"><span class="iconfont fz12" style="color:#FFB400">&#xe654;</span> {{bugMsg.status_desc}}</span>
                                            <span v-if="bugMsg.status===4"><span class="iconfont fz12" style="color:#FFB400">&#xe654;</span> {{bugMsg.status_desc}}</span>
                                            <span v-if="bugMsg.status===5"><span class="iconfont fz12" style="color:#3DCCA6">&#xe653;</span> {{bugMsg.status_desc}}</span>
                                            <span v-if="bugMsg.status===6"><span class="iconfont fz12" style="color:#FF4A4A">&#xe653;</span> {{bugMsg.status_desc}}</span>
                                            <span v-if="bugMsg.status===7"><span class="iconfont fz12" style="color:#BBBBBB">&#xe654;</span> {{bugMsg.status_desc}}</span>
                                            <span v-if="bugMsg.status=== 9"><span class="iconfont fz12" style="color:#FF4A4A">&#xe654;</span> {{bugMsg.status_desc}}</span>
                                            <span v-if="bugMsg.status=== 10"><span class="iconfont fz12" style="color:#FF4A4A">&#xe654;</span> {{bugMsg.status_desc}}</span>

                                            <i class="line" v-if="bugMsg.labels.length"></i>
                                            <span  v-for="item in bugMsg.labels" :key="item.id" style="vertical-align: text-bottom;">
                                                <img style="margin-right:4px" v-if="item.name==='财务审批通过'" src="../../../assets/images/tag-1.png">
                                                <img style="margin-right:4px" v-if="item.name==='财务审批驳回'" src="../../../assets/images/tag-2.png">
                                                <img style="margin-right:4px" v-if="item.name==='内控审批通过'" src="../../../assets/images/tag-3.png">
                                                <img style="margin-right:4px" v-if="item.name==='内控审批驳回'" src="../../../assets/images/tag-4.png">
                                                <img style="margin-right:4px" v-if="item.name==='验收不合格'" src="../../../assets/images/tag-5.png">
                                                <img style="margin-right:4px" v-if="item.name==='已验收'" src="../../../assets/images/tag-6.png">
                                                <img style="margin-right:4px" v-if="item.name==='Bug已关闭'" src="../../../assets/images/tag-7.png">
                                            </span>
                                        </span>
                                    </div>
                                    <div style="margin-bottom:20px">
                                        <span class="left" style="float: left;min-width:75px">验收情况:</span>
                                        <span class="right">
                                            <div v-for="item in bugMsg.bug_accept" :key="item.id" style="margin-bottom:10px">
                                                <span v-if="item.type===1">提bug人员: </span>
                                                <span v-if="item.type===2">测试负责人: </span>
                                                <span v-if="item.type===3">产品负责人: </span>
                                                <span v-if="item.type===4">程序负责人: </span>
                                                <span> {{item.comment}} </span>
                                                <a-popover placement="bottomLeft"
                                                    v-if="item.media.length>0"
                                                    :getPopupContainer="triggerNode => triggerNode.parentNode"
                                                    arrowPointAtCenter>
                                                    <template slot="content">
                                                        <div class="download-list">
                                                            <p>附件</p>
                                                            <downPrd :media="item.media"
                                                                    style="margin-bottom:-10px"
                                                                    :span="24"></downPrd>
                                                        </div>
                                                    </template>
                                                    <span class="icon iconfont cup">&#xe656;</span>
                                                </a-popover>
                                                <span> 于 {{item.updated_at}}</span>

                                            </div>
                                            <span v-if="bugMsg.bug_accept.length===0">--</span>
                                        </span>
                                    </div>
                                     <div style="margin-bottom:20px">
                                        <span class="left" style="min-width:75px">解决方案:</span>
                                        <span class="right">
                                            {{bugMsg.solution ? bugMsg.solution : '--'}}
                                        </span>
                                    </div>
                                     <div style="margin-bottom:20px">
                                        <span class="left" style="min-width:75px">根因分析:</span>
                                        <span class="right">
                                            <span v-if="bugMsg.reason">
                                                 {{bugMsg.reason.reason}} ; {{bugMsg.reason_analyse}}
                                            </span>
                                            <span v-else> -- </span>
                                        </span>
                                    </div>
                                    <div style="margin-bottom:20px">
                                        <span class="left" style="min-width:75px">数据修复情况:</span>
                                        <span class="right">
                                            <span v-if="bugMsg.data_restore ===1 ">
                                                未修复;
                                            </span>
                                             <span v-if="bugMsg.data_restore ===2 ">
                                                已修复;
                                            </span>
                                             <span v-if="bugMsg.data_restore ===3 ">
                                                无需程序修复;
                                            </span>
                                             <span v-if="bugMsg.data_restore ===4 ">
                                                程序无法修复;
                                            </span>
                                            <span> {{bugMsg.data_restore_comment}}</span>
                                            <span v-if="!bugMsg.data_restore">--</span>
                                        </span>
                                    </div>
                                    <div>
                                        <span class="left" style="min-width:75px">调查进展:</span>
                                        <span class="right">
                                            {{bugMsg.inquiry_progress ? bugMsg.inquiry_progress : '--' }}
                                        </span>
                                    </div>
                                </a-tab-pane>
                                <a-tab-pane key="4">
                                    <span slot="tab"  class="tab">
                                        <i class="tabs-ico"></i> 操作记录
                                    </span>
                                    <operationLogs :data="bugMsg.operation_log"></operationLogs>
                                </a-tab-pane>
                            </a-tabs>
                        </div>

                </div>
              </a-spin>
          </a-drawer>
        <div >
             <a-modal title="撤销"
                class="modal-pms"
                   v-model="dialogVisible1"
                   :confirmLoading="btnLoad"
                   @cancel="cancel(1)"
                   @ok="ok(1)"
                   :maskClosable="false"
                   destroyOnClose
                   width="380px">
                    <div>
                        <p style="color:#F88D49;margin-bottom: 15px;">* 撤销后，Bug变更为“已撤销”状态，不可编辑，确认撤销？</p>
                        <div>
                              <a-form-model
                                :model="{comment}"
                                ref="revokeForm">
                                <a-form-model-item prop="comment" label="原因" :rules="[{ required: true, message: '请输入原因', trigger: 'blur' }]">
                                    <a-textarea placeholder="请输入撤销原因" v-model="comment" :rows="4" />
                                </a-form-model-item>
                              </a-form-model>

                        </div>
                    </div>
             </a-modal>

        </div>

        <!-- 操作记录弹框 -->
         <a-modal title="状态变动记录"
                class="modal-pms"
                   v-model="logsShow"
                   :footer="null"
                   width="700px">
                <a-table :dataSource="data2"
                   :columns="columns2"
                   :scroll="{ y: 380 }"
                   style="margin-top:-22px"
                   :pagination="false"
                   :rowKey="(record, index) => index">
                    <div slot="status" slot-scope="status">
                        <span v-if="status==='待指派'"><span class="fz12" style="color:#FF4A4A">待指派</span> </span>
                        <span v-if="status==='待受理'"><span class="fz12" style="color:#FF4A4A">待受理</span> </span>
                        <span v-if="status==='处理中'"><span class="fz12" style="color:#FFB400">处理中</span> </span>
                        <span v-if="status==='待复核'"><span class="fz12" style="color:#FFB400">待复核</span> </span>
                        <span v-if="status==='排期中'"><span class="fz12" style="color:#FFB400">排期中</span> </span>
                        <span v-if="status==='已处理'"><span class="fz12" style="color:#3DCCA6">已处理</span> </span>
                        <span v-if="status==='不处理'"><span class="fz12" style="color:#FF4A4A">不处理</span> </span>
                        <span v-if="status==='已撤销'"><span class="fz12" style="color:#BBBBBB">已撤销</span> </span>
                        <span v-if="status==='财务待审批'"><span class="fz12" style="color:#FF4A4A">财务待审批</span> </span>
                        <span v-if="status==='内控待审批'"><span class="fz12" style="color:#FF4A4A">内控待审批</span> </span>
                    </div>
                </a-table>
                <!-- <span slot="footer"></span> -->
         </a-modal>

            <a-modal title="撤销审批申请"
                    class="modal-pms"
                    v-model="dialogVisible2"
                    :confirmLoading="btnLoad"
                    @cancel="cancel(2)"
                    @ok="ok(2)"
                    :maskClosable="false"
                    destroyOnClose
                    width="380px">
                        <a-form-model
                                    :model="{comment}"
                                    ref="ruleForm">
                                    <a-form-model-item prop="comment" label="备注" :rules="[{ required: true, message: '请输入备注', trigger: 'blur' }]">
                                        <a-textarea placeholder="请输入备注" v-model="comment" :rows="4" />
                                    </a-form-model-item>
                        </a-form-model>
            </a-modal>

            <a-modal title="审批"
                class="modal-pms"
                   v-model="dialogVisible3"
                   :confirmLoading="btnLoad"
                   @cancel="cancel(3)"
                   @ok="ok(3)"
                   :maskClosable="false"
                   destroyOnClose
                   width="380px">
                    <a-form-model
                                :model="approvalForm"
                                ref="approvalForm">
                                 <a-form-model-item prop="result" :rules="[{ required: true, message: '请选择', trigger: 'change' }]" label="审批结果" style="margin-bottom:20px" >
                                        <a-radio-group name="radioGroup" v-model="approvalForm.result">
                                            <a-radio :value="1"> 通过</a-radio>
                                            <a-radio :value="0">驳回</a-radio>
                                        </a-radio-group>
                                 </a-form-model-item>
                                  <a-form-model-item
                                  v-if="approvalForm.result===1 && approvalType===1"
                                  prop="required_internal_control" :rules="[{ required: true, message: '请选择', trigger: 'change' }]" label="是否需要内控介入" style="margin-bottom:20px">
                                        <a-radio-group name="radioGroup" v-model="approvalForm.required_internal_control">
                                            <a-radio :value="1"> 需要</a-radio>
                                            <a-radio :value="0">不需要</a-radio>
                                        </a-radio-group>
                                 </a-form-model-item>
                                 <a-form-model-item prop="comment" label="审批意见" :rules="[{ required: true, message: '请输入备注', trigger: 'blur' }]">
                                    <a-textarea placeholder="请输入审批意见" v-model="approvalForm.comment" :rows="4" />
                                 </a-form-model-item>
                    </a-form-model>
            </a-modal>

            <a-modal  :title="submitType ? ' 更改提交信息' : '提交处理结果'"
                class="modal-pms"
                   v-model="dialogVisible4"
                   :confirmLoading="btnLoad"
                   @cancel="cancel(4)"
                   @ok="ok(4)"
                   :maskClosable="false"
                   destroyOnClose
                   width="380px">
                    <a-form-model
                                :model="submitForm"
                                ref="submitForm">
                                 <a-form-model-item
                                    v-if="!submitType"
                                    :rules="[{ required: true, message: '请选择', trigger: 'change' }]"
                                    prop="resolve_status"
                                    label="问题解决状态"
                                    style="margin-bottom:20px">
                                             <a-select placeholder="请选择"
                                                    v-model="submitForm.resolve_status"
                                                    >
                                                    <!-- 2：处理中；4：排期中；5：已处理；6：不处理； -->
                                                    <a-select-option :value="2">处理中</a-select-option>
                                                    <a-select-option :value="4">排期中</a-select-option>
                                                    <a-select-option :value="5">已处理</a-select-option>
                                                    <a-select-option :value="6">不处理</a-select-option>
                                            </a-select>
                                 </a-form-model-item>
                                <div v-if="submitForm.resolve_status=== 5 || submitForm.resolve_status=== 6">
                                    <a-form-model-item   :rules="[{ required: true, message: '请输入', trigger: 'blur' }]" prop="solution" label="解决方案" style="margin-bottom:20px">
                                        <a-textarea placeholder="请说明解决方案，若存在临时解决，请完整说明临时解决方案，长期解决方案分别是什么" v-model="submitForm.solution" :rows="4" />
                                    </a-form-model-item>
                                    <a-form-model-item   :rules="[{ required: true, message: '请选择', trigger: 'change' }]" prop="reason_id" label="原因类型" style="margin-bottom:20px">
                                                <a-select placeholder="请选择"
                                                        v-model="submitForm.reason_id"
                                                        showSearch
                                                        optionFilterProp="children"
                                                        >
                                                        <a-select-option v-for="item in bugReasons"
                                                            :key="item.id">{{item.reason}}</a-select-option>
                                                </a-select>
                                    </a-form-model-item>

                                    <a-form-model-item  prop="reason_analyse" :rules="[{ required: requiredReason, message: '请输入', trigger: 'blur' }]" label="根因分析" style="margin-bottom:20px">
                                     <a-textarea placeholder="可对所选原因做进一步的根因分析说明" v-model="submitForm.reason_analyse" :rows="4"/>
                                    </a-form-model-item>
                                    <a-form-model-item :rules="[{ required: true, message: '请选择', trigger: 'change' }]" prop="data_restore" label="数据修复情况" style="margin-bottom:20px">
                                                <a-select placeholder="请选择"
                                                    v-model="submitForm.data_restore"
                                                    >
                                                        <!-- 1：未修复；2：已修复；3：无需程序修复；4：程序无法修复 -->
                                                        <a-select-option :value="1">未修复</a-select-option>
                                                        <a-select-option :value="2">已修复</a-select-option>
                                                        <a-select-option :value="3">无需程序修复</a-select-option>
                                                        <a-select-option :value="4">程序无法修复</a-select-option>
                                                </a-select>
                                    </a-form-model-item>
                                   <a-form-model-item prop="data_restore_comment" label="数据修复情况说明" style="margin-bottom:20px">
                                    <a-textarea placeholder="可对数据修复的情况做进一步的说明" v-model="submitForm.data_restore_comment" :rows="4" />
                                 </a-form-model-item>
                                </div>
                                 <a-form-model-item prop="inquiry_progress" label="调查进展">
                                    <a-textarea placeholder="请输入调查进展" v-model="submitForm.inquiry_progress" :rows="4" />
                                 </a-form-model-item>
                    </a-form-model>
          </a-modal>
              <a-modal title="提示"
                    class="modal-pms"
                   v-model="dialogVisible10"
                   :confirmLoading="btnLoad"
                   @cancel="cancel(10)"
                   @ok="ok(10)"
                   :maskClosable="false"
                   destroyOnClose
                   width="380px">
                    <div class="contxt">确定需要发起 <span style="color:#3CCDA7">风控审批</span>?</div>
                    <div slot="footer"
                        class="tac">
                    <a-button  :loading="btnLoad" @click="ok(10)" type="primary" >确 定</a-button>
                    <a-button @click="cancel(10)">取 消</a-button>
                    </div>
          </a-modal>
           <a-modal title="撤销提交"
                    class="modal-pms"
                   v-model="dialogVisible5"
                   :confirmLoading="btnLoad"
                   @cancel="cancel(5)"
                   @ok="ok(5)"
                   :maskClosable="false"
                   destroyOnClose
                   width="380px">
                    <div>
                        <div>
                            <p style="margin-bottom: 10px;">备注: </p>
                            <a-textarea placeholder="请输入备注" v-model="comment" :rows="4" />
                        </div>
                    </div>
            </a-modal>

            <a-modal title="复核"
                class="modal-pms"
                   v-model="dialogVisible6"
                   :confirmLoading="btnLoad"
                   @cancel="cancel(6)"
                   @ok="ok(6)"
                   :maskClosable="false"
                   destroyOnClose
                   width="380px">
                    <a-form-model
                                :model="reviewForm"
                                ref="reviewForm">

                                    <a-form-model-item   :rules="[{ required: true, message: '请选择', trigger: 'change' }]" prop="reason_id" label="原因类型" style="margin-bottom:20px">
                                                <a-select placeholder="请选择"
                                                        v-model="reviewForm.reason_id"
                                                        >
                                                        <a-select-option v-for="item in bugReasons"
                                                            :key="item.id">{{item.reason}}</a-select-option>
                                                </a-select>
                                    </a-form-model-item>

                                    <a-form-model-item  prop="reason_analyse" :rules="[{ required: requiredReason2, message: '请输入', trigger: 'change' }]" label="根因分析" style="margin-bottom:20px">
                                     <a-textarea placeholder="可对所选原因做进一步的根因分析说明" v-model="reviewForm.reason_analyse" :rows="4" />
                                    </a-form-model-item>
                                    <a-form-model-item :rules="[{ required: true, message: '请选择', trigger: 'change' }]" prop="data_restore" label="数据修复情况" style="margin-bottom:20px">
                                                <a-select placeholder="请选择"
                                                    v-model="reviewForm.data_restore"
                                                    >
                                                        <!-- 1：未修复；2：已修复；3：无需程序修复；4：程序无法修复 -->
                                                        <a-select-option :value="1">未修复</a-select-option>
                                                        <a-select-option :value="2">已修复</a-select-option>
                                                        <a-select-option :value="3">无需程序修复</a-select-option>
                                                        <a-select-option :value="4">程序无法修复</a-select-option>
                                                </a-select>
                                    </a-form-model-item>
                                   <a-form-model-item prop="data_restore_comment" label="数据修复情况说明" style="margin-bottom:20px">
                                    <a-textarea placeholder="可对数据修复的情况做进一步的说明" v-model="reviewForm.data_restore_comment" :rows="4" />
                                 </a-form-model-item>
                                  <a-form-model-item
                                    :rules="[{ required: true, message: '请选择', trigger: 'change' }]"
                                    prop="resolve_status"
                                    label="问题解决状态"
                                    style="margin-bottom:20px">
                                             <a-select placeholder="请选择"
                                                    v-model="reviewForm.resolve_status"
                                                    >
                                                    <!-- 2：处理中；4：排期中；5：已处理；6：不处理； -->
                                                    <a-select-option :value="2">处理中</a-select-option>
                                                    <a-select-option :value="4">排期中</a-select-option>
                                                    <a-select-option :value="5">已处理</a-select-option>
                                                    <a-select-option :value="6">不处理</a-select-option>
                                            </a-select>
                                 </a-form-model-item>
                                  <a-form-model-item   :rules="[{ required: true, message: '请输入', trigger: 'blur' }]" prop="solution" label="解决方案" style="margin-bottom:20px">
                                        <a-textarea placeholder="请说明解决方案，若存在临时解决，请完整说明临时解决方案，长期解决方案分别是什么" v-model="reviewForm.solution" :rows="4" />
                                  </a-form-model-item>
                                 <a-form-model-item prop="comment" label="备注" style="margin-bottom:20px">
                                    <a-textarea placeholder="请输入备注" v-model="reviewForm.comment" :rows="4" />
                                 </a-form-model-item>
                                   <a-form-model-item prop="is_qualified" :rules="[{ required: true, message: '请选择', trigger: 'change' }]" label="是否合格"  style="margin-bottom:20px">
                                        <a-radio-group name="radioGroup2" v-model="reviewForm.is_qualified">
                                            <a-radio :value="1">合格</a-radio>
                                            <a-radio :value="0">不合格</a-radio>
                                        </a-radio-group>
                                 </a-form-model-item>
                                 <p style="color:#F88D49">* 请负责人仔细核查处理结果，确认提交信息是否合格！</p>
                    </a-form-model>
            </a-modal>

            <a-modal title="验收"
                class="modal-pms"
                   v-model="dialogVisible7"
                   :confirmLoading="btnLoad"
                   @cancel="cancel(7)"
                   @ok="ok(7)"
                   :maskClosable="false"
                   destroyOnClose
                   width="380px">
                    <a-form-model
                                :model="acceptForm"
                                ref="acceptForm">
                                 <a-form-model-item prop="result" label="验收结果" style="margin-bottom:20px" >
                                        <a-radio-group name="radioGroup3" v-model="acceptForm.result">
                                            <a-radio :value="1">验收合格</a-radio>
                                            <a-radio :value="0">验收不合格，继续修改</a-radio>
                                        </a-radio-group>
                                        <p v-if="acceptForm.result===0" style="color:#F88D49;margin-top:10px;">* 验收不合格,Bug状态将变更为“处理中”并由程序重新处理!</p>
                                 </a-form-model-item>

                                 <a-form-model-item prop="comment" label="备注">
                                    <a-textarea :placeholder="acceptForm.result? '备注' : '请准确描述不合格内容'" v-model="acceptForm.comment" :rows="4" />
                                 </a-form-model-item>
                                 <a-form-model-item
                                    v-if="acceptForm.result===0 "
                                    label="故障截图" style="margin-top:20px;position: relative;">
                                        <span @click="addFileInputList"
                                            class="addFile cup">
                                        <a-icon type="plus" /> 添加</span>
                                          <div v-for="(item, index) in acceptForm.media"
                                                :key="index"
                                                :style="{'margin-bottom': index===acceptForm.media.length-1 ?  '0' :'10px'}"
                                                style="display:flex;">
                                            <div style="flex: 1;margin-right: 10px;">
                                                <a-input :value="item.name"
                                                        placeholder="请选择截图"
                                                        disabled />
                                            </div>
                                            <div >
                                                <a-upload   :showUploadList="false"
                                                            :beforeUpload="(file) => beforeUpload(file, index)">
                                                <a-button size="small">选择文件</a-button>
                                                </a-upload>
                                            </div>
                                            <div @click="() => removeFileInputList(index)"
                                                style="margin-left: 10px;"
                                                v-if="acceptForm.media.length>1"
                                                class="delFile cup"> <span class="iconfont">&#xe64d;</span></div>

                                            </div>
                                 </a-form-model-item>
                    </a-form-model>
            </a-modal>

             <a-modal :title="closeType===1 ? '关闭Bug' : '补充信息'"
                    class="modal-pms"
                   v-model="dialogVisible8"
                   :confirmLoading="btnLoad"
                   @cancel="cancel(8)"
                   @ok="ok(8)"
                   :maskClosable="false"
                   destroyOnClose
                   width="380px">
                        <a-form-model
                                :model="closeForm"
                                ref="closeForm">
                            <a-form-model-item prop="product_line" style="margin-bottom:20px">
                                    <span slot="label">所属产品线</span>
                                    <a-select
                                        v-model="closeForm.product_line"
                                            allowClear
                                            @change="handleProvinceChange"
                                            placeholder="请选择">
                                    <a-select-option v-for="k in productsLine"
                                                    :title="k.description"
                                                    :key="k.id">{{k.name}}</a-select-option>
                                </a-select>
                            </a-form-model-item>
                            <a-form-model-item prop="product_id" style="margin-bottom:20px">
                                <span slot="label">产品名称</span>
                                <a-select
                                    allowClear
                                    v-model="closeForm.product_id"
                                    placeholder="请选择"
                                    >
                                    <a-select-option v-for="item in products"
                                                    :title="item.description"
                                                    :key="item.id">{{item.name}}</a-select-option>
                                </a-select>
                            </a-form-model-item>
                            <a-form-model-item prop="source_project_id" style="margin-bottom:20px">
                                <span slot="label" >所属项目</span>
                                <projectSelect  v-model="closeForm.source_project_id" :allowClear="true" @onChange="onChange" ref="source_project"></projectSelect>
                            </a-form-model-item>
                             <a-form-model-item  prop="source_demand" style="margin-bottom:20px">
                                <span slot="label">所属需求</span>
                                <a-select
                                    allowClear
                                    placeholder="请选择"
                                    :getPopupContainer="triggerNode => triggerNode.parentNode"
                                    showSearch
                                    labelInValue
                                    @search="serchFocus"
                                    v-model="closeForm.source_demand"
                                    optionFilterProp="children"
                                   >
                                    <a-select-option v-for="item in demand"
                                                    :title="item.name"
                                                    :key="item.id">{{item.name}}</a-select-option>
                                </a-select>
                            </a-form-model-item>
                            <a-form-model-item prop="comment" v-if="closeType===1">
                                <span slot="label">备注</span>
                                <a-textarea placeholder="备注" v-model="closeForm.comment" style="height:80px;margin-bottom:20px" />
                                <p style="color:#F88D49">请完善以上信息后再关闭Bug! <br> 关闭后，此Bug将不可再做任何操作，是否确认关闭</p>
                            </a-form-model-item >

                        </a-form-model>
            </a-modal>
            <a-modal title="分配跟进人"
                    class="modal-pms"
                   v-model="dialogVisible9"
                   :confirmLoading="btnLoad"
                   @cancel="cancel(9)"
                   @ok="ok(9)"
                   :maskClosable="false"
                   destroyOnClose
                   width="700px">
                    <a-form-model
                                :model="followForm"
                                ref="followForm">
                        <div style="display: flex;">
                            <a-form-model-item prop="follower_id"
                            label="指定跟进人"
                            :rules="[{ required: true, message: '请选择', trigger: 'change' }]"
                            style="margin-bottom:20px;width:320px;margin-right:20px">
                              <!-- <a-select placeholder="指定跟进人"
                                        showSearch
                                        optionFilterProp="children"
                                        v-model="followForm.follower_id"
                                      >
                                    <a-select-option v-for="item in options_1"
                                                :title="item.name"
                                                :key="item.id">{{item.name}}</a-select-option>
                                </a-select> -->
                                <allPersonSelect :autoFocus="false"
                                                @getSelectValue="handleModalSearch"
                                                :selectValue="followerID"
                                                :searchData="followerArr"
                                                ref="followerRef"
                                                placeholder="请输入英文名搜索"
                                                style="width: 100%;">
                                </allPersonSelect>
                            </a-form-model-item >
                            <a-form-model-item prop="expiration_date" style="margin-bottom:20px" :rules="[{ required: true, message: '请选择', trigger: 'change' }]">
                                    <span slot="label">计划解决时间</span>
                                    <a-date-picker style="width:245px"
                                        format="YYYY-MM-DD"
                                        :disabledDate="disabledDate"
                                        type="date"
                                        v-model="followForm.expiration_date"
                                        placeholder="选择日期">
                                    </a-date-picker>
                                    <span v-if="followForm.expiration_date" style="margin-left:10px">
                                        还剩<span style="color:#F88D49"> {{followForm.expiration_date.diff(moment().startOf('day'), 'day')}}</span>天
                                    </span>
                            </a-form-model-item >
                        </div>
                        <a-form-model-item prop="comment">
                                <span slot="label">备注</span>
                                <a-textarea placeholder="备注" v-model="followForm.comment" style="height:80px;" />
                        </a-form-model-item >
                    </a-form-model>
            </a-modal>

        <div class="tabslist">
        <a-tabs class="tabs_bg"
                v-model="searchData.tabs">
            <a-tab-pane :key="-1">
            <span slot="tab">
                All
            </span>
            </a-tab-pane>
            <a-tab-pane :key="0">
            <span slot="tab" title="未指定跟进人的故障">
                待指派
                <a-badge :count="remind.status0"/>
            </span>
            </a-tab-pane>
            <a-tab-pane :key="1">
            <span slot="tab" title="已指派跟进人但未处理的故障" >
                待受理
                <a-badge :count="remind.status1" />
            </span>
            </a-tab-pane>
            <a-tab-pane :key="4">
            <span slot="tab" title="排期处理的故障">
                排期中
                <a-badge :count="remind.status4" />
            </span>
            </a-tab-pane>
            <a-tab-pane :key="2">
            <span slot="tab" title="已开始处理的故障">
                处理中
                <a-badge :count="remind.status2" />
            </span>
            </a-tab-pane>
            <a-tab-pane :key="3">
            <span slot="tab" title="需程序负责人审核处理结果的故障">
                待复核
                <a-badge :count="remind.status3" />
            </span>
            </a-tab-pane>
            <a-tab-pane :key="6">
            <span slot="tab" title="标记不处理的故障">
                不处理
            </span>
            </a-tab-pane>
            <a-tab-pane :key="5">
            <span slot="tab" title="已解决的故障">
                已处理
            </span>
            </a-tab-pane>
            <a-tab-pane :key="7">
            <span slot="tab" title="发布人撤销的故障">
                已撤销
            </span>
            </a-tab-pane>
            <a-tab-pane :key="8">
            <span slot="tab" title="需要风控团队审批的故障">
                申请审批
                 <a-badge :count="remind.status8" />
            </span>
            </a-tab-pane>

        </a-tabs>
            <!-- 选择筛选 -->
        <div class="select-box">
          <div>
            <a-select placeholder="部门"
                    title="部门"
                    labelInValue
                    showSearch
                    optionFilterProp="children"
                    v-model="searchData.dept"
                    style="width: 6%;margin-right: 10px;">
                <a-select-option v-for="item in options"
                            :title="item.name"
                            :key="item.id">{{item.name}}</a-select-option>
            </a-select>
            <a-select placeholder="操作平台"
                    title="操作平台"
                    labelInValue
                    showSearch
                    optionFilterProp="children"
                    v-model="searchData.operation_platform"
                    style="width: 6%;margin-right: 10px;">
                    <a-select-option :value="2" title="后台PC端">后台PC端</a-select-option>
                    <a-select-option :value="3" title="PDA">PDA</a-select-option>
                    <a-select-option :value="1" title="FS平台">FS平台</a-select-option>
                    <a-select-option :value="5" title="Community中文">Community中文</a-select-option>
                    <a-select-option :value="6" title="Community英文">Community英文</a-select-option>
                    <a-select-option :value="7" title="Arms">Arms</a-select-option>
                    <a-select-option :value="4" title="APP">APP</a-select-option>
            </a-select>

            <!-- <a-select placeholder="程序负责人"
                    title="程序负责人"
                    labelInValue
                    showSearch
                    optionFilterProp="children"
                    v-model="searchData.program_principal"
                    style="width: 6%;margin-right: 10px;">
                <a-select-option v-for="item in options_1"
                            :title="item.name"
                            :key="item.id">{{item.name}}</a-select-option>
            </a-select> -->
            <allPersonSelect :autoFocus="false"
                            @getSelectValue="handleSearch3"
                            :selectValue="program_principalID"
                            :searchData="program_principalArr"
                            ref="program_principalRef"
                            placeholder="程序负责人(请输入英文名搜索)"
                            style="width: 7%;margin-right: 10px;">
            </allPersonSelect>
             <!-- <a-select placeholder="程序跟进人"
                    title="程序跟进人"
                    labelInValue
                    showSearch
                    optionFilterProp="children"
                    v-model="searchData.handler"
                    style="width: 6%;margin-right: 10px;">
                <a-select-option v-for="item in options_1"
                            :title="item.name"
                            :key="item.id">{{item.name}}</a-select-option>
            </a-select> -->
            <allPersonSelect :autoFocus="false"
                            @getSelectValue="handleSearch4"
                            :selectValue="handlerID"
                            :searchData="handlerArr"
                            ref="handlerRef"
                            placeholder="程序跟进人(请输入英文名搜索)"
                            style="width: 7%;margin-right: 10px;">
            </allPersonSelect>
             <!-- <a-select placeholder="产品负责人"
                    title="产品负责人"
                    labelInValue
                    showSearch
                    optionFilterProp="children"
                    v-model="searchData.product_principal"
                    style="width: 6%;margin-right: 10px;">
                <a-select-option v-for="item in options_1"
                            :title="item.name"
                            :key="item.id">{{item.name}}</a-select-option>
            </a-select> -->
            <allPersonSelect :autoFocus="false"
                            @getSelectValue="handleSearch5"
                            :selectValue="product_principalID"
                            :searchData="product_principalArr"
                            ref="product_principalRef"
                            placeholder="产品负责人(请输入英文名搜索)"
                            style="width: 7%;margin-right: 10px;">
            </allPersonSelect>
             <!-- <a-select placeholder="测试负责人"
                    title="测试负责人"
                    labelInValue
                    showSearch
                    optionFilterProp="children"
                    v-model="searchData.test_principal"
                    style="width: 6%;margin-right: 10px;display:none">
                <a-select-option v-for="item in options_1"
                            :title="item.name"
                            :key="item.id">{{item.name}}</a-select-option>
            </a-select> -->
            <allPersonSelect :autoFocus="false"
                            @getSelectValue="handleSearch6"
                            :selectValue="test_principalID"
                            :searchData="test_principalArr"
                            ref="test_principalRef"
                            placeholder="测试负责人(请输入英文名搜索)"
                            style="width: 7%;margin-right: 10px;">
            </allPersonSelect>
            <a-select placeholder="审批情况"
                    title="审批情况"
                    labelInValue
                    showSearch
                    optionFilterProp="children"
                    v-model="searchData.examine_status"
                    style="width: 6%;margin-right: 10px;">
                    <!-- 审批状态 1：待财务审批；2：财务审批通过；3：财务审批驳回；4：待内控审批；5：内控审批通过；6：内控审批驳回 -->
                    <a-select-option :value="1">待财务审批</a-select-option>
                    <a-select-option :value="2">财务审批通过</a-select-option>
                    <a-select-option :value="3">财务审批驳回</a-select-option>
                    <a-select-option :value="4">待内控审批</a-select-option>
                    <a-select-option :value="5">内控审批通过</a-select-option>
                    <a-select-option :value="6">内控审批驳回</a-select-option>
            </a-select>
            <a-range-picker
                style="width:12%;margin-right: 10px;"
                v-model="searchData.created_at"
                :allowClear="false"
                format="YYYY/MM/DD"
                >
                <span class="iconfont" slot="suffixIcon" style="font-size:12px;margin-top: -6px;">&#xe659;</span>
            </a-range-picker>

            <div  style="width: 12%;position:relative;top: -0.5px;display: inline-block">
                <a-input-search placeholder="名称/简述/编号"
                                v-model="searchMsg"
                                @search="onSearch" />
            </div>
            <span style="margin-left:10px;color: #378eef">
                    <mySearch @search="moreSearch" ref="search" :department="options"></mySearch>
            </span>
        </div>
            <div class="upload_box">
            <div class="popup_opinion_submit_box after">
                <ul class="popup_opinion_submit_file">
                <span>筛选：</span>
                    <li v-if="searchData.dept"><b>部门：{{searchData.dept.label}}</b>
                        <i class="icon iconfont"
                        @click="reset(1)">&#xe631;</i>
                    </li>
                    <li v-if="searchData.examine_status"><b>审批情况：{{searchData.examine_status.label}}</b>
                        <i class="icon iconfont"
                        @click="reset(0)">&#xe631;</i>
                    </li>
                    <li v-if="searchData.operation_platform"><b>操作平台：{{searchData.operation_platform.label}}</b>
                        <i class="icon iconfont"
                        @click="reset(2)">&#xe631;</i>
                    </li>
                     <li v-if="searchData.program_principal"><b>程序负责人：{{searchData.program_principal.label}}</b>
                        <i class="icon iconfont"
                        @click="reset(3)">&#xe631;</i>
                    </li>
                     <li v-if="searchData.handler"><b>跟进人：{{searchData.handler.label}}</b>
                        <i class="icon iconfont"
                        @click="reset(4)">&#xe631;</i>
                    </li>
                    <li v-if="searchData.product_principal"><b>产品负责人：{{searchData.product_principal.label}}</b>
                        <i class="icon iconfont"
                        @click="reset(5)">&#xe631;</i>
                    </li>

                    <li v-if="searchData.test_principal"><b>测试负责人：{{searchData.test_principal.label}}</b>
                        <i class="icon iconfont"
                        @click="reset(6)">&#xe631;</i>
                    </li>

                    <li v-if="searchData.created_at"><b>时间：{{ searchData.created_at[0].format('YYYY/MM/DD') + ' 至 ' + searchData.created_at[1].format('YYYY/MM/DD')}}</b>
                        <i class="icon iconfont"
                        @click="reset(7)">&#xe631;</i>
                    </li>
                    <li v-if="mySearch"><b>高级筛选</b>
                        <i class="icon iconfont"
                        @click="reset(8)">&#xe631;</i>
                    </li>
                </ul>

            </div>
            </div>
        <div class="flow-chart cup" @click="show">流程图</div>
        <div class="btn-right">
            <p @click="toSetting" style="cursor: pointer;" v-if="canDo('pm.bugs.basicSettings')"><i class="icon iconfont"
               style="font-size: 12px;">&#xe6f9;</i>基础配置</p>

            <a-popover trigger="click" placement="bottomLeft">
                <div slot="content" >
                    <div style="padding:10px 10px 0">
                          <a-radio-group name="radioGroup" v-model="excelRadio">
                            <a-radio :value="1">
                            bug信息表
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
                    v-if="canDo('pm.bugs.store')"
                    @click="releaseBug"
                    >
                <a-icon type="plus"  />提Bug</a-button>
            </div>

        </div>
        </div>

      <div class="table-list">

        <a-table :rowSelection="{selectedRowKeys: selectedRowKeys, onChange: onSelectChange}"
                 :rowKey="(record, index) => record.id"
                 :columns="columns"
                 :scroll="{x:true}"
                 :loading="loading"
                 :pagination="pagination1"
                 :dataSource="data">
            <div slot="is_urgent" slot-scope="is_urgent,record" style="text-align: center">
                <div v-if="record.status!==5 && record.status!==6 && record.status!==7" style="position: relative;">
                    <div v-if="is_urgent || (record.remaining_days && record.remaining_days < 2 ) || record.remaining_days ===0">
                        <div class="left-line" style="background:#FF4A4A"></div>
                        <img v-if="is_urgent && (record.remaining_days && record.remaining_days < 2 || record.remaining_days ===0)"  src="../../../assets/images/sigh-2.png" title="加急/距离计划解决时间还剩一天" >
                        <img v-else-if="is_urgent"  src="../../../assets/images/sigh-2.png" title="加急" >
                        <img v-else-if="record.remaining_days &&record.remaining_days < 2 || record.remaining_days ===0"  src="../../../assets/images/sigh-2.png" title="距离计划解决时间还剩一天" >
                    </div>
                    <div v-else>
                        <div class="left-line"></div>
                        <img   src="../../../assets/images/sigh-1.png">
                    </div>

                </div>

            </div>
            <div slot="number" slot-scope="number,record">
                    <p @click="showMsg(record.id)" style="color:#378EEF" class="cup">{{number}}</p>
                    <p>
                        <span v-if="record.operation_platform===2">后台PC端</span>
                        <span v-if="record.operation_platform===3">PDA</span>
                        <span v-if="record.operation_platform===1">FS平台</span>
                        <span v-if="record.operation_platform===5">Community中文</span>
                        <span v-if="record.operation_platform===6">Community英文</span>
                        <span v-if="record.operation_platform===7">Arms</span>
                        <span v-if="record.operation_platform===4">APP</span>
                    </p>
                    <p>
                        <span v-if="record.is_urgent" class="is_urgent cup" title="加急" style="margin-right:6px">加急</span>
                        <a-popover  placement="bottomLeft"
                                    :getPopupContainer="triggerNode => triggerNode.parentNode"
                                    arrowPointAtCenter>
                                    <template slot="content">
                                        <p>CRM页面意见箱编号：<span>{{record.erp_bug_number}}</span></p>
                                    </template>
                                    <span v-if="record.erp_bug_number" class="is_urgent cup" style="color:rgba(255, 182, 26, 1);background:rgba(255, 182, 26, .2)">CRM</span>
                        </a-popover>

                    </p>
            </div>
            <div slot="created_at" slot-scope="created_at,record">
                <p>{{record.dept_name}}</p>
                <p>{{record.promulgator_name}}</p>
                <p>{{record.created_at}}</p>
            </div>
            <div slot="handlers" slot-scope="handlers,record" class="cup">
                <div @click="caozuo(18,record)" >
                    <span v-for="item in record.handlers" :key="item.id">{{item.handler_name}}</span>
                    <span v-if="record.handlers.length===0">--</span>
                </div>
            </div>
             <div slot="test_principal_name" slot-scope="test_principal_name,record" class="cup">
                <p v-if="!record.productSelect" @click="edit(3,record)">{{record.product_principal_name ? record.product_principal_name : '--'}}</p>
                <a-select
                    v-else
                    showSearch
                    style="width:120px"
                    placeholder="请输入英文名搜索"
                    title="请输入英文名搜索"
                    autoFocus
                    :value="record.product_principal_id"
                    @change="changeProduct($event,record)"
                    @blur="record.productSelect=false"
                    @search="search"
                    optionFilterProp="children"
                    >
                        <a-select-option v-for="item in options_2"
                                :key="item.id">{{item.name}}</a-select-option>
                </a-select>
                 <p v-if="!record.testSelect" @click="edit(4,record)">{{test_principal_name ? test_principal_name : '--'}}</p>
                <a-select
                    v-else
                    showSearch
                    style="width:120px"
                    placeholder="请输入英文名搜索"
                    title="请输入英文名搜索"
                    autoFocus
                    :value="record.test_principal_id"
                    @change="changeTest($event,record)"
                    @blur="record.testSelect=false"
                    @search="search"
                    optionFilterProp="children"
                    >
                        <a-select-option v-for="item in options_2"
                                :key="item.id">{{item.name}}</a-select-option>
                </a-select>

            </div>
            <div slot="program_principal_name" slot-scope="program_principal_name,record" class="cup">
                <p v-if="!record.devSelect" @click="edit(2,record)">{{program_principal_name ? program_principal_name : '--'}}</p>
                <a-select
                    v-else
                    showSearch
                    style="width:120px"
                    placeholder="请输入英文名搜索"
                    title="请输入英文名搜索"
                    autoFocus
                    :value="record.program_principal_id"
                    @change="changeDev($event,record)"
                    @blur="record.devSelect=false"
                    @search="search"
                    optionFilterProp="children"
                    >
                        <a-select-option v-for="item in options_2"
                                :key="item.id">{{item.name}}</a-select-option>
                </a-select>

            </div>

             <div slot="media" slot-scope="media" class="pro_annex">
                <a-popover placement="bottomLeft"
                    v-if="media.length>0"
                       :getPopupContainer="triggerNode => triggerNode.parentNode"
                       arrowPointAtCenter>
                    <template slot="content">
                        <div class="download-list">
                            <p>附件</p>
                            <downPrd :media="media"
                                    style="margin-bottom:-10px"
                                    :span="24"></downPrd>
                        </div>
                    </template>
                    <span class="icon iconfont cup">&#xe656;</span>
                </a-popover>
                <div v-else>--</div>
            </div>

            <div slot="reason" slot-scope="reason,record">
                   <span v-if="reason && reason.reason">{{reason.reason}}</span>
                   <span v-else>--</span>
                    <a-popover placement="bottomLeft"
                        v-if="reason && record.reason_analyse"
                        :getPopupContainer="triggerNode => triggerNode.parentNode"
                        arrowPointAtCenter>
                        <template slot="content">
                            <div>
                                <p style="color:#BBBBBB">根因分析:</p>
                                <p>{{record.reason_analyse}}</p>
                            </div>
                        </template>
                        <span class="iconfont cup" style="font-size: 12px;margin-left: 4px;">&#xe640;</span>
                    </a-popover>
            </div>
            <div slot="data_restore" slot-scope="data_restore,record">
                    <span v-if="data_restore===1">未修复</span>
                    <span v-else-if="data_restore===2">已修复</span>
                    <span v-else-if="data_restore===3">无需程序修复</span>
                    <span v-else-if="data_restore===4">程序无法修复</span>
                    <span v-else>--</span>
                    <a-popover placement="bottomLeft"
                        v-if="record.data_restore_comment"
                        :getPopupContainer="triggerNode => triggerNode.parentNode"
                        arrowPointAtCenter>
                        <template slot="content">
                            <div>
                                    <p style="color:#BBBBBB">数据修复情况备注:</p>
                                    <p>{{record.data_restore_comment}}</p>
                            </div>
                        </template>
                        <span class="iconfont cup" style="font-size: 12px;margin-left: 4px;">&#xe640;</span>
                    </a-popover>

            </div>
            <div slot="expiration_date" slot-scope="expiration_date,record">
                    <div class="cup">
                        <p @click="edit(1,record)" v-if="!record.dateSelect">{{expiration_date ? expiration_date : '--'}}</p>
                        <a-date-picker
                            v-else
                            :disabledDate="disabledDate"
                            @change="changeDate($event,record)"
                            @openChange="blurDate($event,record)"/>
                    </div>

                    <span v-if="record.status!==0 && record.status_desc!==7">
                            <span v-if="record.remaining_days_type==0">
                                <span style="color:#F28D49" v-if="record.remaining_days>0 || record.remaining_days===0"><span class="iconfont" style="font-size: 13px;">&#xe65f;</span> 还剩{{record.remaining_days}}天</span>
                                <span style="color:#F28D49;" v-if="record.remaining_days<0"><span class="iconfont" style="font-size: 13px;">&#xe65f;</span> 超时{{Math.abs(record.remaining_days)}}天</span>
                            </span>
                            <span v-if="record.remaining_days_type==1">
                                <span style="color:#3DCCA6" v-if="record.remaining_days>0"><span class="iconfont" style="font-size: 13px;">&#xe663;</span> 提前{{record.remaining_days}}天</span>
                                <span style="color:#3DCCA6" v-if="record.remaining_days===0"><span class="iconfont" style="font-size: 13px;">&#xe65e;</span> 按时提交</span>
                                <span style="color:#FF4A4A;" v-if="record.remaining_days<0"><span class="iconfont" style="font-size: 13px;">&#xe65d;</span> 超时{{Math.abs(record.remaining_days)}}天</span>
                            </span>
                            <span v-if="record.remaining_days_type==2">
                                <span style="color:#3DCCA6" v-if="record.remaining_days>0"><span class="iconfont" style="font-size: 13px;">&#xe663;</span> 提前{{record.remaining_days}}天</span>
                                <span style="color:#3DCCA6" v-if="record.remaining_days===0"><span class="iconfont" style="font-size: 13px;">&#xe65e;</span> 按时完成</span>
                                <span style="color:#FF4A4A;" v-if="record.remaining_days<0"><span class="iconfont" style="font-size: 13px;">&#xe65d;</span> 超时{{Math.abs(record.remaining_days)}}天</span>
                            </span>
                    </span>
                    <!-- <span style="color:#F28D49" v-if="record.remaining_days>0 || record.remaining_days===0"><span class="iconfont" style="font-size: 13px;">&#xe65f;</span> 还剩{{record.remaining_days}}天</span>
                    <span style="color:#F28D49;" v-if="record.remaining_days<0"><span class="iconfont" style="font-size: 13px;">&#xe65f;</span> 超时{{Math.abs(record.remaining_days)}}天</span> -->
            </div>
            <div slot="labels" slot-scope="labels,record" >
                <div v-for="item in labels" :key="item.id" style="margin-bottom: 6px;" class="cup">
                     <a-popover placement="bottomLeft"
                       :getPopupContainer="triggerNode => triggerNode.parentNode"
                       arrowPointAtCenter>
                        <template slot="content">
                            <div>
                                <p style="color:#bbb">审批人: </p>
                                <span>{{item.user_name}}</span>
                                <p style="color:#bbb">审批意见:</p>
                                <span>{{item.comment}}</span>
                            </div>
                        </template>
                        <img v-if="item.name==='财务审批通过'" src="../../../assets/images/tag-1.png">
                        <img v-if="item.name==='财务审批驳回'" src="../../../assets/images/tag-2.png">
                        <img v-if="item.name==='内控审批通过'" src="../../../assets/images/tag-3.png">
                        <img v-if="item.name==='内控审批驳回'" src="../../../assets/images/tag-4.png">
                    </a-popover>
                    <a-popover placement="bottomLeft"
                        :getPopupContainer="triggerNode => triggerNode.parentNode"
                        arrowPointAtCenter>
                        <template slot="content">
                            <div>
                                <p style="margin-bottom:10px">验收情况</p>
                                <div v-for="item2 in record.bug_accept" :key="item2.id">
                                    <div v-if="item2.result">
                                        <p style="color:#bbb" v-if="item2.type===1">发布人: </p>
                                        <p style="color:#bbb" v-if="item2.type===2">测试负责人: </p>
                                        <p style="color:#bbb" v-if="item2.type===3">产品负责人: </p>
                                        <span v-if="item2.type!==4">
                                            <span style="margin-right:10px">{{item2.user_name}}</span><span>{{item2.created_at}}</span>
                                            <p style="color:#bbb">备注说明:</p>
                                            <span>{{item2.comment}}</span>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </template>
                        <img v-if="item.name==='已验收'" src="../../../assets/images/tag-6.png">
                    </a-popover>
                    <a-popover placement="bottomLeft"
                        :getPopupContainer="triggerNode => triggerNode.parentNode"
                        arrowPointAtCenter>
                        <template slot="content">
                            <div>
                                <p style="color:#bbb">验收人: </p>
                                <span>{{item.user_name}}</span>
                                <p style="color:#bbb">备注: </p>
                                <span>{{item.comment ? item.comment : '--'}}</span>
                                <div v-if="record.media_accept.length">
                                    <p style="color:#bbb">故障截图:</p>
                                    <downPrd :media="record.media_accept"
                                                style="margin-bottom:-10px"
                                                :span="24"></downPrd>
                                </div>
                            </div>
                        </template>
                        <img v-if="item.name==='验收不合格'" src="../../../assets/images/tag-5.png">
                    </a-popover>
                     <a-popover placement="bottomLeft"
                       :getPopupContainer="triggerNode => triggerNode.parentNode"
                       arrowPointAtCenter>
                        <template slot="content">
                            <div>
                                <p style="color:#bbb">操作人: </p>
                                <span>{{item.user_name}}</span>
                                <p style="color:#bbb">操作时间:</p>
                                <span>{{item.updated_at}}</span>
                            </div>
                        </template>
                        <img v-if="item.name==='Bug已关闭'" src="../../../assets/images/tag-7.png">
                    </a-popover>
                </div>
                <div v-if="!labels || labels.length===0">--</div>
            </div>
             <div slot="status" class="cup" slot-scope="status,record" @click="showLogs(record)">

                    <span v-if="status===0"><span class="iconfont fz12" style="color:#FF4A4A">&#xe654;</span> {{record.status_desc}}</span>
                    <span v-if="status===1"><span class="iconfont fz12" style="color:#FF4A4A">&#xe654;</span> {{record.status_desc}}</span>
                    <span v-if="status===2"><span class="iconfont fz12" style="color:#FFB400">&#xe654;</span> {{record.status_desc}}</span>
                    <span v-if="status===3"><span class="iconfont fz12" style="color:#FFB400">&#xe654;</span> {{record.status_desc}}</span>
                    <span v-if="status===4"><span class="iconfont fz12" style="color:#FFB400">&#xe654;</span> {{record.status_desc}}</span>
                    <span v-if="status===5"><span class="iconfont fz12" style="color:#3DCCA6">&#xe653;</span> {{record.status_desc}}</span>
                    <span v-if="status===6"><span class="iconfont fz12" style="color:#FF4A4A">&#xe653;</span> {{record.status_desc}}</span>
                    <span v-if="status===7"><span class="iconfont fz12" style="color:#BBBBBB">&#xe654;</span> {{record.status_desc}}</span>
                    <span v-if="status===9"><span class="iconfont fz12" style="color:#FF4A4A">&#xe654;</span> {{record.status_desc}}</span>
                    <span v-if="status===10"><span class="iconfont fz12" style="color:#FF4A4A">&#xe654;</span> {{record.status_desc}}</span>
                      <a-popover placement="bottomLeft"
                        v-if="record.solution || record.inquiry_progress"
                        :getPopupContainer="triggerNode => triggerNode.parentNode"
                        arrowPointAtCenter>
                        <template slot="content">
                            <div style="margin-bottom:10px">
                                    <p style="color:#BBBBBB">解决方案:</p>
                                    <p>{{record.solution ?record.solution : '--' }}</p>
                            </div>
                            <div style="margin-bottom:10px">
                                    <p style="color:#BBBBBB">调查进展:</p>
                                    <p>{{record.inquiry_progress ? record.inquiry_progress : '--'}}</p>
                            </div>
                        </template>
                        <span class="iconfont cup" style="font-size: 12px;margin-left: 4px;">&#xe640;</span>
                    </a-popover>
            </div>
            <div slot="operate" slot-scope="operate,record" class="pro_operate">
                       <!-- 操作 -->
            <span v-for="(item,index) in record.operation" :key="index" >
                    <span class="icon iconfont"
                    v-if="item==='开始'"
                    @click="caozuo(8,record)"
                    title="开始">&#xe635;</span>
                    <span class="icon iconfont"
                     v-if="item==='复核'"
                    @click="caozuo(11,record)"
                    title="复核">&#xe6f6;</span>
                     <span class="icon iconfont"
                    v-if="item==='提交处理结果'"
                    @click="caozuo(9,record)"
                  title="提交处理结果">&#xe65b;</span>
                   <span class="icon iconfont"
                   v-if="item==='撤销提交'"
                    @click="caozuo(10,record)"
                  title="撤销提交">&#xe65c;</span>
                  <span class="icon iconfont"
                    v-if="item==='更改提交信息'"
                    @click="caozuo(19,record)"
                  title="更改提交信息">&#xe645;</span>
                  <span class="icon iconfont"
                   v-if="item==='财务审批'"
                    @click="caozuo(6,record)"
                  title="财务审批">&#xe63d;</span>
                   <span class="icon iconfont"
                   v-if="item==='内控审批'"
                    @click="caozuo(7,record)"
                  title="内控审批">&#xe63d;</span>
                 <span class="icon iconfont"
                     v-if="item==='申请审批'"
                    @click="caozuo(4,record)"
                  title="申请审批">&#xe6fc;</span>
                   <span class="icon iconfont"
                   style="color:#FEBC2E"
                     v-if="item==='撤销审批申请'"
                    @click="caozuo(5,record)"
                  title="撤销审批申请">&#xe6fc;</span>
                   <span class="icon iconfont"
                    v-if="item==='提bug人验收'"
                    @click="caozuo(13,record)"
                  title="提bug人验收">&#xe647;</span>
                  <span class="icon iconfont"
                    v-if="item==='产品验收'"
                    @click="caozuo(14,record)"
                  title="产品验收">&#xe647;</span>
                   <span class="icon iconfont"
                    v-if="item==='补充信息'"
                    @click="caozuo(17,record)"
                  title="补充信息">&#xe6f7;</span>
                   <span class="icon iconfont"
                    v-if="item==='测试验收'"
                    @click="caozuo(12,record)"
                  title="测试验收">&#xe647;</span>
                    <span class="icon iconfont"
                    v-if="item==='关闭bug'"
                    @click="caozuo(16,record)"
                  title="关闭bug">&#xe6f8;</span>
                    <span class="icon iconfont"
                    v-if="item==='发布需求'"
                    @click="caozuo(15,record)"
                  title="发布需求">&#xe63a;</span>
                    <a-popover placement="bottomLeft"
                            v-if="item==='诉求/需求信息'"
                            :getPopupContainer="triggerNode => triggerNode.parentNode"
                            arrowPointAtCenter>
                            <template slot="content">
                                <div style="display:flex" v-if="record.appeals.length">
                                    <p style="color:#bbb;width:52px;white-space: nowrap;margin-right: 10px;">诉求信息:</p>
                                    <div>
                                        <div  v-for="item in record.appeals" :key="item.id">
                                            <router-link :to="{ name: 'claimDetail', query: { id: item.id }}" target="_blank" >  {{item.number}}</router-link>
                                            <p>{{item.name}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div style="display:flex" v-if="record.demands.length">
                                    <p style="color:#bbb;width:52px;white-space: nowrap;margin-right: 10px;">需求信息:</p>
                                    <div>
                                        <div  v-for="item in record.demands" :key="item.id">
                                            <router-link :to="{ name: 'demandDetails', query: { id: item.id }}" target="_blank" >  {{item.number}}</router-link>
                                            <p>{{item.name}}</p>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <span class="icon iconfont"
                                >&#xe62a;</span>
                    </a-popover>
                    <span class="icon iconfont"
                        v-if="item==='发布诉求'"
                        @click="caozuo(3,record)"
                    title="发布诉求">&#xe6f5;</span>
                    <span class="icon iconfont"
                        v-if="item==='编辑'"
                        @click="caozuo(1,record)"
                    title="编辑">&#xe637;</span>
                    <span class="icon iconfont"
                        v-if="item==='撤销'"
                        @click="caozuo(2,record)"
                    title="撤销">&#xe657;</span>

            </span>
             <!-- 超过3个展示这个下拉 -->
            <div class="eidtDropdown" v-if="record.operation2 && record.operation2.length">
                    <a-dropdown placement="bottomCenter" :trigger="['click']" :getPopupContainer="triggerNode => triggerNode.parentNode">
                    <a class="ant-dropdown-link" href="#" v-if="record.operation2 && record.operation2.length">
                      <span  title="更多" class="icon iconfont">&#xe634;</span>
                    </a>
                    <a-menu slot="overlay" style="padding: 5px 2px;width:120px;" class="edit-icon">
                      <a-menu-item v-for="(item,index) in record.operation2" :key="index" >
                           <span class="icon iconfont"
                                    v-if="item==='开始'"
                                    @click="caozuo(8,record)"
                                title="开始">&#xe635;<span class="eidt-text">{{item}}</span></span>
                            <span class="icon iconfont"
                                    v-if="item==='复核'"
                                    @click="caozuo(11,record)"
                                title="复核">&#xe6f6;<span class="eidt-text">{{item}}</span></span>
                             <span class="icon iconfont"
                                    v-if="item==='提交处理结果'"
                                    @click="caozuo(9,record)"
                                title="提交处理结果">&#xe65b;<span class="eidt-text">{{item}}</span></span>
                              <span class="icon iconfont"
                                v-if="item==='撤销提交'"
                                    @click="caozuo(10,record)"
                                title="撤销提交">&#xe65c;<span class="eidt-text">{{item}}</span></span>
                               <span class="icon iconfont"
                                    v-if="item==='更改提交信息'"
                                    @click="caozuo(19,record)"
                                title="更改提交信息">&#xe645;<span class="eidt-text">{{item}}</span></span>
                                 <span class="icon iconfont"
                                v-if="item==='财务审批'"
                                    @click="caozuo(6,record)"
                                title="财务审批">&#xe63d;<span class="eidt-text">{{item}}</span></span>
                                <span class="icon iconfont"
                                v-if="item==='内控审批'"
                                    @click="caozuo(7,record)"
                                title="内控审批">&#xe63d;<span class="eidt-text">{{item}}</span></span>
                                 <span class="icon iconfont"
                                    v-if="item==='审批申请'"
                                    @click="caozuo(4,record)"
                                title="申请审批">&#xe6fc;<span class="eidt-text">{{item}}</span></span>
                                <span class="icon iconfont"
                                style="color:#FEBC2E"
                                    v-if="item==='撤销审批申请'"
                                    @click="caozuo(5,record)"
                                title="撤销审批申请">&#xe6fc;<span class="eidt-text">{{item}}</span></span>
                                 <span class="icon iconfont"
                                    v-if="item==='提bug人验收'"
                                    @click="caozuo(13,record)"
                                title="提bug人验收">&#xe647;<span class="eidt-text">{{item}}</span></span>
                                <span class="icon iconfont"
                                    v-if="item==='产品验收'"
                                    @click="caozuo(14,record)"
                                title="产品验收">&#xe647;<span class="eidt-text">{{item}}</span></span>
                                  <span class="icon iconfont"
                                    v-if="item==='补充信息'"
                                    @click="caozuo(17,record)"
                                title="补充信息">&#xe6f7;<span class="eidt-text">{{item}}</span></span>
                                 <span class="icon iconfont"
                                    v-if="item==='测试验收'"
                                    @click="caozuo(12,record)"
                                title="测试验收">&#xe647;<span class="eidt-text">{{item}}</span></span>
                                 <span class="icon iconfont"
                                    v-if="item==='关闭bug'"
                                    @click="caozuo(16,record)"
                                title="关闭bug">&#xe6f8;<span class="eidt-text">{{item}}</span></span>
                                <span class="icon iconfont"
                                    v-if="item==='发布需求'"
                                    @click="caozuo(15,record)"
                                title="发布需求">&#xe63a;<span class="eidt-text">{{item}}</span></span>
                                 <a-popover placement="bottomLeft"
                                            v-if="item==='诉求/需求信息'"
                                            :getPopupContainer="triggerNode => triggerNode.parentNode"
                                            arrowPointAtCenter>
                                            <template slot="content">
                                                <div style="display:flex" v-if="record.appeals.length">
                                                    <p style="color:#bbb;width:52px">诉求信息: </p>
                                                    <div>
                                                        <div  v-for="item in record.appeals" :key="item.id">
                                                            <p>{{item.number}}</p>
                                                            <p>{{item.name}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="display:flex" v-if="record.demands.length">
                                                    <p style="color:#bbb;width:52px">需求信息: </p>
                                                    <div>
                                                        <div  v-for="item in record.demands" :key="item.id">
                                                            <p>{{item.number}}</p>
                                                            <p>{{item.name}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                            <span class="icon iconfont"
                                                >&#xe62a;<span class="eidt-text">{{item}}</span></span>
                                    </a-popover>
                            <span class="icon iconfont"
                                        v-if="item==='发布诉求'"
                                        @click="caozuo(3,record)"
                                        title="发布诉求">&#xe6f5;<span class="eidt-text">{{item}}</span></span>
                            <span class="icon iconfont"
                                        v-if="item==='编辑'"
                                        @click="caozuo(1,record)"
                                    title="编辑">&#xe637;<span class="eidt-text">{{item}}</span></span>
                                    <span class="icon iconfont"
                                        v-if="item==='撤销'"
                                        @click="caozuo(2,record)"
                                    title="撤销">&#xe657;<span class="eidt-text">{{item}}</span></span>
                      </a-menu-item>
                    </a-menu>
                  </a-dropdown>
            </div>

            </div>

        </a-table>
      </div>
      <div style="margin-bottom: 16px">
          <div class="table-eidt" :style="{width:screenWidth+'px',height:'64px'}" v-if="data.length>0">
            <a-table :rowSelection="{selectedRowKeys: selectedRowKeys, onChange: onSelectChange}"
                     :rowKey="(record, index) => record.id"
                     :columns="columns"
                     :pagination="pagination1"
                     @change="changePage"
                     :dataSource="data">
            </a-table>
            <span class="select-lengs select-lengs-eidt">
              全选
            </span>
            <span class="select-lengs">
              <template v-if="hasSelected">
                {{`选中 ${selectedRowKeys.length} 个Bug`}}
              </template>
            </span>

          </div>

        </div>
    </div>
</template>
<script>
import moment from 'moment'
import _ from 'lodash'
import mySearch from './components/search'
import { canDo, filtering } from '@/plugins/common'
import qs from 'qs'
import { getBugs, revocationBug, applyBug, revocationApply, financeExamine,
  internalControlExamine, startBug, submitHandleResult, submitHandleResultCancel,
  reexamine, acceptTest, acceptPromulgator, acceptProduct, closeBug, appendInfo,
  expirationDate, setFollow, setDev, setProduct, setTest, bugDetail, bugLogs, getExcel, updateSubmitResult } from '@/api/RDmanagement/bug/index.js'
import { getlDepartment, demandList, getBindPeople } from '@/api/RDmanagement/dropDown'
import { getBugsReason } from '@/api/RDmanagement/bug/setting.js'
import { searchUserList } from '@/api/userManage/index.js'
import downPrd from '@/components/downPrd'
import { getProducts } from '@/api/RDmanagement/ProductMaintenance/index.js'
import projectSelect from '@/components/projectSelect.vue'
import { allow, allowSize } from '@/plugins/common.js'
import downMedia from '@/components/downMedia'
import myViewer from '@/components/myViewer'
import operationLogs from '@/components/operationLogs'
import allPersonSelect from '@/components/allPersonSelect'

const columns = [
  {
    title: '',
    dataIndex: 'is_urgent',
    key: 'is_urgent',
    width: 80,
    scopedSlots: { customRender: 'is_urgent' }
  },
  {
    title: 'ID/操作平台/紧急程度',
    dataIndex: 'number',
    key: 'number',
    scopedSlots: { customRender: 'number' },
    width: '10%'
  },
  {
    title: '发布信息',
    key: 'created_at',
    dataIndex: 'created_at',
    scopedSlots: { customRender: 'created_at' },
    sorter: function (a, b) {
      let aTimeString = a.created_at
      let bTimeString = b.created_at
      aTimeString = aTimeString.replace(/-/g, '/')
      bTimeString = bTimeString.replace(/-/g, '/')
      let aTime = new Date(aTimeString).getTime()
      let bTime = new Date(bTimeString).getTime()
      return bTime - aTime
    },
    width: '9%'
  },
  {
    title: '程序负责人',
    key: 'program_principal_name',
    dataIndex: 'program_principal_name',
    scopedSlots: { customRender: 'program_principal_name' },
    width: 130

  },
  {
    title: '程序跟进人',
    key: 'handlers',
    dataIndex: 'handlers',
    scopedSlots: { customRender: 'handlers' },
    width: 120
  },
  {
    title: '产品/测试负责人',
    key: 'test_principal_name',
    dataIndex: 'test_principal_name',
    scopedSlots: { customRender: 'test_principal_name' },
    width: '9%'
  },
  {
    title: '附件',
    key: 'media',
    dataIndex: 'media',
    scopedSlots: { customRender: 'media' },
    width: 85
  },
  {
    title: '原因类型',
    key: 'reason',
    dataIndex: 'reason',
    scopedSlots: { customRender: 'reason' },
    width: '9%'
  },
  {
    title: '数据修复情况',
    key: 'data_restore',
    dataIndex: 'data_restore',
    scopedSlots: { customRender: 'data_restore' },
    width: 130
  },
  {
    title: '处理时限',
    key: 'expiration_date',
    dataIndex: 'expiration_date',
    scopedSlots: { customRender: 'expiration_date' },
    width: 130
  },
  {
    title: '处理状态',
    key: 'status',
    dataIndex: 'status',
    scopedSlots: { customRender: 'status' },
    width: 130
  },
  {
    title: '标签',
    key: 'labels',
    dataIndex: 'labels',
    scopedSlots: { customRender: 'labels' },
    width: 130
  },
  {
    title: '操作',
    key: 'operate',
    dataIndex: 'operate',
    scopedSlots: { customRender: 'operate' },
    width: 115
  }

]

const columns2 = [
  {
    title: '时间',
    key: 'created_at',
    width: 175,
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
    width: 107,
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
  components: { downPrd, mySearch, projectSelect, myViewer, downMedia, operationLogs, allPersonSelect },
  data () {
    return {
      images: [require('../../../assets/images/flow-chart.jpg')],
      excelRadio: 1,
      riskManagement: false,
      visible: false,
      mediaShow: true,
      logsShow: false,
      mySearch: false,
      btnLoad: false,
      msgLoad: false,
      data: [],
      columns,
      data2: [],
      columns2,
      bugId: '',
      searchMsg: '',
      remind: {},
      approvalForm: {
        result: undefined,
        required_internal_control: undefined,
        comment: undefined
      },
      submitForm: {
        resolve_status: undefined,
        solution: undefined,
        reason_id: undefined,
        reason_analyse: undefined,
        data_restore: undefined,
        data_restore_comment: undefined,
        inquiry_progress: undefined
      },
      reviewForm: {
        resolve_status: undefined,
        solution: undefined,
        reason_id: undefined,
        reason_analyse: undefined,
        data_restore: undefined,
        data_restore_comment: undefined,
        comment: undefined,
        is_qualified: undefined
      },
      acceptForm: {
        result: 1,
        comment: undefined,
        media: [{ name: '', file: null }]
      },
      closeForm: {
        product_line: undefined,
        product_id: undefined,
        source_demand: undefined,
        source_project_id: undefined,
        source_project_name: undefined,
        comment: undefined
      },
      followForm: {
        follower_id: [],
        expiration_date: undefined,
        comment: undefined
      },
      bugReasons: [],
      acceptType: undefined,
      submitType: undefined,
      approvalType: undefined,
      closeType: undefined,
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
      options: [],
      options_1: [],
      options_2: [],
      program_principalArr: [],
      program_principalID: undefined,
      handlerArr: [],
      handlerID: undefined,
      product_principalArr: [],
      product_principalID: undefined,
      test_principalArr: [],
      test_principalID: undefined,
      followerArr: [],
      followerID: undefined,
      productsLine: [],
      products: [],
      demand: [],
      selectedRowKeys: [],
      loading: true,
      bugMsg: {
        policies: {},
        bug_accept: [],
        appeals: [],
        demands: [],
        product_category: {
          product_line: {},
          product: {}
        },
        project: {},
        demand: {},
        media: [],
        labels: []
      },
      activeKey: '1',
      searchData: {
        tabs: -1,
        dept: undefined,
        examine_status: undefined,
        created_at: undefined,
        operation_platform: undefined,
        product_principal: undefined,
        program_principal: undefined,
        test_principal: undefined,
        handler: undefined
      },
      pagination1: {
        showSizeChanger: true,
        pageSizeOptions: ['10', '20', '30', '50'],
        total: 10,
        current: 1,
        pageSize: 10
      },
      comment: undefined,
      screenWidth: this.$store.state.recount.pageWidth
    }
  },
  watch: {
    '$store.state.recount.pageWidth' (newVal) {
      this.screenWidth = newVal
    },
    searchData: {
      handler (newVal, oldVal) {
        if (!this.searchMsg && !this.$route.query.number && !this.$route.query.erp_bug_number) {
          search['keyword'] = undefined
        }
        search['status'] = newVal.tabs
        if (newVal.tabs === -1) {
          search['status'] = undefined
        }
        if (newVal.tabs === 8) {
          search['status'] = '9, 10'
        }
        if (newVal.dept) {
          search['dept_id'] = newVal.dept.key
        } else {
          search['dept_id'] = undefined
        }
        if (newVal.examine_status) {
          search['examine_status'] = newVal.examine_status.key
        } else {
          search['examine_status'] = undefined
        }

        if (newVal.operation_platform) {
          search['operation_platform'] = newVal.operation_platform.key
        } else {
          search['operation_platform'] = undefined
        }
        if (newVal.product_principal) {
          search['product_principal_id'] = newVal.product_principal.key
        } else {
          search['product_principal_id'] = undefined
        }
        if (newVal.program_principal) {
          search['program_principal_id'] = newVal.program_principal.key
        } else {
          search['program_principal_id'] = undefined
        }
        if (newVal.test_principal) {
          search['test_principal_id'] = newVal.test_principal.key
        } else {
          search['test_principal_id'] = undefined
        }
        if (newVal.handler) {
          search['handlers.handler_id'] = newVal.handler.key
        } else {
          search['handlers.handler_id'] = undefined
        }
        if (newVal.created_at) {
          search['created_at'] = newVal.created_at[0].format('YYYY/MM/DD') + ',' + newVal.created_at[1].format('YYYY/MM/DD')
        } else {
          search['created_at'] = undefined
        }
        this.loading = true
        let params = { filters: search,
          may,
          must,
          limit: this.pagination1.pageSize || 10 }
        this.getBugsAll(params)
      },
      deep: true
    }
  },
  created () {
    if (this.$route.query.number) {
      search['keyword'] = this.$route.query.number
    }
    if (this.$route.query.erp_bug_number) {
      search['keyword'] = this.$route.query.erp_bug_number
    }
    if (localStorage.getItem('isReload5')) {
      this.$store.commit('changeGuide5', false)
    } else {
      this.$store.commit('changeGuide5', true)
      localStorage.setItem('isReload5', true)
    }
    let userType = {}
    let user = {}
    let userCache = {}
    if (localStorage.getItem('userType')) {
      userType = JSON.parse(localStorage.getItem('userType'))
    }
    if (localStorage.getItem('user')) {
      user = JSON.parse(localStorage.getItem('user'))
      userCache = _.cloneDeep(user)
      if (user.basic_department.id !== 223 && user.basic_department.id !== 212 && user.basic_department.id !== 205 && user.basic_department.code !== 'IS' &&
      !this.$route.query.number && !this.$route.query.erp_bug_number) {
        this.searchData.dept = { label: user.basic_department.name, key: user.basic_department.id }
      }
      if (userType.finance || userType.internal_control) {
        this.riskManagement = true
      } else {
        this.riskManagement = false
      }
    }
    if (userType.bug_program_principal && !this.$route.query.number && !this.$route.query.erp_bug_number) {
      this.program_principalArr = userCache.id ? [{ name: userCache.name, id: userCache.id }] : []
      this.program_principalID = userCache.id ? userCache.id : undefined
      this.searchData.program_principal = { label: user.name, key: user.id }
    } else if (userType.bug_program_follower && !this.$route.query.number && !this.$route.query.erp_bug_number) {
      this.handlerArr = userCache.id ? [{ name: userCache.name, id: userCache.id }] : []
      this.handlerID = userCache.id ? userCache.id : undefined
      this.searchData.handler = { label: user.name, key: user.id }
    } else if (userType.bug_test_principal && !this.$route.query.number && !this.$route.query.erp_bug_number) {
      this.test_principalArr = userCache.id ? [{ name: userCache.name, id: userCache.id }] : []
      this.test_principalID = userCache.id ? userCache.id : undefined
      this.searchData.test_principal = { label: user.name, key: user.id }
    } else if (userType.bug_product_principal && !this.$route.query.number && !this.$route.query.erp_bug_number) {
      this.product_principalArr = userCache.id ? [{ name: userCache.name, id: userCache.id }] : []
      this.product_principalID = userCache.id ? userCache.id : undefined
      this.searchData.product_principal = { label: user.name, key: user.id }
    } else {
      search = []
      if (this.$route.query.number) {
        search['keyword'] = this.$route.query.number
      }
      if (this.$route.query.erp_bug_number) {
        search['keyword'] = this.$route.query.erp_bug_number
      }
      this.getBugsAll()
    }

    // this.getBugsAll()
    demandList().then(res => {
      this.demand = res.data
    })
    getProducts().then(res => {
      this.productsLine = res.data.products
    })
    getlDepartment().then(res => {
      if (res.code === 200) {
        this.options = res.data.departments
      }
    })
    getBugsReason().then(res => {
      if (res.code === 200) {
        this.bugReasons = res.data
      }
    })
    getBindPeople().then(res => {
      if (res.code === 200) {
        this.options_1 = res.data.users
      }
    })
  },
  computed: {

    hasSelected () {
      return this.selectedRowKeys.length > 0
    },
    requiredReason () {
      let a = ''
      this.bugReasons.forEach(item => {
        if (item.id === this.submitForm.reason_id) {
          a = item.required_analyse
        }
      })
      return a
    },
    requiredReason2 () {
      let a = ''
      this.bugReasons.forEach(item => {
        if (item.id === this.reviewForm.reason_id) {
          a = item.required_analyse
        }
      })
      return a
    }
  },
  methods: {
    moment,
    canDo,
    handleSearch3 (e) {
      this.searchData.program_principal = e.id === undefined ? undefined : { key: e.id, label: e.name }
    },
    handleSearch4 (e) {
      this.searchData.handler = e.id === undefined ? undefined : { key: e.id, label: e.name }
    },
    handleSearch5 (e) {
      this.searchData.product_principal = e.id === undefined ? undefined : { key: e.id, label: e.name }
    },
    handleSearch6 (e) {
      this.searchData.test_principal = e.id === undefined ? undefined : { key: e.id, label: e.name }
    },
    handleModalSearch (e) {
      this.followForm.follower_id = e.id === undefined ? undefined : e.id
    },
    search (e) {
      this.$nextTick(() => {
        let self = this
        this.timer = searchUserList(this.timer, e, function (data) {
          self.options_2 = data.data.users
        })
      })
    },
    inited (viewer) {
      this.$viewer = viewer
    },
    show () {
    //   this.$viewer.view(2)
      this.$viewer.show()
    },
    disabledDate (current) {
      // 不能选择今天以前的日期
      return current && current < moment().startOf('day')
    },
    handleExport () {
      search['id'] = this.selectedRowKeys.toString()
      let params = { may, must, search }
      params = qs.stringify(params)
      getExcel(params)
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
      this.program_principalArr = []
      this.program_principalID = undefined
      this.$refs.program_principalRef.value = undefined
      this.handlerArr = []
      this.handlerID = undefined
      this.$refs.handlerRef.value = undefined
      this.product_principalArr = []
      this.product_principalID = undefined
      this.$refs.product_principalRef.value = undefined
      this.test_principalArr = []
      this.test_principalID = undefined
      this.$refs.test_principalRef.value = undefined
      for (let key in this.searchData) {
        if (key === 'program_principal' || key === 'handler' || key === 'product_principal' || key === 'test_principal') {
          this.searchData[key] = undefined
        } else {
          delete this.searchData[key]
        }
      }
      search = []
      this.mySearch = true
      getBugs(params).then(res => {
        this.$refs.search.showSearch = false
        this.remind = res.data.remind
        this.data = res.data.data.map(item => {
          return { ...item, dateSelect: false, productSelect: false, devSelect: false, testSelect: false }
        })
        this.data.forEach(item => {
          let arr = [item.policies.start ? '开始' : '', item.policies.reexamine ? '复核' : '', item.policies.submitHandleResult ? '提交处理结果' : '', item.policies.submitHandleResultCancel ? '撤销提交' : '',
            item.policies.updateHandleResult ? '更改提交信息' : '', item.policies.financeExamine ? '财务审批' : '', item.policies.internalControlExamine ? '内控审批' : '', item.policies.applyExamine ? '申请审批' : '', item.policies.applyExamineCancel ? '撤销审批申请' : '',
            item.policies.acceptPromulgator ? '提bug人验收' : '', item.policies.acceptProduct ? '产品验收' : '',
            item.policies.appendInfo ? '补充信息' : '', item.policies.acceptTest ? '测试验收' : '', item.policies.close ? '关闭bug' : '', item.policies.publishDemand ? '发布需求' : '', (item.appeals.length || item.demands.length) ? '诉求/需求信息' : '',
            item.policies.publishAppeal ? '发布诉求' : '', item.policies.update ? '编辑' : '', item.policies.revocation ? '撤销' : ''
          ].filter(Boolean)
          if (arr.length > 2) {
            item.operation = arr.slice(0, 3)
            item.operation2 = arr.splice(3)
          } else {
            item.operation = arr
          }
        })
        this.pagination1.total = res.data.total
        this.pagination1.current = res.data.current_page
        this.pagination1.pageSize = res.data.per_page
        this.loading = false
      }).catch(error => {
        this.loading = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    showLogs (record) {
      bugLogs(record.id).then(res => {
        this.logsShow = true
        if (res.code === 200) {
          this.data2 = res.data.status_logs
        }
      })
    },
    showBugDetail (id) {
      bugDetail(id).then(res => {
        this.bugMsg = res.data.bug
        this.bugMsg.operation_log = this.bugMsg.operation_log.map(item => {
          return { show: false, ...item }
        })
      })
    },
    showMsg (id) {
      this.visible = true
      this.msgLoad = true
      bugDetail(id).then(res => {
        this.bugMsg = res.data.bug
        this.msgLoad = false
        this.bugMsg.operation_log = this.bugMsg.operation_log.map(item => {
          return { show: false, ...item }
        })
      })
    },
    onClose () {
      this.visible = false
      this.activeKey = '1'
    },
    changeDev (e, record) {
      let params = { user_id: e }
      setDev(record.id, params).then(res => {
        this.$message.success('设置成功')
        record.devSelect = false
        this.getBugsAll()
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    changeProduct (e, record) {
      let params = { user_id: e }
      setProduct(record.id, params).then(res => {
        this.$message.success('设置成功')
        record.productSelect = false
        this.getBugsAll()
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    changeTest (e, record) {
      let params = { user_id: e }
      setTest(record.id, params).then(res => {
        this.$message.success('设置成功')
        record.testSelect = false
        this.getBugsAll()
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    handleProvinceChange (value) {
      this.closeForm.product_id = undefined
      getProducts(value).then(res => {
        this.products = res.data.products
      })
    },
    serchFocus (e) {
      if (e) {
        demandList({ keyword: e }).then(res => {
          this.demand = res.data
        })
      }
    },
    onChange (e) {
      if (e) {
        this.closeForm.source_project_name = e
      } else {
        this.closeForm.source_project_name = undefined
      }
    },
    blurDate (e, record) {
      if (!e) {
        record.dateSelect = false
      }
    },
    changeDate (e, record) {
      let params = {}
      if (e) {
        params = { expiration_date: e.format('YYYY-MM-DD') }
      }
      expirationDate(record.id, params).then(res => {
        this.$message.success('修改成功')
        record.dateSelect = false
        this.getBugsAll()
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    edit (index, record) {
      if (index === 1) {
        if (record.policies.expirationDate) {
          record.dateSelect = true
        }
      } else if (index === 2) {
        if (record.policies.programPrincipal) {
          record.devSelect = true
          this.options_2 = record.program_principal_id ? [{ id: record.program_principal_id, name: record.program_principal_name }] : []
        }
      } else if (index === 3) {
        if (record.policies.productPrincipal) {
          record.productSelect = true
          this.options_2 = record.product_principal_id ? [{ id: record.product_principal_id, name: record.product_principal_name }] : []
        }
      } else if (index === 4) {
        if (record.policies.testPrincipal) {
          record.testSelect = true
          this.options_2 = record.test_principal_id ? [{ id: record.test_principal_id, name: record.test_principal_name }] : []
        }
      }
    },
    reset (index) {
      if (index === 0) {
        this.searchData.examine_status = undefined
      } else if (index === 1) {
        this.searchData.dept = undefined
      } else if (index === 2) {
        this.searchData.operation_platform = undefined
      } else if (index === 3) {
        this.program_principalArr = []
        this.program_principalID = undefined
        this.$refs.program_principalRef.value = undefined
        this.searchData.program_principal = undefined
      } else if (index === 4) {
        this.handlerArr = []
        this.handlerID = undefined
        this.$refs.handlerRef.value = undefined
        this.searchData.handler = undefined
      } else if (index === 5) {
        this.product_principalArr = []
        this.product_principalID = undefined
        this.$refs.product_principalRef.value = undefined
        this.searchData.product_principal = undefined
      } else if (index === 6) {
        this.test_principalArr = []
        this.test_principalID = undefined
        this.$refs.test_principalRef.value = undefined
        this.searchData.test_principal = undefined
      } else if (index === 7) {
        this.searchData.created_at = undefined
      } else if (index === 8) {
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
        this.getBugsAll()
      }
    },
    // 提交前过滤空数据和undefined
    removeProperty (object) {
      for (let key in object) {
        if (object[key] === '') {
          object[key] = undefined
        }
      }
    },
    caozuo (index, e) {
      if (index === 1) {
        this.$router.push({ name: 'releaseBug', query: { id: e.id } })
      } else if (index === 2) {
        this.dialogVisible1 = true
        this.bugId = e.id
      } else if (index === 3) {
        this.$router.push({ name: 'postclaim', query: { bugId: e.id } })
      } else if (index === 4) {
        this.dialogVisible10 = true
        this.bugId = e.id
      } else if (index === 5) {
        this.dialogVisible2 = true
        this.bugId = e.id
      } else if (index === 6) {
        this.approvalType = 1
        this.dialogVisible3 = true
        this.bugId = e.id
        if (e.status === 10) {
          this.approvalForm = {
            result: 1,
            required_internal_control: 1,
            comment: e.financial_approval_comment
          }
        } else {
          this.approvalForm = {
            result: undefined,
            required_internal_control: undefined,
            comment: undefined
          }
        }
      } else if (index === 7) {
        this.approvalType = 2
        this.dialogVisible3 = true
        this.bugId = e.id
        this.approvalForm = {
          result: undefined,
          required_internal_control: undefined,
          comment: undefined
        }
      } else if (index === 8) {
        startBug(e.id).then(res => {
          this.$message.success('开始处理bug')
          this.getBugsAll()
          this.showBugDetail(this.bugId)
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else if (index === 9) {
        // 提交数据回显
        this.dialogVisible4 = true
        this.bugId = e.id
        this.submitType = 0
        if (e.resolve_status) {
          this.submitForm.resolve_status = e.resolve_status
        } else {
          this.submitForm.resolve_status = undefined
        }
        if (e.solution) {
          this.submitForm.solution = e.solution
        } else {
          this.submitForm.solution = undefined
        }
        if (e.reason_id) {
          this.submitForm.reason_id = e.reason_id
        } else {
          this.submitForm.reason_id = undefined
        }
        if (e.reason_analyse) {
          this.submitForm.reason_analyse = e.reason_analyse
        } else {
          this.submitForm.reason_analyse = undefined
        }
        if (e.data_restore) {
          this.submitForm.data_restore = e.data_restore
        } else {
          this.submitForm.data_restore = undefined
        }
        if (e.data_restore_comment) {
          this.submitForm.data_restore_comment = e.data_restore_comment
        } else {
          this.submitForm.data_restore_comment = undefined
        }
        if (e.inquiry_progress) {
          this.submitForm.inquiry_progress = e.inquiry_progress
        } else {
          this.submitForm.inquiry_progress = undefined
        }
      } else if (index === 10) {
        this.dialogVisible5 = true
        this.bugId = e.id
      } else if (index === 11) {
        this.dialogVisible6 = true
        this.bugId = e.id
        this.reviewForm.resolve_status = e.resolve_status
        this.reviewForm.solution = e.solution
        this.reviewForm.reason_id = e.reason_id
        if (e.reason_analyse) {
          this.reviewForm.reason_analyse = e.reason_analyse
        } else {
          this.reviewForm.reason_analyse = undefined
        }
        this.reviewForm.data_restore = e.data_restore
        if (e.data_restore_comment) {
          this.reviewForm.data_restore_comment = e.data_restore_comment
        } else {
          this.reviewForm.data_restore_comment = undefined
        }
      } else if (index === 12) {
        this.dialogVisible7 = true
        this.bugId = e.id
        this.acceptType = 1
      } else if (index === 13) {
        this.dialogVisible7 = true
        this.bugId = e.id
        this.acceptType = 2
      } else if (index === 14) {
        this.dialogVisible7 = true
        this.bugId = e.id
        this.acceptType = 3
      } else if (index === 15) {
        this.$router.push({ name: 'releaseDemand', query: { bugId: e.id } })
      } else if (index === 16) {
        this.dialogVisible8 = true
        this.bugId = e.id
        this.closeType = 1
        if (e.source_project_id) {
          this.$nextTick(() => {
            this.$refs.source_project.projectsData.projectList = [{ id: e.source_project_id, name: e.source_project_name }]
          })
          this.closeForm.source_project_id = e.source_project_id
          this.closeForm.source_project_name = e.source_project_name
        }
        if (e.source_demand_id) {
          this.closeForm.source_demand = { key: e.source_demand_id, label: e.source_demand_name }
        } else {
          this.closeForm.source_demand = undefined
        }
        if (e.product_category.product_line) {
          this.closeForm.product_line = e.product_category.product_line.id
          getProducts(e.product_category.product_line.id).then(res => {
            this.products = res.data.products
            this.closeForm.product_id = e.product_category.product.id
          })
        }
      } else if (index === 17) {
        this.dialogVisible8 = true
        this.bugId = e.id
        this.closeType = 2
        if (e.source_project_id) {
          this.$nextTick(() => {
            this.$refs.source_project.projectsData.projectList = [{ id: e.source_project_id, name: e.source_project_name }]
          })
          this.closeForm.source_project_id = e.source_project_id
          this.closeForm.source_project_name = e.source_project_name
        }
        if (e.source_demand_id) {
          this.closeForm.source_demand = { key: e.source_demand_id, label: e.source_demand_name }
        } else {
          this.closeForm.source_demand = undefined
        }
        if (e.product_category.product_line) {
          this.closeForm.product_line = e.product_category.product_line.id
          getProducts(e.product_category.product_line.id).then(res => {
            this.products = res.data.products
            this.closeForm.product_id = e.product_category.product.id
          })
        }
      } else if (index === 18) {
        if (e.policies.follow) {
          this.dialogVisible9 = true
          this.$nextTick(() => {
            var day = ''
            if (e.expiration_date) {
              day = moment(e.expiration_date)
            } else {
              day = undefined
            }
            this.followForm.expiration_date = day

            if (e.comment) {
              this.followForm.comment = e.comment
            }
            if (e.handlers.length) {
              this.followForm.follower_id = e.handlers[0].handler_id
              this.followerArr = e.handlers[0].handler_id ? [{ name: e.handlers[0].handler_name, id: e.handlers[0].handler_id }] : []
              this.followerID = e.handlers[0].handler_id ? e.handlers[0].handler_id : undefined
            } else {
              this.followForm.follower_id = undefined
              this.followerArr = []
              this.followerID = undefined
            }
          })
          this.bugId = e.id
        }
      } else if (index === 19) {
        this.dialogVisible4 = true
        this.bugId = e.id
        this.submitType = 1
        if (e.resolve_status) {
          this.submitForm.resolve_status = e.resolve_status
        } else {
          this.submitForm.resolve_status = undefined
        }
        if (e.solution) {
          this.submitForm.solution = e.solution
        } else {
          this.submitForm.solution = undefined
        }
        if (e.reason_id) {
          this.submitForm.reason_id = e.reason_id
        } else {
          this.submitForm.reason_id = undefined
        }
        if (e.reason_analyse) {
          this.submitForm.reason_analyse = e.reason_analyse
        } else {
          this.submitForm.reason_analyse = undefined
        }
        if (e.data_restore) {
          this.submitForm.data_restore = e.data_restore
        } else {
          this.submitForm.data_restore = undefined
        }
        if (e.data_restore_comment) {
          this.submitForm.data_restore_comment = e.data_restore_comment
        } else {
          this.submitForm.data_restore_comment = undefined
        }
        if (e.inquiry_progress) {
          this.submitForm.inquiry_progress = e.inquiry_progress
        } else {
          this.submitForm.inquiry_progress = undefined
        }
      }
    },
    cancel (index) {
      if (index === 1) {
        this.dialogVisible1 = false
        this.comment = undefined
      } else if (index === 2) {
        this.dialogVisible2 = false
        this.comment = undefined
      } else if (index === 3) {
        this.dialogVisible3 = false
        this.$refs.approvalForm.resetFields()
      } else if (index === 4) {
        this.dialogVisible4 = false
        this.$refs.submitForm.resetFields()
      } else if (index === 5) {
        this.dialogVisible5 = false
        this.comment = undefined
      } else if (index === 6) {
        this.dialogVisible6 = false
        this.$refs.reviewForm.resetFields()
      } else if (index === 7) {
        this.$refs.acceptForm.resetFields()
        this.acceptForm.media = [{ name: '', file: null }]
        this.dialogVisible7 = false
      } else if (index === 8) {
        this.$refs.closeForm.resetFields()
        this.products = []
      } else if (index === 9) {
        this.$refs.followForm.resetFields()
        this.followerID = undefined
        this.followerArr = []
        this.$refs.followerRef.value = undefined
        this.dialogVisible9 = false
      } else if (index === 10) {
        this.dialogVisible10 = false
      }
    },
    ok (index) {
      if (index === 1) {
        this.$refs.revokeForm.validate(valid => {
          if (valid) {
            let params = { comment: this.comment }
            this.btnLoad = true
            revocationBug(this.bugId, params).then(res => {
              if (res.code === 200) {
                this.$message.success('撤销成功')
                this.dialogVisible1 = false
                this.comment = undefined
                this.getBugsAll()
                this.showBugDetail(this.bugId)
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
      } else if (index === 2) {
        this.$refs.ruleForm.validate(valid => {
          if (valid) {
            let params = { comment: this.comment }
            this.btnLoad = true
            revocationApply(this.bugId, params).then(res => {
              if (res.code === 200) {
                this.$message.success('撤销审批申请成功')
                this.dialogVisible2 = false
                this.comment = undefined
                this.getBugsAll()
                this.showBugDetail(this.bugId)
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
      } else if (index === 3) {
        this.$refs.approvalForm.validate(valid => {
          if (valid) {
            if (this.approvalType === 1) {
              if (this.approvalForm.result === 0) {
                this.approvalForm.required_internal_control = undefined
              }
              this.btnLoad = true
              financeExamine(this.bugId, this.approvalForm).then(res => {
                if (res.code === 200) {
                  this.$message.success('审批成功')
                  this.dialogVisible3 = false
                  this.$refs.approvalForm.resetFields()
                  this.getBugsAll()
                  this.showBugDetail(this.bugId)
                  this.btnLoad = false
                }
              }).catch(error => {
                this.btnLoad = false
                this.$message.error(error.response ? error.response.data.message : error.message)
              })
            } else {
              let params = { comment: this.approvalForm.comment, result: this.approvalForm.result }
              this.btnLoad = true
              internalControlExamine(this.bugId, params).then(res => {
                if (res.code === 200) {
                  this.$message.success('审批成功')
                  this.dialogVisible3 = false
                  this.$refs.approvalForm.resetFields()
                  this.getBugsAll()
                  this.showBugDetail(this.bugId)
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
      } else if (index === 4) {
        this.$refs.submitForm.validate(valid => {
          if (valid) {
            this.btnLoad = true
            this.removeProperty(this.submitForm)
            if (this.submitType) {
              updateSubmitResult(this.bugId, this.submitForm).then(res => {
                if (res.code === 200) {
                  this.$message.success('更改成功')
                  this.dialogVisible4 = false
                  this.$refs.submitForm.resetFields()
                  this.getBugsAll()
                  this.showBugDetail(this.bugId)
                  this.btnLoad = false
                }
              }).catch(error => {
                this.btnLoad = false
                this.$message.error(error.response ? error.response.data.message : error.message)
              })
            } else {
              submitHandleResult(this.bugId, this.submitForm).then(res => {
                if (res.code === 200) {
                  this.$message.success('提交成功')
                  this.dialogVisible4 = false
                  this.$refs.submitForm.resetFields()
                  this.getBugsAll()
                  this.showBugDetail(this.bugId)
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
      } else if (index === 5) {
        let params = { comment: this.comment }
        this.btnLoad = true
        submitHandleResultCancel(this.bugId, params).then(res => {
          if (res.code === 200) {
            this.$message.success('撤销提交成功')
            this.dialogVisible5 = false
            this.comment = undefined
            this.getBugsAll()
            this.showBugDetail(this.bugId)
            this.btnLoad = false
          }
        }).catch(error => {
          this.btnLoad = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else if (index === 6) {
        this.$refs.reviewForm.validate(valid => {
          if (valid) {
            this.btnLoad = true
            reexamine(this.bugId, this.reviewForm).then(res => {
              if (res.code === 200) {
                this.$message.success('复核成功')
                this.dialogVisible6 = false
                this.$refs.reviewForm.resetFields()
                this.getBugsAll()
                this.showBugDetail(this.bugId)
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
        const formData = new FormData()
        this.acceptForm.media.map(item => {
          if (item.file) {
            formData.append('media[]', item.file)
          }
        })
        formData.append('result', this.acceptForm.result)
        if (this.acceptForm.comment) {
          formData.append('comment', this.acceptForm.comment)
        }
        if (this.acceptType === 1) {
          this.btnLoad = true
          acceptTest(this.bugId, formData).then(res => {
            this.$message.success('验收成功')
            this.dialogVisible7 = false
            this.$refs.acceptForm.resetFields()
            this.acceptForm.media = [{ name: '', file: null }]
            this.getBugsAll()
            this.showBugDetail(this.bugId)
            this.btnLoad = false
          }).catch(error => {
            this.btnLoad = false
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        } else if (this.acceptType === 2) {
          this.btnLoad = true
          acceptPromulgator(this.bugId, formData).then(res => {
            this.$message.success('验收成功')
            this.dialogVisible7 = false
            this.$refs.acceptForm.resetFields()
            this.acceptForm.media = [{ name: '', file: null }]
            this.getBugsAll()
            this.showBugDetail(this.bugId)
            this.btnLoad = false
          }).catch(error => {
            this.btnLoad = false
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        } else if (this.acceptType === 3) {
          this.btnLoad = true
          acceptProduct(this.bugId, formData).then(res => {
            this.$message.success('验收成功')
            this.dialogVisible7 = false
            this.$refs.acceptForm.resetFields()
            this.acceptForm.media = [{ name: '', file: null }]
            this.getBugsAll()
            this.showBugDetail(this.bugId)
            this.btnLoad = false
          }).catch(error => {
            this.btnLoad = false
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        }
      } else if (index === 8) {
        if (this.closeForm.source_demand) {
          this.closeForm.source_demand_id = this.closeForm.source_demand.key
          this.closeForm.source_demand_name = this.closeForm.source_demand.label
          delete this.closeForm.source_demand
        }
        if (this.closeType === 1) {
          this.btnLoad = true
          closeBug(this.bugId, this.closeForm).then(res => {
            if (res.code === 200) {
              this.$message.success('关闭Bug成功')
              this.dialogVisible8 = false
              this.$refs.closeForm.resetFields()
              this.products = []
              this.getBugsAll()
              this.showBugDetail(this.bugId)
              this.btnLoad = false
            }
          }).catch(error => {
            this.btnLoad = false
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        } else {
          //   let params = this.closeForm
          //   if (JSON.stringify(this.closeForm) === '{}') {
          //     params = undefined
          //   }
          this.btnLoad = true
          appendInfo(this.bugId, this.closeForm).then(res => {
            if (res.code === 200) {
              this.$message.success('补充信息成功')
              this.dialogVisible8 = false
              this.$refs.closeForm.resetFields()
              this.products = []
              this.getBugsAll()
              this.showBugDetail(this.bugId)
              this.btnLoad = false
            }
          }).catch(error => {
            this.btnLoad = false
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        }
      } else if (index === 9) {
        this.$refs.followForm.validate(valid => {
          if (valid) {
            let params = JSON.parse(JSON.stringify(this.followForm))
            params.expiration_date = this.followForm.expiration_date.format('YYYY/MM/DD')
            params.follower_ids = [this.followForm.follower_id]
            this.btnLoad = true
            setFollow(this.bugId, params).then(res => {
              if (res.code === 200) {
                this.$message.success('分配成功')
                this.dialogVisible9 = false
                this.followerArr = []
                this.followerID = undefined
                this.$refs.followerRef.value = undefined
                this.$refs.followForm.resetFields()
                this.getBugsAll()
                this.showBugDetail(this.bugId)
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
      } else if (index === 10) {
        this.btnLoad = true
        applyBug(this.bugId).then(res => {
          this.$message.success('申请审批成功')
          this.getBugsAll()
          this.dialogVisible10 = false
          this.showBugDetail(this.bugId)
          this.btnLoad = false
        }).catch(error => {
          this.btnLoad = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      }
    },
    toSetting () {
      this.$router.push({ name: 'bugSetting' })
    },
    getBugsAll (params) {
      if (!params) {
        params = {
          limit: this.pagination1.pageSize || 10,
          page: this.pagination1.current,
          filters: search
        }
      }
      getBugs(params).then(res => {
        this.remind = res.data.remind
        this.data = res.data.data.map(item => {
          return { ...item, dateSelect: false, productSelect: false, devSelect: false, testSelect: false }
        })
        this.data.forEach(item => {
          let arr = [item.policies.start ? '开始' : '', item.policies.reexamine ? '复核' : '', item.policies.submitHandleResult ? '提交处理结果' : '', item.policies.submitHandleResultCancel ? '撤销提交' : '',
            item.policies.updateHandleResult ? '更改提交信息' : '', item.policies.financeExamine ? '财务审批' : '', item.policies.internalControlExamine ? '内控审批' : '', item.policies.applyExamine ? '申请审批' : '', item.policies.applyExamineCancel ? '撤销审批申请' : '',
            item.policies.acceptPromulgator ? '提bug人验收' : '', item.policies.acceptProduct ? '产品验收' : '',
            item.policies.appendInfo ? '补充信息' : '', item.policies.acceptTest ? '测试验收' : '', item.policies.close ? '关闭bug' : '', item.policies.publishDemand ? '发布需求' : '', (item.appeals.length || item.demands.length) ? '诉求/需求信息' : '',
            item.policies.publishAppeal ? '发布诉求' : '', item.policies.update ? '编辑' : '', item.policies.revocation ? '撤销' : ''
          ].filter(Boolean)
          if (arr.length > 2) {
            item.operation = arr.slice(0, 3)
            item.operation2 = arr.splice(3)
          } else {
            item.operation = arr
          }
        })
        this.pagination1.total = res.data.total
        this.pagination1.current = res.data.current_page
        this.pagination1.pageSize = res.data.per_page
        this.loading = false
      }).catch(error => {
        this.loading = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    onSearch (value) {
      if (value) {
        search['keyword'] = '%' + value.trim() + '%'
      } else {
        search['keyword'] = undefined
      }
      this.loading = true
      let params = {
        limit: this.pagination1.pageSize || 10,
        page: this.pagination1.current,
        filters: search
      }
      this.getBugsAll(params)
    },
    changePage (e) {
      this.loading = true
      let params = { filters: search, may, must, page: e.current, limit: e.pageSize }
      this.getBugsAll(params)
    },
    onSelectChange (selectedRowKeys) {
      this.selectedRowKeys = selectedRowKeys
    },
    releaseBug () {
      this.$router.push({ name: 'releaseBug' })
    },
    addFileInputList () {
      const object = {
        name: '',
        file: null
      }
      this.acceptForm.media.push(object)
    },
    beforeUpload (file, index) {
      const size = file.size / (1024 * 1024)
      const name = file.name.substring(file.name.lastIndexOf('.'))
      if (size > allowSize) {
        this.$message.error('上传文件不得超过' + allowSize + 'm')
      } else if (allow.indexOf(name) === -1) {
        this.$message.error('上传文件格式不正确')
      } else {
        this.acceptForm.media[index].file = file
        this.acceptForm.media[index].name = file.name
      }
      return false
    },
    removeFileInputList (index) {
      this.acceptForm.media.splice(index, 1)
    }

  }
}
</script>
<style lang="less" scoped>

.image{
     display: none;
}
.contxt {
  padding: 30px 0;
  font-size: 16px;
  text-align: center;
  line-height: 1;
}
.flow-chart{
    position: absolute;
    top: -32px;
    right: 20px;
    color: rgba(55, 141, 239, .5);
    &:hover{
        color:rgba(55, 141, 239, 1);
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
  .btn-right {
    position: absolute;
    right: 20px;
    top: 30px;
    display: flex;
    display: flex;
    align-items: center;
    height: 32px;
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
}

.table-list /deep/.ant-table td { white-space: nowrap}

.table-list /deep/.ant-table-body {
    overflow-x:auto !important;
}
.table-eidt /deep/ .ant-table-body {
  margin: 10px 0px 0px 0px;
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
}
.table-eidt /deep/.ant-table-placeholder {
  display: none;
}
.table-list /deep/.ant-table-pagination {
  display: none;
}
    /deep/.ant-dropdown-menu-item a {
            padding-left:20px !important;
            span{
                margin-right:10px;
            }
    }
.ok{
      text-align: right;
      padding: 20px 10px;
      width: 280px;
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

        }
    .content{
        .top .dept{
            font-size:14px;
            font-family:Microsoft YaHei;
            font-weight:bold;
            color:rgba(51,51,51,1);
        }
        .con{
          padding-top: 40px;
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
              min-width: 54px;
              display: inline-block;
          }
          .right{
              display: inline-block;
          }
        }
    }
    .line{
        display: inline-block;
        position: relative;
        top: 4px;
        height: 18px;
        width: 1px;
        background: rgba(238, 238, 238, 1);
        margin: 0 10px;
    }
    .addFile{
        color:#378EEF;
        font-size:12px;
        width: 40px;
        position: absolute;
        top: -23px;
        left: 302px;
    }
    /deep/.eidt-expend{
       line-height: 40px;
    }
    /deep/.ant-popover-inner-content{
        padding: 10px;
    }
     /deep/.ant-row::before,  /deep/.ant-row::after{
            display: inline ;
    }
    .pro_operate {
        display: flex;
        .icon {
            color: #378eef;
            font-size: 12px;
            margin-right: 10px;
            cursor: pointer;
        }
        span {
            display: inline-block;
            margin-right: 4px;
        }
    }

    .is_urgent{
        display: inline-block;
        width:32px;
        height:18px;
        text-align: center;
        line-height: 18px;
        background:rgba(255,74,74,.2);
        border-radius:2px;
        color: #FF4A4A;
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
    .download-list > p {
    color: #666;
    font-size: 12px;
    margin-bottom: 10px;
    }

    .left-line{
        position: absolute;
        left: -65px;
        top: -32px;
        width:5px;
        height:94px;
        background:rgba(255,217,127,1);
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
    }
    .tabslist{
        background: #fff;
        background-image:url('../../../assets/images/bug-logo.png') ;
        background-repeat: no-repeat;
        background-position: right bottom;

    }

    .table-list /deep/.ant-table-placeholder {
            margin-top: 9px;
    }
     .table-list {

        /deep/.ant-table table{
         border-spacing: 0 10px;
         .ant-checkbox-checked .ant-checkbox-inner::after{
             transform: rotate(45deg) scaleY(.45) translate(-50%, -50%);
             top: 1px;
         }
         .ant-checkbox-indeterminate .ant-checkbox-inner::after{
             transform: translate(-50%, -50%) scaleY(.42);
         }
        }
        /deep/.ant-table-thead > tr > th{
           div{
                display: flex;
                // height: 22px !important;
            }
             .ant-table-column-sorter-inner-full{
                  display: block;
                  padding-top: 6px;
            }
        }
        /deep/.ant-table-body tr{
            background: #fff;
            box-shadow:0px 5px 15px 0px rgba(223,226,230,0.8);
            border-radius:5px;
            th:first-child,td:first-child {/*设置table左边边框*/
                border-left: 0.5px  ;
                border-top-left-radius: 5px;
                border-bottom-left-radius: 5px;
                width: 65px;
            }
            th:last-child,td:last-child {/*设置table右边边框*/
                border-right: 0.5px ;
                border-top-right-radius: 5px;
                border-bottom-right-radius: 5px;
            }
            th,td{/*设置table上下边框*/
                border-top: 0.5px ;
                border-bottom: 0.5px ;
            }
            & td:last-child{
                background-image:url('../../../assets/images/bug-logo.png') ;
                background-repeat: no-repeat;
                background-position: right bottom;
            }

        }
     }
     .table-eidt /deep/ .ant-table-thead .ant-table-selection-column {
        display: block;
        text-align: left;
        padding-left: 20px;
    }
    .table-list /deep/ .ant-table-thead .ant-table-selection-column {
        text-align: left;
        padding-left: 20px ;
    }

    .table-list /deep/.ant-table-tbody > tr > td.ant-table-selection-column {
        text-align: left;
        padding-left: 20px !important;
    }
</style>
