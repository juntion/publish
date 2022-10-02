import axios from '../../plugins/axios'

// 某页数据
export const getPositionPageData = (params) => {
  return axios.get('/positions', { params })
}

// 更新职称
export const updatePositionInfo = (params) => {
  return axios.patch('/positions/' + params.id, params)
}

// 删除职称
export const delPosition = (params) => {
  return axios.delete('/positions/' + params)
}

// 创建职称
export const addPosition = (params) => {
  return axios.post('/positions', params)
}

// 获取某职称下的用户
export const getPositionUser = (params) => {
  return axios.get('/positions/' + params + '/users')
}
