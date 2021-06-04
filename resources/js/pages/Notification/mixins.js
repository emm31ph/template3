import Vue from 'vue'
import store from '~/store'
import axios from 'axios'


Vue.mixin({

    computed: {
        getUnReadNoti() {
            if (this.isUser) {
                const data = store.getters['Notification/unreadnotify'];

                if (data) {
                    return data
                }
            }
            return false
        }
    },
    methods: {
        async fetchMixinsUnReadNotify() {
            await this.$store.dispatch("Notification/fetchUnReadNotify");
            await this.$nextTick()
        }
    },
})