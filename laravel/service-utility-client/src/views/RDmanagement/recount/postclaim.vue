<template>
  <div>
    <a-form :form="form">
      <div class="box">
        <div class="header" style="margin-bottom: 16px;">
          <h1>{{this.$route.query.type==1?"编辑诉求":"发布诉求"}}</h1>
          <p>
            请诉求人根据需求实际情况，仔细填写相关信息，并描述详细的诉求内容，完成发布。
            <!-- <span class="icon iconfont down">&#xe631;</span> -->
          </p>
        </div>
        <div class="con base-info" style="padding-bottom:0px">
          <h3 style="margin-top:0;">基本信息</h3>
          <div class="info">
            <a-row class="form-row">
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 40px">
                <a-form-item>
                  <span slot="label">诉求标题</span>
                  <a-input placeholder="请输入诉求标题"
                           :maxLength="40"
                           v-decorator="['name', { rules: [{ required: true, message: '请输入诉求标题' },{ max:40,message: '* 请将诉求标题控制在40个字符以内', }] }]" />
                </a-form-item>
              </a-col>
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 40px"
                     class="eidt-button">
                <a-form-item label="诉求类型:">
                  <a-select placeholder="请选择"
                            v-decorator="['type', { rules: [{ required: true, message: '请选择诉求类型' }] }]"
                            style="width: 87%">
                    <a-select-option :value="1"><span> 规则调整</span></a-select-option>
                    <a-select-option :value="2"><span> 新增功能</span></a-select-option>
                    <a-select-option :value="3"><span> 迭代建议</span></a-select-option>
                    <a-select-option :value="4"><span> 数据提取</span></a-select-option>
                    <a-select-option :value="5"><span> Bug修复</span></a-select-option>
                    <a-select-option :value="7"><span> 设计样式</span></a-select-option>
                    <a-select-option :value="6"><span>其他</span></a-select-option>
                  </a-select>
                </a-form-item>
                <div class="button-selects">
                  <span class="button-selects-yellow"
                        :class="statusbut1 == true ? 'active':''"><span @click="pointbutton1()">紧急</span>
                    <div class="modal"
                         v-if="btnShow">
                      <a-form layout="vertical"
                              :form="btnForm1">
                        <a-form-item label="你能接受的是最晚交付时间是：">
                          <a-date-picker style="width:100%"
                                        :disabledDate="disabledDate"
                                         v-decorator="['time', { rules: [{ required: true, message: '请选择日期' }] }]" />
                        </a-form-item>
                        <a-form-item label="若晚于目标日期交付会带来什么影响：">

                          <a-textarea style="height:80px"
                                      v-decorator="['txt', { rules: [{ required: true, message: '请输入' }] }]"
                                      placeholder="请输入" />
                        </a-form-item>
                      </a-form>
                      <div style="text-align: right;">
                        <span class="btn"
                             style="width:68px"
                              @click="btnOk">确定</span>
                      </div>
                    </div>
                  </span>
                  <span class="button-selects-green"
                        :class="statusbut2 == true ? 'active':''"><span @click="pointbutton2()">重要</span>
                    <div class="modal"
                         style="right:20px"
                         v-if="btnShow2">
                      <a-form layout="vertical"
                              :form="btnForm2">

                        <a-form-item label="请举例说明其重要性：">
                          <a-input v-decorator="['txt', { rules: [{ required: true, message: '请输入' }] }]"
                                   placeholder="请输入" />
                        </a-form-item>
                      </a-form>
                      <div style="text-align: right;">
                        <span class="btn"
                                style="width:68px"
                              @click="btnOk2">确定</span>
                      </div>
                    </div>
                  </span>
                </div>

              </a-col>

            </a-row>
            <a-row class="form-row">
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right:40px;"
                    >
                <a-form-item >
                  <span slot="label">所属产品线</span>
                  <a-select
                            v-decorator="['productsLine', { rules: [{ required: true, message: '请选择所属产品线' }] }]"
                            @change="handleProvinceChange"
                            placeholder="请选择">
                    <a-select-option v-for="k in productsLine"
                                     :title="k.description"
                                     :key="k.id">{{k.name}}</a-select-option>
                  </a-select>
                </a-form-item>
              </a-col>
                <a-col :lg="12"
                     :md="12"
                     :sm="24"
                    >
                     <a-form-item>
                            <span slot="label">产品名称</span>
                            <a-select
                                v-decorator="['products', { rules: [{ required: true, message: '请选择所属产品' }] }]"
                                placeholder="请选择"
                                @change="handleProvinceChange2">
                                <a-select-option v-for="item in products"
                                                :title="item.description"
                                                :key="item.id">{{item.name}}</a-select-option>
                            </a-select>
                     </a-form-item>
                </a-col>

            </a-row>
          </div>
        </div>
        <div class="con" style="padding:0 10px;">

          <div class="info">
            <a-row class="form-row">
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     class="project-source"
                     style="padding-right: 40px">
                <a-form-item class="colon">
                  <span class="fz12" slot="label">项目来源 :<span style="color:#f88d49;margin-left:10px"> 若为项目诉求，请正确选择对应项目! </span></span>
                  <a-select showSearch
                            placeholder="请选择"
                            style="width:100%"
                            allowClear
                            v-decorator="['source_project_name']"
                            @search="serchFocus"
                            :filterOption="false"
                            @popupScroll="popupScroll">
                    <a-select-option v-for="item2 in projectsData.projectList"
                                     :key="JSON.stringify(item2)">
                        <img src="@/assets/images/daily.png" v-if="item2.type == 0" style="position: relative; top: -2px;">
                        <img src="@/assets/images/key.png" v-if="item2.type == 1" style="position: relative; top: -2px;">
                        {{item2.name}}
                     </a-select-option>
                    <a-spin v-if="loading"
                            class="loading" />
                  </a-select>
                </a-form-item>
              </a-col>

              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 0px">
                <a-form-item>
                  <span slot="label">需要ta关注</span>
                  <!-- v-decorator="['attention_user_ids', {  type: 'array',rules: [{ required: true, message: '请选择关注人' }] }]" -->
                  <multiplePeopleSelect @getValue2="getCareValue"></multiplePeopleSelect>
                </a-form-item>
              </a-col>
            </a-row>

          </div>
        </div>
        <div class="con">
          <h3 style="margin-bottom: 22px;">诉求描述</h3>
          <div class="claimDescription">
            <p class="claimDescription-title"> <span style="color:#FF0000">*</span> 诉求描述：</p>
            <p class="claimDescription-title2"><span class="icon iconfont down">&#xe654;</span>请从以下几点详细描述你的诉求</p>
            <ul v-if="form.getFieldValue('type')==4">
              <li>[1]为什么有这个数据统计需求?</li>
              <li>[2]目前是遇到什么困难？</li>
              <li>[3]现在是怎么做的?</li>
              <li>[4]数据统计出来后给谁用?</li>
              <li>[5]需要我们统计哪些字段（数据）?</li>
              <li>[6]字段（数据）的业务意义是什么?</li>
              <li>[7]你要求应用什么计算公式得出数据结果？</li>
              <li>[8]数据分析的用户量是多少？</li>
            </ul>
            <ul v-else>
              <li>[1]当前功能是怎么样的？</li>
              <li>[2]目前是遇到什么困难？</li>
              <li>[3]为什么产生该需求？</li>
              <li>[4]为什么想要通过软件产品来解决而非其他方式？</li>
              <li>[5]想要实现怎么样的效果？</li>
              <li>[6]此需求涉及的业务量庞大与否？</li>
            </ul>
          </div>
        <a-form-item :validate-status="validateStatus.contents"
                     :help="validateStatus.contentsTxt">
            <div style="height: 350px;margin-bottom: 20px;">
                <myEditor v-model="form2.content" placeholder="请输入诉求描述" :class="{'active' : active}"></myEditor>
            </div>
        </a-form-item>
        </div>
        <div class="con">
          <h3 style="margin-top: 15px;margin-bottom: 22px;">其他信息</h3>
          <a-row style="margin-bottom:10px;margin-top:20px">
            <span>附件:</span>
            <span @click="addFileInputList"
                  class="addFile">
              <a-icon type="plus" />添加</span>
          </a-row>
          <div v-for="(item, index) in fileInputList"
               :key="index"
               style="display:flex;margin-bottom:10px;position: relative;">
            <div class="fileInput">
              <a-input :value="item.name"
                       placeholder="请选择文件"
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
                 class="delFile">
              <!--<a-icon type="delete" />-->
                <span class="icon iconfont down" style="position: absolute;top: 0;right: 0;line-height: 32px;cursor: pointer;">&#xe64d;</span>

            </div>
          </div>
        </div>
        <div class="con"
             style="padding-bottom: 17px;">
          <p class="select-title2"><span class="icon iconfont down">&#xe654;</span>请确保诉求描述准确度，诉求质量会影响后续各项成本，包括诉求进度。</p>
          <el-checkbox class="select-title1"
                       v-model="checked">我已了解</el-checkbox>
        </div>
        <div class="con">
          <a-button @click="postForm"
                    :disabled="!checked"
                    :loading="btnLoad"
                    :class="{'disabled':!checked}"
                    style="margin-right:20px;background:rgba(55,142,239,1)"
                    type="primary">发布</a-button>
          <a-button style="background:rgba(248,248,248,1);"
                    @click="goback">取消</a-button>
        </div>
      </div>
    </a-form>
  </div>
