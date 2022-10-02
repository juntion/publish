<template>
  <div>
    <!-- 操作记录弹框 -->
    <a-modal title="状态变动记录"
             v-model="visible"
             @ok="handleOk"
             width="746px"
             class="eidt-model eidt-model-border">
      <a-table :columns="columns2"
               :dataSource="data2"
               :pagination="false"
               :rowKey="(record, index) => index">
          <div slot="status"
               slot-scope="status,record">
            <span class="status_txt" style="color:#FF4A4A" v-if="record.status==='关闭'">关闭中</span>
            <span class="status_txt" style="color:#3dcca6" v-if="record.status==='开启中'">开启中</span>
          </div>
      </a-table>

    </a-modal>

    <div class="header">
      <a-input-search placeholder="输入关键字搜索"
                      style="width: 420px"
                      @search="onSearch" />
      <span class="more">
        <mySearch @search="moreSearch" ref="search"></mySearch>
      </span>
      <a-button type="primary"
                class="btn"
                v-if="canDo('pm.products.productMaintenance')"
                @click="goToPMM">产品管理维护</a-button>
    </div>
    <div class="example"
         v-if="loading">
      <a-spin />
    </div>
    <div v-if="productsData.length===0" class="con">
        <img src="../../../assets/images/empty.png">
        <p>空空如也~</p>
    </div>
    <div class="table"
         v-for="(item, index) in productsData"
         :key="index">
      <a-card style="width: 100%">
        <div class="pro">
          <h1>
            <span class="pro_name"
                  :title="item.name">{{ item.name }}</span>
            <a-popover placement="bottomLeft"
                       arrowPointAtCenter>
              <template slot="content">
                <div style="max-width:216px;">
                  {{ item.description }}
                </div>
              </template>
              <a-icon v-if="item.description"
                      class="question"
                      type="question-circle" />
            </a-popover>
          </h1>
        </div>
        <span :class="item.status ? 'on' : 'off'"
              @click="showModal(item.id)">{{ item.status ? "开启中" : "关闭中" }}</span>
        <!-- 产品线 -->
        <a-table :columns="columns"
                 :dataSource="item.children"
                 :pagination="false"
                 childrenColumnName="child"
                 :rowKey="record => record.id">
          <span slot="name"
                slot-scope="text, record"
                class="pro">
            <div style="padding-left:20px">
              <span class="txt"
                    :title="text">{{ text }} </span>
              <a-popover placement="bottomLeft"
                         arrowPointAtCenter>
                <template slot="content">
                  <div style="max-width:216px;">
                    {{ record.description }}
                  </div>
                </template>
                <a-icon v-if="record.description"
                        class="question"
                        type="question-circle" />
              </a-popover>

              <a-popover placement="bottomLeft"
                         v-if="record.teams.length"
                         arrowPointAtCenter>
                <template slot="content">
                  <div class="tooltip">
                    <div>
                      <span style="color:rgba(187, 187, 187, 1)"> 产品负责人: </span>
                      <span>{{record.team_principal_users.product}}</span>
                    </div>
                     <div>
                      <span style="color:rgba(187, 187, 187, 1)"> 开发负责人: </span>
                      <span>{{record.team_principal_users.develop}}</span>
                    </div>
                     <div>
                      <span style="color:rgba(187, 187, 187, 1)"> 设计负责人: </span>
                      <span>{{record.team_principal_users.design}}</span>
                    </div>
                     <div>
                      <span style="color:rgba(187, 187, 187, 1)"> 测试负责人: </span>
                      <span>{{record.team_principal_users.test}}</span>
                    </div>
                  </div>
                </template>
                <a-icon
                        class="user"
                        type="user" />
              </a-popover>
            </div>
          </span>
          <span class="status"
                slot="status"
                slot-scope="text, record"
                @click="showModal(record.id)"
                :style="{ color: text ? '#3DCCA6' : '#FF4A4A' }">{{ text ? "开启中" : "关闭中" }}</span>
          <span slot="tags"
                slot-scope="tags"
          >
            <a-tag v-for="(tag, index) in tags"
                   :key="index"
                   @click="showModal(tag.id)"
                   :class="tag.status ? 'ontags' : 'offtags'">
              <span>{{ tag.name }}</span>
              <a-popover placement="bottomLeft"
                         arrowPointAtCenter>
                <template slot="content">
                  <div style="max-width:216px;">
                    {{ tag.description }}
                  </div>
                </template>

                <a-icon v-if="tag.description"
                        class="question"
                        type="question-circle" />
              </a-popover>

              <a-popover placement="bottomLeft"
                         arrowPointAtCenter>
                <template slot="content">
                  <div class="tooltip">
                    <a-tag color="rgba(38,163,224,1)" style="margin-bottom:10px;"
                           v-for="(k, index) in tag.children"
                           :key="index">{{ k.name }}</a-tag>
                  </div>
                </template>
                <span v-if="tag.children.length"
                      class="iconfont fz12" style="cursor: pointer;vertical-align: bottom">&#xe636;</span>
              </a-popover>
            </a-tag>
          </span>
        </a-table>
      </a-card>
    </div>
  </div>
