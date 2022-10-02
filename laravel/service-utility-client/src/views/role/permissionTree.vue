<template>
  <a-spin :spinning="spinning">
    <a-card>
      <a-form layout="inline"
              :form="searchForm">
        <a-form-item>
          <SelectSubs></SelectSubs>
        </a-form-item>
        <a-form-item>
          <a-button type="primary"
                    icon="search"
                    @click="searchData"></a-button>
        </a-form-item>
        <a-form-item style="float: right"
                     v-if="canDo('permissions.roles.givePermissions')">
          <a-button type="primary"
                    :loading="rolePermissionLoading"
                    class="marginLeft"
                    @click="updateRolePermission">{{$t('role.permission.updateRolePermission')}}</a-button>
        </a-form-item>
      </a-form>

      <a-tree checkable
              :treeData="treeData"
              v-model="PermissionRows">
      </a-tree>
    </a-card>
  </a-spin>
</template>

<script>
import { getRolePermission, updateRolePermission, getPermissionsGroups } from '../../api/role'
import { canDo } from '../../plugins/common'
import { mapGetters } from 'vuex'
import SelectSubs from '../../components/SubsSelect'

export default {
  name: 'permissionTree',
  components: { SelectSubs },
  data () {
    return {
      spinning: false,
      searchForm: this.$form.createForm(this),
      isUpdateRolePermission: false,
      rolePermissionLoading: false,
      treeData: [],
      PermissionRows: [],
      oldPermissionRow: []
    }
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
        id: this.$route.params.id,
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
      let roleId = this.$route.params.id
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
    },
    searchData () {
      this.getRoleGroupData()
    }
  },
  created () {
    this.getRoleGroupData()
  },
  computed: {
    ...mapGetters(['getLanguage', 'getCurrentSub'])
  }
}
</script>

<style scoped>
</style>
