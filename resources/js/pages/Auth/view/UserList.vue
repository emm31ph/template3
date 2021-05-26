<template>
	<div></div>
</template>

<script>
import Form from "vform";

export default {
	middleware: "auth",
	data() {
		return {
			pagename: "Auths",
		};
	},
	metaInfo() {
		return { title: "Auths" };
	},
};
</script>
