import { addSubForbid, delSubForbid, getSubs, getUserSubForbid } from '../../../api/userManage'

const state = {
  subSystemList: [],
  forbiddenSubsystems: []
}

const actions = {
  async getSubsList ({ commit }) {
    let data = await getSubs()
    commit('SET_SUBSYSTEM_LIST', data.data.subsystems)
  },
  async getForbiddenList ({ commit }, params) {
    let data = await getUserSubForbid(params)
    commit('SET_FORBIDDEN_SUBSYSTEM', data.data.subsystems)
  },
  async changeForbidStatus ({ dispatch }, params) {
    if (params.enable) {
      await delSubForbid(params)
    } else {
      await addSubForbid(params)
    }
    await dispatch('getForbiddenList', params)
    await dispatch('getSubsList', params)
  }
}

const mutations = {
  SET_SUBSYSTEM_LIST (state, data) {
    state.subSystemList = data
  },
  SET_FORBIDDEN_SUBSYSTEM (state, data) {
    state.forbiddenSubsystems = data
  }
}

const getters = {
  getSubSystemList: state => state.subSystemList,
  getForbiddenSubs: state => state.forbiddenSubsystems
}

export default {
  state,
  actions,
  mutations,
  getters
}
