<template>
	<div>
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Settings</h6>
 
			</div>
			<div class="card-body">
				<div class="table-responsive">
					 
					 
				</div>
			</div>
		</div>
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
   
};
</script>

<style>
</style>