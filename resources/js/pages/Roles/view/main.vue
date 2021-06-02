<template>
	<div>
		<router-view></router-view>
	</div>
</template>

<script>
export default {
	name: "Roles",
	middleware: "auth",
};
</script>

<style>
</style>