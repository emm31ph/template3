<template>
	<card :title="pagename"> logged in </card>
</template>

<script>
export default {
	middleware: "auth",
	layout: "default",
	data() {
		return {
			pagename: "dashboard",
		};
	},
	metaInfo() {
		return { title: "dashboard" };
	},
	created() {
		this.isLoggedCheck;
	},
	mounted() {},
};
</script>
