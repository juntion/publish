import {
  getAllowSubsUsers,
  getSubSystemForbidUsers,
  getSubSystemsData
} from '../../../api/subsystem'
import { message } from 'ant-design-vue'

const state = {
  subSystemPageLoading: false,
  subSystemListData: [],
  currentSubSystemData: {
    locale: '{"en": ""}'
  },
  forbidPageLoading: false,
  forbidUsersList: [],
  allowUsersList: [],
  allowUserPagination: {
    total: 0,
    showSizeChanger: true,
    current: 1,
    pageSize: 20,
    pageSizeOptions: ['20', '50', '100']
  },
  allowPageLoading: false,
  forbidUsersFilters: {},
  allowUsersFilters: {},
  filters: {}
}

const actions = {
  fetchSubSystemData ({ commit, getters }, data) {
    state.filters.guard_name = getters.getCurrentSub
    commit('SET_SUBSYSTEM_LOADING', true)
    getSubSystemsData({ filters: state.filters }).then(data => {
      if (data.status) {
        commit('SET_SUBSYSTEM_LIST_DATA', data)
      } else {
        message.error('获取列表失败')
      }
      commit('SET_SUBSYSTEM_LOADING', false)
    }).catch(error => {
      commit('SET_SUBSYSTEM_LOADING', false)
      message.error(error.response.data.message || error.message)
    })
  },
  fetchForbidUserList ({ commit, state }, params) {
    commit('SET_FORBID_PAGE_LOADING', true)
    params.filters = state.forbidUsersFilters
    getSubSystemForbidUsers(params).then(data => {
      if (data.status) {
        commit('SET_FORBID_USER_LIST', data)
      } else {
        message.error('获取禁用用户失败')
      }
      commit('SET_FORBID_PAGE_LOADING', false)
    }).catch(error => {
      commit('SET_FORBID_PAGE_LOADING', false)
      message.error(error.response.data.message || error.message)
    })
  },
  fetchAllowUserList ({ commit, state }, sendData) {
    let params = {
      id: sendData.id,
      limit: sendData.pagination ? sendData.pagination.pageSize : state.allowUserPagination.pageSize,
      page: sendData.pagination ? sendData.pagination.current : state.allowUserPagination.current,
      filters: state.allowUsersFilters
    }
    commit('SET_ALLOW_USER_LOADING', true)
    getAllowSubsUsers(params).then(data => {
      if (data.status) {
        commit('SET_ALLOW_USER_LIST', data)
        let pagination = {
          total: data.data.total,
          current: data.data.current_page,
          pageSize: data.data.per_page
        }
        commit('SET_ALLOW_PAGE_PAGINATION', pagination)
      } else {
        message.error('获取用户失败')
      }
      commit('SET_ALLOW_USER_LOADING', false)
    }).catch(error => {
      commit('SET_ALLOW_USER_LOADING', false)
      message.error(error.response.data.message || error.message)
    })
  }
}

const getters = {
  getSubSystemListData: state => state.subSystemListData,
  getSubSystemPageLoading: state => state.subSystemPageLoading,
  getCurrentSubSystemData: state => state.currentSubSystemData,
  getSubSystemForbidUserList: state => state.forbidUsersList,
  getSystemForbidLoading: state => state.forbidPageLoading,
  getSystemAllowLoading: state => state.allowPageLoading,
  getSubSystemAllowUserList: state => state.allowUsersList,
  getSubSystemAllowPagination: state => state.allowUserPagination
}

const mutations = {
  SET_SUBSYSTEM_LIST_DATA (state, data) {
    state.subSystemListData = data.data.subsystems
  },
  SET_SUBSYSTEM_LOADING (state, data) {
    state.subSystemPageLoading = data
  },
  SET_CURRENT_SUBSYSTEM_DATA (state, data) {
    state.currentSubSystemData = data
  },
  SET_FORBID_PAGE_LOADING (state, data) {
    state.forbidPageLoading = data
  },
  SET_FORBID_USER_LIST (state, data) {
    state.forbidUsersList = data.data.users
  },
  SET_ALLOW_USER_LIST (state, data) {
    state.allowUsersList = data.data.data
  },
  SET_ALLOW_USER_LOADING (state, data) {
    state.allowPageLoading = data
  },
  SET_ALLOW_PAGE_PAGINATION (state, data) {
    state.allowUserPagination.total = data.total
    state.allowUserPagination.pageSize = Number(data.pageSize)
    state.allowUserPagination.current = data.current
  },
  SET_FORBID_SEARCH_FILTERS (state, data) {
    state.forbidUsersFilters = data
  },
  SET_ALLOW_SEARCH_FILTERS (state, data) {
    state.allowUsersFilters = data
  },
  SET_SUBSYSTEMS_DATA_FILTER (state, data) {
    state.filters = data
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
