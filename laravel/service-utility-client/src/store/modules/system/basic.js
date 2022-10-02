import { getLoginLogInfo } from '../../../api/system/setting'
import Cookie from 'js-cookie'
import { getDomain } from '../../../plugins/common'

let language = Cookie.get('switch_language')
if (language && language !== localStorage.getItem('language')) {
  Cookie.remove('switch_language', { path: '/', domain: getDomain() })
  localStorage.setItem('language', language)
}

const state = {
  language: localStorage.getItem('language') || 'zh-CN',
  menuCollapse: localStorage.getItem('menuCollapse') === 'true' || false,
  loginLog: [],
  filter: {}
}

const mutations = {
  SET_LANGUAGE: (state, language) => {
    state.language = language
    localStorage.setItem('language', language)
  },
  SET_MENU_COLLAPSE: (state, collapse) => {
    state.menuCollapse = collapse
    localStorage.setItem('menuCollapse', collapse)
  },
  REMOVE_ALL_SYSTEM_ENUM: (state) => {
    state.logisticsPatterns = []
    localStorage.removeItem('_logistics_patterns')
  },
  SET_LOGINLOG_LIST: (state, data) => {
    state.loginLog = data.data
  }
}

const actions = {
  setLanguage ({ commit }, language) {
    commit('SET_LANGUAGE', language)
  },
  setMenuCollapse ({ commit }, collapse) {
    commit('SET_MENU_COLLAPSE', collapse)
  },
  initSystemEnum: async ({ dispatch }) => {
  },
  loginLogInfo: async ({ commit }) => {
    let data = await getLoginLogInfo({ filters: state.filter })
    commit('SET_LOGINLOG_LIST', data)
  }
}

const getters = {
  getLanguage: state => state.language,
  getMenuCollapse: state => state.menuCollapse,
  getLoginLog: state => state.loginLog
}

export default {
  state,
  mutations,
  actions,
  getters
}
