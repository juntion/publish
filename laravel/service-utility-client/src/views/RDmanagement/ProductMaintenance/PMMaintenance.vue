<template>
  <div>
    <div class="header">
      <a-button class="btn1"
                @click="goBack">
        <a-icon type="arrow-left" /> 返回</a-button>
      <a-input-search placeholder="输入关键字搜索"
                      style="width: 420px"
                      @search="onSearch" />
      <span class="more">
        <mySearch @search="moreSearch" ref="search"></mySearch>
      </span>

      <a-button type="primary"
                class="btn"
                @click="showModal1">
        <a-icon type="plus" v-if="canDo('pm.products.store')" /> 新增产品线</a-button>
    </div>
    <div v-if="productsData.length===0" class="con">
        <img src="@/assets/images/empty.png">
        <p>空空如也~</p>
    </div>
    <!-- 新增产品线弹框 -->
    <a-modal title="新增产品线"
             v-model="visible1"
             @cancel="cancel1"
             @ok="handleOk1"
             :maskClosable="false"
             width="708px"
             okText="新增">
      <a-form :form="proLineForm">
        <a-form-item class="pmForm">
          <p class="lineHeihgt-none"><span style="color:red">*</span> 产品线名称</p>
          <a-input class="input"
                   v-decorator="['name', { rules: [{ required: true, message: '请填写产品线名称' }] }]"
                   placeholder="请填写产品线名称" />
        </a-form-item>
        <a-form-item class="pmForm">
          <p class="lineHeihgt-none"><span style="color:red">*</span> 产品线简介</p>
          <a-input style="width:467px"
                   v-decorator="['description', { rules: [{ required: true, message: '请填写产品线简介' }] }]"
                   placeholder="请填写产品线简介" />
        </a-form-item>
      </a-form>
      <addProduct ref="productsLine"></addProduct>
        <span slot="footer"
                  class="dialog-footer">
              <el-button @click="cancel1">取 消</el-button>
              <el-button type="primary"
                         :loading="btnLoad"
                         @click="handleOk1">新 增</el-button>
        </span>
    </a-modal>

    <!-- 新增产品弹框 -->
    <a-modal title="新增产品"
             v-model="visible2"
             :maskClosable="false"
             @ok="handleOk2"
             @cancel="cancel2"
             width="708px"
             >
      <addProduct ref="addProductModal"></addProduct>
        <span slot="footer"
                  class="dialog-footer">
              <el-button @click="cancel2">取 消</el-button>
              <el-button type="primary"
                         :loading="btnLoad"
                         @click="handleOk2">新 增</el-button>
        </span>
    </a-modal>

    <!-- 新增产品模块弹框 -->
    <a-modal title="新增产品模块"
             v-model="visible3"
             @cancel="cancel3"
             @ok="handleOk3"
             :maskClosable="false"
             width="708px"
            >
      <addProduct ref="addModuleModal"
                  placeholder="模块"
                  text="新增模块"></addProduct>
      <span slot="footer"
                  class="dialog-footer">
              <el-button @click="cancel3">取 消</el-button>
              <el-button type="primary"
                         :loading="btnLoad"
                         @click="handleOk3">新 增</el-button>
        </span>
    </a-modal>

    <!-- 标签管理弹框 -->
    <a-modal title="标签管理"
             :maskClosable="false"
             v-model="visible4"
             @cancel="cancel4"
             width="708px"
             :footer="null"
    >

      <addTag :label="labelData"
              :fn="getAllData"
              :tagId="tagId"></addTag>
    </a-modal>

    <!-- 编辑绑定负责人弹框 -->
    <a-modal title="编辑绑定负责人"
             :maskClosable="false"
             v-model="visible5"
             @cancel="cancel5"
             @ok="handleOk5"
             width="380px"
             okText="确定">
      <div style="margin-bottom: 10px;">
        <div style="padding-bottom: 10px;">产品负责人</div>
        <a-select style="width: 100%"
                  showSearch
                  placeholder="请输入英文名搜索"
                  optionFilterProp="children"
                  @search="search($event, 1)"
                  v-model="form1.product_user_id">
          <a-select-option v-for="item in options_1"
                           :key="item.id">{{item.name}}</a-select-option>

        </a-select>
      </div>
      <div style="margin-bottom: 10px;">
        <div style="margin-bottom: 10px;">设计负责人</div>
        <a-select style="width: 100%"
                  showSearch
                  placeholder="请输入英文名搜索"
                  optionFilterProp="children"
                  @search="search($event, 2)"
                  v-model="form1.design_user_id">
          <a-select-option v-for="item in options_2"
                           :key="item.id">{{item.name}}</a-select-option>

        </a-select>
      </div>
      <div style="margin-bottom: 10px;">
        <div style="margin-bottom: 10px;">开发负责人</div>
        <a-select style="width: 100%"
                  showSearch
                  placeholder="请输入英文名搜索"
                  optionFilterProp="children"
                  @search="search($event, 3)"
                  v-model="form1.dev_user_id">
          <a-select-option v-for="item in options_3"
                           :key="item.id">{{item.name}}</a-select-option>

        </a-select>
      </div>
      <div style="margin-bottom: 10px;">
        <div style="margin-bottom: 10px;">测试负责人</div>
        <a-select style="width: 100%"
                  showSearch
                  placeholder="请输入英文名搜索"
                  optionFilterProp="children"
                  @search="search($event, 4)"
                  v-model="form1.test_user_id">
          <a-select-option v-for="item in options_4"
                           :key="item.id">{{item.name}}</a-select-option>

        </a-select>
      </div>
    </a-modal>

    <!-- 编辑产品模块弹框  -->
    <a-modal title="编辑模块"
             v-model="visible6"
             :maskClosable="false"
             @ok="handleOk6"
             @cancel="cancel6"
             width="380px"
             okText="确定">
      <a-form :form="deitForm">
        <div class="mb">模块开关</div>
        <el-switch :active-value="1"
                   active-color="RGBA(58, 205, 167, 1)"
                   :inactive-value="0"
                   class="mb"
                   @change="changeMsg"
                   v-model="check1" />
        <div v-if="showAction">
          <div class="mb"><span style="color:red">*</span> 操作说明</div>
          <a-form-item>
            <a-textarea placeholder="请对此次操作进行说明"
                        v-decorator="['moduleComment', { rules: [{ required: true, message: '请填写操作说明' }] }]"
                        :autosize="{ minRows: 3, maxRows: 6 }"
                        class="mb" />
          </a-form-item>
        </div>
        <div class="mb">模块简介</div>

        <a-textarea placeholder="请输入模块简介内容"
                    v-model="moduleDescription"
                    :autosize="{ minRows: 3, maxRows: 6 }"
                    class="mb" />

      </a-form>
    </a-modal>

    <!-- 编辑产品简介 -->
    <a-modal :title="line ? '编辑产品线简介' : '编辑产品简介'"
             v-model="visible7"
             class="edit-introduction"
             :maskClosable="false"
             @ok="handleOk7"
             width="380px"
             okText="确定">
      <a-textarea :placeholder="line ? '请输入产品线简介' : '请输入产品简介'"
                  v-model="productDescription"
                  :autosize="{ minRows: 3, maxRows: 6 }" />
    </a-modal>

    <!-- 操作说明 -->
    <a-modal title="操作说明"
             class="eidt-explanation-modal"
             v-model="visible8"
             :maskClosable="false"
             @ok="handleOk8"
             @cancel="cancel8"
             width="380px"
             okText="确定">
      <a-form :form="form">
        <a-form-item label="操作说明">
          <a-textarea v-decorator="[
                    'comment',
                    { rules: [{ required: true, message: '请填写操作说明' }] },
                    ]"
                      placeholder="请输入操作说明"
                      :autosize="{ minRows: 3, maxRows: 6 }" />
        </a-form-item>
      </a-form>

    </a-modal>

    <!-- 修改产品线名字提示框 -->
    <a-modal title="提示"
             class="tips"
             v-model="visible9"
             :maskClosable="false"
             @ok="handleOk9"
             @cancel="cancel9"
             width="380px"
             okText="确定">

      <p class="info">确定要修改这个名称吗？</p>
        <div slot="footer" style="text-align: center;">
            <a-button type="primary"
                            @click="handleOk9">确 定</a-button>
            <a-button @click="cancel9">取 消</a-button>
        </div>
    </a-modal>

    <!-- 修改产品名字提示框 -->
    <a-modal title="提示"
             class="tips"
             v-model="visible10"
             :maskClosable="false"
             @ok="handleOk10"
             @cancel="cancel10"
             width="380px"
             okText="确定">

      <p class="info">确定要修改这个名称吗？</p>
      <div slot="footer" style="text-align: center;">
         <a-button type="primary"
                         @click="handleOk10">确 定</a-button>
        <a-button @click="cancel10">取 消</a-button>
      </div>
    </a-modal>

    <!-- 修改产品名字提示框 -->
    <a-modal title="提示"
             class="tips"
             v-model="visible11"
             :maskClosable="false"
             @ok="handleOk11"
             @cancel="cancel11"
             width="380px"
             okText="确定">

      <p class="info">确定要修改这个名称吗？</p>
       <div slot="footer" style="text-align: center;">
         <a-button type="primary"
                         @click="handleOk11">确 定</a-button>
        <a-button @click="cancel11">取 消</a-button>
        </div>
    </a-modal>
    <!-- 产品线列表 -->
    <div>
        <draggable :options="dragOptions"
                @end="onEnd"
                @start="onStart"
                @change="change"
                :list="productsData">
        <div class="table"
            v-for="(item,index) in productsData"
            :key="index">
            <a-card style="width: 100%">
            <h1>
                <span class="iconfont drag-icon">&#xe646;</span>
                <span class="proName"
                    :ref="'name-'+item.id"
                    @dblclick="showInput2(item)">
                {{item.name}}
                </span>
                <span class="active"
                    :ref="'editinput-'+item.id">
                <a-input v-model="editname2"
                        :ref="'input-'+item.id"
                        style="max-width:128px"
                        @blur="editName2(item)"
                        @pressEnter="editName2(item)" />
                </span>
                <a-popover placement="bottomLeft"
                        arrowPointAtCenter>
                    <template slot="content">
                        <div style="max-width:216px;">{{item.description}}</div>
                    </template>
                    <a-icon class="question"
                            style="top:0"
                            type="question-circle" />
                </a-popover>
                <span class="iconfont edit"
                        @click="showModal7(item.id,item.description,true)">&#xe637;</span>
            </h1>
            <div class="on">
                <el-switch :active-value="1"
                        v-if="canDo('pm.products.status')"
                        active-color="RGBA(58, 205, 167, 1)"
                        :inactive-value="0"
                        :value="item.status"
                        @change="onChange($event,item.id)" />
                <span class="addProduct"
                    @click="showModal2(item.id)">
                  <a-icon type="plus" v-if="canDo('pm.products.addProducts')"/> 新增产品</span>
            </div>
            <div class="onOff">

            </div>

            <!-- 产品列表 -->
            <a-table :columns="columns"
                    :dataSource="item.children"
                    v-if="showTable"
                    :rowKey="record=> record.id"
                    childrenColumnName="child"
                    :pagination="false">

                <span slot="name"
                    slot-scope="name, record">
                <div style="padding-left:20px">
                    <span class="iconfont drag-icon">&#xe646;</span>
                    <span class="active"
                        :ref="'editInput'+record.id">
                    <a-input v-model="editname"
                            style="max-width:128px"
                            :ref="'input'+record.id"
                            @blur="editName(record)"
                            @pressEnter="editName(record)" />
                    </span>
                    <span class="pName"
                        :title="name"
                        :ref="'name'+record.id"
                        @dblclick="showInput(record)"> {{name}}</span>
                    <!-- 产品简介 -->
                    <a-popover placement="bottomLeft"
                            arrowPointAtCenter>
                    <template slot="content">
                        <div style="max-width:;">{{record.description}}</div>
                    </template>
                    <span class="iconfont question">&#xe640;</span>
                    </a-popover>
                    <!-- 绑定用户关系 -->
                    <span @click="showModal5(record.id)"
                        v-if="canDo('pm.products.teams')"
                        class="iconfont user">&#xe639;</span>
                    <!-- 编辑产品简介 -->
                    <span class="iconfont edit"
                        v-if="canDo('pm.products.description')"
                        @click="showModal7(record.id,record.description,false)">&#xe637;</span>
                </div>
                </span>
                <span slot="status"
                    slot-scope="status,record">
                <el-switch class="Mstatus"
                            v-if="canDo('pm.products.status')"
                            :active-value="1"
                            active-color="RGBA(58, 205, 167, 1)"
                            :inactive-value="0"
                            :value="record.status"
                            @change="onChangeStatus($event,record.id)">
                </el-switch>
                </span>
                <div slot="tags"
                    slot-scope="tags,record">
                <draggable :options="dragOptions"
                                :list="tags"
                                @change="changeTags($event,tags)"
                            class="drag-tags">
                    <span v-for="(tag,index) in tags" :key="index">
                        <a-tag
                            :class="tag.status ? 'ontags' : 'offtags'"
                            style="margin-bottom: 4px"
                            @mouseenter="onTag(tag.id)"
                            @mouseleave="offTag(tag.id)"
                            class="tags">
                        <span class="iconfont drag-icon">&#xe646;</span>
                        <span :ref="'name--'+tag.id"
                                @dblclick="saveRow(tag)">{{tag.name}}</span>
                        <span class="active"
                                :ref="'editinput--'+tag.id">
                            <a-input v-model="editname3"
                                    :ref="'input--'+tag.id"
                                    style="max-width:128px;height:22px"
                                    @blur="editName3(tag)"
                                    @pressEnter="editName3(tag)" />
                        </span>
                        <span :class="{'active':isactlive}"
                                :ref="'name'+tag.id"
                                :data-id="tag.id">

                            <!-- 绑定用户关系 -->
                            <!-- <span @click="showModal5(tag.id)"
                             v-if="canDo('pm.products.teams')"
                            class="iconfont user" style="vertical-align: baseline;">&#xe639;</span> -->

                            <!-- 添加标签 -->
                            <span @click="showModal4(tag.children,tag.id)"
                                class="iconfont fz12" style="cursor: pointer;margin: 0 4px 0 10px;">&#xe636;</span>
                            <!-- 编辑 -->
                            <a-icon type="form"
                                    class="padding"
                                    v-if="canDo('pm.products.modifyModules')"
                                    @click="showModal6(tag.status,tag.id,tag.description)" />
                        </span>

                        </a-tag>
                    </span>
                </draggable>
                <span class="addIcon"
                        v-if="canDo('pm.products.modules')"
                        @click="showModal3(record.id)">
                        <img src="../../../assets/images/addicon.png" alt="">
                </span>
                </div>
            </a-table>
            </a-card>
        </div>
        </draggable>
    </div>
  </div>
