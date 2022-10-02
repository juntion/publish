<template>
  <div>
      <!-- 改变产品提示弹框 -->
      <!-- <a-modal title="提示"
                    class="modal-pms"
                   v-model="tipsShow"
                   :maskClosable="false"
                   destroyOnClose
                   width="380px">
            <div>
                <div>
                    <p style="margin-bottom: 20px;color: #F88E4A;">* 检测到所选产品发生变化，以下为最新产品绑定角色负责人与已选负责人不一致，是否需要同步更新？ </p>
                    <div v-if="this.check1 && designTeam.interactive">
                        <p class="marginB10">交互负责人:</p>
                        <a-input class="marginB20" :value="designTeam.interactive.user_name" disabled />
                    </div>
                    <div v-if="this.check2 && designTeam.visual">
                        <p class="marginB10">视觉负责人:</p>
                        <a-input class="marginB20" :value="designTeam.visual.user_name" disabled />
                    </div>
                    <div v-if="this.check3 && designTeam.front">
                        <p class="marginB10">前端负责人:</p>
                        <a-input class="marginB20" :value="designTeam.front.user_name" disabled />
                    </div>
                    <div v-if="this.check4 && designTeam.mobile">
                        <p class="marginB10">移动端负责人:</p>
                        <a-input class="marginB20" :value="designTeam.mobile.user_name" disabled />
                    </div>
                    <div v-if="this.check5 && designTeam.art">
                        <p class="marginB10">美工负责人:</p>
                        <a-input class="marginB20" :value="designTeam.art.user_name" disabled />
                    </div>
                    <p class="marginB10">是否需要更新:</p>
                    <a-radio-group v-model="isUpdate" >
                        <a-radio :value="0">
                            保持不变
                        </a-radio>
                        <a-radio :value="1">
                            同步更新
                        </a-radio>
                    </a-radio-group>
                </div>
            </div>
    </a-modal> -->

    <a-form-model :model="form1"  ref="ruleForm">
      <div class="box">
        <div class="header">
          <h1>{{$route.query.id ? '编辑' : '发布'}}设计内部任务</h1>
        </div>
          <p v-if="tip" class="tip">
            发布“设计内部任务”没有审核流程，发布后即可开始处理，内部任务无法流入其他研发角色（开发、测试）!
          </p>
        <div class="con">
          <h3><i class="tabs-ico"></i> 基本信息</h3>
          <div class="info">
            <a-row class="form-row">
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 40px">
                <a-form-model-item
                        prop="title"
                        label="任务标题"
                        :rules="[{ required: true, message: '请输入任务标题', trigger: 'blur' }]">
                  <a-input  placeholder="请输入任务标题,简洁清晰,突出要点"
                            :maxLength="40"
                            v-model="form1.title"
                            />
                </a-form-model-item>
              </a-col>
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 10px">
                <a-form-model-item
                    label="优先级"
                    prop="priority"
                   >

                  <a-select v-model="form1.priority"
                            placeholder="请选择"
                            style="width: 100%">
                    <a-select-option :value="1"><span class="button_box_text"> 1</span><span class="after" style="color:#FF4A4A;float:right">高</span></a-select-option>
                    <a-select-option :value="2"><span class="button_box_text button_box_color2"> 2</span></a-select-option>
                    <a-select-option :value="3"><span class="button_box_text button_box_color3"> 3</span></a-select-option>
                    <a-select-option :value="4"><span class="button_box_text button_box_color4"> 4</span></a-select-option>
                    <a-select-option :value="5"><span class="button_box_text button_box_color5"> 5</span><span class="after" style="color:#BBBBBB;float:right">低</span></a-select-option>
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
                        <a-form-model-item label="所属产品线" prop="product_line" :rules="[{ required: true, message: '请选择', trigger: 'change' }]">
                        <a-select   v-model="form1.product_line"
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
                        <a-form-model-item label="产品名称" prop="product_id"  :rules="[{ required: true, message: '请选择', trigger: 'change' }]">
                                <a-select
                                    v-model="form1.product_id"
                                    placeholder="请选择"
                                    @change="handleProvinceChange2">
                                    <a-select-option v-for="item in products"
                                                    :title="item.description"
                                                    :key="item.id">{{item.name}}</a-select-option>
                                </a-select>
                        </a-form-model-item>
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
                    <a-form-model-item style="margin-bottom:4px;">
                        <span slot="label" v-if="index===0">模块名称</span>
                        <a-select   v-model="item.module_id"
                                    allowClear
                                    @change="handleProvinceChange3($event,index)"
                                    placeholder="请选择">
                            <a-select-option v-for="item in modules"
                                            :title="item.description"
                                            :key="item.id">{{item.name}}</a-select-option>
                        </a-select>
                    </a-form-model-item>
                    </a-col>
                <a-col :lg="12"
                    :md="12"
                    :sm="24"
                    style="padding-right: 10px"
                    >
                    <a-form-model-item style="margin-bottom:6px;">
                    <span slot="label" v-if="index===0">模块标签</span>
                    <a-select   v-model="item.label_ids"
                                mode="multiple"
                                allowClear
                                :style="{width:form1.product_modules.length > 1 ? '96%': '100%'}"
                                placeholder="请选择">
                        <a-select-option v-for="item2 in item.moduleTags"
                                        :title="item2.description"
                                        :key="item2.id">{{item2.name}}</a-select-option>
                    </a-select>
                    </a-form-model-item>
                </a-col>
                    <span class="iconfont del"
                        v-if="form1.product_modules.length > 1"
                        @click="() => remove(index)">&#xe631;</span>
                </a-row>
            </div>
            <a-row :style="{'margin-top': form1.product_modules.length > 1 ? '-5px': '12px'}">
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 40px">
                <a-form-model-item class="colon">
                  <span class="fz12" slot="label">项目来源 :<span style="color:#f88d49;margin-left:10px"> 可与项目进行关联! </span></span>
                   <projectSelect v-model="form1.source_project_id" :allowClear="true"></projectSelect>
                </a-form-model-item>
              </a-col>
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 10px">
                 <a-form-model-item
                    label="总任务截止时间"
                    prop="expiration_date"
                    :rules="[{ required: true, message: '请选择总任务截止时间', trigger: 'change' }]">
                  <a-date-picker style="width:100%"
                                 format="YYYY/MM/DD"
                                 :disabledDate="disabledDate"
                                 v-model="form1.expiration_date"
                                 type="date"
                                 placeholder="请选择日期">
                  </a-date-picker>
                </a-form-model-item>
              </a-col>
            </a-row>
             <a-row>
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     style="padding-right: 40px">
                <a-form-model-item class="colon">
                  <span class="fz12" slot="label">预计纳入版本 :<span style="color:#f88d49;margin-left:10px"> 选择预期想在哪个版本进行发布上线，非特殊要求，不要选择已发布测试的版本! </span></span>
                  <GroupSelect v-model="form1.release_version_ids" :productId="form1.product_id ? form1.product_id : form1.product_line"></GroupSelect>
                </a-form-model-item>
              </a-col>
            </a-row>

          </div>
        <a-form-model-item
            label="设计类型"
            prop="design_type"
            :rules="[{ required: true, message: '请选择设计类型', trigger: 'change' }]">
            <a-radio-group v-model="form1.design_type" :disabled="Boolean($route.query.id)">
                <a-radio :value="0">
                    分阶段设计
                </a-radio>
                <a-radio :value="1">
                    同时进行
                </a-radio>
                <a-radio :value="2">
                    设计优先
                </a-radio>
            </a-radio-group>
        </a-form-model-item>
        <a-form-model-item
            class="parts"
            label="参与角色"
            prop="parts"
            :rules="[{ required: true, message: '请至少勾选一个参与角色', trigger: 'change' }]">
                  <a-checkbox-group style="width:100%;" v-model="form1.parts" :disabled="Boolean($route.query.id)">
                    <a-row>
                        <!-- 环节；0：交互；1：视觉；2：美工 3：前端；4：移动端； -->
                      <a-col :span="8"
                      style="padding-right:10px"
                             >
                        <a-checkbox :value="0"
                                    @change="checkUser($event,1)"
                                    >
                          <span >交互设计</span>
                        </a-checkbox>
                         <a-form-model-item prop="user1" :rules="[{ required: check1, message: '请选择' }]">
                            <!-- <a-select
                                        v-model="form1.user1"
                                        showSearch
                                        :disabled="Boolean($route.query.id)"
                                        allowClear
                                        placeholder="请选择"
                                        optionFilterProp="children"
                                    >
                                <a-select-option v-for="item in bindPeople"
                                                :key="item.id">{{item.name}}</a-select-option>
                            </a-select> -->
                            <allPersonSelect :autoFocus="false"
                                            :disabled="Boolean($route.query.id)"
                                            @getSelectValue="handleSearch1"
                                            :selectValue="user1ID"
                                            :searchData="user1Arr"
                                            ref="user1Ref"
                                            placeholder="请输入英文名搜索"
                                            style="width: 100%">
                            </allPersonSelect>
                         </a-form-model-item>
                      </a-col>
                      <a-col :span="8"
                              style="padding-right:10px">
                        <a-checkbox :value="1"
                                     @change="checkUser($event,2)"
                                   >
                          <span >视觉设计</span>
                        </a-checkbox>
                        <a-form-model-item prop="user2" :rules="[{ required: check2, message: '请选择' }]">
                         <!-- <a-select
                                    showSearch
                                    allowClear
                                    :disabled="Boolean($route.query.id)"
                                    v-model="form1.user2"
                                    placeholder="请选择"
                                    optionFilterProp="children"
                                   >
                            <a-select-option v-for="item in bindPeople"
                                            :key="item.id">{{item.name}}</a-select-option>
                        </a-select> -->
                          <allPersonSelect :autoFocus="false"
                                          :disabled="Boolean($route.query.id)"
                                          @getSelectValue="handleSearch2"
                                          :selectValue="user2ID"
                                          :searchData="user2Arr"
                                          ref="user2Ref"
                                          placeholder="请输入英文名搜索"
                                          style="width: 100%">
                          </allPersonSelect>
                        </a-form-model-item>
                      </a-col>
                      <a-col :span="8"
                             style="padding-right:10px">
                        <a-checkbox :value="3"
                                     @change="checkUser($event,3)"
                                   >
                          <span >前端</span>
                        </a-checkbox>
                         <a-form-model-item prop="user3" :rules="[{ required: check3, message: '请选择' }]">
                            <!-- <a-select
                                        showSearch
                                        allowClear
                                        :disabled="Boolean($route.query.id)"
                                        v-model="form1.user3"
                                        placeholder="请选择"
                                        optionFilterProp="children"
                                    >
                                <a-select-option v-for="item in bindPeople"
                                                :key="item.id">{{item.name}}</a-select-option>
                            </a-select> -->
                            <allPersonSelect :autoFocus="false"
                                            :disabled="Boolean($route.query.id)"
                                            @getSelectValue="handleSearch3"
                                            :selectValue="user3ID"
                                            :searchData="user3Arr"
                                            ref="user3Ref"
                                            placeholder="请输入英文名搜索"
                                            style="width: 100%">
                            </allPersonSelect>
                         </a-form-model-item>
                      </a-col>
                    </a-row>
                    <a-row>
                      <a-col :span="8"
                              style="padding-right:10px">
                        <a-checkbox :value="4"
                                     @change="checkUser($event,4)"
                                    >
                          <span>移动端</span>
                        </a-checkbox>
                        <a-form-model-item prop="user4" :rules="[{ required: check4, message: '请选择' }]">
                          <!-- <a-select
                                    showSearch
                                    allowClear
                                    :disabled="Boolean($route.query.id)"
                                    v-model="form1.user4"
                                    placeholder="请选择"
                                    optionFilterProp="children"
                                   >
                            <a-select-option v-for="item in bindPeople"
                                            :key="item.id">{{item.name}}</a-select-option>
                        </a-select> -->
                          <allPersonSelect :autoFocus="false"
                                          :disabled="Boolean($route.query.id)"
                                          @getSelectValue="handleSearch4"
                                          :selectValue="user4ID"
                                          :searchData="user4Arr"
                                          ref="user4Ref"
                                          placeholder="请输入英文名搜索"
                                          style="width: 100%">
                          </allPersonSelect>
                        </a-form-model-item>
                      </a-col>
                      <a-col :span="8"
                              style="padding-right:10px">
                        <a-checkbox :value="2"
                         @change="checkUser($event,5)"
                                    >
                          <span >美工</span>
                        </a-checkbox>
                        <a-form-model-item prop="user5" :rules="[{ required: check5, message: '请选择' }]">
                          <!-- <a-select
                                    showSearch
                                    v-model="form1.user5"
                                    allowClear
                                    :disabled="Boolean($route.query.id)"
                                    placeholder="请选择"
                                    optionFilterProp="children"
                                   >
                            <a-select-option v-for="item in bindPeople"
                                            :key="item.id">{{item.name}}</a-select-option>
                          </a-select> -->
                          <allPersonSelect :autoFocus="false"
                                          :disabled="Boolean($route.query.id)"
                                          @getSelectValue="handleSearch5"
                                          :selectValue="user5ID"
                                          :searchData="user5Arr"
                                          ref="user5Ref"
                                          placeholder="请输入英文名搜索"
                                          style="width: 100%">
                          </allPersonSelect>
                        </a-form-model-item>
                      </a-col>
                    </a-row>

                  </a-checkbox-group>
                </a-form-model-item>
        </div>

        <div class="con" style="padding-top: 5px;">
          <h3><i class="tabs-ico"></i> 任务描述</h3>
          <p class="mb10"> <span style="color:#FF0000">*</span> 任务描述 :</p>
          <a-form-model-item :validate-status="validateStatus.contents"
                       :help="validateStatus.contentsTxt">
            <div>
              <myEditor v-model="form1.description"
                        placeholder="请输入需要完成的任务内容"
                        :class="{'active' : active}"></myEditor>
            </div>
          </a-form-model-item>
        </div>
        <div class="con eidt-con-margin">
          <h3><i class="tabs-ico"></i> 其他信息</h3>
          <p style="margin-bottom:10px">url共享:</p>
          <a-row style="margin-bottom:10px">
                <a-radio-group v-model="value">
                    <a-radio :value="0">无</a-radio>
                    <a-radio :value="1">有</a-radio>
                </a-radio-group>
                <span @click="addUrlInputList"
                        v-if="value"
                        class="addFile">
                    <a-icon type="plus" />添加</span>
          </a-row>
          <div v-if="value">
            <div v-for="(item, index) in form1.share_address"
                 :key="index"
                 style="display:flex;margin-bottom:10px">
              <div style="margin-right: 10px;width:1118px">
                <a-input-group compact>
                    <a-input placeholder="可填写名称" style="width: 120px;background: #FAFAFA;" title="单击可进行编辑" v-model="item.name" :maxLength="8"/>
                    <a-input placeholder="请输入地址" style="width: calc(100% - 120px)" v-model="item.value" />
                </a-input-group>
              </div>
              <div @click="() => removeUrlInputList(index)"
                   class="delFile"> <span class="iconfont">&#xe64d;</span></div>
            </div>
          </div>

          <a-row style="margin-bottom:10px;margin-top:20px">
            <span>附件 :</span>
            <span @click="addFileInputList"
                  class="addFile">
              <a-icon type="plus" />添加</span>
          </a-row>
          <a-form-model-item
                    :validate-status="validateStatus.media"
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
                   class="delFile"> <span class="iconfont" style="top: 4px;">&#xe64d;</span></div>
            </div>
          </a-form-model-item>
        </div>
        <div style="padding:0 10px 30px 10px">
          <a-button @click="postForm"
                    :loading="btnLoad"
                    style="margin-right:20px;background:rgba(55,142,239,1)"
                    type="primary">发布</a-button>
          <a-button style="background:rgba(248,248,248,1);"
                    @click="goback">取消</a-button>
        </div>
      </div>
    </a-form-model>
  </div>
