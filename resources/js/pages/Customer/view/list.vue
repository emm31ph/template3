<template>
	<div>
		 Customer List
	</div>
</template>

<script>
export default {
	name: "Customers List",
	layout: "default",
	middleware: "auth",
	metaInfo() {
		return { title: "Customers List" };
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
		 
	}
	 
};
</script>

<style>

</style>