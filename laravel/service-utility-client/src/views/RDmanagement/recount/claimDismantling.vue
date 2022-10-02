<template>
  <div>
    <!-- 发布诉求时候提示一个框并且需要备注 -->
    <div class="modal-box">
        <el-dialog title="提示"
                    :close-on-click-modal="false"
                    :visible.sync="dialogVisible"
                    width="380px"
                    >
        <div class="eidt-tips">
            <p>
            注意：使用拆解功能，会把一个诉求拆成至少两个新的诉求，原诉求将被置灰无法使用；被拆解后，将无法恢复，请务必谨慎操作；
            </p>
        </div>
        <el-form :model="{textarea}" :rules="rules" ref="ruleForm">
            <el-form-item prop="textarea">
                <div class="radio_box">
                    <p><span style="color:red">*</span> 备注:</p>
                    <el-input type="textarea"
                            :autosize="{ minRows: 3, maxRows: 3}"
                            placeholder="请输入备注"
                            v-model="textarea"
                            resize="none">
                    </el-input>
                </div>
             </el-form-item>
        </el-form>
        <span slot="footer"
               >
            <el-button @click="dialogVisible = false,$refs['ruleForm'].resetFields();">取 消</el-button>
            <el-button type="primary" @click="ok" :loading="btnLoad">确 定</el-button>
        </span>
        </el-dialog>

    </div>
    <div class="box">
      <div>
        <div class="header">
          <h1>拆解诉求</h1>
          <p>
            请诉求人根据需求实际情况，仔细填写相关信息，并描述详细的诉求内容，完成发布。
            <!-- <span class="icon iconfont down">&#xe631;</span> -->
          </p>
        </div>
        <span @click="add"
              class="addFile addclaim">
          <a-icon type="plus" />添加</span>
        <a-tabs hideAdd
                v-model="activeKey"
                type="editable-card"
                @edit="onEdit">
          <a-tab-pane v-for="(pane) in panes"
                      :tab="pane.title"
                      :key="pane.key"
                      :closable="pane.closable">
             <a-form-model
                :ref="'ruleForm'+pane.key"
                :model="{pane}"
            >
            <div class="con">
              <h3>基本信息</h3>
              <div class="info">
                <a-row class="form-row">
                  <a-col :lg="12"
                         :md="12"
                         :sm="24"
                         style="padding-right: 40px">
                    <a-form-model-item prop="pane.name" :rules="[{ required: true, message: '请输入诉求标题', trigger: 'blur' }]">
                    <span slot="label">诉求标题</span>
                      <a-input v-model="pane.name"
                               placeholder="请输入诉求标题" />
                    </a-form-model-item>
                  </a-col>
                  <a-col :lg="12"
                         :md="12"
                         :sm="24"
                         style="padding-right: 40px"
                         class="eidt-button">
                     <a-form-model-item prop="pane.type" :rules="[{ required: true, message: '请选择诉求类型', trigger: 'change' }]">
                      <span slot="label">诉求类型</span>
                      <a-select v-model="pane.type"
                                style="width: 87%">
                        <a-select-option :value="1"><span> 规则调整</span></a-select-option>
                        <a-select-option :value="2"><span> 新增功能</span></a-select-option>
                        <a-select-option :value="3"><span> 迭代建议</span></a-select-option>
                        <a-select-option :value="4"><span> 数据提取</span></a-select-option>
                        <a-select-option :value="5"><span> Bug修复</span></a-select-option>
                        <a-select-option :value="7"><span> 设计样式</span></a-select-option>
                        <a-select-option :value="6"><span> 其他</span></a-select-option>
                      </a-select>
                    </a-form-model-item>
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
                        :class="statusbut2 == true ? 'active':''"><span @click="pointbutton2()">重要</span></span>
                  <div class="modal"
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
                </div>
                  </a-col>

                </a-row>
                <a-row>
                <a-row class="form-row">
                        <a-col :lg="12"
                            :md="12"
                            :sm="24"
                            style="padding-right:40px;"
                        >
                          <a-form-model-item prop="pane.productsLine_id" :rules="[{ required: true, message: '请选择所属产品线', trigger: 'change' }]">
                            <span slot="label">所属产品线</span>
                            <a-select
                                        v-model="pane.productsLine_id"
                                        @change="handleProvinceChange"
                                        placeholder="请选择">
                                <a-select-option v-for="k in productsLine"
                                                :key="k.id">{{k.name}}</a-select-option>
                            </a-select>
                        </a-form-model-item>
                        </a-col>
                         <a-col :lg="12"
                            :md="12"
                            :sm="24"
                        >
                            <a-form-model-item prop="pane.product_id" :rules="[{ required: true, message: '请选择所属产品', trigger: 'change' }]">
                            <span slot="label">产品名称</span>
                            <a-select
                                        placeholder="请选择"
                                        v-model="pane.product_id"
                                        @change="handleProvinceChange2">
                                <a-select-option v-for="item in pane.products"
                                                :key="item.id">{{item.name}}</a-select-option>
                            </a-select>
                       </a-form-model-item>
                         </a-col>
                </a-row>
                </a-row>
                <!--
                <div>
                 <span class="add" @click="addModules"><a-icon type="plus" />添加</span>
                 <a-row v-for="(item,index) in pane.product_modules" :key="index" class="form-row">
                    <a-col
                        :lg="12"
                        :md="12"
                        :sm="24"
                        style="padding-right:40px">
                         <a-form-model-item>
                            <span slot="label" v-if="index===0">模块名称</span>
                            <a-cascader
                                    :options="modules"
                                    :loadData="loadData"
                                    placeholder="请选择"
                                    v-decorator="['product_id']"
                                    changeOnSelect
                                />
                            <a-select   v-model="item.module_id"
                                        allowClear
                                        @change="handleProvinceChange3($event,index)"
                                        placeholder="请选择">
                                <a-select-option v-for="item in pane.modules"
                                                :title="item.description"
                                                :key="item.id">{{item.name}}</a-select-option>
                            </a-select>
                         </a-form-model-item>
                     </a-col>
                    <a-col :lg="12"
                        :md="12"
                        :sm="24"
                        >
                         <a-form-model-item>
                        <span slot="label" v-if="index===0">模块标签</span>
                        <a-select   v-model="item.label_ids"
                                    allowClear
                                    mode="multiple"
                                    :style="{width:pane.product_modules.length > 1 ? '96%': '100%'}"
                                    placeholder="请选择">
                            <a-select-option v-for="item2 in item.moduleTags"
                                            :title="item2.description"
                                            :key="item2.id">{{item2.name}}</a-select-option>
                        </a-select>
                         </a-form-model-item>
                    </a-col>
                      <span class="iconfont del"
                            v-if="pane.product_modules.length > 1"
                            @click="() => remove2(index)">&#xe631;</span>
               </a-row>
            </div>
            -->

              </div>
            </div>
            <div class="con">

              <div class="info">
                <a-row class="form-row">
                  <a-col :lg="12"
                         :md="12"
                         :sm="24"
                         style="padding-right: 40px">
                    <div class="ant-form-item-label"
                         style="width:100%;text-align:left;">
                      <span class="fz12" style="color: rgba(0, 0, 0, 0.85);">项目来源 :<span style="color:#f88d49;margin-left:10px"> 若为项目诉求，请正确选择对应项目! </span></span>
                    </div>
                    <a-select showSearch
                              allowClear
                              placeholder="请选择"
                              style="width:100%"
                              v-model="pane.source_project_name"
                              @change="handleChange4"
                              @search="serchFocus"
                              :filterOption="false"
                              @popupScroll="popupScroll">
                      <a-select-option v-for="item2 in projectsData.projectList"
                                       :key="JSON.stringify(item2)">
                       <img src="@/assets/images/daily.png" v-if="item2.type == 0">
                       <img src="@/assets/images/key.png" v-if="item2.type == 1">
                       {{item2.name}}
                        </a-select-option>
                      <!--<a-spin v-if="loading" class="loading"/>-->
                    </a-select>
                  </a-col>

                  <a-col :lg="12"
                         :md="12"
                         :sm="24"
                         >
                    <a-form-item label="需要ta关注：">
                      <multiplePeopleSelect @getValue2="getCareValue"
                                            :valueData="pane.attention_user_ids"
                                            :searchData="pane.searchUser"
                                            ></multiplePeopleSelect>
                    </a-form-item>
                  </a-col>
                </a-row>

              </div>
            </div>
            <div class="con">
              <h3>诉求描述</h3>
                <div class="claimDescription">
                    <p class="claimDescription-title"><span style="color:red">*</span> 诉求描述：</p>
                    <p class="claimDescription-title2"><span class="icon iconfont down">&#xe654;</span>请从以下几点详细描述你的诉求</p>
                    <ul v-if="pane.type==4">
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
              <a-form-model-item prop="pane.content" :rules="[{ required: true, message: '请填写诉求描述', trigger: 'blur' }]">
                <div class="con"
                    style="padding:0;">

                        <div style="height: 350px;">
                        <myEditor v-model="pane.content"></myEditor>
                        </div>

                </div>
              </a-form-model-item>
            </div>
            <div class="con">
              <h3>其他信息</h3>
              <a-row style="margin-bottom:10px;margin-top:20px">
                <span>附件:</span>
                <span @click="addFileInputList"
                      class="addFile">
                  <a-icon type="plus" />添加
                </span>
              </a-row>
              <div v-for="(item, index) in pane.media"
                   :key="index"
                   style="display:flex;margin-bottom:10px">
                <div class="fileInput">
                  <a-input :value="item.name"
                           disabled />
                </div>
                <div style="width: 68px;margin-right: 10px;">
                  <a-upload :showUploadList="false"
                            :beforeUpload="(file) => beforeUpload(file, index)">
                    <a-button size="small">选择文件</a-button>
                  </a-upload>
                </div>
                <div @click="() => removeFileInputList(index)"
                     class="delFile cup">
                  <span class="iconfont">&#xe64d;</span>
                </div>
              </div>
            </div>
            <div class="con"
                 style="margin-bottom:30px;">
              <p class="select-title2"><span class="icon iconfont down">&#xe654;</span>请确保拆解的所有诉求均已划分正确，内容完整，描述准确。
            </p>
              <el-checkbox class="select-title1"
                           v-model="pane.checked">我已了解</el-checkbox>
            </div>
           </a-form-model>
          </a-tab-pane>
        </a-tabs>
         <div class="con">
              <a-button @click="postForm"
                        :disabled="checkAll"
                        :class="{'disabled':checkAll}"
                        style="margin-right:20px;background:rgba(55,142,239,1)"
                        type="primary">发布</a-button>
              <a-button style="background:rgba(248,248,248,1);"
                        @click="goback">取消</a-button>
            </div>
      </div>

    </div>
  </div>
