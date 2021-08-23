<template> 
    <div>
        <div class="row pt-0 pb-0">
            <nav class="menu">
                <ul v-for="(item, i) in menusDis" :key="i"  v-show="item.access">
                    <li >
                        <template v-if=" item.link!=''">
                        <router-link
                            :to="{ name: item.link }"
                            :class="item.childs != null ? 'fly' : ''"
                            >{{ item.title }}  
                        </router-link>
                        </template>
                        <template>
                            <a href="#" aria-current="page"   :class="item.childs != null ? 'fly' : ''"
                             @click="onclick">
                                {{ item.title }} 
                            </a>
                        </template>
                        

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
    name: "Logistic",
    layout: "default",
    middleware: "auth",
    metaInfo() {
        return { title: "Logistic" };
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
        onclick(e){
            e.preventDefault();
        },
        list() {
            this.menus = [ 
                {
                    id: "item1",
                    level: 0,
                    title: "Shipping Advice",
                    link: "",
                    access: this.can("shipping-advice-read"),
                    childs: [
                        {
                            id: "item2",
                            level: 1,
                            title: "New Shipping Advice",
                            link: "log-shipping-create",
                            access: this.can("shipping-advice-create")
                        },
                        {
                            id: "item3",
                            level: 1,
                            title: "Shipping Advice List",
                            link: "log-shipping-list",
                            access: this.can("shipping-advice-read")
                        } 
                    ]
                }
                ,
                {
                    id: "item2",
                    level: 0,
                    title: "Packing List",
                    link: "",
                    access: this.can("packing-list-read"),
                    childs: [
                        {
                            id: "item2",
                            level: 1,
                            title: "New Packing List",
                            link: "log-packing-create",
                            access: this.can("packing-list-create")
                        },
                        {
                            id: "item3",
                            level: 1,
                            title: "Packing List",
                            link: "log-packing-list",
                            access: this.can("packing-list-read")
                        } 
                    ]
                }
            ];
        }
    }
};
</script>

<style>

</style>
