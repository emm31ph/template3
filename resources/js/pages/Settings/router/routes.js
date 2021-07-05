function page(path) {
    return () =>
        import( /* webpackChunkName: '' */ `~/pages/${path}`).then(
            m => m.default || m
        )
}

export default [{
    path: '/settings',
    name: 'settings',
    // redirect: { name: 'settings-list' },
    component: page('Settings/view/main.vue'),
    children: [{
        path: 'list',
        name: 'settings-list',
        meta: { layout: 'default' },
        component: page('Settings/view/list.vue')
    },{
        path: 'master-data-items',
        name: 'master-data-items',
        meta: { layout: 'default' },
        component: page('Settings/view/items.vue')
    },{
        path: 'price-list',
        name: 'price-list',
        meta: { layout: 'default' },
        component: page('Settings/view/Pricing.vue')
    },{
        path: 'price-category',
        name: 'price-category',
        meta: { layout: 'default' },
        component: page('Settings/view/PriceCategory.vue')
    },]
}]