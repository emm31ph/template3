function page(path) {
    return () =>
        import ( /* webpackChunkName: '' */ `~/pages/${path}`).then(
            m => m.default || m
        )
}

let routes
export default routes = [{
        path: '/login',
        name: 'login',

        component: page('Auth/view/login.vue')
    },
    {
        path: '/register',
        name: 'register',

        component: page('Auth/view/Register.vue')
    },

    {
        path: '/dashboard',
        name: 'dashboard',

        component: page('Auth/view/dashboard.vue')
    },

]