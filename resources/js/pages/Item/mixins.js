import Vue from 'vue'
import store from '~/store'
import axios from 'axios'


Vue.mixin({
    computed: {

        getItems() {
            if (this.isUser) {
                const data = store.getters['Item/items']

                if (data) {
                    return data
                }
            }
            return false
        },
        getAllItems() {
            const data = store.getters['Item/allitems']
            if (data) {
                return data
            }

        },

        getAllItemsBranch() {
            const data = store.getters['Item/items']
            if (data) {
                return data
            }

        },

        getItemsOut() {
            const data = store.getters['Item/items']
            if (data) {
                return data
            }

        },
    },
    methods: {
        async fetchItemsOut() {
            await this.$store.dispatch("Item/fetchItemsOut");
        },
        async fetchAllItemsBranch() {
            await this.$store.dispatch("Item/fetchAllItemsBranch");
        },
        async fetchAllItems() {
            await this.$store.dispatch("Item/fetchAllItems");
        },
        async fetchItems() {
            await this.$store.dispatch("Item/fetchItems");
        },

        onChangeItems(value) {
            // this.fetchAllItems();
        },
    }
});