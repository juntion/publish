import axios from '@/plugins/axios'
import { getDomain } from '../../plugins/common'
import a from 'axios'
import Cookies from 'js-cookie'
import md5 from 'blueimp-md5'

const Auth = {
  // 供应商登录
  login: (params) => {
    return axios.post('/auth/login', params)
  },
  // 供应商登录
  logout: () => {
    return axios.post('auth/logout')
  },
  // 发送重置密码邮件
  passwordEmail: (params) => {
    return axios.post('/auth/password/email', params)
  },
  // 供应商密码重置
  passwordReset: (params) => {
    return axios.post('/auth/password/reset', params)
  },
  userInfo: (params) => {
    return axios.get('/userInfo', {
      params
    })
  },
  checkTokenAvailable: () => {
    return axios.get('/amILogin')
  },
  refreshToken: () => {
    let token = localStorage.getItem('token')
    let instance = a.create({
      baseURL: process.env.VUE_APP_API_URL,
      withCredentials: false,
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': token
      },
      timeout: 100000
    })
    return instance.post('/auth/refresh/0').then(data => {
      let remember = localStorage.getItem('token') ? 1 : 0
      window.Bus.$store.commit('LOGIN_SUCCESS', { data: data.data.data, remember: remember })
      window.Bus.$ws.connect()
      return data
    })
  },
  webSocketBind: (params) => {
    return axios.post('/webSocket/bind', params)
  }
}

export default Auth

export const sendMail = (params) => {
  return axios.post('/auth/validateCodeEmail', params)
}

// 验证token是否有效
export const checkToken = async () => {
  let res = false
  await Auth.checkTokenAvailable().then(data => {
    if (data.status === 'success') {
      res = data.data.ticket
    } else {
      res = false
    }
  }).catch(error => {
    res = false
  })
  return res
}

export const switchToken = (token) => {
  // 当 ERP 存在账号切换操作时
  let switchToken = token || Cookies.get('switch_token')
  if (switchToken) {
    switchToken = 'Bearer ' + switchToken
    Cookies.remove('switch_token', { path: '/', domain: getDomain() })
    Cookies.set('token', switchToken)
    Cookies.set('client_group', md5(switchToken), { path: '/', domain: getDomain() })
    if (localStorage.getItem('token')) {
      localStorage.setItem('token', switchToken)
    }
    window.Bus.$store.dispatch('refresh')
    window.Bus.$ws.close()
    window.Bus.$ws.connect()
  }
}
