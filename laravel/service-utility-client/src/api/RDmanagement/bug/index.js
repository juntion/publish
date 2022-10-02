/* eslint-disable */
import axios from '../../../plugins/axios'


// 提 bug
export const postBugs = (params) => {
    return axios.post('/pm/bugs', params)
}
// 编辑 bug
export const editBugs = (id,params) => {
    return axios.post('/pm/bugs/'+id, params)
}

// bug 列表
export const getBugs = (params) => {
    return axios.get('/pm/bugs', { params })
}
// bug 详情
export const bugDetails = (id) => {
    return axios.get('/pm/bugs/'+id+'/detail')
}

// 撤销 bug
export const revocationBug = (id,params) => {
    return axios.post('/pm/bugs/'+id+'/revocation', params)
}

// bug 申请审批
export const applyBug = (id) => {
    return axios.get('/pm/bugs/'+id+'/applyExamine')
}

// 撤销审批申请
export const revocationApply = (id,params) => {
    return axios.post('/pm/bugs/'+id+'/applyExamineCancel', params)
}

// 财务审批
export const financeExamine = (id,params) => {
    return axios.post('/pm/bugs/'+id+'/financeExamine', params)
}

// 内控审批
export const internalControlExamine = (id,params) => {
    return axios.post('/pm/bugs/'+id+'/internalControlExamine', params)
}

// 开始处理bug
export const startBug = (id,params) => {
    return axios.post('/pm/bugs/'+id+'/start', params)
}

// 提交处理结果
export const submitHandleResult = (id,params) => {
    return axios.post('/pm/bugs/'+id+'/submitHandleResult', params)
}

// 处理结果撤销提交
export const submitHandleResultCancel = (id,params) => {
    return axios.post('/pm/bugs/'+id+'/submitHandleResult/cancel', params)
}

// bug 复核
export const reexamine = (id,params) => {
    return axios.post('/pm/bugs/'+id+'/reexamine', params)
}

// 测试验收
export const acceptTest = (id,params) => {
    return axios.post('/pm/bugs/'+id+'/acceptTest', params)
}

// 产品验收
export const acceptProduct = (id,params) => {
    return axios.post('/pm/bugs/'+id+'/acceptProduct', params)
}

// 提bug人验收
export const acceptPromulgator = (id,params) => {
    return axios.post('/pm/bugs/'+id+'/acceptPromulgator', params)
}

// 关闭 bug
export const closeBug = (id,params) => {
    return axios.post('/pm/bugs/'+id+'/close', params)
}

// 补充信息
export const appendInfo = (id,params) => {
    return axios.post('/pm/bugs/'+id+'/appendInfo', params)
}

// 设置处理时限
export const expirationDate = (id,params) => {
    return axios.post('/pm/bugs/'+id+'/expirationDate', params)
}

// bug分配跟进人
export const setFollow = (id,params) => {
    return axios.post('/pm/bugs/'+id+'/follow', params)
}

// 更改开发负责人
export const setDev = (id,params) => {
    return axios.post('/pm/bugs/'+id+'/programPrincipal', params)
}

// 更改产品负责人
export const setProduct = (id,params) => {
    return axios.post('/pm/bugs/'+id+'/productPrincipal', params)
}

// 更改测试负责人
export const setTest = (id,params) => {
    return axios.post('/pm/bugs/'+id+'/testPrincipal', params)
}

// bug 详情
export const bugDetail= (id) => {
    return axios.get('/pm/bugs/'+id+'/detail')
}

// 查看bug状态变更日志
export const bugLogs= (id) => {
    return axios.get('/pm/bugs/'+id+'/logs')
}

// bug审批日志
export const bugExamineLogs= (id) => {
    return axios.get('/pm/bugs/'+id+'/examineLogs')
}
// bug 列表导出
export const getExcel = (params) => {
    let url = process.env.VUE_APP_API_URL + '/pm/bugs/export?' + params
    window.open(url, '_blank')
  }

//   更改提交信息
export const updateSubmitResult = (id,params) => {
    return axios.patch('/pm/bugs/'+id+'/submitHandleResult/update', params)
}