</template>

<style lang="less" scoped>
/deep/.ant-table-thead > tr:first-child > th:first-child {
  padding-left: 20px;
}
/deep/.ant-table-thead > tr{
    height:58px;
    min-height:58px;
}
.example {
  text-align: center;
  background: rgba(0, 0, 0, 0.05);
  border-radius: 4px;
  margin-bottom: 20px;
  padding: 30px 100px;
  margin: 20px 0;
  z-index: 100;
}

/deep/.ant-table-body tr:nth-child(odd) {
  background: #fff;
  height:58px;
}
/deep/.ant-table-body tr:nth-child(even) {
  background: #f8f8f8;
   height:58px;
}
.user {
  margin-right: 4px;
    position: relative;
    top: -1px;
    color: #666;
}
.margin {
  margin: 3px;
}
.fz12 {
  font-size: 12px;
}
.tooltip {
  max-width: 270px;
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
.question {
  position: relative;
  top: -1px;
  margin-right: 10px;
  margin-left: 4px;
}
.drag-icon {
  margin-right: 10px;
}
h1 {
  font-weight: bold;
  font-size: 14px;
}
.pro {
  position: relative;
  .pro_name {
    font-size: 14px;
    vertical-align: top;
    display: inline-block;
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    cursor: pointer;
  }
  .txt {
    vertical-align: top;
    display: inline-block;
    max-width: 158px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
      cursor: pointer;
  }
}
.header {
  text-align: center;
  position: relative;
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
    // float: right;
    position: absolute;
    right: 0;
    background: #378eef;
  }
}

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
.offtags {
  color: #bbbbbb;
  background: rgba(187, 187, 187, 0.2) !important;
}
.ontags {
  color: #26a3e0;
  background: rgba(38, 163, 224, 0.2) !important;
}
.table {
  margin-top: 30px;
  position: relative;
  /deep/.ant-tag {
    border: 0;
  }
  .on {
    position: absolute;
    top: 24px;
    left: 303px;
    color: rgba(61, 204, 166, 1);
    cursor: pointer;
  }
  .off {
    position: absolute;
    top: 24px;
    left: 303px;
    color: #ff4a4a;
    cursor: pointer;
  }
}
.status {
  cursor: pointer;
  color: rgba(61, 204, 166, 1);
  font-size: 12px;
}
// 修改css
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

    max-width: 240px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}
.ant-table-tbody > tr > td {
  padding: 14px 0px;
}

.eidt-model-border /deep/ .ant-table-thead > tr > th {
    border-bottom:1px solid #eee;
}
.eidt-model-border .ant-table-thead > tr > th, .ant-table-tbody > tr > td{
    padding: 7px 0px;
}
/deep/ .ant-popover-inner-content{
    padding: 10px;
}
</style>
<style>
/* 修改记录的弹窗css */
.ant-modal-content .ant-modal-header {
  padding: 12.5px 20px;
  border-bottom: 1px solid #eee;
  background: #f8f8f8;
}
.ant-table-placeholder{
    border-bottom: none;
}
.ant-modal-title {
  color: #666;
}
.eidt-model .ant-modal-body {
  padding-top: 0;
    padding-bottom:0;
}
.eidt-model .ant-table-body tr:nth-child(even) {
  background: #fff;
}
.eidt-model .ant-table-thead > tr > th {
  background: #fff !important;
}
.eidt-model .ant-table-thead > tr:first-child > th:first-child {
  padding-left: 0px;
}
.eidt-model .ant-modal-footer {
  border-top: 0;
    display: none;
}
.eidt-model .ant-table-body{
    margin-top: 6px;
    margin-bottom:6px;
}