</template>

<style lang="less" scoped>
.con {
    position: relative;
    top: 130px;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    p {
      font-size: 16px;
      margin-top: 20px;
    }
  }
/deep/.ant-table-thead > tr:first-child > th:first-child {
  padding-left: 20px;
}

/deep/.ant-table-body tr:nth-child(odd) {
  background: #fff;
  height:58px;
}
/deep/.ant-table-body tr:nth-child(even) {
  background: #f8f8f8;
  height:58px;
}
.active {
  display: none;
}
.drag-tags {
  display: inline-block;
}
.addIcon {
  display: inline-block;
  width: 15px;
  height: 15px;
  background: rgba(38, 163, 224, 1);
  opacity: 0.2;
  border-radius: 50%;
  vertical-align: middle;
  /*background-image: url("../../../assets/images/addicon.png");*/
  position: relative;
  cursor: pointer;
}
.addIcon img{
    position: absolute;
    top: 0;
    left: 0;
    margin: auto;
    bottom: 0;
    right: 0;
}
.drag-icon {
  font-size: 10px;
  cursor: move;
  vertical-align: middle;
  margin-right: 8px;
}
.fz12 {
  font-size: 12px;
}
.mb {
  margin-bottom: 10px;
}
.padding {
  padding: 0 5px;
}
.pmForm {
  display: inline-block;
  margin-bottom: 16px;
    width: 28.5%;
    margin-right: 10px;
}

