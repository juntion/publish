import axios from '../../../plugins/axios'

// 获取产品线列表
export const getProducts = (params) => {
  return axios.get('/pm/products/list', { params: { product_id: params, status: 1 } })
}

// 获取产品负责人或团队绑定数据
export const getTeamsData = (id) => {
  return axios.get('/pm/products/' + id + '/teams')
}

// 部门树结构
export const getTreeData = () => {
  return axios.get('/departments/tree')
}

// 添加产品线
export const addProductsLine = (params) => {
  return axios.post('/pm/products/lines', params)
}

// 添加产品
export const addProducts = (id, params) => {
  return axios.post('/pm/products/' + id + '/products', { products: params })
}

// 添加产品线的模块
export const addProductsModule = (id, params) => {
  return axios.post('/pm/products/' + id + '/modules', { modules: params })
}

// 添加产品模块分类标签
export const addModuleTag = (id, params) => {
  return axios.post('/pm/products/' + id + '/labels', { name: params })
}

// 获取产品线数据
export const getProductsData = (params) => {
  return axios.get('/pm/products/tree', { params })
}

// 产品线和产品的开启或关闭
export const changeProductStatus = (params, id) => {
  return axios.patch('/pm/products/' + id + '/status', params)
}

// 获取产品状态变更日志
export const getProductsLog = (id) => {
  return axios.get('/pm/products/' + id + '/logs')
}

// 编辑产品线或产品的说明
export const editDescription = (id, params) => {
  return axios.patch('/pm/products/' + id + '/description', { description: params })
}

// 编辑产品模块
export const editProductModules = (id, params) => {
  return axios.patch('/pm/products/' + id + '/modules', params)
}

// 编辑产品线、产品和模块名称
export const editProductName = (id, params) => {
  return axios.patch('/pm/products/' + id + '/name', { name: params })
}

// 编辑产品模块分类标签名称
export const editTagName = (id, params) => {
  return axios.patch('/pm/products/labels/' + id + '/name', { name: params })
}

// 添加产品模块分类标签
export const addTags = (id, params) => {
  return axios.post('/pm/products/' + id + '/labels', { name: params })
}

// 删除产品模块分类标签
export const delTags = (id) => {
  return axios.delete('/pm/products/labels/' + id)
}

// 产品排序
export const productSort = (params) => {
  return axios.patch('/pm/products/sort', params)
}

// 产品团队负责人绑定
export const bindTeam = (id, params) => {
  return axios.post('/pm/products/' + id + '/teams', params)
}

// 产品团队负责人和成员绑定
export const bindMembers = (id, params) => {
  return axios.post('/pm/products/' + id + '/members', params)
}
