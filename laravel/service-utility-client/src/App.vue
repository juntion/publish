<template>
  <div id="app">
    <a-config-provider :locale="language">
      <router-view></router-view>
    </a-config-provider>
  </div>
</template>

<script>
import cn from 'ant-design-vue/lib/locale-provider/zh_CN'
import en from 'ant-design-vue/lib/locale-provider/en_US'

export default {
  name: 'app',
  data () {
    return {
      timer: null
    }
  },
  computed: {
    language () {
      return this.$store.getters.getLanguage === 'zh-CN' ? cn : en
    }
  }
}
</script>
<style lang="less">
html,
body,
#app {
  height: 100%;
}

/deep/ .el-dialog__header {
  padding: 12px 20px;
  border-bottom: 1px solid #eeeeee;
}

.ant-tree-node-content-wrapper {
  width: 100%;
}
.el-popper .popper__arrow,
.el-popper .popper__arrow::after {
  border: 0;
}
.ant-select-dropdown.ant-select-tree-dropdown.ant-select-dropdown--single.ant-select-dropdown-placement-bottomLeft {
  /*left: 0 !important;*/
  /*top: 0 !important;*/
  max-height: 500px !important;
}
.ant-select-dropdown.ant-select-tree-dropdown.ant-select-dropdown--multiple.ant-select-dropdown-placement-bottomLeft {
  max-height: 500px !important;
}
.ant-btn-primary {
  background: #378eef !important;
}
</style>
