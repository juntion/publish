<template>
  <a-spin :spinning="spinning">
    <a-table :columns="columns" :data-source="data" :pagination="false">
    </a-table>
  </a-spin>
</template>
<script>
import { getRoleLog } from '@/api/role'
export default {
  name: 'record',
  data () {
    return {
      pagination: {
        limit: 20,
        page: 1
      },
      id: undefined,
      spinning: false,
      columns: [
        {
          title: '操作时间',
          dataIndex: 'created_at',
          key: 'created_at'
        },
        {
          title: '操作人员',
          dataIndex: 'user_name',
          key: 'user_name'
        },
        {
          title: '操作内容',
          dataIndex: 'description',
          key: 'description',
          ellipsis: true
        }
      ],
      data: []
    }
  },
  props: {
    itId: undefined
  },
  watch: {
    itId (val, oldVal) {
      if (val !== oldVal) {
        this.getRecordData(val, this.pagination.page)
      }
    }
  },
  created () {
    this.getRecordData(this.itId, this.pagination.page)
  },
  methods: {
    getRecordData (val, page) {
      let roleId = val
      let params = {
        limit: this.pagination.limit,
        page: page
      }
      getRoleLog(roleId, params).then(res => {
        if (res.status === 'success') {
          this.data = res.data.data
          this.$emit('logOption', res.data.total)
        }
      }).catch(error => {
        console.log(error)
      })
    }
  }
}
</script>

<style scoped>
</style>
