<template>
    <div class="userList">
        <a-card>
            <div class="select-options">
                <a-form layout="inline" style="display: inline-block;" :form="searchForm">
                <div class="btn_div_relative">
                  <span class="btn_span_absolute" style="top: -10px;">默认部门</span>
                  <a-form-item class="userList-department">
                      <a-tree-select
                              showSearch
                              treeNodeFilterProp="title"
                              v-decorator="['department']"
                              :placeholder='$t("user.user.all")'
                              allowClear
                              style="width: 260px"
                              :treeData="getDepartmentTree"
                              multiple
                              treeCheckable
                              showCheckedStrategy=SHOW_ALL
                      >
                      </a-tree-select>
                  </a-form-item>
                </div>
                <div class="btn_div_relative">
                  <span class="btn_span_absolute">职位</span>
                  <a-form-item>
                      <a-select
                              showSearch
                              :placeholder='$t("user.user.all")'
                              style="width: 110px"
                              v-decorator="['position']"
                              allowClear
                              optionFilterProp="children"
                      >
                          <a-select-option v-for="(item, key) in getAllOptions" :key="key" :value="item.id">
                            {{JSON.parse(item.locale)[getLanguage]}}
                            </a-select-option>
                      </a-select>
                  </a-form-item>
                </div>
                <div class="btn_div_relative">
                  <span class="btn_span_absolute">所属子公司</span>
                  <a-form-item>
                      <a-select
                              showSearch
                              :placeholder='$t("user.user.all")'
                              style="width: 180px"
                              v-decorator="['company_id']"
                              allowClear
                              optionFilterProp="children"
                      >
                          <a-select-option v-for="item in companies" :key="item.id" :value="item.id" :title="item.company_name">
                            {{item.company_name}}
                            </a-select-option>
                      </a-select>
                  </a-form-item>
                </div>
                <div class="btn_div_relative">
                  <span class="btn_span_absolute">侧边栏模板管理</span>
                  <a-form-item>
                      <a-select
                              showSearch
                              :placeholder='$t("user.user.all")'
                              style="width: 180px"
                              v-decorator="['sidebarTemplates']"
                              allowClear
                              optionFilterProp="children"
                      >
                          <a-select-option v-for="item in getTemplatesData" :key="item.id" :value="item.id" :title="item.name">
                            {{item.name}}
                            </a-select-option>
                      </a-select>
                  </a-form-item>
                </div>
                <div class="btn_div_relative">
                  <span class="btn_span_absolute">角色管理</span>
                  <a-form-item>
                      <a-select
                              showSearch
                              :placeholder='$t("user.user.all")'
                              style="width: 180px"
                              v-decorator="['roles']"
                              allowClear
                              optionFilterProp="children"
                      >
                         <a-select-option
                            v-for="(item, key) in roles"
                            :key="key"
                            :value="item.id"
                    >
                        {{JSON.parse(item.locale)[getLanguage]}}
                    </a-select-option>
                      </a-select>
                  </a-form-item>
                </div>
                <div class="btn_div_relative">
                  <span class="btn_span_absolute">更新时间</span>
                  <a-form-item>
                      <a-range-picker
                            style="width:200px"
                             v-decorator="['updated_date']"
                            format="YYYY/MM/DD"
                            >
                            <span class="iconfont" slot="suffixIcon" style="font-size:12px;margin-top: -6px;">&#xe659;</span>
                    </a-range-picker>
                  </a-form-item>
                </div>
                <div class="btn_div_relative">
                  <span class="btn_span_absolute">快速搜索</span>
                  <a-form-item
                            style="width: 180px">
                        <a-input
                                :placeholder='$t("user.user.inputName")'
                                allowClear
                                v-decorator="['name']"/>
                    </a-form-item>
                    <a-form-item>
                        <a-button type="primary" icon="search" @click="searchData"></a-button>
                    </a-form-item>
                </div>
                </a-form>
                <div class="add_user_btn">
                    <a-popover trigger="click" placement="bottomLeft">
                        <div slot="content" >
                            <div style="padding:10px 10px 0">
                                <a-radio-group name="radioGroup" v-model="excelRadio">
                                    <a-radio :value="1">
                                    后台账户管理详情表
                                    </a-radio>
                                </a-radio-group>
                            </div>
                            <div class="export-ok" >
                                <a-button type="primary" @click="handleExport">确定</a-button>
                            </div>
                        </div>
                        <p class="export-p">
                            <i class="icon iconfont"
                            style="font-size: 12px;">&#xe65a;</i> 导出</p>
                    </a-popover>
                    <a-form :form="searchForm">
                        <a-form-item style="float: right">
                            <a-button type="primary" class="marginLeft" @click="showAddModal" v-if="canDo('users.create')">{{this.$t('user.user.createUser')}}</a-button>
                        </a-form-item>
                    </a-form>
                </div>

            </div>
            <a-table
                    :columns="columns"
                    :dataSource="getUserList"
                    :pagination="getPagination"
                    :loading="getPageLoading"
                    @change="handleTableChange"
                    rowKey="id"
                    :rowSelection="{selectedRowKeys: getSelectRows, onChange: onSelectChange}"
            >
                <template slot="email" slot-scope="text, record">
                    {{ record.email.length === 0 ? '--' : record.email}}
                </template>
                <template slot="email_verified_at" slot-scope="text, record">
                    {{ record.email_verified_at === null ? '--' : record.email_verified_at}}
                </template>
                <template slot="department" slot-scope="text, record">
                    {{ record.department.length === 0 ? '--' : JSON.parse(record.department[0].locale)[getLanguage] }}
                </template>
                <template slot="positions" slot-scope="text, record">
                    <span v-if="record.positions.length === 0">{{'--'}}</span>
                    <span v-else v-for="(item, key) in record.positions" :key="key">{{item.length === 0 ? '--' : JSON.parse(item.locale)[getLanguage]}} <br/></span>
                </template>
                <template slot="company" slot-scope="text, record">
                    {{ record.company === null ? '--' : record.company.company_name }}
                </template>
                <template slot="action" slot-scope="text, record">
                    <a-popconfirm placement="top" :okText="$t('user.info.ok')" :cancelText="$t('user.info.cancel')" @confirm="deleteUser(record.id)" v-if="canDo('users.delete')">
                        <template slot="title">
                            <p>{{$t('user.info.deleteSure')}}</p>
                        </template>
                        <a>{{$t('user.action.deleteUser')}}</a>
                    </a-popconfirm>
                    <a-divider type="vertical" v-if="canDo('users.delete')"/>
                    <a @click="updateUser(record)" v-if="canDo('users.update')">{{$t('user.action.updateUser')}}</a>
                    <a-divider type="vertical" v-if="canDo('users.update')"/>
                    <!-- <router-link :to="'/userManage/user/' + record.id + '/subsystemForbid'" v-if="canDo('users.subsystems.forbid')">{{$t('user.action.forbidSubsystem')}}</router-link>
                    <a-divider type="vertical" v-if="canDo('users.subsystems.forbid')"/> -->
                    <a-dropdown>
                        <a class="ant-dropdown-link">
                            {{$t('user.action.moreAction')}} <a-icon type="down" />
                        </a>
                        <a-menu slot="overlay">
                            <a-menu-item  v-if="canDo('users.departments.setDefaultDepartment')">
                                <a @click="showSetDepartmentModal(record)">{{$t('user.action.defaultDepartment')}}</a>
                            </a-menu-item>
                            <a-menu-item  v-if="canDo('users.departments.setOtherDepartment')">
                                <a @click="showSetOtherDepartmentModal(record)">{{$t('user.action.otherDepartment')}} </a>
                            </a-menu-item>
                            <a-menu-item  v-if="canDo('users.positions.setPosition')">
                                <a @click="showSetPositionModal(record)">{{$t('user.action.position')}} </a>
                            </a-menu-item>
                            <!-- <a-menu-item  v-if="true">
                                <a @click="showSetSubsidiaryCompany(record)">{{$t('user.action.subsidiaryCompany')}} </a>
                            </a-menu-item> -->
