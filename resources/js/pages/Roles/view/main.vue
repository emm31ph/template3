<template>
	<div>
		<router-view></router-view>
	</div>
</template>

<script>
export default {
	name: "Roles",
	layout: "default",
	middleware: "auth",
	created() {
		this.isLoggedCheck;
	},
};
</script>

<style>
</style>