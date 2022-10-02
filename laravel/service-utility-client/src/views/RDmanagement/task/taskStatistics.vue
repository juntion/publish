<template>
    <div>
        <div style="margin-bottom:20px" class="box border">
            <div>
                 <a-select placeholder="小组"
                  labelInValue
                  showSearch
                  mode="multiple"
                  v-model="searchData.department"
                  @change="changeType"
                  optionFilterProp="children"
                  class="icon-select"
                  style="width: 130px;margin-right: 10px;">
                    <a-select-option v-for="item in options1"
                           :key="item.id">{{item.text}}</a-select-option>
                 </a-select>
                 <a-popover placement="bottomLeft"
                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                               arrowPointAtCenter>
                            <template slot="content">
                                <div>
                                组织架构下的人员的账号类别。
                                </div>
                            </template>
                                <span class="iconfont fz12 cup question-icon">&#xe640;</span>
                </a-popover>
                <a-select placeholder="人员"
                    labelInValue
                    showSearch
                    mode="multiple"
                    v-model="searchData.admin_id"
                    optionFilterProp="children"
                    class="icon-select"
                    style="width: 120px;margin-right: 10px;">
                     <a-select-option v-for="item in options2"
                           :key="item.id">{{item.text}}</a-select-option>
                </a-select>
                <a-popover placement="bottomLeft"
                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                               arrowPointAtCenter>
                            <template slot="content">
                                <div>
                                取任务的处理人。
                                </div>
                            </template>
                                <span class="iconfont fz12 cup question-icon">&#xe640;</span>
                </a-popover>
                <div style="float:right">
                    <a-select placeholder="年"
                    labelInValue
                    showSearch
                    @change="changeYear"
                    v-model="searchData.year_list"
                    optionFilterProp="children"
                    style="width: 90px;margin-right: 10px;">
                        <a-select-option :key="getYear">{{getYear}}年</a-select-option>
                        <a-select-option :key="getYear-1">{{getYear-1}}年</a-select-option>
                        <a-select-option :key="getYear-2">{{getYear-2}}年</a-select-option>
                        <a-select-option :key="getYear-3">{{getYear-3}}年</a-select-option>
                        <a-select-option :key="getYear-4">{{getYear-4}}年</a-select-option>
                        <a-select-option :key="getYear-5">{{getYear-5}}年</a-select-option>
                    </a-select>
                    <a-select placeholder="季"
                    labelInValue
                    showSearch
                    v-model="searchData.quarter_list"
                    optionFilterProp="children"
                    @change="changeQuarter"
                    style="width: 90px;margin-right: 10px;">
                         <a-select-option v-for="item in quarter_list"
                           :key="item">第{{item}}季度</a-select-option>
                    </a-select>
                    <a-select placeholder="月"
                    labelInValue
                    showSearch
                    @change="changeMoon"
                    v-model="searchData.moon_list"
                    optionFilterProp="children"
                    style="width: 90px;">
                            <a-select-option v-for="item in moon_list"
                           :key="item">{{item}}月</a-select-option>
                    </a-select>
                    <i class="short-line"></i>
                    <a-select placeholder="快速筛选"
                        labelInValue
                        showSearch
                        v-model="searchData.days"
                        optionFilterProp="children"
                        style="width: 95px;margin-right: 10px;">
                        <a-select-option v-for="item in options3"
                           :key="item.id">{{item.text}}</a-select-option>
                    </a-select>
                    <a-range-picker
                        style="width:240px;"
                        :allowClear="false"
                        format="YYYY/MM/DD"
                        v-model="searchData.select_time"
                        >
                        <span class="iconfont" slot="suffixIcon" style="font-size:12px;margin-top: -6px;">&#xe659;</span>
                    </a-range-picker>
                </div>
            </div>
            <div class="upload_box">
                <div class="popup_opinion_submit_box after">
                    <ul class="popup_opinion_submit_file">
                    <span>筛选：</span>
                    <li v-if="searchData.department.length">
                        <b>小组:
                        <span v-for="(k,index) in searchData.department" :key="index">
                            {{k.label}} <span v-if="index!==searchData.department.length-1">,</span>
                        </span>
                    </b>
                        <i class="icon iconfont" @click="reset(1)"
                        >&#xe631;</i>
                    </li>
                    <li v-if="searchData.admin_id.length"><b>人员:
                            <span v-for="(k,index) in searchData.admin_id" :key="index">
                                {{k.label}} <span v-if="index!==searchData.admin_id.length-1">,</span>
                            </span>
                        </b>
                        <i class="icon iconfont" @click="reset(2)"
                        >&#xe631;</i>
                    </li>
                    <li v-if="searchData.year_list"><b>年: {{searchData.year_list.label}}</b>
                        <i class="icon iconfont" @click="reset(3)"
                        >&#xe631;</i>
                    </li>
                    <li v-if="searchData.quarter_list"><b>季度: {{searchData.quarter_list.label}}</b>
                        <i class="icon iconfont" @click="reset(4)"
                        >&#xe631;</i>
                    </li>
                    <li v-if="searchData.moon_list"><b>月: {{searchData.moon_list.label}}</b>
                        <i class="icon iconfont" @click="reset(5)"
                        >&#xe631;</i>
                    </li>
                    <li v-if="searchData.days && searchData.days.key"><b>快速筛选: {{searchData.days.label}}</b>
                        <i class="icon iconfont" @click="reset(6)"
                        >&#xe631;</i>
                    </li>
                    <li v-if="searchData.select_time"><b>时间: {{ searchData.select_time[0].format('YYYY/MM/DD') + ' 至 ' + searchData.select_time[1].format('YYYY/MM/DD')}}</b>
                        <i class="icon iconfont" @click="reset(7)"
                        >&#xe631;</i>
                    </li>
                    </ul>
                </div>
            </div>
        </div>
    <a-spin :spinning="spinning">
        <div class="list border">
            <ul>
                <li style="width:20%">
                    <p class="title">新增任务数 (个)
                         <a-popover placement="bottomLeft"
                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                               arrowPointAtCenter>
                            <template slot="content">
                                <div>
                                    取任务分配给跟进人时间,统计当天任务数量
                                </div>
                            </template>
                                <span class="iconfont fz12 cup">&#xe640;</span>
                         </a-popover>
                    </p>
                    <div class="number">{{headData.task.taskNum}}</div>
                    <div>
                        <span>环比 {{headData.task.taskCircle}}% </span>
                        <img style="vertical-align: -2px;" v-if="headData.task.taskCircle > 0" src="../../../assets/images/up.png">
                        <img style="vertical-align: -2px;" v-else src="../../../assets/images/down.png">
                    </div>
                </li>
                <li style="width:20%">
                    <p class="title">提交任务数 (个)
                         <a-popover placement="bottomLeft"
                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                               arrowPointAtCenter>
                            <template slot="content">
                                <div>
                                取任务完成时间，统计筛选时间内完成任务数量
                                </div>
                            </template>
                                <span class="iconfont fz12 cup">&#xe640;</span>
                         </a-popover>
                    </p>
                    <div class="number">{{headData.task.submitNum}}</div>
                    <div>
                        <span>环比 {{headData.task.submitCircle}}% </span>
                        <img style="vertical-align: -2px;"  v-if="headData.task.submitCircle>0" src="../../../assets/images/up.png">
                        <img style="vertical-align: -2px;" v-else src="../../../assets/images/down.png">
                    </div>
                </li>
                <li style="width:20%">
                    <p class="title">按时提交任务数 (个)
                         <a-popover placement="bottomLeft"
                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                               arrowPointAtCenter>
                            <template slot="content">
                                <div>
                               取任务完成时间，统计筛选时间内完成类型为按时或提前完成的任务数量。完成类型2020/9/11上线，上线前此数据有误。
                                </div>
                            </template>
                                <span class="iconfont fz12 cup">&#xe640;</span>
                         </a-popover>
                    </p>
                    <div class="number">{{headData.task.onTimeSubmitNum}}</div>
                    <div>
                        <span>环比 {{headData.task.onTimeSubmitCircle}}% </span>
                        <img style="vertical-align: -2px;" v-if="headData.task.onTimeSubmitCircle>0" src="../../../assets/images/up.png">
                        <img style="vertical-align: -2px;" v-else src="../../../assets/images/down.png">
                    </div>
                </li>
                <li style="width:20%">
                    <p class="title">新增bug数 (个)
                         <a-popover placement="bottomLeft"
                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                               arrowPointAtCenter>
                            <template slot="content">
                                <div>
                                 取bug分配给跟进人时间，统计当天bug新增数量
                                </div>
                            </template>
                                <span class="iconfont fz12 cup">&#xe640;</span>
                         </a-popover>
                    </p>
                    <div class="number">{{headData.bug.bugNum}}</div>
                    <div>
                        <span>环比 {{headData.bug.bugCircle}}% </span>
                        <img style="vertical-align: -2px;" v-if="headData.bug.bugCircle>0" src="../../../assets/images/up.png">
                        <img style="vertical-align: -2px;" v-else src="../../../assets/images/down.png">
                    </div>
                </li>
                <li style="width:20%">
                    <p class="title">提交bug数 (个)
                         <a-popover placement="bottomLeft"
                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                               arrowPointAtCenter>
                            <template slot="content">
                                <div>
                                取bug完成时间，统计当天已复核通过的bug数量
                                </div>
                            </template>
                                <span class="iconfont fz12 cup">&#xe640;</span>
                         </a-popover>
                    </p>
                    <div class="number">{{headData.bug.submitBugNum}}</div>
                    <div>
                        <span>环比 {{headData.bug.submitBugCircle}}% </span>
                        <img style="vertical-align: -2px;" v-if="headData.bug.submitBugCircle>0" src="../../../assets/images/up.png">
                        <img style="vertical-align: -2px;" v-else src="../../../assets/images/down.png">
                    </div>
                </li>
            </ul>
        </div>
        <div class="list border">
            <ul>
                <li style="width:33.3%">
                    <p class="title">任务完成率 (%)
                        <a-popover placement="bottomLeft"
                              :getPopupContainer="triggerNode => triggerNode.parentNode"
                               arrowPointAtCenter>
                        <template slot="content">
                            <div>
                                取分配任务时间或任务完成时间。任务完成率=任务完成时间在筛选时间的任务数量 / 任务分配或完成时间在筛选时间内的总任务数量
                            </div>
                        </template>
                            <span class="iconfont fz12 cup">&#xe640;</span>
                        </a-popover>
                    </p>
                    <a-progress type="circle"
                                :percent="taskDetail.finishRate"
                                stroke-color="#3DCCA6"
                                >
                      <template v-slot:format="percent">
                        <span style="color:#3DCCA6;font-size:30px;">{{Math.round(percent)}}<span style="font-size:12px;color:#3DCCA6;">%</span>
                          <p style="color:#BBBBBB;font-size:12px;margin-top:10px;">完成率</p>
                        </span>
                      </template>
                    </a-progress>
                </li>
                <li style="width:33.3%">
                    <p class="title">任务延期率 (%)
                        <a-popover placement="bottomLeft"
                              :getPopupContainer="triggerNode => triggerNode.parentNode"
                               arrowPointAtCenter>
                        <template slot="content">
                            <div>
                                取任务完成时间。延期率=任务超时完成的数量 / 完成任务总数量。
                            </div>
                        </template>
                            <span class="iconfont fz12 cup">&#xe640;</span>
                        </a-popover>
                    </p>
                    <a-progress type="circle"
                                :percent="taskDetail.overRate"
                                stroke-color="#FF4A4A"
                               >
                      <template v-slot:format="percent">
                        <span style="color:#FF4A4A;font-size:30px;">{{Math.round(percent)}}<span style="font-size:12px;color:#FF4A4A;">%</span>
                          <p style="color:#BBBBBB;font-size:12px;margin-top:10px;">延期率</p>
                        </span>
                      </template>
                    </a-progress>
                </li>
                <li style="width:33.3%;border-right:0;padding-bottom:0">
                    <p class="title" style="margin-bottom:6px">任务类型 (个)
                        <a-popover placement="bottomLeft"
                              :getPopupContainer="triggerNode => triggerNode.parentNode"
                               arrowPointAtCenter>
                        <template slot="content">
                            <div>
                                取任务完成时间，统计开发负责人对任务划分的等级的数量
                            </div>
                        </template>
                            <span class="iconfont fz12 cup">&#xe640;</span>
                        </a-popover>
                    </p>
                    <myCharts :chartsData="taskDetail"></myCharts>
                </li>
            </ul>
        </div>
        <div class="box border" style="padding-bottom:30px">
           <h1 class="top">成员工作统计</h1>
           <div style="overflow:hidden">
            <div class="line-chart">
                <p>任务完成数量情况
                    <a-popover placement="bottomLeft"
                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                                arrowPointAtCenter>
                        <template slot="content">
                            <div>
                               取任务完成时间。延期完成数：完成类型为超时完成的任务数量。 延期完成任务比例= 该人员（小组）延期完成的数量 / 对应时间内的完成任务数量。
                            </div>
                        </template>
                            <span class="iconfont fz12 cup">&#xe640;</span>
                        </a-popover>
                    </p>
                <lineCharts  :chartType="1" :chartsData="taskNum"></lineCharts>
            </div>
            <div class="line-chart" style="border-right:0;padding-left:20px">
                <p style="left:20px">bug处理数量情况
                    <a-popover placement="bottomLeft"
                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                                arrowPointAtCenter>
                        <template slot="content">
                            <div>
                                取bug完成时间。bug处理数量：统计人员（小组）对应时间内处理完成bug的数量。bug比例=处理bug数量 /（处理bug数+完成任务数量）完成任务数量取任务完成时间。bug延期处理比例= 延期数量 / bug处理数量。延期定义完成时间大于预估完成时间。
                            </div>
                        </template>
                            <span class="iconfont fz12 cup">&#xe640;</span>
                        </a-popover>
                </p>
                <lineCharts :chartType="2" :chartsData="bugNum"></lineCharts>
            </div>
           </div>
           <div class="details">
               <p class="marginB20">详细情况</p>
               <a-table
                    :columns="columns"
                    :scroll="{ x: true }"
                    :data-source="data"
                    :rowKey="(record, index) => index"
                    :pagination="false"
                    size="middle"
                >
                <div slot="sNum" slot-scope="text,record">
                    <div class="progress">
                        <span class="progress-num">{{text}}</span>
                         <a-progress  :percent="Math.round(text/record.taskTotal *100)" :strokeWidth="8" :format="percent => `${percent}%`" :strokeColor="strokeColor" size="small" />
                    </div>
                </div>
                <div slot="aNum" slot-scope="text,record">
                    <div class="progress">
                        <span class="progress-num">{{text}}</span>
                         <a-progress :percent="Math.round(text/record.taskTotal *100)" :strokeWidth="8"  :format="percent => `${percent}%`" :strokeColor="strokeColor" size="small" />
                    </div>
                </div>
                <div slot="bNum" slot-scope="text,record">
                    <div class="progress">
                        <span class="progress-num">{{text}}</span>
                         <a-progress :percent="Math.round(text/record.taskTotal *100)" :strokeWidth="8"  :format="percent => `${percent}%`" :strokeColor="strokeColor" size="small" />
                    </div>
                </div>
                <div slot="cNum" slot-scope="text,record">
                    <div class="progress">
                        <span class="progress-num">{{text}}</span>
                         <a-progress :percent="Math.round(text/record.taskTotal *100)" :strokeWidth="8"  :format="percent => `${percent}%`" :strokeColor="strokeColor" size="small" />
                    </div>
                </div>
                <div slot="dNum" slot-scope="text,record">
                    <div class="progress">
                        <span class="progress-num">{{text}}</span>
                         <a-progress :percent="Math.round(text/record.taskTotal *100)" :strokeWidth="8" :format="percent => `${percent}%`" :strokeColor="strokeColor" size="small" />
                    </div>
                </div>
                <div slot="customTitle" class="table-title"> 延期总数 (个)
                    <a-popover placement="bottomLeft"
                               arrowPointAtCenter>
                            <template slot="content">
                                <div >
                                取任务完成时间，统计筛选时间内开发环节任务验收完成且标记为超时完成的任务数量。
                                </div>
                            </template>
                                <span class="iconfont fz12 cup">&#xe640;</span>
                    </a-popover>
                </div>
                <div slot="customTitle2" class="table-title"> 延期时长
                    <a-popover placement="bottomLeft"
                               arrowPointAtCenter>
                            <template slot="content">
                                <div >
                                取任务完成时间，开发环节验收时系统自动计算延期时长之和。
                                </div>
                            </template>
                                <span class="iconfont fz12 cup">&#xe640;</span>
                    </a-popover>
                </div>
                 <div slot="customTitle3" class="table-title"> 延期率
                    <a-popover placement="bottomLeft"
                               arrowPointAtCenter>
                            <template slot="content">
                                <div>
                                延期总数/总任务数量。
                                </div>
                            </template>
                                <span class="iconfont fz12 cup">&#xe640;</span>
                    </a-popover>
                </div>
                 <div slot="customTitle4" class="table-title"> bug总数 (个)
                    <a-popover placement="bottomLeft"
                               arrowPointAtCenter>
                            <template slot="content">
                                <div>
                                取bug处理完成时间，统计筛选时间内复核通过的bug数量。
                                </div>
                            </template>
                                <span class="iconfont fz12 cup">&#xe640;</span>
                    </a-popover>
                </div>
                 <div slot="customTitle5" class="table-title"> 延期率
                    <a-popover placement="bottomLeft"
                               arrowPointAtCenter>
                            <template slot="content">
                                <div>
                                bug延期处理数量/bug总数。
                                </div>
                            </template>
                                <span class="iconfont fz12 cup">&#xe640;</span>
                    </a-popover>
                </div>
                <div slot="overTaskNum" slot-scope="text,record">
                    {{text}}
                    <a-popover placement="bottomLeft"
                    :getPopupContainer="triggerNode => triggerNode.parentNode"
                               arrowPointAtCenter>
                            <template slot="content">
                                <div>
                                        <p class="marginB10"><span class="task-num">S类型任务:</span>{{record.sOverNum}}个</p>
                                        <p class="marginB10"><span class="task-num">A类型任务:</span>{{record.aOverNum}}个</p>
                                        <p class="marginB10"><span class="task-num">B类型任务:</span>{{record.bOverNum}}个</p>
                                        <p class="marginB10"><span class="task-num">C类型任务:</span>{{record.cOverNum}}个</p>
                                        <p class="marginB10" style="margin-bottom:0"><span class="task-num">D类型任务:</span>{{record.dOverNum}}个</p>
                                </div>
                            </template>
                                <span class="iconfont fz12 cup">&#xe707;</span>
                    </a-popover>
                </div>
                <div slot="overTime" slot-scope="text" >
                    {{text}}天
                </div>
                 <div slot="overTaskRate" slot-scope="text" >
                    {{text}}%
                </div>
                <div slot="overBugRate" slot-scope="text" >
                    {{text}}%
                </div>
               </a-table>
           </div>
        </div>
    </a-spin>
    </div>
