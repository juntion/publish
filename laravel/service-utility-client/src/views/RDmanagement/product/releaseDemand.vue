<template>
  <div>
    <a-form :form="form">
      <div class="box">
        <div class="header">
          <h1>发布需求</h1>
          <p v-if="tip">
            请进行完整的产品分析流程后，仔细编写需求内容以及上传需求文档！
            <!-- <span class="icon iconfont down"
                  @click="close">&#xe631;</span> -->
          </p>
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
                  <span slot="label">需求标题</span>
                  <!-- v-model="form1.name"  -->
                  <a-input placeholder="请输入需求标题,简洁清晰,突出要点"
                            :maxLength="40"
                            v-decorator="['name', { rules: [{ required: true, message: '请输入需求标题' },{ max:40,message: '* 请将需求标题控制在40个字符以内', }] }]" />
                </a-form-item>
              </a-col>
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 10px">
                <a-form-item label="优先级">

                  <a-select v-decorator="['priority']"
                            placeholder="请选择"
                            style="width: 100%">
                    <a-select-option :value="1"><span class="button_box_text"> 1</span><span class="after" style="color:#FF4A4A;float:right">高</span></a-select-option>
                    <a-select-option :value="2"><span class="button_box_text button_box_color2"> 2</span></a-select-option>
                    <a-select-option :value="3"><span class="button_box_text button_box_color3"> 3</span></a-select-option>
                    <a-select-option :value="4"><span class="button_box_text button_box_color4"> 4</span></a-select-option>
                    <a-select-option :value="5"><span class="button_box_text button_box_color5"> 5</span><span class="after" style="color:#BBBBBB;float:right">低</span></a-select-option>
                  </a-select>
                </a-form-item>
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
                        <!-- {{sqProduct}} -->
                         <a-popover
                          v-model="visible"
                          v-if="$route.query.sqId"
                          :getPopupContainer="triggerNode => triggerNode.parentNode"
                          trigger="click">
                            <template slot="content">
                                <div>
                                    <p style="color:#bbb">诉求产品分类:</p>
                                    <p v-for="(item,sqIndex) in sqProduct" :key="sqIndex">
                                        <span>{{item.product_line.name}} / {{item.product.name}}</span>
                                        <span v-if="item.product_modules.length"> / </span>
                                        <span v-for="(k,index) in item.product_modules" :key="k.id">
                                            {{k.name}}
                                            (<span v-for="(k2,index2) in k.product_labels" :key="index2">
                                                {{k2.name}}<span v-if="index2 !== k.product_labels.length-1">、</span>
                                            </span> )
                                            <span v-if="index !== item.product_modules.length-1">;</span>
                                        </span>
                                        <span> / </span>
                                        ( {{Array.isArray($route.query.sqNumber) ? $route.query.sqNumber[sqIndex] :  $route.query.sqNumber}} )</p>
                                </div>
                            </template>
                            <a-select
                                    v-decorator="['productsLine', { rules: [{ required: true, message: '请选择所属产品线' }] }]"
                                    @change="handleProvinceChange"
                                    placeholder="请选择">
                                <a-select-option v-for="k in productsLine"
                                                :title="k.description"
                                                :key="k.id">{{k.name}}</a-select-option>
                            </a-select>
                        </a-popover>
                        <a-select
                                    v-else
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
                        style="padding-right: 10px"
                        >
                        <a-form-item>
                                <span slot="label">产品名称</span>
                                <a-popover
                                    v-if="$route.query.sqId"
                                    :getPopupContainer="triggerNode => triggerNode.parentNode"
                                    trigger="click">
                                    <template slot="content">
                                        <div>
                                            <p style="color:#bbb">诉求产品分类:</p>
                                            <p v-for="(item,sqIndex) in sqProduct" :key="sqIndex">
                                                <span>{{item.product_line.name}} / {{item.product.name}}</span>
                                                <span v-if="item.product_modules.length"> / </span>
                                                <span v-for="(k,index) in item.product_modules" :key="k.id">
                                                    {{k.name}}
                                                    (<span v-for="(k2,index2) in k.product_labels" :key="index2">
                                                        {{k2.name}}<span v-if="index2 !== k.product_labels.length-1">、</span>
                                                    </span> )
                                                    <span v-if="index !== item.product_modules.length-1">;</span>
                                                </span>
                                                <span> / </span>
                                                ( {{Array.isArray($route.query.sqNumber) ? $route.query.sqNumber[sqIndex] :  $route.query.sqNumber}} )</p>
                                        </div>
                                    </template>
                                        <a-select
                                            v-decorator="['products', { rules: [{ required: true, message: '请选择所属产品' }] }]"
                                            placeholder="请选择"
                                            @change="handleProvinceChange2">
                                            <a-select-option v-for="item in products"
                                                            :title="item.description"
                                                            :key="item.id">{{item.name}}</a-select-option>
                                        </a-select>
                                </a-popover>
                                <a-select
                                    v-else
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
            <div class="eidt-add-bottom">
                <span class="add" @click="addModules"><a-icon type="plus" />添加</span>
                <a-row v-for="(item,index) in form1.product_modules" :key="index" class="form-row">
                <a-col
                    :lg="12"
                    :md="12"
                    :sm="24"
                    style="padding-right:40px">
                    <a-form-item style="margin-bottom:4px;">
                        <span slot="label" v-if="index===0">模块名称</span>
                        <!-- <a-cascader
                                :options="modules"
                                :loadData="loadData"
                                placeholder="请选择"
                                v-decorator="['product_id']"
                                changeOnSelect
                            /> -->
                        <a-popover
                                    v-if="$route.query.sqId"
                                    :getPopupContainer="triggerNode => triggerNode.parentNode"
                                    trigger="click">
                                    <template slot="content">
                                        <div>
                                            <p style="color:#bbb">诉求产品分类:</p>
                                            <p v-for="(item,sqIndex) in sqProduct" :key="sqIndex">
                                                <span>{{item.product_line.name}} / {{item.product.name}}</span>
                                                <span v-if="item.product_modules.length"> / </span>
                                                <span v-for="(k,index) in item.product_modules" :key="k.id">
                                                    {{k.name}}
                                                    (<span v-for="(k2,index2) in k.product_labels" :key="index2">
                                                        {{k2.name}}<span v-if="index2 !== k.product_labels.length-1">、</span>
                                                    </span> )
                                                    <span v-if="index !== item.product_modules.length-1">;</span>
                                                </span>
                                                <span> / </span>
                                                ( {{Array.isArray($route.query.sqNumber) ? $route.query.sqNumber[sqIndex] :  $route.query.sqNumber}} )</p>
                                        </div>
                                    </template>
                                       <a-select   v-model="item.module_id"
                                                    allowClear
                                                    @change="handleProvinceChange3($event,index)"
                                                    placeholder="请选择">
                                            <a-select-option v-for="item in modules"
                                                            :title="item.description"
                                                            :key="item.id">{{item.name}}</a-select-option>
                                        </a-select>
                                </a-popover>
                                <a-select   v-model="item.module_id"
                                            allowClear
                                            v-else
                                            @change="handleProvinceChange3($event,index)"
                                            placeholder="请选择">
                                    <a-select-option v-for="item in modules"
                                                    :title="item.description"
                                                    :key="item.id">{{item.name}}</a-select-option>
                                </a-select>
                    </a-form-item>
                    </a-col>
                <a-col :lg="12"
                    :md="12"
                    :sm="24"
                    style="padding-right: 10px"
                    >
                    <a-form-item style="margin-bottom:6px;">
                    <span slot="label" v-if="index===0">模块标签</span>
                    <a-popover
                                    v-if="$route.query.sqId"
                                    :getPopupContainer="triggerNode => triggerNode.parentNode"
                                    trigger="click">
                                    <template slot="content">
                                        <div>
                                            <p style="color:#bbb">诉求产品分类:</p>
                                            <p v-for="(item,sqIndex) in sqProduct" :key="sqIndex">
                                                <span>{{item.product_line.name}} / {{item.product.name}}</span>
                                                <span v-if="item.product_modules.length"> / </span>
                                                <span v-for="(k,index) in item.product_modules" :key="k.id">
                                                    {{k.name}}
                                                    (<span v-for="(k2,index2) in k.product_labels" :key="index2">
                                                        {{k2.name}}<span v-if="index2 !== k.product_labels.length-1">、</span>
                                                    </span> )
                                                    <span v-if="index !== item.product_modules.length-1">;</span>
                                                </span>
                                                <span> / </span>
                                                ( {{Array.isArray($route.query.sqNumber) ? $route.query.sqNumber[sqIndex] :  $route.query.sqNumber}} )</p>
                                        </div>
                                    </template>
                                      <a-select   v-model="item.label_ids"
                                                mode="multiple"
                                                allowClear
                                                :style="{width:form1.product_modules.length > 1 ? '96%': '100%'}"
                                                placeholder="请选择">
                                        <a-select-option v-for="item2 in item.moduleTags"
                                                        :title="item2.description"
                                                        :key="item2.id">{{item2.name}}</a-select-option>
                                    </a-select>
                                </a-popover>
                                <a-select   v-model="item.label_ids"
                                            mode="multiple"
                                            v-else
                                            allowClear
                                            :style="{width:form1.product_modules.length > 1 ? '96%': '100%'}"
                                            placeholder="请选择">
                                    <a-select-option v-for="item2 in item.moduleTags"
                                                    :title="item2.description"
                                                    :key="item2.id">{{item2.name}}</a-select-option>
                                </a-select>
                    </a-form-item>
                </a-col>
                    <span class="iconfont del"
                        v-if="form1.product_modules.length > 1"
                        @click="() => remove(index)">&#xe631;</span>
                </a-row>
            </div>

            <a-row>
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 40px">
                <a-form-item class="colon">
                  <span class="fz12" slot="label">预计纳入版本 :<span style="color:#f88d49;margin-left:10px"> 选择预期想在哪个版本进行发布上线，非特殊要求，不要选择已发布测试的版本! </span></span>
                  <GroupSelect v-model="form1.release_version_ids" :productId="form.getFieldValue('products') ? form.getFieldValue('products') : form.getFieldValue('productsLine')"></GroupSelect>
                </a-form-item>
              </a-col>
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 10px">
                <a-form-item label="目标交付日期">
                  <!-- v-model="form1.expiration_date" -->
                  <a-date-picker style="width:100%"
                                 format="YYYY/MM/DD"
                                 :disabledDate="disabledDate"
                                 v-decorator="['expiration_date']"
                                 type="date"
                                 placeholder="选择日期">
                  </a-date-picker>
                </a-form-item>
              </a-col>
            </a-row>
            <a-row>
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 40px">
                <a-form-item class="colon">
                  <span class="fz12" slot="label">项目来源 :<span style="color:#f88d49;margin-left:10px"> 若为项目诉求，请正确选择对应项目! </span></span>
                  <a-select showSearch
                            allowClear
                            placeholder="请选择"
                            style="width:100%"
                            v-decorator="['source_project_name']"
                            @search="serchFocus"
                            :filterOption="false"
                            @popupScroll="popupScroll">
                    <a-select-option v-for="item in projectsData.projectList"
                                     :key="JSON.stringify(item)">
                       <img src="@/assets/images/daily.png" v-if="item.type == 0">
                       <img src="@/assets/images/key.png" v-if="item.type == 1">
                       {{item.name}}
                     </a-select-option>
                  </a-select>
                </a-form-item>
              </a-col>
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 10px">
                <a-form-item>
                  <span slot="label"> 需要ta关注</span>
                  <!-- v-decorator="['attention_user_ids', {  type: 'array',rules: [{ required: true, message: '请选择关注人' }] }]" -->
                  <multiplePeopleSelect @getValue2="getCareValue"></multiplePeopleSelect>
                </a-form-item>
              </a-col>
            </a-row>

          </div>

        </div>

        <div class="con">
          <h3>需求描述</h3>
          <p class="mb10"> <span style="color:#FF0000">*</span> 需求描述 :<span style="color:#f88d49;margin-left:10px">根据工作规范要求，文本编辑器内精简概括需求背景与要点即可；完整需求描述，务必使用需求文档！</span></p>
          <a-form-item :validate-status="validateStatus.contents"
                       :help="validateStatus.contentsTxt">
            <div style="height: 350px;">
              <!-- v-decorator="['content', { rules: [{ required: true, message: '请输入需求描述' }] }]" -->
              <myEditor v-model="form1.content"
                        placeholder="请输入需求描述"
                        :class="{'active' : active}"></myEditor>
            </div>
            <!-- <p class="txt">* 按照要求，需求文档为必要内容，请维护相关文档。</p> -->
          </a-form-item>
        </div>
        <div class="con">
          <h3 class="eidt-margin">研发团队</h3>
          <a-form-item>
            <div class="info" style="">
              <p style="height:24px;"> <span style="color:#FF0000">*</span> 研发环节:</p>

              <div class="fz12">
                <a-checkbox-group :options="plainOptions"
                                  @change="changeList"
                                  v-decorator="['checkedList',{ rules: [{ required: true, message: '请至少选择一个环节' }] }]" />
              </div>
              <div v-if="checkedList.indexOf('测试') !== -1">
                <p style="height:24px;"><span style="color:#FF0000">*</span> 测试人员:</p>
                <div class="fz12" style="height: 34px;">
                  <a-radio-group v-model="form1.demand_links.test.group">
                    <a-radio :value="0">测试团队</a-radio>
                    <a-radio :value="1">产品自测</a-radio>
                  </a-radio-group>
                </div>
              </div>
              <div v-if="checkedList.indexOf('设计') !== -1">
                <p class="mb4" style="height:30px">产品备注(设计):</p>
                <a-input placeholder="需要设计关注的"
                         v-model="form1.demand_links.design.comment"
                         class="mb6" />
              </div>

              <div v-if="checkedList.indexOf('程序') !== -1">
                <p class="mb4" style="height:30px">产品备注(开发):</p>
                <a-input placeholder="需要开发关注的"
                         v-model="form1.demand_links.dev.comment"
                         class="mb6" />
              </div>

              <div v-if="checkedList.indexOf('测试') !== -1">
                <p class="mb4" style="height:30px">产品备注(测试):</p>
                <a-input placeholder="需要测试关注的"
                         v-model="form1.demand_links.test.comment"
                         class="mb6" />
              </div>
            </div>
          </a-form-item>
        </div>
        <div class="con eidt-con-margin">
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
            <div v-for="(item, index) in form1.share_address"
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
            <span><span style="color:red" v-if="checkedList.indexOf('程序') !== -1">*</span> 需求文档 :<span style="color:#f88d49;margin-left:10px">涉及考核标准，请按照规定，维护好需求文档！</span></span>
            <span @click="addFileInputList"
                  class="addFile">
              <a-icon type="plus" />添加</span>
          </a-row>
          <a-form-item :validate-status="validateStatus.media"
                       :help="validateStatus.mediaTxt">
            <div v-for="(item, index) in fileInputList"
                 :key="index"
                 style="display:flex;margin-bottom:10px">
              <div class="fileInput">
                <a-input :value="item.name"
                        placeholder="请选择文档"
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
          </a-form-item>
        </div>
        <div class="con" style="padding-bottom:30px;">
          <a-button @click="postForm"
                    :loading="btnLoad"
                    style="margin-right:20px;background:rgba(55,142,239,1)"
                    type="primary">申请立项</a-button>
          <a-button style="background:rgba(248,248,248,1);"
                    @click="goback">取消</a-button>
        </div>
      </div>
    </a-form>
  </div>
