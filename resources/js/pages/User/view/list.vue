<template>
	<div>
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Users</h6>

				<h6
					class="m-0 font-weight-bold text-primary"
					v-if="can('users-create')"
				>
					<a @click="openModalWindow">
						<i class="fas fa-cogs"></i>
					</a>
				</h6>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-sm table-hover">
						<thead class="thead-dark">
							<tr>
								<th
									v-bind:class="[
										sortBy === 'id' ? sortDirection : '',
									]"
									@click="sort('id')"
								>
									ID
								</th>
								<th
									v-bind:class="[
										sortBy === 'name' ? sortDirection : '',
									]"
									@click="sort('name')"
								>
									Name
								</th>
								<th
									v-bind:class="[
										sortBy === 'email' ? sortDirection : '',
									]"
									@click="sort('email')"
								>
									Email
								</th>
								<th
									v-bind:class="[
										sortBy === 'username'
											? sortDirection
											: '',
									]"
									@click="sort('username')"
								>
									Username
								</th>
								<th
									v-bind:class="[
										sortBy === 'branch'
											? sortDirection
											: '',
									]"
									@click="sort('branch')"
								>
									Branch
								</th>
								<th  class="text-center"
									v-bind:class="[
										sortBy === 'usertype'
											? sortDirection
											: '',
									]"
									@click="sort('usertype')"
								>
									User Type
								</th>
								<th  class="text-center"
									v-bind:class="[
										sortBy === 'usertype'
											? sortDirection
											: '',
									]"
									@click="sort('status')"
								>
									Status
								</th>
								<th>Roles</th>
								<th>Created</th>
								<th class="text-center">Modify</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="user in filteredUsers" :key="user.id">
								<td>{{ user.id }}</td>
								<td class="text-capitalize">{{ user.name }}</td>
								<td>{{ user.email }}</td>
								<td>{{ user.username }}</td>
								<td>{{ user.branch }}</td>
								<td class="text-center">{{ usertype(user.usertype)}}</td>
								<td  class="text-center">
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

								<td>
									<span
										v-for="role in user.roles"
										:key="role.id"
										class="
											badge badge-success
											mr-1
											text-capitalize
										"
										>{{ role.display_name }}</span
									>
								</td>

								<td>{{ dataF(user.created_at) }}</td>

								<td class="text-center">
									<div v-if="user.status != '99'">
										<a
											href="#"
											data-id="user.id"
											@click="
												editModalWindow(user);
												showModal = true;
											"
											v-if="can('users-update')"
										>
											<i class="fa fa-edit blue"></i>
										</a>

										<a
											href="#"
											@click="deleteUser(user.id)"
											v-if="can('users-delete')"
										>
											<i
												class="fa fa-trash text-danger"
											></i>
										</a>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					<vue-plain-pagination
						v-if="allUsers"
						v-model="currentPage"
						:page-count="totalPages"
						:classes="bootstrapPaginationClasses"
						:labels="customLabels"
					/>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div v-if="showModal">
			<transition name="modal">
				<div class="modal-mask">
					<div class="modal-wrapper">
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
										@click="showModal = false"
									>
										&times;
									</button>
								</div>
								<form
									@submit.prevent="
										editMode ? updateUser() : createUser()
									"
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
													'is-invalid':
														form.errors.has('name'),
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
													'is-invalid':
														form.errors.has(
															'email'
														),
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
													'is-invalid':
														form.errors.has(
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
												:disabled="editMode"
												class="form-control"
												:class="{
													'is-invalid':
														form.errors.has(
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
													'is-invalid':
														form.errors.has(
															'branch'
														),
												}"
											>
												<option
													v-for="(
														branch, k
													) in getBranch"
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
										<div>
											<label class="typo__label"
												>Selected Branch</label
											>
											<multi-select
											:index="1000"
												:options="getBranch"
												display-property="branchname"
												value-property="branch"
												v-model="form.selectedOptionsBranch"
											/>

											<label
												class="typo__label form__label"
												>Must have at least one
												value</label
											>
										</div>
										<div class="form-group" >
											<select   
												v-model="form.usertype" 
												class="form-control"
												:class="{
													'is-invalid':
														form.errors.has(
															'usertype'
														),
												}"
											>
											<option value="" disabled selected>User Type</option>
												<option
													v-for="(
														lookup, k
													) in getLookup('U01')"
													:key="k"
													v-bind:value="lookup.code"
												>
													{{ lookup.fulltitle }}
												</option>
											</select>
											<has-error
												:form="form"
												field="usertype"
											></has-error>
										</div>


										<div>
											<label class="typo__label"
												>Roles</label
											>
											<multi-select
											
											:index="900"
												:options="roles"
												display-property="name"
												value-property="id"
												v-model="form.selectedOptions"
											/>

											<label
												class="typo__label form__label"
												>Must have at least one
												value</label
											>
										</div>
									</div>
									<div
										class="
											modal-footer
											d-flex
											flex-row-reverse
										"
									>
										<button
											type="button"
											class="btn btn-danger"
											data-dismiss="modal"
											@click="showModal = false"
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
			</transition>
		</div>
	</div>
</template>

