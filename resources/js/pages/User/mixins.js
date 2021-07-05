import Vue from 'vue'
import store from '~/store'


Vue.mixin({
    computed: {
        getUsers() {
            if (this.isUser) {
                const data = store.getters['User/users']

                if (data) {
                    return data
                }
            }
            return false
        },
    },
    methods: {
        async fetchUsers() {
            await this.$store.dispatch("User/fetchUsers");
        },
        isLogged1: function () {
            axios.get('/api/user').then(res => {
                if (res.data.id !== undefined) {
                    
                    return true;
                }
                return false;
            });
        },



    }
});