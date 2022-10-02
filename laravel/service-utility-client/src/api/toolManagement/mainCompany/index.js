import axios from '../../../plugins/axios'

// 获取主体公司列表
export const getCompanyList = params => {
  return axios.get('/company/list', {
    params: params
  })
}

// 列表处更新公司信息
export const updateCompanyInfo = (id, form) => {
  return axios.post('/company/' + id, form)
}

// 新增公司
export const addCompanyInfo = (form) => {
  return axios.post('/company/store', form)
}

// 启用或者关闭公司
export const updateCompanyStatus = (id, form) => {
  return axios.post('/company/' + id + '/status', form)
}

// 公司状态日志
export const getStatusLog = id => {
  return axios.get('/company/' + id + '/status')
}

// 获取国家数据
export const getCountrys = () => {
  return axios.get('/company/country')
}

// 获取所有子公司/母公司
export const getAllCompanys = (type) => {
  return axios.get('/company/type/all?type=' + type)
}
