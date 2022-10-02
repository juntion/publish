import { getDepartmentsTree } from '../../../api/userManage'

const state = {
  departmentListData: [],
  departmentPageLoading: false,
  currentDepartment: {
    locale: '{"en": ""}'
  },
  filter: {},
  selectDepartmentTree: [],
  allErpProfiles: []
}

const actions = {
  async fetchDepartmentTree ({ commit }) {
    commit('SET_DEPARTMENT_LOADING', true)
    let data = await getDepartmentsTree({ filters: state.filter })
    commit('SET_DEPARTMENT_LIST', data)
    commit('SET_DEPARTMENT_LOADING', false)
  }
}

const getters = {
  getDepartmentListData: state => state.departmentListData,
  getDepartmentPageLoading: state => state.departmentPageLoading,
  getCurrentDepartment: state => state.currentDepartment,
  getSelectDepartment: state => state.selectDepartmentTree,
  getErpAllProfiles: state => state.allErpProfiles
}

const mutations = {
  SET_DEPARTMENT_LIST (state, data) {
    state.departmentListData = data.data.trees
  },
  SET_DEPARTMENT_LOADING (state, data) {
    state.departmentPageLoading = data
  },
  SET_CURRENT_DEPARTMENT_DATA (state, data) {
    state.currentDepartment = data
  },
  SET_DEPARTMENT_DATA_FILTER (state, data) {
    state.filter = data
  },
  SET_SELECT_DEPART_TREE (state, data) {
    state.selectDepartmentTree = data
  },
  SET_ERP_PROFILES (state, data) {
    state.allErpProfiles = data
  }
}

export default {
  actions,
  state,
  mutations,
  getters
}
