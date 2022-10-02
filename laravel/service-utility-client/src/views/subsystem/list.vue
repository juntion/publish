<template>
    <a-card>
        <a-form layout="inline" :form="searchForm">
            <a-form-item
                    style="width: 180px">
                <a-input
                        :placeholder="$t('subsystem.list.subsystem')"
                        allowClear
                        v-decorator="['name']"/>
            </a-form-item>
            <a-form-item>
                <SelectSubs></SelectSubs>
            </a-form-item>
            <a-form-item>
                <a-button type="primary" icon="search" @click="searchData"></a-button>
            </a-form-item>
        </a-form>
        <a-table
                class="content"
                :columns="columns"
                :dataSource="getSubSystemListData"
                :loading="getSubSystemPageLoading"
                rowKey="id"
                :pagination="false"
        >
            <template slot-scope="text, record" slot="sidebar">
                <a-switch
                        :checked="record.sidebar == 1"
                        :checkedChildren="$t('common.yes')"
                        :unCheckedChildren="$t('common.no')"
                        @change='checked => changeSidebarStatus(checked,record.id)'
                />
            </template>
            <template slot-scope="text, record" slot="homepage">
                <a-switch
                        :checked="record.homepage == 1"
                        :checkedChildren="$t('common.yes')"
                        :unCheckedChildren="$t('common.no')"
                        @change='checked => changeHomepageStatus(checked,record.id)'
                />
            </template>
            <template slot-scope="text, record" slot="guardName">
                <span>{{JSON.parse(getGuardToSubs[record.guard_name])[getLanguage]}}</span>
            </template>
            <template slot-scope="text, record" slot="locale">
                <span>{{JSON.parse(record.locale)[getLanguage]}}</span>
            </template>
            <template slot-scope="text, record" slot="action">
                <a @click="updateInfo(record)" v-if="canDo('subsystems.update')">{{$t('subsystem.action.update')}}</a>
                <a-divider type="vertical" v-if="canDo('subsystems.update')"/>
                <a @click="forbidUsers(record.id)" v-if="canDo('subsystems.forbidUsers')">{{$t('subsystem.action.forbidUsers')}}</a>
            </template>
        </a-table>
        <!-- 更新信息模态框 -->
        <updateSubSystemModal></updateSubSystemModal>
    </a-card>
</template>

<script>
import { mapGetters } from 'vuex'
import { languages } from '../../plugins/lang'
import { setSubSystemHomepage, setSubSystemSideBar } from '../../api/subsystem'
import { bus } from '../../plugins/bus'
import updateSubSystemModal from './modal/updateSubSystemModal'
import SelectSubs from '../../components/SubsSelect'
import { canDo } from '../../plugins/common'

export default {
  name: 'list',
  components: { updateSubSystemModal, SelectSubs },
  data () {
    return {
      columns: [
        {
          title: () => this.$t('subsystem.table.subsystem'),
          dataIndex: 'name',
          scopedSlots: { customRender: 'locale' },
          width: '15%'
        },
        {
          title: () => this.$t('subsystem.table.link'),
          dataIndex: 'link',
          width: '20%'
        },
        {
          title: () => this.$t('subsystem.table.setSideBar'),
          dataIndex: 'sidebar',
          scopedSlots: { customRender: 'sidebar' },
          width: '15%'
        },
        {
          title: () => this.$t('subsystem.table.setHomePage'),
          dataIndex: 'homepage',
          scopedSlots: { customRender: 'homepage' },
          width: '15%'
        },
        {
          title: () => this.$t('common.action'),
          dataIndex: 'action',
          scopedSlots: { customRender: 'action' }
        }
      ],
      languages: languages,
      searchForm: this.$form.createForm(this)
    }
  },
  methods: {
    getListData () {
      this.$store.dispatch('fetchSubSystemData').catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    changeSidebarStatus (check, id) {
      let params = {
        status: check ? 1 : 0,
        id
      }
      this.$store.commit('SET_SUBSYSTEM_LOADING', true)
      setSubSystemSideBar(params).then(data => {
        if (data.status === 'success') {
          this.$message.success(this.$t('subsystem.notify.updateSideSuccess'))
          this.$store.dispatch('fetchSubSystemData')
        } else {
          this.$store.commit('SET_SUBSYSTEM_LOADING', false)
          this.$message.error(this.$t('subsystem.notify.updateSideError'))
        }
      }).catch(error => {
        this.$store.commit('SET_SUBSYSTEM_LOADING', false)
        this.$message.error(error.response.data.message || error.message)
      })
    },
    changeHomepageStatus (check, id) {
      let params = {
        status: check ? 1 : 0,
        id
      }
      this.$store.commit('SET_SUBSYSTEM_LOADING', true)
      setSubSystemHomepage(params).then(data => {
        if (data.status === 'success') {
          this.$message.success(this.$t('subsystem.notify.updateHomePageSuccess'))
          this.$store.dispatch('fetchSubSystemData')
        } else {
          this.$store.commit('SET_SUBSYSTEM_LOADING', false)
          this.$message.error(this.$t('subsystem.notify.updateHomePageError'))
        }
      }).catch(error => {
        this.$store.commit('SET_SUBSYSTEM_LOADING', false)
        this.$message.error(error.response.data.message || error.message)
      })
    },
    updateInfo (record) {
      this.$store.commit('SET_CURRENT_SUBSYSTEM_DATA', record)
      bus.$emit('updateSubSystemInfoModalShow')
    },
    forbidUsers (id) {
      this.$router.push({
        name: 'subsystemForbidUsers',
        params: {
          id
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
      await this.$store.commit('SET_SUBSYSTEMS_DATA_FILTER', filter)
      this.getListData()
    },
    canDo
  },
  computed: {
    ...mapGetters(['getSubSystemListData', 'getSubSystemPageLoading', 'getLanguage', 'getGuardToSubs'])
  },
  created () {
    this.$store.commit('SET_SUBSYSTEMS_DATA_FILTER', {})
    this.getListData()
  }
}
</script>

<style scoped>
    .marginBottom5{
        margin-bottom: 5px;
    }
    .content{
        margin-top: 10px;
    }
</style>
