function page(path) {
    return () =>
        import(/* webpackChunkName: '' */ `~/pages/${path}`).then(
            m => m.default || m
        );
}

export default [
    {
        path: "/logistic",
        name: "logistic",
        redirect: { name: "log-d" },
        component: page("Logistic/view/main.vue"),
        children: [

            {
                path: 'default',
                name: 'log-d',
                meta: { layout: 'default' },
                component: page('Logistic/view/blank.vue')
            },
            {
                path: "report-view",
                name: "log-report",
                component: page("Logistic/view/Report/ReportView.vue"),
                props: true
            },
            {
                path: "report",
                name: "log-report-sh",
                component: page("Logistic/view/Report/ShippingAdvice.vue"),
                props: true
            },
            {
                path: "createSH",
                name: "log-shipping-create",
                meta: { layout: "default" },
                component: page("Logistic/view/ShippingAdvice/Create.vue")
            },
            {
                path: "list-sh",
                name: "log-shipping-list",
                meta: { layout: "default" },
                component: page("Logistic/view/ShippingAdvice/List.vue")
            },
            {
                path: "report",
                name: "log-report-pl",
                component: page("Logistic/view/Report/PackingList.vue"),
                props: true
            },
            {
                path: "createPL",
                name: "log-packing-create",
                meta: { layout: "default" },
                component: page("Logistic/view/PackingList/Create.vue")
            },
            {
                path: "list-pl",
                name: "log-packing-list",
                meta: { layout: "default" },
                component: page("Logistic/view/PackingList/List.vue")
            },
        ]
    }
];
