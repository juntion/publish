<template>
    <a-card>
        <a-tabs defaultActiveKey="1">
            <a-tab-pane :tab="$t('subsystem.list.disabledUser')" key="1">
                <div class="select-options">
                    <a-form layout="inline" :form="searchForm">
                        <a-form-item
                                style="width: 180px">
                            <a-input
                                    :placeholder="$t('subsystem.list.inputName')"
                                    allowClear
                                    v-decorator="['name']"/>
                        </a-form-item>
                        <a-form-item>
                            <a-button type="primary" icon="search" @click="searchData"></a-button>
                        </a-form-item>
                        <a-form-item style="float: right" v-if="canDo('subsystems.removeForbidUsers')">
                            <a-button
                                    class="marginRight10 floatRight"
                                    type="primary"
                                    icon="usergroup-delete"
                                    @click="showAddModal"
                                    :loading="delForbidBtnLoading"
                            >
                                {{$t('subsystem.list.removeDisabled')}}
                            </a-button>
                        </a-form-item>
                    </a-form>
                </div>
                <a-table
                        class="content"
                        :columns="columns"
                        :dataSource="getSubSystemForbidUserList"
                        :loading="getSystemForbidLoading"
                        rowKey="id"
                        :pagination="false"
                        :rowSelection="{selectedRowKeys: forbidSelectRows, onChange: onSelectChange}"
                >
                </a-table>
            </a-tab-pane>
            <a-tab-pane :tab="$t('subsystem.list.availableUsers')" key="2" >
                <div class="select-options">
                    <a-form layout="inline" :form="allowSearchForm">
                        <a-form-item
                                style="width: 180px">
                            <a-input
                                    :placeholder="$t('subsystem.list.inputName')"
                                    allowClear
                                    v-decorator="['name']"/>
                        </a-form-item>
                        <a-form-item>
                            <a-button type="primary" icon="search" @click="searchAllowData"></a-button>
                        </a-form-item>
                        <a-form-item style="float: right" v-if="canDo('subsystems.addForbidUsers')">
                            <a-button
                                    type="primary"
                                    icon="usergroup-add"
                                    @click="addForbidUsers"
                                    :loading="addForbidBtnLoading"
                            >
                                {{$t('subsystem.list.addDisabled')}}
                            </a-button>
                        </a-form-item>
                    </a-form>
                </div>
                <a-table
                        class="content"
                        :columns="columns"
                        :dataSource="getSubSystemAllowUserList"
                        :loading="getSystemAllowLoading"
                        rowKey="id"
                        :pagination="getSubSystemAllowPagination"
                        :rowSelection="{selectedRowKeys: allowSelectRows, onChange: onAllowSelectChange}"
                        @change="handleTableChange"
                >
                </a-table>
            </a-tab-pane>
        </a-tabs>
    </a-card>
</template>

<script>
import { mapGetters } from 'vuex'
import { addSubSystemForbidUsers, delSubSystemForbidUsers } from '../../api/subsystem'
import { canDo } from '../../plugins/common'

export default {
  name: 'forbidUsers',
  data () {
    return {
      columns: [
        {
          title: () => this.$t('subsystem.table.userName'),
          dataIndex: 'name'
        },
        {
          title: () => this.$t('subsystem.table.email'),
          dataIndex: 'email'
        },
        {
          title: () => this.$t('subsystem.table.emailVerified'),
          dataIndex: 'email_verified_at'
        }
      ],
      forbidSelectRows: [],
      allowSelectRows: [],
      delForbidBtnLoading: false,
      addForbidBtnLoading: false,
      searchForm: this.$form.createForm(this),
      allowSearchForm: this.$form.createForm(this)
    }
  },
  methods: {
    canDo,
    getUserList () {
      let id = this.$route.params.id
      this.forbidSelectRows = this.allowSelectRows = []
      this.$store.dispatch('fetchForbidUserList', { id })
      this.$store.dispatch('fetchAllowUserList', { id })
    },
    showAddModal () {
      if (this.forbidSelectRows.length === 0) {
        this.$message.error(this.$t('subsystem.notify.choose'))
        return false
      }
      this.delForbidBtnLoading = true
      let params = {
        id: this.$route.params.id,
        user_ids: this.forbidSelectRows
      }
      delSubSystemForbidUsers(params).then(data => {
        this.delForbidBtnLoading = false
        if (data.status === 'success') {
          this.$message.success(this.$t('subsystem.notify.removeDisabledSuccess'))
          this.delForbidBtnLoading = false
          this.getUserList()
        } else {
          this.$message.error(this.$t('subsystem.notify.removeDisabledError'))
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
        this.delForbidBtnLoading = false
      })
    },
    addForbidUsers () {
      if (this.allowSelectRows.length === 0) {
        this.$message.error(this.$t('subsystem.notify.choose'))
        return false
      }
      this.addForbidBtnLoading = true
      let params = {
        id: this.$route.params.id,
        user_ids: this.allowSelectRows
      }
      addSubSystemForbidUsers(params).then(data => {
        this.addForbidBtnLoading = false
        if (data.status === 'success') {
          this.$message.success(this.$t('subsystem.notify.addDisabledSuccess'))
          this.addForbidBtnLoading = false
          this.getUserList()
        } else {
          this.$message.error(this.$t('subsystem.notify.addDisabledError'))
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
        this.addForbidBtnLoading = false
      })
    },
    onSelectChange (selectedRowKeys, selectedRows) {
      this.forbidSelectRows = selectedRowKeys
    },
    onAllowSelectChange (selectedRowKeys, selectedRows) {
      this.allowSelectRows = selectedRowKeys
    },
    handleTableChange (pagination) {
      let params = {
        id: this.$route.params.id,
        pagination
      }
      this.$store.dispatch('fetchAllowUserList', params)
    },
    async searchData () {
      let filters = {
        name: '%' + this.searchForm.getFieldValue('name') + '%'
      }
      await this.$store.commit('SET_FORBID_SEARCH_FILTERS', filters)
      let id = this.$route.params.id
      this.$store.dispatch('fetchForbidUserList', { id })
    },
    async searchAllowData () {
      let filters = {
        name: '%' + this.allowSearchForm.getFieldValue('name') + '%'
      }
      await this.$store.commit('SET_ALLOW_SEARCH_FILTERS', filters)
      let id = this.$route.params.id
      this.$store.dispatch('fetchAllowUserList', { id })
    }
  },
  created () {
    this.getUserList()
  },
  computed: {
    ...mapGetters(['getSubSystemForbidUserList', 'getSystemForbidLoading', 'getSubSystemAllowUserList', 'getSystemAllowLoading', 'getSubSystemAllowPagination'])
  }
}
</script>

<style scoped>
    .content{
        margin-top: 10px;
    }
    .marginRight10 {
        margin-right: 10px;
    }
</style>
