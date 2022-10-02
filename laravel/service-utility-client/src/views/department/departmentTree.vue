<template>
    <a-card>
        <a-tabs defaultActiveKey="1">
            <a-tab-pane :tab="$t('department.list.departmentList')" key="1">
                <a-form layout="inline" :form="searchForm">
                    <a-form-item
                            style="width: 180px">
                        <a-input
                                :placeholder="$t('department.list.departmentName')"
                                allowClear
                                v-decorator="['name']"/>
                    </a-form-item>
                    <a-form-item>
                        <a-button type="primary" icon="search" @click="searchData"></a-button>
                    </a-form-item>
                    <a-form-item style="float: right">
                        <a-button type="primary" icon="plus-circle" @click="showAddModal" v-if="canDo('departments.createBasic')">
                            {{$t('department.list.addLevel1')}}
                        </a-button>
                    </a-form-item>
                </a-form>
                <a-table
                        class="content"
                        :columns="columns"
                        :dataSource="getDepartmentListData"
                        :loading="getDepartmentPageLoading"
                        rowKey="id"
                        :pagination="false"
                >
                    <template slot-scope="text, record" slot="locale">
                        <span>{{JSON.parse(record.locale)[getLanguage]}}</span>
                    </template>
                    <template slot-scope="text, record" slot="is_base">
                        <span>{{ record.is_base == 1 ? $t('common.yes') : $t('common.no')}}</span>
                    </template>
                    <template slot="action" slot-scope="text, record">
                        <a @click="edit(record)" v-if="canDo('departments.update')">{{$t('department.action.update')}}</a>
                        <a-divider type="vertical" v-if="canDo('departments.update')"/>
                        <a-popconfirm placement="top"
                          :okText="$t('common.ok')"
                          :cancelText="$t('common.cancel')"
                          @confirm="deleteDepartment(record.id)"
                          v-if="(canDo('departments.delete') && record.is_base == 0) || (canDo('departments.deleteBasic') && record.is_base == 1)"
                        >
                            <template slot="title">
                                <p>{{$t('department.action.confirm')}}</p>
                            </template>
                            <a>{{$t('department.action.delete')}}</a>
                        </a-popconfirm>
                        <a-divider type="vertical" v-if="canDo('departments.delete') && record.is_base == 0"/>
                        <a @click="departmentUser(record.id)" >{{$t('department.action.user')}}</a>
                        <a-divider type="vertical"/>
                        <a @click="addChildDepartment(record)" v-if="canDo('departments.store')">{{$t('department.action.add')}}</a>
                    </template>
                </a-table>
            </a-tab-pane>
            <a-tab-pane :tab="$t('department.list.tree')" key="2" forceRender>
                <departmentTreeData></departmentTreeData>
            </a-tab-pane>
        </a-tabs>
        <!--  新增或修改的modal  -->
        <addDepartmentModal></addDepartmentModal>
    </a-card>
</template>

<script>
import { bus } from '../../plugins/bus'
import { mapGetters } from 'vuex'
import { delDepartment } from '../../api/department'
import { languages } from '../../plugins/lang'
import addDepartmentModal from './modal/addDepartmentModal'
import departmentTreeData from './modal/departmentTreeData'
import { canDo } from '@/plugins/common'

export default {
  name: 'departmentTree',
  components: { addDepartmentModal, departmentTreeData },
  data () {
    return {
      columns: [
        {
          title: () => this.$t('department.table.department'),
          dataIndex: 'name',
          scopedSlots: { customRender: 'locale' },
          width: '20%'
        },
        {
          title: () => this.$t('department.table.baseDepartment'),
          dataIndex: 'is_base',
          scopedSlots: { customRender: 'is_base' },
          width: '20%'
        },
        {
          title: () => this.$t('department.table.code'),
          dataIndex: 'code',
          scopedSlots: { customRender: 'code' },
          width: '20%'
        },
        {
          title: () => this.$t('department.table.created_at'),
          dataIndex: 'created_at',
          width: '20%'
        },
        {
          title: () => this.$t('common.action'),
          scopedSlots: { customRender: 'action' }
        }
      ],
      languages: languages,
      langForm: this.$form.createForm(this),
      searchForm: this.$form.createForm(this)
    }
  },
  methods: {
    canDo,
    getDataTree () {
      this.$store.dispatch('fetchDepartmentTree').catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    deleteDepartment (id) {
      delDepartment(id).then(data => {
        if (data.status === 'success') {
          this.$message.success(this.$t('department.notify.deleteSuccess'))
          this.$store.dispatch('fetchDepartmentTree')
          bus.$emit('updateDepartmentLevelInfo')
        } else {
          this.$message.error(this.$t('department.notify.deleteError'))
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    showAddModal () {
      let params = {
        parent_id: 0,
        locale: '{}',
        name: '',
        action: 'addFirstDepartment'
      }
      this.$store.commit('SET_CURRENT_DEPARTMENT_DATA', params)
      bus.$emit('showAddDepartmentModal')
    },
    edit (record) {
      this.$store.commit('SET_CURRENT_DEPARTMENT_DATA', record)
      bus.$emit('showAddDepartmentModal')
    },
    addChildDepartment (record) {
      let params = {
        parent_id: record.id,
        locale: '{}',
        name: '',
        action: 'addChild'
      }
      this.$store.commit('SET_CURRENT_DEPARTMENT_DATA', params)
      bus.$emit('showAddDepartmentModal')
    },
    departmentUser (id) {
      this.$router.push({
        name: 'departmentUser',
        params: {
          id,
          action: 'departmentUsers'
        }
      })
    },
    async searchData () {
      let searchData = this.searchForm.getFieldsValue()
      let filter = {}
      if (searchData.name !== undefined) {
        filter.name = '%' + searchData.name + '%'
      }
      await this.$store.commit('SET_DEPARTMENT_DATA_FILTER', filter)
      this.getDataTree()
    }
  },
  computed: {
    ...mapGetters(['getDepartmentListData', 'getDepartmentPageLoading', 'getLanguage'])
  },
  created () {
    this.$store.commit('SET_DEPARTMENT_DATA_FILTER', {})
    this.getDataTree()
  }
}
</script>

<style scoped>
    .content{
        margin-top: 10px;
    }
</style>
