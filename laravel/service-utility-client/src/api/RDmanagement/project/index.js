import axios from '../../../plugins/axios'

// 创建日常项目
export const pushDailyprojects = params => {
  return axios.post('/pm/projects/daily', params)
}

// 创建重要项目
export const pushKeyprojects = params => {
  return axios.post('/pm/projects/major', params)
}

// 查看项目列表数据
export const getAllprojects = params => {
  return axios.get('/pm/projects', { params: params })
}

export const searchProjects = (status, timer, name, callback) => {
  if (name.length > 2) {
    if (timer !== null) {
      clearTimeout(timer)
    }
    return setTimeout(function () {
      getAllprojects({ 'search[keyword]': name, 'search[status]': status, limit: 30 }).then(data => {
        callback(data)
      })
    }, 500)
  }
}

// 项目列表搜索
export const getSearchAllpjs = params => {
  return axios.get('/pm/projects', { params: params })
}

// 项目数量统计
export const getProjectCounts = params => {
  return axios.get('/pm/projects/statistics', { params: params })
}

// 查看动态日志数据
export const getProjectLog = params => {
  return axios.get('/pm/projects/dynamicLog', params)
}

// 查看项目详情
export const getProjectDetails = (id, params) => {
  return axios.get('/pm/projects/' + id + '/details', { params })
}

// 关注或取消关注项目
export const attentionProject = id => {
  return axios.post('/pm/projects/' + id + '/attention')
}

// 更新项目状态
export const updateProjectStatus = (id, params) => {
  return axios.post('/pm/projects/' + id + '/status', params)
}

// 查看项目状态变更日志
export const getProjectChangeLog = id => {
  return axios.get('/pm/projects/' + id + '/logs')
}

// 编辑项目
export const editProject = (id, params) => {
  return axios.post('/pm/projects/' + id, params)
}

// 图片上传
export const upload = (params) => {
  return axios.post('/medias/upload', params)
}

// 更新项目总结报告
export const projectSummary = (id, params) => {
  return axios.post('/pm/projects/' + id + '/projectSummary', params)
}
