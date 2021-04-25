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
        isUser: function() {
            const user = store.getters['Auth/user']
            if (user) {
                return user
            }
            return false
        },
    },


    methods: {
        logout() {
            Swal.fire({
                title: 'Ready to Leave?',
                text: 'Select "Logout" below if you are ready to end your current session.',
                // icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Log out the user.
                    this.$store.dispatch('Auth/logout')
                        // await this.$store.dispatch('Items/clear')
                        // await this.$store.dispatch('Settings/clear')
                        // await this.$store.dispatch('Customer/clear')

                    // Redirect to login.
                    this.$router.push({
                        name: 'login'
                    })
                }
            })

        },
    }
})