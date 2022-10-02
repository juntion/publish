<template>
  <div>
     <viewer :images="images"
            class="viewer" ref="viewer"
            @inited="inited"
    >
     <img v-for="src in images" :src="src" :key="src" class="image">
    </viewer>
     <viewer :images="images2"
            class="viewer" ref="viewer2"
            @inited="inited2"
    >
     <img v-for="src in images2" :src="src" :key="src" class="image">
    </viewer>
    <a-form-model   ref="ruleForm"
                    :model="form1"
                    :rules="rules">
      <div class="box bug">
        <div class="header">
          <h1>{{$route.query.id ? '编辑Bug' : '提Bug'}}</h1>
        </div>
        <div class="con">
          <h3>重要信息</h3>
          <div class="info">
            <a-row class="form-row">
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 40px">
                <a-form-model-item>
                  <span slot="label"><span style="color:red">*</span> 部门</span>
                   <a-select placeholder="部门"
                    showSearch
                    optionFilterProp="children"
                    :disabled="deptDisabled"
                        v-model="form1.dept_id">
                    <span slot="suffixIcon"></span>
                    <a-select-option v-for="item in options"
                                :key="item.id">{{item.name}}</a-select-option>
                </a-select>
                </a-form-model-item>
              </a-col>
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 10px">
                <a-form-model-item label="是否加急" prop="is_urgent" >
                  <a-select v-model="form1.is_urgent"
                            placeholder="请选择"
                            style="width: 100%">
                    <a-select-option :value="1">加急</a-select-option>
                    <a-select-option :value="0">不加急</a-select-option>

                  </a-select>
                </a-form-model-item>
              </a-col>
            </a-row>
             <a-row class="form-row">
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 40px">
                <a-form-model-item  prop="browser" class="colon">
                    <span class="fz12" slot="label">浏览器 :<span style="color:#f88d49;margin-left:10px"> 产生故障的浏览器</span></span>
                   <a-select
                            v-model="form1.browser"
                            mode="tags"
                            placeholder="请选择"
                            style="width: 100%">
                    <a-select-option value="无">无</a-select-option>
                    <a-select-option value="谷歌浏览器">谷歌浏览器</a-select-option>
                    <a-select-option value="360浏览器">360浏览器</a-select-option>
                    <a-select-option value="火狐浏览器">火狐浏览器</a-select-option>
                    <a-select-option value="QQ浏览器">QQ浏览器</a-select-option>
                    <a-select-option value="猎豹浏览器">猎豹浏览器</a-select-option>
                    <a-select-option value="Opera浏览器">Opera浏览器</a-select-option>
                    <a-select-option value="UC浏览器">UC浏览器</a-select-option>
                    <a-select-option value="IE浏览器">IE浏览器</a-select-option>
                    <a-select-option value="百度浏览器">百度浏览器</a-select-option>
                    <a-select-option value="搜狗浏览器">搜狗浏览器</a-select-option>
                  </a-select>
                </a-form-model-item>
              </a-col>
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 10px">
                <a-form-model-item  :validateStatus="validateStatus.users"
                       :help="validateStatus.usersTxt">
                       <span slot="label"><span style="color:red">*</span> 操作账号</span>
                    <multiplePeopleSelect @getValue2="getCareValue" ref="attentionUser"></multiplePeopleSelect>
                </a-form-model-item>
              </a-col>
            </a-row>

            <a-row>
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 40px">
                <a-form-model-item label="操作平台" prop="operation_platform" >

                    <a-select v-model="form1.operation_platform"
                            placeholder="请选择"
                            style="width: 100%">
                        <a-select-option :value="2">后台PC端</a-select-option>
                        <a-select-option :value="3">PDA</a-select-option>
                        <a-select-option :value="1">FS平台</a-select-option>
                        <a-select-option :value="5">Community中文</a-select-option>
                        <a-select-option :value="6">Community英文</a-select-option>
                        <a-select-option :value="7">Arms</a-select-option>
                        <a-select-option :value="4">APP</a-select-option>
                    </a-select>
                </a-form-model-item>
              </a-col>
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 10px">
                <a-form-model-item label="故障产生时间段" prop="date">
                  <!-- v-model="form1.expiration_date" -->
                  <a-range-picker
                    :disabledDate="disabledDate"
                    :disabledTime="disabledTime"
                    :ranges="{ Today: [moment(), moment()] }"
                    show-time
                    style="width:100%"
                    v-model="form1.date"
                    format="YYYY/MM/DD HH:mm:ss"
                    >
                        <span class="iconfont" slot="suffixIcon" style="font-size:12px;margin-top: -6px;">&#xe659;</span>
                  </a-range-picker>
                </a-form-model-item>
              </a-col>
            </a-row>
            <a-row>
                <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     v-if="form1.operation_platform===1 || form1.operation_platform===2 || form1.operation_platform===5 || form1.operation_platform===6 "
                     style="padding-right: 40px"
                    >

                            <a-row>
                            <span><span style="color:red">*</span> 页面链接 :</span>
                            <span @click="addUrlInputList"
                                    class="addFile">
                                <a-icon type="plus" />添加</span>
                            </a-row>

                                <a-form-model-item
                                 style="margin-bottom: 0px;"
                                 v-for="(link, index) in form1.links"
                                 :key="link.key"
                                 :prop="'links.' + index + '.value'"
                                 :rules="[{ required: true, message: '请输入出现故障的页面链接', trigger: 'blur' }, { pattern: new RegExp(/^[0-9a-zA-Z_.:/#?=&%+-]{1,}$/, 'g'), message: '请输入正确的格式', trigger: 'blur' }]">
                                        <a-input placeholder="请输入出现故障的页面链接"
                                            style="margin-bottom: 10px;"
                                            :style="{'width': form1.links.length>1 ?  '95%' : '100%'}"
                                            v-model="link.value" />
                                       <span v-if="form1.links.length>1" @click="() => removeUrlInputList(index)" class="iconfont fz12 cup" style="margin-left:10px">&#xe631;</span>
                                </a-form-model-item>
                </a-col>
                <a-col
                     :lg="12"
                     :md="12"
                     :sm="24"
                     v-if="form1.operation_platform===3 || form1.operation_platform===4 || form1.operation_platform===7"
                     style="padding-right: 40px"
                    >
                    <a-form-model-item prop="version" class="colon">
                        <span class="fz12" slot="label">软件版本号 :<span style="color:#f88d49;margin-left:10px"> 想知道怎么查看版本号,<span class="cup" @click="show">点击试一试</span></span></span>
                        <a-input v-model="form1.version" placeholder="请输入出现故障的软件版本号"/>
                    </a-form-model-item>
                </a-col>

            </a-row>

          </div>

        </div>

        <div class="con" style="padding-top: 19px;">
          <h3>故障内容</h3>
          <p class="mb10"> <span style="color:#FF0000">*</span> 故障描述 :
            <span style="color:#f88d49;margin-left:10px">请务必规范填写,否则系统有权驳回不予处理!</span>
            <span style="color:#378EEF;margin-left:10px" class="cup" @click="showGuide"> 点击查看示例</span>
          </p>
          <a-form-model-item :validate-status="validateStatus.contents"
                       :help="validateStatus.contentsTxt">
            <div style="height: 350px;margin-bottom: 20px;">
              <myEditor v-model="form1.description"
                        placeholder="请输入故障描述"
                        :class="{'active' : active}"></myEditor>
            </div>

          </a-form-model-item>
          <a-row style="margin-bottom:10px;">
            <span>附件 :<span style="color:#F88D49;margin-left:10px">可上传文档,图片文件,视频文件</span></span>
            <span @click="addFileInputList"
                  class="addFile">
              <a-icon type="plus" />添加</span>
          </a-row>
          <a-form-model-item :validate-status="validateStatus.media"
                       :help="validateStatus.mediaTxt">
            <div v-for="(item, index) in fileInputList"
                 :key="index"
                 style="display:flex;margin-bottom:10px">
              <div class="fileInput">
                <a-input :value="item.name"
                        placeholder="请选择附件"
                         disabled />
              </div>
              <div style="width: 68px;margin-right: 10px;">
                <a-upload :showUploadList="false"
                          :remove="handleRemove"
                          :beforeUpload="(file) => beforeUpload(file, index)">
                  <a-button size="small">选择文件</a-button>
                </a-upload>
              </div>
              <div @click="() => removeFileInputList(index)"
                   class="delFile"> <span class="iconfont" style="top: 8px;">&#xe64d;</span></div>
            </div>
          </a-form-model-item>

        </div>
        <div class="con eidt-con-margin">
          <h3>附加信息</h3>
           <a-row class="form-row">
                    <a-col :lg="12"
                            :md="12"
                            :sm="24"
                            style="padding-right:40px;"
                            >
                        <a-form-model-item >
                        <span slot="label">所属产品线</span>
                        <a-select
                                   v-model="form1.product_line"
                                    allowClear
                                    @change="handleProvinceChange"
                                    placeholder="请选择">
                            <a-select-option v-for="k in productsLine"
                                            :title="k.description"
                                            :key="k.id">{{k.name}}</a-select-option>
                        </a-select>
                        </a-form-model-item>
                    </a-col>
                    <a-col :lg="12"
                        :md="12"
                        :sm="24"
                        style="padding-right: 10px"
                        >
                        <a-form-model-item>
                                <span slot="label">产品名称</span>
                                <a-select
                                    allowClear
                                    v-model="form1.product_id"
                                    placeholder="请选择"
                                    >
                                    <a-select-option v-for="item in products"
                                                    :title="item.description"
                                                    :key="item.id">{{item.name}}</a-select-option>
                                </a-select>
                        </a-form-model-item>
                    </a-col>
            </a-row>
            <a-row class="form-row">
                    <a-col :lg="12"
                            :md="12"
                            :sm="24"
                            style="padding-right:40px;"
                            >
                        <a-form-model-item>
                        <span slot="label">所属项目</span>
                        <projectSelect v-model="form1.source_project_id" :allowClear="true" @onChange="onChange" ref="source_project"></projectSelect>
                        </a-form-model-item>
                    </a-col>
                    <a-col :lg="12"
                        :md="12"
                        :sm="24"
                        style="padding-right: 10px"
                        >
                        <a-form-model-item>
                                <span slot="label">所属需求</span>
                                <a-select
                                    allowClear
                                    placeholder="请选择"
                                    :getPopupContainer="triggerNode => triggerNode.parentNode"
                                    showSearch
                                    labelInValue
                                    @search="serchFocus"
                                    v-model="form1.source_demand"
                                    optionFilterProp="children"
                                   >
                                    <a-select-option v-for="item in demand"
                                                    :title="item.name"
                                                    :key="item.id">{{item.name}}</a-select-option>
                                </a-select>
                        </a-form-model-item>
                    </a-col>
            </a-row>
        </div>
        <div class="con" style="padding-bottom:30px;padding-top:9px">
          <a-button @click="postForm"
                    :loading="btnLoad"
                    style="margin-right:20px;background:rgba(55,142,239,1)"
                    type="primary">提交</a-button>
          <a-button style="background:rgba(248,248,248,1);"
                    @click="goback">取消</a-button>
        </div>
      </div>
    </a-form-model>
  </div>
