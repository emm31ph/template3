<template>
	<div>
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Signatories</h6>
 
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
	name: "Signatories",
	layout: "default",
	middleware: "auth",
	metaInfo() {
		return { title: "Signatories" };
	},
   
	created() {
		this.isLoggedCheck;
	},
   
};
</script>

<style>
</style>