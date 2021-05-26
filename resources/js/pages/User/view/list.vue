<template>
	<div>
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Users</h6>

				<h6 class="m-0 font-weight-bold text-primary">
					<a
						data-toggle="modal"
						data-target="#AddModal"
						@click="openModalWindow"
					>
						<i class="fas fa-cogs"></i>
					</a>
				</h6>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead class="thead-dark">
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Username</th>
								<th>Branch</th>
								<th>Status</th>
								<th>Created</th>
								<th>Modify</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="user in users" :key="user.id">
								<td>{{ user.id }}</td>
								<td>{{ user.name }}</td>
								<td>{{ user.email }}</td>
								<td>{{ user.username }}</td>
								<td>{{ user.branch }}</td>
								<td>
									<span
										class="badge"
										:class="
											user.status == '99'
												? ' badge-danger'
												: ' badge-success'
										"
										>{{
											user.status == "99"
												? "Delete"
												: "Active"
										}}</span
									>
								</td>
								<td>{{ dataF(user.created_at) }}</td>

								<td>
									<div v-if="user.status != '99'">
										<a
											href="#"
											data-id="user.id"
											@click="editModalWindow(user)"
										>
											<i class="fa fa-edit blue"></i>
										</a>
										|
										<a
											href="#"
											@click="deleteUser(user.id)"
										>
											<i class="fa fa-trash red"></i>
										</a>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div
			id="AddModal"
			class="modal fade"
			data-backdrop="static"
			data-keyboard="false"
			role="dialog"
		>
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h5
							v-show="!editMode"
							class="modal-title"
							id="addNewLabel"
						>
							Add New User
						</h5>
						<h5
							v-show="editMode"
							class="modal-title"
							id="addNewLabel"
						>
							Update User
						</h5>

						<button
							type="button"
							class="close"
							data-dismiss="modal"
							@click="closeModal"
						>
							&times;
						</button>
					</div>
					<form
						@submit.prevent="editMode ? updateUser() : createUser()"
						@keydown="form.onKeydown($event)"
					>
						<div class="modal-body">
							<div class="form-group">
								<input
									v-model="form.name"
									type="text"
									name="name"
									placeholder="Name"
									class="form-control"
									:class="{
										'is-invalid': form.errors.has('name'),
									}"
								/>
								<has-error
									:form="form"
									field="name"
								></has-error>
							</div>

							<div class="form-group">
								<input
									v-model="form.email"
									type="email"
									name="email"
									placeholder="Email Address"
									class="form-control"
									:class="{
										'is-invalid': form.errors.has('email'),
									}"
								/>
								<has-error
									:form="form"
									field="email"
								></has-error>
							</div>

							<div class="form-group">
								<input
									v-model="form.password"
									type="password"
									name="password"
									id="password"
									placeholder="Enter password"
									class="form-control"
									:class="{
										'is-invalid': form.errors.has(
											'password'
										),
									}"
								/>
								<has-error
									:form="form"
									field="password"
								></has-error>
							</div>

							<div class="form-group">
								<input
									v-model="form.username"
									type="text"
									name="username"
									id="username"
									placeholder="Enter username"
									class="form-control"
									:class="{
										'is-invalid': form.errors.has(
											'username'
										),
									}"
								/>
								<has-error
									:form="form"
									field="username"
								></has-error>
							</div>

							<div class="form-group">
								<select
									name="branch"
									v-model="form.branch"
									id="branch"
									class="form-control"
									:class="{
										'is-invalid': form.errors.has('branch'),
									}"
								>
									<option
										v-for="(branch, k) in getBranch"
										:key="k"
										v-bind:value="branch.branch"
									>
										{{ branch.branchname }}
									</option>
								</select>
								<has-error
									:form="form"
									field="branch"
								></has-error>
							</div>
							<div :class="{ invalid: isInvalid }">
								<label class="typo__label">Roles</label>
								<multiselect
									placeholder="Pick at least one"
									select-label="Enter doesn’t work here!"
									:value="value"
									:options="options"
									:multiple="true"
									:searchable="true"
									:allow-empty="false"
									:hide-selected="true"
									:max-height="150"
									:max="5"
									:block-keys="['Tab', 'Enter']"
									@input="onChange"
									@close="onTouch"
									@select="onSelect"
								></multiselect>
								<label
									class="typo__label form__label"
									v-show="isInvalid"
									>Must have at least one value</label
								>
							</div>
						</div>
						<div class="modal-footer">
							<button
								type="button"
								class="btn btn-danger"
								data-dismiss="modal"
								@click="closeModal"
							>
								Close
							</button>
							<button
								v-show="editMode"
								type="submit"
								class="btn btn-primary"
							>
								Update
							</button>
							<button
								v-show="!editMode"
								type="submit"
								class="btn btn-primary"
							>
								Create
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import Form from "vform";
import Multiselect from "vue-multiselect";