</template>

<style lang="less" scoped>
.image{
     display: none;
}
/deep/.ql-snow .ql-picker-label::before{
    top:0
}
/deep/.el-input--prefix .el-input__inner {
  height: 32px;
}
/deep/.ant-form-item-label{
line-height: 1;
margin-bottom: 10px;
}
/deep/.ant-form-item-control{
line-height: 1 ;
}
/deep/.expend{
       line-height: 32px;
    }
.active {
  border: 1px solid;
  border-color: #f5222d;
}
.mb10 {
  margin-bottom: 10px;
}
.mb4 {
    margin-bottom: 4px;
}
mb6{
    margin-bottom: 6px;
}
.mb20 {
  margin-bottom: 20px;
}
.fz12 {
  font-size: 12px;
}
.txt {
  color: #f88d49;
}
.delFile {
  line-height: 2;
  cursor: pointer;
}
.del{
    font-size: 12px;
    cursor: pointer;
    position: relative;
    left: 1118px;
    top: -36px;
    color:#BBBBBB;
}
.add{
    position: relative;
    left: 1090px;
    top: 6px;
    cursor: pointer;
    z-index: 100;
    color: rgba(55, 142, 239, 1);
}
.addFile {
  cursor: pointer;
  float: right;
  color: rgba(55, 142, 239, 1);
}
.delFile span{
   position: relative;
    top: 2px;
}
.fileInput {
  width: 1040px;
  margin-right: 10px;
}
.box {
  padding: 0 20px 0 20px;
  position: relative;
  left: 50%;
  transform: translateX(-50%);
  width: 1200px;

  background: rgba(255, 255, 255, 1);
  box-shadow: 0px 5px 15px 0px rgba(223, 226, 230, 0.8);
  border-radius: 4px;
  .header {
    height: 54px;
    line-height: 54px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid rgba(238, 238, 238, 1);
    margin-bottom: 16px;
    h1 {
      font-size: 16px;
      font-family: Microsoft YaHei;
      font-weight: bold;
      color: rgba(51, 51, 51, 1);
    }
    .down {
      cursor: pointer;
    }
    p {
      margin-left: 10px;
      height: 32px;
      color: #f88d49;
      font-size: 12px;
      background: rgba(255, 242, 234, 1);
      border: 1px solid rgba(255, 216, 191, 1);
      border-radius: 5px;
      line-height: 30px;
      padding: 0 10px;
      span {
        display: inline-block;
      }
    }
  }
}
.con {
  padding: 10px;
  margin-bottom: 6px;
  h3 {
    font-size: 14px;
    font-family: Microsoft YaHei;
    font-weight: bold;
    color: rgba(51, 51, 51, 1);
    margin-bottom: 16px;
  }
}
.form {
  .form-row {
    margin: 0 -8px;
      height:68px;
  }
  .ant-col-md-12,
  .ant-col-sm-24,
  .ant-col-lg-6,
  .ant-col-lg-8,
  .ant-col-lg-10,
  .ant-col-xl-8,
  .ant-col-xl-6 {
    padding: 0 10px;
  }
}
.colon /deep/label::after{
  content: '';

}
.eidt-add-bottom .form-row {
    // height:48px;
    margin-bottom: -20px;
    margin-top: -25px;
}
.con .eidt-margin{
    margin-bottom: 12px;
}
.eidt-con-margin{
    padding-top:9px;
    padding-bottom:0;
    margin-bottom: 0;
}

