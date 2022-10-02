import Vue from 'vue'
import App from './App.vue'
import router from './router/index'
import store from './store/index'
import i18n from './lang'
import Antd from 'ant-design-vue'
import publicJS_ from './plugins/public.js'
import 'ant-design-vue/dist/antd.css'
import 'babel-polyfill'
import '@/assets/css/public.less'
import '@/assets/css/erpFrameStyle.less'
import '@/assets/css/erpSelfStyle.less'
import '@/assets/iconfont/iconfont.css'
import echarts from 'echarts'
// import ElementUI from 'element-ui'
import { Button, Dialog, Form, FormItem, Input, Radio,
  Tabs, TabPane, Switch, Checkbox, Dropdown, DatePicker,
  DropdownMenu, DropdownItem, InfiniteScroll, TimeSelect,
  TimePicker } from 'element-ui'

import 'element-ui/lib/theme-chalk/index.css'
import 'viewerjs/dist/viewer.css'
import Viewer from 'v-viewer'
import ws from './plugins/push/index'

// import './mockjs/index.js'

Viewer.setDefaults({
  navbar: false,
  toolbar: false
})
Vue.directive('title', {
  inserted: function (el, binding) {
    document.title = el.dataset.title
  }
})
Vue.use(Button)
Vue.use(Dialog)
Vue.use(Form)
Vue.use(FormItem)
Vue.use(Input)
Vue.use(Radio)
Vue.use(Tabs)
Vue.use(TabPane)
Vue.use(Switch)
Vue.use(Checkbox)
Vue.use(Dropdown)
Vue.use(DropdownMenu)
Vue.use(DropdownItem)
Vue.use(DatePicker)
Vue.use(InfiniteScroll)
Vue.use(TimePicker)
Vue.use(TimeSelect)

Vue.prototype.$echarts = echarts

Vue.config.productionTip = false

Vue.use(Antd)

Vue.prototype.publicJS = publicJS_

Vue.use(Viewer)
Vue.prototype.$ws = ws

window.Bus = new Vue({
  router,
  store,
  i18n,
  render: h => h(App)
}).$mount('#app')
