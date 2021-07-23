import axios from 'axios'
import * as types from './mutation-types'

// state
export const state = {
    branch: null,
    pricecat: null,
    pricecust: null,
    pricelist: null,
    lookup: null,
    salesperson: null,
}

// getters
export const getters = {
    branch: state => state.branch,
    pricecat: state => state.pricecat,
    pricecust: state => state.pricecust,
    pricelist: state => state.pricelist,
    lookup: state => state.lookup,
    salesperson: state => state.salesperson,
}

// mutations
export const mutations = {
    //branch
    [types.FETCH_BRANCH_SUCCESS](state, { branch }) {
        state.branch = branch
    },
    [types.FETCH_BRANCH_FAILURE](state) {
        state.branch = null
    },
    //category
    [types.FETCH_PRICE_CATEGORY_SUCCESS](state, { pricecat }) {
        state.pricecat = pricecat
    },
    [types.FETCH_PRICE_CATEGORY_FAILURE](state) {
        state.pricecat = null
    }, 
    
    //lookup
    [types.FETCH_LOOKUP_SUCCESS](state, { lookup }) {
        state.lookup = lookup
    },
    [types.FETCH_LOOKUP_FAILURE](state) {
        state.lookup = null
    }, 
    
    //salesperson
    [types.FETCH_SALESPERSON_SUCCESS](state, { salesperson }) {
        state.salesperson = salesperson
    },
    [types.FETCH_SALESPERSON_FAILURE](state) {
        state.salesperson = null
    }, 
    [types.CLEAR_ALL](state) {
        state.branch = null
        state.pricecat = null
        state.pricecust = null
        state.pricelist = null
        state.lookup = null
        state.salesperson = null
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
    async fetchSalesPerson({ commit }) {
        try {
            const { data } = await axios.get('/api/settings/salesperson')
            commit(types.FETCH_SALESPERSON_SUCCESS, {
                salesperson: data
            })
        } catch (e) {
            commit(types.FETCH_SALESPERSON_FAILURE)
        }
    },

    async fetchPriceCategory({ commit }) {
        try {
            const { data } = await axios.get('/api/settings/price', {
                params: {
                    trntype: 'pricecat' 
                }
            }) 
            commit(types.FETCH_PRICE_CATEGORY_SUCCESS, {
                pricecat: data.result
            })
        } catch (e) {
            commit(types.FETCH_PRICE_CATEGORY_FAILURE)
        }
    },


    async fetchLookup({ commit }) {
        try {
            const { data } = await axios.get('/api/settings/lookup')  
            commit(types.FETCH_LOOKUP_SUCCESS, {
                lookup: data
            })
        } catch (e) {
            commit(types.FETCH_LOOKUP_FAILURE)
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