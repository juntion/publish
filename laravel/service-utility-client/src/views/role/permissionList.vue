<template>
  <a-card>
    <a-form layout="inline"
            :form="searchForm">
      <a-form-item style="width: 180px">
        <a-input :placeholder="$t('role.permission.inputPermission')"
                 allowClear
                 v-decorator="['name']" />
      </a-form-item>
      <a-form-item>
        <SelectSubs></SelectSubs>
      </a-form-item>
      <a-form-item>
        <a-button type="primary"
                  icon="search"
                  @click="searchData"></a-button>
      </a-form-item>
      <a-form-item style="float: right"
                   v-if="isUpdateRolePermission && canDo('permissions.roles.givePermissions')">
        <a-button type="primary"
                  :loading="rolePermissionLoading"
                  class="marginLeft"
                  @click="updateRolePermission">{{$t('role.permission.updateRolePermission')}}</a-button>
      </a-form-item>
    </a-form>
    <a-table v-if="isUpdateRolePermission"
             class="content"
             :columns="updateColumns"
             :dataSource="getPermissionListData"
             :pagination="getPermissionPagePagination"
             :loading="getPermissionPageLoading"
             @change="handleTableChange"
             rowKey="id"
             :rowSelection="{selectedRowKeys: PermissionRows, onChange: onSelectChange}">
      <template slot-scope="text, record"
                slot="guardName">
        <span>{{JSON.parse(getGuardToSubs[record.guard_name])[getLanguage]}}</span>
      </template>
      <template slot-scope="text, record"
                slot="locale">
        <span>{{JSON.parse(record.locale)[getLanguage]}}</span>
      </template>
    </a-table>
    <a-table v-else
             class="content"
             :columns="columns"
             :dataSource="getPermissionListData"
             :pagination="getPermissionPagePagination"
             :loading="getPermissionPageLoading"
             @change="handleTableChange"
             rowKey="id">
      <template slot-scope="text, record"
                slot="guardName">
        <span>{{JSON.parse(getGuardToSubs[record.guard_name])[getLanguage]}}</span>
      </template>
      <template slot-scope="text, record"
                slot="locale">
        <span>{{JSON.parse(record.locale)[getLanguage]}}</span>
      </template>
      <template slot-scope="text, record"
                slot="action">
        <a @click="edit(record)"
           v-if="canDo('permissions.update')">{{$t('role.permission.update')}}</a>
      </template>
    </a-table>
    <!-- 更新权限信息 -->
    <updatePermissionModal></updatePermissionModal>
  </a-card>
</template>

<script>
import { languages } from '../../plugins/lang'
import { mapGetters } from 'vuex'
import { bus } from '../../plugins/bus'
import updatePermissionModal from './modals/updatePermissionModal'
import { getRolePermission, updateRolePermission } from '../../api/role'
import SelectSubs from '../../components/SubsSelect'
import { canDo } from '../../plugins/common'

export default {
  name: 'permissionList',
  components: { updatePermissionModal, SelectSubs },
  data () {
    return {
      columns: [
        {
          title: () => this.$t('role.permission.permissionName'),
          dataIndex: 'name',
          scopedSlots: { customRender: 'locale' },
          width: '15%'
        },
        {
          title: () => this.$t('common.guard'),
          dataIndex: 'guard_name',
          scopedSlots: { customRender: 'guardName' },
          width: '15%'
        },
        {
          title: () => this.$t('common.comment'),
          dataIndex: 'comment',
          width: '20%'
        },
        {
          title: () => this.$t('role.permission.created_at'),
          dataIndex: 'created_at',
          width: '25%'
        },
        {
          title: () => this.$t('common.action'),
          dataIndex: 'action',
          scopedSlots: { customRender: 'action' }
        }
      ],
      updateColumns: [
        {
          title: () => this.$t('role.permission.permissionName'),
          dataIndex: 'name',
          scopedSlots: { customRender: 'locale' },
          width: '15%'
        },
        {
          title: () => this.$t('common.guard'),
          dataIndex: 'guard_name',
          scopedSlots: { customRender: 'guardName' },
          width: '25%'
        },
        {
          title: () => this.$t('common.comment'),
          dataIndex: 'comment',
          width: '20%'
        },
        {
          title: () => this.$t('role.permission.created_at'),
          dataIndex: 'created_at',
          width: '25%'
        }
      ],
      languages: languages,
      searchForm: this.$form.createForm(this),
      isUpdateRolePermission: false,
      PermissionRows: [],
      oldPermissionRow: [],
      rolePermissionLoading: false
    }
  },
  methods: {
    handleTableChange (pagination) {
      this.$store.dispatch('fetchPermissionsList', pagination)
    },
    getIndexData () {
      this.$store.dispatch('fetchPermissionsList')
    },
    edit (record) {
      this.$store.commit('SET_CURRENT_PERMISSION_DATA', record)
      bus.$emit('showUpdatePermissionModal')
    },
    async searchData () {
      let param = {
      }
      let searchData = this.searchForm.getFieldsValue()
      if (searchData.name !== undefined) {
        param.name = '%' + searchData.name + '%'
      }
      await this.$store.commit('SET_PERMISSION_LIST_FILTERS', param)
      this.$store.dispatch('fetchPermissionsList', { current: 1 })
    },
    onSelectChange (selectedRowKeys, selectedRows) {
      this.PermissionRows = selectedRowKeys
    },
    updateRolePermission () {
      if (this.PermissionRows.length < 1) {
        this.$message.error(this.$t('role.permission.choose'))
        return false
      }
      this.rolePermissionLoading = true
      let params = {
        id: this.$route.params.id,
        permission_ids: this.PermissionRows
      }
      updateRolePermission(params).then(data => {
        this.rolePermissionLoading = false
        if (data.status === 'success') {
          this.$message.success(this.$t('role.permission.updateRolePermissionSuccess'))
          this.oldPermissionRow = this.PermissionRows
        } else {
          this.$message.error(this.$t('role.permission.updateRolePermissionError'))
          this.PermissionRows = this.oldPermissionRow
        }
      }).catch(error => {
        this.rolePermissionLoading = false
        this.PermissionRows = this.oldPermissionRow
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    setIsRolePermission () {
      let roleId = this.$route.params.id
      if (roleId !== undefined) {
        this.isUpdateRolePermission = true
        let params = {
          id: roleId
        }
        this.getRolePermissions(params)
      } else {
        this.isUpdateRolePermission = false
      }
    },
    getRolePermissions (params) {
      getRolePermission(params).then(data => {
        if (data.status === 'success') {
          this.PermissionRows = data.data
          this.oldPermissionRow = data.data
        } else {
          this.$message.error('获取角色权限失败')
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    canDo
  },
  computed: {
    ...mapGetters(['getPermissionListData', 'getPermissionPagePagination', 'getPermissionPageLoading', 'getSubsData', 'getLanguage', 'getGuardToSubs'])
  },
  created () {
    this.isUpdateRolePermission = false
    this.$store.commit('SET_PERMISSION_LIST_FILTERS', {})
    this.getIndexData()
    this.setIsRolePermission()
  },
  watch: {
    $route () {
      this.setIsRolePermission()
    }
  }
}
</script>

<style scoped>
.content {
  margin-top: 10px;
}
.localeSpan {
  margin: 5px;
}
</style>
