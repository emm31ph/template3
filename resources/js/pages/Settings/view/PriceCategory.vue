<template>
	<div>
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">
					Price Category
				</h6>

				 
					<ul class="navbar-nav float-right">
						<li class="nav-item dropdown">
							<a
								id="my-dropdown"
								data-toggle="dropdown"
								aria-haspopup="true"
								aria-expanded="false"
								class="nav-link"
							>
								<i class="fas fa-cogs"></i>
							</a>
							<div
								aria-labelledby="my-dropdown"
								class="dropdown-menu dropdown-menu-right"
								style=""
							>
								<a 	class="dropdown-item" v-if="can('price-cat-create')" @click="openModalWindow">
									New Price Category
								</a>
								 
								 	<a 	class="dropdown-item" v-if="!can('price-cat-copy')" @click="openModalGenerateWindow">
									Re-Gerate Price Category from EBT
								</a>
							</div>
							
							 
						</li>
						
					</ul>
					
				 
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-sm table-hover">
						<thead class="thead-dark">
							<tr>
								<th
									v-bind:class="[
										sortBy === 'fulltitle'
											? sortDirection
											: '',
									]"
									@click="sort('fulltitle')"
								>
									Price Category
								</th>
								<th class="text-center">Modify</th>
							</tr>
						</thead>
						<tbody>
							<tr
								v-for="product in filteredCategory"
								:key="product.id"
								@dblclick="can('price-cat-update')	? editModalWindow(product): ''">
								<td class="text-capitalize">
									{{ product.fulltitle }}
								</td>

								<td class="text-center">
									<div v-if="product.status != '99'">
										<a
											href="#"
											data-id="product.id"
											@click="editModalWindow(product)"
											v-if="can('price-cat-update')"
										>
											<i class="fa fa-edit blue"></i>
										</a>

										<a
											href="#"
											@click="
												deletePriceCategory(product.id)
											"
											v-if="can('price-cat-delete')"
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
						v-if="allPriceCategory"
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
										Add New Price Category
									</h5>
									<h5
										v-show="editMode"
										class="modal-title"
										id="addNewLabel"
									>
										Update Price Category
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
										editMode
											? updatePriceCategory()
											: createPriceCategory()
									"
									@keydown="form.onKeydown($event)"
								>
									<input
										type="hidden"
										v-model="form.trnmode"
									/>
									<div class="modal-body">
										<div class="form-group">
											<label for="pricelist"
												>Price Category ID</label
											>
											<input
												v-model="form.pricelist"
												type="text"
												name="pricelist"
												placeholder="Price Category ID"
												class="form-control"
												:class="{
													'is-invalid':
														form.errors.has(
															'pricelist'
														),
												}"
											/>
											<has-error
												:form="form"
												field="pricelist"
											></has-error>
										</div>
										<div class="form-group">
											<label for="fulltitle"
												>Price Category</label
											>
											<input
												v-model="form.fulltitle"
												type="text"
												name="fulltitle"
												placeholder="Price Category"
												class="form-control"
												:class="{
													'is-invalid':
														form.errors.has(
															'fulltitle'
														),
												}"
											/>
											<has-error
												:form="form"
												field="fulltitle"
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
	name: "PriceCategory",
	middleware: "auth",
	data() {
		return {
			showModal: false, 
			pagename: "Price Category",
			editMode: false, 
			form: new Form({
				id: "",
				fulltitle: "",
				pricelist: "",
				trntype: "pricecat",
				trnmode: "get",
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
		return { title: "Price Category" };
	},
	methods: {
		editModalWindow(data) {
			this.form.clear();
			this.form.reset();
			this.editMode = true;
			this.showModal = true;
			this.form.fill(data);
			this.form.trntype = "pricecat";
			this.form.trnmode = "update";
		},
		async updatePriceCategory() {
			await this.form.patch("/api/settings/price").then((response) => {
				Swal.fire({
					title: "Product created successfully",
					icon: "success",
					showConfirmButton: false,
					timer: 1500,
				});
				this.fetchPriceCategory();
				this.allPriceCategory;
				this.closeModal();
			});
		},
		openModalGenerateWindow(){
			Swal.fire({
				title: 'Are you sure?',
				text: "The data will be Overwrite!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, Confirm!'
				}).then((result) => {
				if (result.isConfirmed) {
				Swal.fire({
					title: "Checking...",
					text: "Please wait",
					showConfirmButton: false,
					allowOutsideClick: false,
					willOpen: () => {
						Swal.showLoading();
					},
				});

				axios.post('/api/settings/price', {
					trntype: 'generate', 
					}).then(res =>{
						Swal.fire(
						'Successful!',
						'Data has been overwrite',
						'success'
						)
						
					Swal.close();
						this.fetchPriceCategory();
					}) 
				}
				})
		},
		openModalWindow() {
			this.showModal = true;
			this.editMode = false;
			this.form.reset();
		},
		createPriceCategory() {
			this.form.trnmode = "new";
			this.form.post("/api/settings/price").then((response) => {
				Swal.fire({
					title: "Product created successfully",
					icon: "success",
					showConfirmButton: false,
					timer: 1500,
				});
				this.fetchPriceCategory();
				this.allPriceCategory;
				this.closeModal();
			});
		},
		closeModal() {
			this.showModal = false; 
			this.form.errors.errors = "";
		},
		deletePriceCategory(id) {
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
					this.form.id = id;
					this.form.trnmode = "delete";
					this.form
						.post("/api/settings/price")
						.then((response) => {
							Swal.fire(
								"Deleted!",
								"User deleted successfully",
								"success"
							);
							this.fetchPriceCategory();
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
			return this.filteredCategory.filter(
				(item) => item["fulltitle"].toLowerCase().startsWith(this.query) //search start left side
				// .includes(this.query.toLowerCase()) //search match letter
			);
		},
	},

	mounted() {
		this.isAbleToAuth(["price-cat-*"]);
		this.fetchPriceCategory();
		this.currentPage = 1;
		bus.$on("send", (data) => {
			this.query = data;
		});
	},

	computed: {
		allPriceCategory() {
			const data = this.getPriceCat ? this.getPriceCat : "";

			if (this.getPriceCat != "undefined ") {
				this.$emit("change", this.query);
				if (!this.query == "") {
					return data
						.filter(
							(item) =>
								item["fulltitle"]
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
		filteredCategory() {
			var page = this.currentPage;
			var perPage = this.postsPerPage;
			var from = page * perPage - perPage;
			var to = page * perPage;
			return this.allPriceCategory.slice(from, to);
		},
		totalPages() {
			return Math.ceil(this.allPriceCategory.length / this.postsPerPage);
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
