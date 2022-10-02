import Vue from 'vue'
import VueI18n from 'vue-i18n'
import messages from './message'

Vue.use(VueI18n)

const i18n = new VueI18n({
  locale: localStorage.getItem('language') || 'zh-CN', // set locale
  messages // set locale messages
})

export default i18n
