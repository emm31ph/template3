import Vue from 'vue'
import store from '~/store'
import axios from 'axios'


Vue.mixin({
    computed: {
        checkBal(perBox = 0, qty = 0, numperuompu = 0, bal = 0, uom = 'CASE') {

            return bal - (uom == 'CASE' ? qty * perbox : qty);
        },


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
        toCase(perBox = 0, qty = 0) {
            return qty/perBox
            // return (qty > 0 ? 1 : -1) *
            //     (Math.floor(
            //         qty /
            //         ((qty >= 0 ? 1 : -1) *
            //             perBox)
            //     ) +
            //         (qty %
            //             ((qty >= 0 ? 1 : -1) *
            //                 perBox)) /
            //         ((qty >= 0 ? 1 : -1) *
            //             100))
        },
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