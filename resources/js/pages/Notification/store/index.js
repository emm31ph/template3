import axios from 'axios'
import * as types from './mutation-types'


// state
export const state = {
    unreadnotify: null,
}

// getters
export const getters = {
    unreadnotify: state => state.unreadnotify,
}

// mutations
export const mutations = {

    [types.FETCH_UNREAD_SUCCESS](state, { unreadnotify }) {
        state.unreadnotify = unreadnotify
    },

    [types.FETCH_UNREAD_FAILURE](state) {
        state.unreadnotify = null

    },

}

// actions
export const actions = {

    async fetchUnReadNotify({ commit }) {
        try {
            const { data } = await axios.get('/api/unreadNotification')
            commit(types.FETCH_UNREAD_SUCCESS, { unreadnotify: data })
        } catch (e) {
            commit(types.FETCH_UNREAD_FAILURE)
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