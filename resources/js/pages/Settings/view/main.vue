<template>

    <div>
        <div class="row pt-0 pb-0">
            <nav class="menu">
                <ul v-for="(item, i) in menusDis" :key="i">
                    <li>
                        <router-link
                            :to="{ name: item.link }"
                            :class="item.childs != null ? 'fly' : ''"
                            >{{ item.title }}  
                        </router-link>

                        <ul v-if="item.childs != null">
                            <menu-item
                                v-for="(r, i) in item.childs"
                                :key="i"
                                :item="r"
                                :index="i"
                            ></menu-item> 
                        </ul>
                    </li>
                </ul> 
            </nav>
        </div>

        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "Settings",
    layout: "default",
    middleware: "auth",
    metaInfo() {
        return { title: "Settings" };
    },
    created() {
        this.isLoggedCheck;
    },
    mounted() {
        this.list();
    },
    data() {
        return {
            menus: []
        };
    },
    computed: {
        menusDis() {
            return this.menus.filter(menu => menu.level == 0);
        }
    },
    methods: {
        list() {
            this.menus = [
                {
                    id: "item1",
                    level: 0,
                    title: "Item Master Data",
                    link: "master-data-items",
                    access: true
                },
                {
                    id: "item2",
                    level: 0,
                    title: "Item Management",
                    link: "",
                    access: this.can("price-cat-read"),
                    childs: [
                        {
                            id: "item1",
                            level: 1,
                            title: "Price Category",
                            link: "price-category",
                            access: this.can("price-cat-read")
                        },
                        {
                            id: "item3",
                            level: 1,
                            title: "Price List",
                            link: "price-list",
                            access: this.can("price-list-read")
                        },
                        {
                            id: "item4",
                            level: 1,
                            title: "Price Customer",
                            link: "price-customer",
                            access: this.can("price-cust-read"),
                            
                        }
                    ]
                }
                ,
                { 
                    level: 0,
                    title: "Setup",
                    link: "",
                    access: true,
                    childs: [
                        {
                            level: 1,
                            title: "Signatories",
                            link: "signatories-list",
                            access: true,  
                        },
                        { 
                            level: 1,
                            title: "Business Partners",
                            link: "",
                            access: true,
                            childs: [
                            { 
                                level: 2,
                                title: "Sales Person",
                                link: "settings-salesperson",
                                access: this.can('sales-person-read')
                            },
                            ]
                        },
                         
                    ]
                }
            ];
        }
    }
};
</script>

<style>
.menu {
    height: 50px;
    position: relative;
}
.menu ul {
    padding: 0;
    margin: 0;
    list-style: none;
    width: 150px;
    float: left;
}
.menu ul ul {
    position: absolute;
    z-index: -1;
    -webkit-transition: 0.5s;
    -moz-transition: 0.5s;
    -ms-transition: 0.5s;
    -o-transition: 0.5s;
    transition: 0.5s;
    transition-delay: 0.5s;
    -o-transition-delay: 0.5s;
    -moz-transition-delay: 0.5s;
    -ms-transition-delay: 0.5s;
    -webkit-transition-delay: 0.5s;
}
.menu ul ul ul {
    position: absolute;
    left: 150px;
    top: 0;
}
.menu ul li {
    float: left;
    width: 150px;
    position: relative;
    z-index: 10;
    -webkit-transition: 0.25s;
    -moz-transition: 0.25s;
    -ms-transition: 0.25s;
    -o-transition: 0.25s;
}
.menu ul ul li {
    transition-delay: 1s;
    -o-transition-delay: 1s;
    -moz-transition-delay: 1s;
    -ms-transition-delay: 1s;
    -webkit-transition-delay: 1s;
}
.menu ul ul ul li {
    transition-delay: 0.5s;
    -o-transition-delay: 0.5s;
    -moz-transition-delay: 0.5s;
    -ms-transition-delay: 0.5s;
    -webkit-transition-delay: 0.5s;
}
.menu ul li a {
    display: block;
    /* width:139px; */
    height: 29px;
    padding-left: 10px;
    background: #10a1b7;
    font: normal 12px/29px arial, sans-serif;
    color: #fff;
    text-decoration: none;
    margin-bottom: 1px;
    margin-right: 1px;
    -o-border-radius: 5px;
    -moz-border-radius: 5px;
    -ms-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
}
.menu ul li a.fly {
    background: #10a1b7
        url(data:image/gif;base64,R0lGODlhFAAJAIAAAP////8AACH5BAEHAAEALAAAAAAUAAkAAAIdDI4Qy73qTHRQvtmq1VMljzEaxEXVGV5m+nxlVAAAOw==)
        no-repeat right center;
}
.menu ul li:hover > a {
    background: #999;
    color: #fff;
}
.menu ul li:hover > a.fly {
    color: #000;
    background: #10a1b7
        url(data:image/gif;base64,R0lGODlhFAAJAIAAAGdnZ////yH5BAEHAAEALAAAAAAUAAkAAAIdDI4Qy73qTHRQvtmq1VMljzEaxEXVGV5m+nxlVAAAOw==)
        no-repeat right center;
}
.menu ul ul li {
    margin-top: -30px;
}
.menu ul ul li.p1 {
    margin-top: 0;
}
.menu ul ul ul {
    margin-left: -150px;
}
.menu ul li:hover > ul > li {
    margin-top: 0;
    transition-delay: 0.5s;
    -o-transition-delay: 0.5s;
    -moz-transition-delay: 0.5s;
    -ms-transition-delay: 0.5s;
    -webkit-transition-delay: 0.5s;
}
.menu ul ul li:hover > ul {
    margin-left: 0;
    transition-delay: 0s;
    -o-transition-delay: 0s;
    -moz-transition-delay: 0s;
    -ms-transition-delay: 0s;
    -webkit-transition-delay: 0s;
}
.menu ul li.close {
    margin-top: -30px;
    z-index: -1;
}
</style>
