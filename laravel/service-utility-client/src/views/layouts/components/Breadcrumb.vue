<template>
  <div class="breadcrumb">
    <a-breadcrumb>
      <a-breadcrumb-item v-for="(item, index) in breadList"
                         :key="item.name">
        <router-link v-if="item.name != name && index != 1"
                     :to="{ path: item.path === '' ? '/' : item.path }">
          {{ $t('routers.' + item.name) }}
        </router-link>
        <span v-else>{{ $t('routers.' + item.name) }}</span>
      </a-breadcrumb-item>
    </a-breadcrumb>
    <div class="pm project"
         v-if="show">
      <router-link :to="{name:'editionManagement'}"
                   class="left">发版管理</router-link> <i class="short-line"></i>
      <router-link :to="{name:'ProIndex'}"
                   class="left right">主视图</router-link> <i class="short-line"></i>
      <router-link :to="{name:'relationship'}"
                   class="right">绑定关系</router-link>
    </div>
    <div class="project"
         v-if="show2">
      <!-- <router-link :to="{name:item.path}" v-for="(item,index) in proLists" :key="index" class="toNav">{{item.classify}}</router-link> -->
      <router-link :to="{name:'projectHome'}"
                   class="toNav">首页</router-link> <i class="short-line"></i>
      <router-link :to="{name:'projectDemandList'}"
                   class="toNav">需求列表</router-link> <i class="short-line"></i>
      <router-link :to="{name:'projectTaskList',query:{project:1}}"
                   class="toNav">任务列表</router-link>
    </div>
    <div class="recout-title project"
         v-show="showrecount">
      <router-link :to="{name:'recountindex'}"
                   class="left">诉求列表</router-link> <i class="short-line"></i>
      <router-link :to="{name:'recountAnalysis'}"
                   class="right">统计分析</router-link>
    </div>
     <div class="recout-title project"
         v-show="showBug">
      <router-link :to="{name:'bugProduct'}"
                   class="left">生产版本</router-link> <i class="short-line"></i>
      <router-link :to="{name:'bugTest'}"
                   class="right">测试版本</router-link>
    </div>
    <div class="recout-title project"
         v-if="showProduct">
      <router-link :to="{name:'demandList'}"
                   class="left">需求列表</router-link> <i class="short-line"></i>
      <router-link :to="{name:'task'}"
                   class="right">任务</router-link>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      activeNum: -1,
      proLists: [
        { path: 'project', classify: '首页' },
        { path: 'projectDemandList', classify: '需求列表' },
        { path: 'projectTaskList', classify: '任务列表' }
      ],
      name: '',
      breadList: [],
      show: this.$route.path.indexOf('/ProductMaintenance') !== -1,
      show2: this.$route.path.indexOf('/project') !== -1,
      showProduct: this.$route.path.indexOf('/product') !== -1,
      showrecount: this.$route.path.indexOf('/recount') !== -1,
      showBug: this.$route.path.indexOf('/bug') !== -1
    }
  },
  created () {
    this.getBreadcrumb()
    // console.log(this.breadList);
  },
  methods: {
    getBreadcrumb () {
      this.breadList = []
      this.name = this.$route.name
      this.$route.matched.forEach(item => {
        this.breadList.push(item)
      })
    },
    toNav (item, index) {
      this.$router.push({ name: item.path })
      this.activeNum = index
    }
  },
  watch: {
    $route (to, from) {
      this.getBreadcrumb()
      if (to.path !== from.path) {
        this.show = this.$route.path.indexOf('/ProductMaintenance') !== -1
        this.showrecount = this.$route.path.indexOf('/recount') !== -1
        this.showProduct = this.$route.path.indexOf('/product') !== -1
        this.show2 = this.$route.path.indexOf('/project') !== -1
        this.showBug = this.$route.path.indexOf('/bug') !== -1
      }
    }
  }
}
</script>

<style lang="less" scoped>
.short-line {
  width: 1px;
  height: 20px;
  background: rgba(238, 238, 238, 1);
  position: absolute;
  top: -3px;
}
.toNav {
  color: #333;
  margin: 20px;
  text-decoration: none;
    font-size: 14px;
}
.project {
  .router-link-active {
    color: #378eef !important;
  }
}
.project {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
    a{
        font-size: 14px;
    }
}
.title {
  font-size: 20px;
  font-weight: bolder;
  margin-right: 20px;
}
.breadcrumb {
  position: relative;
  & a:hover{
      color: #378EEF !important;
  }
}
.pm,
.recout-title {
  font-family: Microsoft YaHei;
  font-weight: 400;
  color: rgba(51, 51, 51, 1);
  font-size: 14px;
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}
.pm a,
.recout-title a {
  color: rgba(51, 51, 51, 1);
  text-decoration: none;
    font-size: 14px;
}
.left {
  margin-right: 20px;
}
.right {
  margin-left: 20px;
}
</style>
