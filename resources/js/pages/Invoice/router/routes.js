function page(path) {
    return () =>
        import( /* webpackChunkName: '' */ `~/pages/${path}`).then(
            m => m.default || m
        )
}

export default [{
    path: '/invoice',
    name: 'invoice',
    redirect: { name: 'invoice-list' },
    component: page('Invoice/view/main.vue'),
    children: [ {
        path: '',
        name: 'invoice-create',
        meta: { layout: 'default' },
        component: page('Invoice/view/create-order.vue')
    }, {
        path: '',
        name: 'invoice-list',
        meta: { layout: 'default' },
        component: page('Invoice/view/list.vue')
    },]
}]