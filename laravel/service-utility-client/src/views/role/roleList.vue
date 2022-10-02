<template>
  <div class="role-list-wrap">
    <a-card class="role-card">
      <div class="role-list-top">
        <div class="role-top-title">{{ $t("role.list.roleManage") }}</div>
        <div class="role-top-btn">
          <div class="role-list-export" @click="exportFn">
            <i class="icon iconfont">&#xe65a;</i>
            <span class="export-btn">{{ $t("role.list.export") }}</span>
          </div>
          <a-button
            type="primary"
            class="marginLeft"
            @click="showAddModal"
            v-if="canDo('permissions.roles.store')"
          >
            <a-icon type="plus" />{{ $t("role.list.addRole") }}
          </a-button>
        </div>
      </div>
      <div class="role-list-content">
        <div class="role-side-box">
          <a-form layout="inline" :form="searchForm" class="side-search-wrap">
            <a-form-item>
              <SelectSubs
                style="width: 120px"
              ></SelectSubs>
              <a-input-search
                placeholder="请输入角色名搜索"
                style="width: 200px"
                v-decorator="['name']"
                @search="searchData"
              />
            </a-form-item>
          </a-form>
          <div class="role-admin-box">
            <div
              :class="[{ actived: itId == k.id }]"
              v-for="(k, index) in getRoleListData"
              :key="index"
              @click="permissionFn(k)">
                <div class="role-admin-list">
                  <div class="role-info">
                    <span v-show="itId == k.id" class="line"></span>
                    <a-popover>
                      <span class="role-name">{{ k.name }}</span>
                      <div class="role-detail"  slot="content">
                        <p><span class="label-txt">{{ $t("role.list.roleName") }}:</span><span>{{ k.name }}</span></p>
                        <p><span class="label-txt">{{ $t("role.list.belongTo") }}:</span><span>{{ k.guard_name }}</span></p>
                        <p><span class="label-txt">{{ $t("role.list.remark") }}:</span><span>{{ k.comment }}</span></p>
                        <p><span class="label-txt" >{{ $t("role.list.createTime") }}:</span><span>{{ k.created_at }}</span></p>
                      </div>
                    </a-popover>
                  </div>
                  <div class="role-opretion">
                    <i class="iconfont icon-size" title="更新角色"  @click="edit(k)" v-if="canDo('permissions.roles.update')">&#xe645;</i>
                    <i class="icon iconfont icon-size" title="删除" @click="deleteRole(k.id)" v-if="canDo('permissions.roles.delete')">&#58957;</i>
                  </div>
                </div>

            </div>
            <div v-if="getRoleListData.length <= 0">暂无数据</div>
          </div>
        </div>
        <div class="role-center-box">
          <div
            class=""
            style="height: 100%; width: 100%"
            v-if="canDo('permissions.roles.getPermissions')">
            <a-tabs default-active-key="1" @change="callback">
              <a-tab-pane key="1" tab="功能权限">
                <RoleTree :itId.sync="itId" ref="treeUpdate" @activeFn='activeFn'></RoleTree>
              </a-tab-pane>
              <a-tab-pane key="2" tab="绑定人员">
                <BindList :itId.sync="itId" ref="bindUpdate" @bindOption="bindOption"></BindList>
              </a-tab-pane>
              <a-tab-pane key="3" tab="操作记录">
                <Record :itId.sync="itId" ref="recordUpdate" @logOption="logOption"></Record>
              </a-tab-pane>
            </a-tabs>
          </div>
          <div v-else>暂无权限</div>
        </div>
      </div>
      <!-- 删除角色modal  -->
      <delRoleModal @delHandel="delHandel"></delRoleModal>
      <!-- 新增角色modal  -->
      <addRoleModal></addRoleModal>
      <!-- 更新信息modal  -->
      <updateRoleModal></updateRoleModal>
    </a-card>
    <a-card class="role-list-bottom">
      <template v-if="index == 1">
        <a-button type="primary" class="marginLeft" @click="updatePermission">
          {{ $t("role.action.update") }}
        </a-button>
      </template>
      <template v-if="index == 2">
        <div class="page-size-box">
          <a-pagination
            v-model="current"
            :page-size-options="pageSizeOptions"
            :total="bindTotal"
            show-size-changer
            :page-size="pageSize"
            @change="changePage"
            @showSizeChange="onShowSizeChange">
            <template slot="buildOptionText" slot-scope="props">
              <span v-if="props.value !== '50'">{{ props.value }}条/页</span>
              <span v-if="props.value === '50'">全部</span>
            </template>
          </a-pagination>
        </div>
      </template>
      <template v-if="index == 3">
        <div class="page-size-box">
          <a-pagination
            v-model="current"
            :page-size-options="pageSizeOptions"
            :total="logTotal"
            show-size-changer
            :page-size="pageSize"
            @change="changePage"
            @showSizeChange="onShowSizeChange">
            <template slot="buildOptionText" slot-scope="props">
              <span v-if="props.value !== '50'">{{ props.value }}条/页</span>
              <span v-if="props.value === '50'">全部</span>
            </template>
          </a-pagination>
        </div>
      </template>
    </a-card>
  </div>
</template>

