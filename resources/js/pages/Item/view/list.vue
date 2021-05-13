<template>
	<div>
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">
					List of Items Product
				</h6>

				<h6 class="m-0 font-weight-bold text-primary">
					<a href="#" data-toggle="modal" data-target="#uploadModal">
						<i class="fas fa-cogs"></i>
					</a>
				</h6>
			</div>
			<div class="card-body">
				<div
					class="d-flex text-capitalize font-weight-bold"
					v-if="getItems || getItems != 0"
				>
					<div class="col-2">
						Branch : {{ this.branch ? this.branch : "All" }}
					</div>
					<div class="col-2">Date : {{ this.trndate }}</div>
				</div>
				<div class="table-responsive">
					<table
						class="table table-sm table-hover table-bordered border-top-0 table-striped"
					>
						<thead class="thead-dark">
							<tr>
								<th scope="col" class="pl-2">
									Item Description
								</th>
								<th scope="col">Item code</th>
								<th
									scope="col"
									class="text-center"
									style="width: 120px"
								>
									Expiry Date
								</th>
								<th
									scope="col"
									class="text-center"
									style="width: 120px"
								>
									Last Trn
								</th>
								<th
									scope="col"
									class="text-right pr-2"
									style="width: 120px"
								>
									Quantity
								</th>
							</tr>
						</thead>
						<tbody v-if="filteredPosts">
							<tr
								v-for="(item, i) in filteredPosts"
								:key="i"
								:class="item.qty < 0 ? 'text-danger' : ''"
							>
								<td class="pl-2">{{ item.itemdesc }}</td>
								<td class="">{{ item.itemcode }}</td>
								<td class="text-center">{{ item.expdate }}</td>
								<td class="text-center">{{ item.lasttrn }}</td>
								<td class="text-right pr-2">
									{{ formatNumber(item.qty / 100) }}
								</td>
							</tr>
						</tbody>
						<tbody v-if="!getItems || getItems == 0">
							<tr>
								<td colspan="5" class="text-center">
									No Records
								</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td class="text-right">
									Total:
									{{
										formatNumber(this.drQty / 100)
											? formatNumber(this.drQty / 100)
											: 0
									}}
								</td>
							</tr>
						</tfoot>
					</table>
					<nav aria-label="Page navigation example">
						<ul class="pagination mb-0">
							<li class="page-item">
								<button @click="prev" class="page-link">
									Prev
								</button>
							</li>
							<li
								class="page-item"
								v-for="(pageNumber, k) in totalPages"
								:key="k"
								v-if="
									Math.abs(pageNumber - currentPage) < 3 ||
									pageNumber == totalPages - 1 ||
									pageNumber == 0
								"
								:class="
									currentPage === pageNumber
										? 'active'
										: false
								"
							>
								<button
									type="button"
									class="page-link"
									@click="setPage(pageNumber)"
								>
									{{ pageNumber }}
								</button>
							</li>
							<li class="page-item">
								<button @click="next" class="page-link">
									Next
								</button>
							</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div id="uploadModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Search</h4>
						<button
							type="button"
							class="close"
							data-dismiss="modal"
						>
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
											isUser.branch != 'MAIN'
												? true
												: false
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
	</div>
</template>