</style>

<script>
// import searchMore from './components/searchMore'
import mySearch from '@/components/search'
import { mapGetters } from 'vuex'
import { canDo, filtering } from '@/plugins/common'
import {
  getProductsData,
  getProductsLog
} from '@/api/RDmanagement/ProductMaintenance/index.js'
const columns = [
  {
    title: '产品名称',
    dataIndex: 'name',
    key: 'name',
    // slots: { title: 'customTitle' },
    scopedSlots: { customRender: 'name' },
    width: 280
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
    width: 100,
    scopedSlots: { customRender: 'status' }
  },
  {
    title: '操作人',
    key: 'user_name',
    width: 120,
    dataIndex: 'user_name'
  },
  {
    title: '描述',
    key: 'comment',
    dataIndex: 'comment',
    width: 292

  }
]
const data = [
  {
    key: '1',
    name: '中文站',
    status: '开启中',
    tags: ['首页', '首页首页']
  },
  {
    key: '2',
    name: '日文站',
    status: '开启中',
    tags: ['首页', '首页首页首页']
  },
  {
    key: '3',
    name: '中文站',
    status: '开启中',
    tags: ['首页', '首页首页首页']
  },
  {
    key: '4',
    name: '中文站',
    status: '开启中',
    tags: ['首页', '首页首页首页']
  }
]
const data2 = [
  {
    key: '1',
    time: '2019/11/09 12:00',
    status: '开启中',
    actions: '开启',
    operator: 'Vicky.Wei',
    describe: '描述信息描述信息描述信息'
  },
  {
    key: '2',
    time: '2019/11/09 12:00',
    status: '开启中',
    actions: '开启',
    operator: 'Vicky.Wei',
    describe: '描述信息描述信息描述信息'
  },
  {
    key: '3',
    time: '2019/11/09 12:00',
    status: '开启中',
    actions: '开启',
    operator: 'Vicky.Wei',
    describe: '描述信息描述信息描述信息'
  }
]
let may = []
let must = []
export default {
  components: { mySearch },
  data () {
    return {
      loading: false,
      data,
      columns,
      data2,
      columns2,
      products: [],
      productsData: [],
      showData: false,
      visible: false,
      showSearch: false
    }
  },
  computed: {
    ...mapGetters(['getProducts'])
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
        must
      }

      getProductsData(params).then(res => {
        this.productsData = res.data.products
        this.$refs.search.showSearch = false
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    goToPMM () {
      this.$router.push({ name: 'PMMaintenance' })
    },
    show () {
      this.showData = true
    },
    off () {
      this.showData = false
    },
    showModal (id) {
      getProductsLog(id)
        .then(res => {
          // console.log(res.data.status_logs)
          if (res.code === 200) {
            this.data2 = res.data.status_logs
            this.visible = true
          }
        })
        .catch(error => {
          this.$message.error(
            error.response
              ? error.response.data.message
              : error.message
          )
        })
    },
    handleOk (e) {
      this.visible = false
    },
    onSearch (value) {
      if (value) {
        let params = {
          'search[keyword]': '%' + value.trim() + '%'
        }
        getProductsData(params).then(res => {
          this.productsData = res.data.products
        })
      } else {
        getProductsData().then(res => {
          this.productsData = res.data.products
        })
      }
    },
    showMore () {
      this.showSearch = !this.showSearch
    }
  },
  created () {
    if (localStorage.getItem('isReload4')) {
      this.$store.commit('changeGuide4', false)
    } else {
      this.$store.commit('changeGuide4', true)
      localStorage.setItem('isReload4', true)
    }
    if (this.$store.state.ProductMaintenance.productsData.length > 0) {
      this.loading = false
      this.productsData = this.$store.state.ProductMaintenance.productsData
    } else {
      this.$store.dispatch('getProducts').then(res => {
        this.loading = false
        this.productsData = res
      })
    }
  },
  mounted () {

  }
}
</script>
