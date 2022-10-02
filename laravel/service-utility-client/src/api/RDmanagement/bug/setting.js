/* eslint-disable */
import axios from '../../../plugins/axios'

// bug 负责人列表
export const getBugsPrincipal = (params) => {
    return axios.get('/pm/bugs/principal', { params })
}

// 故障原因列表
export const getBugsReason = (params) => {
    return axios.get('/pm/bugs/reason', { params })
}

// 编辑绑定负责人
export const editPrincipal = (id,params) => {
    return axios.patch('/pm/bugs/principal/'+id,  params )
}

// 新增故障原因
export const addReason = (params) => {
    return axios.post('/pm/bugs/reason',  params )
}

// 删除故障原因
export const delReason = (id) => {
    return axios.delete('/pm/bugs/reason/'+id )
}

// 编辑故障原因
export const editReason = (id,params) => {
    return axios.patch('/pm/bugs/reason/'+id,params )
}
// 批量绑定负责人
export const editMorePrincipal = (params) => {
    return axios.post('/pm/bugs/principal',  params )
}