<script>
export default {
	name: "items",
	middleware: "auth",
	data() {
		return {
			pagename: "Item List",
			trndate: "",
			branch: "",
			pages: [],
			page: 1,
			items: 6,
			currentPage: 1,
			postsPerPage: 15,
			action: "preview",
			total: 0,
		};
	},
	metaInfo() {
		return { title: "Item" };
	},
	mounted() {
		this.fetchItems();
		this.fetchBranch();
		this.trndate = this.datenow;
		this.branch = this.isUser.branch;
		console.log(window.screen.height);
	},
	computed: {
		allPosts() {
			if (this.action == "preview") {
				const data = this.getItems ? this.getItems : "";
				if (this.getItems != "undefined ") {
					return Object.keys(data).map((itemcode) => data[itemcode]);
				}
			}
			return false;
		},
		filteredPosts() {
			if (this.action == "preview") {
				return this.allPosts.slice(
					(this.currentPage - 1) * this.postsPerPage,
					this.currentPage * this.postsPerPage
				);
			}
			return false;
		},
		totalPages() {
			if (this.action == "preview") {
				return Math.ceil(this.allPosts.length / this.postsPerPage);
			}
			return false;
		},
		drQty: function () {
			var sum = 0;
			for (var i = 0; i < this.getItems.length; i++) {
				sum = sum + this.getItems[i]["qty"] * 1;
			}
			return sum;
		},
	},

	methods: {
		handleDownload: function () {
			var data = [];
			for (var i = 0; i < this.getItems.length; i++) {
				data.push({
					SKU: this.getItems[i]["itemcode"],
					FSKU: "",
					SHORTDESC: this.getItems[i]["u_skucode"],
					EXPDATE: this.getItems[i]["expdate"],
					P: this.getItems[i]["p"],
					ITEMDESC: this.getItems[i]["itemdesc"],
					WAREHOUSE: this.getItems[i]["branch"],
					QTY:
						parseFloat(
							(this.getItems[i]["qty"] / 100).toString()
						).toFixed(2) * 1,
					CASESIZE: this.getItems[i]["pckgsize"],
				});
			}

			const ws = XLSX.utils.json_to_sheet(
				data,
				// { header: header },
				{
					skipHeader: false,
					origin: "A1",
					raw: false,
					dateNF: "yyyy-mm-dd",
					cellDates: true,
				}
			);

			// const merge = [
			// 	{ s: { c: 0, r: 0 }, e: { c: 1, r: 1 }, v: "hello", t: "s" }, // <-- The cell A1 represents the range A1:B2
			// 	{ s: { c: 2, r: 0 }, e: { c: 2, r: 1 } }, // <-- The cell C1 represents the range C1:C2
			// 	{ s: { c: 0, r: 2 }, e: { c: 1, r: 2 } }, // <-- The cell A3 represents the range A3:B3
			// 	{ s: { c: 3, r: 0 }, e: { c: 3, r: 1 } }, // <-- The cell D1 represents the range D1:D2
			// 	{ s: { c: 0, r: 3 }, e: { c: 1, r: 3 } },
			// ];
			// ws["!merges"] = merge;

			const wb = XLSX.utils.book_new();

			// ws[
			// 	{
			// 		A2: { t: "s", v: "Sheet" },
			// 		B2: { t: "n", v: 12 },
			// 		A3: { t: "s", v: "JS" },
			// 		B3: { t: "n", v: 24 },
			// 		A1: { t: "s", v: "name" },
			// 		B1: { t: "s", v: "age" },
			// 	}
			// ];
			XLSX.utils.book_append_sheet(wb, ws, "data");
			XLSX.writeFile(wb, "export " + this.trndate + ".xlsx", {
				bookType: "xlsx",
				type: "array",
			});
		},
		async handleSubmit(value) {
			this.action = value;
			Swal.fire({
				title: "Checking...",
				text: "Please wait",
				showConfirmButton: false,
				allowOutsideClick: false,
				willOpen: () => {
					Swal.showLoading();
				},
			});
			await this.$store.dispatch("Item/fetchItems", {
				trndate: this.trndate,
				branch: this.branch,
			});

			if (this.getItems.length == 0) {
				Swal.fire({
					title:
						this.getItems.length == 0
							? "No record found"
							: "Your work has been saved",
					showConfirmButton: false,
					timer: 1500,
				});
			} else {
				if (value == "excel") {
					this.handleDownload();
				}
				Swal.close();
			}
		},

		next() {
			if (this.currentPage < this.totalPages) {
				this.currentPage++;
			}
		},
		prev() {
			if (this.currentPage > 1) {
				this.currentPage--;
			}
		},
		setPage: function (pageNumber) {
			this.currentPage = pageNumber;
		},
	},
};
</script>

<style>
</style>