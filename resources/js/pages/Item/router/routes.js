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
        path: '1',
        name: 'report-view',
        component: page('Item/view/report/ReportView.vue'),
        props: true

    },{
        path: '2',
        name: 'report-wp',
        component: page('Item/view/report/wp.vue'),
        props: true
    },{
        path: '3',
        name: 'report-adj',
        component: page('Item/view/report/adjustment.vue'),
        props: true
    },{
        path: '4',
        name: 'report-dlvry',
        component: page('Item/view/report/dlvry.vue'),
        props: true
    },{
        path: '5',
        name: 'report-rr',
        component: page('Item/view/report/rr.vue'),
        props: true
    },{
        path: '6',
        name: 'report-rrm',
        component: page('Item/view/report/rrm.vue'),
        props: true
    },{
        path: '7',
        name: 'report-rj',
        component: page('Item/view/report/reject.vue'),
        props: true
    },{
        path: '8',
        name: 'report-rev',
        component: page('Item/view/report/reversal.vue'),
        props: true
    },{
        path: '9',
        name: 'report-can',
        component: page('Item/view/report/cancelled.vue'),
        props: true
    },{
        path: '10',
        name: 'report-imp',
        component: page('Item/view/report/import.vue'),
        props: true
    },

    {
        path: '11',
        name: 'delivery',
        component: page('Item/view/delivery.vue')
    }, {
        path: '12',
        name: 'import',
        component: page('Item/view/import.vue')
    }, {
        path: '13',
        name: 'items-list',
        component: page('Item/view/list.vue')
    }, {
        path: '14',
        name: 'items-reject',
        component: page('Item/view/reject.vue')
    }, {
        path: '15',
        name: 'items-rr',
        component: page('Item/view/rr.vue')
    }, {
        path: '16',
        name: 'items-rrm',
        component: page('Item/view/rrm.vue')
    }, {
        path: '17',
        name: 'items-fptd',
        component: page('Item/view/fptd.vue')
    }, {
        path: '18',
        name: 'items-adjust',
        component: page('Item/view/adjustment.vue')
    }, {
        path: '19',
        name: 'delivery-edit',
        component: page('Item/view/edit/delivery.vue'), 
        props: true
    }]
}]