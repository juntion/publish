import axios from '../../plugins/axios'

export const settingBasicData = (params) => {
  return axios.patch('/users/setting/userInfo', params)
}

export const settingPassword = (params) => {
  return axios.post('/users/setting/password', params)
}

export const settingAvatar = (params) => {
  return axios.post('/users/setting/avatar', params)
}

export const setCodeEmail = (params) => {
  return axios.post('/users/setting/codeEmail', params)
}

export const getAssistantLevel = (params) => {
  return axios.get('/users/setting/assistantLevel', {
    params
  })
}

export const setAssistantLevel = (params) => {
  return axios.post('/users/setting/assistantLevel', params)
}

export const getLoginLogInfo = (params) => {
  return axios.get('/user/loginHistory', params)
}