export default {
	components: { Multiselect },
	middleware: "auth",
	data() {
		return {
			pagename: "Users",

			editMode: false,
			users: [],
			isDisabled: false,
			isTouched: false,
			value: [],
			options: [
				"Select option",
				"Disable me!",
				"Reset me!",
				"mulitple",
				"label",
				"searchable",
			],

			form: new Form({
				id: "",
				name: "",
				email: "",
				password: "",
				username: "",
				status: "",
				branch: "MAIN",
				roles: "",
			}),
		};
	},
	metaInfo() {
		return { title: "Users" };
	},
	methods: {
		onChange(value) {
			this.value = value;
			if (value.indexOf("Reset me!") !== -1) this.value = [];
		},
		onSelect(option) {
			if (option === "Disable me!") this.isDisabled = true;
		},
		onTouch() {
			this.isTouched = true;
		},
		loadUsers() {
			axios.get("/api/users").then((data) => (this.users = data.data));
		},
		editModalWindow(user) {
			this.form.clear();
			this.editMode = true;
			this.form.reset();
			$("#AddModal").modal("show");
			this.form.fill(user);
		},
		async updateUser() {
			await this.form
				.patch("/api/user/update")
				.then((response) => {
					Swal.fire({
						title: "User created successfully",
						icon: "success",
						showConfirmButton: false,
						timer: 1500,
					});
					$("#AddModal").modal("hide");
					this.loadUsers();
					this.closeModal();
				})
				.catch(() => {
					Swal.fire({
						icon: "error",
						title: "Oops...",
						text: "Something went wrong!",
						footer: "<a href>Why do I have this issue?</a>",
					});
				});
		},
		openModalWindow() {
			this.editMode = false;
			this.form.reset();
			// $("#addNew").modal("show");
		},
		createUser() {
			this.form
				.post("/api/user/create")
				.then((response) => {
					Swal.fire({
						title: "User created successfully",
						icon: "success",
						showConfirmButton: false,
						timer: 1500,
					});
					this.loadUsers();
					this.closeModal();
				})
				.catch(() => {
					Swal.fire({
						icon: "error",
						title: "Oops...",
						text: "Something went wrong!",
						footer: "<a href>Why do I have this issue?</a>",
					});
				});
		},
		closeModal() {
			$("#AddModal").modal("hide");
			this.form.errors.errors = "";
		},
		deleteUser(id) {
			Swal.fire({
				title: "Are you sure?",
				text: "You won't be able to revert this!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, delete it!",
			}).then((result) => {
				if (result.value) {
					//Send Request to server
					this.form
						.delete("/api/user/" + id)
						.then((response) => {
							Swal.fire(
								"Deleted!",
								"User deleted successfully",
								"success"
							);
							this.loadUsers();
						})
						.catch(() => {
							Swal.fire({
								icon: "error",
								title: "Oops...",
								text: "Something went wrong!",
								footer: "<a href>Why do I have this issue?</a>",
							});
						});
				}
			});
		},
	},
	created() {
		this.loadUsers();
	},
	mounted() {
		this.fetchBranch();
		this.fetchRoles();
	},
	computed: {
		isInvalid() {
			return this.isTouched && this.value.length === 0;
		},
	},
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
