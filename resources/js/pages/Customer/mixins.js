import Vue from 'vue'
import store from '~/store'
import axios from 'axios'


import camelCase from 'lodash/camelCase'
import upperFirst from 'lodash/upperFirst'

var moment = require('moment');

Vue.mixin({

    computed: {
        getCustomer(){
            if (this.isUser) { 
                const getCustmer = store.getters['Customer/customers'] 
                if (getCustmer) {
                    return getCustmer
                }
            }
            return [];
        }
    },
    methods: { 
        fetchCustomer() {
            this.$store.dispatch("Customer/fetchCustomer", {
                branch: this.isUser.branch
            });
        },
    }


})