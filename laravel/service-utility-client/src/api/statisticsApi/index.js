import axios from 'axios'
import Cookies from 'js-cookie'

axios.defaults.baseURL = process.env.VUE_APP_API_URL_TASK
axios.defaults.headers['stats-token'] = Cookies.get('stats_token') || null

export const getHeaderTask = (params) => {
  return axios.post('/pms/headerTaskDetail', params)
}

export const getHeaderBug = (params) => {
  return axios.post('/pms/headerBugDetail', params)
}

export const getTaskDetail = (params) => {
  return axios.post('/pms/taskDetail', params)
}
export const getTaskFinishedSituation = (params) => {
  return axios.post('/pms/taskFinishedSituation', params)
}

export const getBugDealSituation = (params) => {
  return axios.post('/pms/bugDealSituation', params)
}

export const getAdminWorkDetail = (params) => {
  return axios.post('/pms/adminWorkDetail', params)
}

export const getSelectDutiesList = (params) => {
  return axios.post('/pms/selectDutiesList', params)
}
export const getSelectAdminList = (params) => {
  return axios.post('/pms/selectAdminList', params)
}

export const getSelectTimeList = (params) => {
  return axios.post('/pms/selectTimeList', params)
}
