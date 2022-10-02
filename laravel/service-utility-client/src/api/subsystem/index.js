import axios from '../../plugins/axios'

// 获取所有子系统列表
export const getSubSystemsData = (params) => {
  return axios.get('/subsystems', {
    params: params
  })
}

// 获取所有看守器
export const getGuardNames = () => {
  return axios.get('/subsystems/guardNames')
}

// 查询禁止登录的用户
export const getSubSystemForbidUsers = (params) => {
  return axios.get('/subsystems/' + params.id + '/forbid/users', {
    params
  })
}

// 删除禁止登录的用户
export const delSubSystemForbidUsers = (params) => {
  return axios.delete('/subsystems/' + params.id + '/forbid/users', {
    params
  })
}

// 更新子系统信息
export const updateSubSystemInfo = (params) => {
  return axios.patch('/subsystems/' + params.id, params)
}

// 添加禁止登录的用户
export const addSubSystemForbidUsers = (params) => {
  return axios.post('/subsystems/' + params.id + '/forbid/users', params)
}

// 设置侧边栏状态
export const setSubSystemSideBar = (params) => {
  return axios.post('/subsystems/' + params.id + '/setSidebar', params)
}

// 设置首页状态
export const setSubSystemHomepage = (params) => {
  return axios.post('/subsystems/' + params.id + '/setHomepage', params)
}

// 未被禁止的用户
export const getAllowSubsUsers = (params) => {
  return axios.get('/users/subsystems/' + params.id + '/allow', {
    params
  })
}

// 页面列表
export const getPageList = (params) => {
  return axios.get('/pages', {
    params
  })
}

// 查询首页页面
export const getHomePageList = (params) => {
  return axios.post('/pages/homepages', params)
}

// 更新页面
export const updatePageInfo = (params) => {
  return axios.patch('/pages/' + params.id, params)
}

// 所有页面
export const getSubsAllPage = (params) => {
  return axios.get('/pages/all', {
    params
  })
}

// 获取所有的adminlevel
export const getAllAdminLevels = (params) => {
  return axios.get('/users/adminLevel', {
    params
  })
}
