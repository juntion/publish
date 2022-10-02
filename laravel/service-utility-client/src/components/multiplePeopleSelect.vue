<template>
  <div>
    <div style=" position: relative;">
      <a-tree-select v-show="show"
                     multiple
                     :id="randomId"
                     :getPopupContainer="triggerNode => triggerNode.parentNode"
                     style="width: 100%;"
                     :dropdownStyle="{ maxHeight: '400px', overflow: 'auto' }"
                     :treeData="treeData"
                     placeholder="请选择"
                     v-model="value"
                     :showArrow="false"
                     @treeExpand="expand"
                     :loadData="loadData"
                     @change="sendData1">
      </a-tree-select>
      <a-select v-show="!show"
                showSearch
                mode="multiple"
                v-model="value2"
                placeholder="请选择"
                style="width: 100%"
                :defaultActiveFirstOption="false"
                :showArrow="false"
                :getPopupContainer="triggerNode => triggerNode.parentNode"
                :filterOption="false"
                @search="search"
                @change="sendData2">
        <a-select-option v-for="d in searchUser"
                         :key="d.id">{{d.name}}</a-select-option>
      </a-select>
      <span class="iconfont expend"
            :class="{active:show}"
            @click="showTree">&#xe660;</span>
    </div>
  </div>
</template>
<style lang="less" scoped>
/deep/.ant-select-selection--multiple{
    min-height: 32px;
}
.expend {
  cursor: pointer;
  position: absolute;
  top: 1px;
  font-size: 10px;
  right: 10px;
}
.active {
  color: #378eef;
}
</style>
<script>

import { getDepartmentsTree, searchUserList } from '@/api/userManage/index.js'
import { getDepartmentUsers } from '@/api/department/index.js'

export default {
  data () {
    return {
      show: false,
      value: [],
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
  model: [{
    prop: 'valueData',
    event: 'getValue2'
  }],

  watch: {

    valueData (newVal, oldVal) {
      this.value2 = newVal
    },
    searchData (newVal, oldVal) {
      this.searchUser = newVal
    },
    value2 () {
      this.sendData2()
    }
  },
  props: {
    autoFocus: {
      type: Boolean
    },
    valueData: {
      type: Array
    },
    searchData: {
      type: Array
    }

  },
  created () {
    getDepartmentsTree().then(res => {
      this.treeData = this.deepTreeData([], res.data.trees)
    })
  },
  methods: {
    sendData1 () {
      this.$emit('getValue1', this.value)
      if (this.value) {
        this.value2 = this.value.map(item => {
          return item.replace('user-', '')
        })
      }
    },
    sendData2 () {
      this.$emit('getValue2', this.value2)
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

      // 调用接口 res
      //   getDepartmentUsers(e[e.length - 1], { is_direct: 1 }).then(res => {
      //     console.log('----')
      //     let result = this.deepTreeData([], res.data.users)
      //     // console.log(result)
      //     //  this.treeData[2].children = result
      //   })
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
      return new Promise((resolve) => {
        let id = treeNode.dataRef.key
        getDepartmentUsers(id, { is_direct: 1 }).then(data => {
          if (data.status === 'success') {
            let users = this.deepTreeData([], data.data.users)
            let children = treeNode.dataRef.children
            users.forEach(user => {
              user.isLeaf = true
              user.key = 'user-' + user.key
              user.value = 'user-' + user.value
              user.selectable = true
              children.push(user)
            })
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
