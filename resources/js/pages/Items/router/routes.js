function page(path) {
    return () =>
        import( /* webpackChunkName: '' */ `~/pages/${path}`).then(
            m => m.default || m
        )
}

export default [{
    path: '/product',
    name: 'product',
    redirect: { name: 'product-list' },
    component: page('Items/view/main.vue'),
    children: [{
        path: 'list',
        name: 'product-list',
        component: page('Items/view/list.vue')
    },]
}]