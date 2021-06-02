function page(path) {
    return () =>
        import( /* webpackChunkName: '' */ `~/pages/${path}`).then(
            m => m.default || m
        )
}

export default [{
    path: '/users',
    name: 'users',
    redirect: { name: 'users-list' },
    component: page('User/view/main.vue'),
    children: [{
        path: 'profile',
        name: 'profile',
        component: page('User/view/profile.vue')
    }, {
        path: 'list',
        name: 'users-list',
        meta: { layout: 'default' },
        component: page('User/view/list.vue')
    },]
}]