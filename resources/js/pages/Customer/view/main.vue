<template>
	<div>
		 Customer
		<router-view></router-view>
	</div>
</template>

<script>
export default {
	name: "Customers",
	layout: "default",
	middleware: "auth",
	metaInfo() {
		return { title: "Customers" };
	},
	created() {
		this.isLoggedCheck;
		this.fetchCustomer(); 
		
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
		 
	}
	 
};
</script>

<style>

</style>