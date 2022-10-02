import { getPermission } from '../../../api/role'
import { message } from 'ant-design-vue'

const state = {
  permissionPageLoading: false,
  permissionPageList: [],
  permissionPagePagination: {
    total: 0,
    showSizeChanger: true,
    current: 1,
    pageSize: 20,
    pageSizeOptions: ['20', '50', '100']
  },
  filters: {},
  currentPermissionData: {
    locale: '{"en": ""}'
  }
}

const actions = {
  fetchPermissionsList ({ state, commit, getters }, data) {
    state.filters.guard_name = getters.getCurrentSub
    commit('SET_PERMISSION_PAGE_LOADING', true)
    let params = {
      limit: data !== undefined ? data.pageSize : state.permissionPagePagination.pageSize,
      page: data !== undefined ? data.current : state.permissionPagePagination.current,
      filters: state.filters
    }
    getPermission(params).then(data => {
      commit('SET_PERMISSION_PAGE_LOADING', false)
      if (data.status === 'success') {
        commit('SET_PERMISSION_LIST_DATA', data)
        commit('SET_PERMISSION_PAGINATION', data.data)
      } else {
        message.error('获取角色列表失败')
      }
    }).catch(error => {
      commit('SET_PERMISSION_PAGE_LOADING', false)
      message.error(error.response ? error.response.data.message : error.message)
    })
  }
}

const getters = {
  getPermissionListData: state => state.permissionPageList,
  getPermissionPagePagination: state => state.permissionPagePagination,
  getPermissionPageLoading: state => state.permissionPageLoading,
  getCurrentPermissionData: state => state.currentPermissionData
}

const mutations = {
  SET_PERMISSION_PAGE_LOADING (state, data) {
    state.permissionPageLoading = data
  },
  SET_PERMISSION_LIST_DATA (state, data) {
    state.permissionPageList = data.data.data
  },
  SET_PERMISSION_PAGINATION (state, data) {
    state.permissionPagePagination.total = data.total
    state.permissionPagePagination.pageSize = Number(data.per_page)
    state.permissionPagePagination.current = data.current_page
  },
  SET_PERMISSION_LIST_FILTERS (state, data) {
    state.filters = data
  },
  SET_CURRENT_PERMISSION_DATA (state, data) {
    state.currentPermissionData = data
  }
}

export default {
  actions,
  state,
  getters,
  mutations
}