</template>
<style lang="less" scoped>
.disabled{
    color: #fff;
    opacity: .5;
}
.disabled:hover{
    color: #fff;
}
.delFile {
  line-height: 2.5;
}
.addFile {
  cursor: pointer;
  float: right;
  color: rgba(55, 142, 239, 1);
}
.add{
    position: relative;
    left: 1060px;
    top: 23px;
    cursor: pointer;
    z-index: 100;
    color: rgba(55, 142, 239, 1);
}
.del{
    font-size: 12px;
    cursor: pointer;
    position: relative;
    left: 1088px;
    top: -38px;
}
.addclaim {
  top: 10px;
  right: 40px;
  font-size: 14px;
  position: relative;
  cursor: pointer;
  z-index: 10;
}
.fileInput {
  width: 1040px;
  margin-right: 10px;
}
.modal {
  text-align: left;
  position: absolute;
  top: 46px;
  right: 0px;
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
    height: 34px;
    color: #fff;
    font-size: 14px;
    background: rgba(55, 142, 239, 1);
    border-radius: 3px;
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
/deep/ .el-dialog__headerbtn .el-dialog__close {
  color: #999;
  font-size: 20px;
}
/deep/ .el-dialog__headerbtn {
  top: 14px;
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
.eidt-tips p {
  position: relative;
  color: #f88d49;
  font-size: 12px;
  background: #fff2ea;
  border: 1px solid #ffd8bf;
  border-radius: 5px;
  padding: 8px 8px;
  padding-right: 16px;
  margin-bottom: 15px;
}
.eidt-tips .down {
  cursor: pointer;
  display: inline-block;
  right: 0;
  position: absolute;
  top: 33%;
  right: 6px;
}
.radio_box p {
  color: #666;
  font-size: 12px;
  padding-bottom: 0;
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
  padding: 0 10px 10px 10px;

  h3 {
    font-size: 14px;
    font-family: Microsoft YaHei;
    font-weight: bold;
    color: rgba(51, 51, 51, 1);
    margin-bottom: 24px;
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
      background: rgba(255, 219, 219, 1);
      color: rgba(255, 74, 74, 1);
      margin-right: 10px;
    }
    .button-selects-green {
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
    .claimDescription-title {
      color: #666666;
      font-size: 12px;
    }
    .claimDescription-title2 {
      font-size: 12px;
      color: #f88d49;
      margin: 10px 0;
      span {
        margin-right: 4px;
        position: relative;
        top: 2px;
      }
    }
    ul {
      display: flex;
      flex-wrap: wrap;
      li {
        color: #f88d49;
        font-size: 12px;
        width: 25%;
        margin-bottom: 10px;
      }
    }
  }
  .select-title2 {
    font-size: 12px;
    color: #f88d49;
      margin-top:10px;
    span {
      margin-right: 4px;
      position: relative;
      top: 2px;
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
</style>
<script>
import { allow, allowSize } from '@/plugins/common.js'
import myEditor from '@/components/myEditor'
import moment from 'moment'
import multiplePeopleSelect from '@/components/multiplePeopleSelect'
import { claimDetial, splitClaim } from '../../../api/recount'
import { getProducts } from '../../../api/RDmanagement/ProductMaintenance/index.js'
import { getAllprojects } from '../../../api/RDmanagement/project'
// import addRelatedProducts from './components/addRelatedProducts'
const plainOptions = ['产品', '设计', '测试', '开发', '业务']

const panes = [
  {
    title: '拆解1',
    key: 1,
    name: '',
    brief: '44',
    content: '',
    type: '',
    productsLine_id: undefined,
    product_id: undefined,
    is_urgent: '',
    is_important: '',
    // product_modules: [{ module_id: undefined, label_ids: [], moduleTags: [] }],
    questions: { urgent: [], important: [] },
    source_project_id: undefined,
    source_project_name: undefined,
    attention_user_ids: [],
    media: [{ name: '', file: null }],
    checked: false,
    products: [],
    modules: [],
    moduleTags: []
  },
  {
    title: '拆解2',
    key: 2,
    name: '',
    brief: '44',
    content: '',
    type: '',
    productsLine_id: undefined,
    product_id: undefined,
    is_urgent: '',
    is_important: '',
    // product_modules: [{ module_id: undefined, label_ids: [], moduleTags: [] }],
    questions: { urgent: [], important: [] },
    source_project_id: undefined,
    source_project_name: undefined,
    attention_user_ids: [],
    media: [{ name: '', file: null }],
    checked: false,
    products: [],
    modules: [],
    moduleTags: []
  }

]
export default {
  components: { myEditor, multiplePeopleSelect },
  data () {
    return {
      btnForm1: this.$form.createForm(this, { name: 'btn1' }),
      btnForm2: this.$form.createForm(this, { name: 'btn2' }),
      btnShow: false,
      btnShow2: false,
      formData: {},
      textarea: '',
      btnLoad: false,
      rules: { textarea: [{ required: true, message: '请输入备注', trigger: 'blur' }] },
      selecttext: 'rrrr',
      dialogVisible: false,
      panes,
      size: 'default',
      fileList: [],
      fileInputList: [{ name: '', file: null }],
      form2: {
        name: '',
        brief: '',
        content: '',
        type: '',
        is_urgent: '',
        is_important: '',
        questions: { urgent: [], important: [] },
        source_project_id: '',
        source_project_name: '',
        product_id: '',
        attention_user_ids: [],
        media: ''
      },
      datas: [],
      plainOptions,
      checkedList: [],
      value: 1,
      checked: false,
      statusbut1: false,
      statusbut2: false,
      productsLine: [],
      projectsData: {
        projectList: [],
        total: '',
        page: 1,
        totalPages: null
      },
      loading: false,
      activeKey: panes[0].key,
      newTabIndex: 0
    }
  },
  watch: {
    activeKey (newVal) {
      this.activeKey = newVal
    }
  },
  computed: {
    checkAll () {
      // 如果数组中有一个没勾选,就不能发布
      let notAllow = this.panes.some(value => {
        return value.checked === false
      })
      return notAllow
    }
  },
  created () {
    this.getclaimdetial(this.$route.query.id, 0)
    this.getclaimdetial(this.$route.query.id, 1)
    getProducts().then(res => {
      this.productsLine = res.data.products
    })
  },
  methods: {
    // loadData (selectedOptions) {
    //   const targetOption = selectedOptions[selectedOptions.length - 1]
    //   targetOption.loading = true
    //   getProducts(targetOption.id).then(res => {
    //     targetOption.loading = false
    //     targetOption.children = res.data.products.map(item => {
    //       return { id: item.id, name: item.name, isLeaf: true }
    //     })
    //     this.panes[this.activeKey - 1].modules = [...this.panes[this.activeKey - 1].modules]
    //   })
    // },
    ok () {
      this.$refs['ruleForm'].validate((valid) => {
        if (valid) {
          this.btnLoad = true
          this.formData.append('comment', this.textarea)
          splitClaim(this.formData, this.$route.query.id).then(data => {
            if (data.code === 200) {
              this.$message.success('诉求拆分成功')
              this.$router.push({ name: 'recountindex' })
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
    onChange (checkedValues) {
    },
    // 同时校验表单
    getFormPromise (form) {
      return new Promise(resolve => {
        form.validate(res => {
          resolve(res)
        })
      })
    },
    postForm () {
      const arr = []
      this.panes.forEach(item => {
        let rules = 'ruleForm' + item.key
        arr.push(this.$refs[rules][0])
      })
      // 使用Promise.all去校验结果
      Promise.all(arr.map(this.getFormPromise)).then(res => {
        const validateResult = res.every(item => !!item)
        if (validateResult) {
          let formData = new FormData()
          this.panes.map((item, key) => {
            this.removeProperty(this.panes[key])
            formData.append('appeals[' + key + '][name]', item.name)
            formData.append('appeals[' + key + '][content]', item.content)
            formData.append('appeals[' + key + '][type]', item.type)
            if (item.source_project_id) {
              formData.append('appeals[' + key + '][source_project_id]', item.source_project_id)
              formData.append('appeals[' + key + '][source_project_name]', item.source_project_name)
            }
            formData.append('appeals[' + key + '][product_id]', item.product_id)
            /* .map((item2, key2) => {
              if (item2.module_id) {
                formData.append('appeals[' + key + '][product_modules][' + key2 + '][module_id]', item2.module_id)
              }
              if (item2.label_ids) {
                item2.label_ids.map((k, index) => {
                  if (k) {
                    formData.append('appeals[' + key + '][product_modules][' + key2 + '][label_ids][' + index + ']', k)
                  }
                })
              }
            }) */
            if (this.form2.is_urgent) {
              formData.append('appeals[' + key + '][is_urgent]', 1)
              this.form2.questions.urgent.map((item2, key2) => {
                formData.append('appeals[' + key + '][questions][urgent][' + key2 + '][question]', item2.question)
                formData.append('appeals[' + key + '][questions][urgent][' + key2 + '][answer]', item2.answer)
              })
            }
            if (this.form2.is_important) {
              formData.append('appeals[' + key + '][is_important]', 1)
              this.form2.questions.important.map((item2, key2) => {
                formData.append('appeals[' + key + '][questions][important][' + key2 + '][question]', item2.question)
                formData.append('appeals[' + key + '][questions][important][' + key2 + '][answer]', item2.answer)
              })
            }

            item.attention_user_ids.forEach((item2, key2) => {
              if (item2) {
                formData.append('appeals[' + key + '][attention_user_ids][]', item2)
              }
            })
            item.media.forEach((item2, key2) => {
              if (item2.file) {
                formData.append('appeals[' + key + '][media][]', item2.file)
              }
            })
          })
          //   确定拆分弹框
          this.dialogVisible = true
          this.formData = formData
        } else {
          this.$message.error('请填写必填项')
        }
      })
    },
    async getclaimdetial (id, keys) {
      await claimDetial(id).then(data => {
        this.datas = data.data.appeals
        this.panes[keys].name = this.datas.name
        this.panes[keys].type = this.datas.type
        this.panes[keys].brief = this.datas.brief
        this.panes[keys].content = this.datas.content
        if (this.datas.is_urgent === 1) {
          this.form2.is_urgent = this.datas.is_urgent
          this.form2.questions.urgent = JSON.parse(this.datas.questions).urgent
          this.statusbut1 = true
        }
        if (this.datas.is_important === 1) {
          this.form2.is_important = this.datas.is_important
          this.form2.questions.important = JSON.parse(this.datas.questions).important
          this.statusbut2 = true
        }
        this.panes[keys].source_project_id = this.datas.source_project_id
        this.panes[keys].source_project_name = this.datas.source_project_name

        this.panes[keys].attention_user_ids = this.datas.user_attentions

        // ----------------
        let attentionIds = []
        let Arr = []
        this.datas.user_attentions.forEach(item => {
          let data = {}
          data.id = item.user_id
          data.name = item.user_name
          Arr.push(data)
          attentionIds.push(item.user_id)
        })
        // 需要ta关注回显处理
        this.panes[keys].attention_user_ids = attentionIds
        this.panes[keys].searchUser = Arr
        // --------------------------
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    handleProvinceChange (value) {
      this.panes[this.activeKey - 1].product_id = undefined
      /* const data = this.panes[this.activeKey - 1].product_modules
      this.panes[this.activeKey - 1].product_modules = data.map((item, key) => {
        return { module_id: undefined, label_ids: [], moduleTags: [] }
      }) */
      this.panes[this.activeKey - 1].modules = []
      this.panes[this.activeKey - 1].moduleTags = []
      getProducts(value).then(res => {
        this.panes[this.activeKey - 1].products = res.data.products
      })
    },
    handleProvinceChange2 (value) {
      /* const data = this.panes[this.activeKey - 1].product_modules
      this.panes[this.activeKey - 1].product_modules = data.map((item, key) => {
        return { module_id: undefined, label_ids: [], moduleTags: [] }
      }) */
      this.panes[this.activeKey - 1].moduleTags = []
      getProducts(value).then(res => {
        this.panes[this.activeKey - 1].modules = res.data.products
      })
    },
    /* handleProvinceChange3 (value, index) {
      const data = this.panes[this.activeKey - 1].product_modules
      this.panes[this.activeKey - 1].product_modules = data.map((item, key) => {
        if (key === index) {
          return { module_id: item.module_id, label_ids: [], moduleTags: item.moduleTags }
        } else {
          return item
        }
      })
      getProducts(value).then(res => {
        this.panes[this.activeKey - 1].product_modules[index].moduleTags = res.data.products
      })
    },
    addModules () {
      this.panes[this.activeKey - 1].product_modules.push({ module_id: undefined, label_ids: [], moduleTags: [] })
    },
    remove2 (e) {
      this.panes[this.activeKey - 1].product_modules.splice(e, 1)
    }, */
    handleChange4 (value) {
      //          let name ='refname'+value;
      this.panes[this.activeKey - 1].source_project_name = JSON.parse(value).name
      this.panes[this.activeKey - 1].source_project_id = JSON.parse(value).id
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
          params = {
            page: this.projectsData.page,
            limit: 30
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
      if (e.target.scrollTop + e.target.offsetHeight === e.target.scrollHeight) {
        this.proJectList(null)
      }
    },

    beforeUpload (file, index) {
      const size = file.size / (1024 * 1024)
      const name = file.name.substring(file.name.lastIndexOf('.'))
      if (size > allowSize) {
        this.$message.error('上传文件不得超过' + allowSize + 'm')
      } else if (allow.indexOf(name) === -1) {
        this.$message.error('上传文件格式不正确')
      } else {
        this.panes[this.activeKey - 1].media[index].file = file
        this.panes[this.activeKey - 1].media[index].name = file.name
        let a = this.panes.map(item => {
          return item.media
        })
        console.log(a)
      }
      return false
    },
    addFileInputList () {
      const object = {
        name: '',
        file: null
      }
      //   this.fileInputList.push(object)
      this.panes[this.activeKey - 1].media.push(object)
    },
    removeFileInputList (index) {
    //   this.fileInputList.splice(index, 1)
      this.panes[this.activeKey - 1].media.splice(index, 1)
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
    removeProperty (object) {
      for (let key in object) {
        if (object[key] === '') {
          delete object[key]
        }
      }
    },
    // 拆分的方法

    onEdit (targetKey, action) {
      this[action](targetKey)
    },
    add () {
      if (this.newTabIndex == 0) {
        this.newTabIndex = 3
      }
      const panes = this.panes
      if (this.panes.length < 5) {
        const activeKey = `${this.newTabIndex++}`
        panes.push({
          title: `拆解 ${activeKey}`,
          key: activeKey,
          name: '',
          brief: '',
          content: '',
          type: '',
          productsLine_id: undefined,
          product_id: undefined,
          is_urgent: '',
          is_important: '',
          // product_modules: [{ module_id: undefined, label_ids: [], moduleTags: [] }],
          questions: { urgent: [], important: [] },
          source_project_id: undefined,
          source_project_name: undefined,
          attention_user_ids: [],
          media: [{ name: '', file: null }],
          checked: false,
          products: [],
          modules: [],
          moduleTags: []
        })

        this.panes = panes
        this.activeKey = activeKey
        this.getclaimdetial(this.$route.query.id, this.activeKey - 1)
      } else {
        this.$message.error('最多只能拆解5个')
        return false
      }
    },
    remove (targetKey) {
      let activeKey = this.activeKey
      let lastIndex
      if (this.panes.length === 2) {
        this.$message.error('最少保留一个拆分项目')
        return false
      }
      const panes = this.panes.filter(pane => pane.key !== targetKey)
      if (panes.length && activeKey === targetKey) {
        if (lastIndex >= 0) {
          activeKey = panes[lastIndex].key
        } else {
          activeKey = panes[0].key
        }
      }
      this.panes = panes
      this.activeKey = activeKey
    },
    getCareValue (e) {
      this.panes[this.activeKey - 1].attention_user_ids = e
    }
  },
  mounted () {
    // 获取项目列表
    // 获取项目
    getAllprojects({ page: 1, limit: 30 }).then(res => {
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
