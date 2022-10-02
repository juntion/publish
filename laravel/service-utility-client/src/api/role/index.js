import axios from '../../plugins/axios'

// 创建角色
export const addRoles = (params) => {
  return axios.post('/roles', params)
}

// 删除角色
export const delRoles = (params) => {
  return axios.delete('/roles/' + params.id, {
    params
  })
}

// 所有角色
export const getAllRoles = (params) => {
  return axios.post('/roles/all', params)
}

// 更新权限
export const updatePermission = (params) => {
  return axios.patch('/permissions/' + params.id, params)
}

// 更新角色
export const updateRoles = (params) => {
  return axios.patch('/roles/' + params.id, params)
}

// 更新角色权限
export const updateRolePermission = (params) => {
  return axios.patch('/roles/' + params.id + '/permissions', params)
}

// 权限列表
export const getPermission = (params) => {
  return axios.get('/permissions', {
    params
  })
}

// 权限组数据
export const getPermissionsGroups = (params) => {
  return axios.post('/permissions/groups', params)
}

// 角色列表
export const getRoles = (params) => {
  return axios.get('/roles', {
    params
  })
}

// 角色已有权限
export const getRolePermission = (params) => {
  return axios.get('/roles/' + params.id + '/permissions', {
    params
  })
}

// 获取拥有某个角色的用户
export const getRoleChild = (id, params) => {
  return axios.get('/roles/' + id + '/users', {
    params
  })
}
// 获取角色的权限操作日志
export const getRoleLog = (id, params) => {
  return axios.get('/roles/' + id + '/logs', {
    params
  })
}
// 角色导出
export const getRoleExcel = (params) => {
  let url = process.env.VUE_APP_API_URL + '/roles/export?' + params
  console.log(url)
  window.open(url, '_blank')
}
