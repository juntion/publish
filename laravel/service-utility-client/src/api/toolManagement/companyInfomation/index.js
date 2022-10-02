import axios from '../../../plugins/axios'

// 获取主体公司列表
export const getCompanyInfoList = () => {
  return axios.get('/company/all/info')
}

// 获取公司具体信息
export const getCompanyInfo = (id) => {
  return axios.get('/company/' + id + '/info')
}

// 获取公司办公室信息
export const getCompanyOfficeInfo = id => {
  return axios.get('/company/' + id + '/office')
}

// 获取公司仓库信息
export const getCompanyWarehouseInfo = id => {
  return axios.get('/company/' + id + '/warehouse')
}

// 获取公司支付信息
export const getCompanyBankInfo = id => {
  return axios.get('/company/' + id + '/bank')
}

// 更新注册信息
export const updateCompanyRegistryInfo = (id, form) => {
  return axios.post('/company/' + id + '/registryInfo', form)
}

// 更新办公室信息
export const updateCompanyOfficeInfo = (id, form) => {
  return axios.post('/company/' + id + '/office', form)
}

// 更新仓储地址信息
export const updateCompanyWarehouseInfo = (id, form) => {
  return axios.post('/company/' + id + '/warehouse', form)
}

// 更新收款方式信息
export const updateCompanyBankInfo = (id, form) => {
  return axios.post('/company/' + id + '/bank', form)
}

// 更新办公室/仓库地址/支付方式信息状态
export const updateCompanyMoreInfoStatus = (id, form, name) => {
  return axios.post('/company/' + name + '/' + id + '/status', form)
}

// 办公室启用记录
export const getCompanyOfficeStatusLog = (id) => {
  return axios.get('/company/office/' + id + '/statusLog')
}

// 仓库启用记录
export const getCompanyWarehouseStatusLog = (id) => {
  return axios.get('/company/warehouse/' + id + '/statusLog')
}

// 支付方式启用记录
export const getCompanyBankStatusLog = (id) => {
  return axios.get('/company/bank/' + id + '/statusLog')
}

// 获取货币信息
export const getCompanyCurrencies = () => {
  return axios.get('/company/currencies')
}