</template>
<script>
import lineCharts from '@/components/lineCharts'
import myCharts from '@/components/myCharts'
import moment from 'moment'
import axios from 'axios'
import { getHeaderTask, getHeaderBug, getTaskDetail, getTaskFinishedSituation, getBugDealSituation, getAdminWorkDetail, getSelectDutiesList, getSelectAdminList, getSelectTimeList } from '@/api/statisticsApi/index'
const columns = [
  {
    title: '后台系统',
    key: 'adminName',
    dataIndex: 'adminName',
    width: 150
  },
  {
    title: '任务',
    key: 'task',
    dataIndex: 'task',
    children: [
      {
        title: 'S类型任务',
        dataIndex: 'sNum',
        key: 'sNum',
        width: 180,
        scopedSlots: { customRender: 'sNum' },
        sorter: (a, b) => a.sNum - b.sNum
      },
      {
        title: 'A类型任务',
        dataIndex: 'aNum',
        key: 'aNum',
        width: 180,
        scopedSlots: { customRender: 'aNum' },
        sorter: (a, b) => a.aNum - b.aNum
      },
      {
        title: 'B类型任务',
        dataIndex: 'bNum',
        key: 'bNum',
        width: 180,
        scopedSlots: { customRender: 'bNum' },
        sorter: (a, b) => a.bNum - b.bNum
      },
      {
        title: 'C类型任务',
        dataIndex: 'cNum',
        key: 'cNum',
        width: 180,
        scopedSlots: { customRender: 'cNum' },
        sorter: (a, b) => a.cNum - b.cNum
      },
      {
        title: 'D类型任务',
        dataIndex: 'dNum',
        key: 'dNum',
        width: 180,
        scopedSlots: { customRender: 'dNum' },
        sorter: (a, b) => a.dNum - b.dNum
      },

      {
        title: '总任务数量',
        dataIndex: 'taskTotal',
        key: 'taskTotal',
        width: 180,
        sorter: (a, b) => a.taskTotal - b.taskTotal
      }
    ]

  },
  {
    title: '效率',
    key: 'efficiency',
    dataIndex: 'efficiency',
    children: [
      {
        // title: '延期总数',
        dataIndex: 'overTaskNum',
        key: 'overTaskNum',
        sorter: (a, b) => a.overTaskNum - b.overTaskNum,
        slots: { title: 'customTitle' },
        scopedSlots: { customRender: 'overTaskNum' },
        width: 180
      },
      {
        // title: '延期时长',
        dataIndex: 'overTime',
        key: 'overTime',
        slots: { title: 'customTitle2' },
        scopedSlots: { customRender: 'overTime' },
        width: 150,
        sorter: (a, b) => a.overTime - b.overTime
      },
      {
        // title: '延期率',
        dataIndex: 'overTaskRate',
        key: 'overTaskRate',
        slots: { title: 'customTitle3' },
        scopedSlots: { customRender: 'overTaskRate' },
        width: 150,
        sorter: (a, b) => a.overTaskRate - b.overTaskRate
      }
    ]
  },
  {
    title: '质量',
    key: 'quality',
    dataIndex: 'quality',
    children: [
      {
        // title: 'bug总数',
        dataIndex: 'bugNum',
        key: 'bugNum',
        slots: { title: 'customTitle4' },
        width: 180,
        sorter: (a, b) => a.bugNum - b.bugNum
      },
      {
        // title: '延期率',
        dataIndex: 'overBugRate',
        key: 'overBugRate',
        slots: { title: 'customTitle5' },
        scopedSlots: { customRender: 'overBugRate' },
        width: 150,
        sorter: (a, b) => a.overBugRate - b.overBugRate
      }
    ]

  }
]
let userInfo = {}
if (localStorage.getItem('user')) {
  userInfo.key = JSON.parse(localStorage.getItem('user')).id
  userInfo.label = JSON.parse(localStorage.getItem('user')).name
}

