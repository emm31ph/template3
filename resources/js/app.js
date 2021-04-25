import Vue from 'vue'

require('./bootstrap')

import store from '~/store'
import router from '~/router'
// import i18n from '~/plugins/i18n'
import App from '~/components/App'

import '~/plugins'
import '~/components'
import '~/dynamics'
import '~/mixins'


window.Swal = require('sweetalert2')

const app = new Vue({
    // i18n,
    store,
    router,
    ...App
});