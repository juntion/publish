import { getAllprojects } from '@/api/RDmanagement/project'

const state = {
  projectsData: []
}

const getters = {
  getProjects: state => state.productsData
}

const mutations = {
  getProjects (state, productsData) {
    state.projectsData = productsData
  }
}

const actions = {
  getProjects ({ commit }) {
    return new Promise((resolve, reject) => {
      let search = []
      search['status'] = 1
      getAllprojects({ page: 1, limit: 30, filters: search }).then(res => {
        commit('getProjects', res.data.data)
        resolve(res.data)
      })
    })
  }
}

export default {
  state,
  actions,
  mutations,
  getters
}
