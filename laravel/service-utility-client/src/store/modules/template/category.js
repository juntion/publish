import { getTemplateTree } from '../../../api/sidebar'
import { getSubsAllPage } from '../../../api/subsystem'

const state = {
  currentCateData: {
    locale: '{"en": ""}'
  },
  currentTemplateId: 0,
  dataTree: [],
  templatePages: [
    {
      locale: '{"en": ""}'
    }
  ]
}

const actions = {
  async getTemplateTreeByTId ({ commit, state }) {
    let params = {
      id: state.currentTemplateId
    }
    let data = await getTemplateTree(params)
    commit('SET_TEMPLATE_TREE_DATA', data)
  },
  async fetchTemplatePages ({ commit, state }, send) {
    let params = {
      guard_name: send.guard_name
    }
    let data = await getSubsAllPage(params)
    commit('SET_TEMPLATE_PAGES_DATA', data)
  }
}

const getters = {
  getTemplateTreeData: state => state.dataTree,
  getCurrentCateData: state => state.currentCateData,
  getCurrentTemplateId: state => state.currentTemplateId,
  getCurrentTemplatePages: state => state.templatePages
}

const mutations = {
  SET_CURRENT_CATE_DATA (state, data) {
    state.currentCateData = data
  },
  SET_TEMPLATE_TREE_DATA (state, data) {
    let res = (data.data.trees)
    state.dataTree = res
  },
  SET_CURRENT_TEMPLATE_ID (state, data) {
    state.currentTemplateId = data
  },
  SET_TEMPLATE_PAGES_DATA (state, data) {
    state.templatePages = data.data
  }
}

export default {
  state,
  actions,
  getters,
  mutations
}
