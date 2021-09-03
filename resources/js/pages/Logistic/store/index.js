import axios from 'axios'
import * as types from './mutation-types'

// state
export const state = {
    ShippingList: null,
    PacklingList: null,
}


export const getters = {
    ShippingList: state => state.ShippingList,
    PacklingList: state => state.PacklingList,
}


export const mutations = {
    //ShippingList
    [types.FETCH_SHIPPING_LIST_SUCCESS](state, { ShippingList }) {
        state.ShippingList = ShippingList
    },
    //ShippingList
    [types.FETCH_PACKING_LIST_SUCCESS](state, { PacklingList }) {
        state.PacklingList = PacklingList
    },
    [types.CLEAR_ALL](state) {
        state.ShippingList = null
        state.PacklingList = null
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
    async fetchPackingList({ commit }, payload) {
        try {
            const { data } = await axios.get('/api/process/logistic', {
                params: {
                    trnmode: payload.trnmode,
                    branch: payload.branch,
                }
            })
            commit(types.FETCH_PACKING_LIST_SUCCESS, {
                PackingList: data
            })
        } catch (e) {
            commit(types.FETCH_PACKING_LIST_FAILURE)
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