h1 {
  font-weight: bold;
}
.tips {
  .ant-modal-footer {
    text-align: center;
    border-top: 0 !important;
  }
  .info {
    padding: 20px;
    text-align: center;
    font-size: 16px;
  }
}

.offtags {
  color: #bbbbbb;
  background: rgba(187, 187, 187, 0.2) !important;
}
.ontags {
  color: #26a3e0;
  background: rgba(38, 163, 224, 0.2) !important;
}
.header {
  height: 48px;
  text-align: center;
  position: relative;
  .more {
    margin-left: 4px;
    width: 24px;
    height: 11px;
    font-size: 12px;
    font-family: Microsoft YaHei;
    font-weight: 400;
    color:#378EEF;
    line-height: 48px;
  }
  .btn {
    margin-top: 4px;
    float: right;
    background: #378eef;
  }
  .btn1 {
    margin-top: 4px;
    float: left;
    color: #bbbbbb;
    font-size: 14px;
  }
}

.table {
  margin-top: 10px;
  position: relative;
  /deep/.ant-tag {
    border: 0;
  }
  .question {
    position: relative;
    top: 1px;
    cursor: pointer;
    font-size: 12px;
    margin: 0 5px;
    margin-left: 4px;
    vertical-align: middle;
  }
  .user {
    cursor: pointer;
    font-size: 12px;
    margin: 0 5px;
    vertical-align: middle;
  }
  .edit {
    cursor: pointer;
    font-size: 12px;
    margin: 0 5px;
    vertical-align: middle;
    font-weight: normal;
  }
  .proName {
    font-size: 14px;
    vertical-align: top;
    display: inline-block;
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    cursor: pointer;
  }
  & .proName:hover {
    background: #eeeeee;
  }
  .pName {
    vertical-align: middle;
    display: inline-block;
    max-width: 158px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .pName:hover {
    background: #eeeeee;
  }
  .onOff {
    position: absolute;
    top: 24px;
    right: 30px;

  }
  .on {
    position: absolute;
    top: 24px;
    left: 313px;
    color: rgba(61, 204, 166, 1);
    cursor: pointer;
    .addProduct {
      margin-left: 90px;
      color:#378EEF;
    }
  }
}
// 修改项目任务管理css
.ant-card-wider-padding .ant-card-body {
  padding: 20px 20px;
}

.pro {
  padding-bottom: 6px;
}
.ant-table-thead tr th {
  padding: 10px 0px;
}
.ant-table-tbody .ant-tag {
  line-height: 30px;
  height: 30px;
  padding: 0 10px;
  border-radius: 3px;
}

.ant-table-tbody > tr > td {
  padding: 14px 0px;
}
/deep/ .ant-table-thead>tr>th{
    border-bottom: none;
}
/deep/ .ant-tag-blue{
    border: none;
}
</style>
<style>
    .edit-introduction .ant-modal-footer{
        padding: 20px;
    }

    .eidt-easy-modal .ant-modal-content .ant-modal-body {
         padding:20px !important;
     }
    .eidt-easy-modal .ant-modal-footer{
        padding:20px;
    }
    .eidt-explanation-modal .ant-form-item-label{
        line-height: initial;
        padding-bottom:10px;
    }
    .eidt-explanation-modal .ant-modal-footer {
          border-top: 0 !important;
          padding: 20px;
          padding-top:0;
    }
   .eidt-explanation-modal .ant-modal-body .ant-form-item{
       margin-bottom:16px;
   }
    .ant-modal-body {
     padding: 20px !important;
    }
    .ant-modal-content .ant-modal-body{
        padding: 20px 20px 0 20px !important;
    }

</style>
<script>
import { canDo, filtering } from '@/plugins/common'
import addProduct from './modal/addProduct'
import addTag from './components/addTag'
import mySearch from '@/components/search'
import draggable from 'vuedraggable'
import { getBindPeople } from '@/api/RDmanagement/dropDown'
import { editProductName, changeProductStatus, editDescription, addProductsLine, addProducts, addProductsModule, editProductModules, getTreeData, productSort, bindTeam, getTeamsData, getProductsData, getProducts } from '@/api/RDmanagement/ProductMaintenance/index.js'
import { searchUserList } from '@/api/userManage/index.js'
const dragOptions = {
  sort: true,
  disabled: false,
  scroll: true,
  scrollSpeed: 2,
  animation: 150,
  ghostClass: 'dragable-ghost',
  chosenClass: 'dragable-chose',
  dragClass: 'dragable-drag'
}
const columns = [
  {
    title: '产品名称',
    dataIndex: 'name',
    key: 'name',
    width: 290,
    scopedSlots: { customRender: 'name' }
  },
  {
    title: '状态',
    dataIndex: 'status',
    key: 'status',
    width: 130,
    scopedSlots: { customRender: 'status' }
  },
  {
    title: '产品模块',
    key: 'children',
    dataIndex: 'children',
    scopedSlots: { customRender: 'tags' }
  }
]
let may = []
let must = []
export default {
  components: { addProduct, addTag, mySearch, draggable },
  watch: {

  },
  data () {
    return {
      line: '',
      btnLoad: false,
      options: [],
      options_1: [],
      options_2: [],
      options_3: [],
      options_4: [],
      form1: {
        product_user_id: undefined,
        design_user_id: undefined,
        dev_user_id: undefined,
        test_user_id: undefined
      },
      teams: [],
      editname: '',
      editname2: '',
      editname3: '',
      info: {},
      showAction: false,
      labelData: null,
      tagId: null,
      isactlive: true,
      bindTeamId: null,
      changeStatusId: '',
      actionExplain: '',
      addProductId: '',
      addProductModuleId: '',
      productId: '',
      productDescription: '',
      moduleComment: '',
      moduleDescription: '',
      dragOptions: { ...dragOptions, group: this.group },
      showTable: true,
      productsData: [],
      pmValue: 1,
      activeIndex: -1,
      check1: false,
      columns,
      visible1: false,
      productsLine: {
        name: undefined,
        description: undefined,
        products: undefined
      },
      visible2: false,
      visible3: false,
      visible4: false,
      visible5: false,
      visible6: false,
      visible7: false,
      visible8: false,
      visible9: false,
      visible10: false,
      visible11: false,
      form: this.$form.createForm(this, { name: 'comment' }),
      proLineForm: this.$form.createForm(this, { name: 'addProLine' }),
      deitForm: this.$form.createForm(this, { name: 'edit' }),
      params: {},
      statusId: ''
    }
  },
  created () {
    getBindPeople().then(res => {
      if (res.code === 200) {
        this.options = res.data.users
      }
    })
    if (this.$store.state.ProductMaintenance.productsData.length > 0) {
      this.productsData = this.$store.state.ProductMaintenance.productsData
    } else {
      this.productsData = JSON.parse(localStorage.getItem('products'))
    }
    getTreeData().then(res => {
    })
  },
  methods: {
    canDo,
    filtering,
    search (e, type) {
      this.$nextTick(() => {
        let self = this
        this.timer = searchUserList(this.timer, e, function (data) {
          if (type === 1) {
            self.options_1 = data.data.users
          } else if (type === 2) {
            self.options_2 = data.data.users
          } else if (type === 3) {
            self.options_3 = data.data.users
          } else if (type === 4) {
            self.options_4 = data.data.users
          }
        })
      })
    },
    // 高级搜索
    moreSearch (e) {
      may = []
      must = []
      filtering(e, may, must)
      let params = {
        may,
        must
      }
      if (Object.keys(must).length || Object.keys(may).length) {
        this.dragOptions.disabled = true
      } else {
        this.dragOptions.disabled = false
      }
      getProductsData(params).then(res => {
        this.productsData = res.data.products
        this.$refs.search.showSearch = false
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    changeMsg () {
      this.showAction = !this.showAction
    },

    onTag (id) {
      let name = 'name' + id
      this.$refs[name][0].className = ''
    },
    offTag (id) {
      let name = 'name' + id
      let classes = this.$refs[name][0].className
      this.$refs[name][0].className = classes + ' active'
    },
    goBack () {
      this.$router.push({ name: 'ProductMaintenance' })
    },
    onChange (checked, id) {
      let params = {}
      params.status = checked
      params.comment = this.actionExplain
      this.visible8 = true
      this.params = params
      this.statusId = id
    },
    onChangeStatus (checked, id) {
      let params = {}
      params.status = checked
      params.comment = this.actionExplain
      this.visible8 = true
      this.params = params
      this.statusId = id
    },
    onSearch (value) {
      if (value) {
        this.dragOptions.disabled = true
        let params = {
          'search[keyword]': '%' + value + '%'
        }
        getProductsData(params).then(res => {
          this.productsData = res.data.products
        })
      } else {
        this.dragOptions.disabled = false
        getProductsData().then(res => {
          this.productsData = res.data.products
        })
      }
    },
    showModal1 () {
      this.visible1 = true
    },
    cancel1 () {
      this.visible1 = false
      this.$refs.productsLine.form.resetFields()
      this.proLineForm.resetFields()
    },
    handleOk1 (e) {
      this.proLineForm.validateFields((err, values) => {
        if (err) {
          return false
        }
        this.productsLine = values
      })
      this.$refs.productsLine.form.validateFields((err, values) => {
        if (err) {
          return false
        }
        let params = values.params.filter(d => d)
        this.productsLine.products = params
      })
      if (this.productsLine.products && this.productsLine.description && this.productsLine.name) {
        this.btnLoad = true
        addProductsLine(this.productsLine).then(res => {
          if (res.code === 200) {
            this.$message.success('添加产品线成功')
            this.visible1 = false
            this.btnLoad = false
            this.getAllData()
            this.$refs.productsLine.form.resetFields()
            this.proLineForm.resetFields()
          }
        }).catch(error => {
          this.btnLoad = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      }
    },
    showModal2 (id) {
      this.visible2 = true
      this.addProductId = id
    },
    cancel3 () {
      this.visible3 = false
      this.$refs.addModuleModal.form.resetFields()
    },
    cancel4 () {
      this.getAllData()
    },
    cancel5 () {
      this.form1.product_user_id = undefined
      this.form1.design_user_id = undefined
      this.form1.dev_user_id = undefined
      this.form1.test_user_id = undefined
    },
    cancel2 () {
      this.visible2 = false
      this.$refs.addProductModal.form.resetFields()
    },
    handleOk2 (e) {
      this.$refs.addProductModal.form.validateFields((err, values) => {
        if (!err) {
          let params = values.params.filter(d => d)
          this.btnLoad = true
          addProducts(this.addProductId, params).then(res => {
            if (res.code === 200) {
              this.$message.success('添加产品成功')
              this.$refs.addProductModal.form.resetFields()
              this.visible2 = false
              this.btnLoad = false
              this.getAllData()
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
    showModal3 (id) {
      this.addProductModuleId = id
      this.visible3 = true
    },
    handleOk3 (e) {
      this.$refs.addModuleModal.form.validateFields((err, values) => {
        if (!err) {
          let params = values.params.filter(d => d)
          this.btnLoad = true
          addProductsModule(this.addProductModuleId, params).then(res => {
            if (res.code === 200) {
              this.$message.success('添加产品模块成功')
              this.$refs.addModuleModal.form.resetFields()
              this.visible3 = false
              this.btnLoad = false
              this.getAllData()
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
    showModal4 (item, id) {
      this.visible4 = true
      this.labelData = item
      this.tagId = id
    },
    showModal5 (id) {
      this.visible5 = true
      this.bindTeamId = id
      getTeamsData(id).then(res => {
        if (res.code === 200) {
          this.teams = res.data.teams
          this.teams.forEach(item => {
            if (item.type === 1 && item.is_default === 1) {
              this.form1.product_user_id = item.user_id
              this.options_1 = [{ id: item.user_id, name: item.user_name }]
            } else if (item.type === 2 && item.is_default === 1) {
              this.form1.design_user_id = item.user_id
              this.options_2 = [{ id: item.user_id, name: item.user_name }]
            } else if (item.type === 3 && item.is_default === 1) {
              this.form1.dev_user_id = item.user_id
              this.options_3 = [{ id: item.user_id, name: item.user_name }]
            } else if (item.type === 4 && item.is_default === 1) {
              this.form1.test_user_id = item.user_id
              this.options_4 = [{ id: item.user_id, name: item.user_name }]
            }
          })
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    handleOk5 (e) {
      bindTeam(this.bindTeamId, this.form1).then(res => {
        if (res.code === 200) {
          this.$message.success('绑定成功')
          this.visible5 = false
          this.options_1 = []
          this.options_2 = []
          this.options_3 = []
          this.options_4 = []
          this.getAllData()
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    handleChange (value) {
    },
    showModal6 (status, id, txt) {
      this.changeStatusId = id
      this.check1 = status
      this.moduleDescription = txt
      this.visible6 = true
    },
    cancel6 () {
      this.showAction = false
    },
    handleOk6 (e) {
      if (!this.showAction) {
        let params = {}
        params.status = this.check1
        params.description = this.moduleDescription
        editProductModules(this.changeStatusId, params).then(res => {
          if (res.code === 200) {
            this.$message.success('修改产品模块成功')
            this.visible6 = false
            this.showAction = false
            this.getAllData()
          }
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else {
        this.deitForm.validateFields((err, values) => {
          if (!err) {
            let params = {}
            params.status = this.check1
            params.description = this.moduleDescription
            params.comment = values.moduleComment
            editProductModules(this.changeStatusId, params).then(res => {
              if (res.code === 200) {
                this.$message.success('修改产品模块成功')
                this.visible6 = false
                this.showAction = false
                this.getAllData()
              }
            }).catch(error => {
              this.$message.error(error.response ? error.response.data.message : error.message)
            })
          }
        })
      }
    },
    showModal7 (id, txt, line) {
      this.line = line
      this.visible7 = true
      this.productId = id
      this.productDescription = txt
    },
    handleOk7 () {
      editDescription(this.productId, this.productDescription).then(res => {
        if (res.code === 200) {
          //   console.log(res)
          this.$message.success('修改描述成功')
          this.visible7 = false
          this.getAllData()
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    cancel8 () {
      this.form.resetFields()
    },
    handleOk8 () {
      this.form.validateFields((err, values) => {
        if (!err) {
          this.params.comment = values.comment
          changeProductStatus(this.params, this.statusId).then(res => {
            this.getAllData()
            this.visible8 = false
            this.$message.success('修改成功')
            this.form.resetFields()
          }).catch(error => {
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        }
      })
    },
    cancel9 () {
      const k = this.info
      let editInput = 'editinput-' + k.id
      let name = 'name-' + k.id
      this.visible9 = false
      this.$refs[editInput][0].className = 'active'
      this.$refs[name][0].className = 'proName'
    },
    handleOk9 () {
      const k = this.info
      let editInput = 'editinput-' + k.id
      let name = 'name-' + k.id
      if (this.editname2 !== k.name) {
        editProductName(k.id, this.editname2).then(res => {
          if (res.code === 200) {
            k.name = this.editname2
            this.visible9 = false
            this.$refs[editInput][0].className = 'active'
            this.$refs[name][0].className = 'proName'
            this.$message.success('修改成功')
          }
        })
      }
    },
    cancel10 () {
      const k = this.info
      let editInput = 'editInput' + k.id
      let name = 'name' + k.id
      this.visible10 = false
      this.$refs[editInput][0].className = 'active'
      this.$refs[name][0].className = 'pName'
    },
    handleOk10 () {
      const k = this.info
      let editInput = 'editInput' + k.id
      let name = 'name' + k.id
      if (this.editname !== k.name) {
        k.name = this.editname
        editProductName(k.id, this.editname).then(res => {
          if (res.code === 200) {
            k.name = this.editname
            this.visible10 = false
            this.$refs[editInput][0].className = 'active'
            this.$refs[name][0].className = 'pName'
            this.$message.success('修改成功')
          }
        })
      }
      this.$refs[editInput][0].className = 'active'
      this.$refs[name][0].className = ''
    },
    cancel11 () {
      const k = this.info
      let editInput = 'editinput--' + k.id
      let name = 'name--' + k.id
      this.visible11 = false
      this.$refs[editInput][0].className = 'active'
      this.$refs[name][0].className = ''
    },
    handleOk11 () {
      const k = this.info
      let editInput = 'editinput--' + k.id
      let name = 'name--' + k.id
      if (this.editname3 !== k.name) {
        k.name = this.editname3
        editProductName(k.id, this.editname3).then(res => {
          if (res.code === 200) {
            k.name = this.editname3
            this.visible11 = false
            this.$refs[editInput][0].className = 'active'
            this.$refs[name][0].className = ''
            this.$message.success('修改成功')
          }
        })
      }
      this.$refs[editInput][0].className = 'active'
      this.$refs[name][0].className = ''
    },
    showInput (k) {
      if (this.canDo('pm.products.name')) {
        let input = 'input' + k.id
        let editInput = 'editInput' + k.id
        let name = 'name' + k.id
        this.editname = k.name
        this.$refs[editInput][0].className = 'pName'
        this.$refs[name][0].className = 'active'
        this.$nextTick(function () {
          this.$refs[input][0].focus()
        })
      }
    },
    showInput2 (k) {
      if (this.canDo('pm.products.name')) {
        let input = 'input-' + k.id
        let editInput = 'editinput-' + k.id
        let name = 'name-' + k.id
        this.editname2 = k.name
        this.$refs[editInput][0].className = ''
        this.$refs[name][0].className = 'active'
        this.$nextTick(function () {
          this.$refs[input][0].focus()
        })
      }
    },
    saveRow (k) {
      if (this.canDo('pm.products.name')) {
        let input = 'input--' + k.id
        let editInput = 'editinput--' + k.id
        let name = 'name--' + k.id
        this.editname3 = k.name
        this.$refs[editInput][0].className = ''
        this.$refs[name][0].className = 'active'
        this.$nextTick(function () {
          this.$refs[input][0].focus()
        })
      }
    },
    editName2 (k) {
      this.info = k
      let editInput = 'editinput-' + k.id
      let name = 'name-' + k.id
      if (this.editname2 !== k.name) {
        this.visible9 = true
      } else {
        this.$refs[editInput][0].className = 'active'
        this.$refs[name][0].className = 'proName'
      }
    },
    editName3 (k) {
      this.info = k
      let editInput = 'editinput--' + k.id
      let name = 'name--' + k.id
      if (this.editname3 !== k.name) {
        this.visible11 = true
      } else {
        this.$refs[editInput][0].className = 'active'
        this.$refs[name][0].className = ''
      }
    },
    editName (k) {
      this.info = k
      let editInput = 'editInput' + k.id
      let name = 'name' + k.id
      if (this.editname !== k.name) {
        this.visible10 = true
      } else {
        this.$refs[editInput][0].className = 'active'
        this.$refs[name][0].className = 'pName'
      }
    },
    onStart (e) {
      this.showTable = false
    },
    onEnd (e) {
      this.showTable = true
    },
    change (evt) {
      //   调用排序接口
      let sort = this.productsData.map((item, index) => {
        return { product_id: item.id, sort: index }
      })
      let params = { products_sort: sort }
      productSort(params).then(res => {
      })
    },
    changeTags (evt, tags) {
      let sort = tags.map((item, index) => {
        return { product_id: item.id, sort: index }
      })

      let params = { products_sort: sort }
      productSort(params).then(res => {
      })
    },
    getAllData () {
      this.$store.dispatch('getProducts').then(res => {
        this.productsData = res
      })
    }
  }
}
</script>
