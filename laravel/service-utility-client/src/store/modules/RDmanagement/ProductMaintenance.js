import { getProductsData } from '@/api/RDmanagement/ProductMaintenance'

const state = {
  productsData: []
}

const getters = {
  getProducts: state => state.productsData
}

const mutations = {
  getProducts (state, productsData) {
    state.productsData = productsData
  }
}

const actions = {
  getProducts ({ commit }) {
    return new Promise((resolve, reject) => {
      getProductsData().then(res => {
        commit('getProducts', res.data.products)
        localStorage.setItem('products', JSON.stringify(res.data.products))
        resolve(res.data.products)
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
