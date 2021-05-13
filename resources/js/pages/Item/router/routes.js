function page(path) {
    return () =>
        import( /* webpackChunkName: '' */ `~/pages/${path}`).then(
            m => m.default || m
        )
}

export default [{
    path: '/item',
    name: 'item',
    redirect: { name: 'items-list' },
    component: page('Item/view/main.vue'),
    children: [{
        path: 'report-fptd/:id',
        name: 'report-fptd',
        component: page('Item/view/report/fptd.vue')
    }, {
        path: 'report-dlvry/:id',
        name: 'report-dlvry',
        component: page('Item/view/report/dlvry.vue')
    },
    {
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
    }, {
        path: 'reject',
        name: 'items-reject',
        component: page('Item/view/reject.vue')
    }, {
        path: 'rr',
        name: 'items-rr',
        component: page('Item/view/rr.vue')
    }, {
        path: 'rrm',
        name: 'items-rrm',
        component: page('Item/view/rrm.vue')
    }, {
        path: 'fptd',
        name: 'items-fptd',
        component: page('Item/view/fptd.vue')
    },]
}]