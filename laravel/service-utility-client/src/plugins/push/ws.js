import { getDomain } from '../common'
import Cookies from 'js-cookie'

export default class Ws {
  constructor (options) {
    options = options || {}
    this.address = options.address || null
    this.maxReconnection = options.maxReconnection || 10 // 最大重连次数
    this.onHeartbeat = options.onHeartbeat || null // 自定义心跳函数
    this.heartbeatMessage = options.heartbeatMessage || '{"type":"ping"}' // 心跳消息
    this.heartbeatInterval = options.heartbeatInterval || 50000 // 心跳间隔时间
    this.reconnectInterval = options.reconnectInterval || 5000 // 重连间隔时间
    this.socket = null
    this.connectionTimes = 0 // 连接次数
    this.reconnectionTimes = 0 // 重连次数
    this.actions = {}
    this.client_id = null
    this.heartbeatTimer = null
    this.reconnectTimer = null
    this.reconnect = true
  }

  connect () {
    if ((this.socket !== null && this.socket.readyState !== 3) || this.address === null) return

    this.socket = new WebSocket(this.address)
    // 连接成功
    this.socket.onopen = (e) => {
      if (this.reconnect === false) this.reconnect = true
      this.startHeartbeat()
      this.stopReconnect()
    }

    // 连接断开
    this.socket.onclose = (e) => {
      this.stopHeartbeat()
      if (this.reconnect === true) {
        this.startReconnect()
      }
    }

    // 服务端主动推送消息时会触发这里的onmessage
    this.socket.onmessage = (e) => {
      // json数据转换成js对象
      let data = JSON.parse(e.data)
      let type = data.type || ''
      if (type) {
        let action = this.actions[type]
        if (typeof action !== 'function') {
          console.log('WebSocket ' + type + ' 方法未注册')
          return
        }
        action(data, this, e)
      }
    }
  }

  close () {
    this.reconnect = false
    if (this.socket) {
      this.socket.close()
      this.socket = null
      this.client_id = null
    }
  }

  // 心跳检测
  startHeartbeat () {
    if (!this.heartbeatTimer) {
      this.heartbeatTimer = setInterval(() => {
        if (typeof this.onHeartbeat === 'function') {
          this.onHeartbeat(this)
        } else {
          this.socket.send(this.heartbeatMessage)
        }
      }, this.heartbeatInterval)
      this.connectionTimes++
      console.info('与服务端连接成功，开启心跳检测')
    }
  }

  stopHeartbeat () {
    if (this.heartbeatTimer) {
      clearInterval(this.heartbeatTimer)
      this.heartbeatTimer = null
      console.log('断开连接，关闭心跳检测')
    }
  }

  // 断线重连
  startReconnect () {
    if (!this.reconnectTimer) {
      this.reconnectTimer = setInterval(() => {
        if (this.maxReconnection > this.reconnectionTimes) {
          this.reconnectionTimes++
          this.connect()
        } else {
          this.stopReconnect()
          console.log('重连失败！')
        }
      }, this.reconnectInterval)
      if (this.connectionTimes > 0) {
        console.log('断线重连中···')
      } else {
        console.log('连接服务器失败，等待重新连接···')
      }
    }
  }

  stopReconnect () {
    if (this.reconnectTimer) {
      clearInterval(this.reconnectTimer)
      this.reconnectTimer = null
      this.reconnectionTimes = 0
    }
  }

  // 添加onmessage中各类型消息对应处理的方法
  register (type, callback) {
    this.actions[type] = callback
  }

  bulkRegister (callbacks) {
    for (let type in callbacks) {
      if (callbacks.hasOwnProperty(type)) {
        this.register(type, callbacks[type])
      }
    }
  }
}

/**
 * 调用 Windows 桌面通知
 * @see https://developer.mozilla.org/en-US/docs/Web/API/notification
 */
export const windowNotification = (options) => {
  options = options || {}
  if (options.tag) {
    // 避免和 ERP 的 windows 通知重复
    if (Cookies.get('notify_' + options.tag)) return
    let expires = new Date()
    expires.setSeconds(expires.getSeconds() + 30)
    Cookies.set('notify_' + options.tag, 1, { expires: expires, path: '/', domain: getDomain() })
  }
  // 浏览器是否支持显示通知   需要注意的是 只有 HTTPS 协议才能浏览器才能通过通知的功能，否则浏览器是强制关闭改功能的
  if (window.Notification && Notification.permission !== 'denied') {
    // 通知功能 有骚扰用户的嫌疑，让用户根据自己喜好选择是否开启通知权限
    Notification.requestPermission((status) => {
      if (status === 'granted') {
        // 编辑通知内容并加上各个点击事件等  后期控制点击通知跳转到文章
        let notify = new Notification(options.title || 'FS系统通知', {
          dir: options.dir || undefined,
          body: options.body || undefined,
          lang: options.lang || 'zh-CN',
          icon: options.icon || 'https://uums.fs.com/favicon.ico',
          tag: options.tag || undefined,
          data: options.data || {},
          image: options.image || undefined
        })
        notify.addEventListener('click', (e) => {
          if (typeof options.onclick === 'function') {
            options.onclick(e, notify)
          }
        })
        notify.addEventListener('close', (e) => {
          Cookies.remove('notify_' + options.tag, { path: '/', domain: getDomain() })
        })
      }
    })
  }
}

// 避免 UUMS 和 ERP 的 windows 通知重复
export const setNotification = (options) => {
  setTimeout(function () {
    windowNotification(options)
  }, 0)
}
