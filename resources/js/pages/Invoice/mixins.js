import Vue from 'vue'
import store from '~/store'
import axios from 'axios'


Vue.mixin({
    data() {
        return {

        }
    },
    computed: {
        getList() {
            const data = store.getters['Invoice/list']
            if (data) {
                return data
            }

        },
    },
    methods: {
        async fetchInvoiceList() {
            await this.$store.dispatch("Invoice/fetchList");
        },
    }
})