export default {
  components: { lineCharts, myCharts },
  data () {
    return {
      spinning: false,
      strokeColor: {
        form: '#378EEF',
        to: '#68A9F3'
      },
      columns,
      data: [],
      headData: {
        task: {},
        bug: {}
      },
      taskDetail: {},
      taskNum: {},
      bugNum: {},
      options1: [],
      options2: [],
      options3: [],
      quarter_list: [],
      moon_list: [],
      searchData: {
        year_list: { key: new Date().getFullYear(), label: `${new Date().getFullYear()}年` },
        quarter_list: undefined,
        moon_list: { key: new Date().getMonth() + 1, label: `${new Date().getMonth() + 1}月` },
        days: undefined,
        select_time: undefined,
        admin_id: [],
        department: [],
        admin_department: undefined,
        firstAdmin: undefined
      }
    }
  },
  computed: {
    getYear () {
      let date = new Date()
      let y = date.getFullYear()
      return y
    },
    firstAdmin () {
      let id = 0
      if (localStorage.getItem('user')) {
        id = JSON.parse(localStorage.getItem('user')).id
      }
      return id
    }
  },
  created () {
    let user = JSON.parse(localStorage.getItem('user'))
    if (user.duties > 10) {
      this.searchData.admin_id = []
      this.searchData.department = []
    } else if (user.duties === 10) {
      this.searchData.admin_id = []
      this.searchData.department = [{
        key: user.department[0].id,
        label: user.department[0].name
      }]
    } else {
      this.searchData.admin_id = [ {
        key: user.id,
        label: user.name
      }]
      this.searchData.department = []
    }
  },
  watch: {
    searchData: {
      handler (newVal) {
        this.spinning = true
        let params = {}
        if (newVal.department && newVal.department.length) {
          params.department = newVal.department.map(item => {
            return item.key
          })
        }
        if (newVal.admin_id && newVal.admin_id.length) {
          params.admin_id = newVal.admin_id.map(item => {
            return item.key
          })
        }
        if (newVal.days) {
          params.days = newVal.days.key
        }
        if (newVal.select_time) {
          params.select_time = newVal.select_time.key
        }
        if (newVal.select_time) {
          params.select_time = newVal.select_time[0].format('YYYY/MM/DD') + ' - ' + newVal.select_time[1].format('YYYY/MM/DD')
        }
        if (newVal.year_list) {
          params.year_list = newVal.year_list.key
        }
        if (newVal.quarter_list) {
          params.quarter_list = newVal.year_list.key + '-' + newVal.quarter_list.key
        }
        if (newVal.moon_list) {
          params.moon_list = newVal.year_list.key + '-' + newVal.moon_list.key
        }
        params.firstAdmin = this.firstAdmin
        this.getAllData(params)
      },
      deep: true,
      immediate: true
    }
  },
  methods: {
    moment,
    reset (index) {
      if (index === 1) {
        this.searchData.department = []
        this.getAdminList({ firstAdmin: this.firstAdmin })
      } else if (index === 2) {
        this.searchData.admin_id = []
      } else if (index === 3) {
        this.searchData.year_list = undefined
      } else if (index === 4) {
        this.searchData.quarter_list = undefined
      } else if (index === 5) {
        this.searchData.moon_list = undefined
      } else if (index === 6) {
        this.searchData.days = undefined
      } else if (index === 7) {
        this.searchData.select_time = undefined
      }
    },
    changeType (e) {
      this.searchData.admin_id = []
      let department = e.map(item => {
        return item.key
      })
      this.getAdminList({ department, firstAdmin: this.firstAdmin })
    },
    changeYear (e) {
      if (e.key === this.getYear) {
        let date = new Date()
        let m = date.getMonth() + 1
        let q = Math.floor((m % 3 === 0 ? (m / 3) : (m / 3 + 1)))
        let arr = []
        let arr2 = []
        for (let index = 1; index <= m; index++) {
          arr.push(index)
        }
        for (let index = 1; index <= q; index++) {
          arr2.push(index)
        }
        this.moon_list = arr.reverse()
        this.quarter_list = arr2.reverse()
      } else {
        this.moon_list = [12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1]
        this.quarter_list = [4, 3, 2, 1]
      }
    },
    changeQuarter () {
      this.searchData.moon_list = undefined
    },
    changeMoon () {
      this.searchData.quarter_list = undefined
    },
    getAdminList (params) {
      getSelectAdminList(params).then(res => {
        this.options2 = res.data.data.adminList
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    getAllData (params) {
      axios.all([getHeaderTask(params), getHeaderBug(params), getTaskDetail(params),
        getTaskFinishedSituation(params), getBugDealSituation(params), getAdminWorkDetail(params)]).then(
        axios.spread((r1, r2, r3, r4, r5, r6) => {
          this.headData.task = r1.data.data
          this.headData.bug = r2.data.data
          this.taskDetail = r3.data.data
          this.taskNum = r4.data.data
          this.bugNum = r5.data.data
          this.data = r6.data.data
          this.spinning = false
        })
      ).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    }

  },
  mounted () {
    let date = new Date()
    let m = date.getMonth() + 1
    let q = Math.floor((m % 3 === 0 ? (m / 3) : (m / 3 + 1)))
    let arr = []
    let arr2 = []
    for (let index = 1; index <= m; index++) {
      arr.push(index)
    }
    for (let index = 1; index <= q; index++) {
      arr2.push(index)
    }
    this.moon_list = arr.reverse()
    this.quarter_list = arr2.reverse()
    getSelectDutiesList({ firstAdmin: this.firstAdmin }).then(res => {
      this.options1 = res.data.data.groupList
    }).catch(error => {
      this.$message.error(error.response ? error.response.data.message : error.message)
    })
    this.getAdminList({ firstAdmin: this.firstAdmin })
    getSelectTimeList().then(res => {
      this.options3 = res.data.data.day_list
    }).catch(error => {
      this.$message.error(error.response ? error.response.data.message : error.message)
    })
  }
}
</script>
<style lang="less" scoped>
/deep/.ant-table td { white-space: nowrap; }
.icon-select /deep/.ant-select-selection--single .ant-select-selection__rendered {
    margin-right: 40px;
}

.question-icon{
    position: relative;
    // left: -50px;
    right: 28px;
    top: -1px;
}
.border{
    box-shadow: 0px 5px 15px 0px rgba(223, 226, 230, 0.8);
    border-radius: 4px;
}
/deep/.ant-popover{
    z-index: 1100;
}
.details{
    padding-top:30px;
    /deep/.ant-table-thead > tr  th{
        background: #f8f8f8 !important;
        color:#bbb;
        border-right: 1px #fff solid;
        border-bottom: 1px #fff solid;
        padding-left: 20px !important;
        padding-right: 20px !important;
    }
    /deep/ .ant-table-tbody > tr  td{
         padding-left: 20px !important;
         padding-right: 20px !important;
    }
}
.marginB10 .task-num{
    margin-right: 10px;
    color: #bbb;
}
.progress{
    display: flex;
    white-space: nowrap;
    /deep/.ant-progress-text{
        color:#999999;
    }
    /deep/.ant-progress-inner{
        background: rgba(55, 142, 239, .2);
    }
    .progress-num{
        color:#999999;
        margin-right: 4px;
        width: 20px;
    }
}
.iconfont{
    color: #666;
}
.table-title{
    position: relative;
    .iconfont{
        position: absolute;
            top: 1px;
            right: -36px;
    }
}
/deep/.ant-popover-inner-content{
        padding: 10px;
    }
    .box{
        padding:20px;
        background:#fff;
        overflow: auto;
         /deep/  .ant-select-selection--multiple .ant-select-selection__rendered{
            margin-right: 20px;
        }

    }
    .short-line{
        display: inline-block;
        width: 1px;
        height: 22px;
        vertical-align: -4px;
        background: #EEEEEE;
        margin: 0 20px;
    }
    .upload_box {
        width: 100%;
        display: flex;
        padding: 10px 0 0 0;
    }
    .popup_opinion_submit_file > span {
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
    .list{
        background:#fff;
        margin-bottom:20px;
        overflow: hidden;
        ul > li{
            float: left;
            padding: 30px 0;
            border-right:1px #eeeeee solid;
            text-align: center;
        }
        .title{
            color: #999999;
            margin-bottom: 20px;
            .iconfont{
                vertical-align: middle;
            }
        }
        .number{
            font-size: 20px;
            color:#333;
            margin-bottom: 10px;
            font-weight: bold;
        }
    }
    .box .top{
        padding-bottom:20px;
        font-size: 16px;
        font-weight: bold;
        color: #333333;
        border-bottom: 1px #eeeeee solid;
    }
    .box .line-chart{
        position: relative;
        width: 50%;
        // overflow-x: auto;
        float: left;
        border-right: 1px #eeeeee solid;
        border-bottom: 1px #eeeeee solid;
        p{
            position: absolute;
            width: 100%;
            left: 0;
            top: 20px;
            z-index: 100;
        }
    }
</style>
