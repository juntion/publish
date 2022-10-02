<template>
  <div :style="!$route.meta.hiddenHeaderContent ? 'margin: -24px -24px 0px;' : null"
       class="pageView">
    <page-header v-if="!$route.meta.hiddenHeaderContent">
      <div slot="pageMenu">
        <div v-if="tabs && tabs.items">
          <a-tabs :tabBarStyle="{margin: 0}"
                  :activeKey="tabs.active()"
                  @change="tabs.callback">
            <a-tab-pane v-for="item in tabs.items"
                        :tab="item.title"
                        :key="item.key"></a-tab-pane>
          </a-tabs>
        </div>
      </div>
    </page-header>
    <div class="content">
      <slot>
        <router-view ref="content" :key="$route.fullPath"/>
      </slot>
    </div>
    <div class="copyRight">{{getYear}}</div>
  </div>
</template>

<script>
import PageHeader from './components/PageHeader'

export default {
  name: 'PageView',
  components: {
    PageHeader
  },
  props: {
    title: {
      type: [String, Boolean],
      default: true
    }
  },
  computed: {
    getYear () {
      let date = new Date()
      let y = date.getFullYear()
      return 'Copyright © 2009-' + y + ' FS.COM All Rights Reserved.'
    }
  },
  data () {
    return {
      tabs: {}
    }
  },
  mounted () {
    this.getPageMeta()
  },
  updated () {
    this.getPageMeta()
  },
  methods: {
    getPageMeta () {
      // eslint-disable-next-line
      const content = this.$refs.content
      if (content) {
        if (content.pageMeta) {
          Object.assign(this, content.pageMeta)
        } else {
          this.tabs = content.tabs
        }
      }
    }
  }
}
</script>

<style lang="less" scoped>
/deep/.ant-select-selection--multiple {
  height: 100% !important;
}

/deep/.el-input--prefix .el-input__inner {
  height: 32px;
}

.copyRight {
//   position: fixed;
//   left: 50%;
//   bottom: 0;
//   transform: translateX(-50%);
 text-align: center;
  margin-top: 6px;
  margin-bottom: 20px;
  color: #bbbbbb;
}
.content {
  padding: 24px;
  position: relative;
}

.page-menu-search {
  text-align: center;
  margin-bottom: 16px;
}
</style>
