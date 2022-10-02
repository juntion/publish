<template>
  <div>
    <!-- 更新状态弹框 -->
    <a-modal title="更新状态"
             v-model="visible"
             @cancel="cancel"
             :maskClosable="false"
             @ok="handleOk"
             :confirmLoading="btnLoading"
             width="380px"
             okText="确定">
      <div class="mb">状态</div>
      <a-select class="mb"
                v-model="projectStatus.status"
                style="width: 100%">
        <a-select-option :value="1">开启</a-select-option>
        <a-select-option :value="0">关闭</a-select-option>
        <a-select-option :value="2">暂停</a-select-option>
        <a-select-option :value="3">完成</a-select-option>
        <a-select-option :value="4">取消</a-select-option>
      </a-select>
      <div class="mb"><span style="color:red">*</span> {{projectStatus.status===3? '项目总结报告文件' : '备注'}}</div>
      <a-form :form="form">
        <a-form-item v-if="projectStatus.status!==3">
          <a-textarea v-decorator="[
                    'comment',
                    { rules: [{ required: true, message: '请填写备注' }] },
                    ]"
                      placeholder="请输入备注"
                      :autosize="{ minRows: 3, maxRows: 6 }"
                      class="mb" />
        </a-form-item>
        <a-form-item v-else :validate-status="validateStatus.media"
                       :help="validateStatus.mediaTxt">
                 <a-input :value="file.name"
                        style="width:250px;margin-right:10px"
                         disabled />
                  <a-upload :showUploadList="false"
                          :beforeUpload="(file) => beforeUpload(file)">
                  <a-button size="small">选择文件</a-button>
                </a-upload>
          </a-form-item>
      </a-form>
    </a-modal>
    <div class="header">

        <span>

            <a-input-search placeholder="输入关键字搜索"
                            style="width: 420px"
                            @search="onSearch" />
            <span class="more">
            <mySearch @search="moreSearch" ref="search"></mySearch>
            </span>
        </span>
         <a-button type="primary"
                class="btn"
                v-if="canDo('pm.projects.daily')"
                @click="toPro1">
        <a-icon type="plus" />创建日常项目</a-button>
        <a-button type="primary"
                class="btn"
                @click="toPro2"
                v-if="canDo('pm.projects.major')"
                style="right:146px">
        <a-icon type="plus" />创建重点项目</a-button>

    </div>
    <div class="box">
      <div class="left1">
        <div class="title">
          <div style="margin-right:40px;">
            <h1>hi,{{userName}},以下是你的项目情况,请查看:</h1>
          </div>
          <div style="margin-right:20px;">
            <i class="line1"></i>
          </div>
          <div>
            <a-select defaultValue="participant"
                      style="width: 120px"
                      @change="ChangeCount">
              <a-select-option value="participant">我参与的</a-select-option>
              <a-select-option value="attentionAble.user_id">我关注的</a-select-option>
              <a-select-option value="promulgator_id">我发布的</a-select-option>
              <a-select-option value="all">所有项目</a-select-option>
            </a-select>
          </div>
        </div>
        <div>

        </div>
        <div style="display:flex">
          <div class="con" style="padding-top: 30px;">
            <ul>
              <li v-for="(item,index) in projectCounts"
                  :key="index">
                <div style="float: left;margin-right:13px;">
                  <img :src="require('@/assets/images/icon'+item.status+'.png')">
                </div>
                <div style="float: left;">
                  <p class="p1">{{item.name}}</p>
                  <p class="p2">{{item.count}}</p>
                </div>
              </li>

            </ul>

          </div>
          <div>
            <i class="line"></i>
          </div>
          <div class="tu">
            <myCharts :chartsData="projectCounts"></myCharts>
          </div>
        </div>

      </div>
      <div class="right1">
        <div class="title">
          <h1>动态</h1>
          <div style="padding-left:3px">
            <a-badge :count="logData.total" />
          </div>
          <!-- <a-badge count="5" /> -->
        </div>
        <div style="height: 190px;overflow-y:auto;">
            <a-timeline>
              <div v-for="(item,index) in logData.dynamicLog"
                   :key='index'>
                <a-timeline-item color="rgba(238,238,238,1)"
                                 class="timeLine">
                  <span class="time">{{item.created_at}}</span> {{item.description}}
                </a-timeline-item>
              </div>
            </a-timeline>
        </div>
      </div>
    </div>
    <div class="box2">
      <div class="header2">
        <h1 style="margin-right:40px;">项目</h1>
        <i class="line1"
           style="margin-right:20px;"></i>
        <div style="margin-right:10px;">
          <a-select v-model="searchData.myProject"
                    style="width: 120px"
                    @change="handleChange">
            <a-select-option value="participant">我参与的</a-select-option>
            <a-select-option value="attentionAble.user_id">我关注的</a-select-option>
            <a-select-option value="promulgator_id">我发布的</a-select-option>
            <a-select-option value="all">所有项目</a-select-option>
          </a-select>
        </div>
        <div style="margin-right:30px;">
          <a-select style="width: 120px"
                    v-model="searchData.type"
                    @change="handleChange">
            <a-select-option :value="1">重点项目</a-select-option>
            <a-select-option :value="0">日常项目</a-select-option>
            <a-select-option :value="3">所有项目</a-select-option>
          </a-select>
        </div>
        <div style="padding-top: 21px;">
          <a-tabs v-model="searchData.status"
                  size="large">
            <a-tab-pane tab="开启中"
                        :key="1"></a-tab-pane>
            <a-tab-pane tab="关闭中"
                        :key="0"></a-tab-pane>
            <a-tab-pane tab="暂停中"
                        :key="2"></a-tab-pane>
            <a-tab-pane tab="已完成"
                        :key="3"></a-tab-pane>
            <a-tab-pane tab="已撤销"
                        :key="4"></a-tab-pane>
            <a-tab-pane tab="所有的"
                        :key="5"></a-tab-pane>
          </a-tabs>
        </div>
      </div>
      <!-- 项目 -->
      <div class="body2">
        <ul>
          <li style="position: relative;">
              <div class="myProjects1"
                   style="overflow-y:auto;"
                   v-infinite-scroll="load"
                   :infinite-scroll-disabled="disabled">
                <p v-for="(item,index) in projectsData.projectList"
                   :key="index"
                   @click="msgShow(index,item.id)">
                  <i class="active-l"
                     v-show="activeIndex===index"></i>
                  <span class="content">
                    <span>
                         <span class="level"
                         style="vertical-align: middle;"
                          v-if="item.level==='S'">{{item.level}}</span>
                        <span class="level level-AB"
                            style="vertical-align: middle;"
                            v-if="item.level==='A'">{{item.level}}</span>
                        <span class="level level-AB"
                           style="vertical-align: middle;"
                            v-if="item.level==='B'">{{item.level}}</span>
                        <span class="level level-CD"
                            style="vertical-align: middle;"
                            v-if="item.level==='C'">{{item.level}}</span>
                        <span class="level level-CD"
                            style="vertical-align: middle;"
                            v-if="item.level==='D'">{{item.level}}</span>
                    </span>
                   {{item.name}}
                  </span>
                  <span class="right"
                        @click="toDemand(item.id,item.name)">
                    <a-icon type="arrow-right"
                            class="rightArry" />
                  </span>
                </p>
                <a-spin v-if="loading"
                        class="loading" />
                <p v-if="noMore"
                   style="margin-top:10px;font-size:13px;color:#ccc">没有更多了</p>
              </div>
              <span class="total">共{{projectsData.total}}条</span>
          </li>
          <li>
            <div class="myProjects2"
                 v-if="projectDetails">
              <div class="top">
                <div style="margin-bottom: 10px;display: flex;align-items: center;">
                  <span class="imPro"
                        v-if="projectDetails.type===1">重点项目</span>
                  <span class="dailyPro"
                        v-if="projectDetails.type===0">日常项目</span>
                  <span class="proName">{{projectDetails.name}}</span>

                  <div class="actions">
                    <span class="iconfont fz12 ml10 color1"
                          v-if="projectDetails.policies.updateStatus"
                          title="更新状态"
                          @click="visible=true">&#xe645;</span>
                    <span class="iconfont fz12 ml10 color1"
                          title="编辑"
                          v-if="projectDetails.policies.updateProject"
                          @click="goEdit(projectDetails.id)">&#xe637;</span>
                    <span @click="attention(projectDetails.id)"
                          class="ml10">
                      <span v-if="projectDetails.is_attention"
                            class="iconfont sign"
                            style="font-size:14px">&#xe64f;</span>
                      <span v-else
                            style="color: #bbb;font-size:14px"
                            class="iconfont">&#xe64f;</span>
                    </span>
                  </div>
                </div>
                <div>
                  <span title="项目级别"
                        style="cursor: pointer;">
                    <span class="level"
                          v-if="projectDetails.level==='S'">{{projectDetails.level}}</span>
                    <span class="level level-AB"
                          v-if="projectDetails.level==='A'">{{projectDetails.level}}</span>
                    <span class="level level-AB"
                          v-if="projectDetails.level==='B'">{{projectDetails.level}}</span>
                    <span class="level level-CD"
                          v-if="projectDetails.level==='C'">{{projectDetails.level}}</span>
                    <span class="level level-CD"
                          v-if="projectDetails.level==='D'">{{projectDetails.level}}</span>
                  </span>
                  <span class="short-line"></span>

                  <span class="star"
                        title="项目难度">
                    <span v-if="projectDetails.difficulty===5"><span class="iconfont"
                            v-for="k in projectDetails.difficulty"
                            :key="k"
                            style="font-size:12px;color:rgba(255, 74, 74, 1)">&#xe641;</span></span>
                    <span v-if="projectDetails.difficulty===4"><span class="iconfont"
                            v-for="k in projectDetails.difficulty"
                            :key="k"
                            style="font-size:12px;color:rgba(248, 141, 73, 1)">&#xe641;</span></span>
                    <span v-if="projectDetails.difficulty===3"><span class="iconfont"
                            v-for="k in projectDetails.difficulty"
                            :key="k"
                            style="font-size:12px;color:rgba(248, 141, 73, 1)">&#xe641;</span></span>
                    <span v-if="projectDetails.difficulty===2"><span class="iconfont"
                            v-for="k in projectDetails.difficulty"
                            :key="k"
                            style="font-size:12px;color:rgba(254, 188, 46, 1)">&#xe641;</span></span>
                    <span v-if="projectDetails.difficulty===1"><span class="iconfont"
                            v-for="k in projectDetails.difficulty"
                            :key="k"
                            style="font-size:12px;color:rgba(254, 188, 46, 1)">&#xe641;</span></span>
                  </span>
                  <span class="short-line"></span>
                  <span style="color:rgba(55, 142, 239, 1);position: relative;top: -2px;cursor: pointer;"
                        @click="toDetails(projectDetails.id)">{{projectDetails.number}}</span>
                  <!-- <span class="date" v-if="projectDetails.remaining_days">
                    <span v-if="projectDetails.remaining_days>0 || projectDetails.remaining_days==0">还剩{{projectDetails.remaining_days}}天</span>
                    <span v-if="projectDetails.remaining_days<0" style="color:#FF4A4A;">超时{{Math.abs(projectDetails.remaining_days)}}天</span>
                  </span> -->
                  <span class="date" style="color:#666;">{{projectDetails.expiration_date}}</span>
                </div>
              </div>
              <div class="content">
                <div class="info">
                  <p style="margin-bottom:10px">项目负责人 <span class="iconfont" style="font-size:12px;cursor: pointer;" title="该负责人指几个系统部门的统筹人员，非公司指定的项目经理">&#xe640;</span> : </p>
                  <div class="Mperson">
                    <img src="@/assets/images/charge.png"
                         class="charge">
                    <a-avatar :size="30"
                              icon="user"
                              class="avatar" /><span>{{projectDetails.principal_user_name}}</span>
                  </div>
                </div>
                <div class="info">
                  <!-- <p style="margin-bottom:10px">项目备注: <span v-if="!projectDetails.comment">暂无数据</span></p> -->
                  <p v-if="projectDetails.comment">{{projectDetails.comment}}</p>

                </div>
                <div class="info">
                  <p style="margin-bottom:10px">指定负责人: <span v-if="!projectDetails.project_principals.length">暂无数据</span></p>
                  <span v-for="k in projectDetails.project_principals"
                        :key="k.id">
                    <a-popover placement="bottomLeft"
                               arrowPointAtCenter>
                      <template slot="content">
                        <div style="max-width:300px">
                          <div class="c-Mperson"
                               v-for="(item,index) in projectDetails.project_principals"
                               :key="index">
                            <a-avatar :size="30"
                                      icon="user"
                                      class="avatar" /><span style="margin-left:10px;">{{item.user_name}}
                              <span v-if="item.type===0">（产品）</span>
                              <span v-if="item.type===1">（设计）</span>
                              <span v-if="item.type===2">（开发）</span>
                              <span v-if="item.type===3">（业务）</span>
                              <span v-if="item.type===4">（测试）</span>
                            </span>
                          </div>
                        </div>
                      </template>
                      <a-avatar :size="30"
                                icon="user"
                                class="avatar" />
                    </a-popover>
                  </span>
                </div>
                <div class="info">
                  <p style="margin-bottom:10px">需要关注: <span v-if="!projectDetails.user_attentions.length">暂无数据</span></p>
                  <span v-for="k in projectDetails.user_attentions"
                        :key="k.id">
                    <a-popover placement="bottomLeft"
                               arrowPointAtCenter>
                      <template slot="content">
                        <div style="max-width:300px">
                          <div class="c-Mperson"
                               v-for="(item,index) in projectDetails.user_attentions"
                               :key="index">
                            <a-avatar :size="30"
                                      icon="user"
                                      class="avatar" /><span style="margin-left:10px;">{{item.user_name}}</span>
                          </div>
                        </div>
                      </template>
                      <a-avatar :size="30"
                                icon="user"
                                class="avatar" />
                    </a-popover>
                  </span>
                </div>
              </div>
              <div class="content">
                <p>项目描述： </p>
                <br>
                <div class="info ellipsis eidt-p"
                     v-html="projectDetails.contents">
                  {{projectDetails.contents}}
                </div>
              </div>
              <div style="padding:20px 0">
                <div class="info">
                  <p style="margin-bottom:10px">URL/共享: <span v-if="!projectDetails.shared_address">暂无数据</span></p>
                  <div v-if="projectDetails.shared_address">
                        <div class="url"
                       v-for="(url,index) in projectDetails.shared_address"
                       :key="index">
                    <a style="line-height: 18px;" :href="url" target="_blank">{{url}}</a>
                  </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="myProjects2"
                 v-else>暂无数据</div>
          </li>
          <li>
              <div class="myProjects3">
                <div style="height:34px;border-bottom: 1px solid rgba(238,238,238,1);margin-bottom:30px;">
                  <h1>需求</h1>
                </div>
                <div class="demand">
                  <div class="leftChart">
                    <myCharts :charName="'myChart2'"
                              :chartType="2"
                              :chartsData="demand.status_count"></myCharts>
                  </div>
                  <div class="rightBox">
                    <a-progress type="circle"
                                :percent="demand.completed_count/demand.total_count *100"
                                style="margin-right:30px;">
                      <template v-slot:format="percent">
                        <span style="color:#378EEF;font-size:30px;">{{Math.round(percent)}}<span style="font-size:12px;color:rgba(55, 142, 239, 1);">%</span>
                          <p style="color: rgba(187,187,187,1);font-size:12px;margin-top:10px;">闭环率</p>
                        </span>
                      </template>
                    </a-progress>
                    <div style="margin-right:50px;">
                      <div style="margin-bottom:7px"> <span class="num1">{{demand.completed_count}}</span>/{{demand.total_count}}个 </div>
                      <span class="txt">已完成</span>
                    </div>
                    <div style="margin-right:50px;">
                      <div style="margin-bottom:7px"><span class="num1">{{demand.average_period}}</span> 天 </div>
                      <span class="txt">平均周期</span>
                    </div>
                    <div>
                      <div style="margin-bottom:7px"> <span class="num2">{{demand.overdue_count}}</span> 个 </div>
                      <span class="txt">超期</span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- 需求燃尽图 -->
              <!-- <div class="myProjects3" style="height: 381px;">
                                <div style="height:34px;border-bottom: 1px solid rgba(238,238,238,1);margin-bottom:30px;">
                                        <h1>需求燃尽图</h1>
                                </div>
                                <div>
                                    <lineChart></lineChart>
                                </div>
                            </div> -->

              <!-- 任务 -->
              <div class="myProjects3"
                   style="height: 255px;">
                <div style="height:34px;border-bottom: 1px solid rgba(238,238,238,1);margin-bottom:30px; position: relative;">
                  <h1>任务</h1>
                  <div class="complete">
                    <!-- <a-radio-group name="radioGroup" :defaultValue="1">
                                                <a-radio :value="1">已完成</a-radio>
                                                <a-radio :value="2">总数</a-radio>
                                            </a-radio-group> -->
                    <span style="margin-right:16px"> <i class="radio1 active"></i> 已完成</span>
                    <span> <i class="radio1"></i> 总数</span>
                  </div>
                </div>
                <div>
                  <div style="display:flex;align-items:center;margin-bottom:30px">
                    <div style="margin-right:10px">设计任务</div>
                    <div style="width:300px;margin-right:40px">
                      <a-progress :percent="Math.round(task.design.completed_count/task.design.total_count *100)" />
                    </div>
                    <div style="margin-right:40px"> <span class="text">已完成数量</span><span class="num-1">{{task.design.completed_count}}</span>/{{task.design.total_count}}个</div>
                    <div style="margin-right:40px"> <span class="text">平均周期 </span><span class="num-1">{{task.design.average_period}}</span>天</div>
                    <div><span class="text"> 超期</span><span class="num-2">{{task.design.overdue_count}}</span>个</div>
                  </div>
                  <div style="display:flex;align-items:center;margin-bottom:30px">
                    <div style="margin-right:10px">开发任务</div>
                    <div style="width:300px;margin-right:40px">
                      <a-progress :percent="Math.round(task.dev.completed_count/task.dev.total_count *100)" />
                    </div>
                    <div style="margin-right:40px"> <span class="text">已完成数量</span><span class="num-1">{{task.dev.completed_count}}</span>/{{task.dev.total_count}}个</div>
                    <div style="margin-right:40px"> <span class="text">平均周期 </span><span class="num-1">{{task.dev.average_period}}</span>天</div>
                    <div><span class="text"> 超期</span><span class="num-2">{{task.dev.overdue_count}}</span>个</div>
                  </div>
                  <div style="display:flex;align-items:center;margin-bottom:30px">
                    <div style="margin-right:10px">测试任务</div>
                    <div style="width:300px;margin-right:40px">
                      <a-progress :percent="Math.round(task.test.completed_count/task.test.total_count *100)" />
                    </div>
                    <div style="margin-right:40px"> <span class="text">已完成数量</span><span class="num-1">{{task.test.completed_count}}</span>/{{task.test.total_count}}个</div>
                    <div style="margin-right:40px"> <span class="text">平均周期 </span><span class="num-1">{{task.test.average_period}}</span>天</div>
                    <div><span class="text"> 超期</span><span class="num-2">{{task.test.overdue_count}}</span>个</div>
                  </div>
                </div>
              </div>

          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<style lang="less" scoped>
