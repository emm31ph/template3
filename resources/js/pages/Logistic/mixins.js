import Vue from 'vue'
import store from '~/store'
import axios from 'axios'


import camelCase from 'lodash/camelCase'
import upperFirst from 'lodash/upperFirst'

var moment = require('moment');

Vue.mixin({

    computed: {
        getShippingList() {
            if (this.isUser) {
                var getShippingAdvice = store.getters['Logistic/ShippingList']
                if (getShippingAdvice) {
                    return getShippingAdvice
                }
            }
            return []
        },
        getPackingList() {
            if (this.isUser) {
                var getPackinglist = store.getters['Logistic/PackingList']
                console.log(getPackinglist);
                if (getPackinglist) {
                    return getPackinglist
                }
            }
            return []
        },
    }
})
