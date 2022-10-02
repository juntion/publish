import axios from '../../../plugins/axios'
/* eslint-disable */
// 设计-任务列表
export const getDesignTask = params => {
    return axios.get('/pm/tasks/design', { params: {...params, append: 'product_category' } })
}

// 设计-开始环节子任务
export const startTask = (id, params) => {
    return axios.post('/pm/tasks/design/parts/subtasks/' + id + '/start', params)
}

// 设计-提交环节子任务
export const submitTask = (id, params) => {
    return axios.post('/pm/tasks/design/parts/subtasks/' + id + '/submit', params)
}

// 设计-暂停环节子任务
// /pm/tasks/design/parts/subtasks/{id}/pause
export const stopTask = (id, params) => {
    return axios.post('/pm/tasks/design/parts/subtasks/' + id + '/pause', params)
}

// 设计-审核任务
// /pm/tasks/design/{id}/verify

export const reviewTasks = (id, params) => {
        return axios.post('/pm/tasks/design/' + id + '/verify', params)
    }
    // 设计-更改任务负责人
export const changeTaskPeople = (id, params) => {
    return axios.post('/pm/tasks/design/' + id + '/principal', params)
}

// 设计-更改设计环节顺序
// /pm/tasks/design/{id}/sequence
export const sequenceTasks = (id, params) => {
    return axios.post('/pm/tasks/design/' + id + '/sequence', params)
}

// 设计-总任务状态变更日志
export const statsuChangeLog = (id) => {
    return axios.get('/pm/tasks/design/' + id + '/logs')
}

// 设计-角色环节状态变更日志
export const partsChangeLog = (id) => {
    return axios.get('/pm/tasks/design/parts/' + id + '/logs')
}

// 设计-角色环节子任务状态变更日志
export const subtasksChangeLog = (id) => {
    return axios.get('/pm/tasks/design/parts/subtasks/' + id + '/logs')
}

// 设计-撤销环节子任务
export const revocationTask = (id, params) => {
    return axios.post('/pm/tasks/design/parts/subtasks/' + id + '/revocation', params)
}

// 设计-确认完成环节子任务

export const completeTask = (id, params) => {
    return axios.post('/pm/tasks/design/parts/subtasks/' + id + '/complete', params)
}

// 设计-指派任务处理人
// /pm/tasks/design/parts/{id}/handler
export const handlerTask = (id, params) => {
    return axios.post('/pm/tasks/design/parts/' + id + '/handler', params)
}

// 设计-创建环节子任务
// /pm/tasks/design/parts/{id}/subtasks
export const postSubtasksDesign = (id, params) => {
    return axios.post('/pm/tasks/design/parts/' + id + '/subtasks', { subtasks: params })
}

// 设计-发布任务
export const postDesignTask = (params) => {
    return axios.post('/pm/tasks/design', params)
}

// 设计-走查
// /pm/tasks/design/{id}/review
export const designWalk = (id, params) => {
    return axios.post('/pm/tasks/design/' + id + '/review', params)
}

// 设计-设置总任务优先级
// /pm/tasks/design/{id}/priority
export const setPriority = (id, params) => {
    return axios.post('/pm/tasks/design/' + id + '/priority', { priority: params })
}

// 设计-设置子任务优先级
export const setSubtasksPriority = (id, params) => {
    return axios.post('/pm/tasks/design/parts/subtasks/' + id + '/priority', { priority: params })
}


// 设计-撤销提交环节子任务
// /pm/tasks/design/parts/subtasks/{id}/submit/cancel
export const dissubmitTask = (id, params) => {
    return axios.post('/pm/tasks/design/parts/subtasks/' + id + '/submit/cancel', params)
}

// 设计-更改任务预计交付日期
export const changeTaskDate = (id, params) => {
    return axios.post('/pm/tasks/design/' + id + '/expirationDate', params)
}

// 设计-更改子任务交付日期
export const changeSubtasksDate = (id, params) => {
    return axios.post('/pm/tasks/design/parts/subtasks/' + id + '/expirationDate', params)
}

// 设计-获取该任务更新负责人下拉选项
export const getNewPrincipal = (id) => {
    return axios.get('/pm/tasks/design/' + id + '/principal')
}


// 导出设计任务列表
export const getExcel = (params) => {
    let url = process.env.VUE_APP_API_URL + '/pm/tasks/design/export?' + params
    window.open(url, '_blank')
  }

//   设计-更新提交信息
export const submitUpdate = (id, params) => {
    return axios.post('/pm/tasks/design/parts/subtasks/' + id + '/submit/update', params)
}

// 获取默认产品设计团队成员
export const getDesignTeam = (id, params) => {
    return axios.get('/pm/products/' + id + '/defaultDesignTeamMembers', params)
}
// 测试 - 获取任务详情
export const getDesignDetails = (id) => {
    return axios.get('/pm/tasks/design/' + id + '/details')
}

// 测试-编辑任务
export const editDesignTask = (id, params) => {
    return axios.post('/pm/tasks/design/' + id , params)
}


// 设计--------------接口