</style>
<script>
import moment from 'moment'
import projectSelect from '@/components/projectSelect.vue'
import myEditor from '@/components/myEditor'
import { getProducts } from '../../../api/RDmanagement/ProductMaintenance/index.js'
import { postBugs, bugDetails, editBugs } from '@/api/RDmanagement/bug/index.js'
import { demandList, getlDepartment } from '@/api/RDmanagement/dropDown'
import multiplePeopleSelect from '@/components/multiplePeopleSelect'
import { allow, allowSize } from '@/plugins/common.js'

const range = (start, end) => {
  const result = []
  for (let i = start; i <= end; i++) {
    result.push(i)
  }
  return result
}

export default {
  components: { myEditor, multiplePeopleSelect, projectSelect },
  data () {
    return {
      range,
      previewVisible: false,
      options: false,
      btnLoad: false,
      active: false,
      productsData: undefined,
      tip: true,
      validateStatus: {
        users: 'success',
        usersTxt: '',
        media: 'success',
        mediaTxt: '',
        contents: 'success',
        contentsTxt: ''
      },
      demand: [],
      fileList: [],
      fileInputList: [{ name: '', file: null }],
      urlInputList: [],
      productsLine: [],
      products: [],
      projectsData: {
        projectList: [],
        total: '',
        page: 1,
        totalPages: null
      },
      rules: {
        // is_urgent: [
        //   { required: true, message: '请选择', trigger: 'change' }
        // ],
        browser: [
          { required: true, message: '请选择', trigger: 'change' }
        ],
        operation_platform: [
          { required: true, message: '请选择', trigger: 'change' }
        ],
        date: [
          { required: true, message: '请选择', trigger: 'change' }
        ],
        version: [
          { required: true, message: '请输入出现故障的软件版本号', trigger: 'blur' },
          { pattern: new RegExp(/^[0-9a-zA-Z_.]{1,}$/, 'g'), message: '请输入正确的格式', trigger: 'blur' }
        ]
      },
      images2: [],
      form1: {
        dept_id: undefined,
        browser: [],
        is_urgent: undefined,
        operation_platform: undefined,
        product_line: undefined,
        product_id: undefined,
        date: undefined,
        version: undefined,
        description: '<p><strong>【故障产生的操作步骤】</strong></p><h3><span>&nbsp;(必填)</span><br></h3><h3><br></h3><h3><br></h3><h3><br></h3><p><strong>【操作结果】</strong></h3><h3><span>&nbsp;(必填)</span><br></h3><h3><br></h3><h3><br></h3><h3><br></h3><p><strong>【预期结果】</strong></p><h3><span>&nbsp;(必填)</span><br></h3><h3><br></h3><h3><br></h3>',
        links: [
          { value: '' }
        ],
        source_demand: undefined,
        source_project_id: undefined,
        source_project_name: undefined,
        operation_account: []
      },
      value: 1
    }
  },
  computed: {
    deptDisabled () {
      if (this.$route.query.id) {
        return true
      } else {
        return false
      }
    },
    images () {
      let urls = []
      if (this.form1.operation_platform === 3) {
        urls = [require('../../../assets/images/pda-version.png')]
      } else if (this.form1.operation_platform === 4) {
        urls = [require('../../../assets/images/app-version.png')]
      } else if (this.form1.operation_platform === 7) {
        urls = [require('../../../assets/images/arms-version.png')]
      }
      return urls
    }
  },
  watch: {
    'form1.description' (newValue, oldValue) {
      if (newValue) {
        this.validateStatus.contents = 'success'
        this.validateStatus.contentsTxt = ''
        this.active = false
      } else {
        this.validateStatus.contents = 'error'
        this.validateStatus.contentsTxt = '请填写故障描述'
        this.active = true
      }
    },
    'form1.operation_account' (newValue, oldValue) {
      if (newValue && newValue.length) {
        this.validateStatus.users = 'success'
        this.validateStatus.usersTxt = ''
      } else {
        this.validateStatus.users = 'error'
        this.validateStatus.usersTxt = '请选择操作账号'
      }
    },
    fileInputList: {
      handler (newValue, oldValue) {
        newValue.forEach(item => {
          if (item.file) {
            this.validateStatus.media = 'success'
            this.validateStatus.mediaTxt = ''
          }
        })
      },
      deep: true
    }

  },
  created () {
    getlDepartment().then(res => {
      if (res.code === 200) {
        this.options = res.data.departments
        this.form1.dept_id = JSON.parse(localStorage.getItem('user')).basic_department.id
      }
    })
    getProducts().then(res => {
      this.productsLine = res.data.products
    })
    demandList().then(res => {
      this.demand = res.data
    })
    if (this.$route.query.id) {
      bugDetails(this.$route.query.id).then(res => {
        this.form1.browser = res.data.bug.browser
        this.form1.is_urgent = res.data.bug.is_urgent
        this.form1.operation_platform = res.data.bug.operation_platform
        this.form1.version = res.data.bug.version
        this.form1.description = res.data.bug.description
        if (res.data.bug.source_project_id) {
          this.form1.source_project_id = res.data.bug.source_project_id
        }
        if (res.data.bug.source_project_name) {
          this.form1.source_project_name = res.data.bug.source_project_name
        }
        if (res.data.bug.links) {
          this.form1.links = res.data.bug.links.map(item => {
            return { value: item }
          })
        } else {
          this.form1.links = [ { value: '' } ]
        }
        // 操作账号回显处理
        let attentionIds = []
        let Arr = []
        res.data.bug.operation_account.forEach(item => {
          Arr.push(item)
          attentionIds.push(item.id)
        })
        this.$refs.attentionUser.searchUser = Arr
        this.$refs.attentionUser.value2 = attentionIds
        this.form1.operation_account = attentionIds

        // ---------------

        this.form1.date = [moment(res.data.bug.start_time), moment(res.data.bug.end_time)]
        if (res.data.bug.product_category.product_line) {
          this.form1.product_line = res.data.bug.product_category.product_line.id
          getProducts(res.data.bug.product_category.product_line.id).then(res => {
            this.products = res.data.products
          })
          this.form1.product_id = res.data.bug.product_category.product.id
        }
        if (res.data.bug.source_demand_id) {
          this.form1.source_demand = { key: res.data.bug.source_demand_id, label: res.data.bug.source_demand_name }
        }

        if (res.data.bug.source_project_id) {
          this.$refs.source_project.projectsData.projectList.push({ id: res.data.bug.source_project_id, name: res.data.bug.source_project_name })
        }
        this.fileInputList = res.data.bug.media
      })
    }
  },
  methods: {
    moment,
    inited (viewer) {
      this.$viewer = viewer
    },
    inited2 (viewer) {
      this.$viewer2 = viewer
    },
    show () {
      this.$viewer.show()
    },
    showGuide () {
      this.images2 = [require('../../../assets/images/bug-guide.jpg')]
      this.$viewer2.show()
    },
    disabledDate (current) {
      // 不能选择今天以后的日期
      return current && current >= moment().endOf('day')
    },
    disabledTime (dates, partial) {
      let hours = moment().hours()// 0~23
      let minutes = moment().minutes()// 0~59
      let seconds = moment().seconds()// 0~59
      // 当日只能选择当前时间之后的时间点
      if (dates && moment(dates[1]).date() === moment().date() && partial === 'end') {
        return {
          disabledHours: () => this.range(hours + 1, 23),
          disabledMinutes: () => this.range(minutes + 1, 59),
          disabledSeconds: () => this.range(seconds + 1, 59)
        }
      }
    },
    serchFocus (e) {
      if (e) {
        demandList({ keyword: e }).then(res => {
          this.demand = res.data
        })
      }
    },
    getCareValue (e) {
      this.form1.operation_account = e
    },
    handleProvinceChange (value) {
      this.form1.product_id = undefined
      if (value) {
        getProducts(value).then(res => {
          this.products = res.data.products
        })
      } else {
        this.products = []
      }
    },
    loadData (selectedOptions) {
      const targetOption = selectedOptions[selectedOptions.length - 1]
      targetOption.loading = true
      // 加载数据
      getProducts(targetOption.value).then(res => {
        targetOption.loading = false
        targetOption.children = res.data.products.map(item => {
          return { value: item.id, label: item.name, isLeaf: true }
        })
        this.modules = [...this.modules]
      })
    },
    onChange (e) {
      this.form1.source_project_name = e
    },
    // 提交前过滤空数据和undefined
    removeProperty (object) {
      for (let key in object) {
        if (object[key] === undefined) {
          delete object[key]
        } else if (object[key] === null) {
          delete object[key]
        } else if (object[key] === '') {
          delete object[key]
        } else if (Array.isArray(object[key]) && object[key].length === 0) {
          delete object[key]
        }
      }
    },
    postForm () {
      this.$refs.ruleForm.validate(valid => {
        if (!this.form1.operation_account.length) {
          this.validateStatus.users = 'error'
          this.validateStatus.usersTxt = '请选择操作账号'
        }
        if (valid && this.form1.description && this.validateStatus.users === 'success') {
          const formData = new FormData()
          const data = JSON.parse(JSON.stringify(this.form1))
          data.start_time = this.form1.date[0].format('YYYY/MM/DD HH:mm:ss')
          data.end_time = this.form1.date[1].format('YYYY/MM/DD HH:mm:ss')
          data.date = ''
          if (data.source_demand) {
            data.source_demand_id = data.source_demand.key
            data.source_demand_name = data.source_demand.label
            delete data.source_demand
          }

          data.links = data.links.map(item => {
            if (item.value) {
              return item.value
            }
          })
          this.removeProperty(data)

          // formdata对数组进行处理
          Object.keys(data).forEach(key => {
            if (Array.isArray(data[key])) {
              if (data[key].length > 0) {
                data[key].forEach(item => {
                  if (item) {
                    formData.append(key + '[]', item)
                  }
                })
              }
            } else {
              formData.append(key, data[key])
            }
          })
          this.btnLoad = true
          if (this.$route.query.id) {
            this.fileInputList.forEach(item => {
              if ('file' in item === true) {
                if (item.file) {
                  formData.append('new_media[]', item.file)
                }
              } else {
                formData.append('old_media[]', item.id)
              }
            })

            editBugs(this.$route.query.id, formData).then(res => {
              if (res.code === 200) {
                this.$message.success('编辑Bug成功')
                this.$router.push({ name: 'bug' })
                this.btnLoad = false
              }
            }).catch(error => {
              this.btnLoad = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          } else {
            this.fileInputList.map(item => {
              if (item.file) {
                formData.append('media[]', item.file)
              }
            })
            postBugs(formData).then(res => {
              if (res.code === 200) {
                this.$message.success('提Bug成功')
                this.$router.push({ name: 'bug' })
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
    handleRemove (file) {
      const index = this.fileList.indexOf(file)
      const newFileList = this.fileList.slice()
      newFileList.splice(index, 1)
      this.fileList = newFileList
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
    addUrlInputList () {
      this.form1.links.push({ value: '', key: Date.now() })
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
    removeUrlInputList (index) {
      this.form1.links.splice(index, 1)
    },
    removeProductsList (index) {
      this.productsList.splice(index, 1)
    },
    removeFileInputList (index) {
      const { fileInputList } = this
      fileInputList.splice(index, 1)
      this.fileInputList = fileInputList
    },
    goback () {
      this.$router.go(-1)
    }
  }
}
</script>
<style lang="less">
    .ant-calendar  .ant-calendar-ok-btn{
        display: none !important;
    }
</style>
