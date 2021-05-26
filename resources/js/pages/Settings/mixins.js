import Vue from 'vue'
import store from '~/store'
import axios from 'axios'


import camelCase from 'lodash/camelCase'
import upperFirst from 'lodash/upperFirst'

var moment = require('moment');

Vue.mixin({

    computed: {

        getBranch() {
            if (this.isUser) {

                const getBranch = store.getters['Settings/branch']
                if (getBranch) {
                    return getBranch
                }
            }
            return false
        },
    },
    methods: {
        dataF(value) {
            return moment(value).format('YYYY-MM-DD');
        },
        Ucase(value) {
            return (value || '').toUpperCase()
        },
        async fetchBranch() {
            await this.$store.dispatch("Settings/fetchBranch");
        },
        formatNumber(value) {
            if (value == 0) {
                return null;
            }
            return value.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        },
        printme() {
            this.$htmlToPaper('printMe')
        },
        validateNumber: (event) => {
            let keyCode = event.keyCode;
            if (keyCode < 48 || keyCode > 57) {
                event.preventDefault();
            }
        },

    }
});