import { delUser, getUsers } from '../../../api/userManage'
import { getGuardNames, getAllAdminLevels } from '../../../api/subsystem'

const state = {
  pagination: {
    total: 0,
    showSizeChanger: true,
    current: 1,
    pageSize: 20,
    pageSizeOptions: ['20', '50', '100']
  },
  departmentTree: [],
  userList: [],
  allOptions: [],
  allSubsystem: [],
  currentUser: [],
  pageLoading: false,
  selectRows: [],
  isGroupSet: false,
  filters: {},
  subsData: [],
  currentSubs: '',
  adminLevels: [],
  subsidiaryCompanies: []
}

const getters = {
  getPagination: state => state.pagination,
  getUserList: state => state.userList,
  getDepartmentTree: state => state.departmentTree,
  getAllOptions: state => state.allOptions,
  getUpdateUserModalShow: state => state.UpdateUserModalShow,
  getCurrentUser: state => state.currentUser,
  getPageLoading: state => state.pageLoading,
  getSelectRows: state => state.selectRows,
  getIsGroupSet: state => state.isGroupSet,
  getSubsidiaryCompanies (state) {
    let filterArr = state.subsidiaryCompanies.filter((item) => {
      return item.id !== 9
    })
    return filterArr
  },
  getSubsData () {
    return JSON.parse(localStorage.getItem('subs'))
  },
  getCurrentSub (state) {
    return state.currentSubs !== '' ? state.currentSubs : 'uums'
  },
  getGuardToSubs () {
    return JSON.parse(localStorage.getItem('guardToSubs'))
  },
  getAdminLevels: state => state.adminLevels
}

const mutations = {
  SET_PAGINATION (state, data) {
    state.pagination.total = data.total
    state.pagination.pageSize = Number(data.pageSize)
    state.pagination.current = data.current
  },
  SET_USER_LIST (state, data) {
    state.userList = data.data.data
  },
  SET_DEPART_TREE (state, data) {
    state.departmentTree = data
  },
  SET_OPTIONS_ALL (state, data) {
    state.allOptions = data
  },
  SET_PAGE_LOADING (state, data) {
    state.pageLoading = data
  },
  SET_SELECT_ROWS (state, data) {
    state.selectRows = data
  },
  SET_IS_GROUP_SET (state, data) {
    state.isGroupSet = data
  },
  SET_CURRENT_USER (state, data) {
    state.currentUser = data
  },
  SET_USER_FILTERS (state, data) {
    state.filters = data
  },
  SET_ALL_SUBS_DATA (state, data) {
    state.subsData = data.data
    let guardToSubs = {}
    for (let i in data.data) {
      guardToSubs[(data.data[i]['guard_name'])] = data.data[i]['locale']
    }
    localStorage.setItem('subs', JSON.stringify(data.data))
    localStorage.setItem('guardToSubs', JSON.stringify(guardToSubs))
  },
  SET_CURRENT_SELECTED_SUB (state, data) {
    state.currentSubs = data
  },
  SET_ALL_ADMIN_LEVEL (state, data) {
    state.adminLevels = data.data
  },
  SET_SBUSIDIARY_COMPANIES (state, data) {
    state.subsidiaryCompanies = data
  }
}

const actions = {
  async getUsersList ({ commit }, params) {
    commit('SET_PAGE_LOADING', true)
    params.append = ['department_ids']
    let data = await getUsers(params)
    commit('SET_PAGE_LOADING', false)
    commit('SET_USER_LIST', data)
    let pagination = {
      total: data.data.total,
      current: data.data.current_page,
      pageSize: data.data.per_page
    }
    commit('SET_PAGINATION', pagination)
  },
  async TableChange ({ commit, dispatch, state }, params) {
    let sendData = {
      limit: params.pageSize,
      page: params.current,
      include: 'department,positions,posts,company',
      filters: state.filters
    }
    await dispatch('getUsersList', sendData)
    commit('SET_PAGINATION', params)
  },
  async getUser ({ state, dispatch, commit }) {
    commit('SET_SELECT_ROWS', [])
    let params = {
      limit: state.pagination.pageSize,
      page: state.pagination.current,
      include: 'department,positions,posts,company',
      filters: state.filters
    }
    await dispatch('getUsersList', params)
  },
  async deleteUser ({ dispatch }, id) {
    return delUser(id)
  },
  async fetchAllSubs ({ commit }) {
    let data = await getGuardNames()
    commit('SET_ALL_SUBS_DATA', data)
  },
  async fetchAllAdminLevel ({ commit }) {
    let data = await getAllAdminLevels()
    commit('SET_ALL_ADMIN_LEVEL', data)
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
