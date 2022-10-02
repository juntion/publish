<template>
    <a-card>
        <div class="select-options">
            <a-form layout="inline" :form="searchForm">
                <a-form-item
                        style="width: 180px">
                    <a-input
                            :placeholder="$t('subsystem.list.inputPage')"
                            allowClear
                            v-decorator="['name']"/>
                </a-form-item>
                <a-form-item
                        style="width: 180px">
                    <a-select  :placeholder="$t('subsystem.list.pageType')"
                               style="width: 180px"
                               allowClear
                               v-decorator="['type']">
                        <a-select-option value="0">{{$t('subsystem.list.commonPage')}}</a-select-option>
                        <a-select-option value="1">{{$t('subsystem.list.homePage')}}</a-select-option>
                    </a-select>
                </a-form-item>
                <a-form-item>
                    <SelectSubs></SelectSubs>
                </a-form-item>
                <a-form-item>
                    <a-button type="primary" icon="search" @click="searchData"></a-button>
                </a-form-item>
            </a-form>
        </div>
        <a-table
                class="content"
                :columns="columns"
                :dataSource="data"
                :loading="pageLoading"
                rowKey="id"
                :pagination="pagination"
                @change="handleTableChange"
        >
            <template slot-scope="text, record" slot="guardName">
                <span>{{JSON.parse(getGuardToSubs[record.guard_name])[getLanguage]}}</span>
            </template>
            <template slot-scope="text, record" slot="locale">
                <span>{{JSON.parse(record.locale)[getLanguage]}}</span>
            </template>
            <template slot-scope="text, record" slot="type">
                <span v-if="record.type === 1">
                    {{$t('subsystem.list.homePage')}}
                </span>
                <span v-else>
                    {{$t('subsystem.list.commonPage')}}
                </span>
            </template>
            <template slot-scope="text, record" slot="action">
                <a @click="updateInfo(record)" v-if="canDo('pages.update')">{{$t('subsystem.action.updatePage')}}</a>
            </template>
        </a-table>
        <updatePageInfoModal></updatePageInfoModal>
    </a-card>
</template>

<script>
import { getPageList } from '../../api/subsystem'
import { languages } from '../../plugins/lang'
import { bus } from '../../plugins/bus'
import updatePageInfoModal from './modal/updatePageInfoModal'
import { mapGetters } from 'vuex'
import SelectSubs from '../../components/SubsSelect'
import { canDo } from '../../plugins/common'

export default {
  name: 'pageList',
  components: { updatePageInfoModal, SelectSubs },
  data () {
    return {
      searchForm: this.$form.createForm(this),
      columns: [
        {
          title: () => this.$t('subsystem.table.pageName'),
          dataIndex: 'name',
          scopedSlots: { customRender: 'locale' },
          width: '10%'
        },
        {
          title: () => this.$t('common.comment'),
          dataIndex: 'comment',
          width: '20%'
        },
        {
          title: () => this.$t('common.guard'),
          dataIndex: 'guard_name',
          scopedSlots: { customRender: 'guardName' },
          width: '10%'
        },
        {
          title: () => this.$t('subsystem.table.route'),
          dataIndex: 'route',
          width: '10%'
        },
        {
          title: () => this.$t('subsystem.table.routeName'),
          dataIndex: 'route_name',
          width: '15%'
        },
        {
          title: () => this.$t('subsystem.table.pageType'),
          dataIndex: 'type',
          scopedSlots: { customRender: 'type' },
          width: '10%'
        },
        {
          title: () => this.$t('common.action'),
          dataIndex: 'action',
          scopedSlots: { customRender: 'action' }
        }
      ],
      data: [],
      pageLoading: false,
      pagination: {
        showSizeChanger: true,
        current: 1,
        pageSize: 20,
        pageSizeOptions: ['20', '50', '100']
      },
      filter: {},
      languages: languages
    }
  },
  methods: {
    canDo,
    searchData () {
      let searchData = this.searchForm.getFieldsValue()
      this.filter = {}
      if (searchData.name !== undefined) {
        this.filter.name = '%' + searchData.name + '%'
      }
      if (searchData.type !== undefined) {
        this.filter.type = searchData.type
      }
      this.getData({})
    },
    getData (params) {
      this.filter.guard_name = this.getCurrentSub
      params.filters = this.filter
      this.pageLoading = true
      getPageList(params).then(data => {
        this.pageLoading = false
        if (data.status === 'success') {
          this.data = data.data.data
          this.pagination.current = data.data.current_page
          this.pagination.total = data.data.total
          this.pagination.pageSize = Number(data.data.per_page)
        } else {
          this.$message.error(this.$t('subsystem.notify.getPageDateError'))
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
        this.pageLoading = false
      })
    },
    handleTableChange (pagination) {
      let params = {
        limit: pagination.pageSize,
        page: pagination.current
      }
      this.getData(params)
    },
    updateInfo (record) {
      bus.$emit('updatePageInfoModalShow', record)
    }
  },
  created () {
    this.getData({})
  },
  mounted () {
    bus.$on('refreshPageData', data => {
      this.getData({
        limit: this.pagination.pageSize,
        page: this.pagination.current
      })
    })
  },
  computed: {
    ...mapGetters(['getLanguage', 'getCurrentSub', 'getGuardToSubs'])
  }
}
</script>

<style scoped>
    .content{
        margin-top: 10px;
    }
    .marginBottom5{
        margin-bottom: 5px;
    }
</style>
