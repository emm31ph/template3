import axios from 'axios'
import * as types from './mutation-types'

// state
export const state = {
    customers: null,
}


export const getters = {
    customers: state => state.customers,
}


export const mutations = {
      //customers
      [types.FETCH_CUSTOMER_SUCCESS](state, { customers }) {
        state.customers = customers
    },
    [types.CLEAR_ALL](state) {
        state.customers = null 
    }
}


export const actions = {
    async fetchCustomer({ commit }) {
        try {
            const { data } = await axios.get('/api/settings/customer', {
                params: {
                    trntype: 'customer-list' 
                }
            })  
            commit(types.FETCH_CUSTOMER_SUCCESS, {
              
                customers: data
            })
        } catch (e) {
            commit(types.FETCH_CUSTOMER_FAILURE)
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