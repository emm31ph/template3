<template>
	<div>
		<div class="row pt-0 pb-0">                        
			<ul id="menu">
				<menu-item v-for="(r, i) in menus"
					:key="i" :item="r" ></menu-item> 
			</ul> 
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
	mounted(){
		this.list();
	},
	data(){
        return{
            menus:[],
        }
    },
	methods:{
		list(){
		 
            this.menus = [
                {id:'item1',title:'Item Master Data', link:'master-data-items',},
                {id:'item2',title:'Item Management', link:'',access:this.can('price-cat-read'), 
					childs:[{id:'item1',title:'Price Category', link:'price-category', access:this.can('price-cat-read')},
							{id:'item3',title:'Price List', link:'price-list', access:this.can('price-list-read')},
							{id:'item4',title:'Price Customer', link:'price-customer', access:this.can('price-cust-read')},
							 
    	        			]},
			]}
    
	}
	 
};
</script>

<style>

</style>