<!--                            <a-menu-item>-->
<!--                                <a @click="updateUserPermission(record.id)">{{$t('user.action.permission')}} </a>-->
<!--                            </a-menu-item>-->
                            <a-menu-item v-if="canDo('users.roles.syncRoles')">
                                <a @click="showSetUserRoleModal(false, record.id)">{{$t('user.action.role')}} </a>
                            </a-menu-item>
                            <a-menu-item  v-if="canDo('users.homepages.setHomepage')">
                                <a @click="showSetHomePageModal(record.id)">{{$t('user.action.homePage')}} </a>
                            </a-menu-item>
                            <a-menu-item v-if="canDo('users.sidebars.template')">
                                <a @click="showUserSideModal(record.id)">{{$t('user.action.aside')}} </a>
                            </a-menu-item>
                            <a-menu-item v-if="canDo('users.resetPassword')">
                                <a @click="resetPassword(record.id)">{{$t('user.action.resetPassword')}}</a>
                            </a-menu-item>
                            <!-- <a-menu-item v-if="canDo('users.resetPassword')">
                                <a @click="resetPassword(record.id)">{{$t('user.action.subsidiaryCompany')}}</a>
                            </a-menu-item> -->
                        </a-menu>
                    </a-dropdown>
                </template>
            </a-table>
            <!--<div class="userList_contentBottom" :style="{width:screenWidth+'px'}">-->
              <!--<a-form :form="searchForm">-->
                  <!--<a-form-item style="float: left">-->
                      <!--&lt;!&ndash; <a-button type="primary" class="marginLeft" @click="showAddModal" v-if="canDo('users.create')">{{this.$t('user.user.createUser')}}</a-button> &ndash;&gt;-->
                      <!--<a-button type="primary" class="marginLeft" :class="{btnOpacity:getSelectRows.length>0}" @click="showSetDepartmentModal(false)" v-if="canDo('users.departments.batchSetDefaultDepartment')">{{this.$t('user.user.setDefaultDepartment')}}</a-button>-->
                      <!--<a-button type="primary" class="marginLeft" :class="{btnOpacity:getSelectRows.length>0}" @click="showSetPositionModal(false)" v-if="canDo('users.positions.batchSetPosition')">{{this.$t('user.user.setPosition')}}</a-button>-->
                      <!--&lt;!&ndash; <a-button type="primary" class="marginLeft" :class="{btnOpacity:getSelectRows.length>0}" @click="showSetSubsidiaryCompany(false)" v-if="true">{{this.$t('user.user.subsidiaryCompany')}}</a-button> &ndash;&gt;-->
                      <!--<a-button type="primary" class="marginLeft" :class="{btnOpacity:getSelectRows.length>0}" @click="bindUsersTemplate" v-if="canDo('users.sidebars.bindSidebarTemplate')">{{this.$t('user.user.bindSide')}}</a-button>-->
                      <!--&lt;!&ndash; <a-button type="primary" class="marginLeft" @click="setHomePageModalShow" v-if="canDo('users.homepages.batchSetHomepage')">{{this.$t('user.user.subsystem')}}</a-button>-->
                      <!--<a-button type="primary" class="marginLeft" @click="forbidPageModalShow" v-if="canDo('users.sidebars.pages.forbid')">{{this.$t('user.user.subsystemForbid')}}</a-button> &ndash;&gt;-->
                  <!--</a-form-item>-->
              <!--</a-form>-->
            <!--</div>-->
        </a-card>
        <div class="userList_contentBottom" :style="{width:screenWidth+'px'}">
            <a-form :form="searchForm">
                <a-form-item style="float: left">
                    <!-- <a-button type="primary" class="marginLeft" @click="showAddModal" v-if="canDo('users.create')">{{this.$t('user.user.createUser')}}</a-button> -->
                    <a-button type="primary" class="marginLeft" :class="{btnOpacity:getSelectRows.length>0}" @click="showSetDepartmentModal(false)" v-if="canDo('users.departments.batchSetDefaultDepartment')">{{this.$t('user.user.setDefaultDepartment')}}</a-button>
                    <a-button type="primary" class="marginLeft" :class="{btnOpacity:getSelectRows.length>0}" @click="showSetPositionModal(false)" v-if="canDo('users.positions.batchSetPosition')">{{this.$t('user.user.setPosition')}}</a-button>
                    <!-- <a-button type="primary" class="marginLeft" :class="{btnOpacity:getSelectRows.length>0}" @click="showSetSubsidiaryCompany(false)" v-if="true">{{this.$t('user.user.subsidiaryCompany')}}</a-button> -->
                    <a-button type="primary" class="marginLeft" :class="{btnOpacity:getSelectRows.length>0}" @click="bindUsersTemplate" v-if="canDo('users.sidebars.bindSidebarTemplate')">{{this.$t('user.user.bindSide')}}</a-button>
                    <a-button type="primary" class="marginLeft" :class="{btnOpacity:getSelectRows.length>0}" @click="showSetUserRoleModal(true)" v-if="canDo('users.roles.attachRoles')">{{this.$t('user.user.bindRoles')}}</a-button>
                    <!-- <a-button type="primary" class="marginLeft" @click="setHomePageModalShow" v-if="canDo('users.homepages.batchSetHomepage')">{{this.$t('user.user.subsystem')}}</a-button>
                    <a-button type="primary" class="marginLeft" @click="forbidPageModalShow" v-if="canDo('users.sidebars.pages.forbid')">{{this.$t('user.user.subsystemForbid')}}</a-button> -->
                </a-form-item>
            </a-form>
        </div>
        <!-- 新增用户的模块框 -->
        <AddUserModal></AddUserModal>
        <!-- 设置默认部门的模态框 -->
        <SetDefaultDepartmentModal></SetDefaultDepartmentModal>
        <!-- 设置职称的模态框 -->
        <SetPositionModal></SetPositionModal>
        <!-- 设置用户信息的模态框 -->
        <updateUserModal></updateUserModal>
        <!-- 设置其他部门的模态框 -->
        <SetOtherDepartmentModal></SetOtherDepartmentModal>
        <!-- 批量绑定模板的模态框 -->
        <UsersBindTemplateModal></UsersBindTemplateModal>
        <!-- 批量禁用页面的模态框 -->
        <forBidUserPageModal></forBidUserPageModal>
        <!-- 批量设置首页的模态框 -->
        <setHomePageModal></setHomePageModal>
        <!-- 单个设置用户首页 -->
        <setUserHomePageModal></setUserHomePageModal>
        <!-- 设置用户角色 -->
        <setUserRoleModal></setUserRoleModal>
        <!-- 用户模板 -->
        <userSideModal></userSideModal>
        <!-- 重置密码 -->
        <ResetPassword></ResetPassword>
        <!-- 设置人员所属子公司 -->
        <!-- <SetSubsidiaryCompany></SetSubsidiaryCompany> -->
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import moment from 'moment'
import qs from 'qs'
import { getRoles } from '@/api/role'
import { getOptionsAll, getSubsidiaryCompanies, getUserExcel } from '../../../api/userManage'
import AddUserModal from './modals/addUserModal'
import SetDefaultDepartmentModal from './modals/setDefaultDepartmentModal'
import SetPositionModal from './modals/setPositionModal'
import updateUserModal from './modals/updateUserModal'
import SetOtherDepartmentModal from './modals/setOtherDepartmentModal'
import UsersBindTemplateModal from './modals/usersBindTemplate'
import forBidUserPageModal from './modals/UserForbidPagesModal'
import setHomePageModal from './modals/usersSetHomePageModal'
import { bus } from '../../../plugins/bus'
import { getAllDepartmentData } from '../../../api/department'
import setUserHomePageModal from './modals/setUserHomePage'
import setUserRoleModal from './modals/setUserRoleModal'
import userSideModal from './modals/userSideBarModal'
import { canDo } from '../../../plugins/common'
import _ from 'lodash'
import ResetPassword from './modals/resetPassword'
import Cookies from 'js-cookie'
// import SetSubsidiaryCompany from './modals/setSubsidiaryCompany'

