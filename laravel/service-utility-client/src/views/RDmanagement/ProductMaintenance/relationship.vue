<template>
  <div>
    <div class="header">
      <a-input-search placeholder="输入关键字搜索"
                      style="width: 420px"
                      @search="onSearch" />
      <span class="more">
        <mySearch @search="moreSearch" ref="search"></mySearch>
      </span>
    </div>
    <div v-if="productsData.length===0" class="con">
        <img src="@/assets/images/empty.png">
        <p>空空如也~</p>
    </div>
    <div class="table"
         v-for="(item,index) in productsData"
         :key="index">
      <a-card style="width: 100%">
        <div class="pro">
          <h1><span class="pro_name"
                  :title="item.name">{{item.name}}</span> </h1>
        </div>
        <span :class="item.status ? 'on' : 'off'"
              >{{item.status ? '开启中': '关闭中'}}</span>
        <!-- 产品线 -->
        <a-table :columns="columns"
                 :dataSource="item.children"
                 :pagination="false"
                 :rowKey="record=> record.id"
                 childrenColumnName="child">
          <span slot="name"
                slot-scope="name,record"
                class="pro"
                @click="showDrawer(record.id,name)">
            <div style="padding-left:20px">
              <span class="txt"
                    :title="name">
                {{name}}
              </span>
              <a-popover placement="bottomLeft"
                         arrowPointAtCenter>
                <template slot="content">
                  <div class="tooltip" >
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
                <a-icon v-if="record.teams.length"
                        class="user"
                        type="user" />
              </a-popover>
            </div>

          </span>
          <span class="status"
                slot="status"
                slot-scope="text"
                :style="{color: text ? '#3DCCA6' : '#FF4A4A'}">{{text ? '开启中': '关闭中'}}</span>
          <span slot="tags"
                slot-scope="tags">
            <a-tag v-for="(tag,index) in tags"
                   :key="index"
                   style="margin-bottom: 4px"
                   :class="tag.status ? 'ontags' : 'offtags'">
              {{tag.name}}
              <!-- <a-popover placement="bottomLeft"
                         arrowPointAtCenter>
                <template slot="content">
                  <div class="tooltip">
                    <div>
                      <span style="color:rgba(187, 187, 187, 1)"> 产品负责人: </span>
                      <span>{{tag.team_principal_users.product}}</span>
                    </div>
                     <div>
                      <span style="color:rgba(187, 187, 187, 1)"> 开发负责人: </span>
                      <span>{{tag.team_principal_users.develop}}</span>
                    </div>
                     <div>
                      <span style="color:rgba(187, 187, 187, 1)"> 设计负责人: </span>
                      <span>{{tag.team_principal_users.design}}</span>
                    </div>
                     <div>
                      <span style="color:rgba(187, 187, 187, 1)"> 测试负责人: </span>
                      <span>{{tag.team_principal_users.test}}</span>
                    </div>
                  </div>
                </template>
                <a-icon v-if="tag.teams.length"
                        class="user"
                        type="user" />
              </a-popover> -->

            </a-tag>
          </span>
        </a-table>
      </a-card>

    </div>

    <!-- 绑定右边弹出层 -->
    <a-drawer width="716"
              placement="right"
              :closable="true"
              @close="onClose"
              :visible="visible2">
      <span slot="title"
            class="title "
            :title="proName"
            v-if="show" style="font-weight: bold;font-size: 16px;color:#333;">绑定关系 (产品名称 : <span class="text-p-overflow" style="max-width:422px;vertical-align: -6px;">{{proName}}</span>)
          <div class="edit" @click="edit" v-if="canDo('pm.products.members')">
              <a-icon type="form"
                       />
              <span>编辑</span>
          </div>
        </span>
      <span slot="title"
            class="title"
            v-else>编辑绑定关系
        <span class="action">
          <a-button class="l-btn"
                    @click="cancel">取消</a-button>
          <a-button type="primary"
                    @click="ok">保存</a-button>
        </span>
      </span>

      <!-- 绑定关系显示 -->
      <div v-if="show">
        <!-- <div class="bind"
             v-for="(item,index) in teams"
             :key="index">
          <h1 v-if="item.type===1">产品团队</h1>
          <h1 v-if="item.type===2">设计团队</h1>
          <h1 v-if="item.type===3">开发团队</h1>
          <h1 v-if="item.type===4">测试团队</h1>
          <div class="Mperson">
            <a-avatar :size="30"
                      icon="user"
                      class="avatar" /><span>{{item.user_name}}
              <span v-if="item.type===1">(产品负责人)</span>
              <span v-if="item.type===2">(设计负责人)</span>
              <span v-if="item.type===3">(开发负责人)</span>
              <span v-if="item.type===4">(测试负责人)</span>
            </span>
          </div>
          <br>
          <div class="person"
               v-for="(member,index) in item.members"
               :key="index">
            <a-avatar :size="30"
                      icon="user"
                      class="avatar" /><span>{{member.user_name}}
              <span v-if="member.type===1">(交互)</span>
              <span v-if="member.type===2">(视觉)</span>
              <span v-if="member.type===3">(前端)</span>
              <span v-if="member.type===4">(移动端)</span>
              <span v-if="member.type===5">(美工)</span>
            </span>
          </div>
        </div> -->
        <div class="bind">
          <h1>产品团队</h1>
          <div class="Mperson">
            <a-avatar :size="30"
                      icon="user"
                      class="avatar" /><span>
                    <span v-if="edit_format.product_user && edit_format.product_user.main_user">{{edit_format.product_user.main_user.user_name}}</span>
                    <span v-else>暂无</span>
                       (产品主负责人)
            </span>
          </div>
          <span  v-if="edit_format.product_user && edit_format.product_user.other_user">
            <div class="Mperson" v-for="(item,index) in edit_format.product_user.other_user" :key="index">
                <a-avatar :size="30"
                        icon="user"
                        class="avatar" /><span>
                        <span>{{item.user_name}}</span>
                </span>
             </div>
          </span>
          <br>
          <div v-if="edit_format.product_user&&edit_format.product_user.members">
            <div class="person"
                v-for="(member,index) in edit_format.product_user.members"
                :key="index">
                <a-avatar :size="30"
                        icon="user"
                        class="avatar" /><span>{{member.user_name}}</span>

            </div>
           </div>
        </div>
        <div v-if="edit_format.design_user">
            <div class="bind" v-for="(item,index) in edit_format.design_user" :key="index">
            <h1>设计团队<span v-if="edit_format.design_user.length>1">{{index+1}}</span></h1>
            <div class="Mperson">
                <a-avatar :size="30"
                        icon="user"
                        class="avatar" /><span>
                        <span>{{item.design_user_name}}</span>
                        <span v-if="!item.design_user_name">暂无</span>
                        (设计负责人)
                </span>
            </div>
            <br>
            <div v-if="item.members">
                <div class="person"
                    v-for="(member,index) in item.members"
                    :key="index">
                    <a-avatar :size="30"
                            icon="user"
                            class="avatar" />
                    <span>{{member.user_name}}
                                <span v-if="member.type===1">(交互)</span>
                                <span v-if="member.type===2">(视觉)</span>
                                <span v-if="member.type===3">(前端)</span>
                                <span v-if="member.type===4">(移动端)</span>
                                <span v-if="member.type===5">(美工)</span>
                    </span>

                </div>
            </div>
            </div>
        </div>
        <div v-else>
            <div class="bind">
            <h1>设计团队</h1>
            <div class="Mperson">
                <a-avatar :size="30"
                        icon="user"
                        class="avatar" /><span>
                        <span>暂无</span>
                        (设计负责人)
                </span>
            </div>
            </div>
        </div>
        <div class="bind">
          <h1>开发团队</h1>
          <div class="Mperson">
            <a-avatar :size="30"
                      icon="user"
                      class="avatar" /><span>
                    <span v-if="edit_format.dev_user && edit_format.dev_user.main_user">{{edit_format.dev_user.main_user.user_name}}</span>
                    <span v-else>暂无</span>
                       (开发主负责人)
            </span>
          </div>
            <span v-if="edit_format.dev_user && edit_format.dev_user.other_user">
            <div class="Mperson" v-for="(item,index) in edit_format.dev_user.other_user" :key="index">
                <a-avatar :size="30"
                        icon="user"
                        class="avatar" /><span>
                        <span >{{item.user_name}}</span>
                </span>
            </div>
          </span>
        </div>
        <div class="bind">
          <h1>测试团队</h1>
          <div class="Mperson">
            <a-avatar :size="30"
                      icon="user"
                      class="avatar" /><span>
                    <span v-if="edit_format.test_user && edit_format.test_user.main_user">{{edit_format.test_user.main_user.user_name}}</span>
                    <span v-else>暂无</span>
                       (测试主负责人)
            </span>
          </div>
          <span v-if="edit_format.test_user && edit_format.test_user.other_user">
            <div class="Mperson" v-for="(item,index) in edit_format.test_user.other_user" :key="index">
                <a-avatar :size="30"
                        icon="user"
                        class="avatar" /><span>
                        <span >{{item.user_name}}</span>
                </span>
            </div>
          </span>
        </div>

      </div>
      <!-- 编辑绑定关系 -->
      <div class="editBind"
           v-if="!show">
        <div>
          <h1>产品团队</h1>
          <p class="Mpeople">产品主负责人 <span style="margin-left:155px">次要负责人</span></p>
          <a-select style="width: 208px;margin-right:20px;"
                    showSearch
                    allowClear
                    placeholder="请输入英文名搜索"
                    optionFilterProp="children"
                    @search="search($event, 1)"
                    v-model="form1.product_user.main_user">
            <a-select-option v-for="item in options_1"
                             :key="item.id">{{item.name}}</a-select-option>

          </a-select>
           <a-select style="width:calc(100% - 228px);"
                     showSearch
                     mode="multiple"
                     optionFilterProp="children"
                     v-model="form1.product_user.other_user"
                     @change="choosePeople($event,1)"
                     @search="search($event, 11)"
                     placeholder="请输入英文名搜索"
                     >
            <a-select-option v-for="item in options_1_1"
                             :key="item.id">{{item.name}}</a-select-option>

          </a-select>
        </div>

        <div class="people">
          <p class="Mpeople">产品成员</p>
          <a-select style="width: 100%"
                    showSearch
                    mode="multiple"
                    placeholder="请输入英文名搜索"
                    @search="search($event, 12)"
                    optionFilterProp="children"
                    v-model="form1.product_user.members">
            <a-select-option v-for="item in options_1_2"
                             :key="item.id">{{item.name}}</a-select-option>

          </a-select>
        </div>
        <!-- 设计团队 -->
        <addTeam ref="design"
                 :valueData="form1.design_user"></addTeam>
        <div class="people">
          <h1>开发团队</h1>
          <p class="Mpeople">开发主负责人 <span style="margin-left:155px">次要负责人</span></p>
          <a-select style="width: 208px;margin-right:20px"
                    showSearch
                    allowClear
                    placeholder="请输入英文名搜索"
                    optionFilterProp="children"
                    @search="search($event, 3)"
                    v-model="form1.dev_user.main_user">
            <a-select-option v-for="item in options_3"
                             :key="item.id">{{item.name}}</a-select-option>

          </a-select>
           <a-select style="width:calc(100% - 228px)"
                    showSearch
                    mode="multiple"
                    placeholder="请输入英文名搜索"
                    @change="choosePeople($event,2)"
                    @search="search($event, 31)"
                    optionFilterProp="children"
                    v-model="form1.dev_user.other_user">
            <a-select-option v-for="item in options_3_1"
                             :key="item.id">{{item.name}}</a-select-option>

          </a-select>
        </div>
        <div class="people">
          <h1>测试团队</h1>
          <p class="Mpeople">测试主负责人 <span style="margin-left:155px">次要负责人</span></p>
          <a-select style="width: 208px;margin-right:20px"
                    showSearch
                    allowClear
                    placeholder="请输入英文名搜索"
                    optionFilterProp="children"
                    @search="search($event, 4)"
                    v-model="form1.test_user.main_user">
            <a-select-option v-for="item in options_4"
                             :key="item.id">{{item.name}}</a-select-option>

          </a-select>
           <a-select style="width:calc(100% - 228px)"
                    showSearch
                    mode="multiple"
                    placeholder="请选择"
                    @change="choosePeople($event,3)"
                    @search="search($event, 41)"
                    optionFilterProp="children"
                    v-model="form1.test_user.other_user">
            <a-select-option v-for="item in options_4_1"
                             :key="item.id">{{item.name}}</a-select-option>

          </a-select>
        </div>
      </div>
    </a-drawer>

    <!-- 操作未保存提示弹框 -->
    <a-modal title="提示"
             v-model="visible3"
             @ok="hideModal"
             okText="确认"
             cancelText="取消"
             width="380px">
      <p>操作未保存,确定退出吗?</p>
    </a-modal>
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
  height: 58px;
}
/deep/.ant-table-body tr:nth-child(even) {
  background: #f8f8f8;
  height: 58px;
}
/deep/.ant-select-selection--multiple{
    height:auto !important;
}
.charge {
  width: 208px;
}
.offtags {
  color: #bbbbbb;
  background: rgba(187, 187, 187, 0.2) !important;
}
.ontags {
  color: #26a3e0;
  background: rgba(38, 163, 224, 0.2) !important;
}
.fz12 {
  font-size: 12px;
}
.user {
  margin-left: 10px;
  margin-right: 4px;
}
.question {
  margin: 0 4px;
}
.tooltip {
  max-width: 240px;
    padding-bottom:8px;
}
.editBind {
  width: 660px;
}
.action {
  cursor: pointer;
  position: absolute;
  right: 60px;
  top: 14px;
  .l-btn {
    margin-right: 10px;
  }
}
.Mpeople {
  margin-bottom: 10px;
}
.people {
  margin-top: 20px;
  margin-bottom: 20px;
}
.edit {
  cursor: pointer;
  position: absolute;
  font-weight: normal;
  right: 60px;
  top: 16px;
    color:#378EEF;
    font-size: 12px;
    span{
        padding-left:4px;
    }
}

