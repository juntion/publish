<template>
  <a-spin :spinning="spinning">
      <a-tree checkable
              :treeData="treeData"
              v-model="PermissionRows">
      </a-tree>
  </a-spin>
</template>
<script>
import { getRolePermission, updateRolePermission, getPermissionsGroups } from '@/api/role'
import { canDo } from '@/plugins/common'
import { mapGetters } from 'vuex'
export default {
  name: 'permissionTree',
  data () {
    return {
      id: undefined,
      spinning: false,
      searchForm: this.$form.createForm(this),
      isUpdateRolePermission: false,
      rolePermissionLoading: false,
      treeData: [],
      PermissionRows: [],
      oldPermissionRow: []
    }
  },
  props: {
    itId: undefined
  },
  watch: {
    itId (val, oldVl) {
      this.id = val
      if (val != oldVl) {
        this.getRoleGroupData()
      }
    }
  },
  computed: {
    ...mapGetters(['getRoleListData', 'getLanguage', 'getCurrentSub'])
  },
  async created () {
    await this.$store.dispatch('fetchRolesList')
    this.id = this.getRoleListData[0].id
    this.$emit('activeFn', this.id)
    this.getRoleGroupData()
  },
  methods: {
    updateRolePermission () {
      if (this.PermissionRows.length < 1) {
        this.$message.error(this.$t('role.permission.choose'))
        return false
      }
      let permission = this.PermissionRows
      for (let i in permission) {
        if (permission[i].indexOf('level') > -1) {
          permission.splice(i, 1)
        }
      }
      this.rolePermissionLoading = true
      let params = {
        id: this.itId,
        permission_ids: permission
      }
      updateRolePermission(params).then(data => {
        this.rolePermissionLoading = false
        if (data.status === 'success') {
          this.$message.success(this.$t('role.permission.updateRolePermissionSuccess'))
          this.oldPermissionRow = this.PermissionRows
        } else {
          this.$message.error(this.$t('role.permission.updateRolePermissionError'))
          this.PermissionRows = this.oldPermissionRow
        }
      }).catch(error => {
        this.rolePermissionLoading = false
        this.PermissionRows = this.oldPermissionRow
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    setIsRolePermission () {
      let roleId = this.id
      // console.log(roleId,'roleId')
      if (roleId !== undefined) {
        this.isUpdateRolePermission = true
        let params = {
          id: roleId
        }
        this.getRolePermissions(params)
      } else {
        this.isUpdateRolePermission = false
      }
    },
    getRolePermissions (params) {
      getRolePermission(params).then(data => {
        if (data.status === 'success') {
          let res = data.data
          for (let i in res) {
            res[i] = (res[i]).toString()
          }
          this.PermissionRows = res
          this.oldPermissionRow = res
        } else {
          this.$message.error('获取角色权限失败')
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    canDo,
    getRoleGroupData () {
      this.spinning = true
      let params = {
        guard_name: this.getCurrentSub
      }
      getPermissionsGroups(params).then(data => {
        let treeData = this.formatTreeData(data.data.permissions)
        this.dataTree = treeData
        this.setIsRolePermission()
        this.spinning = false
      }).catch(error => {
        this.spinning = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    formatTreeData (data) {
      let treeData = []
      for (let item in data) {
        let level1 = {
          title: data[item]['name'],
          key: 'level1-' + item
        }
        let childLevel = data[item].data
        level1.children = this.formatChild(childLevel)
        treeData.push(level1)
      }
      this.treeData = treeData
    },
    formatChild (childLevel) {
      let child = []
      for (let i in childLevel) {
        let params = {
          title: () => JSON.parse(childLevel[i]['locale'])[this.getLanguage],
          key: (childLevel[i]['id']).toString(),
          value: childLevel[i]['id'],
          isLeaf: true
        }
        child.push(params)
      }
      return child
    }
    // searchData () {
    //   this.getRoleGroupData()
    // }
  }
}
</script>

<style scoped>
</style>
