<template>
	<div>
		<router-view></router-view>
	</div>
</template>

<script>
export default {
	name: "item",
	layout: "default",
	middleware: "auth",
	created() {
		this.isLoggedCheck;
	},
};
</script>

<style>
</style>