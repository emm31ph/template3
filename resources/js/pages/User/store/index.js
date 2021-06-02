import axios from 'axios'
import * as types from './mutation-types'


// state
export const state = {
    users: null,
}

// getters
export const getters = {
    users: state => state.users,
}

// mutations
export const mutations = {

    [types.FETCH_USERS_SUCCESS](state, { users }) {
        state.users = users
    },

    [types.FETCH_USERS_FAILURE](state) {
        state.users = null

    },

    [types.UPDATE_USERS](state, { users }) {
        state.users = users
    }
}

// actions
export const actions = {

    async fetchUsers({ commit }) {
        try {
            const { data } = await axios.get('/api/users')

            commit(types.FETCH_USERS_SUCCESS, { users: data })
        } catch (e) {
            commit(types.FETCH_USERS_FAILURE)
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