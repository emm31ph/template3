import Vue from 'vue'
import store from '~/store'
import axios from 'axios'


Vue.mixin({
    computed: {

        getItems() {
            if (this.isUser) {
                const data = store.getters['Item/items']
                console.log(data);
                if (data) {
                    return data
                }
            }
            return false
        },
        getAllItems() {
            const data = store.getters['Items/allitems']
            if (data) {
                return data
            }

        },
    },
    methods: {
        async fetchAllItems() {
            await this.$store.dispatch("Items/fetchAllItems");
        },
        async fetchItems() {
            await this.$store.dispatch("Items/fetchItems");
        },

        onChangeItems(value) {
            // this.fetchAllItems();
        },
    }
});