import axios from 'axios'
import * as types from './mutation-types'

// state
export const state = {
    items: null,
    allitems: null,
}

// getters
export const getters = {
    items: state => state.items,
    allitems: state => state.allitems,
}

// mutations
export const mutations = {
    [types.FETCH_ITEMS_SUCCESS](state, { items }) {
        state.items = items
    },
    [types.FETCH_ITEMS_FAILURE](state) {
        state.items = null
    },

    [types.FETCH_ALL_ITEMS_SUCCESS](state, { allitems }) {
        state.allitems = allitems
    },
    [types.FETCH_ALL_ITEMS_FAILURE](state) {
        state.allitems = null
    },
    [types.CLEAR_ALL](state) {
        state.items = null
        state.allitems = null
    }
}

// actions
export const actions = {
    async fetchItems({ commit }, payload) {
        try {
            const { data } = await axios.get('/api/items/getitems', {
                params: {
                    branch: payload.branch,
                    trndate: payload.trndate
                }
            })
            commit(types.FETCH_ITEMS_SUCCESS, {
                items: data
            })
        } catch (e) {
            commit(types.FETCH_ITEMS_FAILURE)
        }
    },

    async fetchAllItems({ commit }) {
        try {
            const { data } = await axios.get('/api/items/getAllitems')

            commit(types.FETCH_ALL_ITEMS_SUCCESS, {
                allitems: data
            })
        } catch (e) {
            commit(types.FETCH_ALL_ITEMS_FAILURE)
        }
    },
    async clear({ commit }) {

        commit(types.CLEAR_ALL)
    }
}
export default {
    namespaced: true,
    state,
    actions,
    getters,
    mutations
}