</template>
<style lang="less" scoped>

.active {
  border: 1px solid;
  border-color: #f5222d;
}
.disabled{
    color: #fff;
    opacity: .5;
}
.disabled:hover{
    color: #fff;
}
.modal {
  text-align: left;
  position: absolute;
  top: 46px;
  right: -32px;
  padding: 20px;
  z-index: 101;
  width: 550px;
  // height: 268px;
  background: rgba(255, 255, 255, 1);
  border: 1px solid rgba(238, 238, 238, 1);
  box-shadow: 0px 5px 15px 0px rgba(223, 226, 230, 0.8);
  border-radius: 3px;
  .btn {
    display: inline-block;
    width: 68px;
    height: 32px;
    color: #fff;
    font-size: 14px;
    background: rgba(55, 142, 239, 1);
    border-radius: 3px;
  }
}
.delFile {
  line-height: 3;
}
.del{
    font-size: 12px;
    cursor: pointer;
    position: relative;
    left: 1128px;
    top: -38px;
}
.addFile {
  cursor: pointer;
  float: right;
  color: rgba(55, 142, 239, 1);
}
.add {
    position: absolute;
    right: 0;
    left: auto;
    top: 9px;
    cursor: pointer;
    z-index: 100;
    color: rgba(55, 142, 239, 1);
    line-height: 16px;
}
.fileInput {
  width: 1040px;
  margin-right: 10px;
}
.box {
    padding: 0 20px 20px 20px;
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
    line-height: 54px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid rgba(238, 238, 238, 1);
    .down {
      cursor: pointer;
    }
    h1 {
      font-size: 16px;
      font-family: Microsoft YaHei;
      font-weight: bold;
      color: rgba(51, 51, 51, 1);
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
//  margin-bottom: 50px;
  h3 {
    font-size: 14px;
    font-family: Microsoft YaHei;
    font-weight: bold;
    color: rgba(51, 51, 51, 1);
    margin-bottom: 18px;
    margin-top: 34px;
  }
  .eidt-button {
    position: relative;
  }
  .button-selects {
    position: absolute;
    right: 0;
    top: 34px;
  }
  .button-selects {
    span {
      width: 44px;
      height: 32px;
      border-radius: 3px;
      font-size: 12px;
      display: inline-block;
      line-height: 30px;
      text-align: center;
      border-radius: 3px;
      cursor: pointer;
    }
    .button-selects-yellow {
      position: relative;
      background: rgba(255, 219, 219, 1);
      color: rgba(255, 74, 74, 1);
      margin-right: 10px;
    }
    .button-selects-green {
      position: relative;
      background: rgba(61, 204, 166, 0.2);
      color: rgba(61, 204, 166, 1);
    }
    .button-selects-yellow.active {
      border: 1px solid rgba(255, 74, 74, 1);
      background-image: url("../../../assets/images/urgent.png");
      background-position: bottom right;

      background-repeat: no-repeat;
    }
    .button-selects-green.active {
      border: 1px solid rgba(61, 204, 166, 1);
      background-image: url("../../../assets/images/important.png");
      background-position: bottom right;
      border-radius: 3px;
      background-repeat: no-repeat;
    }
  }
  .claimDescription {
    padding-bottom: 2px;

    .claimDescription-title {
      color: #666666;
      font-size: 12px;
    }
    .claimDescription-title2 {
      font-size: 12px;
      color: #f88d49;
      margin: 8px 0 10px;
      line-height: 13px;
      span {
        margin-right: 4px;
        font-size: 13px;
      }
    }
    ul {
      display: flex;
      flex-wrap: wrap;
      li {
        color: #f88d49;
        font-size: 12px;
        width: 25%;
        margin-bottom: 8px;
        line-height: 14px;
      }
    }
  }
  .select-title2 {
    font-size: 12px;
    color: #f88d49;
    margin-top: 30px;
    margin-bottom: 6px;
    line-height: 13px;
    span {
      margin-right: 4px;
      font-size: 13px;
    }
  }
  .select-title1 /deep/ .el-checkbox__input.is-checked + .el-checkbox__label {
    font-size: 12px;
    color: #666;
  }
    .select-title1 /deep/ .el-checkbox__input + .el-checkbox__label {
    font-size: 12px;
    color: #666;
    }
}
.form {
  .form-row {
    margin: 0 -8px;
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
.base-info {
  .del {
    position: absolute;
    left: auto;
    right: 0;
    top: auto;
    bottom: 14px;
    color: #bbb;
  }
  .ant-form-item {
    margin-bottom: 4px;
  }
  .info {
    >div {
      padding-bottom: 4px;
    }
  }
  /deep/ .ant-select-selection {
    height: 32px !important;
  }
}
/deep/ .project-source {
  .ant-select-selection__rendered {line-height: 32px;}
}
</style>
<script>
import moment from 'moment'
import myEditor from '@/components/myEditor'
import { putForm, claimDetial, eidtClaim } from '../../../api/recount'
import { getProducts } from '../../../api/RDmanagement/ProductMaintenance/index.js'
import { getAllprojects } from '../../../api/RDmanagement/project'
import multiplePeopleSelect from '@/components/multiplePeopleSelect'
import { allow, allowSize } from '@/plugins/common.js'
const plainOptions = ['产品', '设计', '测试', '开发', '业务']
export default {
  components: { myEditor, multiplePeopleSelect },
  data () {
    return {
      btnLoad: false,
      active: false,
      form: this.$form.createForm(this, { name: 'releaseDemand' }),
      btnForm1: this.$form.createForm(this, { name: 'btn1' }),
      btnForm2: this.$form.createForm(this, { name: 'btn2' }),
      btnShow: false,
      btnShow2: false,
      validateStatus: {
        media: 'success',
        mediaTxt: '',
        contents: 'success',
        contentsTxt: ''
      },
      size: 'default',
      fileList: [],
      fileInputList: [{ name: '', file: null }],
      urlInputList: [],
      productsList: [{ val1: '', val2: '' }, { val1: '', val2: '' }],

      form2: {
        name: '',
        content: '<p><strong>诉求意义：</strong></p><p><br></p><p><br></p><p><br></p><p><strong>诉求内容：</strong></p><p><br></p><p><br></p><p><br></p>',
        type: '',
        is_urgent: '',
        is_important: '',
        questions: { urgent: [], important: [] },
        source_project_id: '',
        source_project_name: '',
        product_id: undefined,
        attention_user_ids: [],
        media: []
      },
      datas: [],
      plainOptions,
      checkedList: [],
      editorOption: {
        modules: {
          toolbar: {
            container: '#toolbar'
          }
        },
        placeholder: '请输入项目描述' // 提示
      },
      value: 1,
      checked: false,
      statusbut1: false,
      statusbut2: false,
      products_id: undefined,
      productsLine: [],
      products: [],
      modules: [],
      moduleTags: [],
      projectsData: {
        projectList: [],
        total: '',
        page: 1,
        totalPages: null
      },
      loading: false,
      loading2: false

    }
  },
  created () {
    getProducts().then(res => {
      this.productsLine = res.data.products
    })
  },
  methods: {
    moment,
    disabledDate (current) {
      // 不能选择今天以前的日期
      return current && current < moment().startOf('day')
    },
    btnOk () {
      this.btnForm1.validateFields((err, values) => {
        if (!err) {
          let time = values['time'].format('YYYY-MM-DD')
          this.btnShow = false
          this.form2.questions.urgent = [{ question: '你能接受的是最晚交付时间是', answer: time }, { question: '若晚于目标日期交付会带来什么影响', answer: values.txt }]
        }
      })
    },
    btnOk2 () {
      this.btnForm2.validateFields((err, values) => {
        if (!err) {
          this.btnShow2 = false
          this.form2.questions.important = [{ question: '请举例说明其重要性', answer: values.txt }]
        }
      })
    },
    postForm () {
      this.form.validateFields((err, values) => {
        if (!this.form2.content) {
          this.validateStatus.contents = 'error'
          this.validateStatus.contentsTxt = '请输入诉求描述'
          this.active = true
        }
        if (!err && this.form2.content) {
          let formData = new FormData()
          if (values.source_project_name) {
            let name = JSON.parse(values.source_project_name).name
            let id = JSON.parse(values.source_project_name).id
            formData.append('source_project_id', id)
            formData.append('source_project_name', name)
          }
          formData.append('name', values.name)
          formData.append('type', values.type)
          formData.append('product_id', values.products)
          formData.append('content', this.form2.content)
          if (this.form2.is_urgent) {
            formData.append('is_urgent', 1)
          }
          if (this.form2.is_important) {
            formData.append('is_important', 1)
          }

          this.form2.questions.urgent.map((item, key) => {
            formData.append('questions[urgent][' + key + '][question]', item.question)
            formData.append('questions[urgent][' + key + '][answer]', item.answer)
          })
          this.form2.questions.important.map((item, key) => {
            formData.append('questions[important][' + key + '][question]', item.question)
            formData.append('questions[important][' + key + '][answer]', item.answer)
          })
          this.fileInputList.map((item, index) => {
            if (item.file) {
              formData.append('media[]', item.file)
            }
          })
          this.form2.attention_user_ids.forEach(item => {
            formData.append('attention_user_ids[]', item)
          })
          if (this.$route.query.bugId) {
            formData.append('source_bug_id', this.$route.query.bugId)
          }
          if (this.checked) {
            this.btnLoad = true
            putForm(formData).then(data => {
              if (data.code === 200) {
                this.$message.success('诉求发布成功')
                this.btnLoad = false
                this.$router.push({ name: 'recountindex' })
              }
            }).catch(error => {
              this.btnLoad = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          } else {
            this.$message.error('请勾选我已了解')
          }
        }
      })
    },
    posteidt () {
      eidtClaim(this.$route.query.id).then(data => {
        this.datas = data.data.appeals
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    async getclaimdetial (lis_id) {
      await claimDetial(lis_id).then(data => {
        this.datas = data.data.appeals
        this.form2.name = this.datas.name
        this.form2.type = this.datas.type
        this.productsLine = this.datas.products
        this.form2.source_project_name = this.datas.source_project_name
        this.form2.content = this.datas.content
        if (this.datas.is_urgent === 1) {
          this.form2.is_urgent = this.datas.is_urgent
          this.statusbut1 = true
        }
        if (this.datas.is_important === 1) {
          this.form2.is_important = this.datas.is_important
          this.statusbut2 = true
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    handleProvinceChange (value) {
      setTimeout(() => {
        this.form.setFieldsValue({
          'products': undefined
        })
      }, 0)
      this.modules = []
      this.moduleTags = []
      getProducts(value).then(res => {
        this.products = res.data.products
      })
    },
    handleProvinceChange2 (value) {
      this.moduleTags = []
      getProducts(value).then(res => {
        this.modules = res.data.products
      })
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
    serchFocus (value) {
      this.projectsData.page = 0
      this.projectsData.projectList = []
      let values = '%' + value + '%'
      this.proJectList(values)
    },
    filterOption (input, option) {
      return (
        option.componentOptions.children[0].text.toLowerCase().indexOf(input.toLowerCase()) >= 0
      )
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
      if (e.target.scrollHeight - e.target.offsetHeight - e.target.scrollTop < 1) {
        this.proJectList(null)
      }
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
    addFileInputList () {
      const object = {
        name: '',
        file: null
      }
      const { fileInputList } = this
      fileInputList.push(object)
      this.fileInputList = fileInputList
    },
    removeFileInputList (index) {
      const { fileInputList } = this
      fileInputList.splice(index, 1)
      this.fileInputList = fileInputList
    },
    goback () {
      this.$router.go(-1)
    },
    pointbutton1 () {
      if (!this.btnShow2) {
        if (!this.statusbut1) {
          this.btnShow = true
        } else {
          this.btnShow = false
        }
        this.statusbut1 = !this.statusbut1
        if (this.statusbut1) {
          this.form2.is_urgent = '1'
        } else {
          this.form2.is_urgent = ''
        }
      }
    },
    pointbutton2 () {
      if (!this.btnShow) {
        if (!this.statusbut2) {
          this.btnShow2 = true
        } else {
          this.btnShow2 = false
        }
        this.statusbut2 = !this.statusbut2
        if (this.statusbut2) {
          this.form2.is_important = '1'
        } else {
          this.form2.is_important = ''
        }
      }
    },
    getCareValue (e) {
      this.form2.attention_user_ids = e
    },
    removeProperty (object) {
      for (let key in object) {
        if (object[key] === '') {
          delete object[key]
        }
      }
    }
  },
  watch: {
    'form2.content' () {
      if (this.form2.content) {
        this.validateStatus.contents = 'success'
        this.validateStatus.contentsTxt = ''
        this.active = false
      } else {
        this.validateStatus.contents = 'error'
        this.validateStatus.contentsTxt = '请填写诉求描述内容'
        this.active = true
      }
    },
    fileInputList: {
      handler () {
        this.fileInputList.forEach(item => {
          if (item.value) {
            this.validateStatus.media = 'success'
            this.validateStatus.mediaTxt = ''
          }
        })
      },
      deep: true
    }
  },
  mounted () {
    if (this.$route.query.type === 1) {
      this.getclaimdetial(this.$route.query.id)
    } else {

    }
    // 获取项目列表
    // 获取项目
    let search = []
    search['status'] = 1
    getAllprojects({ page: 1, limit: 30, filters: search }).then(res => {
      if (res.code === 200) {
        this.projectsData.projectList = res.data.data
        this.projectsData.total = res.data.total
        this.projectsData.totalPages = res.data.last_page
      }
    }).catch(error => {
      this.$message.error(error.response ? error.response.data.message : error.message)
    })
  }
}
</script>
