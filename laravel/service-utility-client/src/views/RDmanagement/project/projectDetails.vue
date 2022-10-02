<template>
  <div>
    <div class="box">
      <div class="header">
        <h1>项目详情</h1>
        <a-dropdown :trigger="['click']"
                    placement='bottomCenter'>
          <span class="operation">
            <img src="@/assets/images/action-icon.png">
            <span class="cz">操作</span>
          </span>
          <a-menu slot="overlay"
                  style="width:120px;text-align: center;">
                  <!-- v-if="projectDetails.policies.updateStatus" -->
            <a-menu-item v-if="projectDetails.policies.updateStatus">
              <a @click="visible=true"><span class="iconfont fz12"
                      style="margin-right:10px">&#xe645;</span>更新状态</a>
            </a-menu-item>
             <a-menu-item  v-if="projectDetails.policies.projectSummary">
              <a @click="visible3=true"><span class="iconfont fz12"
                      style="margin-right:10px">&#xe645;</span>更新报告</a>
            </a-menu-item>
            <a-menu-item v-if="projectDetails.policies.updateProject">
              <a @click="goEdit(projectDetails.id)"><span class="iconfont fz12"
                      style="margin-right:10px">&#xe637;</span>编辑项目</a>
            </a-menu-item>
            <a-menu-item>
              <a @click="attention(projectDetails.id)">
                <span v-if="!projectDetails.is_attention"><span class="iconfont fz12"
                        style="margin-right:10px">&#xe64f;</span>标记关注 </span>
                <span v-else><span class="iconfont fz12 sign"
                        style="margin-right:10px">&#xe64f;</span> 取消关注 </span>
              </a>
            </a-menu-item>
          </a-menu>
        </a-dropdown>
      </div>
      <!-- 更新状态弹框 -->
      <a-modal title="更新状态"
               v-model="visible"
               :maskClosable="false"
               :confirmLoading="loading"
               @cancel="cancel"
               @ok="handleOk"
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

        <a-form :form="form" >
          <a-form-item v-if="projectStatus.status!==3">
            <a-textarea v-decorator="[
                    'comment',
                    { rules: [{ required: true, message: '请填写备注' }] },
                    ]"
                        placeholder="请输入备注"
                        :autosize="{ minRows: 3, maxRows: 6 }"
                        class="mb" />
            <!-- v-model="projectStatus.comment" -->
          </a-form-item>
           <a-form-item v-else :validate-status="validateStatus.media"
                       :help="validateStatus.mediaTxt">
                 <a-input :value="file.name"
                        placeholder="请选择文件"
                        style="width:258px;margin-right:10px"
                         disabled />
                  <a-upload :showUploadList="false"
                          :beforeUpload="(file) => beforeUpload(file)">
                  <a-button size="small">选择文件</a-button>
                </a-upload>
          </a-form-item>
        </a-form>

      </a-modal>
      <!-- 更新报告弹框 -->
        <a-modal title="更新报告"
               v-model="visible3"
               :maskClosable="false"
               :confirmLoading="loading2"
               @cancel="cancel2"
               @ok="handleOk2"
               width="380px"
               okText="确定">
        <div class="mb"><span style="color:red">*</span> 项目总结报告文件</div>

        <a-form>
           <a-form-item :validate-status="validateStatus.media"
                       :help="validateStatus.mediaTxt">
                 <a-input :value="file.name"
                        placeholder="请选择文件"
                        style="width:258px;margin-right:10px"
                         disabled />
                  <a-upload :showUploadList="false"
                          :beforeUpload="(file) => beforeUpload(file)">
                  <a-button size="small">选择文件</a-button>
                </a-upload>
          </a-form-item>
        </a-form>

      </a-modal>
      <!-- 操作记录弹框 -->
      <a-modal title="状态变动记录"
               class="logModal"
               v-model="visible2"
               width="746px">
        <a-table :columns="columns2"
                 :dataSource="data2"
                 :pagination="false">
          <div slot="status"
               slot-scope="status">
            <span v-if="status==='关闭中'"
                  style="color:#FF4A4A">关闭中</span>
            <span v-if="status==='开启中'"
                  style="color:#378EEF">开启中</span>
            <span v-if="status==='暂停中'"
                  style="color:#FEBC2E">暂停中</span>
            <span v-if="status==='已完成'"
                  style="color:#3DCCA6">已完成</span>
            <span v-if="status==='已撤销'"
                  style="color:#BBBBBB">已撤销</span>
          </div>
          <div slot="comment"
               class="comment"
               slot-scope="comment">
            {{comment}}</div>
        </a-table>
        <div slot="footer"></div>
      </a-modal>

      <div class="con">
        <div class="top">
          <span class="line"></span>
          <div style="margin-bottom: 10px;">
            <span class="imPro"
                  v-if="projectDetails.type===1">重点项目</span>
            <span class="dailyPro"
                  v-if="projectDetails.type===0">日常项目</span>
            <span class="proName" style="max-width: 58%;">{{projectDetails.name}}</span>
          </div>
          <div style="position: relative;">
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
            <span class="short-line"></span> <span style="color:rgba(55, 142, 239, 1)">{{projectDetails.number}}</span>
          </div>
          <div class="right">
            <div class="status">
              <p style="margin-bottom:17px">
                <span @click="visible2=true"
                      v-if="projectDetails.status===0"
                      style="color:rgba(255, 74, 74, 1);cursor: pointer;">关闭中</span>
                <span @click="visible2=true"
                      v-if="projectDetails.status===1"
                      style="color:rgba(55, 142, 239, 1);cursor: pointer;">开启中</span>
                <span @click="visible2=true"
                      v-if="projectDetails.status===2"
                      style="color:rgba(254, 188, 46, 1);cursor: pointer;">暂停中</span>
                <span @click="visible2=true"
                      v-if="projectDetails.status===3"
                      style="color:rgba(61, 204, 166, 1);cursor: pointer;">已完成</span>
                <span @click="visible2=true"
                      v-if="projectDetails.status===4"
                      style="color:rgba(187, 187, 187, 1);cursor: pointer;">已撤销</span>
              </p>
              <p><span>{{projectDetails.created_at}}</span></p>
            </div>
            <div style="float:right;padding-left:20px">
              <p style="margin-bottom:17px"><span style="color: rgba(248, 141, 73, 1);margin-right: 15px;"  v-if="projectDetails.remaining_days">
                    <span v-if="projectDetails.remaining_days>0 || projectDetails.remaining_days==0">还剩{{projectDetails.remaining_days}}天</span>
                    <span v-if="projectDetails.remaining_days<0" style="color:#FF4A4A;">超时{{Math.abs(projectDetails.remaining_days)}}天</span>
                </span></p>
              <p><span>{{projectDetails.expiration_date}}</span> <span v-if="!projectDetails.expiration_date">--</span> </p>
            </div>
          </div>
        </div>
      </div>
      <div class="con">
        <h3 style="margin-bottom: 30px"><i class="tabs-ico"></i>负责人信息</h3>
        <div class="info">
          <p style="margin-bottom:10px"
             class="p">项目负责人: </p>
          <div class="Mperson">
            <a-avatar :size="30"
                      icon="user"
                      class="avatar" /><span>{{projectDetails.principal_user_name}}</span>
          </div>
        </div>
        <div class="info">
          <p style="margin-bottom:10px"
             class="p">指定负责人: <span v-if="!projectDetails.project_principals.length">暂无数据</span></p>
          <div class="Mperson"
               style="background:rgba(238, 238, 238, 1)"
               v-for="(k,index) in projectDetails.project_principals"
               :key="index">
            <a-avatar :size="30"
                      icon="user"
                      class="avatar" /><span>{{k.user_name}}
              <span v-if="k.type===0">(产品)</span>
              <span v-if="k.type===1">(设计)</span>
              <span v-if="k.type===2">(开发)</span>
              <span v-if="k.type===3">(业务)</span>
              <span v-if="k.type===4">(测试)</span>
            </span>
          </div>
        </div>
        <div class="info">
          <p style="margin-bottom:10px"
             class="p">需要关注: <span v-if="!projectDetails.user_attentions.length">暂无数据</span></p>
          <div :class="{active:show}">
            <div class="Mperson"
                 style="background:rgba(238, 238, 238, 1)"
                 v-for="(k,index) in projectDetails.user_attentions"
                 :key="index">
              <a-avatar :size="30"
                        icon="user"
                        class="avatar" /><span>{{k.user_name}}({{k.dept_name}})</span>
            </div>
            <span class="closemore"
                  v-if="!show"
                  @click="closeMore">收起</span>
          </div>
          <span class="showmore"
                v-if="show && projectDetails.user_attentions.length>5"
                @click="showMore">更多</span>
          <!-- <div style="float:right">
            <a-avatar :size="30"
                      v-for="k in 4"
                      :key="k"
                      icon="user"
                      class="avatar" /> <span class="more">更多</span>
          </div> -->
        </div>
        <div class="info">
             <p style="margin-bottom:10px"
             class="p">所属产品: <span v-if="!projectDetails.products || !projectDetails.products.length">暂无数据</span></p>
             <span v-for="(item,index) in projectDetails.products" :key="index">
                 <span v-if="item.type===0">{{item.name}}</span><span v-if="item.type===1"  style="margin-right:10px">/{{item.name}};</span>
             </span>
        </div>

      </div>
      <div class="con">
        <h3 style="margin-bottom: 30px"><i class="tabs-ico"></i>项目描述</h3>
        <myViewer :html="projectDetails.contents"></myViewer>
      </div>
      <div class="con">
          <h3 style="margin-bottom: 30px"><i class="tabs-ico"></i>项目总结报告</h3>
          <a v-if="projectDetails.project_summary"  @click="downLoad(projectDetails.project_summary)" ><span class="iconfont icon">&#xe655;</span> <span class="download" :title="projectDetails.project_summary.name">{{projectDetails.project_summary.name}}</span><span style="color: #c8c5c8"> ({{parseInt(projectDetails.project_summary.size/1024)}}kb)</span></a>
      </div>
      <div class="con">
        <h3 style="margin-bottom: 30px"><i class="tabs-ico"></i>其他信息</h3>
        <div class="info">
          <p class="mb10 p">URL/共享: <span v-if="!projectDetails.shared_address">暂无数据</span></p>
          <div v-if="projectDetails.shared_address">
            <p v-for="(item,index) in projectDetails.shared_address"
               :key="index"
               class="mb10">
              <a style="line-height:18px;" :href="item" target="_blank" >{{item}}</a>
            </p>
          </div>

        </div>
        <div class="info">
          <p style="margin-bottom:10px"
             class="p">方案文档:
            <span @click="toggle"
                    class="cup fz12"
                    style="margin-left:20px"
                  v-if="docs.length>0">
              <span v-if="expand"
                    >收起 <span class="iconfont cup fz12" style="color:#BBBBBB">&#xe607;</span></span>
              <span v-else
                    >展开 <span class="iconfont cup fz12" style="color:#BBBBBB">&#xe605;</span></span>
            </span>
            <span v-else style="margin-left:20px">暂无数据</span>
          </p>
          <downMedia :media="docs"
                     v-if="docs.length>0"
                     v-show="expand"></downMedia>
        </div>
        <div class="info">
          <p style="margin-bottom:10px">附件:
            <span @click="toggle2"
                  class="cup fz12"
                  style="margin-left:20px"
                  v-if="projectDetails.media.length>0">
              <span v-if="expand2"
                    >收起 <span class="iconfont cup fz12" style="color:#BBBBBB">&#xe607;</span></span>
              <span v-else
                    >展开 <span class="iconfont cup fz12" style="color:#BBBBBB">&#xe605;</span></span>
            </span>
            <span v-else style="margin-left:20px">暂无数据</span>
          </p>
          <downMedia :media="projectDetails.media"
                     v-if="projectDetails.media.length>0"
                     v-show="expand2"></downMedia>
        </div>
      </div>
      <div class="con">
           <h3 style="margin-bottom: 30px"><i class="tabs-ico"></i>操作记录</h3>
           <operationLogs :data="projectDetails.operation_logs"></operationLogs>
      </div>
    </div>
  </div>
