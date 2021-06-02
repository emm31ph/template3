import axios from 'axios'
import * as types from './mutation-types'


// state
export const state = {
    role: null,
    permission: null,
}

// getters
export const getters = {
    role: state => state.role,
    permission: state => state.permission,
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
    },

    [types.FETCH_PERMISSIONS_SUCCESS](state, { permission }) {
        state.permission = permission
    },

    [types.FETCH_PERMISSIONS_FAILURE](state) {
        state.permission = null

    },

    [types.UPDATE_PERMISSIONS](state, { permission }) {
        state.permission = permission
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

    async fetchPermissions({ commit }) {
        try {
            const { data } = await axios.get('/api/permissions')

            commit(types.FETCH_PERMISSIONS_SUCCESS, { permission: data })
        } catch (e) {
            commit(types.FETCH_PERMISSIONS_FAILURE)
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