import Vue from 'vue'
import store from '~/store'
import axios from 'axios'

Vue.mixin({

    computed: {
        segment: function () {
            const pathArray = window.location.pathname.split("/");
            const segment_1 = pathArray[1];

            return segment_1
        },
        isLogged: function () {
            const isLoggedIn = store.getters['Auth/check']
            if (isLoggedIn) {
                return true
            }
            return false
        },
        isLoggedCheck: function () {
            axios.get('/api/user').then(res => {
                if (res.data.id !== undefined) {
                    return true;
                }
                if (res.data.status !== null) {
                    this.autologout();

                    return false;
                }

            });
        },
        isUser: function () {
            const user = store.getters['Auth/user']
            if (user) {
                return user
            }
            return false
        },
    },


    methods: {
        async autologout() {
            await this.$store.dispatch('Auth/logout')
            await this.$store.dispatch('Item/clear')
            await this.$store.dispatch('Settings/clear')
            // await this.$store.dispatch('Customer/clear')

            // Redirect to login.
            this.$router.push({
                name: 'login'
            })
        },
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

                    // // Redirect to login.
                    // this.$router.push({
                    //     name: 'login'
                    // }).catch(error => {
                    //     console.info(error.message)
                    // })
                    this.$router.push('/');
                }
            })

        },
    }
})