<template>
    <div>
        <a-input-search style="margin-bottom: 8px;width: 220px"  @change="onChange" />
        <a-tree
                :loadData="onLoadData"
                :expandedKeys="expandedKeys"
                :autoExpandParent="autoExpandParent"
                :treeData="treeData"
                :showIcon="true"
                :filterTreeNode="filterTreeNode"
                @expand="onExpand"
                @rightClick="rightClick"
                :selectedKeys="selectKey"
        >
            <a-icon slot="user" type="user"/>
            <a-icon slot="user-duties-10" type="user" class="userDuties10"></a-icon>
            <a-icon slot="user-duties-20" type="user" class="userDuties20"></a-icon>
            <a-icon slot="user-duties-30" type="user" class="userDuties30"></a-icon>
            <a-icon slot="user-duties-40" type="user" class="userDuties40"></a-icon>
            <a-icon slot="user-duties-50" type="user" class="userDuties50"></a-icon>
            <a-icon slot="user-duties-60" type="user" class="userDuties60"></a-icon>
            <template slot="folder" slot-scope="{expanded}">
                <a-icon :type="expanded ? 'folder-open':'folder'" />
            </template>
            <template slot="title" slot-scope="{ title, isLeaf }">
                <span v-if="isLeaf">
                    <span v-if="title.toLowerCase().indexOf(searchValue.toLowerCase()) > -1">
                      {{ title.substr(0, title.toLowerCase().indexOf(searchValue.toLowerCase())) }}
                      <span style="color: #f50">{{ title.substr(title.toLowerCase().indexOf(searchValue.toLowerCase()), searchValue.length) }}</span>
                      {{ title.substr(title.toLowerCase().indexOf(searchValue.toLowerCase()) + searchValue.length) }}
                    </span>
                    <span v-else>{{ title }}</span>
                </span>
                <span v-else>
                    <span v-if="title[getLanguage].toLowerCase().indexOf(searchValue.toLowerCase()) > -1">
                      {{ title[getLanguage].substr(0, title[getLanguage].toLowerCase().indexOf(searchValue.toLowerCase())) }}
                      <span style="color: #f50">{{ title[getLanguage].substr(title[getLanguage].toLowerCase().indexOf(searchValue.toLowerCase()), searchValue.length) }}</span>
                      {{ title[getLanguage].substr(title[getLanguage].toLowerCase().indexOf(searchValue.toLowerCase()) + searchValue.length) }}
                    </span>
                    <span v-else>{{ title[getLanguage] }}</span>
                </span>
            </template>
        </a-tree>
        <div class="rightClickMenu ant-popover-inner"
             ref="rightMenu"
             v-show="isShow"
             @mouseleave="hideMenu"
             :style="menuStyle"
        >
                <a
                    class="MenuItem"
                    ref="item0"
                    @mouseover="changeState(0)"
                    @mouseout="resetState(0)"
                    @click="setDuties(60)"
                    v-if="canSetDuty">
                    <a-icon type="user" class="userDuties60"></a-icon>
                    {{$t('department.action.setAsDirector')}}
                </a>
                <a
                        class="MenuItem"
                        ref="item1"
                        @mouseover="changeState(1)"
                        @mouseout="resetState(1)"
                        @click="setDuties(50)"
                        v-if="canSetDuty"
                >
                    <a-icon type="user" class="userDuties50"></a-icon>
                    {{$t('department.action.setAsManager')}}
                </a>
                <a
                        class="MenuItem"
                        ref="item2"
                        @mouseover="changeState(2)"
                        @mouseout="resetState(2)"
                        @click="setDuties(40)"
                        v-if="canSetDuty"
                >
                    <a-icon type="user" class="userDuties40"></a-icon>
                    {{$t('department.action.setAsSupervisor')}}
                </a>
                <a
                        class="MenuItem"
                        ref="item3"
                        @mouseover="changeState(3)"
                        @mouseout="resetState(3)"
                        @click="setDuties(30)"
                        v-if="canSetDuty"
                >
                    <a-icon type="user" class="userDuties30"></a-icon>
                    {{$t('department.action.setAsPrincipal')}}
                </a>
                <a
                        class="MenuItem"
                        ref="item4"
                        @mouseover="changeState(4)"
                        @mouseout="resetState(4)"
                        @click="setDuties(20)"
                        v-if="canSetDuty"
                >
                    <a-icon type="user" class="userDuties20"></a-icon>
                    {{$t('department.action.setAsGroupPrincipal')}}
                </a>
                <a
                        class="MenuItem"
                        ref="item5"
                        @mouseover="changeState(5)"
                        @mouseout="resetState(5)"
                        @click="setDuties(10)"
                        v-if="canSetDuty"
                >
                    <a-icon type="user" class="userDuties10"></a-icon>
                    {{$t('department.action.setAsGroupLeader')}}
                </a>
                <a
                        class="MenuItem"
                        ref="item6"
                        @mouseover="changeState(6)"
                        @mouseout="resetState(6)"
                        @click="setDuties(0)"
                        v-if="canSetDuty"
                >
                    <a-icon type="user"></a-icon>
                    {{$t('department.action.setAsDefault')}}
                </a>

                <a class="MenuItem"
                   ref="item7"
                   @mouseover="changeState(7)"
                   @mouseout="resetState(7)"
                   @click="setPermission"
                   v-if="canSetProfiles"
                >
                    <a-icon type="setting"></a-icon>
                    {{$t('department.action.SetPermissions')}}
                </a>

                <a class="MenuItem"
                   ref="item8"
                   @mouseover="changeState(8)"
                   @mouseout="resetState(8)"
                   @click="distributionPermissions"
                   v-if="canSetUsersProfiles"
                >
                    <a-icon type="setting"></a-icon>
                    {{$t('department.action.distributionPermissions')}}
                </a>
        </div>
        <SetPermissionModal></SetPermissionModal>
        <Distribution></Distribution>
    </div>
