<template>
    <a-card>
        <a-table
                :columns="columns"
                :dataSource="UserList"
                :loading="PageLoading"
                rowKey="id"
        >
        </a-table>
    </a-card>
</template>

<script>
import { getPositionUser } from '../../api/position'
import { getDepartmentUsers } from '../../api/department'

export default {
  name: 'userListOfPosition',
  data () {
    return {
      columns: [
        {
          title: () => this.$t('position.user.name'),
          dataIndex: 'name'
        },
        {
          title: () => this.$t('position.user.email'),
          dataIndex: 'email'
        },
        {
          title: () => this.$t('position.user.email_verified_at'),
          dataIndex: 'email_verified_at'
        }
      ],
      UserList: [],
      PageLoading: false
    }
  },
  methods: {
    getUserList () {
      this.PageLoading = true
      let id = this.$route.params.id
      let action = this.$route.params.action
      let res = {}
      switch (action) {
        case 'positiontUsers':
          res = getPositionUser(id)
          break
        case 'departmentUsers':
          res = getDepartmentUsers(id)
          break
      }
      res.then(data => {
        if (data.status === 'success') {
          this.UserList = data.data.users
        } else {
          this.$message.error(this.$t('position.notify.getDataError'))
        }
        this.PageLoading = false
      }).catch(error => {
        this.PageLoading = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    }
  },
  created () {
    this.getUserList()
  }
}
</script>

<style scoped>

</style>
