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
        path: '',
        name: 'report-view',
        component: page('Item/view/report/ReportView.vue'),
        props: true

    },{
        path: '',
        name: 'report-wp',
        component: page('Item/view/report/wp.vue'),
        props: true
    },{
        path: '',
        name: 'report-adj',
        component: page('Item/view/report/adjustment.vue'),
        props: true
    },{
        path: '',
        name: 'report-dlvry',
        component: page('Item/view/report/dlvry.vue'),
        props: true
    },{
        path: '',
        name: 'report-rr',
        component: page('Item/view/report/rr.vue'),
        props: true
    },{
        path: '',
        name: 'report-rrm',
        component: page('Item/view/report/rrm.vue'),
        props: true
    },{
        path: '',
        name: 'report-rj',
        component: page('Item/view/report/reject.vue'),
        props: true
    },{
        path: '',
        name: 'report-rev',
        component: page('Item/view/report/reversal.vue'),
        props: true
    },{
        path: '',
        name: 'report-can',
        component: page('Item/view/report/cancelled.vue'),
        props: true
    },{
        path: '',
        name: 'report-imp',
        component: page('Item/view/report/import.vue'),
        props: true
    },

    {
        path: '',
        name: 'delivery',
        component: page('Item/view/delivery.vue')
    }, {
        path: '',
        name: 'import',
        component: page('Item/view/import.vue')
    }, {
        path: '',
        name: 'items-list',
        component: page('Item/view/list.vue')
    }, {
        path: '',
        name: 'items-reject',
        component: page('Item/view/reject.vue')
    }, {
        path: '',
        name: 'items-rr',
        component: page('Item/view/rr.vue')
    }, {
        path: '',
        name: 'items-rrm',
        component: page('Item/view/rrm.vue')
    }, {
        path: '',
        name: 'items-fptd',
        component: page('Item/view/fptd.vue')
    }, {
        path: '',
        name: 'items-adjust',
        component: page('Item/view/adjustment.vue')
    }, {
        path: '',
        name: 'delivery-edit',
        component: page('Item/view/edit/delivery.vue'), 
        props: true
    }]
}]