import axios from 'axios'
import * as types from './mutation-types'

// state
export const state = {
    branch: null,
}

// getters
export const getters = {
    branch: state => state.branch,
}

// mutations
export const mutations = {
    [types.FETCH_BRANCH_SUCCESS](state, { branch }) {
        state.branch = branch
    },
    [types.FETCH_BRANCH_FAILURE](state) {
        state.branch = null
    },

    [types.CLEAR_ALL](state) {
        state.branch = null
    }
}

// actions
export const actions = {
    async fetchBranch({ commit }) {
        try {
            const { data } = await axios.get('/api/branches/getbranch')
            commit(types.FETCH_BRANCH_SUCCESS, {
                branch: data
            })
        } catch (e) {
            commit(types.FETCH_BRANCH_FAILURE)
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