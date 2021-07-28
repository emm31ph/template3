<template>
	<div>
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Sales Person</h6>

				<h6
					class="m-0 font-weight-bold text-primary"
					v-if="can('sales-person-create')"
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
										sortBy === 'salesperson' ? sortDirection : '',
									]"
									@click="sort('salesperson')"
								>
									SALES PERSON ID
								</th>
								<th
									v-bind:class="[
										sortBy === 'salespersonname' ? sortDirection : '',
									]"
									@click="sort('salespersonname')"
								>
									SALES PERSON NAME
								</th>
								<th
									v-bind:class="[
										sortBy === 'user_id'
											? sortDirection
											: '',
									]"
									@click="sort('user_id')"
								>
									Linked
								</th>
								 
								<th class="text-center">Modify</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="user in filteredSalesPerson" :key="user.id">
							 
								<td>{{ user.salesperson }}</td>
								<td  class="text-capitalize">{{ user.salespersonname }}</td>
								<td><span class="badge badge-success" v-if="user.user_id">{{ getLinked(user.user_id) }}</span></td> 
								 

								<td class="text-center">
									<div v-if="user.status != '99'">
										<a
											href="#"
											data-id="user.id"
											@click="
												editModalWindow(user);
												showModal = true;"
											v-if="can('sales-person-update')"
										>
											<i class="fa fa-edit blue"></i>
										</a>

										<a
											href="#"
											@click="deleteUser(user.id)"
											v-if="can('sales-person-delete')"
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
										Add New Sale Person
									</h5>
									<h5
										v-show="editMode"
										class="modal-title"
										id="addNewLabel"
									>
										Update Sale Person
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
										editMode ? updateSalesperson() : createSalesperson()
									"
									@keydown="form.onKeydown($event)"
								>
									<div class="modal-body">
										<div class="form-group">
											<input
												v-model="form.salesperson"
												type="text"
												name="name"
												placeholder="salesperson"
												class="form-control"
												:class="{
													'is-invalid':
														form.errors.has('salesperson'),
												}"
											/>
											<has-error
												:form="form"
												field="salesperson"
											></has-error>
										</div>

										<div class="form-group">
											<input
												v-model="form.salespersonname"
												type="text"
												name="salespersonname"
												placeholder="Sales Person Name"
												class="form-control"
												:class="{
													'is-invalid':
														form.errors.has(
															'salespersonname'
														),
												}"
											/>
											<has-error
												:form="form"
												field="salespersonname"
											></has-error>
										</div> 
										<div class="form-group" >
											<select 
												v-model="form.link_id" 
												class="form-control"
												:class="{
													'is-invalid':
														form.errors.has(
															'link_id'
														),
												}"
											>
											<option value="" disabled selected>User</option>
												<option
													v-for="(
														lookup, k
													) in linkUser()"
													:key="k"
													v-bind:value="lookup.id"
												>
													{{ lookup.name }}
												</option>
											</select>
											<has-error
												:form="form"
												field="link_id"
											></has-error>
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
			pagename: "Sales Person",
			editMode: false,
			value: [],
			roles: [],
			form: new Form({
				id: "",
				salespersonname: "",
				salesperson: "",
			 	link_id:'',
			}),
			query: "",
			page: 1,
			items: 6,
			currentPage: 1,
			postsPerPage: 20,
			sortBy: "",
			sortDirection: "desc",
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
		return { title: "Sales Person" };
	},
	methods: {
		getLinked(id) { 
			if(id){
			var val = this.getUsers 
			var val1 = val.filter(el => el.id===id); 
			if(val1.length){
			return val1[0]['name'];
			} }
			return '';
		},

		linkUser(){
			let val  = this.getUsers; 
			var val1 = val.filter(el => el.usertype === 'U002').sort(function(a, b) {
			var nameA = a.name.toUpperCase(); // ignore upper and lowercase
			var nameB = b.name.toUpperCase(); // ignore upper and lowercase
			if (nameA < nameB) {
				return -1;
			}
			if (nameA > nameB) {
				return 1;
			}

			// names must be equal
			return 0;
			}); 

			return val1;
		},
		editModalWindow(user) { 
			this.linkUser();
			this.form.clear();
			this.form.reset();
			this.editMode = true;
			this.form.id = user.id;
			this.form.fill(user);
			console.log(user);
		 
		},
		async updateSalesperson() {
			 this.form.trntype='update'
			await this.form
				.patch("/api/settings/salesperson")
				.then((res) => {
					// console.log(res.data);
					Swal.fire({
						title: "successfully linked",
						icon: "success",
						showConfirmButton: false,
						timer: 1500,
					});

					this.fetchUsers();
					this.fetchSalesPerson();
					this.closeModal();
				})
				.catch((error) => { 
				 console.log(error);
				});
		},
		openModalWindow() {
			this.showModal = true;
			this.editMode = false;
			this.form.reset();
		},
		createSalesperson() {
			 
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
			return this.filteredSalesPerson.filter(
				(item) => item["salespersonname"].toLowerCase().startsWith(this.query) //search start left side
				// .includes(this.query.toLowerCase()) //search match letter
			);
		},
		reload() {
			this.fetchUsers();
		},
		
	},

	mounted() {
		 
		this.isAbleToAuth(["users-*"]); 
		this.fetchUsers();
		this.fetchSalesPerson();
		this.getRole;
		this.currentPage = 1;
		bus.$on("send", (data) => {
			this.query = data;
		});
	},

	computed: {
		
		allUsers() {
			const data = this.getSalesperson ? this.getSalesperson : "";

			if (this.getSalesperson != "undefined ") {
				this.$emit("change", this.query);
				if (!this.query == "") {
					return data
						.filter(
							(item) =>
								item["salespersonname"]
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
		filteredSalesPerson() {
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
