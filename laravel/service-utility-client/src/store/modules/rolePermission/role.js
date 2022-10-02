import { getRoles } from '../../../api/role'
import { message } from 'ant-design-vue'

const state = {
  rolePageLoading: false,
  rolePageList: [],
  rolePagePagination: {
    total: 0,
    showSizeChanger: true,
    current: 1,
    pageSize: 20,
    pageSizeOptions: ['20', '50', '100']
  },
  filters: {},
  currentRoleData: {
    locale: '{"en": ""}'
  }
}

const actions = {
  async fetchRolesList ({ state, commit, getters }, data) {
    state.filters.guard_name = getters.getCurrentSub
    commit('SET_ROLE_PAGE_LOADING', true)
    let params = {
      limit: data !== undefined ? data.pageSize : state.rolePagePagination.pageSize,
      page: data !== undefined ? data.current : state.rolePagePagination.current,
      filters: state.filters
    }
    const obj = await getRoles(params)
    commit('SET_ROLE_PAGE_LOADING', false)
    if (obj.status === 'success') {
      commit('SET_ROLE_LIST_DATA', obj)
      commit('SET_ROLE_PAGINATION', obj.data)
    } else {
      message.error('获取角色列表失败')
    }
    // getRoles(params).then(data => {
    //   commit('SET_ROLE_PAGE_LOADING', false)
    //   if (data.status === 'success') {
    //     commit('SET_ROLE_LIST_DATA', data)
    //     commit('SET_ROLE_PAGINATION', data.data)
    //   } else {
    //     message.error('获取角色列表失败')
    //   }
    // }).catch(error => {
    //   commit('SET_ROLE_PAGE_LOADING', false)
    //   message.error(error.response ? error.response.data.message : error.message)
    // })
  }
}

const getters = {
  getRoleListData: state => state.rolePageList,
  getRolePagePagination: state => state.rolePagePagination,
  getRolePageLoading: state => state.rolePageLoading,
  getCurrentRoleData: state => state.currentRoleData
}

const mutations = {
  SET_ROLE_PAGE_LOADING (state, data) {
    state.rolePageLoading = data
  },
  SET_ROLE_LIST_DATA (state, data) {
    state.rolePageList = data.data.data
  },
  SET_ROLE_PAGINATION (state, data) {
    state.rolePagePagination.total = data.total
    state.rolePagePagination.pageSize = Number(data.per_page)
    state.rolePagePagination.current = data.current_page
  },
  SET_ROLE_LIST_FILTERS (state, data) {
    state.filters = data
  },
  SET_CURRENT_ROLE_DATA (state, data) {
    state.currentRoleData = data
  }
}

export default {
  actions,
  state,
  getters,
  mutations
}
