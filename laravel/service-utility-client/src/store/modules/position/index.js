import { getPositionPageData } from '../../../api/position'

const state = {
  positionPagination: {
    total: 0,
    showSizeChanger: true,
    current: 1,
    pageSize: 20,
    pageSizeOptions: ['20', '50', '100']
  },
  positionsListData: [],
  positionPageLoading: false,
  currentPositionData: {
    locale: '{"en": ""}'
  },
  filters: {}
}

const mutations = {
  SET_POSITION_LIST_PAGINATION (state, data) {
    state.positionPagination.total = data.total
    state.positionPagination.pageSize = Number(data.pageSize)
    state.positionPagination.current = data.current
  },
  SET_POSITION_DATA (state, data) {
    state.positionsListData = data.data.data
  },
  SET_POSITION_LOADING (state, data) {
    state.positionPageLoading = data
  },
  SET_CURRENT_POSITION (state, data) {
    state.currentPositionData = data
  },
  SET_POSITION_DATA_FILTER (state, data) {
    state.filters = data
  }
}

const actions = {
  async getPositionsListData ({ commit, state }, params) {
    let data = await getPositionPageData(params)
    commit('SET_POSITION_LOADING', false)
    commit('SET_POSITION_DATA', data)
    let pagination = {
      total: data.data.total,
      current: data.data.current_page,
      pageSize: data.data.per_page
    }
    commit('SET_POSITION_LIST_PAGINATION', pagination)
  },
  async positionPageChange ({ commit, dispatch }, params) {
    commit('SET_POSITION_LOADING', true)
    let sendData = { 'limit': params.pageSize, 'page': params.current }
    await dispatch('getPositionsListData', sendData)
  },
  async getPositionIndexData ({ dispatch, commit }) {
    commit('SET_POSITION_LOADING', true)
    let params = {
      limit: state.positionPagination.pageSize,
      page: state.positionPagination.current,
      filters: state.filters
    }
    await dispatch('getPositionsListData', params)
  }
}

const getters = {
  getPositionListPagination: state => state.positionPagination,
  getPositionListData: state => state.positionsListData,
  getPositionPageLoading: state => state.positionPageLoading,
  getCurrentPosition: state => state.currentPositionData
}

export default {
  state,
  mutations,
  actions,
  getters
}
