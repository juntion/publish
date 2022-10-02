import { getTemplates } from '../../../api/sidebar'

const state = {
  templatePageLoading: false,
  templatePageList: [],
  templatePagePagination: {
    total: 0,
    showSizeChanger: true,
    current: 1,
    pageSize: 20,
    pageSizeOptions: ['20', '50', '100']
  },
  templateFilters: {},
  currentTemplateData: {
    locale: '{"en": ""}'
  }
}

const actions = {
  async fetchTemplate ({ state, commit, getters }, data) {
    state.templateFilters.guard_name = getters.getCurrentSub
    commit('SET_TEMPLATE_PAGE_LOADING', true)
    let params = {
      limit: data !== undefined ? data.pageSize : state.templatePagePagination.pageSize,
      page: data !== undefined ? data.current : state.templatePagePagination.current,
      filters: state.templateFilters
    }
    const res = await getTemplates(params)
    commit('SET_TEMPLATE_PAGE_LOADING', false)
    commit('SET_TEMPLATE_DATA_LIST', res)
    commit('SET_TEMPLATE_PAGINATION', res)
  }
}

const getters = {
  getTemplatesData: state => state.templatePageList,
  getTemplatePageLoading: state => state.templatePageLoading,
  getTemplatePagination: state => state.templatePagePagination,
  getTemplateCurrentData: state => state.currentTemplateData
}

const mutations = {
  SET_TEMPLATE_PAGE_LOADING (state, data) {
    state.templatePageLoading = data
  },
  SET_TEMPLATE_DATA_LIST (state, data) {
    state.templatePageList = data.data.data
  },
  SET_TEMPLATE_PAGINATION (state, data) {
    state.templatePagePagination.total = data.data.total
    state.templatePagePagination.pageSize = Number(data.data.per_page)
    state.templatePagePagination.current = data.data.current_page
  },
  SET_TEMPLATE_FILTER (state, data) {
    state.templateFilters = data
  },
  SET_TEMPLATE_CURRENT_DATA (state, data) {
    state.currentTemplateData = data
  }
}

export default {
  state,
  actions,
  getters,
  mutations
}