.bind {
  margin-bottom: 29px;
  h1 {
    margin-bottom: 20px;
  }
}

.Mperson {
  background: rgba(253, 218, 66, 1);
  margin-bottom: 10px;
  margin-right: 12px;
  display: inline-block;
  padding-right: 10px;
  height: 34px;
  border-radius: 17px;
  line-height: 34px;
  .avatar {
    margin-right: 10px;
    vertical-align: middle;
      position: relative;
      left: 2px;
      top: -2px;
  }
}
.person {
  margin-bottom: 10px;
  margin-right: 12px;
  display: inline-block;
  padding-right: 10px;
  height: 34px;
  background: rgba(238, 238, 238, 1);
  border-radius: 17px;
  line-height: 34px;
  .avatar {
    margin-right: 10px;
    vertical-align: middle;
      position: relative;
      left: 2px;
      top: -2px;
  }
}
h1 {
  font-size: 14px;
  font-weight: bold;
}
.pro {
  cursor: pointer;
  position: relative;
  .pro_name {
    font-size: 14px;
    vertical-align: top;
    display: inline-block;
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .txt {
    vertical-align: top;
    display: inline-block;
    max-width: 158px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
}

.header {
  height: 48px;
  text-align: center;
  .more {
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
    margin-top: 4px;
    float: right;
  }
}
.ant-table-tbody .ant-tag {
  line-height: 30px;
  height: 30px;
  padding: 0 10px;
  border-radius: 3px;
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
  color: rgba(61, 204, 166, 1);
  font-size: 12px;
}
</style>

<script>
import { canDo, filtering } from '@/plugins/common'
import addTeam from './components/addTeam'
import mySearch from '@/components/search'
import { getBindPeople } from '@/api/RDmanagement/dropDown'
import { searchUserList } from '@/api/userManage/index.js'
import { getTeamsData, bindMembers, getProductsData } from '@/api/RDmanagement/ProductMaintenance/index.js'
const columns = [
  {
    title: '产品名称',
    dataIndex: 'name',
    key: 'name',
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

const data = [
  {
    key: '1',
    name: '中文站',
    status: '开启中',
    tags: ['首页', '首页首页']
  },
  {
    key: '2',
    name: '中文站',
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
let may = []
let must = []
export default {
  components: { addTeam, mySearch },
  data () {
    return {

      options: [],
      options_1: [],
      options_1_1: [],
      options_1_2: [],
      options_3: [],
      options_3_1: [],
      options_4: [],
      options_4_1: [],
      form1: {
        product_user: { main_user: undefined, other_user: [], members: [] },
        dev_user: { main_user: undefined, other_user: [] },
        test_user: { main_user: undefined, other_user: [] },
        design_user: [
          {
            design: [],
            design_user_id: undefined,
            members: []
          }
        ]
      },
      productsData: [],
      teams: [],
      edit_format: [],
      data,
      columns,
      proId: '',
      proName: '',
      show: true,
      visible: false,
      visible2: false,
      visible3: false
    }
  },
  watch: {

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
          } else if (type === 11) {
            self.options_1_1 = data.data.users
          } else if (type === 12) {
            self.options_1_2 = data.data.users
          } else if (type === 3) {
            self.options_3 = data.data.users
          } else if (type === 31) {
            self.options_3_1 = data.data.users
          } else if (type === 4) {
            self.options_4 = data.data.users
          } else if (type === 41) {
            self.options_4_1 = data.data.users
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
      getProductsData(params).then(res => {
        this.productsData = res.data.products
        this.$refs.search.showSearch = false
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    choosePeople (e, status) {
      if (status === 1) {
        let index = this.form1.product_user.other_user.indexOf(this.form1.product_user.main_user)
        if (index !== -1) {
          this.$message.error('不可重复绑定负责人！')
          this.form1.product_user.other_user.splice(index, 1)
        }
      } else if (status === 2) {
        let index = this.form1.dev_user.other_user.indexOf(this.form1.dev_user.main_user)
        if (index !== -1) {
          this.$message.error('不可重复绑定负责人！')
          this.form1.dev_user.other_user.splice(index, 1)
        }
      } else if (status === 3) {
        let index = this.form1.test_user.other_user.indexOf(this.form1.test_user.main_user)
        if (index !== -1) {
          this.$message.error('不可重复绑定负责人！')
          this.form1.test_user.other_user.splice(index, 1)
        }
      }
    },
    cancel () {
      this.visible2 = false
      this.options_1 = []
      this.options_1_1 = []
      this.options_1_2 = []
      this.options_3 = []
      this.options_3_1 = []
      this.options_4 = []
      this.options_4_1 = []
      this.show = true
    },
    ok () {
      this.form1.design_user = this.$refs.design.design_user
      let params = JSON.parse(JSON.stringify(this.form1))
      if (params.product_user) {
        if (!params.product_user.main_user) {
          delete params.product_user
        }
      }
      if (params.test_user && !params.test_user.main_user) {
        delete params.test_user
      }
      if (params.dev_user && !params.dev_user.main_user) {
        delete params.dev_user
      }

      if (params.design_user.length > 0) {
        params.design_user.forEach((item, index) => {
          if (!item.design_user_id) {
            params.design_user.splice(index, 1)
          }
        })
      }
      // 判断设计负责人是否重复
      //   var valueArr = params.design_user.map(function (item) { return item.design_user_id })
      //   var isDuplicate = valueArr.some(function (item, idx) {
      //     return valueArr.indexOf(item) !== idx
      //   })
      bindMembers(this.proId, params).then(res => {
        if (res.code === 200) {
          this.$message.success('编辑成功')
          this.getAllData()
          this.visible2 = false
          this.options_1 = []
          this.options_1_1 = []
          this.options_1_2 = []
          this.options_3 = []
          this.options_3_1 = []
          this.options_4 = []
          this.options_4_1 = []
          this.show = true
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
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
    showDrawer (id, name) {
      this.proId = id
      this.proName = name
      getTeamsData(id).then(res => {
        if (res.code === 200) {
          this.teams = res.data.teams
          this.edit_format = res.data.edit_format
          this.visible2 = true
          if (res.data.edit_format.length === 0) {
            this.form1 = {
              product_user: { main_user: undefined, other_user: [], members: [] },
              dev_user: { main_user: undefined, other_user: [] },
              test_user: { main_user: undefined, other_user: [] },
              design_user: [
                {
                  design_user_id: undefined,
                  members: []
                }
              ]
            }
            this.options_1 = []
            this.options_1_1 = []
            this.options_1_2 = []
            this.options_3 = []
            this.options_3_1 = []
            this.options_4 = []
            this.options_4_1 = []
          } else {
            this.form1 = res.data.edit_format
            this.options_1 = this.edit_format.product_user.main_user.user_id ? [{ id: this.edit_format.product_user.main_user.user_id, name: this.edit_format.product_user.main_user.user_name }] : []
            if (this.edit_format.product_user.other_user && this.edit_format.product_user.other_user.length > 0) {
              this.edit_format.product_user.other_user.forEach(item => {
                this.options_1_1.push({ id: item.user_id, name: item.user_name })
              })
            } else {
              this.options_1_1 = []
            }
            if (this.edit_format.product_user.members && this.edit_format.product_user.members.length > 0) {
              this.edit_format.product_user.members.forEach(item => {
                this.options_1_2.push({ id: item.user_id, name: item.user_name })
              })
            } else {
              this.options_1_2 = []
            }
            this.options_3 = this.edit_format.dev_user.main_user.user_id ? [{ id: this.edit_format.dev_user.main_user.user_id, name: this.edit_format.dev_user.main_user.user_name }] : []
            if (this.edit_format.dev_user.other_user && this.edit_format.dev_user.other_user.length > 0) {
              this.edit_format.dev_user.other_user.forEach(item => {
                this.options_3_1.push({ id: item.user_id, name: item.user_name })
              })
            } else {
              this.options_3_1 = []
            }
            this.options_4 = this.edit_format.test_user.main_user.user_id ? [{ id: this.edit_format.test_user.main_user.user_id, name: this.edit_format.test_user.main_user.user_name }] : []
            if (this.edit_format.test_user.other_user && this.edit_format.test_user.other_user.length > 0) {
              this.edit_format.test_user.other_user.forEach(item => {
                this.options_4_1.push({ id: item.user_id, name: item.user_name })
              })
            } else {
              this.options_4_1 = []
            }
            if (!this.form1.product_user) {
              this.$set(this.form1, 'product_user', { main_user: undefined, other_user: [], members: [] })
            }
            if (!this.form1.test_user) {
              this.$set(this.form1, 'test_user', { main_user: undefined, other_user: [] })
            }
            if (!this.form1.dev_user) {
              this.$set(this.form1, 'dev_user', { main_user: undefined, other_user: [] })
            }
            if (this.form1.design_user) {
              this.form1.design_user.forEach(item => {
                item.members.forEach(item2 => {
                  // 交互
                  if (item2.type === 1) {
                    item.interactive_id = item2.user_id
                  }
                  // 视觉
                  if (item2.type === 2) {
                    item.vision_id = item2.user_id
                  }
                  // 前端
                  if (item2.type === 3) {
                    item.web_id = item2.user_id
                  }
                  // 移动端
                  if (item2.type === 4) {
                    item.mobile_id = item2.user_id
                  }
                  // 美工
                  if (item2.type === 5) {
                    item.art_id = item2.user_id
                  }
                })
              })
            } else {
              this.form1.design_user = [
                {
                  design: [],
                  design_user_id: undefined,
                  members: []
                }
              ]
            }
          }
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    onClose () {
      if (!this.show) {
        this.visible3 = true
      } else if (this.show) {
        this.visible2 = false
        this.options_1 = []
        this.options_1_1 = []
        this.options_1_2 = []
        this.options_3 = []
        this.options_3_1 = []
        this.options_4 = []
        this.options_4_1 = []
        setTimeout(() => {
          this.show = true
        }, 1000)
      }
    },
    edit () {
      this.show = false
      if (this.form1.product_user && this.form1.product_user.main_user) {
        this.form1.product_user.main_user = this.form1.product_user.main_user.user_id
        this.form1.product_user.members = this.form1.product_user.members.map(item => {
          return item.user_id
        })
        if (this.form1.product_user.other_user) {
          this.form1.product_user.other_user = this.form1.product_user.other_user.map(item => {
            return item.user_id
          })
        }
      }
      if (this.form1.dev_user && this.form1.dev_user.main_user) {
        this.form1.dev_user.main_user = this.form1.dev_user.main_user.user_id
        if (this.form1.dev_user.other_user) {
          this.form1.dev_user.other_user = this.form1.dev_user.other_user.map(item => {
            return item.user_id
          })
        }
      }
      if (this.form1.test_user && this.form1.test_user.main_user) {
        this.form1.test_user.main_user = this.form1.test_user.main_user.user_id
        if (this.form1.test_user.other_user) {
          this.form1.test_user.other_user = this.form1.test_user.other_user.map(item => {
            return item.user_id
          })
        }
      }
    },
    hideModal () {
      this.visible3 = false
      this.visible2 = false
      this.options_1 = []
      this.options_1_1 = []
      this.options_1_2 = []
      this.options_3 = []
      this.options_3_1 = []
      this.options_4 = []
      this.options_4_1 = []
      setTimeout(() => {
        this.show = true
      }, 1000)
    },
    getAllData () {
      this.$store.dispatch('getProducts').then(res => {
        this.productsData = res
      })
    }
  },
  created () {
    getBindPeople().then(res => {
      if (res.code === 200) {
        this.options = res.data.users
      }
    })
    // this.$store.dispatch('getProducts')
    if (this.$store.state.ProductMaintenance.productsData.length > 0) {
      this.productsData = this.$store.state.ProductMaintenance.productsData
    } else {
      this.productsData = JSON.parse(localStorage.getItem('products'))
    }
  }
}
</script>