<script>
import RoleTree from './modals/permissionTree'
import BindList from './modals/bindList'
import Record from './modals/recordList'
import { languages } from '../../plugins/lang'
import { mapGetters } from 'vuex'
import { bus } from '../../plugins/bus'
import delRoleModal from './modals/delModal'
import addRoleModal from './modals/addRoleModal'
import updateRoleModal from './modals/updateRoleModal'
import { getRoleExcel, delRoles } from '../../api/role'
import SelectSubs from '../../components/SubsSelect'
import { canDo } from '../../plugins/common'
import qs from 'qs'
import Cookies from 'js-cookie'
export default {
  name: 'roleList',
  data () {
    return {
      itId: undefined,
      delId: undefined,
      index: '1',
      pageSizeOptions: ['20'],
      current: 1,
      pageSize: 20,
      bindTotal: 0,
      logTotal: 0,
      languages: languages,
      searchForm: this.$form.createForm(this)
    }
  },
  components: {
    delRoleModal,
    RoleTree,
    BindList,
    Record,
    addRoleModal,
    updateRoleModal,
    SelectSubs
  },
  computed: {
    ...mapGetters(['getRoleListData', 'getLanguage', 'getCurrentSub'])
  },
  created () {
    this.$store.commit('SET_ROLE_LIST_FILTERS', {})
  },
  mounted () {

  },
  methods: {
    exportFn () {
      let params = {}
      params.guard_name = this.getCurrentSub
      params.token = Cookies.get('token').replace('Bearer', '')
      params = qs.stringify(params)
      getRoleExcel(params)
    },
    activeFn (id) {
      this.itId = id
    },
    bindOption (option) {
      this.bindTotal = option
    },
    logOption (option) {
      this.logTotal = option
    },
    permissionFn (data) {
      this.itId = data.id
      this.current = 1
    },
    callback (activeKey) {
      this.index = activeKey
    },
    changePage (page, pageSize) {
      switch (this.index) {
        case '2':
          this.$refs.bindUpdate.getChildData(this.itId, page)
          break
        case '3':
          this.$refs.recordUpdate.getRecordData(this.itId, page)
          break
        default:
      }
    },
    onShowSizeChange (current, pageSize) {

    },
    updatePermission () {
      this.$refs.treeUpdate.updateRolePermission()
    },
    edit (record) {
      this.$store.commit('SET_CURRENT_ROLE_DATA', record)
      bus.$emit('showUpdateRoleModal')
    },
    async searchData () {
      let param = {}
      let searchData = this.searchForm.getFieldsValue()
      if (searchData.name !== undefined) {
        param.name = '%' + searchData.name + '%'
      }
      await this.$store.commit('SET_ROLE_LIST_FILTERS', param)
      this.$store.dispatch('fetchRolesList', { current: 1 })
    },
    showAddModal () {
      bus.$emit('showAddRoleModal')
    },
    deleteRole (id) {
      bus.$emit('showDelModal')
      this.delId = id
    },
    delHandel () {
      delRoles({
        id: this.delId
      })
        .then((data) => {
          if (data.status === 'success') {
            this.$message.success('删除角色成功')
            this.$store.dispatch('fetchRolesList')
          } else {
            this.$message.error('删除角色失败')
          }
        })
        .catch((error) => {
          this.$message.error(
            error.response ? error.response.data.message : error.message
          )
        })
    },
    canDo
  }
}
</script>
<style scoped lang="less">
.role-list-wrap {
  .role-list-top {
    display: flex;
    justify-content: space-between;
    padding-bottom: 10px;
    border-bottom: 1px solid #eeeeee;
    .role-top-title {
      font-size: 16px;
      font-weight: bold;
      color: #333333;
    }
    .role-top-btn {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      .role-list-export {
        cursor: pointer;
        color: #378eef;
        .icon {
          font-size: 12px;
        }
        .export-btn {
          padding: 0 20px 0 4px;
        }
      }
    }
  }
  .role-list-content {
    display: flex;
    justify-content: flex-start;
    .role-side-box {
      width: 370px;
      height: 602px;
      overflow-y: auto;
      border-right: 1px solid#eeeeee;
      .actived {
        background-color: #ebf3ff;
        border-radius: 5px;
        color: #378eef;
      }
      .role-admin-list {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 330px;
        height: 40px;
        line-height: 40px;
        font-size: 12px;
        color: #6666666;
        .role-info {
          display: flex;
          justify-content: space-between;
          align-items: center;
          .line {
            width: 3px;
            height: 16px;
            background: #378eef;
          }
          .role-name {
            margin-left: 20px;
          }
        }
        .role-opretion {
          display: none;
          .icon-size{
            font-size: 12px;
            color: #378eef;
          }
          .iconfont {
            cursor: pointer;
          }
          .icon {
            margin: 0 20px;
          }
        }
        &:hover{
          .role-opretion{
            display: block;
          }
        }
      }
    }
    .role-center-box {
      overflow-y: auto;
      position: relative;
      width: calc(100% - 20px);
      height: 602px;
      margin: 10px 0 0 20px;
      padding-bottom: 20px;
    }
  }
  .role-list-bottom {
    position: fixed;
    bottom: 0;
    margin: 20px 0 0 0;
    width: calc(100% - 15px);
    .page-size-box {
      display: flex;
      justify-content: flex-end;
    }
  }
}
</style>
<style lang="less">
.role-list-wrap {
  .side-search-wrap {
    .ant-form-item-children {
      display: flex;
      justify-content: space-between;
      margin: 20px 0 20px 0;
      .ant-input-affix-wrapper {
        margin-left: 10px !important;
      }
    }
  }
  .ant-table-column-title {
    padding-left: 20px !important;
  }
  .ant-table-tbody {
    td {
      padding-left: 20px !important;
    }
  }
  .role-card .ant-card-body {
    padding-bottom: 0;
  }
}
.ant-popover-inner-content {
  padding: 10px;
}
.role-detail {
  font-size: 12px;
  .label-txt {
    color: #999 !important;
    padding-right: 5px;
  }
}
/* .content {
        margin-top: 10px;
    }
    .localeSpan {
        margin: 5px;
    } */
</style>
