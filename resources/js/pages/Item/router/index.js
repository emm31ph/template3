function page(path) {
    return () =>
        import ( /* webpackChunkName: '' */ `~/pages/${path}`).then(
            m => m.default || m
        )
}

export default [{
    path: '/item',
    name: 'item',
    component: page('Item/view/main.vue'),
    children: [{
        path: 'profile',
        name: 'profile',
        component: page('Item/view/profile.vue')
    }, ]
}]