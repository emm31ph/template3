<template>
	<div>
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Products</h6>

				<h6
					class="m-0 font-weight-bold text-primary"
					v-if="!can('products-create')"
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
										sortBy === 'itemdesc'
											? sortDirection
											: '',
									]"
									@click="sort('itemdesc')"
								>
									Item description
								</th>
								<th
									v-bind:class="[
										sortBy === 'itemcode'
											? sortDirection
											: '',
									]"
									@click="sort('itemcode')"
								>
									Itemcode
								</th>
								<th
									v-bind:class="[
										sortBy === 'u_skucode'
											? sortDirection
											: '',
									]"
									@click="sort('u_skucode')"
								>
									Shortcode
								</th>
								<th
									v-bind:class="[
										sortBy === 'pckgsize'
											? sortDirection
											: '',
									]"
									@click="sort('pckgsize')"
								>
									Package Size
								</th>
								<th
									v-bind:class="[
										sortBy === 'numperuompu'
											? sortDirection
											: '',
									]"
									@click="sort('numperuompu')"
								>
									Number/Uom
								</th>
								<th
									v-bind:class="[
										sortBy === 'uompu' ? sortDirection : '',
									]"
									@click="sort('uompu')"
								>
									UOM
								</th>
								<th class="text-center">Status</th>
								<th class="text-center">Modify</th>
							</tr>
						</thead>
						<tbody>
							<tr
								v-for="product in filteredProducts"
								:key="product.id"
							>
								<td class="text-capitalize">
									{{ product.itemdesc }}
								</td>
								<td class="text-capitalize">
									{{ product.itemcode }}
								</td>
								<td>{{ product.u_skucode }}</td>
								<td>{{ product.pckgsize }}</td>
								<td>{{ product.numperuompu }}</td>
								<td>{{ product.uompu }}</td>
								<td class="text-center">
									<span
										class="badge"
										:class="
											product.status == '99'
												? ' badge-danger'
												: ' badge-success'
										"
										>{{
											product.status == "99"
												? "Delete"
												: "Active"
										}}</span
									>
								</td>
								<td class="text-center">
									<div v-if="product.status != '99'">
										<a
											href="#"
											data-id="product.id"
											@click="editModalWindow(product)"
											v-if="!can('products-update')"
										>
											<i class="fa fa-edit blue"></i>
										</a>

										<a
											href="#"
											@click="
												deleteProduct(product.itemcode)
											"
											v-if="!can('products-delete')"
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
						v-if="allProducts"
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
										Add New Product
									</h5>
									<h5
										v-show="editMode"
										class="modal-title"
										id="addNewLabel"
									>
										Update Product
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
											? updateProduct()
											: createProduct()
									"
									@keydown="form.onKeydown($event)"
								>
									<div class="modal-body">
										<div class="form-group">
											<label for="itemdesc"
												>Item description</label
											>
											<input
												v-model="form.itemdesc"
												type="text"
												name="itemdesc"
												placeholder="Item description"
												class="form-control"
												:class="{
													'is-invalid':
														form.errors.has(
															'itemdesc'
														),
												}"
											/>
											<has-error
												:form="form"
												field="itemdesc"
											></has-error>
										</div>

										<div class="form-group">
											<label for="itemcode"
												>Itemcode</label
											>
											<input
												v-model="form.itemcode"
												type="text"
												name="itemcode"
												placeholder="Itemcode"
												:disabled="editMode"
												class="form-control"
												:class="{
													'is-invalid':
														form.errors.has(
															'itemcode'
														),
												}"
											/>
											<has-error
												:form="form"
												field="itemcode"
											></has-error>
										</div>

										<div class="form-group">
											<label for="Shortcode"
												>Shortcode</label
											>
											<input
												v-model="form.u_skucode"
												type="text"
												name="u_skucode"
												placeholder="Shortcode"
												class="form-control"
												:class="{
													'is-invalid':
														form.errors.has(
															'u_skucode'
														),
												}"
											/>
											<has-error
												:form="form"
												field="u_skucode"
											></has-error>
										</div>

										<div class="form-group">
											<label for="Package Size"
												>Package Size</label
											>
											<input
												v-model="form.pckgsize"
												type="text"
												name="pckgsize"
												placeholder="Package Size"
												class="form-control"
												:class="{
													'is-invalid':
														form.errors.has(
															'pckgsize'
														),
												}"
											/>
											<has-error
												:form="form"
												field="pckgsize"
											></has-error>
										</div>

										<div class="form-group">
											<label for="# per UOM"
												># per UOM</label
											>
											<input
												v-model="form.numperuompu"
												type="text"
												name="numperuompu"
												placeholder="Number per Unit"
												class="form-control"
												:class="{
													'is-invalid':
														form.errors.has(
															'numperuompu'
														),
												}"
											/>
											<has-error
												:form="form"
												field="numperuompu"
											></has-error>
										</div>

										<div class="form-group">
											<label for="UOM">UOM</label>
											<input
												v-model="form.uompu"
												type="text"
												name="uompu"
												placeholder="UOM"
												class="form-control"
												:class="{
													'is-invalid':
														form.errors.has(
															'uompu'
														),
												}"
											/>
											<has-error
												:form="form"
												field="uompu"
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
	name: "ProductsList",
	middleware: "auth",
	data() {
		return {
			showModal: false,
			pagename: "Products",
			editMode: false,
			value: [],
			roles: [],
			form: new Form({
				itemdesc: "",
				itemcode: "",
				pckgsize: "",
				u_skucode: "",
				uompu: "",
				numperuompu: "",
				status: "01",
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
		return { title: "Products" };
	},
	methods: {
		editModalWindow(product) {
			this.form.clear();
			this.form.reset();
			this.editMode = true;
			this.showModal = true;
			this.form.fill(product);
		},
		async updateProduct() {
			await this.form.patch("/api/items/update").then((response) => {
				Swal.fire({
					title: "Product created successfully",
					icon: "success",
					showConfirmButton: false,
					timer: 1500,
				});
				this.fetchProducts();
				this.closeModal();
			});
		},
		openModalWindow() {
			this.showModal = true;
			this.editMode = false;
			this.form.reset();
		},
		createProduct() {
			this.form
				.post("/api/items/create")
				.then((response) => {
					Swal.fire({
						title: "Product created successfully",
						icon: "success",
						showConfirmButton: false,
						timer: 1500,
					});
					this.fetchProducts();
					this.closeModal();
				})
				.catch(() => {
					Swal.fire({
						icon: "error",
						title: "Oops...",
						text: "Something went wrong!",
					});
				});
		},
		closeModal() {
			this.showModal = false;
			this.form.errors.errors = "";
		},
		deleteProduct(id) {
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
						.delete("/api/items/" + id)
						.then((response) => {
							Swal.fire(
								"Deleted!",
								"User deleted successfully",
								"success"
							);
							this.fetchProducts();
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
			return this.filteredProducts.filter(
				(item) => item["itemdesc"].toLowerCase().startsWith(this.query) //search start left side
				// .includes(this.query.toLowerCase()) //search match letter
			);
		},
	},

	mounted() {
		this.isAbleToAuth(["products-*"]);
		this.fetchProducts();
		this.currentPage = 1;
		bus.$on("send", (data) => {
			this.query = data;
		});
	},

	computed: {
		allProducts() {
			const data = this.getProducts ? this.getProducts : "";

			if (this.getProducts != "undefined ") {
				this.$emit("change", this.query);
				if (!this.query == "") {
					return data
						.filter(
							(item) =>
								item["itemdesc"]
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
		filteredProducts() {
			var page = this.currentPage;
			var perPage = this.postsPerPage;
			var from = page * perPage - perPage;
			var to = page * perPage;
			return this.allProducts.slice(from, to);
		},
		totalPages() {
			return Math.ceil(this.allProducts.length / this.postsPerPage);
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
