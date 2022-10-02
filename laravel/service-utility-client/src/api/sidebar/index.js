import axios from '../../plugins/axios'

// 侧边栏栏目排序
export const categoriesSort = (params) => {
  return axios.post('/sidebars/categories/' + params.id + '/sort', params)
}

// 侧边栏栏目批量排序
export const categoriesBatchSort = (params) => {
  return axios.post('/sidebars/categories/batchSort', params)
}

// 侧边栏栏目页面排序
export const pagesSort = (params) => {
  return axios.post('/sidebars/categories/' + params.id + '/pages/' + params.pid + '/sort', params)
}

// 侧边栏栏目页面批量排序
export const pagesBatchSort = (params) => {
  return axios.post('/sidebars/categories/pages/batchSort', params)
}

// 创建侧边栏分类
export const newCategories = (params) => {
  return axios.post('/sidebars/categories', params)
}

// 删除侧边栏分类
export const delCategories = (params) => {
  return axios.delete('/sidebars/categories/' + params.id, {
    params
  })
}

// 删除关联页面
export const delCategoriesPage = (params) => {
  return axios.delete('/sidebars/categories/' + params.id + '/pages', {
    params
  })
}

// 更新侧边栏分类
export const updateCategories = (params) => {
  return axios.patch('/sidebars/categories/' + params.id, params)
}

// 添加关联页面
export const addCategoriesPage = (params) => {
  return axios.post('/sidebars/categories/' + params.id + '/pages', params)
}

// 侧边栏模板列表
export const getTemplates = (params) => {
  return axios.get('/sidebars/templates', {
    params
  })
}

// 侧边栏模板树结构
export const getTemplateTree = (params) => {
  return axios.get('/sidebars/templates/' + params.id + '/trees', {
    params
  })
}

// 创建侧边栏模板
export const newTemplate = (params) => {
  return axios.post('/sidebars/templates', params)
}

// 删除侧边栏模板
export const delTemplate = (params) => {
  return axios.delete('/sidebars/templates/' + params.id, {
    params
  })
}

// 所有侧边栏模板
export const allTemplate = (params) => {
  return axios.post('/sidebars/templates/all', params)
}

// 更新侧边栏模板
export const updateTemplate = (params) => {
  return axios.patch('/sidebars/templates/' + params.id, params)
}

// 模板所有侧边栏分类
export const getTemplateCategories = (params) => {
  return axios.get('/sidebars/templates/' + params.id + '/categories', {
    params
  })
}

// 模板可用页面
export const getTemplatePages = (params) => {
  return axios.get('/sidebars/templates/' + params.id + '/pages', {
    params
  })
}
