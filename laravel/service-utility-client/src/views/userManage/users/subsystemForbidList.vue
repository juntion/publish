<template>
    <div>
        <a-card>
            <a-table
                    :columns="columns"
                    :dataSource="getSubSystemList"
                    :loading="loading"
                    rowKey="id"
                    :pagination="false"
            >
                <template slot="name" slot-scope="text, record">
                    {{JSON.parse(record.locale)[getLanguage]}}
                </template>
                <template slot="action" slot-scope="text, record">
                    <a-switch
                            :checked="canUse(record.id)"
                            :checkedChildren="$t('user.modal.able')"
                            :unCheckedChildren="$t('user.modal.unable')"
                            @change='checked => onUsableChange(checked,record.id)'
                    />
                </template>
            </a-table>
        </a-card>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'subsystemForbidList',
  data () {
    return {
      loading: false,
      columns: [
        {
          title: 'id',
          dataIndex: 'id',
          width: '15%'
        },
        {
          title: () => this.$t('user.modal.subName'),
          dataIndex: 'name',
          scopedSlots: { customRender: 'name' }
        },
        {
          title: () => this.$t('user.modal.link'),
          dataIndex: 'link'
        },
        {
          title: () => this.$t('user.modal.guard'),
          dataIndex: 'guard_name'
        },
        {
          title: () => this.$t('user.modal.status'),
          dataIndex: 'action',
          scopedSlots: { customRender: 'action' }
        }
      ]
    }
  },
  methods: {
    async getList () {
      this.loading = true
      await this.$store.dispatch('getSubsList').catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
      this.loading = false
    },
    async getForbids () {
      let params = {
        id: this.$route.params.id
      }
      await this.$store.dispatch('getForbiddenList', params).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
      this.getList()
    },
    canUse (id) {
      for (var i in this.getForbiddenSubs) {
        if (this.getForbiddenSubs[i] === id) {
          return false
        }
      }
      return true
    },
    async onUsableChange (check, id) {
      this.loading = true
      let params = {
        enable: check,
        id: this.$route.params.id,
        subsystem_id: id
      }
      await this.$store.dispatch('changeForbidStatus', params).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
      this.loading = false
    }
  },
  computed: {
    ...mapGetters(['getSubSystemList', 'getForbiddenSubs', 'getLanguage'])
  },
  created () {
    this.getForbids()
  }
}
</script>

<style scoped>

</style>
