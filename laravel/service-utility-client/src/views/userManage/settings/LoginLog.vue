<template>
  <div>
    <!--
    <a-table
      :columns="columns"
      :dataSource='getLoginLog'
      :pagination="{ pageSize: 20 }"
      :scroll="{ y: 300 }"
      rowKey="id"
    />
    -->
    <div class="setting-title">{{ $t('system.settings.loginLogTitle') }}</div>
    <div class="table-1">
      <div style="padding-right: 17px;background-color: #e4eaf6;">
        <table class="widthAll">
          <thead>
            <tr>
              <td v-for="(item, i) in columns" :key="i" :width="item.width">{{ $t(item.name) }}</td>
            </tr>
          </thead>
        </table>
      </div>
      <div style="max-height: 316px;overflow-y: scroll;">
        <table class="widthAll">
          <tbody>
          <tr v-for="(item, i) in getLoginLog" :key="i">
            <td width="34%">{{ item.created_at ? item.created_at : blankData }}</td>
            <td width="22%">{{ item.ip_address ? item.ip_address : blankData }}</td>
            <td width="22%">{{ item.city ? item.city : blankData }}</td>
            <td width="22%">{{ item.browser ? item.browser : blankData }}</td>
          </tr>
        </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'LoginLog',
  data () {
    return {
      columns: [
        {
          title: () => this.$t('system.settings.loginTime'),
          name: 'system.settings.loginTime',
          dataIndex: 'created_at',
          width: '34%'
        },
        {
          title: () => this.$t('system.settings.loginIP'),
          name: 'system.settings.loginIP',
          dataIndex: 'ip_address',
          width: '22%'
        },
        {
          title: () => this.$t('system.settings.loginCity'),
          name: 'system.settings.loginCity',
          dataIndex: 'city',
          width: '22%'
        },
        {
          title: () => this.$t('system.settings.loginDevice'),
          name: 'system.settings.loginDevice',
          dataIndex: 'browser',
          width: '22%'
        }
      ],
      blankData: this.publicJS.blankData
    }
  },
  computed: {
    ...mapGetters([ 'getLoginLog' ])
  },
  methods: {
    getLoginLogData () {
      this.$store.dispatch('loginLogInfo').catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    }
  },
  mounted () {
    this.getLoginLogData()
  }
}
</script>

<style lang="less" scoped>
  .table-1 td {
    padding-left: 20px;
    font-size: 12px;
  }
</style>
