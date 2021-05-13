import Vue from 'vue'
import Vuex from 'vuex'

import camelCase from 'lodash/camelCase'
import upperFirst from 'lodash/upperFirst'

Vue.use(Vuex)

const requireContext = require.context('~/pages/', true, /store\/.*index.js$/)

const modules = requireContext
    .keys()
    .map(file => [
        file.replace(/(^.\/)|(\.js$)/g, '').replace('/store/index', ''),
        requireContext(file)
    ])
    .reduce((modules, [name, module]) => {
        if (module.namespaced === undefined) {
            module.namespaced = true
        }
        return { ...modules, [name]: module }
    }, {})




// Load store modules dynamically.
const requireContextInside = require.context('./modules', false, /.*\.js$/)

const modulesInside = requireContextInside.keys()
    .map(file => [file.replace(/(^.\/)|(\.js$)/g, ''), requireContextInside(file)])
    .reduce((modulesInside, [name, module]) => {
        if (module.namespaced === undefined) {
            module.namespaced = true
        }

        return { ...modulesInside, [name]: module }
    }, {})

export default new Vuex.Store({
    modules,
    modulesInside
})