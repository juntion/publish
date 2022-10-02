<template>
  <div>
    <a-form-model :model="form1"  ref="ruleForm">
      <div class="box">
        <div class="header">
          <h1>{{$route.query.id ? '编辑' : '发布'}}{{$route.query.link==='dev' ? '开发' : '测试'}}内部任务</h1>
        </div>
          <p v-if="tip" class="tip">
            若涉及业务逻辑或功能变动，请走诉求或需求，经由产品人员把控！
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
                        <a-form-model-item label="所属产品线" prop="product_line">
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
                        <a-form-model-item label="产品名称" prop="product_id">
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
                <a-form-model-item
                     label="负责人"
                     prop="user_id"
                     :rules="[{ required: true, message: '请选择负责人', trigger: 'change' }]"
                     >
                   <!--<a-select
                            v-model="form1.user_id"
                            showSearch
                            :disabled="Boolean($route.query.id)"
                            optionFilterProp="children"
                            placeholder="请选择">
                            <a-select-option v-for="k in chargeOption"
                                            :title="k.name"
                                            :key="k.id">{{k.name}}</a-select-option>
                        </a-select> -->
                    <allPersonSelect :autoFocus="false"
                                    @getSelectValue="handleSearch1"
                                    :selectValue="chargeID"
                                    :searchData="chargeArr"
                                    ref="chargeRef"
                                    placeholder="请输入英文名搜索"
                                    style="width: 100%;">
                    </allPersonSelect>
                </a-form-model-item>
              </a-col>
              <a-col :lg="12"
                     :md="12"
                     :sm="24"
                     v-if="$route.query.link === 'dev'"
                     style="padding-right: 10px"
                     >
                 <a-form-model-item class="colon">
                  <span class="fz12" slot="label">预计纳入版本 :<span style="color:#f88d49;margin-left:10px"> 选择预期想在哪个版本进行发布上线，非特殊要求，不要选择已发布测试的版本! </span></span>
                  <GroupSelect v-model="form1.release_version_ids" :productId="form1.product_id ? form1.product_id : form1.product_line"></GroupSelect>
                </a-form-model-item>
              </a-col>
            </a-row>
          </div>

        </div>

        <div class="con">
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
        <div class="con">
            <h3><i class="tabs-ico"></i> 任务分工 <span class="add-handler cup" @click="addPeople" v-if="!$route.query.id"> <a-icon type="plus" /> 添加次要跟进人</span></h3>
            <div class="main-subtask">
                <span class="number">1</span>
                <a-row>
                    <a-col :lg="12"
                            :md="12"
                            :sm="24"
                            style="padding-right: 40px">
                        <a-form-model-item >
                        <span slot="label"> 主要跟进人</span>
                        <!-- <a-select
                                    v-model="form1.main_sub_task.handler_id"
                                    showSearch
                                    :disabled="Boolean($route.query.id)"
                                    optionFilterProp="children"
                                    placeholder="请选择">
                                    <a-select-option v-for="k in handlerOption"
                                                    :title="k.name"
                                                    :key="k.id">{{k.name}}</a-select-option>
                                </a-select> -->
                          <allPersonSelect :autoFocus="false"
                                          @getSelectValue="handleSearch2"
                                          :selectValue="mainFollowerID"
                                          :searchData="mainFollowerArr"
                                          :disabled="Boolean($route.query.id)"
                                          ref="mainFollowerRef"
                                          placeholder="请输入英文名搜索"
                                          style="width: 100%;">
                          </allPersonSelect>
                        </a-form-model-item>
                    </a-col>
                    <a-col :lg="12"
                            :md="12"
                            :sm="24"
                            >
                        <a-form-model-item>
                            <span slot="label"> 指定截止时间</span>
                              <a-date-picker style="width:100%"
                                 format="YYYY/MM/DD"
                                 :allowClear="false"
                                 :disabledDate="disabledDate"
                                 v-model="form1.main_sub_task.expiration_date"
                                 @change="changeDate"
                                 type="date"
                                 placeholder="请选择日期">
                              </a-date-picker>
                        </a-form-model-item>
                    </a-col>
              </a-row>
              <a-row v-if="$route.query.link==='dev'">
                    <a-col :lg="12"
                            :md="12"
                            :sm="24"
                            style="padding-right: 40px">
                        <a-form-model-item class="colon">
                        <span slot="label"> 考核标准工作量(天) :
                            <a-popover
                                    placement="bottomLeft"
                                    arrowPointAtCenter>
                                    <template slot="content">
                                        <div style="max-width:216px;">
                                           <p class="pop-title">考核标准工作量（天）：</p>
                                           <div>
                                               预计交付日期-当前日期-期间休息天数
                                           </div>
                                           <p class="pop-title">注意 ：</p>
                                           <div>
                                               当预计交付日期因项目需求周期影响，需延长或缩短时，并需重新定义考核标准工作量时，可点击调整，并说明原因，对应等级和系数按照此修改后的值计算。
                                           </div>
                                        </div>
                                    </template>
                                    <span class="iconfont fz12 cup">&#xe640;</span>
                            </a-popover>
                        </span>
                            <div>
                                <a-input-number
                                    @change="changeWorkDay($event,form1.main_sub_task)"
                                    :disabled="!form1.main_sub_task.checked"
                                    v-model="form1.main_sub_task.standard_workload"
                                    style="width:86%;margin-right:10px"
                                    :min="1" />
                                 <a-checkbox
                                 :disabled="!form1.main_sub_task.standard_workload"
                                 @change="adjustment($event,form1.main_sub_task)"
                                 v-model="form1.main_sub_task.checked">调整</a-checkbox>
                            </div>
                        </a-form-model-item>
                    </a-col>

                    <a-col :lg="12"
                            :md="12"
                            :sm="24"
                            >
                        <a-form-model-item class="colon">
                            <span slot="label"> 绩效等级/系数 :
                                <a-popover
                                    placement="bottomLeft"
                                    arrowPointAtCenter>
                                    <template slot="content">
                                        <div style="width:266px">
                                            <p class="pop-title">绩效等级/系数：</p>
                                            <div>根据标准工作量进行自动匹配：</div>
                                            <table class="pop-table" style="border-collapse: collapse;">
                                                <tr>
                                                    <th> 标准工作量X (天)</th>
                                                    <th> 绩效等级 </th>
                                                    <th> 标准分系数 </th>
                                                </tr>
                                                <tr v-for="(item,index) in tableData" :key="index">
                                                   <td>{{item.day}}</td>
                                                   <td>{{item.level}}</td>
                                                   <td>{{item.grade}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </template>
                                    <span class="iconfont fz12 cup">&#xe640;</span>
                                </a-popover>
                            </span>
                                <a-input v-model="form1.main_sub_task.level" disabled/>
                        </a-form-model-item>
                    </a-col>
              </a-row>
              <a-row v-if="form1.main_sub_task.checked">
                  <a-col :lg="24"
                            :md="24"
                            :sm="24"
                            >
                        <a-form-model-item class="colon"
                        prop="main_sub_task.adjust_reason"
                        :rules="[{ required: true, message: '请输入调整原因', trigger: 'blur' }]">
                        <span slot="label"> 调整原因 :<span style="color:#f88d49;margin-left:10px">标准工作量为自动根据预计交付日期计算,其变动会影响绩效等级和系数,请务必说明原因 </span></span>
                       <a-textarea
                            v-model="form1.main_sub_task.adjust_reason"
                            style="height:80px"
                            placeholder="请输入调整原因"

                            />
                        </a-form-model-item>
                    </a-col>
              </a-row>
              <a-row>
                  <a-col :lg="24"
                            :md="24"
                            :sm="24"
                            >
                        <a-form-model-item>
                        <span slot="label"> 任务分工要求</span>
                       <a-textarea
                            v-model="form1.main_sub_task.description"
                            style="height:80px"
                            placeholder="请输入任务分工要求描述"

                            />
                        </a-form-model-item>
                    </a-col>
              </a-row>
            </div>
            <div class="other-subtask" v-for="(item,index) in form1.other_sub_tasks" :key="index">
                <span class="number">{{index+2}}</span>
                 <span class="iconfont del"
                        style="left: 1072px;top: -12px;"
                        @click="() => removePeople(index)">&#xe631;</span>
                <a-row>
                    <a-col :lg="12"
                            :md="12"
                            :sm="24"
                            style="padding-right: 40px">
                        <a-form-model-item>
                        <span slot="label"> 次要跟进人</span>
                        <!-- <a-select
                                    v-model="item.handler_id"
                                    showSearch
                                    :disabled="Boolean($route.query.id)"
                                    optionFilterProp="children"
                                    placeholder="请选择">
                                    <a-select-option v-for="k in handlerOption"
                                                    :title="k.name"
                                                    :key="k.id">{{k.name}}</a-select-option>
                                </a-select> -->
                                <allPersonSelect :autoFocus="false"
                                                @getSelectValue="handleSearch3"
                                                :selectValue="otherFollowerID[index]"
                                                :searchData="otherFollowerArr[index]"
                                                :index="index"
                                                :disabled="Boolean($route.query.id)"
                                                :ref="'otherFollowerRef' + index"
                                                placeholder="请输入英文名搜索"
                                                style="width: 100%;">
                                </allPersonSelect>
                        </a-form-model-item>
                    </a-col>
                    <a-col :lg="12"
                            :md="12"
                            :sm="24"
                            >
                        <a-form-model-item>
                        <span slot="label"> 指定截止时间</span>
                        <a-date-picker style="width:100%"
                                 format="YYYY/MM/DD"
                                 :allowClear="false"
                                 :disabledDate="disabledDate"
                                 v-model="item.expiration_date"
                                 @change="changeOtherDate($event,item)"
                                 type="date"
                                 placeholder="请选择日期">
                              </a-date-picker>
                        </a-form-model-item>
                    </a-col>
              </a-row>
              <a-row v-if="$route.query.link==='dev'">
                    <a-col :lg="12"
                            :md="12"
                            :sm="24"
                            style="padding-right: 40px">
                        <a-form-model-item class="colon">
                        <span slot="label"> 考核标准工作量(天) :
                            <a-popover
                                    placement="bottomLeft"
                                    arrowPointAtCenter>
                                    <template slot="content">
                                        <div style="max-width:216px;">
                                           <p class="pop-title">考核标准工作量（天）：</p>
                                           <div>
                                               预计交付日期-当前日期-期间休息天数
                                           </div>
                                           <p class="pop-title">注意 ：</p>
                                           <div>
                                               当预计交付日期因项目需求周期影响，需延长或缩短时，并需重新定义考核标准工作量时，可点击调整，并说明原因，对应等级和系数按照此修改后的值计算。
                                           </div>
                                        </div>
                                    </template>
                                    <span class="iconfont fz12 cup">&#xe640;</span>
                            </a-popover>
                        </span>
                            <div>
                                <a-input-number
                                    @change="changeWorkDay($event,item)"
                                    :disabled="!item.checked"
                                    v-model="item.standard_workload"
                                    style="width:86%;margin-right:10px"
                                    :min="1" />

                                 <a-checkbox
                                 :disabled="!item.standard_workload"
                                  @change="adjustment($event,item)"
                                 v-model="item.checked">调整</a-checkbox>
                            </div>
                        </a-form-model-item>
                    </a-col>

                    <a-col :lg="12"
                            :md="12"
                            :sm="24"
                            >
                        <a-form-model-item class="colon">
                            <span slot="label"> 绩效等级/系数 :
                                <a-popover
                                    placement="bottomLeft"
                                    arrowPointAtCenter>
                                    <template slot="content">
                                        <div style="width:266px">
                                            <p class="pop-title">绩效等级/系数：</p>
                                            <div>根据标准工作量进行自动匹配：</div>
                                            <table class="pop-table" style="border-collapse: collapse;">
                                                <tr>
                                                    <th> 标准工作量X (天)</th>
                                                    <th> 绩效等级 </th>
                                                    <th> 标准分系数 </th>
                                                </tr>
                                                <tr v-for="(item2,index) in tableData" :key="index">
                                                   <td>{{item2.day}}</td>
                                                   <td>{{item2.level}}</td>
                                                   <td>{{item2.grade}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </template>
                                    <span class="iconfont fz12 cup">&#xe640;</span>
                                </a-popover>
                            </span>
                                <a-input v-model="item.level" disabled/>
                        </a-form-model-item>
                    </a-col>
              </a-row>
              <a-row v-if="item.checked">
                  <a-col :lg="24"
                            :md="24"
                            :sm="24"
                            >
                        <a-form-model-item class="colon"
                        :prop="`other_sub_tasks[${index}].adjust_reason`"
                        :rules="[{ required: true, message: '请输入调整原因', trigger: 'blur' }]">
                        <span slot="label"> 调整原因 :<span style="color:#f88d49;margin-left:10px">标准工作量为自动根据预计交付日期计算,其变动会影响绩效等级和系数,请务必说明原因 </span></span>
                       <a-textarea
                            v-model="item.adjust_reason"
                            style="height:80px"
                            placeholder="请输入调整原因"

                            />
                        </a-form-model-item>
                    </a-col>
              </a-row>
              <a-row>
                  <a-col :lg="24"
                            :md="24"
                            :sm="24"
                            >
                        <a-form-model-item>
                        <span slot="label"> 任务分工要求</span>
                       <a-textarea
                           v-model="item.description"
                           style="height:80px"
                            placeholder="请输入任务分工要求描述"
                            />
                        </a-form-model-item>
                    </a-col>
              </a-row>
            </div>
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
.pop-title{
    color: #bbb;
    font-size: 12px;
}
.pop-table{
    margin-top: 6px;
    th{
         border: 1px solid #ccc;
         padding: 10px;
    }
    td{
         border: 1px solid #ccc;
         text-align: center;
         line-height: 1;
         padding: 10px 0;
    }
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
  .other-subtask  .number{
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
    .number{
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
    padding-top:34px;
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
import { getProducts } from '../../../api/RDmanagement/ProductMaintenance/index.js'
import { getdevPrincipal, devTaskHandler, testTaskHandler, getTestPrincipal } from '@/api/RDmanagement/dropDown'
import { postDevTask, editDevTask, getDevDetails, getWorkload, getAchievements } from '@/api/RDmanagement/task/dev'
import { postTestTask, editTestTask, getTestDetails } from '@/api/RDmanagement/task/test'
import { allow, allowSize, objToFd } from '@/plugins/common.js'
export default {
  components: { myEditor, projectSelect, GroupSelect, allPersonSelect },
  data () {
    return {
      tableData: [
        { day: 'X＞15', level: 'S', grade: '1.4' },
        { day: '8＜X≤15', level: 'A', grade: '1.3' },
        { day: '5＜X≤8', level: 'B', grade: '1.2' },
        { day: '2＜X≤5', level: 'C', grade: '1.1' },
        { day: '1≤X≤2', level: 'D', grade: '1' }
      ],
      btnLoad: false,
      active: false,
      productsData: undefined,
      tip: true,
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
      chargeArr: [],
      chargeID: undefined,
      mainFollowerArr: [],
      mainFollowerID: undefined,
      otherFollowerArr: [],
      otherFollowerID: [],
      productsLine_id: undefined,
      products_id: undefined,
      form1: {
        title: '',
        priority: undefined,
        product_line: undefined,
        product_id: undefined,
        level: undefined,
        user_id: undefined,
        expiration_date: undefined,
        description: undefined,
        share_address: [
          { name: undefined, value: undefined }
        ],
        main_sub_task: {
          handler_id: undefined,
          expiration_date: undefined,
          description: undefined,
          standard_workload: undefined,
          adjust_reason: undefined,
          level: undefined,
          checked: false
        },
        release_version_ids: [],
        other_sub_tasks: [],
        product_modules: [{ module_id: undefined, label_ids: [], moduleTags: [] }],
        source_project_id: undefined
      },
      value: 1
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
    if (this.$route.query.link === 'dev') {
      getdevPrincipal().then(res => {
        if (res.code === 200) {
          this.chargeOption = res.data.users
        }
      })
      devTaskHandler().then(res => {
        if (res.code === 200) {
          this.handlerOption = res.data.users
        }
      })
    } else {
      getTestPrincipal().then(res => {
        if (res.code === 200) {
          this.chargeOption = res.data.users
        }
      })
      testTaskHandler().then(res => {
        if (res.code === 200) {
          this.handlerOption = res.data.users
        }
      })
    }

    getProducts().then(res => {
      this.productsLine = res.data.products
    })
    if (this.$route.query.id) {
    // 编辑数据回显
      if (this.$route.query.link === 'dev') {
        getDevDetails(this.$route.query.id).then(res => {
          const data = res.data.dev_task
          let dataCache = _.cloneDeep(data)
          this.form1.title = data.title
          this.form1.priority = data.priority || undefined
          this.form1.source_project_id = data.source_project_id || undefined
          this.form1.expiration_date = moment(data.expiration_date)
          this.form1.user_id = data.principal_user_id
          this.chargeID = dataCache.principal_user_id ? dataCache.principal_user_id : undefined
          this.chargeArr = dataCache.principal_user_id ? [{ name: dataCache.principal_user_name, id: dataCache.principal_user_id }] : []
          this.form1.description = data.content
          this.form1.level = data.level || undefined
          this.form1.main_sub_task.handler_id = data.main_subtask.handler_id || undefined
          this.mainFollowerID = dataCache.main_subtask.handler_id ? dataCache.main_subtask.handler_id : undefined
          this.mainFollowerArr = dataCache.main_subtask.handler_id ? [{ name: dataCache.main_subtask.handler_name, id: dataCache.main_subtask.handler_id }] : []
          this.form1.main_sub_task.description = data.main_subtask.description || undefined
          this.form1.main_sub_task.standard_workload = data.main_subtask.standard_workload || undefined
          this.form1.main_sub_task.adjust_reason = data.main_subtask.adjust_reason || undefined
          if (data.main_subtask.performance_level) {
            this.form1.main_sub_task.level = data.main_subtask.performance_level + '/' + data.main_subtask.standard_factor
          }

          this.form1.main_sub_task.sub_task_id = data.main_subtask.id || undefined
          this.form1.release_version_ids = data.expected_versions.map(item => {
            return item.id
          })
          if (data.main_subtask.expiration_date) {
            this.form1.main_sub_task.expiration_date = moment(data.main_subtask.expiration_date)
          } else {
            this.form1.main_sub_task.expiration_date = undefined
          }

          if (!data.share_address) {
            this.value = 0
          } else {
            this.form1.share_address = JSON.parse(data.share_address)
          }
          this.fileInputList = data.media

          this.form1.other_sub_tasks = data.other_subtasks.map(item => {
            if (item.expiration_date) {
              item.expiration_date = moment(item.expiration_date)
            } else {
              item.expiration_date = undefined
            }
            if (item.performance_level) {
              item.level = item.performance_level + '/' + item.standard_factor
            }
            this.otherFollowerID.push(item.handler_id ? item.handler_id : undefined)
            this.otherFollowerArr.push(item.handler_id ? [{ name: item.handler_name, id: item.handler_id }] : [])
            return {
              handler_id: item.handler_id,
              sub_task_id: item.id,
              expiration_date: item.expiration_date,
              description: item.description,
              standard_workload: item.standard_workload,
              adjust_reason: item.adjust_reason,
              level: item.level
            }
          })
          if (data.product_category && data.product_category.product_line) {
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
      } else {
        getTestDetails(this.$route.query.id).then(res => {
          const data = res.data.test_task
          let dataCache = _.cloneDeep(data)
          this.form1.title = data.title
          this.form1.priority = data.priority || undefined
          this.form1.source_project_id = data.source_project_id || undefined
          this.form1.expiration_date = moment(data.expiration_date)
          this.form1.user_id = data.principal_user_id
          this.chargeID = dataCache.principal_user_id ? dataCache.principal_user_id : undefined
          this.chargeArr = dataCache.principal_user_id ? [{ name: dataCache.principal_user_name, id: dataCache.principal_user_id }] : []
          this.form1.description = data.content
          this.form1.main_sub_task.handler_id = data.main_subtask.handler_id || undefined
          this.mainFollowerID = dataCache.main_subtask.handler_id ? dataCache.main_subtask.handler_id : undefined
          this.mainFollowerArr = dataCache.main_subtask.handler_id ? [{ name: dataCache.main_subtask.handler_name, id: dataCache.main_subtask.handler_id }] : []
          this.form1.main_sub_task.description = data.main_subtask.description || undefined
          this.form1.main_sub_task.sub_task_id = data.main_subtask.id || undefined
          if (data.main_subtask.expiration_date) {
            this.form1.main_sub_task.expiration_date = moment(data.main_subtask.expiration_date)
          } else {
            this.form1.main_sub_task.expiration_date = undefined
          }
          if (!data.share_address) {
            this.value = 0
          } else {
            this.form1.share_address = JSON.parse(data.share_address)
          }
          this.fileInputList = data.media

          this.form1.other_sub_tasks = data.other_subtasks.map(item => {
            if (item.expiration_date) {
              item.expiration_date = moment(item.expiration_date)
            } else {
              item.expiration_date = undefined
            }
            this.otherFollowerID.push(item.handler_id ? item.handler_id : undefined)
            this.otherFollowerArr.push(item.handler_id ? [{ name: item.handler_name, id: item.handler_id }] : [])
            return {
              handler_id: item.handler_id,
              sub_task_id: item.id,
              expiration_date: item.expiration_date,
              description: item.description
            }
          })
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
    }
  },
  methods: {
    moment,
    objToFd,
    handleSearch1 (e) {
      this.form1.user_id = e.id
    },
    handleSearch2 (e) {
      this.form1.main_sub_task.handler_id = e.id
    },
    handleSearch3 (e) {
      this.form1.other_sub_tasks[e.index].handler_id = e.id
      this.$set(this.form1.other_sub_tasks[e.index], 'handler_name', e.name)
    },
    disabledDate (current) {
      // 不能选择今天以前的日期
      return current && current < moment().startOf('day')
    },
    async changeOtherDate (e, item) {
      if (e && this.$route.query.link === 'dev') {
        let params = { expiration_date: e.format('YYYY-MM-DD') }
        const res = await getWorkload(params)
        item.standard_workload = res.data.standard_workload
        item.level = res.data.performance_level + '/' + res.data.standard_factor
      } else {
        item.standard_workload = undefined
      }
    },
    async changeDate (e) {
      if (e && this.$route.query.link === 'dev') {
        let params = { expiration_date: e.format('YYYY-MM-DD') }
        const res = await getWorkload(params)
        this.form1.main_sub_task.standard_workload = res.data.standard_workload
        this.form1.main_sub_task.level = res.data.performance_level + '/' + res.data.standard_factor
      } else {
        this.form1.main_sub_task.standard_workload = undefined
      }
    },
    async changeWorkDay (e, item) {
      let params = { workload: e }
      const res = await getAchievements(params)
      item.level = res.data.performance_level + '/' + res.data.standard_factor
    },
    async adjustment (e, item) {
      if (!e.target.checked) {
        let params = { expiration_date: item.expiration_date.format('YYYY-MM-DD') }
        const res = await getWorkload(params)
        item.standard_workload = res.data.standard_workload
        item.level = res.data.performance_level + '/' + res.data.standard_factor
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
    addPeople () {
      this.form1.other_sub_tasks.push({
        handler_id: undefined,
        expiration_date: undefined,
        description: undefined,
        standard_workload: undefined,
        adjust_reason: undefined,
        level: undefined,
        checked: false
      })
      this.otherFollowerArr.push([])
      this.otherFollowerID.push(undefined)
    },
    removePeople (e) {
      this.form1.other_sub_tasks.splice(e, 1)
      this.otherFollowerArr.splice(e, 1)
      this.otherFollowerID.splice(e, 1)
      this.form1.other_sub_tasks.forEach((item, index) => {
        this.$set(this.otherFollowerArr, index, item.handler_id ? [{ id: item.handler_id, name: item.handler_name }] : [])
        this.$set(this.otherFollowerID, index, item.handler_id ? item.handler_id : undefined)
        this.$refs['otherFollowerRef' + index].value = item.handler_id
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
          if (this.form1.main_sub_task.expiration_date) {
            data.main_sub_task.expiration_date = this.form1.main_sub_task.expiration_date.format('YYYY-MM-DD')
          }
          data.main_sub_task.checked = undefined
          this.form1.other_sub_tasks.map((item, index) => {
            item.checked = undefined
            if (item.expiration_date) {
              data.other_sub_tasks[index].expiration_date = item.expiration_date.format('YYYY-MM-DD')
            }
          })
          data.product_modules.forEach((item) => {
            item.moduleTags = []
          })

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
          if (this.$route.query.link === 'dev') {
            if (this.$route.query.id) {
              editDevTask(this.$route.query.id, formData).then(res => {
                if (res.code === 200) {
                  this.$message.success('修改任务成功')
                  this.$router.push({ name: 'task', query: { type: 'dev', project: this.$route.query.project ? 1 : undefined } })
                  this.btnLoad = false
                }
              }).catch(error => {
                this.btnLoad = false
                this.$message.error(error.response ? error.response.data.message : error.message)
              })
            } else {
              postDevTask(formData).then(res => {
                if (res.code === 200) {
                  this.$message.success('发布任务成功')
                  this.$router.push({ name: 'task', query: { type: 'dev', project: this.$route.query.project ? 1 : undefined } })
                  this.btnLoad = false
                }
              }).catch(error => {
                this.btnLoad = false
                this.$message.error(error.response ? error.response.data.message : error.message)
              })
            }
          } else {
            if (this.$route.query.id) {
              editTestTask(this.$route.query.id, formData).then(res => {
                if (res.code === 200) {
                  this.$message.success('修改任务成功')
                  this.$router.push({ name: 'task', query: { type: 'test', project: this.$route.query.project ? 1 : undefined } })
                  this.btnLoad = false
                }
              }).catch(error => {
                this.btnLoad = false
                this.$message.error(error.response ? error.response.data.message : error.message)
              })
            } else {
              postTestTask(formData).then(res => {
                if (res.code === 200) {
                  this.$message.success('发布任务成功')
                  this.$router.push({ name: 'task', query: { type: 'test', project: this.$route.query.project ? 1 : undefined } })
                  this.btnLoad = false
                }
              }).catch(error => {
                this.btnLoad = false
                this.$message.error(error.response ? error.response.data.message : error.message)
              })
            }
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
