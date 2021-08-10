import axios from 'axios'
import * as types from './mutation-types'

// state
export const state = {
    ShippingList: null,
}


export const getters = {
    ShippingList: state => state.ShippingList,
}


export const mutations = {
      //ShippingList
      [types.FETCH_SHIPPING_LIST_SUCCESS](state, { ShippingList }) {
        state.ShippingList = ShippingList
    },
    [types.CLEAR_ALL](state) {
        state.ShippingList = null 
    }
}


export const actions = {
    async fetchShippingList({ commit }, payload) {
        try {
            const { data } = await axios.get('/api/process/logistic', {
                params: {
                    trnmode: payload.trnmode,
                    branch: payload.branch,  
                }
            })   
            commit(types.FETCH_SHIPPING_LIST_SUCCESS, { 
                ShippingList: data
            })
        } catch (e) {
            commit(types.FETCH_SHIPPING_LIST_FAILURE)
        }
    },
}


export default {
    namespaced: true,
    state,
    actions,
    getters,
    mutations
}