import Vue from 'vue'
import store from '~/store'
import axios from 'axios'

Vue.mixin({
    computed: {
        isLogged: function() {
            const isLoggedIn = store.getters['Auth/check']
            if (isLoggedIn) {
                return true
            }
            return false
        },
    },


    methods: {


        async logout() {
            // Log out the user.
            await this.$store.dispatch('Auth/logout')
                // await this.$store.dispatch('Items/clear')
                // await this.$store.dispatch('Settings/clear')
                // await this.$store.dispatch('Customer/clear')

            // Redirect to login.
            this.$router.push({
                name: 'login'
            })
        },
    }
})