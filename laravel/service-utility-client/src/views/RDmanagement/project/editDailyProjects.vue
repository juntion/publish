<template>
  <div>
    <a-form :form="form">
      <div class="box">
        <div class="header">
          <h1 v-if="type===0">编辑日常项目</h1>
          <h1 v-if="type===1">编辑重点项目</h1>
        </div>
        <div class="con">
          <h3>基本信息</h3>
          <div class="info">
            <a-row class="form-row">
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 40px">
                <a-form-item>
                  <span slot="label">项目名称</span>
                  <a-input placeholder="请输入项目名称"
                             :maxLength="40"
                           v-decorator="['name',{ rules: [{ required: true, message: '请输入项目名称' },{ max:30,message: '* 请将项目名称控制在30个字符以内', }] }, ]" />
                </a-form-item>
              </a-col>
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 10px">
                <a-form-item label="预计项目周期">
                  <a-date-picker style="width:100%"
                                 format="YYYY/MM/DD"
                                 :disabledDate="disabledDate"
                                 v-decorator="['expiration_date',{ rules: [{ required: true, message: '请选择项目周期' }] }]"
                                 type="date"
                                 placeholder="选择日期">
                  </a-date-picker>
                </a-form-item>
              </a-col>
            </a-row>
            <a-row class="form-row">
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 40px">
                <a-form-item>
                  <span slot="label"> 项目级别</span>
                  <a-select v-decorator="['level',{ rules: [{ required: true, message: '请选择项目级别' }] }, ]"
                            placeholder="请选择"
                            :getPopupContainer="triggerNode => triggerNode.parentNode"
                            style="width: 100%">
                    <a-select-option value="S"><span style="color:rgba(255, 74, 74, 1)" v-if="type===1"> S</span></a-select-option>
                    <a-select-option value="A"><span style="color:rgba(248, 141, 73, 1)" v-if="type===1"> A</span></a-select-option>
                    <a-select-option value="B"><span style="color:rgba(248, 141, 73, 1)" v-if="type===0"> B</span></a-select-option>
                    <a-select-option value="C"><span style="color:rgba(254, 188, 46, 1)" v-if="type===0"> C</span></a-select-option>
                    <a-select-option value="D"><span style="color:rgba(254, 188, 46, 1)" v-if="type===0"> D</span></a-select-option>
                  </a-select>
                </a-form-item>
              </a-col>
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 10px">
                <a-form-item>
                  <span slot="label"> 项目难度</span>
                  <a-select v-decorator="['difficulty',{ rules: [{ required: true, message: '请选择项目难度' }] }, ]"
                            :getPopupContainer="triggerNode => triggerNode.parentNode"
                            placeholder="请选择"
                            style="width: 100%">
                    <a-select-option :value="5" v-if="type===1">
                      <span class="iconfont"
                            v-for="k in 5"
                            :key="k"
                            style="font-size:12px;color:rgba(255, 74, 74, 1)">&#xe641;</span>
                    </a-select-option>
                    <a-select-option :value="4" v-if="type===1">
                      <span class="iconfont"
                            v-for="k in 4"
                            :key="k"
                            style="font-size:12px;color:rgba(248, 141, 73, 1)">&#xe641;</span>
                    </a-select-option>
                    <a-select-option :value="3" v-if="type===0">
                      <span class="iconfont"
                            v-for="k in 3"
                            :key="k"
                            style="font-size:12px;color:rgba(248, 141, 73, 1)">&#xe641;</span>
                    </a-select-option>
                    <a-select-option :value="2" v-if="type===0">
                      <span class="iconfont"
                            v-for="k in 2"
                            :key="k"
                            style="font-size:12px;color:rgba(254, 188, 46, 1)">&#xe641;</span>
                    </a-select-option>
                    <a-select-option :value="1" v-if="type===0">
                      <span class="iconfont"
                            style="font-size:12px;color:rgba(254, 188, 46, 1)">&#xe641;</span>
                    </a-select-option>
                  </a-select>
                </a-form-item>
              </a-col>
            </a-row>
            <a-row>
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 40px">
                <a-row style="margin-bottom:10px">
                  <span>关联产品:</span>
                  <span @click="addProductsList"
                        class="addFile">
                    <a-icon type="plus" />添加</span>
                </a-row>
                <div v-for="(item, index) in productsList"
                     :key="index"
                     style="display:flex;margin-bottom:10px">
                  <div style="margin-right: 10px;">
                    <a-select v-model="item.val1"
                              :getPopupContainer="triggerNode => triggerNode.parentNode"
                              style="width: 240px;margin-right: 10px;"
                              :class="{w250:productsList.length<=1}"
                              @change="handleProvinceChange($event,item)"
                              placeholder="请选择">
                      <a-select-option v-for="k in productsLine"
                                       :key="k.id">{{k.name}}</a-select-option>
                    </a-select>
                    <a-select v-model="item.val2"
                              :getPopupContainer="triggerNode => triggerNode.parentNode"
                              style="width: 240px;margin-right: 10px;"
                              :class="{w250:productsList.length<=1}"
                              placeholder="请选择">
                      <a-select-option v-for="k in products"
                                       :key="k.id">{{k.name}}</a-select-option>
                    </a-select>
                  </div>
                  <div @click="() => removeProductsList(index)"
                       v-if="productsList.length>1"
                       class="delFile"><span class="iconfont del">&#xe631;</span></div>
                </div>
              </a-col>
            </a-row>
          </div>
        </div>
        <div class="con">
          <h3>负责人信息</h3>
          <div class="info">
            <a-row class="form-row">
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 40px">
                <a-form-item :validate-status="validateStatus.principal_user_id"
                             :help="validateStatus.principal_user_idTxt">
                  <span slot="label"><span style="color:red">*</span>项目负责人<span class="iconfont" style="font-size:12px" title="该负责人指几个系统部门的统筹人员，非公司指定的项目经理">&#xe640;</span></span>
                  <peopleSelect @getValue2="getChargeValue"
                                ref="select1"></peopleSelect>
                </a-form-item>
              </a-col>
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 10px">
                <a-form-item label="需要ta关注">
                  <multiplePeopleSelect @getValue2="getCareValue"
                                        ref="select2"></multiplePeopleSelect>
                </a-form-item>
              </a-col>
            </a-row>
            <a-row class="form-row">
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 40px">
                <h4 style="margin-bottom:10px">指定负责人</h4>
                <a-checkbox-group :options="plainOptions"
                                  v-model="checkedList"
                                  @change="onChange"
                                  style="margin-bottom:10px" />
                <div v-if="checkedList.indexOf('设计') !== -1"
                     style="display:flex;margin-bottom:10px">
                  <span class="title">设计</span>
                  <multiplePeopleSelect class="input"
                                :searchData="design_user"
                                :valueData="form1.design_user_ids"
                                @getValue2="getPeople"></multiplePeopleSelect>
                </div>
                <div v-if="checkedList.indexOf('开发') !== -1"
                     style="display:flex;margin-bottom:10px">
                  <span class="title">开发</span>
                  <multiplePeopleSelect class="input"
                                :searchData="dev_user"
                                :valueData="form1.dev_user_ids"
                                @getValue2="getPeople2"></multiplePeopleSelect>
                </div>
                <div v-if="checkedList.indexOf('测试') !== -1"
                     style="display:flex;margin-bottom:10px">
                  <span class="title">测试</span>
                  <multiplePeopleSelect class="input"
                                :searchData="test_user"
                                :valueData="form1.test_user_ids"
                                @getValue2="getPeople3"></multiplePeopleSelect>
                </div>
                <div v-if="checkedList.indexOf('产品') !== -1"
                     style="display:flex;margin-bottom:10px">
                  <span class="title">产品</span>
                  <multiplePeopleSelect class="input"
                                :searchData="product_user"
                                :valueData="form1.product_user_ids"
                                @getValue2="getPeople4"></multiplePeopleSelect>
                </div>
                <div v-if="checkedList.indexOf('业务') !== -1"
                     style="display:flex;margin-bottom:10px">
                  <span class="title">业务</span>
                  <multiplePeopleSelect class="input"
                                :searchData="business_user"
                                :valueData="form1.business_user_ids"
                                @getValue2="getPeople5"></multiplePeopleSelect>
                </div>
              </a-col>
            </a-row>
          </div>
        </div>
        <div class="con">
          <h3> <span style="color:red">*</span> 项目描述</h3>
          <a-form-item :validate-status="validateStatus.contents"
                       :help="validateStatus.contentsTxt">
            <div>
              <myEditor v-model="form1.contents"
                        :class="{'active' : active}"></myEditor>
            </div>
          </a-form-item>
        </div>
        <div class="con">
          <h3>其他信息</h3>
          <p style="margin-bottom:10px">url共享:</p>
          <a-radio-group v-model="value">
            <a-radio :value="0">无</a-radio>
            <a-radio :value="1">有</a-radio>
          </a-radio-group>
          <div v-if="value">
            <a-row style="margin-bottom:10px">
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
            <span>附件:</span>
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
                        :remove="handleRemove"
                        :beforeUpload="(file) => beforeUpload(file, index)">
                <a-button size="small">选择文件</a-button>
              </a-upload>
            </div>
            <div @click="() => removeFileInputList(index)"
                 class="delFile"> <span class="iconfont">&#xe64d;</span></div>
          </div>
        </div>
        <div class="con"
             style="margin-bottom:10px;">
          <p style="padding-top:30px;margin-bottom: 6px;">是否开启</p>
          <a-radio-group v-model="form1.status">
            <a-radio :value="0">关闭</a-radio>
            <a-radio :value="1">开启</a-radio>
          </a-radio-group>
        </div>
        <div class="con"
             style="padding-bottom:30px;">
          <a-button @click="postForm"
                    :loading="btnLoad"
                    style="margin-right:20px;background:rgba(55,142,239,1)"
                    type="primary">创建</a-button>
          <a-button style="background:rgba(248,248,248,1);"
                    @click="goback">取消</a-button>
        </div>
      </div>
    </a-form>
  </div>
