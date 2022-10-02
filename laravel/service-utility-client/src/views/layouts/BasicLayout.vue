<template>
  <a-layout class="layout">
    <Aside class="eidt-2"></Aside>
    <a-layout>
      <Header></Header>
      <a-layout-content :style="{ height: '100%', margin: '24px 24px 0', paddingTop: '0' }">
        <transition name="page-transition">
          <router-view></router-view>

        </transition>
      </a-layout-content>
    </a-layout>
  </a-layout>
</template>

<script>
import Aside from './components/Aside'
import Header from './components/Header'

export default {
  name: 'Layout',
  components: { Aside, Header },
  created () {
    this.$ws.connect()
    Notification.requestPermission()
  }

}
</script>

<style scoped>
  .layout {
    height: 100%;
  }

  .page-transition-enter {
    opacity: 0;
  }

  .page-transition-leave-active {
    opacity: 0;
  }

  .page-transition-enter .page-transition-container,
  .page-transition-leave-active .page-transition-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
  }
</style>
