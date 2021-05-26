import axios from 'axios'
import * as types from './mutation-types'


// state
export const state = {
    role: null,
}

// getters
export const getters = {
    role: state => state.role,
}

// mutations
export const mutations = {

    [types.FETCH_ROLES_SUCCESS](state, { role }) {
        state.role = role
    },

    [types.FETCH_ROLES_FAILURE](state) {
        state.role = null

    },

    [types.UPDATE_ROLES](state, { role }) {
        state.role = role
    }
}

// actions
export const actions = {

    async fetchRoles({ commit }) {
        try {
            const { data } = await axios.get('/api/roles')

            commit(types.FETCH_ROLES_SUCCESS, { role: data })
        } catch (e) {
            commit(types.FETCH_ROLES_FAILURE)
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