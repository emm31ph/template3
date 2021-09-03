import axios from 'axios'
import * as types from './mutation-types'

// state
export const state = {
    list: null,
}


export const getters = {
    list: state => state.list,
}


export const mutations = {
    //list
    [types.FETCH_BOOKING_SUCCESS](state, { list }) {
        state.list = list
    },
    [types.CLEAR_ALL](state) {
        state.list = null
    }
}


export const actions = {
    async fetchInvoiceList({ commit }, payload) {
        try {
            const { data } = await axios.get('/api/invoice/process', {
                params: {
                    trnmode: payload.trnmode,
                    branch: payload.branch
                }
            })
            commit(types.FETCH_BOOKING_SUCCESS, {
                list: data
            })
        } catch (e) {
            commit(types.FETCH_BOOKING_FAILURE)
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