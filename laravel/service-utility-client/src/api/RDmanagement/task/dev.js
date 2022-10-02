import axios from '../../../plugins/axios'
/* eslint-disable */
// 开发-任务列表
export const getDevTask = params => {
    return axios.get('/pm/tasks/dev', { params: {...params, append: 'product_category' } })
}

// 开发-设置总任务优先级
export const setPriority = (id, params) => {
    return axios.post('/pm/tasks/dev/' + id + '/priority', { priority: params })
}

// 开发-设置子任务优先级
export const setSubtasksPriority = (id, params) => {
    return axios.post('/pm/tasks/dev/subtasks/' + id + '/priority', { priority: params })
}


// 开发-总任务状态变更日志
export const statsuChangeLog = (id) => {
    return axios.get('/pm/tasks/dev/' + id + '/logs')
}

// 开发-子务状态变更日志
export const subtasksChangeLog = (id) => {
    return axios.get('/pm/tasks/dev/subtasks/' + id + '/logs')
}

// 开发-提交子任务
export const submitTask = (id, params) => {
    return axios.post('/pm/tasks/dev/subtasks/' + id + '/submit', params)
}

// 开发-撤销提交子任务
export const dissubmitTask = (id, params) => {
    return axios.post('/pm/tasks/dev/subtasks/' + id + '/submit/cancel', params)
}

// 开发-撤销子任务
export const revocationTask = (id, params) => {
    return axios.post('/pm/tasks/dev/subtasks/' + id + '/revocation', params)
}

// 开发-开始子任务
export const startTask = (id, params) => {
    return axios.post('/pm/tasks/dev/subtasks/' + id + '/start', params)
}

// 开发-暂停子任务
export const stopTask = (id, params) => {
    return axios.post('/pm/tasks/dev/subtasks/' + id + '/pause', params)
}

// 开发-确认完成子任务
export const completeTask = (id, params) => {
    return axios.post('/pm/tasks/dev/subtasks/' + id + '/complete', params)
}

// 发布任务
export const postDevTask = (params) => {
    return axios.post('/pm/tasks/dev', params)
}

// 开发-指派任务处理人
export const handlerTask = (id, params) => {
    return axios.post('/pm/tasks/dev/' + id + '/handler', params)
}

// 开发-更改任务负责人
export const changeTaskPeople = (id, params) => {
    return axios.post('/pm/tasks/dev/' + id + '/principal', params)
}

// 开发-更改任务预计交付日期
export const changeTaskDate = (id, params) => {
    return axios.post('/pm/tasks/dev/' + id + '/expirationDate', params)
}

// 开发-更改子任务交付日期
export const changeSubtasksDate = (id, params) => {
    return axios.post('/pm/tasks/dev/subtasks/' + id + '/expirationDate', params)
}



// 开发-创建子任务
export const postSubtasksDev = (id, params) => {
    return axios.post('/pm/tasks/dev/' + id + '/subtasks', { subtasks: params })
}

// 导出开发任务列表
export const getExcel = (params) => {
    let url = process.env.VUE_APP_API_URL + '/pm/tasks/dev/export?' + params
    window.open(url, '_blank')
  }

  //   开发-更新提交信息
export const submitUpdate = (id, params) => {
    return axios.post('/pm/tasks/dev/subtasks/' + id + '/submit/update', params)
}

//开发 - 审核任务
export const verifyTask = (id, params) => {
    return axios.post('/pm/tasks/dev/' + id + '/verify', params)
}

// 开发 - 更改任务审核
export const verifyUpdateTask = (id, params) => {
    return axios.patch('/pm/tasks/dev/' + id + '/verify', params)
}

// 开发 - 获取任务详情
export const getDevDetails = (id) => {
    return axios.get('/pm/tasks/dev/' + id + '/details')
}

// 开发-编辑任务
export const editDevTask = (id, params) => {
    return axios.post('/pm/tasks/dev/' + id , params)
}

// 开发 - 计算考核标准工作量

export const getWorkload = (params) => {
    return axios.get('/pm/tasks/dev/workload' ,{params})
}

// 开发 - 计算考核绩效等级、系数
export const getAchievements = (params) => {
    return axios.get('/pm/tasks/dev/appraisalData' ,{params})
}
