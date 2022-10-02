import axios from '../../../plugins/axios'
/* eslint-disable */
// 获取需求列表
export const getDemands = (params) => {
    return axios.get('/pm/demands', { params: {...params, append: 'product_category' } })
}

// 需求继续
export const continueDemands = (id) => {
    return axios.get('/pm/demands/' + id + '/continue')
}

// 关注或取消关注需求
export const attentionDemands = (id) => {
    return axios.post('/pm/demands/' + id + '/attention')
}

// 需求暂停
export const stopDemands = (id, params) => {
    return axios.post('/pm/demands/' + id + '/pause', { comment: params })
}

// 需求验收完成
export const completeDemands = (id, params) => {
    return axios.post('/pm/demands/' + id + '/complete', { comment: params })
}

// 需求更新测试
export const testDemands = (id) => {
    return axios.get('/pm/demands/' + id + '/test')
}

// 撤销需求
export const revokeDemands = (id, params) => {
    return axios.post('/pm/demands/' + id + '/revocation', { comment: params })
}

// 需求审核
export const verifyDemands = (id, params) => {
    return axios.post('/pm/demands/' + id + '/verify', params)
}

// 发布需求
export const postDemands = (params) => {
        return axios.post('/pm/demands', params)
    }
    // 在诉求直接发布需求
export const postClaimDemands = (params) => {
        return axios.post('/pm/appeals/createDemand', params)
    }
    // 编辑需求
export const editDemands = (id, params) => {
        return axios.post('/pm/demands/' + id, params)
    }
    // 查看需求详情
export const getDemandsDetails = (id, params) => {
    return axios.get('/pm/demands/' + id + '/details', { params: params })
}

// 附件下载
export const download = (params) => {
    let url = process.env.VUE_APP_API_URL + '/medias/download?' + params
    window.open(url, '_blank')
}

// 查看需求任务
export const getDemandsTask = (id, params) => {
    return axios.get('/pm/demands/' + id + '/tasks', { params: params })
}

// 确认项目需求
export const confirmDemands = (id, params) => {
    return axios.post('/pm/projects/demands/' + id + '/confirm', params)
}

// 取消确认项目需求
export const cancelConfirmDemands = (id, params) => {
    return axios.post('/pm/projects/demands/' + id + '/confirm/cancel', params)
}

// 推送项目需求
export const pushDemands = (id, params) => {
    return axios.post('/pm/projects/demands/' + id + '/push', params)
}

// 批量确认项目需求
export const confirmDemandsAll = (params) => {
    return axios.post('/pm/projects/demands/batchConfirm', { demand_ids: params })
}

// 批量推送项目需求
export const pushDemandsAll = (params) => {
    return axios.post('/pm/projects/demands/batchPush', { demand_ids: params })
}

// 需求优先级设置
export const pushPriority = (id, params) => {
    return axios.post('/pm/demands/' + id + '/priority', { priority: params })
}

// 查看需求状态变更日志
export const demandChangeLog = (id) => {
    return axios.get('/pm/demands/' + id + '/logs')
}

// 需求转移
export const demandsTransfer = (params) => {
    return axios.patch('/pm/demands/transfer', params)
  }


