import { getProducts, claimList } from '@/api/recount'

const state = {
  guidaStatus1: false,
  guidaStatus2: false,
  guidaStatus3: false,
  guidaStatus4: false,
  guidaStatus5: false,
  claimListData: [],
  pageWidth: ''
}
const actions = {
  async getClaimList ({ commit }) {
    await claimList().then(res => {
      commit('getclaimListall', res.data.data)
    })
  }

}
const mutations = {
  getclaimListall (state, data) {
    state.claimListData = data
  },
  changeValue (state, newVal) {
    state.pageWidth = newVal
  },
  changeGuide1 (state, newVal) {
    state.guidaStatus1 = newVal
  },
  changeGuide2 (state, newVal) {
    state.guidaStatus2 = newVal
  },
  changeGuide3 (state, newVal) {
    state.guidaStatus3 = newVal
  },
  changeGuide4 (state, newVal) {
    state.guidaStatus4 = newVal
  },
  changeGuide5 (state, newVal) {
    state.guidaStatus5 = newVal
  }
}

const getters = {
  // getClaimLists:state => state.claimListData,
}

export default {
  state,
  actions,
  mutations,
  getters
}
