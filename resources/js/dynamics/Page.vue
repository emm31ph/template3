<template>
	<div>
		<slot />
	</div>
</template>

<script>
export default {
	props: {
		size: {
			type: String,
			default: "",
		},
		layout: {
			type: String,
			default: "",
		},
	},
};
</script>

<style></style>
