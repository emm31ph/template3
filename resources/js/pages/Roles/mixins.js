import Vue from 'vue'
import store from '~/store'
import axios from 'axios'


import camelCase from 'lodash/camelCase'
import upperFirst from 'lodash/upperFirst'

var moment = require('moment');

Vue.mixin({

    computed: {
        getRoles() {
            if (this.isUser) {

                const getRole = store.getters['Roles/roles']
                if (getRole) {
                    return getRole
                }
            }
            return false
        },
    },

    methods: {
        fetchRoles() {
            this.$store.dispatch("Roles/fetchRoles");
        },
    }

});