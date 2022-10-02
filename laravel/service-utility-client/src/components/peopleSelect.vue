<template>
  <div style=" position: relative;" class="eidt-expend">
    <a-tree-select v-show="show"
                   :getPopupContainer="triggerNode => triggerNode.parentNode"
                   style="width:100%"
                   :id="randomId"
                   autoFocus
                   labelInValue
                   :dropdownStyle="{ maxHeight: '400px', overflow: 'auto' }"
                   :treeData="treeData"
                   placeholder="请选择"
                   v-model="value1"
                   :showArrow="false"
                   @treeExpand="expand"
                   :loadData="loadData"
                   @change="sendData1">
    </a-tree-select>
    <a-select v-show="!show"
              showSearch
              :autoFocus="autoFocus"
              v-model="value2"
              placeholder="请选择"
              style="width: 100%"
              :defaultActiveFirstOption="false"
              :showArrow="false"
              :filterOption="false"
              @blur="handleBlur"
              @change="sendData2"
              :getPopupContainer="triggerNode => triggerNode.parentNode"
              @search="search">
      <a-select-option v-for="d in searchUser"
                       :key="d.id">{{d.name}}</a-select-option>
    </a-select>
    <span class="iconfont expend"
          :class="{active:show}"
          @click="showTree">&#xe660;</span>
  </div>
</template>
<style lang="less" scoped>
.expend {
  cursor: pointer;
  position: absolute;
  font-size: 10px;
//   top: 1px;
  right: 10px;
}
.eidt-expend .expend{
    // top: 8px;

}
.active {
  color: #378eef;
}
</style>
<script>

import { getDepartmentsTree, searchUserList } from '@/api/userManage/index.js'
import { getDepartmentUsers } from '@/api/department/index.js'
let a = ''
export default {
  data () {
    return {
      show: false,
      value1: undefined,
      value2: this.valueData,
      treeData: [],
      searchUser: this.searchData
    }
  },
  computed: {
    randomId () {
      var Num = ''
      for (var i = 0; i < 6; i++) {
        Num += Math.floor(Math.random() * 10)
      }
      return Num
    }
  },
  watch: {
    valueData (newVal, oldVal) {
      this.value2 = newVal
    },
    value2 () {
      this.sendData2()
    },
    searchData (newVal, oldVal) {
      this.searchUser = newVal
    }
  },
  props: {
    autoFocus: {
      type: Boolean
    },
    valueData: {

    },
    searchData: {
      type: Array
    }
  },

  created () {
    getDepartmentsTree().then(res => {
      //   console.log('+++++++')
      this.treeData = this.deepTreeData([], res.data.trees)
    })
  },
  methods: {
    handleBlur (data) {
      this.$emit('onblur', data)
    },
    sendData1 (e) {
      if (this.value1) {
        this.value2 = this.value1.value.replace('user-', '')
        a = this.value1.label
        this.searchUser = [{ id: this.value2, name: a }]
      }
      this.$emit('getValue1', this.value1.value)
    },
    sendData2 () {
      if (this.searchUser && this.searchUser.length && !this.show) {
        this.searchUser.forEach(item => {
          if (item.id === this.value2) {
            a = item.name
          }
        })
      }
      this.$emit('getValue2', this.value2, a)
    },
    // 遍历接口数据改造成树形菜单
    deepTreeData (treeData = [], data) {
      data.forEach(ele => {
        let parentObj = {}
        parentObj.title = ele.name
        parentObj.key = ele.id
        parentObj.value = ele.id.toString()
        parentObj.selectable = false
        treeData.push(parentObj)
        if (ele.children && ele.children.length !== 0) {
          let arr = []
          this.deepTreeData(arr, ele.children)
          parentObj.children = arr
        } else {
          parentObj.children = []
        }
      })
      return treeData
    },
    expand (e) {

    },
    search (e) {
      this.$nextTick(() => {
        let self = this
        this.timer = searchUserList(this.timer, e, function (data) {
          self.searchUser = data.data.users
        })
      })
    },
    loadData (treeNode) {
      //   console.log(treeNode.dataRef)
      // 异步加载人员数据
      return new Promise((resolve) => {
        let id = treeNode.dataRef.key
        getDepartmentUsers(id, { is_direct: 1 }).then(data => {
          if (data.status === 'success') {
            // let users = data.data.users
            let users = this.deepTreeData([], data.data.users)
            let children = treeNode.dataRef.children
            users.forEach(user => {
              user.isLeaf = true
              user.key = 'user-' + user.key
              user.value = 'user-' + user.value
              user.selectable = true
              children.push(user)
            })
            // console.log(children)
            if (children.length > 0) {
              treeNode.dataRef.children = children
            }
            this.treeData = [...this.treeData]
            resolve()
          }
        }).catch(error => {
          resolve()
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      })
    },
    showTree () {
      this.show = !this.show
      if (this.show) {
        document.getElementById(this.randomId).click()
      }
    }
  }
}
</script>
