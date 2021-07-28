import axios from 'axios'
import * as types from './mutation-types'

// state
export const state = {
    ItemsPrice: null,
}


export const getters = {
    ItemsPrice: state => state.ItemsPrice,
}


export const mutations = {
      //ItemsPrice
      [types.FETCH_CUSTOMER_PRICE_SUCCESS](state, { ItemsPrice }) {
        state.ItemsPrice = ItemsPrice
    },
    [types.CLEAR_ALL](state) {
        state.ItemsPrice = null 
    }
}


export const actions = {
    async fetchCustomerPrice({ commit }, payload) {
        try {
            const { data } = await axios.get('/api/invoice/process', {
                params: {
                    trntype: 'items-price',
                    branch: payload.branch, 
                    pricelist: payload.pricelist, 
                    cid: payload.cid, 
                }
            })   
            commit(types.FETCH_CUSTOMER_PRICE_SUCCESS, { 
                ItemsPrice: data
            })
        } catch (e) {
            commit(types.FETCH_CUSTOMER_PRICE_FAILURE)
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