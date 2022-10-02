<template>
    <a-card>
        <div class="select-options">
            <a-form layout="inline" :form="searchForm">
                <a-form-item
                        style="width: 180px">
                    <a-input
                            :placeholder="$t('position.list.position')"
                            allowClear
                            v-decorator="['name']"/>
                </a-form-item>
                <a-form-item
                        style="width: 180px">
                    <a-input
                            :placeholder="$t('position.list.number')"
                            allowClear
                            v-decorator="['number']"/>
                </a-form-item>
                <a-form-item>
                    <a-button type="primary" icon="search" @click="searchData"></a-button>
                </a-form-item>
                <a-form-item style="float: right" v-if="canDo('positions.store')">
                    <a-button type="primary" icon="plus-circle" @click="showAddModal">
                        {{$t('position.list.add')}}
                    </a-button>
                </a-form-item>
            </a-form>
        </div>
        <a-table
                class="content"
                :columns="columns"
                :dataSource="getPositionListData"
                :pagination="getPositionListPagination"
                :loading="getPositionPageLoading"
                @change="handleTableChange"
                rowKey="id">
            <template slot-scope="text, record" slot="locale">
                <span>{{JSON.parse(record.locale)[getLanguage]}}</span>
            </template>
            <template slot-scope="text, record" slot="is_system">
                <span>{{ record.is_system == 0 ? $t('common.no') : $t('common.yes')}}</span>
            </template>
            <template slot-scope="text, record" slot="action">
                <a @click="updateInfo(record)" v-if="canDo('positions.update')">{{$t('position.action.update')}}</a>
                <a-divider type="vertical" v-if="canDo('positions.update')"/>
                <a-popconfirm placement="top" :okText="$t('common.ok')" :cancelText="$t('common.cancel')" @confirm="deletePosition(record.id)" v-if="record.is_system == 0 && canDo('positions.delete')">
                    <template slot="title">
                        <p>{{$t('position.action.confirm')}}</p>
                    </template>
                    <a>{{ $t('position.action.delete') }}</a>
                </a-popconfirm>
                <a-divider type="vertical" v-if="record.is_system == 0  && canDo('positions.delete')"/>
                <a @click="positionUser(record.id)">{{$t('position.action.users')}}</a>
            </template>
        </a-table>
        <!-- 新增职称模态框 -->
        <addPositionModal></addPositionModal>
        <!-- 更新信息模态框 -->
        <updatePositionModal></updatePositionModal>
    </a-card>
</template>

<script>
import { mapGetters } from 'vuex'
import { bus } from '../../plugins/bus'
import addPositionModal from './modals/addPositionModal'
import updatePositionModal from './modals/updatePositionModal'
import { delPosition } from '../../api/position'
import { canDo } from '../../plugins/common'

export default {
  name: 'list',
  components: { addPositionModal, updatePositionModal },
  data () {
    return {
      columns: [
        {
          title: () => this.$t('position.list.number'),
          dataIndex: 'number',
          width: '10%'
        },
        {
          title: () => this.$t('position.list.position'),
          dataIndex: 'name',
          width: '15%',
          scopedSlots: { customRender: 'locale' }
        },
        {
          title: () => this.$t('common.comment'),
          dataIndex: 'comment',
          width: '25%'
        },
        {
          title: () => this.$t('position.table.is_system'),
          dataIndex: 'is_system',
          width: '10%',
          scopedSlots: { customRender: 'is_system' }
        },
        {
          title: () => this.$t('position.table.created_at'),
          dataIndex: 'created_at',
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
    handleTableChange (pagination) {
      this.$store.dispatch('positionPageChange', pagination)
    },
    getIndexData () {
      this.$store.dispatch('getPositionIndexData')
    },
    showAddModal () {
      bus.$emit('addPositionModalShow')
    },
    updateInfo (record) {
      this.$store.commit('SET_CURRENT_POSITION', record)
      bus.$emit('updatePositionModalShow')
    },
    deletePosition (id) {
      delPosition(id).then(data => {
        if (data.status === 'success') {
          this.$message.success(this.$t('position.notify.deleteSuccess'))
          this.$store.dispatch('getPositionIndexData')
        } else {
          this.$message.error(this.$t('position.notify.deleteError'))
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    positionUser (id) {
      this.$router.push({
        name: 'userListOfPosition',
        params: {
          id,
          action: 'positiontUsers'
        }
      })
    },
    async searchData () {
      let searchData = this.searchForm.getFieldsValue()
      let filter = {}
      if (searchData.name !== undefined) {
        filter.name = '%' + searchData.name + '%'
      }
      if (searchData.number !== undefined) {
        filter.number = searchData.number
      }
      await this.$store.commit('SET_POSITION_DATA_FILTER', filter)
      await this.$store.dispatch('getPositionIndexData')
    }
  },
  computed: {
    ...mapGetters(['getPositionListPagination', 'getPositionListData', 'getPositionPageLoading', 'getLanguage'])
  },
  created () {
    this.$store.commit('SET_POSITION_DATA_FILTER', {})
    this.getIndexData()
  }
}
</script>

<style scoped>
    .content{
        margin-top: 10px;
    }
</style>
