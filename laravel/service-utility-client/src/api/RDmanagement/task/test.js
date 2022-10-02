import axios from '../../../plugins/axios'
/* eslint-disable */

// 测试-任务列表
export const getTestTask = params => {
    return axios.get('/pm/tasks/test', { params: {...params, append: 'product_category' } })
}

// 测试-设置总任务优先级
export const setPriority = (id, params) => {
    return axios.post('/pm/tasks/test/' + id + '/priority', { priority: params })
}

// 测试-设置子任务优先级
export const setSubtasksPriority = (id, params) => {
    return axios.post('/pm/tasks/test/subtasks/' + id + '/priority', { priority: params })
}


// 测试-总任务状态变更日志
export const statsuChangeLog = (id) => {
    return axios.get('/pm/tasks/test/' + id + '/logs')
}

// 测试-子务状态变更日志
export const subtasksChangeLog = (id) => {
    return axios.get('/pm/tasks/test/subtasks/' + id + '/logs')
}

// 测试-提交子任务
export const submitTask = (id, params) => {
    return axios.post('/pm/tasks/test/subtasks/' + id + '/submit', params)
}

// 测试-撤销提交子任务
export const dissubmitTask = (id, params) => {
    return axios.post('/pm/tasks/test/subtasks/' + id + '/submit/cancel', params)
}

// 测试-撤销子任务
export const revocationTask = (id, params) => {
    return axios.post('/pm/tasks/test/subtasks/' + id + '/revocation', params)
}

// 测试-开始子任务
export const startTask = (id, params) => {
    return axios.post('/pm/tasks/test/subtasks/' + id + '/start', params)
}

// 测试-暂停子任务
export const stopTask = (id, params) => {
    return axios.post('/pm/tasks/test/subtasks/' + id + '/pause', params)
}

// 测试-确认完成子任务
export const completeTask = (id, params) => {
    return axios.post('/pm/tasks/test/subtasks/' + id + '/complete', params)
}

// 发布任务
export const postTestTask = (params) => {
    return axios.post('/pm/tasks/test', params)
}

// 测试-指派任务处理人
export const handlerTask = (id, params) => {
    return axios.post('/pm/tasks/test/' + id + '/handler', params)
}

// 测试-更改任务负责人
export const changeTaskPeople = (id, params) => {
    return axios.post('/pm/tasks/test/' + id + '/principal', params)
}

// 测试-更改任务预计交付日期
export const changeTaskDate = (id, params) => {
    return axios.post('/pm/tasks/test/' + id + '/expirationDate', params)
}

// 测试-更改子任务交付日期
export const changeSubtasksDate = (id, params) => {
    return axios.post('/pm/tasks/test/subtasks/' + id + '/expirationDate', params)
}

// 测试-创建子任务
export const postSubtasksTest = (id, params) => {
    return axios.post('/pm/tasks/test/' + id + '/subtasks', { subtasks: params })
}

// 导出测试任务列表
export const getExcel = (params) => {
    let url = process.env.VUE_APP_API_URL + '/pm/tasks/test/export?' + params
    window.open(url, '_blank')
}
//   测试-更新提交信息
export const submitUpdate = (id, params) => {
    return axios.post('/pm/tasks/test/subtasks/' + id + '/submit/update', params)
}
//测试 - 审核任务
export const verifyTask = (id, params) => {
    return axios.post('/pm/tasks/test/' + id + '/verify', params)
}

// 测试 - 更改任务审核
export const verifyUpdateTask = (id, params) => {
    return axios.patch('/pm/tasks/test/' + id + '/verify', params)
}
// 测试 - 获取任务详情
export const getTestDetails = (id) => {
    return axios.get('/pm/tasks/test/' + id + '/details')
}

// 测试-编辑任务
export const editTestTask = (id, params) => {
    return axios.post('/pm/tasks/test/' + id , params)
}