</template>
<style lang="less" scoped>
.active {
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 1;
  max-width: 1100px;
  -webkit-box-orient: vertical;
}
.download{
    max-width: 312px;
    display: inline-block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    vertical-align: top;
}
.closemore {
  color: #378eef;
  position: relative;
  cursor: pointer;
}
.showmore {
  color: #378eef;
  position: relative;
  cursor: pointer;
  top: -30px;
  left: 1100px;
}
.tabs-ico {
  display: inline-block;
  width: 15px;
  height: 20px;
  margin-right: 6px;
  background: url("../../../assets/images/tabs-01.png") no-repeat;
  background-position: 0px 8px;
}
.comment {
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
}
.icon{
     color: #fdb824;
      font-size: 12px;
      margin-right: 4px;
}
.sign {
  color: #febc2e;
}
.fz12 {
  font-size: 12px;
}
.mb {
  margin-bottom: 10px;
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

.more {
  margin-left: 10px;
  color: #378eef;
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
.star {
  position: relative;
  top: -2px;
  cursor: pointer;
}
h3 {
  font-size: 13px;
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
    position: relative;
    h1 {
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
    }
    .operation {
      cursor: pointer;
      position: absolute;
      right: 0;
      top: 50%;
      transform: translateY(-50%);
      .cz {
        margin-left: 4px;
        color: rgba(55, 142, 239, 1);
      }
    }
  }
}
.con {
  padding: 10px;
  margin-bottom: 10px;
  .top {
    position: relative;
    height: 62px;
    .right {
      position: absolute;
      right: 0;
      top: 0;
      height: 62px;
      .status {
        float: left;
        padding-right: 20px;
        border-right: 1px solid #eee;
      }
    }
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
        position: relative;
        top: -2px;
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
    .level-AB {
      background: rgba(248, 141, 73, 0.2);
      color: rgba(248, 141, 73, 1);
    }
    .level-CD {
      background: rgba(254, 188, 46, 0.2);
      color: rgba(254, 188, 46, 1);
    }
    .date {
      position: absolute;
      right: 0;
      top: 0;
    }
  }
}
.info {
  word-break: break-all;
  margin-bottom: 20px;
  .p {
    font-size: 12px;
    font-family: Microsoft YaHei;
    font-weight: 400;
    color: rgba(102, 102, 102, 1);
  }
  .Mperson {
    background: rgba(253, 218, 66, 1);
    margin-right: 12px;
    margin-bottom: 10px;
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
}
.showFile .flieAction a {
    margin-left: 12px;
}
</style>
<style>
.info_img img {
  width: 250px;
  height: 150px;
}
.info_img p{
    line-height: 18px;
}
.eidt-record-modal .ant-modal-footer{
    display: none;
}
</style>
<script>
import { download } from '@/api/RDmanagement/product'
import operationLogs from '@/components/operationLogs'
import { attentionProject, updateProjectStatus, getProjectChangeLog, getProjectDetails, projectSummary } from '@/api/RDmanagement/project'
import downMedia from '@/components/downMedia'
import myViewer from '@/components/myViewer'
import { allow, allowSize } from '@/plugins/common.js'
import qs from 'qs'
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
      loading: false,
      loading2: false,
      validateStatus: {
        media: 'success',
        mediaTxt: ''
      },
      form: this.$form.createForm(this, { name: 'coordinated' }),
      data2: [],
      columns2,
      file: '',
      expand: true,
      expand2: true,
      sign: 1,
      visible: false,
      visible2: false,
      visible3: false,
      projectDetails: {
        policies: {},
        media: [],
        user_attentions: [],
        project_principals: {}
      },
      docs: {},
      projectStatus: {
        status: '',
        comment: ''
      },
      show: true
    }
  },
  created () {
    this.getDetails()
  },
  watch: {
    file () {
      if (this.file) {
        this.validateStatus.media = 'success'
        this.validateStatus.mediaTxt = ''
      } else {
        this.validateStatus.media = 'error'
        this.validateStatus.mediaTxt = '请选择文件'
      }
    }
  },
  methods: {
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
    downLoad (k) {
      let params = { media: [{ id: k.id, file_name: k.file_name }] }
      params = qs.stringify(params)
      if (k.mime_type.indexOf('image') !== -1) {
        // 预览
        window.open(k.url, '_blank')
      } else {
        download(params)
      }
    },
    showMore () {
      this.show = false
    },
    closeMore () {
      this.show = true
    },
    getDetails () {
      getProjectDetails(this.$route.query.id, { demand_docs: 1 }).then(res => {
        if (res.code === 200) {
          this.projectDetails = res.data.project
          this.docs = res.data.demand_docs
          this.projectStatus.status = this.projectDetails.status
          this.projectDetails.operation_logs = this.projectDetails.operation_logs.map(item => {
            return { show: false, ...item }
          }

          )
        }
      })
      getProjectChangeLog(this.$route.query.id).then(res => {
        if (res.code === 200) {
          this.data2 = res.data.status_logs
        }
      })
    },
    toggle () {
      this.expand = !this.expand
    },
    toggle2 () {
      this.expand2 = !this.expand2
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
    },
    cancel () {
      this.getDetails()
      this.form.resetFields()
      this.file = ''
    },
    cancel2 () {
      this.validateStatus.media = 'success'
      this.validateStatus.mediaTxt = ''
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
            this.loading = true
            const formData = new FormData()
            formData.append('status', this.projectStatus.status)
            formData.append('project_summary', this.file)
            updateProjectStatus(this.projectDetails.id, formData).then(res => {
              if (res.code === 200) {
                this.getDetails()
                this.$message.success('更新状态成功')
                this.form.resetFields()
                this.file = ''
                this.loading = false
                this.visible = false
              }
            }).catch(error => {
              this.loading = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          }
          if (this.projectStatus.status !== 3) {
            this.loading = true
            this.projectStatus.comment = values.comment
            updateProjectStatus(this.projectDetails.id, this.projectStatus).then(res => {
              if (res.code === 200) {
                this.getDetails()
                this.$message.success('更新状态成功')
                this.form.resetFields()
                this.loading = false
                this.visible = false
              }
            }).catch(error => {
              this.loading = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          }
        }
      })
    },
    handleOk2 () {
      if (!this.file) {
        this.validateStatus.media = 'error'
        this.validateStatus.mediaTxt = '请选择文件'
      }
      if (this.file) {
        this.loading2 = true
        const formData = new FormData()
        formData.append('project_summary', this.file)
        projectSummary(this.projectDetails.id, formData).then(res => {
          if (res.code === 200) {
            this.getDetails()
            this.$message.success('更新报告文件成功')
            this.loading2 = false
            this.visible3 = false
          }
        }).catch(error => {
          this.loading2 = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      }
    },
    goEdit (id) {
      this.$router.push({ name: 'editDailyProjects', query: { id: id } })
    }
  }
}
</script>
