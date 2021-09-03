function page(path) {
    return () =>
        import( /* webpackChunkName: '' */ `~/pages/${path}`).then(
            m => m.default || m
        )
}

export default [{
    path: '/invoice',
    name: 'invoice',
    redirect: { name: 'bookinglist' },
    component: page('Invoice/view/main.vue'),
    children: [{
        path: '1',
        name: 'invoice-create',
        meta: { layout: 'default' },
        component: page('Invoice/view/create-order.vue')
    }, {
        path: '2',
        name: 'bookinglist',
        meta: { layout: 'default' },
        component: page('Invoice/view/list.vue')
    }, {
        path: '3',
        name: 'preapprove',
        meta: { layout: 'default' },
        props: true,
        component: page('Invoice/view/preApproved.vue')
    },
    {
        path: 'report',
        name: 'invoiceReport',
        meta: { layout: 'default' },
        props: true,
        component: page('Invoice/view/Report/OrderSlip.vue')
    },]
}]