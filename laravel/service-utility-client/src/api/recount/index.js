import axios from '../../plugins/axios'
// 获取产品线列表
export const getProducts = (params) => {
  return axios.get('/pm/products/list', { params: { product_id: params, status: 1 } })
}
// 发布诉求
export const putForm = params => {
  return axios.post('/pm/appeals', params)
}
// 诉求列表
export const claimList = (params) => {
  return axios.get('/pm/appeals', { params: { ...params, append: 'product_category' } })
}
// 诉求详情
export const claimDetial = (id) => {
  return axios.get('/pm/appeals/' + id + '/details')
}
// 编辑诉求
export const eidtClaim = (id, params) => {
  return axios.post('/pm/appeals/' + id, params)
}
// 撤销诉求
export const revocation = (params, id) => {
  return axios.post('/pm/appeals/' + id + '/revocation', params)
}
// 删除诉求
export const delClaim = (id) => {
  return axios.delete('/pm/appeals/' + id)
}
// 拆分诉求
export const splitClaim = (params, id) => {
  return axios.post('/pm/appeals/' + id + '/disassemble', params)
}
// 诉求操作记录
export const getClaimLog = (id) => {
  return axios.get('/pm/appeals/' + id + '/logs')
}
// 认领诉求
export const sendClaim = (id) => {
  return axios.get('/pm/appeals/' + id + '/apply')
}
// 立项

// 取消认领
export const cancelClaim = (id) => {
  return axios.get('/pm/appeals/' + id + '/apply/cancel')
}
// 取消立项
export const cancelProject = (id) => {
  return axios.get('/pm/appeals/' + id + '/createDemand/cancel')
}
// 详情页审核状态
export const getProjectStatus = (id) => {
  return axios.get('/pm/appeals/' + id + '/logs')
}
// 详情页更新审核确认接口
export const updateReview = (params, id) => {
  return axios.post('/pm/appeals/' + id + '/verify', params)
}
// 诉求-修改指定跟进人
export const eidtTaskPeople = (params, id) => {
  return axios.post('/pm/appeals/' + id + '/follow', params)
}
// 更改诉求产品分类
export const eidtIcation = (params, id) => {
  return axios.post('/pm/appeals/' + id + '/products', params)
}

// 关注或取消关注诉求
export const attentionDemands = (id) => {
  return axios.post('/pm/appeals/' + id + '/attention')
}
// 新增标签分类
export const addTagClass = params => {
  return axios.post('/pm/labelCategories', params)
}
// 修改标签分类
export const eidtTagClass = (params, id) => {
  return axios.patch('/pm/labelCategories/' + id, params)
}
// 删除标签分类
export const delTagClass = (id) => {
  return axios.delete('/pm/labelCategories/' + id)
}
// 获取标签分类列表
export const getTagClassList = (params) => {
  return axios.get('/pm/labelCategories', { params: params })
}
// 标签分类排序
export const sortTagClass = params => {
  return axios.post('/pm/labelCategories/sort', params)
}
// 新增标签
export const addTag = params => {
  return axios.post('/pm/labels', params)
}
// 修改标签
export const eidtTag = (params, id) => {
  return axios.patch('/pm/labels/' + id, params)
}
// 删除标签
export const delTag = (id) => {
  return axios.delete('/pm/labels/' + id)
}
// 给诉求贴标签
export const pasteTag = (params, id) => {
  return axios.post('/pm/appeals/' + id + '/labels', params)
}
// 删除诉求标签
export const delClaimTag = (id, label) => {
  return axios.delete('/pm/appeals/' + id + '/labels/' + label)
}
// 获取标签
export const getTagList = (params, id) => {
  return axios.get('/pm/labelCategories/' + id + '/labels', { params })
}
// 标签排序
export const sortTag = params => {
  return axios.post('/pm/labels/sort', params)
}
// 获取标签和分类
export const getlabclassAll = params => {
  return axios.get('/pm/labelCategories/tree', { params })
}
// 部门列表
export const getlDepartment = () => {
  return axios.get('/pm/dropDown/department')
}
export const getClaimant = () => {
  return axios.get('/pm/dropDown/appealPublisher')
}

// 产品跟进人下拉数据
export const getProductFollower = () => {
  return axios.get('/pm/dropDown/productFollower')
}

// 产品负责人下拉数据
export const getProductPrincipal = () => {
  return axios.get('/pm/dropDown/productPrincipal')
}
// 获取诉求产品负责人下拉数据
export const getClaimPrincipall = (id) => {
  return axios.get('/pm/appeals/' + id + '/principal')
}
// 产品负责人更改
export const eidtProductPrincipal = (params, id) => {
  return axios.post('/pm/appeals/' + id + '/principal', params)
}

// 导出诉求信息统计表
export const getAppealsExcel = (params) => {
  let url = process.env.VUE_APP_API_URL + '/pm/appeals/export?' + params
  window.open(url, '_blank')
}

// 诉求转移
export const appealsTransfer = (params) => {
  return axios.patch('/pm/appeals/transfer', params)
}
