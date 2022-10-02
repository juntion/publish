<template>
  <a-spin :spinning="spinning">
   <a-table :columns="columns" :data-source="data" :pagination="false">
  </a-table>
  </a-spin>
</template>
<script>
import { getRoleChild } from '@/api/role'
export default {
  name: 'bind',
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
          title: '用户名',
          dataIndex: 'name',
          ellipsis: true
        },
        {
          title: '邮箱',
          dataIndex: 'email',
          ellipsis: true
        },
        {
          title: '邮箱验证时间',
          dataIndex: 'email_verified_at',
          ellipsis: true
        },
        {
          title: '默认所属部门',
          dataIndex: 'department[0].name',
          ellipsis: true
        },
        {
          title: '职位',
          dataIndex: 'positions[0].name',
          ellipsis: true
        },
        {
          title: '所属子公司',
          dataIndex: 'company.company_name',
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
      if (val != oldVal) {
        this.getChildData(val, this.pagination.page)
      }
    }
  },
  created () {
    this.getChildData(this.itId, this.pagination.page)
  },
  methods: {
    getChildData (val, page) {
      let roleId = val
      let params = {
        limit: this.pagination.limit,
        page: page
      }
      getRoleChild(roleId, params).then(res => {
        if (res.status === 'success') {
          this.data = res.data.users.data
          this.$emit('bindOption', res.data.users.total)
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