<script>
import Form from "vform";
import bus from "../../../EventBus";
export default {
	name: "UsersList",
	middleware: "auth",
	data() {
		return {
			showModal: false,
			pagename: "Users",
			editMode: false,
			value: [],
			roles: [],
			form: new Form({
				id: "",
				name: "",
				email: "",
				password: "",
				username: "",
				usertype:'',
				status: "",
				branch: "MAIN",
				selectedOptions: [],
				selectedOptionsBranch:[],
			}),
			query: "",
			page: 1,
			items: 6,
			currentPage: 1,
			postsPerPage: 20,
			sortBy: "id",
			sortDirection: "asc",
			bootstrapPaginationClasses: {
				// http://getbootstrap.com/docs/4.1/components/pagination/
				ul: "pagination",
				li: "page-item",
				liActive: "active",
				liDisable: "disabled",
				button: "page-link",
			},
			customLabels: {
				first: "First",
				prev: "Previous",
				next: "Next",
				last: "Last",
			},
		};
	},

	created() {
		this.isLoggedCheck;
	},
	metaInfo() {
		return { title: "Users" };
	},
	methods: {
		usertype(data){
			if(data){
				let val  = this.getLookup('U01'); 
				var val1 = val.filter(el => el.code === data) 
				if(val1.length){ 
					return val1[0]['fulltitle'];
				}
			}
			return '';
		},
		editModalWindow(user) {
			console.log(user);
			let roleid = user.roles.map(function (item) {
				return item.id;
			});
			
			let branchid = user.myBranch.map(function (item) {
				return item.branch;
			});

			console.log(branchid);

			this.form.clear();
			this.form.reset();
			this.editMode = true;
			this.form.fill(user);
			this.form.selectedOptions = roleid;
			this.form.selectedOptionsBranch = branchid;
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

					this.fetchUsers();
					this.closeModal();
				})
				.catch((error) => { 
					Swal.fire({
						icon: "error",
						title: "Oops...",
						text: "Something went wrong!",
						footer: "<a href>Why do I have this issue?</a>",
					});
				});
		},
		openModalWindow() {
			this.showModal = true;
			this.editMode = false;
			this.form.reset();
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

					this.fetchUsers();
					this.closeModal();
				})
				.catch(() => {
					// Swal.fire({
					// 	icon: "error",
					// 	title: "Oops...",
					// 	text: "Something went wrong!",
					// });
				});
		},
		closeModal() {
			this.showModal = false;
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
							this.fetchUsers();
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
		sort: function (s) {
			if (s.toLowerCase() === this.sortBy) {
				this.sortDirection =
					this.sortDirection === "asc" ? "desc" : "asc";
			}
			this.sortBy = s;
		},
		matches() {
			this.$emit("change", this.query);
			if (this.query == "") {
				return [];
			} 

			return this.filteredUsers.filter(
				(item) => item["name"].toLowerCase().startsWith(this.query) //search start left side
				// .includes(this.query.toLowerCase()) //search match letter
			);
		},
		reload() {
			this.fetchUsers();
		},
	},

	mounted() {
		
	 

		this.isAbleToAuth(["users-*"]);
		this.fetchBranch();
		this.fetchRoles();
		this.fetchUsers();
		this.getRole;
		this.currentPage = 1;
		bus.$on("send", (data) => {
			this.query = data;
		});
	},

	computed: {
		getRole() {
			axios.get("/api/roles").then((res) => {
				this.roles = res.data;
			});
		},
		allUsers() {
			const data = this.getUsers ? this.getUsers : "";

			if (this.getUsers != "undefined ") {
				this.$emit("change", this.query);
				if (!this.query == "") {
					return data
						.filter(
							(item) =>
								item["name"]
									.toLowerCase()
									// .startsWith(this.query) //search start left side
									.includes(this.query.toLowerCase()) //search match letter
						)
						.sort((p1, p2) => {
							let modifier = 1;
							if (p1[this.sortBy] != undefined) {
								if (this.sortDirection === "desc")
									modifier = -1;
								if (parseInt(p1[this.sortBy])) {
									if (p1[this.sortBy] < p2[this.sortBy])
										return -1 * modifier;
									if (p1[this.sortBy] > p2[this.sortBy])
										return 1 * modifier;
								} else {
									if (
										p1[this.sortBy]
											.toString()
											.toLowerCase() <
										p2[this.sortBy].toString().toLowerCase()
									)
										return -1 * modifier;
									if (
										p1[this.sortBy]
											.toString()
											.toLowerCase() >
										p2[this.sortBy].toString().toLowerCase()
									)
										return 1 * modifier;
								}
							}
							return 0;
						});
				} else {
					// return Object.keys(data).map((itemcode) => data[itemcode]);
					return Object.keys(data)
						.map((name) => data[name])
						.sort((p1, p2) => {
							let modifier = 1;
							if (p1[this.sortBy] != undefined) {
								if (this.sortDirection === "desc")
									modifier = -1;
								if (parseInt(p1[this.sortBy])) {
									if (p1[this.sortBy] < p2[this.sortBy])
										return -1 * modifier;
									if (p1[this.sortBy] > p2[this.sortBy])
										return 1 * modifier;
								} else {
									if (
										p1[this.sortBy]
											.toString()
											.toLowerCase() <
										p2[this.sortBy].toString().toLowerCase()
									)
										return -1 * modifier;
									if (
										p1[this.sortBy]
											.toString()
											.toLowerCase() >
										p2[this.sortBy].toString().toLowerCase()
									)
										return 1 * modifier;
								}
							}
							return 0;
						});
				}
			}

			return false;
		},
		filteredUsers() {
			var page = this.currentPage;
			var perPage = this.postsPerPage;
			var from = page * perPage - perPage;
			var to = page * perPage;
			return this.allUsers.slice(from, to);
		},
		totalPages() {
			return Math.ceil(this.allUsers.length / this.postsPerPage);
		},
	},
};
</script> 

<style>
.modal-mask {
	position: fixed;
	z-index: 9998;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background-color: rgba(0, 0, 0, 0.5);
	display: table;
	transition: opacity 0.3s ease;
}

.modal-wrapper {
	display: table-cell;
	vertical-align: middle;
}
</style>
