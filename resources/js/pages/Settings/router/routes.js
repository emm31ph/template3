function page(path) {
    return () =>
        import( /* webpackChunkName: '' */ `~/pages/${path}`).then(
            m => m.default || m
        )
}

export default [{
    path: '/settings',
    name: 'settings',
    redirect: { name: 'settings-l' },
    component: page('Settings/view/main.vue'),
    children: [{
        path: 'salesperson',
        name: 'settings-salesperson',
        meta: { layout: 'default' },
        component: page('Settings/view/SalesPerson.vue')
    },{
        path: 'listb',
        name: 'settings-l',
        meta: { layout: 'default' },
        component: page('Settings/view/blank.vue')
    },{
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
    },{
        path: 'price-customer',
        name: 'price-customer',
        meta: { layout: 'default' },
        component: page('Settings/view/PriceCustomer.vue')
    },]
}]