/deep/.ant-timeline-item-tail{
    top:7px;
}
/deep/.ant-tabs-nav .ant-tabs-tab {
  margin: 0;
}

/deep/.ant-tabs .ant-tabs-large-bar .ant-tabs-tab {
  padding: 16px 10px;
}
.ellipsis {
  height: 193px;
  overflow-y: scroll;
//   text-overflow: ellipsis;
//   display: -webkit-box;
//   -webkit-box-orient: vertical;
//   -webkit-line-clamp: 10;
}

.c-Mperson {
  background: #eeeeee;
  margin-right: 12px;
  margin-bottom: 10px;
  display: inline-block;
  padding-right: 10px;
  height: 34px;
  border-radius: 17px;
  line-height: 34px;
  .avatar {
    position: relative;
    left: 2px;
    top: -2px;
    margin-bottom: 0 !important
  }
}
.color1 {
  color: #378eef;
}
.mb{
    margin-bottom: 10px;
}
.sign {
  color: #febc2e;
}
.ml10 {
  margin-left: 10px;
  cursor: pointer;
}
.fz12 {
  font-size: 12px;
}
.complete {
  position: absolute;
  right: 0;
  top: 0;
  .radio1 {
    display: inline-block;
    width: 6px;
    height: 6px;
    background: #378eef;
    opacity: 0.2;
    border-radius: 50%;
  }
  .active {
    opacity: 1;
  }
}
.star {
  position: relative;
  top: -3px;
  cursor: pointer;
}
.shop-size {
  display: inline-block;
  width: 27px;
  height: 15px;
  background: #ff4a4a;
  border-radius: 7px;
  font-size: 10px;
  color: #fff;
  font-weight: 400;
  text-align: center;
  line-height: 12px;
  position: relative;
  top: 0;
  left: 4px;
}
.line1 {
  display: inline-block;
  width: 1px;
  height: 32px;
  background: rgba(238, 238, 238, 1);
}
.text {
  font-size: 12px;
  font-family: Microsoft YaHei;
  font-weight: 400;
  color: rgba(187, 187, 187, 1);
}
.num-1 {
  margin-left: 10px;
  font-size: 18px;
  font-family: Microsoft YaHei;
  font-weight: 400;
  color: rgba(55, 142, 239, 1);
}
.num-2 {
  margin-left: 10px;
  font-size: 18px;
  font-family: Microsoft YaHei;
  font-weight: 400;
  color: rgba(255, 74, 74, 1);
}
.short-line {
  display: inline-block;
  margin: 0 10px;
  width: 1px;
  height: 14px;
  background: rgba(238, 238, 238, 1);
}
.myProjects2 {
  box-sizing: border-box;
  background-color: #fff;
  padding: 20px;
  // width: 100%;
  width: 406px;
  height: 100%;
  .url {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  .content {
    border-bottom: 1px solid rgba(238, 238, 238, 1);
    box-sizing: border-box;
    padding: 20px 0;

    .info {
      word-break: break-all;
      margin-bottom: 20px;
    }
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
      position: relative;
      .charge {
        position: absolute;
        left: 16px;
        bottom: 2px;
        z-index: 10;
        width: 14px;
        height: 14px;
      }
      .avatar {
        // margin-left: 2px;
        margin-right: 10px;
        vertical-align: middle;
        margin-bottom: 2px;
      }
    }
  }
  .top {
    position: relative;
    height: 62px;
    border-bottom: 1px solid rgba(238, 238, 238, 1);
    .imPro {
      display: inline-block;
      text-align: center;
      line-height: 18px;
      width: 55px;
      height: 18px;
      background: rgba(255, 74, 74, 0.2);
      margin-right: 4px;
      border-radius: 2px;
      font-size: 12px;
      color: rgba(255, 74, 74, 1);
    }
    .dailyPro {
      display: inline-block;
      text-align: center;
      line-height: 18px;
      width: 55px;
      height: 18px;
      background: rgba(55, 142, 239, 0.2);
      margin-right: 4px;
      border-radius: 2px;
      font-size: 12px;
      color: rgba(55, 142, 239, 1);
    }
    .proName {
      display: inline-block;
      max-width: 216px;
      font-size: 14px;
      font-family: Microsoft YaHei;
      font-weight: bold;
      color: rgba(51, 51, 51, 1);
        max-width:216px;
        overflow: hidden;
        text-overflow:ellipsis;
        white-space: nowrap;
        display: inline-block;

    }
    .actions {
      position: absolute;
      right: 0;
      top: 0;
      height: 14px;
      border-left: 1px solid rgba(238, 238, 238, 1);
    }

    .date {
      color: rgba(248, 141, 73, 1);
      position: absolute;
      right: 0;
    }
  }
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
      position: relative;
      top: -2px;
    }
    .level-AB {
      background: rgba(248, 141, 73, 0.2);
      color: rgba(248, 141, 73, 1);
    }
    .level-CD {
      background: rgba(254, 188, 46, 0.2);
      color: rgba(254, 188, 46, 1);
    }
