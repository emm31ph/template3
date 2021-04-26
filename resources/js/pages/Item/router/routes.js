function page(path) {
    return () =>
        import ( /* webpackChunkName: '' */ `~/pages/${path}`).then(
            m => m.default || m
        )
}

export default [{
    path: '/item',
    name: 'item',
    redirect: { name: 'items-list' },
    component: page('Item/view/main.vue'),
    children: [{
        path: 'delivery',
        name: 'delivery',
        component: page('Item/view/delivery.vue')
    }, {
        path: 'import',
        name: 'import',
        component: page('Item/view/import.vue')
    }, {
        path: 'list',
        name: 'items-list',
        component: page('Item/view/list.vue')
    }, ]
}]