</template>
<style lang="less" scoped>

/deep/.ql-snow .ql-color-picker .ql-picker-label svg {
  margin-bottom: 7px;
}
/deep/.ql-snow .ql-icon-picker .ql-picker-label svg {
  margin-bottom: 7px;
}
.active {
  border: 1px solid;
  border-color: #f5222d;
}
.w250 {
  width: 250px !important;
}
.delFile {
  line-height: 32px;
  cursor: pointer;
   .del{
      font-size:12px;
      color:#bbb;
  }
}
.addFile {
  cursor: pointer;
  float: right;
  color: rgba(55, 142, 239, 1);
}
.fileInput {
  width: 1040px;
  margin-right: 10px;
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
    height: 54px;
    line-height: 54px;
    border-bottom: 1px solid rgba(238, 238, 238, 1);
    h1 {
      font-size: 16px;
      font-family: Microsoft YaHei;
      font-weight: bold;
      color: rgba(51, 51, 51, 1);
    }
  }
}
.con {
  padding: 10px;
  .title {
    display: inline-block;
    width: 43px;
    height: 32px;
    text-align: center;
    line-height: 32px;
    border: 1px solid rgba(204, 204, 204, 1);
    border-right: 0;
    border-radius: 3px 0px 0px 3px;
  }
  .input {
    flex: 1;
    /deep/.expend{
           top: 8px;
      }
    /deep/.ant-select-selection--multiple {
      border-left: 1px solid rgba(204, 204, 204, 1);
      border-top-left-radius: 0;
      border-bottom-left-radius: 0;
    }
  }
  h3 {
    font-size: 14px;
    font-family: Microsoft YaHei;
    font-weight: bold;
    color: rgba(51, 51, 51, 1);
      margin-bottom: 24px;
      margin-top:24px;
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
</style>
<script>
import moment from 'moment'
import myEditor from '@/components/myEditor'
import peopleSelect from '@/components/peopleSelect'
import multiplePeopleSelect from '@/components/multiplePeopleSelect'
import { getProducts } from '@/api/RDmanagement/ProductMaintenance/index.js'
import { editProject, getProjectDetails } from '@/api/RDmanagement/project'
import { allow, allowSize } from '@/plugins/common.js'
const plainOptions = ['产品', '设计', '测试', '开发', '业务']
export default {
  components: { peopleSelect, multiplePeopleSelect, myEditor },
  data () {
    return {
      btnLoad: false,
      active: false,
      type: null,
      validateStatus: {
        principal_user_id: 'success',
        principal_user_idTxt: '',
        contents: 'success',
        contentsTxt: ''
      },
      form: this.$form.createForm(this, { name: 'project' }),
      productsLine: [],
      products: [],
      fileList: [],
      fileInputList: [{ name: '', file: null }],
      urlInputList: [],
      productsList: [{ val1: undefined, val2: undefined }],
      form1: {
        name: '',
        principal_user_id: '', // 负责人id
        expiration_date: '',
        contents: '',
        status: 1,
        shared_address: [
          { value: '' }
        ],
        level: undefined,
        difficulty: undefined,
        product_user_ids: [],
        design_user_ids: [],
        dev_user_ids: [],
        test_user_ids: [],
        business_user_ids: [],
        attention_user_ids: [],
        product_ids: []
      },
      product_user: [],
      design_user: [],
      dev_user: [],
      test_user: [],
      business_user: [],
      plainOptions,
      checkedList: [],
      value: 1
    }
  },
  watch: {
    'form1.contents' (newValue, oldValue) {
      if (this.form1.contents) {
        this.validateStatus.contents = 'success'
        this.validateStatus.contentsTxt = ''
        this.active = false
      } else {
        this.validateStatus.contents = 'error'
        this.validateStatus.contentsTxt = '请填写项目描述'
        this.active = true
      }
    },
    'form1.principal_user_id': function () {
      if (this.form1.principal_user_id) {
        this.validateStatus.principal_user_id = 'success'
        this.validateStatus.principal_user_idTxt = ''
      }
    }
  },
  methods: {
    moment,
    disabledDate (current) {
      // 不能选择今天以前的日期
      return current && current < moment().startOf('day')
    },
    getPeople (e) {
      this.form1.design_user_ids = e
    },
    getPeople2 (e) {
      this.form1.dev_user_ids = e
    },
    getPeople3 (e) {
      this.form1.test_user_ids = e
    },
    getPeople4 (e) {
      this.form1.product_user_ids = e
    },
    getPeople5 (e) {
      this.form1.business_user_ids = e
    },
    getChargeValue (e) {
      this.form1.principal_user_id = e
    },
    getCareValue (e) {
      this.form1.attention_user_ids = e
    },
    handleProvinceChange (value, k) {
      k.val2 = undefined
      getProducts(value).then(res => {
        this.products = res.data.products
      })
    },
    onChange (checkedValues) {
    },
    // 提交前过滤空数据和undefined
    removeProperty (object) {
      for (let key in object) {
        if (object[key] === '') {
          delete object[key]
        } else if (object[key] === undefined) {
          delete object[key]
        } else if (object[key] === null) {
          delete object[key]
        }
      }
    },
    postForm () {
      this.form.validateFields((err, values) => {
        if (!this.form1.principal_user_id) {
          this.validateStatus.principal_user_id = 'error'
          this.validateStatus.principal_user_idTxt = '请选择项目负责人'
        }
        if (!this.form1.contents) {
          this.validateStatus.contents = 'error'
          this.validateStatus.contentsTxt = '请填写项目描述'
          this.active = true
        }
        if (!err && this.form1.principal_user_id && this.form1.contents) {
          this.form1.name = values.name
          this.form1.expiration_date = values['expiration_date'].format('YYYY-MM-DD')
          this.form1.level = values.level
          this.form1.difficulty = values.difficulty
          var urlArr = []
          this.form1.shared_address.forEach(item => {
            if (item.value) {
              urlArr.push(item.value)
            } else {
              urlArr.push('')
            }
          })
          this.form1.shared_address = urlArr
          var productArr = []
          this.productsList.forEach(item => {
            if (item.val2) {
              productArr.push(item.val2)
            }
          })
          this.form1.product_ids = productArr
          const data = this.form1
          this.removeProperty(data)
          const formData = new FormData()
          this.fileInputList.forEach(item => {
            if ('file' in item === true) {
              formData.append('new_media[]', item.file)
            } else {
              formData.append('old_media[]', item.id)
            }
          })

          //   formdata对数组进行处理
          Object.keys(data).forEach(key => {
            if (Array.isArray(data[key])) {
              data[key].forEach(item => {
                formData.append(key + '[]', item)
              })
            } else {
              formData.append(key, data[key])
            }
          })
          this.btnLoad = true
          // 编辑项目
          editProject(this.$route.query.id, formData).then(res => {
            if (res.code === 200) {
              this.$message.success('编辑成功')
              this.$router.push({ name: 'project' })
              this.btnLoad = false
            }
          }).catch(error => {
            this.btnLoad = false
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
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
      this.form1.shared_address.push({ value: '' })
    },
    addProductsList () {
      this.productsList.push({ val1: undefined, val2: undefined })
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
      this.form1.shared_address.splice(index, 1)
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
  },
  created () {
    getProducts().then(res => {
      this.productsLine = res.data.products
    })

    // 数据回显
    getProjectDetails(this.$route.query.id).then(res => {
      this.form1 = res.data.project
      if (res.data.project.shared_address) {
        this.form1.shared_address = res.data.project.shared_address.map(item => {
          return { value: item }
        })
      } else {
        this.value = 0
        this.form1.shared_address = [ { value: '' } ]
      }
      this.form1.product_user_ids = []
      this.form1.design_user_ids = []
      this.form1.dev_user_ids = []
      this.form1.business_user_ids = []
      this.form1.test_user_ids = []
      this.form1.project_principals.forEach(item => {
        if (item.type === 0) {
          this.checkedList.push('产品')
          this.form1.product_user_ids.push(item.user_id)
          this.product_user.push({ id: item.user_id, name: item.user_name })
        } else if (item.type === 1) {
          this.checkedList.push('设计')
          this.form1.design_user_ids.push(item.user_id)
          this.design_user.push({ id: item.user_id, name: item.user_name })
        } else if (item.type === 2) {
          this.checkedList.push('开发')
          this.form1.dev_user_ids.push(item.user_id)
          this.dev_user.push({ id: item.user_id, name: item.user_name })
        } else if (item.type === 3) {
          this.checkedList.push('业务')
          this.form1.business_user_ids.push(item.user_id)
          this.business_user.push({ id: item.user_id, name: item.user_name })
        } else if (item.type === 4) {
          this.checkedList.push('测试')
          this.form1.test_user_ids.push(item.user_id)
          this.test_user.push({ id: item.user_id, name: item.user_name })
        }
      })
      var day = ''
      if (res.data.project.expiration_date) {
        day = moment(res.data.project.expiration_date)
      } else {
        day = undefined
      }
      this.form.setFieldsValue({
        'name': res.data.project.name,
        'level': res.data.project.level,
        'difficulty': res.data.project.difficulty,
        'expiration_date': day
      })
      let attentionIds = []
      let Arr1 = []
      res.data.project.user_attentions.forEach(item => {
        let data = {}
        data.id = item.user_id
        data.name = item.user_name
        Arr1.push(data)
        attentionIds.push(item.user_id)
      })
      this.$refs.select2.value2 = attentionIds
      this.$refs.select2.searchUser = Arr1
      this.$refs.select1.value2 = res.data.project.principal_user_id
      this.$refs.select1.searchUser = [{ id: res.data.project.principal_user_id, name: res.data.project.principal_user_name }]
      this.form1.attention_user_ids = attentionIds
      this.fileInputList = res.data.project.media
      this.type = res.data.project.type
      let Arr = []

      res.data.project.products.forEach(k => {
        if (k.type === 1) {
          Arr.push({ val1: k.parent_id, val2: k.id })
          getProducts(k.parent_id).then(res => {
            this.products = res.data.products
          })
        }
      })
      this.productsList = Arr
    })
  }
}
</script>
