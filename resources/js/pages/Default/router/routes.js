function page(path) {
    return () =>
        import ( /* webpackChunkName: '' */ `~/pages/${path}`).then(
            m => m.default || m
        )
}

export default [{
        path: '/',
        name: 'home',
        meta: { layout: 'default' },
        component: page('Default/view/Main.vue'),
    }, {
        path: '/about',
        name: 'about',
        meta: { layout: 'default' },
        component: page('Default/view/About.vue'),
        children: [{
                path: 'contact',
                name: 'contact',
                // meta: { layout: 'default' },
                component: page('Default/view/Contact.vue')
            },

        ]


    }, { path: '*', component: page('Default/view/errors/404.vue') }

]