export default {
  name: 'userList',
  components: {
    AddUserModal,
    SetDefaultDepartmentModal,
    SetPositionModal,
    updateUserModal,
    SetOtherDepartmentModal,
    UsersBindTemplateModal,
    forBidUserPageModal,
    setHomePageModal,
    setUserHomePageModal,
    setUserRoleModal,
    userSideModal,
    ResetPassword
    // SetSubsidiaryCompany
  },
  data () {
    return {
      excelRadio: 1,
      columns: [
        {
          title: () => this.$t('user.table.userName'),
          dataIndex: 'name',
          width: '10%'
        },
        {
          title: () => this.$t('user.table.email'),
          dataIndex: 'email',
          scopedSlots: { customRender: 'email' },
          width: '10%'
        },
        {
          title: () => this.$t('user.table.emailVerified'),
          dataIndex: 'email_verified_at',
          scopedSlots: { customRender: 'email_verified_at' },
          width: '10%'
        },
        {
          title: () => this.$t('user.table.defaultDepartment'),
          dataIndex: 'department',
          scopedSlots: { customRender: 'department' },
          width: '15%'
        },
        {
          title: () => this.$t('user.table.position'),
          dataIndex: 'position',
          scopedSlots: { customRender: 'positions' },
          width: '15%'
        },
        {
          title: () => this.$t('user.table.company'),
          dataIndex: 'company',
          scopedSlots: { customRender: 'company' },
          width: '20%'
        },
        {
          title: () => this.$t('user.table.updateTime'),
          dataIndex: 'updated_at',
          scopedSlots: { customRender: 'updateTime' },
          width: '10%'
        },
        {
          title: () => this.$t('user.table.action'),
          scopedSlots: { customRender: 'action' }
        }
      ],
      selectedRows: [],
      selectedRowKeys: [],
      searchForm: this.$form.createForm(this),
      companies: [],
      roles: [],
      screenWidth: this.$store.state.recount.pageWidth
    }
  },
  methods: {
    canDo,
    moment,
    handleExport () {
      let searchData = this.searchForm.getFieldsValue()
      let token = Cookies.get('token').replace('Bearer', '')

      let search = []
      if (searchData.name !== undefined) {
        if (searchData.name.indexOf(',') > -1) {
          search['name'] = searchData.name
        } else {
          if (searchData.name.substr(-1) === '%') {
            search['name'] = searchData.name
          } else {
            search['name'] = searchData.name + '%'
          }
        }
      }
      if (searchData.department !== undefined) {
        search['departments.id'] = _.join(searchData.department, ',')
      }
      if (searchData.position !== undefined) {
        search['positions.id'] = searchData.position
      }
      if (searchData.company_id !== undefined) {
        search['company_id'] = searchData.company_id
      }
      if (searchData.sidebarTemplates !== undefined) {
        search['sidebarTemplates.id'] = searchData.sidebarTemplates
      }
      if (searchData.roles !== undefined) {
        search['roles.id'] = searchData.roles
      }
      if (searchData.updated_date && searchData.updated_date.length) {
        search['updated_date'] = searchData.updated_date[0].format('YYYY/MM/DD') + ',' + searchData.updated_date[1].format('YYYY/MM/DD')
      }
      let params = { search }
      params.token = token
      params = qs.stringify(params)
      getUserExcel(params)
    },

    async handleTableChange (pagination) {
      await this.$store.dispatch('TableChange', pagination).catch(error => {
        this.$store.commit('SET_PAGE_LOADING', false)
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    async getUser () {
      await this.$store.dispatch('getUser').catch(error => {
        this.$store.commit('SET_PAGE_LOADING', false)
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    async deleteUser (id) {
      this.$store.commit('SET_PAGE_LOADING', true)
      await this.$store.dispatch('deleteUser', id).then(data => {
        if (data && data.status === 'success') {
          this.$message.success(this.$t('user.info.deleteUserSuccess'))
          this.$store.dispatch('getUser')
        } else {
          this.$message.error(this.$t('user.info.deleteUserError'))
        }
      }).catch(error => {
        this.$message.error(error.response.data.message || error.message)
      })
      this.$store.commit('SET_PAGE_LOADING', false)
    },
    // 多选用户
    onSelectChange (selectedRowKeys, selectedRows) {
      // this.selectedRows = selectedRows
      this.$store.commit('SET_SELECT_ROWS', selectedRowKeys)
    },
    // 获取部门树状结构
    getDepartments () {
      getAllDepartmentData().then(data => {
        if (data.status === 'success') {
          let departments = data.data.departments
          let child = []
          for (let i in departments) {
            let parent = departments[i]['parent_id']
            let id = departments[i]['id']
            if (child[id] === undefined) {
              child[id] = []
            }
            if (child[parent] === undefined) {
              child[parent] = []
            }
            let params = {
              key: id,
              value: id.toString(),
              title: () => JSON.parse(departments[i]['locale'])[this.getLanguage],
              parent_id: parent,
              children: child[id]
            }
            child[parent].push(params)
          }
          this.$store.commit('SET_DEPART_TREE', child[0])
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    // 获取子公司
    getCompanies () {
      getSubsidiaryCompanies().then(res => {
        if (res.data && res.data.length) {
          let data = res.data
          let allSelect = { // 下拉中添加全部
            id: '',
            company_name: this.$t('user.user.all')
          }
          data.unshift(allSelect)
          this.companies = data.filter((item) => {
            return item.id !== 9
          })
          this.$store.commit('SET_SBUSIDIARY_COMPANIES', this.companies)
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    // 获取所有职称
    getPosition () {
      let params = {
        is_system: 1
      }
      getOptionsAll(params).then(data => {
        if (data.status === 'success') {
          this.$store.commit('SET_OPTIONS_ALL', data.data.positions)
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    async searchData () {
      let searchData = this.searchForm.getFieldsValue()
      let filter = []
      if (searchData.name !== undefined) {
        if (searchData.name.indexOf(',') > -1) {
          filter['name'] = searchData.name
        } else {
          if (searchData.name.substr(-1) === '%') {
            filter['name'] = searchData.name
          } else {
            filter['name'] = searchData.name + '%'
          }
        }
      }
      if (searchData.department !== undefined) {
        filter['departments.id'] = _.join(searchData.department, ',')
      }
      if (searchData.position !== undefined) {
        filter['positions.id'] = searchData.position
      }
      if (searchData.company_id !== undefined) {
        filter['company_id'] = searchData.company_id
      }
      if (searchData.sidebarTemplates !== undefined) {
        filter['sidebarTemplates.id'] = searchData.sidebarTemplates
      }
      if (searchData.roles !== undefined) {
        filter['roles.id'] = searchData.roles
      }
      if (searchData.updated_date && searchData.updated_date.length) {
        filter['updated_date'] = searchData.updated_date[0].format('YYYY/MM/DD') + ',' + searchData.updated_date[1].format('YYYY/MM/DD')
      }
      await this.$store.commit('SET_USER_FILTERS', filter)
      this.getUser()
    },
    showAddModal () {
      bus.$emit('restAddUserModal')
    },
    showSetDepartmentModal (record) {
      if (!record) {
        if (this.getSelectRows.length === 0) {
          this.$message.error(this.$t('user.info.mustChooseUser'))
          return false
        } else {
          this.$store.commit('SET_IS_GROUP_SET', true)
          bus.$emit('showDepartmentModal')
        }
      } else {
        this.$store.commit('SET_IS_GROUP_SET', false)
        this.$store.commit('SET_CURRENT_USER', record)
        bus.$emit('showDepartmentModal')
      }
    },
    showSetSubsidiaryCompany (record) {
      if (!record) {
        if (this.getSelectRows.length === 0) {
          this.$message.error(this.$t('user.info.mustChooseUser'))
          return false
        } else {
          this.$store.commit('SET_IS_GROUP_SET', true)
          bus.$emit('showSubsidiaryCompany')
        }
      } else {
        this.$store.commit('SET_IS_GROUP_SET', false)
        this.$store.commit('SET_CURRENT_USER', record)
        bus.$emit('showSubsidiaryCompany')
      }
    },
    showSetPositionModal (record) {
      if (!record) {
        if (this.getSelectRows.length === 0) {
          this.$message.error(this.$t('user.info.mustChooseUser'))
          return false
        } else {
          this.$store.commit('SET_IS_GROUP_SET', true)
          bus.$emit('showPositionModal', true)
        }
      } else {
        this.$store.commit('SET_IS_GROUP_SET', false)
        this.$store.commit('SET_CURRENT_USER', record)
        bus.$emit('showPositionModal')
      }
    },
    async updateUser (record) {
      await this.$store.commit('SET_CURRENT_USER', record)
      bus.$emit('showUpdateInfoModal', false)
    },
    updateUserPermission (id) {
      this.$router.push({
        name: 'userPermissions',
        params: {
          id
        }
      })
    },
    getAllSubs () {
      this.$store.dispatch('fetchAllSubs').catch(error => {
        this.$message.error(error.response.data.message || error.message)
      })
    },
    getAllAdminLevel () {
      this.$store.dispatch('fetchAllAdminLevel').catch(error => {
        this.$message.error(error.response.data.message || error.message)
      })
    },
    showSetOtherDepartmentModal (record) {
      this.$store.commit('SET_CURRENT_USER', record)
      bus.$emit('showOtherDepartmentModal')
    },
    bindUsersTemplate () {
      if (this.getSelectRows.length === 0) {
        this.$message.error(this.$t('user.info.mustChooseUser'))
        return false
      } else {
        bus.$emit('showBindUsersTemplate')
      }
    },
    setHomePageModalShow () {
      if (this.getSelectRows.length === 0) {
        this.$message.error(this.$t('user.info.mustChooseUser'))
        return false
      } else {
        bus.$emit('showSetUsersHomePage')
      }
    },
    forbidPageModalShow () {
      if (this.getSelectRows.length === 0) {
        this.$message.error(this.$t('user.info.mustChooseUser'))
        return false
      } else {
        bus.$emit('showForbidUsersPage')
      }
    },
    showSetHomePageModal (id) {
      bus.$emit('showSetUserHomePageModal', id)
    },
    showSetUserRoleModal (batch, id) {
      if (batch === true && this.getSelectRows.length === 0) {
        this.$message.error(this.$t('user.info.mustChooseUser'))
        return false
      }
      bus.$emit('showSetRolesModal', id, batch)
    },
    showUserSideModal (id) {
      bus.$emit('showUserTemplate', id)
    },
    resetPassword (id) {
      bus.$emit('showRestPasswordModal', id)
    }
  },
  computed: {
    ...mapGetters(['getPagination', 'getUserList', 'getDepartmentTree', 'getAllOptions', 'getPageLoading', 'getSelectRows', 'getLanguage', 'getTemplatesData'])
  },
  created () {
    this.$store.commit('SET_USER_FILTERS', {})
    this.getUser()
    this.getDepartments()
    this.getPosition()
    this.getAllSubs()
    this.getAllAdminLevel()
    this.getCompanies()
    getRoles().then(data => {
      this.roles = data.data.data
    }).catch(error => {
      this.$message.error(error.response.data.message || error.message)
    })
    this.$store.dispatch('fetchTemplate', {}).catch(error => {
      this.$message.error(error.response ? error.response.data.message : error.message)
      this.$store.commit('SET_TEMPLATE_PAGE_LOADING', false)
    })
  },
  watch: {
    '$store.state.recount.pageWidth' (newVal) {
      this.screenWidth = newVal
    }
  }
}
</script>

<style scoped>
    .select-options{
        margin-bottom: 10px;
    }
    .marginLeft{
        margin-left: 15px;
    }

</style>

<style lang="less" scoped>
.export-ok{
    text-align: right;
    padding: 20px 10px;
    width: 280px;
}
.export-p{
    color: #378eef;
    padding-top: 10px;
    height: 25px;
    cursor: pointer;
}
.userList-department{
  height: 34px;

  .ant-select-selection {
    max-height: 34px;
    overflow-y: auto;
  }

  .ant-select-selection__clear {
    right: 20px;
  }

  .ant-select-search__field__placeholder {
    font-size: 12px;
  }
    .userList_contentBottom{
        position: fixed;
        bottom: 1px;
        left:auto !important;
    }
}
</style>
