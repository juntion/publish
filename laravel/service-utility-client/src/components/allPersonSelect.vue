<template>
  <div class="all-person-select">
    <a-select :placeholder="pText"
              :title="pText"
              :disabled="getDisabled"
              showSearch
              :autoFocus="autoFocus"
              :allowClear="getClear"
              :defaultActiveFirstOption="false"
              :filterOption="false"
              :getPopupContainer="triggerNode => triggerNode.parentNode"
              v-model="value"
              @search="search"
              @blur="handleBlur"
              @change="sendData"
              >
              <a-select-option v-for="d in searchUser" :key="d.id">{{ d.name }}</a-select-option>
    </a-select>
  </div>
</template>

<script>
import { searchUserList } from '@/api/userManage/index.js'

export default {
  data () {
    return {
      text: '请输入英文名搜索',
      searchUser: this.searchData,
      value: this.selectValue,
      name: '',
      timer: 600
    }
  },
  props: {
    placeholder: {
      type: String
    },
    disabled: {
      type: Boolean
    },
    autoFocus: {
      type: Boolean
    },
    allowClear: {
      type: Boolean
    },
    selectValue: {

    },
    searchData: {
      type: Array
    },
    index: {}
  },
  computed: {
    pText () {
      if (this.placeholder !== undefined) {
        return this.placeholder
      } else {
        return this.text
      }
    },
    getDisabled () {
      return this.disabled ? this.disabled : false
    },
    getClear () {
      return this.allowClear ? this.allowClear : false
    }
  },
  watch: {
    selectValue (newVal, oldVal) {
      this.value = newVal
    },
    searchData (newVal, oldVal) {
      this.searchUser = newVal
    },
    value () {
      // 将value放在最后一个监听，因为在初始化阶段会有一个值的改变，需要将接受到的 searchData 赋值到 searchUser
      this.sendData()
    }
  },
  created () {},
  methods: {
    search (e) {
      this.$nextTick(() => {
        let self = this
        this.timer = searchUserList(this.timer, e, function (data) {
          self.searchUser = data.data.users
        })
      })
    },
    sendData () {
      if (this.searchUser && this.searchUser.length > 0) {
        this.searchUser.forEach(item => {
          if (item.id === this.value) {
            this.name = item.name
          }
        })
      }
      this.$emit('getSelectValue', { id: this.value, name: this.name, index: this.index })
    },
    handleBlur (data) {
      this.$emit('onblur', data)
    }
  }
}
</script>
<style lang="less" scoped>
.all-person-select {
  display: inline-block;

  /deep/ .ant-select {
    width: 100%;
  }
}
</style>
