function page(path) {
    return () =>
        import( /* webpackChunkName: '' */ `~/pages/${path}`).then(
            m => m.default || m
        )
}

export default [{ 
    path: '/customer',
    name: 'customer',
    // redirect: { name: 'settings-list' },
    component: page('Customer/view/main.vue'),
}];