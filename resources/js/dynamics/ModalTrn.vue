<template>
	<div
		id="trnModal"
		class="modal fade"
		role="dialog"
		tabindex="-1"
		aria-hidden="true"
		data-backdrop="static"
		v-if="trnHistData"
	>
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Transaction History</h4>
					<button
						type="button"
						data-dismiss="modal"
						@click="handleClose"
						class="close"
					>
						&times;
					</button>
				</div>

				<div class="modal-footer"></div>
			</div>
		</div>
	</div>
</template>

<script>
export default {};
</script>

<style>
</style>