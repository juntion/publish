<template>
    <a-card>
        <a-form layout="inline" :form="searchForm">
            <a-form-item
                    style="width: 180px">
                <a-input
                        :placeholder="$t('user.modal.permissionName')"
                        allowClear
                        v-decorator="['name']"/>
            </a-form-item>
            <a-form-item>
                <a-select
                        style="width: 110px"
                        :placeholder="$t('user.modal.sub')"
                        showSearch
                        v-decorator="['subsystem']"
                >
                    <a-select-option
                            v-for="(item, key) in subsystems"
                            :key="key"
                            :value="item.guard_name">
                        {{JSON.parse(item.locale)[getLanguage]}}
                    </a-select-option>
                </a-select>
            </a-form-item>
            <a-form-item>
                <a-button type="primary" icon="search" @click="searchData"></a-button>
            </a-form-item>
            <a-form-item style="float: right">
                <a-button type="primary" :loading="rolePermissionLoading" class="marginLeft" @click="updateUserPermission">{{$t('user.modal.updateUserPermission')}}</a-button>
            </a-form-item>
        </a-form>
        <a-table
                 class="content"
                 :columns="Columns"
                 :dataSource="PermissionListData"
                 :pagination="PermissionPagePagination"
                 :loading="PermissionPageLoading"
                 @change="handleTableChange"
                 rowKey="id"
                 :rowSelection="{selectedRowKeys: PermissionRows, onChange: onSelectChange}"
        >
            <template slot-scope="text, record" slot="locale">
                <span>{{JSON.parse(record.locale)[getLanguage]}}</span>
            </template>
        </a-table>
    </a-card>
</template>

<script>
import { mapGetters } from 'vuex'
import { getSubSystemsData } from '../../../api/subsystem'
import { getPermission } from '../../../api/role'
import { getUserSubsPermission, updateUserPermission } from '../../../api/userManage'

export default {
  name: 'userPermission',
  data () {
    return {
      searchForm: this.$form.createForm(this),
      rolePermissionLoading: false,
      Columns: [
        {
          title: () => this.$t('user.modal.permissionName'),
          dataIndex: 'name',
          width: '20%',
          scopedSlots: { customRender: 'locale' }
        },
        {
          title: () => this.$t('user.modal.guard'),
          dataIndex: 'guard_name',
          width: '25%'
        },
        {
          title: () => this.$t('user.modal.comment'),
          dataIndex: 'comment',
          width: '25%'
        },
        {
          title: () => this.$t('user.modal.created_at'),
          dataIndex: 'created_at',
          width: '20%'
        }
      ],
      PermissionListData: [],
      PermissionPagePagination: {
        total: 0,
        showSizeChanger: true,
        current: 1,
        pageSize: 20,
        pageSizeOptions: ['20', '50', '100']
      },
      PermissionPageLoading: false,
      PermissionRows: [],
      subsystems: [],
      filters: {}
    }
  },
  methods: {
    onSelectChange (selectedRowKeys, selectedRows) {
      this.PermissionRows = selectedRowKeys
    },
    searchData () {
      let param = {
      }
      let searchData = this.searchForm.getFieldsValue()
      if (searchData.name !== undefined) {
        param.name = '%' + searchData.name + '%'
      }
      this.filters = param
      this.filters.guard_name = searchData['system']
      this.getAllPermissions({})
      this.getUserPermissions()
    },
    updateUserPermission () {
      this.rolePermissionLoading = true
      let params = {
        id: this.$route.params.id,
        permission_ids: this.PermissionRows
      }
      updateUserPermission(params).then(data => {
        this.rolePermissionLoading = false
        if (data.status === 'success') {
          this.$message.success(this.$t('user.modal.updatePermissionSuccess'))
          this.getUserPermissions()
        } else {
          this.$message.error(this.$t('user.modal.updatePermissionError'))
        }
      }).catch(error => {
        this.rolePermissionLoading = false
        this.$message.error(error.response.data.message || error.message)
      })
    },
    handleTableChange (pageInfo) {
      let params = {
        page: pageInfo.current,
        limit: pageInfo.pageSize
      }
      this.getAllPermissions(params)
    },
    getAllSubs () {
      getSubSystemsData().then(data => {
        this.subsystems = data.data.subsystems
        this.searchForm.setFieldsValue({
          subsystem: this.subsystems[0]['guard_name']
        })
        this.filters.guard_name = this.subsystems[0]['guard_name']
        this.getAllPermissions({})
        this.getUserPermissions()
      }).catch(error => {
        this.$message.error(error.response.data.message || error.message)
      })
    },
    getAllPermissions (params) {
      this.PermissionPageLoading = true
      params.filters = this.filters
      getPermission(params).then(data => {
        this.PermissionListData = data.data.data
        this.PermissionPagePagination.current = data.data.current_page
        this.PermissionPagePagination.pageSize = Number(data.data.per_page)
        this.PermissionPagePagination.total = data.data.total
        this.PermissionPageLoading = false
      }).catch(error => {
        this.$message.error(error.response.data.message || error.message)
        this.PermissionPageLoading = false
      })
    },
    getUserPermissions () {
      let params = {
        id: this.$route.params.id,
        guard_name: this.searchForm.getFieldValue('subsystem')
      }
      getUserSubsPermission(params).then(data => {
        let permission = []
        for (let i = 0; i < data.data.permissions.length; i++) {
          permission.push(data.data.permissions[i]['id'])
        }
        this.PermissionRows = permission
      }).catch(error => {
        this.$message.error(error.response.data.message || error.message)
      })
    }
  },
  computed: {
    ...mapGetters(['getLanguage'])
  },
  async created () {
    this.getAllSubs()
  }
}
</script>

<style scoped>
    .content{
        margin-top: 10px;
    }
</style>