</template>

<style lang="less" scoped>
/deep/.el-input--prefix .el-input__inner {
  height: 32px;
}
/deep/.ql-snow .ql-picker-label::before {
  position: relative;
  top: 0;
}
.parts .ant-form-item{
    margin-bottom: 10px;
}
/deep/.ant-checkbox-wrapper{
    margin-bottom: 4px;
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
    top: -32px;
    color:#BBBBBB;
}
.add{
    position: relative;
    left: 1090px;
    top: 0;
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
  .tip {
      display: inline-block;
      margin-left: 10px;
      margin-bottom: 2px;
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
  .header {
    height: 54px;
    line-height: 54px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid rgba(238, 238, 238, 1);
    margin-bottom: 20px;
    h1 {
      font-size: 16px;
      font-family: Microsoft YaHei;
      font-weight: bold;
      color: rgba(51, 51, 51, 1);
    }
    .down {
      cursor: pointer;
    }

  }
}
.con {
  padding: 10px;
  margin-bottom: 6px;
  /deep/ .ant-form-item-label{
    line-height: 1;
    margin-bottom: 10px;
  }
  /deep/ .ant-form-item-control{
    line-height: 1 ;
  }
  /deep/.ant-form-item-children{
      line-height: 1;
  }
  /deep/.ql-editor {
    height: 110px !important;
  }
  h3 {
    font-size: 14px;
    font-family: Microsoft YaHei;
    font-weight: bold;
    color: rgba(51, 51, 51, 1);
    margin-bottom: 16px;
    .add-handler{
        font-size: 12px;
        font-weight: 400;
        color: #378EEF;
        float: right;
        margin-top: 10px;
    }
  }
  .other-subtask .number{
    display: inline-block;
    width: 30px;
    height: 30px;
    padding-left: 7px;
    padding-top: 5px;
    background: #FDDA42;
    position: relative;
    top: -10px;
    left: -20px;
    border-radius: 3px 0px 28px 0px;
  }
  .main-subtask{
    background: #F8F8F8;
    border-radius: 3px;
    padding:10px 20px 0px 20px;
  }
  .other-subtask{
    margin-top: 10px;
    background: #F8F8F8;
    border-radius: 3px;
    padding:10px 20px 0px 20px;
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
    // margin-bottom: -20px;
    margin-top: -25px;
}
.con .eidt-margin{
    margin-bottom: 12px;
}
.eidt-con-margin{
    padding-top:15px;
    padding-bottom:0;
    margin-bottom: 0;
}
</style>
<script>
import moment from 'moment'
import _ from 'lodash'
import myEditor from '@/components/myEditor'
import projectSelect from '@/components/projectSelect.vue'
import GroupSelect from '@/components/GroupSelect'
import allPersonSelect from '@/components/allPersonSelect'
import { getProducts } from '@/api/RDmanagement/ProductMaintenance/index.js'
import { designTaskHandler, getBindPeople } from '@/api/RDmanagement/dropDown'
import { postDesignTask, editDesignTask, getDesignDetails, getDesignTeam } from '@/api/RDmanagement/task/design'
import { allow, allowSize, objToFd } from '@/plugins/common.js'

export default {
  components: { myEditor, projectSelect, GroupSelect, allPersonSelect },
  data () {
    return {
      btnLoad: false,
      active: false,
      tipsShow: false,
      isUpdate: 0,
      productsData: undefined,
      tip: true,
      designTeam: {
        interactive: {},
        visual: {},
        front: {},
        mobile: {},
        art: {}
      },
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
      chargeOption: [],
      handlerOption: [],
      bindPeople: [],
      user1Arr: [],
      user1ID: undefined,
      user2Arr: [],
      user2ID: undefined,
      user3Arr: [],
      user3ID: undefined,
      user4Arr: [],
      user4ID: undefined,
      user5Arr: [],
      user5ID: undefined,
      check1: false,
      check2: false,
      check3: false,
      check4: false,
      check5: false,
      productsLine_id: undefined,
      products_id: undefined,
      form1: {
        title: '',
        parts: [],
        user1: undefined,
        user2: undefined,
        user3: undefined,
        user4: undefined,
        user5: undefined,
        priority: undefined,
        product_line: undefined,
        product_id: undefined,
        level: undefined,
        expiration_date: undefined,
        description: undefined,
        share_address: [
          { name: undefined, value: undefined }
        ],
        design_type: undefined,
        product_modules: [{ module_id: undefined, label_ids: [], moduleTags: [] }],
        source_project_id: undefined,
        release_version_ids: []
      },
      value: 1
    }
  },
  watch: {
    'form1.user1' (newValue) {
      if (this.check1) {
        this.$nextTick(() => {
          this.$refs.ruleForm.validateField('user1', { force: true })
        })
      }
    },
    'form1.user2' (newValue) {
      if (this.check2) {
        this.$nextTick(() => {
          this.$refs.ruleForm.validateField('user2', { force: true })
        })
      }
    },
    'form1.user3' (newValue) {
      if (this.check3) {
        this.$nextTick(() => {
          this.$refs.ruleForm.validateField('user3', { force: true })
        })
      }
    },
    'form1.user4' (newValue) {
      if (this.check4) {
        this.$nextTick(() => {
          this.$refs.ruleForm.validateField('user4', { force: true })
        })
      }
    },
    'form1.user5' (newValue) {
      if (this.check5) {
        this.$nextTick(() => {
          this.$refs.ruleForm.validateField('user5', { force: true })
        })
      }
    },
    'form1.description' (newValue, oldValue) {
      if (newValue) {
        this.validateStatus.contents = 'success'
        this.validateStatus.contentsTxt = ''
        this.active = false
      } else {
        this.validateStatus.contents = 'error'
        this.validateStatus.contentsTxt = '请填写任务描述'
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
    getBindPeople().then(res => {
      if (res.code === 200) {
        this.bindPeople = res.data.users
      }
    })
    designTaskHandler().then(res => {
      if (res.code === 200) {
        this.handlerOption = res.data.users
      }
    })
    getProducts().then(res => {
      this.productsLine = res.data.products
    })
    if (this.$route.query.id) {
    // 编辑数据回显
      getDesignDetails(this.$route.query.id).then(res => {
        const data = res.data.design_task
        let dataCache = _.cloneDeep(data)
        this.form1.title = data.title
        this.form1.priority = data.priority || undefined
        this.form1.source_project_id = data.source_project_id || undefined
        this.form1.expiration_date = moment(data.expiration_date)
        this.form1.description = data.content
        this.form1.design_type = data.design_type
        this.form1.release_version_ids = data.expected_versions.map(item => {
          return item.id
        })
        if (!data.share_address) {
          this.value = 0
        } else {
          this.form1.share_address = JSON.parse(data.share_address)
        }
        data.parts.forEach(item => {
          if (item.type === 0) {
            this.form1.parts.push(0)
            this.form1.user1 = item.principal_user_id
          } else if (item.type === 1) {
            this.form1.parts.push(1)
            this.form1.user2 = item.principal_user_id
          } else if (item.type === 2) {
            this.form1.parts.push(2)
            this.form1.user5 = item.principal_user_id
          } else if (item.type === 3) {
            this.form1.parts.push(3)
            this.form1.user3 = item.principal_user_id
          } else if (item.type === 4) {
            this.form1.parts.push(4)
            this.form1.user4 = item.principal_user_id
          }
        })
        dataCache.parts.forEach(item => {
          if (item.type === 0) {
            this.user1Arr = item.principal_user_id ? [{ name: item.principal_user_name, id: item.principal_user_id }] : []
            this.user1ID = item.principal_user_id ? item.principal_user_id : undefined
          } else if (item.type === 1) {
            this.user2Arr = item.principal_user_id ? [{ name: item.principal_user_name, id: item.principal_user_id }] : []
            this.user2ID = item.principal_user_id ? item.principal_user_id : undefined
          } else if (item.type === 2) {
            this.user5Arr = item.principal_user_id ? [{ name: item.principal_user_name, id: item.principal_user_id }] : []
            this.user5ID = item.principal_user_id ? item.principal_user_id : undefined
          } else if (item.type === 3) {
            this.user3Arr = item.principal_user_id ? [{ name: item.principal_user_name, id: item.principal_user_id }] : []
            this.user3ID = item.principal_user_id ? item.principal_user_id : undefined
          } else if (item.type === 4) {
            this.user4Arr = item.principal_user_id ? [{ name: item.principal_user_name, id: item.principal_user_id }] : []
            this.user4ID = item.principal_user_id ? item.principal_user_id : undefined
          }
        })
        this.fileInputList = data.media
        if (data.product_category.product_line) {
          this.form1.product_line = data.product_category.product_line.id
          getProducts(data.product_category.product_line.id).then(res => {
            this.products = res.data.products
            this.form1.product_id = data.product_category.product.id
          })

          getProducts(data.product_category.product.id).then(res => {
            this.modules = res.data.products
          })

          let a = []
          data.product_category.product_modules.forEach(item => {
            item.product_labels = item.product_labels.map(k => {
              return k.id
            })
            getProducts(item.id).then(res => {
              item.moduleTags = res.data.products
              a.push({ module_id: item.id, label_ids: item.product_labels, moduleTags: item.moduleTags })
            })
          })
          if (data.product_category.product_modules.length === 0) {
            this.form1.product_modules = [{ module_id: undefined, label_ids: [], moduleTags: [] }]
          } else {
            this.form1.product_modules = a
          }
        }
      })
    }
  },
  methods: {
    moment,
    objToFd,
    handleSearch1 (e) {
      this.form1.user1 = e.id
    },
    handleSearch2 (e) {
      this.form1.user2 = e.id
    },
    handleSearch3 (e) {
      this.form1.user3 = e.id
    },
    handleSearch4 (e) {
      this.form1.user4 = e.id
    },
    handleSearch5 (e) {
      this.form1.user5 = e.id
    },
    disabledDate (current) {
      // 不能选择今天以前的日期
      return current && current < moment().startOf('day')
    },
    // 参与角色验证
    checkUser (e, index) {
      let designTeamCache = _.cloneDeep(this.designTeam)
      if (index === 1) {
        this.check1 = e.target.checked
        if (!e.target.checked) {
          this.form1.user1 = undefined
          this.user1ID = undefined
          this.user1Arr = []
          this.$refs.user1Ref.value = undefined
        } else {
          if (this.designTeam.interactive) {
            this.form1.user1 = this.designTeam.interactive.user_id
            this.user1ID = designTeamCache.interactive.user_id ? designTeamCache.interactive.user_id : undefined
            this.user1Arr = designTeamCache.interactive.user_id ? [{ id: designTeamCache.interactive.user_id, name: designTeamCache.interactive.user_name }] : []
            if (!designTeamCache.interactive.user_id) this.$refs.user1Ref.value = undefined
          }
        }
        this.$nextTick(() => {
          this.$refs.ruleForm.validateField('user1', { force: true })
        })
      } else if (index === 2) {
        this.check2 = e.target.checked
        if (!e.target.checked) {
          this.form1.user2 = undefined
          this.user2ID = undefined
          this.user2Arr = []
          this.$refs.user2Ref.value = undefined
        } else {
          if (this.designTeam.visual) {
            this.form1.user2 = this.designTeam.visual.user_id
            this.user2ID = designTeamCache.visual.user_id ? designTeamCache.visual.user_id : undefined
            this.user2Arr = designTeamCache.visual.user_id ? [{ id: designTeamCache.visual.user_id, name: designTeamCache.visual.user_name }] : []
            if (!designTeamCache.visual.user_id) this.$refs.user2Ref.value = undefined
          }
        }
        this.$nextTick(() => {
          this.$refs.ruleForm.validateField('user2', { force: true })
        })
      } else if (index === 3) {
        this.check3 = e.target.checked
        if (!e.target.checked) {
          this.form1.user3 = undefined
          this.user3ID = undefined
          this.user3Arr = []
          this.$refs.user3Ref.value = undefined
        } else {
          if (this.designTeam.front) {
            this.form1.user3 = this.designTeam.front.user_id
            this.user3ID = designTeamCache.front.user_id ? designTeamCache.front.user_id : undefined
            this.user3Arr = designTeamCache.front.user_id ? [{ id: designTeamCache.front.user_id, name: designTeamCache.front.user_name }] : []
            if (!designTeamCache.front.user_id) this.$refs.user3Ref.value = undefined
          }
        }
        this.$nextTick(() => {
          this.$refs.ruleForm.validateField('user3', { force: true })
        })
      } else if (index === 4) {
        this.check4 = e.target.checked
        if (!e.target.checked) {
          this.form1.user4 = undefined
          this.user4ID = undefined
          this.user4Arr = []
          this.$refs.user4Ref.value = undefined
        } else {
          if (this.designTeam.mobile) {
            this.form1.user4 = this.designTeam.mobile.user_id
            this.user4ID = designTeamCache.mobile.user_id ? designTeamCache.mobile.user_id : undefined
            this.user4Arr = designTeamCache.mobile.user_id ? [{ id: designTeamCache.mobile.user_id, name: designTeamCache.mobile.user_name }] : []
            if (!designTeamCache.mobile.user_id) this.$refs.user4Ref.value = undefined
          }
        }
        this.$nextTick(() => {
          this.$refs.ruleForm.validateField('user4', { force: true })
        })
      } else if (index === 5) {
        if (!e.target.checked) {
          this.form1.user5 = undefined
          this.user5ID = undefined
          this.user5Arr = []
          this.$refs.user5Ref.value = undefined
        } else {
          if (this.designTeam.art) {
            this.form1.user5 = this.designTeam.art.user_id
            this.user5ID = designTeamCache.art.user_id ? designTeamCache.art.user_id : undefined
            this.user5Arr = designTeamCache.art.user_id ? [{ id: designTeamCache.art.user_id, name: designTeamCache.art.user_name }] : []
            if (!designTeamCache.art.user_id) this.$refs.user5Ref.value = undefined
          }
        }
        this.check5 = e.target.checked
        this.$nextTick(() => {
          this.$refs.ruleForm.validateField('user5', { force: true })
        })
      }
    },
    close () {
      this.tip = false
    },
    handleProvinceChange (value) {
      this.form1.product_id = undefined
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
      // 更改产品,更改勾选的角色负责人
      if (!this.$route.query.id) {
        getDesignTeam(value).then(res => {
          this.designTeam = res.data.users
          let designTeamCache = _.cloneDeep(this.designTeam)
          if (this.check1 && this.designTeam.interactive) {
            this.form1.user1 = this.designTeam.interactive.user_id
            this.user1ID = designTeamCache.interactive.user_id ? designTeamCache.interactive.user_id : undefined
            this.user1Arr = designTeamCache.interactive.user_id ? [{ id: designTeamCache.interactive.user_id, name: designTeamCache.interactive.user_name }] : []
            if (!designTeamCache.interactive.user_id) this.$refs.user1Ref.value = undefined
          } else {
            this.form1.user1 = undefined
            this.user1ID = undefined
            this.user1Arr = []
            this.$refs.user1Ref.value = undefined
          }
          if (this.check2 && this.designTeam.visual) {
            this.form1.user2 = this.designTeam.visual.user_id
            this.user2ID = designTeamCache.visual.user_id ? designTeamCache.visual.user_id : undefined
            this.user2Arr = designTeamCache.visual.user_id ? [{ id: designTeamCache.visual.user_id, name: designTeamCache.visual.user_name }] : []
            if (!designTeamCache.visual.user_id) this.$refs.user2Ref.value = undefined
          } else {
            this.form1.user2 = undefined
            this.user2ID = undefined
            this.user2Arr = []
            this.$refs.user2Ref.value = undefined
          }
          if (this.check3 && this.designTeam.front) {
            this.form1.user3 = this.designTeam.front.user_id
            this.user3ID = designTeamCache.front.user_id ? designTeamCache.front.user_id : undefined
            this.user3Arr = designTeamCache.front.user_id ? [{ id: designTeamCache.front.user_id, name: designTeamCache.front.user_name }] : []
            if (!designTeamCache.front.user_id) this.$refs.user3Ref.value = undefined
          } else {
            this.form1.user3 = undefined
            this.user3ID = undefined
            this.user3Arr = []
            this.$refs.user3Ref.value = undefined
          }
          if (this.check4 && this.designTeam.mobile) {
            this.form1.user4 = this.designTeam.mobile.user_id
            this.user4ID = designTeamCache.mobile.user_id ? designTeamCache.mobile.user_id : undefined
            this.user4Arr = designTeamCache.mobile.user_id ? [{ id: designTeamCache.mobile.user_id, name: designTeamCache.mobile.user_name }] : []
            if (!designTeamCache.mobile.user_id) this.$refs.user4Ref.value = undefined
          } else {
            this.form1.user4 = undefined
            this.user4ID = undefined
            this.user4Arr = []
            this.$refs.user4Ref.value = undefined
          }
          if (this.check5 && this.designTeam.art) {
            this.form1.user5 = this.designTeam.art.user_id
            this.user5ID = designTeamCache.art.user_id ? designTeamCache.art.user_id : undefined
            this.user5Arr = designTeamCache.art.user_id ? [{ id: designTeamCache.art.user_id, name: designTeamCache.art.user_name }] : []
            if (!designTeamCache.art.user_id) this.$refs.user5Ref.value = undefined
          } else {
            this.form1.user5 = undefined
            this.user5ID = undefined
            this.user5Arr = []
            this.$refs.user5Ref.value = undefined
          }
        })
      }
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
    postForm () {
      this.$refs.ruleForm.validate(valid => {
        if (!this.form1.description) {
          this.validateStatus.contents = 'error'
          this.validateStatus.contentsTxt = '请输入任务描述'
          this.active = true
        }
        if (valid && this.form1.description && this.validateStatus.media === 'success') {
          let data = JSON.parse(JSON.stringify(this.form1))
          if (this.form1.expiration_date) {
            data.expiration_date = this.form1.expiration_date.format('YYYY-MM-DD')
          }

          data.product_modules.forEach((item) => {
            item.moduleTags = []
          })
          data.parts = []
          if (this.form1.user1) {
            data.parts.push({
              type: 0,
              user_id: this.form1.user1
            })
          }
          if (this.form1.user2) {
            data.parts.push({
              type: 1,
              user_id: this.form1.user2
            })
          }
          if (this.form1.user3) {
            data.parts.push({
              type: 3,
              user_id: this.form1.user3
            })
          }
          if (this.form1.user4) {
            data.parts.push({
              type: 4,
              user_id: this.form1.user4
            })
          }
          if (this.form1.user5) {
            data.parts.push({
              type: 2,
              user_id: this.form1.user5
            })
          }
          const formData = this.objToFd(data)

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
          } else {
            this.fileInputList.map(item => {
              if (item.file) {
                formData.append('media[]', item.file)
              }
            })
          }

          this.btnLoad = true

          if (this.$route.query.id) {
            editDesignTask(this.$route.query.id, formData).then(res => {
              if (res.code === 200) {
                this.$message.success('修改任务成功')
                this.$router.push({ name: 'task', query: { type: 'design', project: this.$route.query.project ? 1 : undefined } })
                this.btnLoad = false
              }
            }).catch(error => {
              this.btnLoad = false
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          } else {
            postDesignTask(formData).then(res => {
              if (res.code === 200) {
                this.$message.success('发布任务成功')
                this.$router.push({ name: 'task', query: { type: 'design', project: this.$route.query.project ? 1 : undefined } })
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
