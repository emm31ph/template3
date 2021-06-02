function page(path) {
    return () =>
        import( /* webpackChunkName: '' */ `~/pages/${path}`).then(
            m => m.default || m
        )
}

export default [{
    path: '/roles',
    name: 'roles',
    redirect: { name: 'roles-list' },
    component: page('Roles/view/main.vue'),
    children: [{
        path: 'list',
        name: 'roles-list',
        meta: { layout: 'default' },
        component: page('Roles/view/list.vue')
    },]
}]