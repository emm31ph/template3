import Vue from 'vue'
import store from '~/store'
import axios from 'axios'


Vue.mixin({
    computed: {
        getProducts() {
            const data = store.getters['Items/allitems']
            if (data) {
                return data
            }

        },
    },

    methods: {
        async fetchProducts() {
            await this.$store.dispatch("Items/fetchAllItems");
        },
    }

})