<template>
  <a-layout-sider
    class="sider"
    :theme="theme"
    :trigger="null"
    collapsible
    v-model="getMenuCollapse"
    width="245px">
    <div class="menu">
      <div class="logo">
        <div class="logo-img" :class="{ 'fold-img': getMenuCollapse }">
          <img src="../../../assets/images/logo.svg" alt="logo">
        </div>
      </div>
      <a-menu
        class="menu-content"
        mode="inline"
        :theme="theme"
        v-model="selectedKeys"
        :defaultOpenKeys="openKeys"
        :forceSubMenuRender="false"
        @click="handleSelect">
        <template v-for="item in templateData">
          <a-menu-item v-if="!item.children" :key="item.key">
            <a-icon :type="item.type" />
            <span>{{JSON.parse(item.locale)[getLanguage]}}</span>
          </a-menu-item>
          <SubMenu v-else :menu-info="item" :key="item.key" :language="getLanguage"/>
        </template>
      </a-menu>
    </div>
  </a-layout-sider>
</template>

<script>
import { mapGetters } from 'vuex'
import { formatDataTree } from '../../../plugins/common'
import SubMenu from '../../../components/SubMenu'
import { bus } from '../../../plugins/bus'

export default {
  name: 'Aside',
  components: { SubMenu },
  data () {
    return {
      theme: 'light',
      selectedKeys: [],
      templateData: []
    }
  },
  computed: {
    ...mapGetters(['getMenuCollapse', 'getLanguage']),
    openKeys () {
      return this.getMenuCollapse ? [] : ['order', 'communicate', 'user']
    }
  },
  created () {
    this.updateMenu()
    this.getTemplateData()
  },
  watch: {
    '$route' () {
      this.updateMenu()
    }
  },
  methods: {
    handleSelect (item) {
      this.$router.push({
        name: item.key
      })
    },
    updateMenu () {
      const routes = this.$route.matched.concat()
      //   if (routes.length >= 4) {
      //     routes.pop()
      //     this.selectedKeys = [routes[2].name]
      //   } else {
      //     this.selectedKeys = [routes.pop().name]
      //   }
      this.selectedKeys = []
      routes.forEach(item => {
        this.selectedKeys.push(item.name)
      })
    },
    localeName (item) {
      if (!item.locale) return item.name
      const localName = JSON.parse(item.locale)
      return localName[this.$i18n.locale] || item.name
    },
    getTemplateData () {
      let sidebars = JSON.parse(localStorage.getItem('sidebars'))
      if (sidebars.length === 0) {
        this.templateData = []
      } else {
        this.templateData = formatDataTree(sidebars)
      }
    }
  },
  mounted () {
    bus.$on('updateMenu', data => {
      this.getTemplateData()
    })
  }
}
</script>

<style scoped lang="less">
  .sider {
    background-color: #fff;
    -webkit-box-shadow: 2px 0 8px 0 rgba(29, 35, 41, 0.05);
    box-shadow: 2px 0 8px 0 rgba(29, 35, 41, 0.05);
    overflow-y: auto;
    .menu {
      padding-top: 64px;

      .logo {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 64px;
        padding: 12px 0 0 20px;
        -webkit-transition: all 0.3s;
        transition: all 0.3s;
        overflow: hidden;
        z-index: 9;
        background: #fff;
        -webkit-box-shadow: 1px 1px 0 0 #e8e8e8;
        box-shadow: 1px 1px 0 0 #e8e8e8;

        .logo-img {
          float: left;
          overflow: hidden;

          img {
            display: block;
            height: 40px;
            margin: 0 auto 10px;
          }
        }

        .logo-img.fold-img {
          width: 40px;
        }
      }

      .menu-content {
        padding: 12px 0;
        border-right-color: transparent;
      }
    }
  }
</style>