.myProjects3 {
  margin-bottom: 20px;
  box-sizing: border-box;
  padding: 20px;
  background-color: #fff;
  width: 100%;
  height: 292px;
  box-shadow: 0px 1px 2px 0px rgba(223, 226, 230, 0.8);
  border-radius: 3px;
  .demand {
    display: flex;
      align-items: center;
    .leftChart {
        position: relative;
      width: 400px;
      /*border-right: 1px solid rgba(238, 238, 238, 1);*/
        &:after{
            content:'';
            display: block;
            width:1px;
            height:168px;
            background:rgba(238, 238, 238, 1);
            position: absolute;
            top: 8px;
            right: 0px;
        }
    }

    .rightBox {
      flex: 1;
      padding-left: 30px;
      // padding-top: 20px;
      display: flex;
      align-items: center;
      .num1 {
        font-size: 30px;
        font-family: Microsoft YaHei;
        font-weight: 400;
        color: rgba(55, 142, 239, 1);
      }
      .num2 {
        font-size: 30px;
        font-family: Microsoft YaHei;
        font-weight: 400;
        color: rgba(255, 74, 74, 1);
      }
      .txt {
        font-size: 12px;
        font-family: Microsoft YaHei;
        font-weight: 400;
        color: rgba(187, 187, 187, 1);
      }
    }
  }
  .xqMap {
    box-sizing: border-box;
    height: 381px;
    background: rgba(255, 255, 255, 1);
    box-shadow: 0px 1px 2px 0px rgba(223, 226, 230, 0.8);
    border-radius: 3px;
    padding: 20px;
    width: 100%;
  }
}
.myProjects1 {
  box-sizing: border-box;
  padding-bottom: 20px;
  // overflow-y: auto;
  width: 100%;
  height: 776px;
  p {
    overflow: hidden; /*超出部分隐藏*/
    white-space: nowrap; /*不换行*/
    text-overflow: ellipsis; /*超出部分省略号显示*/
    cursor: pointer;
    position: relative;
    padding: 0 20px;
    margin-right: 16px;
    height: 32px;
    line-height: 32px;
    font-size: 12px;
    font-family: Microsoft YaHei;
    font-weight: 400;
    color: rgba(85, 85, 85, 1);
    .content {
      display: inline-block;
      max-width: 218px;
      overflow: hidden; /*超出部分隐藏*/
      white-space: nowrap; /*不换行*/
      text-overflow: ellipsis; /*超出部分省略号显示*/
    }
    .active-l {
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 3px;
      height: 16px;
      background: rgba(55, 142, 239, 1);
    }
    //鼠标移入右箭头
    .right {
      text-align: center;
      position: absolute;
      top: 0;
      right: 0;
      width: 32px;
      height: 32px;
      line-height: 32px;
      background: rgba(187, 187, 187, 1);
      display: none;
    }
    .rightArry {
      color: rgba(55, 142, 239, 1);
    }
    //鼠标移入样式
    &:hover {
      background: rgba(238, 238, 238, 1);
    }
    &:hover .right {
      display: block;
    }
  }
}
.time {
  position: absolute;
  top: 0;
  left: -144px;
}
.timeLine {
  position: relative;
  margin-left: 145px;
}
.title {
  display: flex;
  align-items: center;
  height: 54px;
  border-bottom: 1px solid RGBA(239, 239, 239, 1);
  margin-bottom: 20px;
}
.line {
  width: 1px;
  height: 168px;
  background: rgba(238, 238, 238, 1);
  display: inline-block;
    position: relative;
    top: 18px;
}
h1 {
  font-size: 16px;
  font-family: Microsoft YaHei;
  font-weight: bold;
  color: rgba(51, 51, 51, 1);
}
.searchMore {
  position: absolute;
  top: 40px;
  left: -220px;
  width: 570px;
  height: 293px;
  background-color: #fff;
  z-index: 11;
}
.header {
  height: 48px;
  position: relative;
  margin-bottom: 30px;
  text-align: center;
  .more {
    position: relative;
    cursor: pointer;
    margin-left: 4px;
    margin-right: 4px;
    width: 24px;
    height: 11px;
    font-size: 12px;
    font-family: Microsoft YaHei;
    font-weight: 400;
    color:#378EEF;
    line-height: 48px;
  }
  .btn {
    margin-top: 6px;
    position: absolute;
    right: 0;
  }
}
.box {
  margin-bottom: 30px;
  display: flex;
  .left1 {
    // flex: 1;
    width: 50%;
    margin-right: 30px;
    line-height: 1;
    padding: 0 20px;
    background: rgba(255, 255, 255, 1);
    box-shadow: 0px 5px 15px 0px rgba(223, 226, 230, 0.8);
    border-radius: 4px;
  }
  .right1 {
    line-height: 1;
    flex: 1;
    padding: 0 20px;
    background: rgba(255, 255, 255, 1);
    box-shadow: 0px 5px 15px 0px rgba(223, 226, 230, 0.8);
    border-radius: 4px;
    .ant-timeline {
      padding-top: 5px;
    }
    .title {
      .num {
        padding: 4px;
        margin-left: 10px;
        height: 14px;
        background: rgba(255, 74, 74, 1);
        border-radius: 7px;
        font-family: Microsoft YaHei;
        font-weight: 400;
        color: rgba(255, 255, 255, 1);
        line-height: 1;
        span {
          transform: scale(0.83);
        }
      }
    }
  }
}
.con {
  position: relative;
  box-sizing: border-box;
  padding-left: 20px;
  padding-top: 20px;
  width: 450px;
  overflow: hidden;
  li {
    float: left;
    width: 50%;
    margin-bottom: 50px;
    img {
      vertical-align: middle;
    }
    .p1 {
      height: 11px;
      font-size: 12px;
      font-family: Microsoft YaHei;
      font-weight: 400;
      color: rgba(187, 187, 187, 1);
      margin-bottom: 14px;
    }
    .p2 {
      height: 20px;
      font-size: 20px;
      font-family: Microsoft YaHei;
      font-weight: 400;
      color: rgba(85, 85, 85, 1);
    }
  }
}
.box2 {
  box-sizing: border-box;
  overflow-x: auto;
  padding: 0 20px;
  height: 900px;
  background: rgba(255, 255, 255, 1);
  box-shadow: 0px 5px 15px 0px rgba(223, 226, 230, 0.8);
  border-radius: 4px;
  .ant-tabs-nav .ant-tabs-tab-active,
  .ant-tabs-nav .ant-tabs-tab:hover {
    font-size: 12px;
  }
  /deep/div.ant-tabs-tab {
    font-size: 12px;
  }
  .header2 {
    display: flex;
    align-items: center;
    height: 54px;
    border-bottom: 1px solid RGBA(239, 239, 239, 1);
    margin-bottom: 20px;
  }
}
.body2 {
  .total {
    position: absolute;
    right: 0;
    bottom: 0;
    z-index: 100;
    color: #bbbbbb;
  }
  ul {
    display: flex;
  }
  li {
    height: 806px;
    margin-right: 20px;
  }
  li:nth-child(1) {
    width: 300px;
  }
  li:nth-child(2) {
    width: 446px;
    background-color: RGBA(249, 249, 249, 1);
    box-sizing: border-box;
    padding: 20px;
  }
  li:nth-child(3) {
    flex: 1;
    margin-right: 0;
    box-sizing: border-box;
    background-color: RGBA(249, 249, 249, 1);
    padding: 20px;
  }
}
.loading {
  margin-top: 10px;
  margin-left: 50px;
}
/deep/ .ant-timeline-item-head{
    background-color: rgb(238, 238, 238);
    top: -2px;
}
</style>
<style>
    .eidt-p p{
    line-height: 16px;
    }
    .eidt-p>p>a{
    line-height: 16px;
    }

