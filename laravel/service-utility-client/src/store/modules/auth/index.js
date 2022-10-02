import Auth from '../../../api/auth'
import Cookies from 'js-cookie'
import _ from 'lodash'
import { message } from 'ant-design-vue'
import { bus } from '../../../plugins/bus'
import { getDomain } from '../../../plugins/common'
import md5 from 'blueimp-md5'

const state = {
  user: localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : null,
  isMailSend: false,
  isPasswordReset: false
}

const mutations = {
  LOGIN_SUCCESS (state, data) {
    // this.commit('REFRESH_SUCCESS', data)
    const token = data.data.token_type + ' ' + data.data.access_token
    if (data.remember === 1) {
      localStorage.setItem('token', token)
    } else {
      localStorage.removeItem('token', token)
    }
    Cookies.set('token', token)
    Cookies.set('client_group', md5(data.data.access_token), { path: '/', domain: getDomain() })
    let ticketExp = new Date()
    ticketExp.setSeconds(ticketExp.getSeconds() + 300)
    Cookies.set('ticket', data.data.ticket, { expires: ticketExp })
    if (data.data.client_token) {
      Cookies.set('client_token_' + data.data.name.toLowerCase(), data.data.client_token, { expires: new Date(new Date().getTime() + 7 * 24 * 60 * 60 * 1000) }) // 7天失效
    }
    if (data.data.stats_token) {
      Cookies.set('stats_token', data.data.stats_token)
    }
  },
  REFRESH_SUCCESS (state, data) {
    const user = _.pick(data.data.user, [
      'id', 'name', 'email', 'positions', 'department', 'department_ids', 'avatar', 'forbid_pages', 'duties', 'basic_department', 'code_email', 'admin_level', 'assistant_id', 'admin_telephone'
    ])
    state.user = user
    localStorage.setItem('userType', JSON.stringify(data.data.pm_user_type))
    localStorage.setItem('user', JSON.stringify(user))
    localStorage.setItem('sidebars', JSON.stringify(data.data.sidebars))
    localStorage.setItem('dashboard', JSON.stringify(data.data.dashboard))
    localStorage.setItem('permissions', JSON.stringify(data.data.permissions))
  },
  AUTH_LOGOUT (state) {
    state.user = null
    Cookies.remove('token')
    localStorage.removeItem('user')
    localStorage.removeItem('token')
    Cookies.remove('returnUrl')
    window.Bus.$ws.close()
    window.Bus.$notification.destroy()
  },
  SEND_RESET_MAIL_SUCCESS (state) {
    state.isMailSend = true
  },
  RESET_PASSWORD_SUCCESS (state) {
    state.isPasswordReset = true
  },
  BASE_SETTING_SUCCESS (state, data) {
    state.user.name = data.name
    state.user.email = data.email
    state.user.position = data.position
    state.user.admin_telephone = data.admin_telephone
    localStorage.setItem('user', JSON.stringify(state.user))
  },
  updateAvatarSuccess (state, data) {
    state.user.avatar = data.avatar
    localStorage.setItem('user', JSON.stringify(state.user))
  },
  SHOW_FORBID_ERROR () {
    this.$message.error('没有权限查看')
  }
}

const actions = {
  async login ({ commit, dispatch }, params) {
    const { data } = await Auth.login(params)
    localStorage.removeItem('demandPage')
    localStorage.removeItem('designPage')
    await dispatch('initSystemEnum')
    await commit('LOGIN_SUCCESS', { data: data, remember: params.remember })
    await dispatch('fetchAllSubs')
    await dispatch('refresh')
  },
  async logout ({ commit }) {
    await Auth.logout()
    Cookies.remove('client_group', { path: '/', domain: getDomain() })
    commit('AUTH_LOGOUT')
    commit('REMOVE_ALL_SYSTEM_ENUM')
  },
  async refresh ({ commit }) {
    const { data } = await Auth.userInfo()
    commit('REFRESH_SUCCESS', { data })
    bus.$emit('updateMenu')
  },
  async sendResetEmail ({ commit }, params) {
    await Auth.passwordEmail(params)
    commit('SEND_RESET_MAIL_SUCCESS')
  },
  async resetPassword ({ commit }, params) {
    await Auth.passwordReset(params)
    commit('RESET_PASSWORD_SUCCESS')
  },
  baseSettingSuccess ({ commit }, params) {
    commit('BASE_SETTING_SUCCESS', params)
  },
  async noticeUserHasBeenUpdate ({ dispatch }, type) {
    let msg = ''
    switch (type) {
      case 1:
        msg = window.Bus.$t('auth.permissionUpdate')
        break
      case 2:
        msg = window.Bus.$t('auth.sideBarUpdate')
        break
      default:
        msg = window.Bus.$t('auth.otherInfoUpdate')
        break
    }
    message.info(msg)
    await dispatch('refresh')
  }
}

const getters = {
  getAuthUser: state => state.user
}

export default {
  state,
  mutations,
  actions,
  getters
}
