<template>
    <a-card>
        <div class="select-options">
            <a-form layout="inline" :form="searchForm">
                <a-form-item
                        style="width: 180px">
                    <a-input
                            :placeholder="$t('template.list.inputTemplate')"
                            allowClear
                            v-decorator="['name']"/>
                </a-form-item>
                <a-form-item>
                    <SelectSubs></SelectSubs>
                </a-form-item>
                <a-form-item>
                    <a-button type="primary" icon="search" @click="searchData"></a-button>
                </a-form-item>
                <a-form-item style="float: right" v-if="canDo('sidebars.templates.store')">
                    <a-button type="primary" class="marginLeft" @click="showAddModal">
                        {{$t('template.list.addTemplate')}}
                    </a-button>
                </a-form-item>
            </a-form>
            <a-table
                    class="content"
                    :columns="columns"
                    :dataSource="getTemplatesData"
                    :loading="getTemplatePageLoading"
                    rowKey="id"
                    :pagination="getTemplatePagination"
                    @change="handleTableChange"
            >
                <template slot-scope="text, record" slot="guardName">
                    <span>{{JSON.parse(getGuardToSubs[record.guard_name])[getLanguage]}}</span>
                </template>
                <template slot-scope="text, record" slot="locale">
                    <span>{{JSON.parse(record.locale)[getLanguage]}}</span>
                </template>
                <template slot-scope="text, record" slot="action">
                    <a @click="edit(record)" v-if="canDo('sidebars.templates.update')">{{$t('template.action.update')}}</a>
                    <a-divider type="vertical" v-if="canDo('sidebars.templates.update')"/>
                    <a-popconfirm placement="top" :okText="$t('common.ok')" :cancelText="$t('common.cancel')" @confirm="deleteTemplate(record.id)" v-if="canDo('sidebars.templates.delete')">
                        <template slot="title">
                            <p>{{$t('template.action.confirm')}}</p>
                        </template>
                        <a>{{$t('template.action.delete')}}</a>
                    </a-popconfirm>
                    <a-divider type="vertical" v-if="canDo('sidebars.templates.delete')"/>
                    <a @click="templateContent(record.id, record.guard_name)" v-if="canDo('sidebars.templates.trees')">{{$t('template.action.templateInfo')}}</a>
                </template>

            </a-table>
        </div>
        <!-- 新增模板的模态框 -->
        <addTemplateModal></addTemplateModal>
        <!-- 更新模板的模态框 -->
        <updateTemplateModal></updateTemplateModal>
    </a-card>
</template>

<script>
import { mapGetters } from 'vuex'
import { bus } from '../../plugins/bus'
import addTemplateModal from './modal/addTemplateModal'
import updateTemplateModal from './modal/updateTemplateInfoModal'
import { delTemplate } from '../../api/sidebar'
import SelectSubs from '../../components/SubsSelect'
import { canDo } from '../../plugins/common'

export default {
  name: 'index',
  components: { addTemplateModal, updateTemplateModal, SelectSubs },
  data () {
    return {
      columns: [
        {
          title: () => this.$t('template.table.template'),
          dataIndex: 'name',
          scopedSlots: { customRender: 'locale' },
          width: '15%'
        },
        {
          title: () => this.$t('common.comment'),
          dataIndex: 'comment',
          width: '30%'
        },
        {
          title: () => this.$t('common.guard'),
          dataIndex: 'guard_name',
          scopedSlots: { customRender: 'guardName' },
          width: '15%'
        },
        {
          title: () => this.$t('common.action'),
          dataIndex: 'action',
          scopedSlots: { customRender: 'action' }
        }
      ],
      searchForm: this.$form.createForm(this)
    }
  },
  methods: {
    canDo,
    handleTableChange (data) {
      this.$store.dispatch('fetchTemplate', data).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
        this.$store.commit('SET_TEMPLATE_PAGE_LOADING', false)
      })
    },
    getIndexData () {
      this.$store.dispatch('fetchTemplate', {}).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
        this.$store.commit('SET_TEMPLATE_PAGE_LOADING', false)
      })
    },
    searchData () {
      let searchData = this.searchForm.getFieldsValue()
      let filter = {}
      if (searchData.name !== undefined) {
        filter.name = '%' + searchData.name + '%'
      }
      if (searchData.guard_name !== undefined) {
        filter.guard_name = searchData.guard_name
      }
      this.$store.commit('SET_TEMPLATE_FILTER', filter)
      this.getIndexData({})
    },
    showAddModal () {
      bus.$emit('showAddTemplateModal')
    },
    edit (data) {
      this.$store.commit('SET_TEMPLATE_CURRENT_DATA', data)
      bus.$emit('showUpdateTemplateModal')
    },
    deleteTemplate (id) {
      let params = {
        id
      }
      delTemplate(params).then(data => {
        if (data.status === 'success') {
          this.$message.success(this.$t('template.notify.deleteSuccess'))
          this.$store.dispatch('fetchTemplate', {}).catch(error => {
            this.$message.error(error.response ? error.response.data.message : error.message)
            this.$store.commit('SET_TEMPLATE_PAGE_LOADING', false)
          })
        } else {
          this.$message.error(this.$t('template.notify.deleteError'))
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    templateContent (id, guardName) {
      this.$router.push({
        name: 'sideBarCategory',
        params: {
          id,
          guard_name: guardName
        }
      })
    }
  },
  computed: {
    ...mapGetters(['getTemplatesData', 'getTemplatePageLoading', 'getTemplatePagination', 'getSubsData', 'getLanguage', 'getGuardToSubs'])
  },
  created () {
    this.$store.commit('SET_TEMPLATE_FILTER', {})
    this.getIndexData()
  }
}
</script>

<style scoped>
    .content {
        margin-top: 10px;
    }
</style>
