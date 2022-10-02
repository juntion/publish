import axios from '../../../plugins/axios'

// 发版产品列表
export const getPublishingProducts = (params) => {
  return axios.get('/pm/releaseProducts', { params })
}

// 发版管理简单统计
export const getStatistics = () => {
  return axios.get('/pm/releaseProducts/statistics')
}

// 发版产品管理员
export const getAdmin = (params) => {
  return axios.get('/pm/releaseProducts/admins', { params })
}

// 发版产品详情
export const publishingProductDetails = (id) => {
  return axios.get('/pm/releaseProducts/' + id + '/details')
}

// 添加发版产品
export const addPublishingProducts = (params) => {
  return axios.post('/pm/releaseProducts', params)
}

// 删除发版产品
export const delPublishingProducts = (id) => {
  return axios.delete('/pm/releaseProducts/' + id)
}

// 编辑发版产品信息
export const editPublishingProducts = (id, params) => {
  return axios.patch('/pm/releaseProducts/' + id, params)
}

// 发版产品状态变更日志
export const publishingProductLogs = (id) => {
  return axios.get('/pm/releaseProducts/' + id + '/logs')
}

// 版本号状态变更日志
export const versionsLogs = (id) => {
  return axios.get('/pm/releaseVersions/' + id + '/logs')
}

// 开启关闭发版产品

export const switchPublishingProducts = (id, params) => {
  return axios.post('/pm/releaseProducts/' + id + '/status', params)
}

// 添加版本计划
export const addVersions = (id, params) => {
  return axios.post('/pm/releaseProducts/' + id + '/versions', params)
}

// 编辑版本号信息
export const editVersions = (id, params) => {
  return axios.patch('/pm/releaseVersions/' + id, params)
}

// 删除版本号
export const delVersions = (id) => {
  return axios.delete('/pm/releaseVersions/' + id)
}

// 获取发版产品的版本号记录
export const getVersions = (id, params) => {
  return axios.get('/pm/releaseProducts/' + id + '/versions', { params })
}

// 版本功能清单
export const getVersionsFeatures = (id, params) => {
  return axios.get('/pm/releaseVersions/' + id + '/features', { params })
}

// 获取pms产品相关的发版产品及版本号
export const getProductAndVersion = (params) => {
  return axios.get('/pm/products/releaseVersions', { params })
}

// 版本发布测试
export const testVersions = (id, params) => {
  return axios.post('/pm/releaseVersions/' + id + '/test', params)
}

// 版本功能点发布测试
export const testVersionsFeature = (id, params) => {
  return axios.get('/pm/releaseVersions/feature/' + id + '/releaseTest', { params })
}

// 版本发布上线
export const onlineVersions = (id, params) => {
  return axios.post('/pm/releaseVersions/' + id + '/online', params)
}

// 确认版本功能信息
export const confirmVersions = (id, params) => {
  return axios.get('/pm/releaseVersions/feature/' + id + '/confirm', { params })
}

// 取消确认版本功能信息
export const cancelConfirmVersions = (id, params) => {
  return axios.get('/pm/releaseVersions/feature/' + id + '/confirm/cancel', { params })
}

// 更改功能的版本信息
export const editVersionsFeature = (id, params) => {
  return axios.patch('/pm/releaseVersions/feature/' + id, params)
}

// 导出版本功能清单
export const exportFeatures = (id, params) => {
  let url = process.env.VUE_APP_API_URL + '/pm/releaseVersions/' + id + '/features/export?' + params
  window.open(url, '_blank')
}
// 获取临时授权码
export const getExportFeaturesCode = () => {
  return axios.get('/user/tempAuthCode')
}

// 开发 - 更改版本信息
export const devEditVersions = (id, params) => {
  return axios.post('/pm/tasks/dev/subtasks/' + id + '/versions', params)
}

// 设计- 更改版本信息
export const designEditVersions = (id, params) => {
  return axios.post('/pm/tasks/design/parts/subtasks/' + id + '/versions', params)
}

// 发版管理 - 产品发布人

export const getProductPublisher = () => {
  return axios.get('/pm/releaseVersions/feature/productPublisher')
}
