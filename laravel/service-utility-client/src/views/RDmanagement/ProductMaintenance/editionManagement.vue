<template>
    <div style="overflow-x: auto;">
        <!-- 添加/编辑发版产品 -->
        <addPublishingModal></addPublishingModal>
        <!-- 开启/关闭弹框 -->
        <switchModal></switchModal>
        <!-- 删除弹框 -->
        <deleteModal></deleteModal>
        <!-- 确认版本信息 -->
        <confirmModal></confirmModal>
        <!-- 更改版本 -->
        <editVersionFeature></editVersionFeature>
        <!-- 制定版本计划 -->
        <addVersionPlan :info="details" :list="versionList"></addVersionPlan>
        <!-- 操作记录 -->
        <logsModal :data="logsData"></logsModal>

        <!-- 检验结果弹框 -->
        <checkResultsModal></checkResultsModal>

        <!-- 发布测试/上线弹框/发布功能点测试 -->
        <releaseModal :releaseType="releaseType"></releaseModal>

        <!-- 研发进度 -->
        <allTaskInfo ref="allTaskInfo" :id="demand_id" title="研发进度"></allTaskInfo>

        <!-- ------------ -->
        <div class="content">
            <div class="marginR30 left-box">
                <div class="p-part marginB30 t-box">
                    <h1>Hi , {{userName}} !</h1>
                    <h3>欢迎来到发版管理页面~ </h3>
                    <div class="dashboard">
                        <a-progress strokeColor="#4D66FF" :width="200" :gapDegree="120"  :strokeWidth="7" type="dashboard" :percent="statisticsPercent" >
                            <template slot="format" >
                                <!-- v-slot:format="percent" -->
                                <img src="../../../assets/images/publishing.png">
                                <div class="num">{{statisticsNum}}</div>
                                <p style="color: #bbb;font-size:12px;">发版产品总量(个)</p>
                            </template>
                        </a-progress>
                    </div>

                </div>
                <div class="p-part b-box">
                   <p class="title">
                       待确认
                       <a-badge :count="confirmCount" />
                   </p>
                   <div class="version">
                       <p v-for="item in confirmList" :key="item.id">
                           <span class="iconfont fz12">&#xe70d;</span>{{item.name}}
                           (<span v-for="(item2,index2) in item.versions" :key="index2">
                               <a @click="toConfirm(item2)" >{{item2.full_version}}</a>
                               <span v-if="index2 !== item.versions.length-1">、</span>
                            </span> )
                        </p>
                        <a-empty description="暂无待确认" :image="simpleImage" v-if="confirmList.length===0"/>
                   </div>
                </div>
            </div>
            <div class="p-part  marginR30" style="padding-top:0;flex:1;height:580px;">
                <p class="title">管理发版产品
                    <i class="line"></i>
                    <a-select
                      placeholder="管理员"
                      allowClear
                      v-model="searchData2.admin_id"
                      :getPopupContainer="triggerNode => triggerNode.parentNode"
                      style="width: 120px;margin-right:10px"
                      >
                        <a-select-option v-for="item in admins" :key="item.user_id" :value="item.user_id">
                            {{ item.user_name }}
                        </a-select-option>
                    </a-select>
                    <a-select
                      placeholder="状态"
                      allowClear
                       v-model="searchData2.is_open"
                      :getPopupContainer="triggerNode => triggerNode.parentNode"
                      style="width: 120px"
                      >
                        <a-select-option :value="0"> 关闭</a-select-option>
                        <a-select-option :value="1"> 开启</a-select-option>
                    </a-select>
                    <a @click="showPublishingModal" v-if="canDo('pm.releaseProducts.store')"><span class="iconfont fz12">&#xe658;</span> 添加发版产品</a>
                </p>
                <div style="display:flex">
                    <div class="left">
                        <div class="p-name" :class="{active:activeIndex===index}" @click="showMsg(1,index,item)" v-for="(item,index) in productsList" :key="index">
                            <i class="active-l" v-show="activeIndex===index"></i>
                            <span class="p-ellipsis" :title="item.name" style="width:180px;display: inline-block;">{{item.name}}</span>
                            <div class="eidtDropdown" @click.stop="e => e.preventDefault()">
                                <a-dropdown :trigger="['click']" :getPopupContainer="triggerNode => triggerNode.parentNode">
                                    <a class="ant-dropdown-link">
                                        <span
                                        title="操作"
                                        v-if="canDo('pm.releaseProducts.update')|| canDo('pm.releaseProducts.status') || canDo('pm.releaseProducts.delete')"
                                        class="fz12 iconfont">&#xe634;</span>
                                    </a>
                                    <a-menu slot="overlay" style="padding: 5px 0px;width:120px;" class="edit-icon">
                                        <a-menu-item v-if="canDo('pm.releaseProducts.update')">
                                            <a  @click.stop="operation(1,item)"><span class="iconfont fz12 marginR10">&#xe637;</span>编辑</a>
                                        </a-menu-item>
                                        <a-menu-item v-if="canDo('pm.releaseProducts.status')">
                                            <a  @click.stop="operation(2,item)"><span class="iconfont fz12 marginR10">&#xe6f8;</span>开启/关闭</a>
                                        </a-menu-item>
                                        <a-menu-item v-if="canDo('pm.releaseProducts.delete')">
                                            <a  @click.stop="operation(3,item)"><span class="iconfont fz12 marginR10">&#xe64d;</span>删除</a>
                                        </a-menu-item>
                                    </a-menu>
                                </a-dropdown>
                            </div>
                        </div>
                    </div>
                    <div class="right">
                        <p class="title fz14"> 产品详情 </p>
                        <div class="details">
                            <div class="marginB20">
                                <span class="left-details">发版产品名称:</span>
                                <span class="right-details">{{details.name}}</span>
                            </div>
                            <div class="marginB20">
                                <span class="left-details">状态:</span>
                                <span class="right-details cup" @click="showLogs(1,details)" :style="{color: details.status ? '#3dcca6' : '#ff4a4a'}">{{details.status_desc}}</span>
                            </div>
                            <div class="marginB20">
                                <span class="left-details">管理员:</span>
                                <span class="right-details">
                                    <span v-for="(k,index) in details.admins" :key="index">
                                        {{k.user_name}}
                                        <span v-if="index !== details.admins.length-1">;</span>
                                    </span>
                                </span>
                            </div>
                            <div class="marginB20">
                                <span class="left-details">发版周期:</span>
                                <span class="right-details">{{details.release_cycle}}</span>
                            </div>
                            <div class="marginB20">
                                <span class="left-details">关联产品(线):</span>
                                <span class="right-details">
                                    <span v-for="(k,index) in details.friendly_products" :key="index">
                                        {{k.name}}
                                        <span v-if="index !== details.friendly_products.length-1">;</span>
                                    </span>
                                </span>
                            </div>
                            <div class="marginB20">
                                <span class="left-details">正式站地址:</span>
                                <span class="right-details">
                                    <a
                                     style="display: block;"
                                     :style="{'padding-bottom': index !== details.online_address.length-1 ?  '10px' : '0px'}"
                                     v-for="(link,index) in details.online_address"
                                     :key="index"
                                     :href="link"
                                     target="_blank">{{link}}</a>
                                     <span v-if="details.online_address &&  details.online_address.length===0"> -- </span>
                                 </span>
                            </div>
                            <div class="marginB20">
                                <span class="left-details">测试站地址:</span>
                                <span class="right-details">
                                    <a
                                     style="display: block;"
                                     :style="{'padding-bottom': index !== details.online_address.length-1 ?  '10px' : '0px'}"
                                     v-for="(link,index) in details.testing_address"
                                     :key="index"
                                     :href="link"
                                     target="_blank">{{link}}</a>
                                    <span v-if="details.testing_address && details.testing_address.length===0"> -- </span>
                                </span>
                            </div>
                            <div class="marginB20">
                                <span class="left-details">简介:</span>
                                <span class="right-details">{{details.description ? details.description : '--'}}</span>

                            </div>
                            <div class="marginB20">
                                <span class="left-details">创建人:</span>
                                <span class="right-details">{{details.creator_name}} {{details.created_at}}</span>
                            </div>
                            <div class="marginB20" style="margin-bottom:0">
                                <span class="left-details">更新人:</span>
                                <span class="right-details">{{details.updater_name}} {{details.updated_at}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-part" style="padding-top:0;flex:1;height:580px;">
                <p class="title">版本号记录<a @click="addVersionPlan" v-if="details.policies.addVersions"><span class="iconfont fz12">&#xe70b;</span> 制定版本计划</a></p>
                <a-dropdown :trigger="['click']" placement="bottomCenter">
                            <a class="year" @click="e => e.preventDefault()"> {{versionYear}} <a-icon type="caret-down" /> </a>
                            <a-menu slot="overlay" style="width:200px">
                                <a-menu-item v-for="y in yearList" :key="y" @click="changeYear(y)">
                                    {{y}}
                                </a-menu-item>
                            </a-menu>
                </a-dropdown>
                <div style="display:flex" v-if="versionList.length">
                    <div class="left scroll-bar">
                        <div class="p-name" style="padding-left:15px;width: 259px;margin-bottom:12px" :class="{active:activeIndex2===index,'to-tested': item.status===1,testing:item.status===2}"  @click="showMsg(2,index,item)" v-for="(item,index) in versionList" :key="index">
                            <i class="active-l" v-show="activeIndex2===index"></i>
                            <span style="width:120px;display:inline-block;"  class="tar">
                                <span style="color:#555" v-if="item.status===1" :class="{active:activeIndex2===index}">待发布测试</span>
                                <span style="color:#FEBC2E;font-weight: bold;" v-else-if="item.status===2" :class="{active:activeIndex2===index}">版本测试中</span>
                                <span style="color:#bbb" v-else :class="{active:activeIndex2===index}">{{item.release_online_time}}</span>
                            </span>
                            <span class="icon-node">
                                <span class="icon-line"></span>
                            </span>
                            <span class="version-num" :style="{ color: item.status===3 ? '#bbb' : ''}" :class="{active:activeIndex2===index}">{{item.full_version}}</span>
                            <div class="eidtDropdown"  @click.stop="e => e.preventDefault()">
                                <a-dropdown placement="bottomCenter" :trigger="['click']" :getPopupContainer="triggerNode => triggerNode.parentNode">
                                    <a class="ant-dropdown-link" href="#">
                                        <span  title="操作" v-if="item.policies.update || item.policies.delete" class="fz12 iconfont">&#xe634;</span>
                                    </a>
                                    <a-menu slot="overlay" style="padding: 5px 0px;width:120px;" class="edit-icon">
                                        <a-menu-item v-if="item.policies.update">
                                            <a   @click.stop="operation(4,item)"><span class="iconfont fz12 marginR10">&#xe637;</span>编辑</a>
                                        </a-menu-item>
                                        <a-menu-item v-if="item.policies.delete">
                                            <a  @click.stop="operation(5,item)"><span class="iconfont fz12 marginR10">&#xe64d;</span>删除</a>
                                        </a-menu-item>
                                    </a-menu>
                                </a-dropdown>
                            </div>
                        </div>
                    </div>
                    <div class="right" style="margin-top: -25px;">
                        <p class="title fz14"> 版本详情 </p>
                        <div class="details version-details">
                            <div class="marginB20">
                                <span class="left-details">版本号:</span>
                                <span class="right-details">{{versionDetails.full_version}}</span>
                            </div>
                            <div class="marginB20">
                                <span class="left-details">状态:</span>
                                <span class="right-details cup" @click="showLogs(2,versionDetails)" :style="{color:versionDetails.status ===2 ? '#FEBC2E': '#666'}">{{versionDetails.status_desc}}</span>
                            </div>
                            <div class="marginB20">
                                <span class="left-details">创建人:</span>
                                <span class="right-details">{{versionDetails.creator_name}}</span>
                            </div>
                            <div class="marginB20">
                                <span class="left-details">预计发布测试时间:</span>
                                <span class="right-details">{{versionDetails.expected_release_test_time}}（{{getWeek(versionDetails.expected_release_test_time)}}）</span>
                            </div>
                             <div class="marginB20">
                                <span class="left-details">实际发布测试:</span>
                                <span class="right-details">
                                    <span v-if="versionDetails.release_test_time">
                                        {{versionDetails.release_test_time}}（{{getWeek(versionDetails.release_test_time)}}）
                                        <p>{{versionDetails.release_test_comment}}</p>
                                    </span>
                                    <span v-else> -- </span>
                                </span>
                            </div>
                            <div class="marginB20">
                                <span class="left-details">预计发布上线时间:</span>
                                <span class="right-details">{{versionDetails.expected_release_online_time}}（{{getWeek(versionDetails.expected_release_online_time)}}）</span>
                            </div>
                            <div class="marginB20">
                                <span class="left-details">实际发布上线:</span>
                                <span class="right-details">
                                    <span v-if="versionDetails.release_online_time">
                                        {{versionDetails.release_online_time}}（{{getWeek(versionDetails.release_online_time)}}）
                                        <p>{{versionDetails.release_online_comment}}</p>
                                    </span>
                                     <span v-else> -- </span>
                                </span>
                            </div>
                            <div class="marginB20" style="margin-bottom:0">
                                <span class="left-details">功能统计:</span>
                                <span class="right-details">共{{versionDetails.feature_count}}个</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="version-empty-data" v-else>
                    <a-empty  :image="simpleImage" />
                </div>

            </div>
        </div>
        <div class="p-part" style="padding-top:0;min-width: 1510px;">
             <div class="title"> 功能清单
                 <i class="line"></i>
                    <a-select
                      allowClear
                      showSearch
                      option-filter-prop="children"
                      v-model="searchData.handler_id"
                      :getPopupContainer="triggerNode => triggerNode.parentNode"
                      placeholder="任务处理人(请输入英文名搜索)"
                      title="任务处理人(请输入英文名搜索)"
                      @search="search($event, 1)"
                      style="width: 120px;margin-right:10px"
                      >
                        <a-select-option v-for="item in options_1" :key="item.id" :value="item.id">
                            {{ item.name }}
                        </a-select-option>
                    </a-select>
                    <a-select
                      allowClear
                      showSearch
                      option-filter-prop="children"
                      v-model="searchData.promulgator_id"
                      :getPopupContainer="triggerNode => triggerNode.parentNode"
                      placeholder="产品发布人(请输入英文名搜索)"
                      title="产品发布人(请输入英文名搜索)"
                      @search="search($event, 2)"
                      style="width: 120px;margin-right:10px"
                      >
                        <a-select-option v-for="item in options_2" :key="item.id" :value="item.id">
                            {{ item.name }}
                        </a-select-option>
                    </a-select>
                    <a-select
                      allowClear
                       v-model="searchData.stress_test"
                      :getPopupContainer="triggerNode => triggerNode.parentNode"
                      placeholder="压测"
                      style="width: 120px;margin-right:10px"
                      >
                        <a-select-option :value="0">不需要</a-select-option>
                        <a-select-option :value="1">需要</a-select-option>
                    </a-select>
                    <a-select
                      allowClear
                      v-model="searchData.product_confirmed"
                      :getPopupContainer="triggerNode => triggerNode.parentNode"
                      placeholder="产品确认"
                      style="width: 120px;margin-right:10px"
                      >
                        <a-select-option :value="0">未确认</a-select-option>
                        <a-select-option :value="1">已确认</a-select-option>
                    </a-select>
                    <a-select
                      allowClear
                      showSearch
                      option-filter-prop="children"
                      v-model="searchData.test_handler_id"
                      :getPopupContainer="triggerNode => triggerNode.parentNode"
                      placeholder="测试人员(请输入英文名搜索)"
                      title="测试人员(请输入英文名搜索)"
                      @search="search($event, 3)"
                      style="width: 120px;margin-right:10px"
                      >
                        <a-select-option v-for="item in options_3" :key="item.id" :value="item.id">
                            {{ item.name }}
                        </a-select-option>
                    </a-select>
                    <a-select
                      allowClear
                      v-model="searchData.release_status"
                      :getPopupContainer="triggerNode => triggerNode.parentNode"
                      placeholder="发布测试状态"
                      style="width: 120px;margin-right:10px"
                      >
                        <a-select-option :value="1">未发布测试</a-select-option>
                        <a-select-option :value="2">已发布测试</a-select-option>
                    </a-select>
                    <a-input-search placeholder="请输入关键字搜索"
                        v-model="searchMsg"
                        @search="searchFeatures"
                        style="width: 232px;"
                        />
                    <a @click="releaseOnline" v-if="versionDetails.policies.releaseOnline"><span class="iconfont fz12">&#xe70a;</span> 一键发布上线</a>
                    <a @click="releaseTest" v-if="versionDetails.policies.releaseTest"><span class="iconfont fz12">&#xe70c;</span> 一键发布测试</a>
                    <a-popover trigger="click" arrowPointAtCenter placement="bottomLeft" :getPopupContainer="triggerNode => triggerNode.parentNode">
                            <div slot="content" >
                                <div style="padding:10px 10px 0">
                                    <a-radio-group name="radioGroup" v-model="excelRadio">
                                        <a-radio :value="1">
                                        功能清单
                                        </a-radio>
                                    </a-radio-group>

                                </div>
                                <div class="excel-ok" >
                                    <a-button type="primary" @click="handleExport">确定</a-button>
                                </div>
                            </div>
                           <a><span class="iconfont fz12">&#xe65a;</span> 导出</a>
                    </a-popover>
                    <a class="p-a fr" @click="refreshList"><i class="iconfont iconshuaxin fz14" style="margin-right: 3px;"></i>刷新</a>
             </div>
             <a-table
                     style="margin-top:-10px;"
                     class="feature-table"
                     :loading="loading"
                     :rowKey="(record, index) => record.number"
                     :columns="columns"
                     :dataSource="functionData"
                     :pagination="pagination"
                     @change="handleTableChange">
                     <template slot="Handler">
                       <div class="fl" style="margin-right: 5px;">任务ID/处理人</div>
                       <div class="fl sort-btn">
                        <a-icon type="caret-up" :class="{'choose': paginationParams.sort === 'handler_name'}" @click="sortList(1)" />
                        <a-icon type="caret-down" :class="{'choose': paginationParams.sort === '-handler_name'}" @click="sortList(2)" />
                       </div>
                     </template>
                     <div slot="handler_name" slot-scope="name, record">
                       <div>{{ record.number }}</div>
                       <div>{{ name }}</div>
                     </div>
                     <div slot="version" slot-scope="version">
                      <p>{{version.full_version}}</p>
                      <p>{{version.status_desc}}</p>
                     </div>
                     <div slot="task_title" slot-scope="task,record" style="padding-right: 20px;" class="text-p-overflow">
                          <span v-if="record.demand">
                              <router-link class="cup" :to="{ name: 'demandDetails', query: { id: record.demand.id }}" target="_blank" >{{record.demand.name}}</router-link>
                         </span>
                         <a  class="cup" :title="task"> {{task}}</a>
                         <span  v-if="!task && !record.demand">--</span>
                     </div>
                     <div class="status-box cup" slot="status" slot-scope="status,record">
                        <span  v-if="record.status_desc=='关闭中'"><span style="color:#FF4A4A;" class="iconfont fz13">&#xe654;</span> {{record.status_desc}}</span>
                        <span  v-if="record.status_desc=='未开始'"><span style="color:#FEBC2E;" class="iconfont fz13">&#xe654;</span> {{record.status_desc}}</span>
                        <span  v-if="record.status_desc=='进行中'"><span style="color:#FEBC2E;" class="iconfont fz13">&#xe654;</span> {{record.status_desc}}</span>
                        <span  v-if="record.status_desc=='已提交'"><span style="color:#FEBC2E;" class="iconfont fz13">&#xe653;</span> {{record.status_desc}}</span>
                        <span  v-if="record.status_desc=='已暂停'"><span style="color:#FEBC2E;" class="iconfont fz13">&#xe654;</span> {{record.status_desc}}</span>
                        <span  v-if="record.status_desc=='已完成'"><span style="color:#3DCCA6;" class="iconfont fz13">&#xe653;</span> {{record.status_desc}}</span>
                        <span  v-if="record.status_desc=='已撤销'"><span style="color:#BBBBBB;" class="iconfont fz13">&#xe654;</span> {{record.status_desc}}</span>
                     </div>
                     <div slot="demand" slot-scope="demand">
                         <div v-if="demand">
                             <p>{{demand.number}}</p>
                             <p>{{demand.promulgator_name}}</p>
                         </div>
                         <div v-else> -- </div>
                     </div>
                     <div slot="progress" slot-scope="text, record">
                       <a v-if="record.demand && record.demand.id" class="p-a" @click="checkProgress(record)">查看</a>
                       <span v-else>--</span>
                     </div>
                      <div slot="appeal_users" slot-scope="appeal">
                         <span v-for="(item,index) in appeal" :key="index">
                             {{item}} <span v-if="index!==appeal.length-1">、</span>
                         </span>
                        <span v-if="appeal.length===0">--</span>
                     </div>
                     <div slot="branch_name" slot-scope="branch,record">
                        <div>
                          <span v-if="record.release_status === 1" class="label-unpublished">未发布测试</span>
                          <span v-else-if="record.release_status === 2" class="label-published">已发布测试</span>
                        </div>
                        {{branch}}
                        <a-popover placement="bottomLeft"
                        arrowPointAtCenter>
                        <template slot="content">
                            <div style="max-width:216px;">
                            {{ record.release_comment }}
                            </div>
                        </template>
                        <a-icon v-if="record.release_comment"
                                class="question"
                                type="question-circle" />
                        </a-popover>
                     </div>
                     <div  slot="has_sql" slot-scope="has_sql">
                        <span>
                            {{has_sql ? '有' : '--'}}
                        </span>
                     </div>
                     <div  slot="stress_test" slot-scope="stress_test">
                        <span class="version-tag-1" v-if="stress_test">
                           压测
                        </span>
                        <span v-else>--</span>
                     </div>

                    <div  slot="product_confirmed" slot-scope=" product_confirmed">
                        <img v-if="product_confirmed" src="@/assets/images/confirm-icon-2.png">
                        <img v-else src="@/assets/images/confirm-icon-1.png">
                     </div>
                     <div class="operate-box" slot="operate" slot-scope="text,record">
                         <span title="确认版本信息无误" v-if="record.policies.confirmVersion" class="icon iconfont" @click="confirm(record)">&#xe647;</span>
                         <span title="取消已确认标记版本信息" style="color:#FEBC2E" v-if="record.policies.cancelConfirmVersion" class="icon iconfont" @click="confirm(record)">&#xe647;</span>
                         <span title="已发布测试，版本管理员可操作进行更改功能版本信息" v-if="record.policies.modifyVersion" class="icon iconfont" @click="editFeature(record)">&#xe637;</span>
                         <span title="发布测试" v-if="record.policies.releaseTest" class="icon iconfont iconyijianfabuceshi" style="color: #378EEF;" @click="releaseT(record)"></span>
                     </div>
            </a-table>
        </div>
    </div>
</template>
<style lang="less" scoped>

    /deep/.ant-progress-circle .ant-progress-text{
        top:45%;
    }
   /deep/.ant-table-thead > tr:first-child > th:first-child{
       padding-left: 20px;
   }
   /deep/.ant-table-tbody > tr > td:first-child{
       padding-left: 20px;
   }
   /deep/.feature-table .ant-table-thead > tr > th{
        background: #E4EAF6 !important;
   }
   /deep/.ant-table-body  tr:nth-child(even) {
        background: #F9FCFF !important;
  }
   /deep/.ant-modal-wrap{
       z-index: 1100;
  }
  /deep/ .ant-table-column-title {
    color: #666;
  }
  /deep/ .el-dialog__header {
    padding: 12px 20px;
    .el-dialog__headerbtn {
      top: 15px;
    }
    .el-icon-close {
      font-size: 20px;
      top: -5px;
    }
  }
  .feature-table {
    /deep/ .ant-table table {
      table-layout: fixed;
    }
  }
    .operate-box{
        color: #378eef;
        .iconfont{
            font-size: 12px;
            cursor: pointer;
            margin-right: 10px;
        }
    }
    .excel-ok{
        text-align: right;
        padding: 20px 10px;
        width: 280px;
    }
    .icon-node{
        position: relative;
        display: inline-block;
        vertical-align: middle;
        width: 12px;
        height: 12px;
        border: 3px solid #E2E2E2;
        border-radius: 50%;
        margin: 0 20px;
         .icon-line{
            position: absolute;
            left: 2px;
            top: 11px;
            z-index: 10;
            width: 2px;
            height: 28px;
            background: #e2e2e2;
    }
    .version-num{
        color: #bbb;
    }
    }
    .content{
        display: flex;
        margin-bottom: 30px;
    }
    .title{
            height: 54px;
            line-height: 54px;
            font-size: 16px;
            font-family: Microsoft YaHei;
            font-weight: bold;
            color: #333333;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
            >a{
                float: right;
                margin-left: 20px;
                font-weight: 400;
            }
            .line{
                display: inline-block;
                position: relative;
                top: 11px;
                width: 1px;
                height: 32px;
                background: #EEEEEE;
                margin-right: 20px;
                margin-left: 40px;
            }
        }
    .left-box{
        width: 23%;
        min-width: 260px;
        h1{
            font-size: 24px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 15px;
        }
        h3{
            font-size: 18px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 25px;
        }
        .t-box{
            padding: 30px 30px 20px 30px;
        }
        .b-box{
            padding-top: 0;
            .version{
                height: 180px;
                padding-right: 10px;
                overflow-y: auto;
                a:hover{
                    text-decoration:underline
                }
                .iconfont{
                    color: #378EEF;
                    margin-right: 15px;
                }
                >p{
                    height: 40px;
                    line-height: 40px;
                    color: #666;
                    padding-left: 20px;
                    background: #F9FCFF;
                    margin-bottom: 2px;
                }
            }
        }
        .dashboard{
            text-align: center;
            height: 142px;
            .num{
                font-size: 24px;
                font-family: Microsoft YaHei;
                font-weight: bold;
                color: #333333;
                margin-top: 15px;
                margin-bottom: 15px;
            }
        }
    }
    .active{
        color: #378EEF !important;
        background: #F9F9F9;
        border-radius: 3px;
    }

    .p-part{
        .year{
                font-size: 16px;
                font-weight: bold;
                display: inline-block;
                position: relative;
                left: 23%;
                margin-bottom: 10px;
                i{
                    color: #378eef;
                    vertical-align: baseline;
                }

        }
        .version-empty-data{
            width: 340px;
        }
        .left{
            height: 450px;
            overflow-y: auto;
            min-width: 200px;
            padding-right: 10px;
            margin-right: 20px;

            .eidtDropdown{
                float: right;
                height: 32px;
                display: none;
            }

            .p-name{
                height: 32px;
                cursor: pointer;
                position: relative;
                padding-left: 20px;
                // padding-right: 15px;
                line-height: 32px;
                width: 240px;
                .ant-dropdown-link{
                    position: absolute;
                    right: 15px;
                }
                .active-l{
                    position: absolute;
                    left: 0;
                    top: 50%;
                    transform: translateY(-50%);
                    width: 3px;
                    height: 16px;
                    background: rgba(55, 142, 239, 1);
                }
            }
            .p-name:hover{
                background: #F9F9F9;
                border-radius: 3px;
                .eidtDropdown{
                    display: inline-block;
                }
            }
        }
        .right{
            max-height: 486px;
            min-width: 280px;
            overflow-y: auto;
            flex: 1;
            background: #FAFAFA;
            border-radius: 3px;
            padding: 0 20px 0px 20px;
        }
    }
    .details{
        line-height: 16px;
        .marginB20{
            display: flex;
        }
        .left-details{
            width: 75px;
            margin-right: 10px;
            color: #bbb;
        }
        .right-details{
            flex:1;
            word-break: break-all;
        }
    }
    .version-details{
        .left-details{
             width: 100px;
        }
    }
  .to-tested{
      .icon-node{
          border-color:#FEBC2E ;
      }
      .icon-line{
          background: #FEBC2E;
      }
      .version-num{
          color: #555;
      }

  }
  .testing{
      padding: 5px 0;
      height: 42px !important;
      .active{
          color: #FEBC2E !important;
      }
      .icon-node{
          width: 22px ;
          height: 22px ;
          margin: 0 15px;
          background-image: url('../../../assets/images/ellipse.png');
          background-position: center;
          background-repeat: no-repeat;
          border:0 ;
          background-color: #FEBC2E;
      }
      .icon-line{
          background: #FEBC2E;
          top: 24px;
          left: 10px;
      }
      .version-num{
          color: #FEBC2E;
          font-weight: bold;
      }
  }
  .label-unpublished {
    display: inline-block;
    padding: 0 3px;
    line-height: 18px;
    color: #FF7142;
    background-color: rgba(255, 113, 66, .2);
    font-size: 12px;
    border-radius: 3px;
  }
  .label-published {
    display: inline-block;
    padding: 0 3px;
    line-height: 18px;
    color: #3FCBA6;
    background-color: rgba(63, 203, 166, .2);
    font-size: 12px;
    border-radius: 3px;
  }
  .sort-btn i {
    font-size: 12px;
    color: #bbb;
    cursor: pointer;
    display: block;
    line-height: 8px;
    height: 8px;
    transform: scale(0.91666667) rotate(0deg);
  }
  .sort-btn i.choose { color: #1890ff; }
</style>

<script>
import { Empty } from 'ant-design-vue'
import { canDo } from '@/plugins/common'
import { getBindPeople, testTaskHandler } from '@/api/RDmanagement/dropDown'
import { searchUserList } from '@/api/userManage/index.js'
import { getPublishingProducts, publishingProductDetails, getAdmin, getVersions, getVersionsFeatures, testVersions, onlineVersions, testVersionsFeature, getStatistics, publishingProductLogs, versionsLogs, exportFeatures, getExportFeaturesCode, getProductPublisher } from '@/api/RDmanagement/ProductMaintenance/edition.js'
import addPublishingModal from './modal/addPublishingModal'
import switchModal from './modal/switchModal'
import deleteModal from './modal/deleteModal'
import confirmModal from './modal/confirmModal'
import logsModal from './modal/logsModal'
import checkResultsModal from './modal/checkResultsModal'
import releaseModal from './modal/releaseModal'
import editVersionFeature from './modal/editVersionFeature'
import addVersionPlan from './modal/addVersionPlan'
import allTaskInfo from '@/components/allTaskInfo'
import { bus } from '@/plugins/bus'
import qs from 'qs'
import moment from 'moment'
const columns = [
  {
    // title: '任务ID/处理人',
    dataIndex: 'handler_name',
    key: 'handler_name',
    scopedSlots: { customRender: 'handler_name', title: 'Handler' },
    width: '8.65%'
  },
  {
    title: '需求/任务标题',
    key: 'task_title',
    dataIndex: 'task_title',
    scopedSlots: { customRender: 'task_title' },
    width: '16.35%'
  },
  {
    title: '任务状态',
    dataIndex: 'status',
    key: 'status',
    scopedSlots: { customRender: 'status' },
    width: '7.04%'
  },
  {
    title: '产品需求信息',
    key: 'demand',
    dataIndex: 'demand',
    scopedSlots: { customRender: 'demand' },
    width: '9.42%'
  },
  {
    title: '研发进度',
    key: 'progress',
    dataIndex: 'progress',
    scopedSlots: { customRender: 'progress' },
    width: '6.1%'
  },
  {
    title: '诉求人',
    key: 'appeal_users',
    dataIndex: 'appeal_users',
    scopedSlots: { customRender: 'appeal_users' },
    width: '7.48%'
  },
  {
    title: '发布状态/分支名/说明',
    key: 'branch_name',
    dataIndex: 'branch_name',
    scopedSlots: { customRender: 'branch_name' },
    width: '13.64%'
  },
  {
    title: 'SQL',
    key: 'has_sql',
    dataIndex: 'has_sql',
    scopedSlots: { customRender: 'has_sql' },
    width: '5.32%'
  },
  {
    title: '压测',
    key: 'stress_test',
    dataIndex: 'stress_test',
    scopedSlots: { customRender: 'stress_test' },
    width: '6.32%'
  },
  {
    title: '版本号/状态',
    key: 'version',
    dataIndex: 'version',
    scopedSlots: { customRender: 'version' },
    width: '7.32%'
  },
  {
    title: '产品确认',
    key: 'product_confirmed',
    dataIndex: 'product_confirmed',
    scopedSlots: { customRender: 'product_confirmed' },
    width: '6.2%'
  },
  {
    title: '操作',
    key: 'operate',
    dataIndex: 'operate',
    scopedSlots: { customRender: 'operate' }
  }

]
let search = []

export default {
  components: { addPublishingModal, switchModal, deleteModal, addVersionPlan, confirmModal, logsModal, editVersionFeature, checkResultsModal, releaseModal, allTaskInfo },
  data () {
    return {
      versionYear: new Date().getFullYear(),
      releaseType: 'test',
      loading: false,
      excelRadio: 1,
      statisticsNum: 0,
      statisticsPercent: 0,
      confirmCount: 0,
      confirmList: [],
      productsList: [],
      logsData: [],
      details: { online_address: [], testing_address: [], policies: {} },
      versionDetails: { policies: {} },
      versionList: [],
      admins: [],
      taskHandler: [],
      testHander: [],
      productPublisher: [],
      options_1: [],
      options_2: [],
      options_3: [],
      userName: JSON.parse(localStorage.getItem('user')).name,
      activeIndex: 0,
      activeIndex2: 0,
      columns,
      functionData: [],
      pagination: {
        showSizeChanger: true,
        pageSizeOptions: ['20', '30', '50'],
        total: 10,
        current: 1,
        pageSize: 2
      },
      paginationParams: { 'page': 1, 'limit': 20, 'sort': 'submit_time' },
      addType: 1,
      publishingProducts: [],
      productDetail: {},
      searchMsg: undefined,
      searchData: {
        handler_id: undefined,
        stress_test: undefined,
        product_confirmed: undefined,
        promulgator_id: undefined,
        release_status: undefined,
        test_handler_id: undefined
      },
      searchData2: {
        admin_id: undefined,
        is_open: undefined
      },
      demand_id: undefined
    }
  },

  watch: {
    searchData: {
      handler (newVal) {
        search['stress_test'] = newVal.stress_test
        search['product_confirmed'] = newVal.product_confirmed
        search['handler_id'] = newVal.handler_id
        search['promulgator_id'] = newVal.promulgator_id
        search['release_status'] = newVal.release_status
        search['test_handler_id'] = newVal.test_handler_id
        let params = { filters: search }
        this.getFeaturesList(this.versionDetails.id, params)
      },
      deep: true
    },
    searchData2: {
      handler (newVal) {
        let params = this.searchData2
        this.getProList(params)
      },
      deep: true
    }
  },
  computed: {
    yearList () {
      let arr = []
      const y = new Date().getFullYear()
      for (let i = 2021; i <= y; i++) {
        arr.push(i)
      }
      return arr
    }
  },
  beforeCreate () {
    this.simpleImage = Empty.PRESENTED_IMAGE_SIMPLE
  },
  mounted () {
    this.getAdminUser()
    this.getConfirmNum()
    getBindPeople().then(res => {
      this.taskHandler = res.data.users
    })
    testTaskHandler().then(res => {
      this.testHander = res.data.users
    })
    getProductPublisher().then(res => {
      this.productPublisher = res.data.users
    })
    this.getProId()
  },
  methods: {
    moment,
    canDo,
    search (e, type) {
      this.$nextTick(() => {
        let self = this
        this.timer = searchUserList(this.timer, e, function (data) {
          if (type === 1) {
            self.options_1 = data.data.users
          } else if (type === 2) {
            self.options_2 = data.data.users
          } else if (type === 3) {
            self.options_3 = data.data.users
          }
        })
      })
    },
    toConfirm (item) {
      // 定位到需确认的版本功能清单
      this.productsList.forEach((p, index) => {
        if (p.id === item.release_product_id) {
          this.activeIndex = index
          publishingProductDetails(p.id).then(res => {
            this.details = res.data.release_product
          })
        }
      })
      getVersions(item.release_product_id).then(res => {
        this.versionList = res.data.release_versions
        this.versionList.forEach((v, index) => {
          if (v.id === item.id) {
            this.activeIndex2 = index
            this.versionDetails = this.versionList[this.activeIndex2]
          }
        })
      })
      this.getFeaturesList(item.id)
    },
    // 如果是版本管理员则直接选中当前登录用户的第一个发版产品，否则默认第一个
    async getProId () {
      const productsList = await getPublishingProducts()
      this.productsList = productsList.data.release_products
      this.activeIndex = this.productsList.findIndex((val) => val.admins.filter(item => item.user_name === this.userName).length > 0) > 0 ? this.productsList.findIndex((val) => val.admins.filter(item => item.user_name === this.userName).length > 0) : 0
      this.firstRender()
    },
    // 默认滚动定位到测试中的版本
    async firstRender () {
      if (this.productsList.length === 0) {
        return
      }
      const details = await publishingProductDetails(this.productsList[this.activeIndex].id)
      const versionList = await getVersions(this.productsList[this.activeIndex].id)
      this.details = details.data.release_product
      this.versionList = versionList.data.release_versions
      if (this.versionList.length === 0) {
        this.functionData = []
        return
      }
      for (let index = 0; index < this.versionList.length; index++) {
        if (this.versionList[index].status === 1) {
          this.activeIndex2 = index
        }
      }
      for (let index = 0; index < this.versionList.length; index++) {
        if (this.versionList[index].status === 2) {
          this.activeIndex2 = index
        }
      }
      this.versionDetails = this.versionList[this.activeIndex2]
      this.$nextTick(() => {
        document.querySelector('.scroll-bar').scrollTo(0, 44 * this.activeIndex2)
      })
      this.loading = true
      let params = Object.assign(this.paginationParams, { filters: search })
      const functionData = await getVersionsFeatures(this.versionDetails.id, params)
      this.functionData = functionData.data.data
      this.loading = false
      this.pagination.total = functionData.data.total
      this.pagination.current = functionData.data.current_page
      this.pagination.pageSize = functionData.data.per_page
    },
    getConfirmNum () {
      getStatistics().then(res => {
        this.confirmList = res.data.statistics_data.need_confirm
        this.confirmCount = res.data.statistics_data.need_confirm_count
        const arr = res.data.statistics_data.release_products_count
        this.statisticsNum = arr.total
        this.statisticsPercent = arr.open / arr.total * 100
      })
    },
    changeYear (y) {
      this.versionYear = y
      this.getVersionsList(this.productsList[this.activeIndex].id, { year: y })
    },
    handleExport () {
      getExportFeaturesCode().then(res => {
        let userId = JSON.parse(localStorage.getItem('user')).id
        let params = { search, userId, tempAuthCode: res.data.code }
        params = qs.stringify(params)
        exportFeatures(this.versionDetails.id, params)
      })
    },
    releaseTest () {
      testVersions(this.versionDetails.id).then(res => {
      }).catch(error => {
        let res = error.response.data
        if (res.code === 406) {
          this.releaseType = 'test'
          bus.$emit('releaseModalShow', this.versionDetails)
        } else {
          bus.$emit('checkResultsModalShow', res.errors)
        }
      })
    },
    releaseOnline () {
      onlineVersions(this.versionDetails.id).then(res => {

      }).catch(error => {
        let res = error.response.data
        if (res.code === 406) {
          this.releaseType = 'online'
          bus.$emit('releaseModalShow', this.versionDetails)
        } else {
          bus.$emit('checkResultsModalShow', res.errors)
        }
      })
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
    showLogs (index, data) {
      bus.$emit('logsModalShow')
      switch (index) {
        case 1:
          publishingProductLogs(data.id).then(res => {
            this.logsData = res.data.status_logs
          })
          break
        case 2:
          versionsLogs(data.id).then(res => {
            this.logsData = res.data.status_logs
          })
          break

        default:
          break
      }
    },
    confirm (record) {
      bus.$emit('confirmModalShow', record)
    },
    editFeature (record) {
      bus.$emit('editFeatureModalShow', record)
    },
    addVersionPlan () {
      bus.$emit('addVersionModalShow')
    },
    operation (index, item) {
      if (index === 1) {
        bus.$emit('addPublishingModalShow', item)
      } else if (index === 2) {
        bus.$emit('switchPublishingModalShow', item)
      } else if (index === 3) {
        bus.$emit('delPublishingModalShow', { ...item, type: 'product' })
      } else if (index === 4) {
        bus.$emit('addVersionModalShow', item)
      } else if (index === 5) {
        bus.$emit('delPublishingModalShow', { ...item, type: 'version' })
      }
    },
    getAdminUser () {
      getAdmin().then(res => {
        this.admins = res.data
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    showMsg (index, k, item) {
      if (index === 1) {
        this.activeIndex = k
        this.versionYear = new Date().getFullYear()
        this.firstRender()
      } else if (index === 2) {
        this.activeIndex2 = k
        this.versionDetails = this.versionList[k]
        this.loading = true
        let params = Object.assign(this.paginationParams, { filters: search })
        getVersionsFeatures(this.versionDetails.id, params).then(res => {
          this.functionData = res.data.data
          this.loading = false
          this.pagination.total = res.data.total
          this.pagination.current = res.data.current_page
          this.pagination.pageSize = res.data.per_page
        })
      }
    },
    searchFeatures (value) {
      if (value) {
        search['keyword'] = '%' + value.trim() + '%'
      } else {
        search['keyword'] = undefined
      }
      let params = { filters: search }
      this.getFeaturesList(this.versionDetails.id, params)
    },
    getFeaturesList (id, params) {
      this.loading = true
      if (params === undefined) {
        params = { filters: search }
      }
      if (!params.hasOwnProperty('page') && !params.hasOwnProperty('limit')) {
        Object.assign(params, this.paginationParams)
        // Object.assign(params, { 'page': this.pagination.current, 'limit': this.pagination.pageSize })
      }
      getVersionsFeatures(id, params).then(res => {
        this.functionData = res.data.data
        this.loading = false
        this.pagination.total = res.data.total
        this.pagination.current = res.data.current_page
        this.pagination.pageSize = res.data.per_page
      })
    },
    getVersionsList (id, params) {
      getVersions(id, params).then(res => {
        this.versionList = res.data.release_versions
        if (this.versionList.length) {
          this.versionDetails = this.versionList[this.activeIndex2]
          this.loading = true
          getVersionsFeatures(this.versionDetails.id, Object.assign(this.paginationParams, { filters: search })).then(res => {
            this.functionData = res.data.data
            this.loading = false
            this.pagination.total = res.data.total
            this.pagination.current = res.data.current_page
            this.pagination.pageSize = res.data.per_page
          })
        } else {
          this.functionData = []
        }
      })
    },
    getProList (params) {
      getPublishingProducts(params).then(res => {
        this.productsList = res.data.release_products
        if (this.productsList.length) {
          publishingProductDetails(this.productsList[this.activeIndex].id).then(res => {
            this.details = res.data.release_product
          })
          this.getVersionsList(this.productsList[this.activeIndex].id)
        }
      })
    },
    showPublishingModal () {
      bus.$emit('addPublishingModalShow')
    },
    handleTableChange (selectedRowKeys, selectedRows) {
      // 分页处理
      this.getFeaturesList(this.versionDetails.id, { 'page': selectedRowKeys.current, 'limit': selectedRowKeys.pageSize })
      this.pagination.total = selectedRowKeys.total
      this.pagination.current = selectedRowKeys.current
      this.pagination.pageSize = selectedRowKeys.pageSize
    },
    checkProgress (record) {
      // 查看研发进度
      this.$refs.allTaskInfo.dialogVisible = true
      this.demand_id = record.demand.id
    },
    releaseT (record) {
      // 发布版本功能点测试
      testVersionsFeature(record.id, { 'task_type': record.task_type }).then(res => {
      }).catch(error => {
        let res = error.response.data
        if (res.code === 406) {
          this.releaseType = record.task_type
          bus.$emit('releaseModalShow', record)
        } else {
          bus.$emit('checkResultsModalShow', res.errors)
        }
      })
    },
    sortList (status) {
      // 排序
      if (status === 1) {
        Object.assign(this.paginationParams, { sort: this.paginationParams.sort === 'handler_name' ? 'submit_time' : 'handler_name' })
      } else {
        Object.assign(this.paginationParams, { sort: this.paginationParams.sort === '-handler_name' ? 'submit_time' : '-handler_name' })
      }
      this.getFeaturesList(this.versionDetails.id)
    },
    refreshList () {
      // 刷新列表
      this.getFeaturesList(this.versionDetails.id)
    }
  }
}
</script>
