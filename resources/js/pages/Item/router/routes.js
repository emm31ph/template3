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
        path: 'report-view',
        name: 'report-view',
        component: page('Item/view/report/ReportView.vue'),
        props: true

    },{
        path: 'report-wp',
        name: 'report-wp',
        component: page('Item/view/report/wp.vue'),
        props: true
    },{
        path: 'report-dlvry',
        name: 'report-dlvry',
        component: page('Item/view/report/dlvry.vue'),
        props: true
    },{
        path: 'report-rr',
        name: 'report-rr',
        component: page('Item/view/report/rr.vue'),
        props: true
    },{
        path: 'report-rrm',
        name: 'report-rrm',
        component: page('Item/view/report/rrm.vue'),
        props: true
    },{
        path: 'report-rj',
        name: 'report-rj',
        component: page('Item/view/report/reject.vue'),
        props: true
    },{
        path: 'report-rev',
        name: 'report-rev',
        component: page('Item/view/report/reversal.vue'),
        props: true
    },{
        path: 'report-can',
        name: 'report-can',
        component: page('Item/view/report/cancelled.vue'),
        props: true
    },{
        path: 'report-imp',
        name: 'report-imp',
        component: page('Item/view/report/import.vue'),
        props: true
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
    }, {
        path: 'itemsadjust',
        name: 'items-adjust',
        component: page('Item/view/adjustment.vue')
    }, {
        path: 'delivery-edit',
        name: 'delivery-edit',
        component: page('Item/view/edit/delivery.vue'), 
        props: true
    }]
}]