function page(path) {
    return () =>
        import ( /* webpackChunkName: '' */ `~/pages/${path}`).then(
            m => m.default || m
        )
}

export default [{
    path: '/login',
    name: 'login',
    meta: { layout: 'default' },
    component: page('Auth/view/login.vue')
}, {
    path: '/dashboard',
    name: 'dashboard',
    meta: { layout: 'default' },
    component: page('Auth/view/dashboard.vue')
}, ]