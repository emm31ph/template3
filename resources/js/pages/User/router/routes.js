function page(path) {
    return () =>
        import ( /* webpackChunkName: '' */ `~/pages/${path}`).then(
            m => m.default || m
        )
}

export default [{
    path: '/user',
    name: 'user',
    component: page('User/view/main.vue'),
    children: [{
        path: 'profile',
        name: 'profile',
        component: page('User/view/profile.vue')
    }, ]
}]