import Ws, { setNotification } from './ws'
import { getDomain } from '../common'
import Auth, { switchToken } from '../../api/auth'
import md5 from 'blueimp-md5'
import Cookie from 'js-cookie'

const ws = new Ws({
  address: process.env.VUE_APP_WEB_SOCKET_ADDRESS,
  heartbeatMessage: '{ "type": "ping", "guard_name": "uums" }'
})

// 注册
ws.register('connect', (data, _this) => {
  _this.client_id = data.client_id || null
  Auth.webSocketBind({ client_id: _this.client_id }).catch(e => {
    window.Bus.$ws.close()
  })
})

// 批量注册
ws.bulkRegister({
  message: (data) => {
    // 将消息使用 MD5 加密作为消息唯一标识
    let sign = md5(JSON.stringify(data))
    window.Bus.$notification['info']({
      message: data.type,
      description: data.data,
      placement: 'bottomRight',
      key: sign
    })
    setNotification({
      title: '这是一个通知',
      body: data.data,
      tag: sign,
      onclick: (e, notify) => {
        notify.close()
      }
    })
  },
  logout: () => {
    window.Bus.$store.commit('AUTH_LOGOUT')
    window.Bus.$router.push('/auth/login')
  },
  close: () => {
    window.Bus.$ws.close()
  },
  // 切换语言
  switchLang: (data) => {
    setTimeout(function () {
      let lang = data.language || Cookie.get('switch_language')
      Cookie.remove('switch_language', { path: '/', domain: getDomain() })
      window.Bus.$i18n.locale = lang
      window.Bus.$store.dispatch('setLanguage', lang)
    })
  },
  //  切换账号
  switchToken: (data) => {
    setTimeout(function () {
      switchToken(data.token)
    })
  },
  notification: (data) => {
    // 系统桌面通知
    setNotification({
      title: data.title,
      body: data.content,
      // 将消息使用 MD5 加密作为通知唯一标识
      tag: md5(JSON.stringify(data))
    })
    window.Bus.$notification.info({
      message: data.title,
      description: data.content,
      placement: 'topRight',
      duration: 10
    })
  }
})

export default ws
