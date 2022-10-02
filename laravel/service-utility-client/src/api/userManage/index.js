import axios from '../../plugins/axios'
// 获取所有用户列表
export const getUsers = (params) => {
  return axios.get('/users', {
    params: params
  })
}

// 用户搜索列表
export const searchUser = (params) => {
  return axios.get('/users/searchList', {
    params: params
  })
}

export const searchUserList = (timer, name, callback) => {
  if (name.length > 2) {
    if (timer !== null) {
      clearTimeout(timer)
    }
    return setTimeout(function () {
      searchUser({ name: name }).then(data => {
        callback(data)
      })
    }, 500)
  }
}

// 删除用户
export const delUser = (id) => {
  let url = '/users/' + id
  return axios.delete(url)
}

// 部门树状图
export const getDepartmentsTree = (params) => {
  return axios.get('/departments/tree', {
    params
  })
}

// 所有职称
export const getOptionsAll = (params) => {
  return axios.get('/positions/all', {
    params
  })
}

// 所属子公司
export const getSubsidiaryCompanies = (params) => {
  return axios.get('/companies')
}

// 添加新用户
export const addNewUser = (params) => {
  return axios.post('/users', params)
}

// 设置默认部门
export const setDefaultDepartment = (params) => {
  let url = ''
  if (params.groupSet) {
    url = '/users/departments'
  } else {
    url = '/users/' + params.id + '/departments'
  }
  return axios.post(url, params)
}

// 设置所属子公司
export const setSubsidiaryCompanies = (params) => {
  let url = ''
  if (params.groupSet) {
    url = '/users/companies'
  } else {
    url = '/users/' + params.id + '/companies'
  }
  return axios.post(url, params)
}

// 设置其他部门
export const setOtherDepartments = (params) => {
  let url = '/users/' + params.id + '/otherDepartments'
  return axios.post(url, params)
}

// 设置职称
export const setPositions = (params) => {
  let url = ''
  if (params.groupSet) {
    url = '/users/positions'
  } else {
    url = '/users/' + params.id + '/positions'
  }
  return axios.post(url, params)
}

// 获取所有子系统
export const getSubs = () => {
  return axios.get('/subsystems')
}

// 获取用户禁用的系统
export const getUserSubForbid = (params) => {
  return axios.get('/users/' + params.id + '/subsystems/forbid')
}

// 添加禁止登录的系统
export const addSubForbid = (params) => {
  return axios.post('/users/' + params.id + '/subsystems/forbid', params)
}

// 删除禁用登录的系统
export const delSubForbid = (params) => {
  return axios.delete('/users/' + params.id + '/subsystems/forbid', {
    params
  })
}

// 更新用户信息
export const updateUseInfo = (params) => {
  return axios.patch('/users/' + params.id, params)
}

// 批量绑定用户侧边栏模板
export const usersBindTemplate = (params) => {
  return axios.post('/users/sidebars', params)
}

// 批量禁用页面
export const usersForbidPages = (params) => {
  return axios.post('/users/sidebars/pages/forbid', params)
}

// 批量设置系统首页
export const usersSetHomePage = (params) => {
  return axios.post('/users/homepages', params)
}

// 查询用户角色
export const getUserRoles = (params) => {
  return axios.post('/users/' + params.id + '/roles', params)
}

// 更新用户角色
export const updateUserRoles = (params) => {
  return axios.patch('/users/' + params.id + '/roles', params)
}

// 批量绑定用户角色
export const attachUserRoles = (params) => {
  return axios.post('/users/attachRoles', params)
}

// 设置用户系统首页
export const setHomePage = (params) => {
  return axios.post('/users/' + params.id + '/homepages', params)
}

// 获取所有页面
export const getAllPagesOfOneSystem = (params) => {
  return axios.get('/pages/all', {
    params
  })
}

// 查询用户各子系统首页
export const getUserHomePage = (params) => {
  return axios.get('/users/' + params.id + '/homepages', {
    params
  })
}

// 查询用户权限
export const getUserSubsPermission = (params) => {
  return axios.post('/users/' + params.id + '/permissions', params)
}

// 更新用户权限
export const updateUserPermission = (params) => {
  return axios.patch('/users/' + params.id + '/permissions', params)
}

// 获取用户对应系统的侧边栏模板
export const getUserSide = (params) => {
  return axios.get('/users/' + params.id + '/sidebars')
}

// 重置用户密码
export const resetUserPassword = (params) => {
  return axios.post('/users/' + params.id + '/resetPassword', params)
}

// 用户列表导出
export const getUserExcel = (params) => {
  let url = process.env.VUE_APP_API_URL + '/users/userList/export?' + params
  window.open(url, '_blank')
}