</style>
<script>
import myCharts from './components/echarts'
import mySearch from './components/search'
import { canDo, filtering } from '@/plugins/common'
import { getAllprojects, getProjectLog, getProjectCounts, getProjectDetails, attentionProject, updateProjectStatus } from '@/api/RDmanagement/project'
import { allow, allowSize } from '@/plugins/common.js'
let search = []
let may = []
let must = []
export default {
  components: { myCharts, mySearch },
  data () {
    return {
      btnLoading: false,
      validateStatus: {
        media: 'success',
        mediaTxt: ''
      },
      file: '',
      form: this.$form.createForm(this, { name: 'coordinated' }),
      visible: false,
      projectStatus: {
        status: '',
        comment: ''
      },
      userName: JSON.parse(localStorage.getItem('user')).name,
      searchData: {
        myProject: 'all',
        type: 3,
        status: 5
      },
      projectDetails: { policies: {}, user_attentions: [], project_principals: [], shared_address: [] },
      task: { design: {}, dev: {}, test: {} },
      demand: {},
      projectsData: {
        projectList: [],
        total: '',
        page: 1,
        totalPages: null // 取后端返回内容的总页数
      },
      loading: false,
      logData: {
        dynamicLog: [],
        total: ''
      },
      projectCounts: [],
      showSearch: false,
      activeIndex: 0,
      sign: 1
    }
  },
  watch: {
    searchData: {
      handler (newValue, oldValue) {
        search['type'] = newValue.type
        search['status'] = newValue.status
        if (newValue.myProject === 'participant') {
          search['participant'] = JSON.parse(localStorage.getItem('user')).id
        } else {
          search['participant'] = undefined
        }
        if (newValue.myProject === 'attentionAble.user_id') {
          search['attentionAble.user_id'] = JSON.parse(localStorage.getItem('user')).id
        } else {
          search['attentionAble.user_id'] = undefined
        }
        if (newValue.myProject === 'promulgator_id') {
          search['promulgator_id'] = JSON.parse(localStorage.getItem('user')).id
        } else {
          search['promulgator_id'] = undefined
        }
        if (newValue.status === 5) {
          search['status'] = undefined
        }
        if (newValue.type === 3) {
          search['type'] = undefined
        }
        let params = { filters: search, limit: 30 }
        getAllprojects(params).then(res => {
          this.projectsData.projectList = res.data.data
          this.projectsData.total = res.data.total
          if (res.data.data.length !== 0) {
            let params = { statistics: 1 }
            getProjectDetails(this.projectsData.projectList[0].id, params).then(res => {
              var imgReg = /<img.*?(?:>|\/>)/gi
              this.projectDetails = res.data.project
              this.projectDetails.contents = this.projectDetails.contents.replace(imgReg, '')
              this.task = res.data.statistics.task
              this.demand = res.data.statistics.demand
              this.projectStatus.status = this.projectDetails.status
              this.demandCount()
            })
          } else {
            this.projectDetails = undefined
          }
        })
      },
      deep: true
    }
  },
  computed: {
    noMore () {
      // 当起始页数大于总页数时停止加载
      return this.projectsData.page >= this.projectsData.totalPages
    },
    disabled () {
      return this.loading || this.noMore
    }
  },
  methods: {
    canDo,
    filtering,
    // 高级搜索
    moreSearch (e) {
      may = []
      must = []
      filtering(e, may, must)
      let params = {
        may,
        must,
        limit: 30
      }
      getAllprojects(params).then(res => {
        this.$refs.search.showSearch = false
        this.projectsData.projectList = res.data.data
        this.projectsData.total = res.data.total
        if (res.data.data.length !== 0) {
          let params = { statistics: 1 }
          getProjectDetails(this.projectsData.projectList[0].id, params).then(res => {
            this.projectDetails = res.data.project
            var imgReg = /<img.*?(?:>|\/>)/gi
            this.projectDetails.contents = this.projectDetails.contents.replace(imgReg, '')
            this.task = res.data.statistics.task
            this.demand = res.data.statistics.demand
            this.projectStatus.status = this.projectDetails.status
            this.demandCount()
          })
        } else {
          this.projectDetails = ''
        }
      })
    },
    beforeUpload (file) {
      const size = file.size / (1024 * 1024)
      const name = file.name.substring(file.name.lastIndexOf('.'))
      if (size > allowSize) {
        this.$message.error('上传文件不得超过' + allowSize + 'm')
      } else if (allow.indexOf(name) === -1) {
        this.$message.error('上传文件格式不正确')
      } else {
        this.file = file
      }
      return false
    },
    cancel () {
      this.getDetails()
      this.form.resetFields()
      this.file = ''
    },
    handleOk (e) {
      //   console.log(e)
      this.form.validateFields((err, values) => {
        if (this.projectStatus.status === 3 && !this.file) {
          this.validateStatus.media = 'error'
          this.validateStatus.mediaTxt = '请选择文件'
        }
        if (!err) {
          if (this.projectStatus.status === 3 && this.file) {
            this.btnLoading = true
            const formData = new FormData()
            formData.append('status', this.projectStatus.status)
            formData.append('project_summary', this.file)
            updateProjectStatus(this.projectDetails.id, formData).then(res => {
              if (res.code === 200) {
                this.getDetails()
                this.$message.success('更新状态成功')
                this.form.resetFields()
                this.file = ''
                this.btnLoading = false
                this.visible = false
              }
            }).catch(error => {
              this.btnLoading = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          }
          if (this.projectStatus.status !== 3) {
            this.btnLoading = true
            this.projectStatus.comment = values.comment
            updateProjectStatus(this.projectDetails.id, this.projectStatus).then(res => {
              if (res.code === 200) {
                this.getDetails()
                this.$message.success('更新状态成功')
                this.form.resetFields()
                this.btnLoading = false
                this.visible = false
              }
            }).catch(error => {
              this.btnLoading = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          }
        }
      })
    },
    // 处理需求数据
    demandCount () {
      let arr = []
      let newArr = []
      this.demand.status_count.forEach(item => {
        if (item.status === 4) {
          newArr.push(item)
        } else if (item.status === 5) {
          newArr.push(item)
        } else if (item.status === 6) {
          newArr.push(item)
        } else if (item.status === 8) {
          newArr.push(item)
        } else if (item.status === 9) {
          newArr.push(item)
        } else {
          arr.push(item.count)
        }
      })
      newArr.push({ name: '其他', count: arr.reduce((a, b) => a + b, 0) })
      this.demand.status_count = newArr
      // console.log(this.demand.status_count)
    },
    load () {
      this.loading = true
      let page = this.projectsData.page += 1
      getAllprojects({ filters: search, page: page, limit: 30 }).then(res => {
        if (res.code === 200) {
          this.projectsData.totalPages = res.data.last_page
          this.projectsData.projectList.push(...res.data.data)
          this.loading = false
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    onSearch (value) {
      let params = {}
      if (value) {
        params = { 'search[keyword]': value.trim(), filters: search, limit: 30 }
      } else {
        params = { filters: search, limit: 30 }
      }
      getAllprojects(params).then(res => {
        this.projectsData.projectList = res.data.data
        this.projectsData.total = res.data.total
        if (res.data.data.length !== 0) {
          let params = { statistics: 1 }
          getProjectDetails(this.projectsData.projectList[0].id, params).then(res => {
            this.projectDetails = res.data.project
            var imgReg = /<img.*?(?:>|\/>)/gi
            this.projectDetails.contents = this.projectDetails.contents.replace(imgReg, '')
            this.task = res.data.statistics.task
            this.demand = res.data.statistics.demand
            this.projectStatus.status = this.projectDetails.status
            this.demandCount()
          })
        } else {
          this.projectDetails = ''
        }
      })
    },
    showMore () {
      this.showSearch = !this.showSearch
    },
    ChangeCount (e) {
      let search = []
      if (e === 'participant') {
        search['participant'] = JSON.parse(localStorage.getItem('user')).id
      } else {
        search['participant'] = undefined
      }
      if (e === 'attentionAble.user_id') {
        search['attentionAble.user_id'] = JSON.parse(localStorage.getItem('user')).id
      } else {
        search['attentionAble.user_id'] = undefined
      }
      if (e === 'promulgator_id') {
        search['promulgator_id'] = JSON.parse(localStorage.getItem('user')).id
      } else {
        search['promulgator_id'] = undefined
      }
      let params = { filters: search }
      // 更新项目数量
      getProjectCounts(params).then(res => {
        if (res.code === 200) {
          this.projectCounts = res.data.statistics
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    handleChange (value) {
    },
    toPro1 () {
      this.$router.push('dailyProjects')
    },
    toPro2 () {
      this.$router.push('keyProjects')
    },
    msgShow (index, id) {
      this.activeIndex = index
      // 获取当前项目详情
      let params = { statistics: 1 }
      getProjectDetails(id, params).then(res => {
        if (res.code === 200) {
          //   console.log(res.data)
          this.projectDetails = res.data.project
          var imgReg = /<img.*?(?:>|\/>)/gi
          this.projectDetails.contents = this.projectDetails.contents.replace(imgReg, '')
          this.task = res.data.statistics.task
          this.demand = res.data.statistics.demand
          this.projectStatus.status = this.projectDetails.status
          this.demandCount()
        }
      })
    },
    getDetails () {
      let params = { statistics: 1 }
      getProjectDetails(this.projectDetails.id, params).then(res => {
        if (res.code === 200) {
          this.projectDetails = res.data.project
          var imgReg = /<img.*?(?:>|\/>)/gi
          this.projectDetails.contents = this.projectDetails.contents.replace(imgReg, '')
          this.projectStatus.status = this.projectDetails.status
          this.task = res.data.statistics.task
          this.demand = res.data.statistics.demand
          this.demandCount()
        }
      })
    },
    toDetails (id) {
      this.$router.push({ name: 'proDetails', query: { id: id } })
    },
    toDemand (id, name) {
      this.$router.push({ name: 'projectDemandList', query: { id: id, name: name } })
    },
    goEdit (id) {
      this.$router.push({ name: 'editDailyProjects', query: { id: id } })
    },
    attention (id) {
      attentionProject(id).then(res => {
        if (res.code === 200) {
          //   console.log(res)
          this.projectDetails.is_attention = !this.projectDetails.is_attention
          if (this.projectDetails.is_attention) {
            this.$message.success('关注成功')
          } else {
            this.$message.error('取消关注')
          }
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    }
  },
  created () {
    if (localStorage.getItem('isReload3')) {
      this.$store.commit('changeGuide3', false)
    } else {
      this.$store.commit('changeGuide3', true)
      localStorage.setItem('isReload3', true)
    }
    let search = []
    // search['participant'] = JSON.parse(localStorage.getItem('user')).id
    // search['status'] = 1
    let params = { filters: search }
    // 获取项目
    getAllprojects({ limit: 30, ...params }).then(res => {
      if (res.code === 200) {
        this.projectsData.projectList = res.data.data
        this.projectsData.total = res.data.total
        this.projectsData.totalPages = res.data.last_page
        // 获取第一个项目详情
        if (res.data.data.length !== 0) {
          let params = { statistics: 1 }
          getProjectDetails(this.projectsData.projectList[0].id, params).then(res => {
            if (res.code === 200) {
              this.projectDetails = res.data.project
              // 去掉img标签
              var imgReg = /<img.*?(?:>|\/>)/gi
              this.projectDetails.contents = this.projectDetails.contents.replace(imgReg, '')
              this.task = res.data.statistics.task
              this.demand = res.data.statistics.demand
              this.projectStatus.status = this.projectDetails.status
              this.demandCount()
            }
          }).catch(error => {
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        } else {
          this.projectDetails = undefined
        }
      }
    }).catch(error => {
      this.$message.error(error.response ? error.response.data.message : error.message)
    })
    // 获取项目日志
    getProjectLog().then(res => {
      if (res.code === 200) {
        this.logData.dynamicLog = res.data.data
        this.logData.total = res.data.total
      }
    }).catch(error => {
      this.$message.error(error.response ? error.response.data.message : error.message)
    })
  },
  mounted () {
    search['participant'] = JSON.parse(localStorage.getItem('user')).id
    let params = { filters: search }
    search['status'] = undefined
    // 获取项目数量
    getProjectCounts(params).then(res => {
      if (res.code === 200) {
        this.projectCounts = res.data.statistics
      }
    }).catch(error => {
      this.$message.error(error.response ? error.response.data.message : error.message)
    })
  }

}
</script>
