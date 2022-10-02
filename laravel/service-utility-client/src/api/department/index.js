import axios from '../../plugins/axios'

// 新增部门
export const addDepartment = (params) => {
  return axios.post('/departments', params)
}

// 删除部门
export const delDepartment = (params) => {
  return axios.delete('/departments/' + params)
}

// 更新部门
export const updateDepartmentInfo = (params) => {
  return axios.patch('/departments/' + params.id, params)
}

// 获取指定部门下所有子部门
export const getAllChildDepartment = (params) => {
  return axios.post('/departments/getAllDepartments', params)
}

// 获取指定部门下的用户
export const getDepartmentUsers = (id, params) => {
  return axios.get('/departments/' + id + '/getUsers', {
    params
  })
}

// 获取指定部门下级子部门
export const getChildDepartment = (params) => {
  return axios.get('/departments/' + params + '/getDepartments')
}

// 所有的部门
export const getAllDepartmentData = (params) => {
  return axios.get('/departments/all')
}

// 设置用户的权力
export const setUserPower = (params) => {
  return axios.post('/users/' + params.user_id + '/setDuty', params)
}

// 获取可分配的权限
export const getErpProfiles = (params) => {
  return axios.get('/users/erp/profiles', {
    params
  })
}

// 获取指定用户权限
export const getUserErpProfiles = (params) => {
  return axios.get('/users/' + params.id + '/erp/profiles', {
    params
  })
}
// 允许分配权限的人员
export const getCanSetUsers = (params) => {
  return axios.get('/users/erp/canSetProfileUsers', {
    params
  })
}

// 批量分配用户权限
export const SetUsersProfiles = (params) => {
  return axios.post('/users/erp/profiles', params)
}

// 添加用户权限
export const SetUserProfiles = (params) => {
  return axios.post('/users/' + params.id + '/erp/profiles', params)
}

// 删除指定用户权限
export const DelUserProfiles = (params) => {
  return axios.delete('/users/' + params.id + '/erp/profiles', {
    params
  })
}