</template>

<script>
import {
  getAllDepartmentData,
  getDepartmentUsers,
  getErpProfiles,
  setUserPower
} from '../../../api/department'
import { bus } from '../../../plugins/bus'
import { mapGetters } from 'vuex'
import { canDo } from '../../../plugins/common'
import SetPermissionModal from './setPermissionModal'
import Distribution from './distributionPermissionsModal'
import { searchUserList } from '@/api/userManage/index.js'

export default {
  name: 'departmentTreeData',
  components: { SetPermissionModal, Distribution },
  data () {
    return {
      menuStyle: {
        left: 0,
        top: 0
      },
      selectKey: [],
      isShow: false,
      treeData: [],
      expandedKeys: [],
      autoExpandParent: true,
      userId: 0,
      currentUserData: [],
      canSetDuty: false,
      canSetProfiles: false,
      canSetUsersProfiles: false,
      searchValue: '',
      timer: null
    }
  },
  methods: {
    setDuties (type) {
      let params = {
        user_id: this.userId,
        duties: type
      }
      setUserPower(params).then(data => {
        if (data.status === 'success') {
          this.isShow = false
          this.$message.success(this.$t('department.notify.setDutySuccess'))
          this.currentUserData.slots.icon = type === 0 ? 'user' : 'user-duties-' + type
        } else {
          this.$message.error(this.$t('department.notify.setDutyError'))
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    changeState (index) {
      let vm = this
      let mask = vm.$refs['item' + index]
      mask.style.background = '#e6f7ff'
    },
    resetState (index) {
      let vm = this
      let mask = vm.$refs['item' + index]
      mask.style.background = '#fff'
    },
    canDo,
    hideMenu () {
      this.isShow = false
    },
    filterTreeNode (node) {
      if (this.expandedKeys.includes(node.eventKey)) {
        if (node.dataRef.loaded !== true && node.dataRef.children.length !== 0) {
          this.onLoadData(node)
        }
        return true
      }
    },
    onChange (e) {
      const value = e.target.value
      this.expandedKeys = []
      this.autoExpandParent = true
      if (value === '') {
        this.searchValue = ''
        this.expandedKeys = []
        return
      }
      this.searchValue = value
      let self = this
      this.timer = searchUserList(this.timer, value, function (data) {
        data.data.users.map(user => {
          if (user.dept_id > 0) {
            self.expandedKeys.push(user.dept_id.toString())
          }
        })
        self.treeData.map((item) => {
          self.getParentKey(value, [item])
        })
      })
    },
    onLoadData (treeNode) {
      return new Promise((resolve) => {
        let id = treeNode.dataRef.key
        treeNode.dataRef.loaded = true
        getDepartmentUsers(id, { is_direct: 1 }).then(data => {
          if (data.status === 'success') {
            let users = data.data.users
            let children = treeNode.dataRef.children
            for (let i in users) {
              if (users[i]['pivot']['department_id'] === Number(id)) {
                let params = {
                  key: 'user-' + treeNode.dataRef.key + '-' + users[i]['id'],
                  title: users[i]['name'],
                  slots: { icon: Number(users[i]['duties']) === 0 ? 'user' : 'user-duties-' + users[i]['duties'] },
                  scopedSlots: { title: 'title', isLeaf: 'isLeaf' },
                  type: 'user',
                  isLeaf: true,
                  department: id,
                  duties: Number(users[i]['duties']),
                  basic_department: users[i]['basic_department']['id']
                }
                children.push(params)
              }
            }
            if (children.length > 0) {
              treeNode.dataRef.children = children
            }
            this.treeData = [...this.treeData]
            resolve()
          } else {
            treeNode.dataRef.loaded = false
            resolve()
            this.$message.error(this.$t('department.notify.getInfoError'))
          }
        }).catch(error => {
          treeNode.dataRef.loaded = false
          resolve()
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      })
    },
    getLevelData () {
      getAllDepartmentData().then(data => {
        if (data.status === 'success') {
          this.treeData = []
          let departments = data.data.departments
          let child = []
          let tree = []
          for (let i in departments) {
            let parent = departments[i]['parent_id']
            let id = departments[i]['id']
            if (child[id] === undefined) {
              child[id] = []
              tree[id] = []
            }
            if (child[parent] === undefined) {
              child[parent] = []
              tree[parent] = []
            }
            let params = {
              key: id.toString(),
              title: JSON.parse(departments[i]['locale']),
              parent_id: parent,
              scopedSlots: { icon: 'folder', title: 'title' },
              children: child[id]
            }
            let params1 = {
              key: id,
              value: id.toString(),
              title: departments[i]['name'],
              parent_id: parent,
              children: tree[id]
            }
            child[parent].push(params)
            tree[parent].push(params1)
          }
          this.treeData = child[0]
          let selectDepartmentTree = tree[0]
          this.$store.commit('SET_SELECT_DEPART_TREE', selectDepartmentTree)
        } else {
          this.$message.error(this.$t('department.notify.getDepartmentError'))
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    getParentKey (key, tree) {
      let parentKey
      for (let i = 0; i < tree.length; i++) {
        const node = tree[i]
        if (node.children) {
          this.getParentKey(key, node.children)
        }
        if (!node.isLeaf) {
          if ((node.title[this.getLanguage]).toLowerCase().indexOf(key.toLowerCase()) > -1) {
            parentKey = node.key
            this.expandedKeys.push(parentKey)
          }
        }
        // if (this.expandedKeys.includes(node.key.toString())) {
        //   this.expandedKeys.push(node.parent_id.toString())
        // }
      }
    },
    onExpand (expandedKeys) {
      this.expandedKeys = expandedKeys
      this.autoExpandParent = false
    },
    rightClick (event) {
      this.canSetDuty = false
      this.canSetProfiles = false
      this.canSetUsersProfiles = false
      let data = event.node.dataRef
      if (data.isLeaf !== true) {
        return false
      }
      let userInfo = JSON.parse(localStorage.getItem('user'))
      let departmentId = userInfo.basic_department
      if (canDo('users.setDuty')) {
        if (Number(departmentId.id) === Number(data.basic_department)) {
          this.canSetDuty = true
        } else {
          this.canSetDuty = false
        }
      }
      if (canDo('users.setAllDuty')) {
        this.canSetDuty = true
      }
      if (canDo('users.erp.setProfiles')) {
        this.canSetProfiles = true
      }
      if (canDo('users.erp.batchSetProfiles')) {
        this.canSetUsersProfiles = data.duties >= 40 // 主管职级
      }
      if (!this.canSetDuty && !this.canSetProfiles && !this.canSetUsersProfiles) {
        return false
      }
      this.currentUserData = data
      let index = data.key.lastIndexOf('-')
      let id = data.key.substr(index + 1)
      this.userId = id
      this.isShow = true
      this.menuStyle.left = (event.event.x - 3) + 'px'
      if (document.documentElement.clientHeight - event.event.y < 300) {
        this.menuStyle.bottom = (document.documentElement.clientHeight - event.event.y - 3) + 'px'
        delete this.menuStyle.top
      } else {
        this.menuStyle.top = (event.event.y - 3) + 'px'
        delete this.menuStyle.bottom
      }
      let selectKey = [event.node.eventKey]
      this.selectKey = selectKey
    },
    setPermission () {
      bus.$emit('showSetPermissionModal', this.userId)
    },
    distributionPermissions () {
      bus.$emit('ShowDistributionPermissionsModal', { department_id: this.currentUserData.basic_department })
    },
    getAllErpProFiles () {
      getErpProfiles().then(data => {
        this.$store.commit('SET_ERP_PROFILES', data.data)
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    }
  },
  created () {
    this.getLevelData()
    this.getAllErpProFiles()
  },
  mounted () {
    bus.$on('updateDepartmentLevelInfo', data => {
      this.getLevelData()
    })
  },
  computed: {
    ...mapGetters(['getLanguage'])
  }
}
</script>

<style scoped>
    .rightClickMenu {
        position: fixed;
        max-height: 300px;
        /*width: 180px;*/
        /*border: 1px solid #e8e8e8;*/
        /*background: #fff;*/
    }
    .MenuItem{
        display: block;
        text-align: left;
        padding: 5px 10px;
        margin: 5px 0;
        color: #333;
    }
    .userDuties10 {
        color: #FF0000
    }
    .userDuties20 {
        color: #0075FF;
    }
    .userDuties30 {
        color: #00FF00;
    }
    .userDuties40 {
        color: #FF7F00;
    }
    .userDuties50 {
        color: #00FFFF;
    }
    .userDuties60 {
        color: #9008FF;
    }
</style>
