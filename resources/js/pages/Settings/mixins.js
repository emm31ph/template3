import Vue from 'vue'
import store from '~/store'
import axios from 'axios'


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
        }
    },
    methods: {
        async fetchBranch() {
            await this.$store.dispatch("Settings/fetchBranch");
        },
        formatNumber(value) {
            return value.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        },
        printme() {
            this.$htmlToPaper('printMe')
        },

    }
});