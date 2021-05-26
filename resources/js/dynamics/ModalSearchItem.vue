<template>
	<!-- Modal -->
	<div id="uploadModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Search</h4>
					<button type="button" class="close" data-dismiss="modal">
						&times;
					</button>
				</div>
				<div class="modal-body">
					<!-- Form -->
					<form
						method="POST"
						onsubmit="event.preventDefault();"
						enctype="multipart/form-data"
					>
						<div class="form-group row">
							<label
								for="inputStatus"
								class="col-sm-4 col-form-label font-weight-bold"
								>Branch</label
							>
							<div class="col-sm-8">
								<select
									class="form-control"
									v-model="branch"
									:disabled="
										isUser.branch != 'MAIN' ? true : false
									"
								>
									<option value="">All</option>
									<option
										v-for="(branch, k) in getBranch"
										:key="k"
										v-bind:value="branch.branch"
									>
										{{ branch.branchname }}
									</option>
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label
								for="inputStatus"
								class="col-sm-4 col-form-label font-weight-bold"
								>Date</label
							>
							<div class="col-sm-8">
								<input
									v-model="trndate"
									class="form-control"
									type="date"
								/>
							</div>
						</div>

						<div class="btn-group">
							<button
								type="button"
								class="btn btn-danger"
								@click="handleSubmit('preview')"
								data-dismiss="modal"
							>
								Preview
							</button>
							<button
								type="button"
								class="btn btn-danger dropdown-toggle dropdown-toggle-split"
								data-toggle="dropdown"
								aria-haspopup="true"
								aria-expanded="false"
							>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu">
								<a
									class="dropdown-item"
									href="#"
									@click="handleSubmit('preview')"
									data-dismiss="modal"
									>Preview</a
								>
								<a
									class="dropdown-item"
									href="#"
									@click="handleSubmit('excel')"
									data-dismiss="modal"
									>Export</a
								>
							</div>
						</div>
					</form>

					<!-- Preview-->
					<div id="preview"></div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {};
</script>

<style>
</style>