import axios from 'axios'
import store from '@/store'
import Cookies from 'js-cookie'
import qs from 'qs'
import _ from 'lodash'
import auth, { switchToken } from '../api/auth'

const instance = axios.create({
  baseURL: process.env.VUE_APP_API_URL,
  withCredentials: false,
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
  },
  timeout: 300000
})

instance.setToken = (token) => {
  instance.defaults.headers['Authorization'] = token
}

instance.interceptors.request.use(async (config) => {
  if (config.params && config.params.filters) {
    clean(config.params.filters)
    if (_.keys(config.params.filters).length) {
      let filters = qs.stringify({ 'search': config.params.filters }, { encode: true })
      config.url = config.url + '?' + filters
    }
  }
  if (config.params && config.params.must) {
    if (_.keys(config.params.must).length) {
      let filters = qs.stringify({ 'must': config.params.must }, { encode: true })
      if (config.url.indexOf('?') === -1) {
        config.url = config.url + '?' + filters
      } else {
        config.url = config.url + '&' + filters
      }
    }
  }
  if (config.params && config.params.may) {
    if (_.keys(config.params.may).length) {
      let filters = qs.stringify({ 'may': config.params.may }, { encode: true })
      if (config.url.indexOf('?') === -1) {
        config.url = config.url + '?' + filters
      } else {
        config.url = config.url + '&' + filters
      }
    }
  }
  if (_.includes(_.keys(config.params), 'filters')) delete config.params.filters
  switchToken()
  config.headers['Authorization'] = Cookies.get('token') || null
  config.headers['Accept-Language'] = localStorage.getItem('language') || 'zh-CN'
  return config
}, (error) => {
  return Promise.reject(error)
})

// 是否正在刷新的标记
let isRefreshing = false
let isRefreshAuth = false
// 重试队列，每一项将是一个待执行的函数形式
const requests = []

instance.interceptors.response.use(async (res) => {
  // 如果返回信息带有 Refresh-Flag 自动刷新信息并提示
  let refreshFlag = res.headers['refresh-flag']
  if (!isRefreshAuth && refreshFlag !== undefined && Number(refreshFlag) !== 0) {
    isRefreshAuth = true
    await store.dispatch('noticeUserHasBeenUpdate', Number(refreshFlag))
    isRefreshAuth = false
  }
  return res.data
}, (error) => {
  if (error.response && error.response.status === 401) {
    if (localStorage.getItem('token')) { // token失效但是 localStorage 的token还在，可以去换取新的token
      const config = error.response.config
      if (!isRefreshing) { // 没有进行刷新token
        isRefreshing = true
        return auth.refreshToken().then(data => {
          let token = data.data.data.token_type + ' ' + data.data.data.access_token
          instance.setToken(token)
          requests.forEach(cb => cb(token))
          config.headers['Authorization'] = token
          return instance(config)
        }).catch(error => {
          store.commit('AUTH_LOGOUT')
          return new Promise(() => {
            window.Bus.$message.warning({ content: window.Bus.$root.$t('auth.unauthorized'), key: 'Unauthorized' })
            window.Bus.$router.push('/auth/login')
          })
        }).finally(() => {
          isRefreshing = false
        })
      } else {
        // 正在刷新token
        return new Promise((resolve) => {
          requests.push((token) => {
            config.headers['Authorization'] = token
            resolve(instance(config))
          })
        })
      }
    } else {
      store.commit('AUTH_LOGOUT')
      return new Promise(() => {
        window.Bus.$message.warning({ content: window.Bus.$root.$t('auth.unauthorized'), key: 'Unauthorized' })
        window.Bus.$router.push('/auth/login')
      })
    }
  } else if (error.response && error.response.status === 422) {
    if (typeof error.response.data['errors'] !== 'undefined') {
      let message = ''
      _.forEach(error.response.data['errors'], function (item) {
        _.forEach(item, function (msg) {
          message += msg + ' '
        })
      })
      error.response.data['message'] += '：' + message
    }
  }
  return Promise.reject(error)
})

function clean (obj) {
  for (let propName in obj) {
    if (obj.hasOwnProperty(propName) && _.includes([null, undefined, ''], obj[propName])) {
      delete obj[propName]
    }
  }
}

export default instance