</template>

<style lang="less" scoped>
/deep/.el-input--prefix .el-input__inner {
  height: 32px;
}
/deep/.ant-popover-inner-content{
    padding: 10px;
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

.eidt-add-bottom .form-row {
    // height:48px;
    margin-bottom: -20px;
    margin-top: -25px;
}
.con .eidt-margin{
    margin-bottom: 12px;
}
.eidt-con-margin{
    padding-top:24px;
    padding-bottom:0;
    margin-bottom: 0;
}
</style>
<script>
import moment from 'moment'
import myEditor from '@/components/myEditor'
import { getProducts } from '../../../api/RDmanagement/ProductMaintenance/index.js'
import { postDemands, postClaimDemands } from '../../../api/RDmanagement/product/index.js'
import { getAllprojects } from '@/api/RDmanagement/project'
import multiplePeopleSelect from '@/components/multiplePeopleSelect'
import GroupSelect from '@/components/GroupSelect'
import { allow, allowSize } from '@/plugins/common.js'
const plainOptions = ['设计', '程序', '测试']
export default {
  components: { myEditor, multiplePeopleSelect, GroupSelect },
  data () {
    return {
      sqProduct: JSON.parse(localStorage.getItem('sqProduct')),
      visible: false,
      btnLoad: false,
      active: false,
      productsData: undefined,
      tip: true,
      form: this.$form.createForm(this, { name: 'releaseDemand' }),
      validateStatus: {
        media: 'success',
        mediaTxt: '',
        contents: 'success',
        contentsTxt: ''
      },
      fileList: [],
      fileInputList: [{ name: '', file: null }],
      urlInputList: [],
      productsLine: [],
      products: [],
      modules: [],
      moduleTags: [],
      productsLine_id: undefined,
      products_id: undefined,
      projectsData: {
        projectList: [],
        total: '',
        page: 1,
        totalPages: null
      },
      form1: {
        name: '',
        product_id: undefined,
        expiration_date: '',
        content: '<p><strong>需求背景：</strong></p><p><br></p><p><br></p><p><br></p><p><strong>需求概要：</strong></p><p><br></p><p><br></p><p><br></p><p>详细需求内容请查看需求文档！</p><p><br></p>',
        share_address: [
          { value: '' }
        ],
        priority: undefined,
        product_modules: [{ module_id: undefined, label_ids: [], moduleTags: [] }],
        source_project_id: undefined,
        source_project_name: undefined,
        demand_links: {
          design: {
            comment: ''
          },
          dev: {
            comment: ''
          },
          test: {
            group: 0,
            comment: ''
          }
        },
        attention_user_ids: [],
        media: [],
        release_version_ids: []
      },
      plainOptions,
      checkedList: [],
      value: 1
    }
  },
  computed: {

  },
  watch: {
    'form1.content' (newValue, oldValue) {
      if (newValue) {
        this.validateStatus.contents = 'success'
        this.validateStatus.contentsTxt = ''
        this.active = false
      } else {
        this.validateStatus.contents = 'error'
        this.validateStatus.contentsTxt = '请填写需求描述'
        this.active = true
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
  mounted () {
    getProducts().then(res => {
      this.productsLine = res.data.products
    })
    // 获取项目列表
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
  },
  methods: {
    moment,
    disabledDate (current) {
      // 不能选择今天以前的日期
      return current && current < moment().startOf('day')
    },
    changeList (e) {
      if (e.indexOf('程序') !== -1) {
        if (e.indexOf('测试') === -1) {
          e.push('测试')
        }
      }
      this.checkedList = e
    },
    close () {
      this.tip = false
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
      if (e.target.scrollTop + e.target.offsetHeight === e.target.scrollHeight) {
        this.proJectList(null)
      }
    },
    serchFocus (value) {
      this.projectsData.page = 0
      this.projectsData.projectList = []
      let values = '%' + value + '%'
      this.proJectList(values)
    },
    getCareValue (e) {
      this.form1.attention_user_ids = e
    },
    handleProvinceChange (value) {
      setTimeout(() => {
        this.form.setFieldsValue({
          'products': undefined
        })
      }, 0)
      const data = this.form1.product_modules
      this.form1.product_modules = data.map((item, key) => {
        return { module_id: undefined, label_ids: [], moduleTags: [] }
      })
      this.modules = []
      this.moduleTags = []
      getProducts(value).then(res => {
        this.products = res.data.products
      })
    },
    handleProvinceChange2 (value) {
      const data = this.form1.product_modules
      this.form1.product_modules = data.map((item, key) => {
        return { module_id: undefined, label_ids: [], moduleTags: [] }
      })
      this.moduleTags = []
      getProducts(value).then(res => {
        this.modules = res.data.products
      })
    },
    handleProvinceChange3 (value, index) {
      const data = this.form1.product_modules
      this.form1.product_modules = data.map((item, key) => {
        if (key === index) {
          return { module_id: item.module_id, label_ids: [], moduleTags: item.moduleTags }
        } else {
          return item
        }
      })
      if (value) {
        getProducts(value).then(res => {
          this.form1.product_modules[index].moduleTags = res.data.products
        })
      } else {
        this.form1.product_modules[index].moduleTags = []
      }
    },
    addModules () {
      this.form1.product_modules.push({ module_id: undefined, label_ids: [], moduleTags: [] })
    },
    remove (e) {
      this.form1.product_modules.splice(e, 1)
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
    onChange (checkedValues) {
    },
    // 提交前过滤空数据和undefined
    removeProperty (object) {
      for (let key in object) {
        if (object[key] === '') {
          delete object[key]
        } else if (object[key] === undefined) {
          delete object[key]
        }
      }
    },
    postForm () {
      this.form.validateFields((err, values) => {
        if (!this.form1.content) {
          this.validateStatus.contents = 'error'
          this.validateStatus.contentsTxt = '请输入需求描述'
          this.active = true
        }
        if (this.checkedList.indexOf('程序') !== -1) {
          if (this.fileInputList.length === 0) {
            this.validateStatus.media = 'error'
            this.validateStatus.mediaTxt = '请选择文件'
          }
          this.fileInputList.forEach(item => {
            if (item.file) {
              this.validateStatus.media = 'success'
              this.validateStatus.mediaTxt = ''
            } else {
              this.validateStatus.media = 'error'
              this.validateStatus.mediaTxt = '请选择文件'
            }
          })
        }

        if (!err && this.form1.content && this.validateStatus.media === 'success') {
          if (values.expiration_date) {
            values.expiration_date = values['expiration_date'].format('YYYY-MM-DD')
          }
          const formData = new FormData()
          if (values.checkedList.indexOf('设计') !== -1) {
            formData.append('demand_links[design][comment]', this.form1.demand_links.design.comment)
          }
          if (values.checkedList.indexOf('程序') !== -1) {
            formData.append('demand_links[dev][comment]', this.form1.demand_links.dev.comment)
          }
          if (values.checkedList.indexOf('测试') !== -1) {
            formData.append('demand_links[test][comment]', this.form1.demand_links.test.comment)
            formData.append('demand_links[test][group]', this.form1.demand_links.test.group)
          }
          formData.append('name', values.name)
          if (values.source_project_name) {
            let id = JSON.parse(values.source_project_name).id
            let name = JSON.parse(values.source_project_name).name
            formData.append('source_project_id', id)
            formData.append('source_project_name', name)
          }

          if (values.priority) {
            formData.append('priority', values.priority)
          }
          if (values.expiration_date) {
            formData.append('expiration_date', values.expiration_date)
          }
          formData.append('product_id', values.products)
          this.form1.product_modules.map((item, key) => {
            if (item.module_id) {
              formData.append('product_modules[' + key + '][module_id]', item.module_id)
            }
            if (item.label_ids) {
              item.label_ids.map((k, index) => {
                if (k) {
                  formData.append('product_modules[' + key + '][label_ids][' + index + ']', k)
                }
              })
            }
          })
          formData.append('content', this.form1.content)
          this.fileInputList.map(item => {
            if (item.file) {
              formData.append('media[]', item.file)
            }
          })
          this.form1.share_address.map(item => {
            if (item.value) {
              formData.append('share_address[]', item.value)
            }
          })
          this.form1.attention_user_ids.forEach(item => {
            formData.append('attention_user_ids[]', item)
          })
          this.form1.release_version_ids.map(item => {
            if (item) {
              formData.append('release_version_ids[]', item)
            }
          })
          if (!this.$route.query.sqId) {
            if (this.$route.query.bugId) {
              formData.append('source_bug_id', this.$route.query.bugId)
            }
            this.btnLoad = true
            postDemands(formData).then(res => {
              if (res.code === 200) {
                this.$message.success('发布需求成功')
                this.$router.push({ name: 'product' })
                this.btnLoad = false
              }
            }).catch(error => {
              this.btnLoad = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          } else {
            let appealIds = []
            if (Array.isArray(this.$route.query.sqId)) {
              appealIds = this.$route.query.sqId
            } else {
              appealIds.push(this.$route.query.sqId)
            }

            appealIds.forEach(item => {
              formData.append('appeal_ids[]', item)
            })
            this.btnLoad = true
            postClaimDemands(formData).then(res => {
              if (res.code === 200) {
                this.$message.success('诉求立项成功')
                this.$router.push({ name: 'product' })
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
      this.form1.share_address.push({ value: '' })
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
      this.form1.share_address.splice(index, 1)
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
