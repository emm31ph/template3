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
				<div class="table-responsive">
					<table
						class="table table-sm table-hover border border-top-0"
					>
						<thead>
							<tr>
								<th scope="col">Item Description</th>
								<th scope="col">Item code</th>
								<th scope="col">Expiry Date</th>
								<th scope="col" class="text-right">Quantity</th>
							</tr>
						</thead>
						<tbody v-if="filteredPosts">
							<tr
								v-for="(item, i) in filteredPosts"
								:key="i"
								:class="item.qty < 0 ? 'text-danger' : ''"
							>
								<td class="">{{ item.itemdesc }}</td>
								<td class="">{{ item.itemcode }}</td>
								<td class="">{{ item.expdate }}</td>
								<td class="text-right">
									{{ formatNumber(item.qty / 100) }}
								</td>
							</tr>
						</tbody>
						<tbody v-if="!getItems || getItems == 0">
							<tr>
								<td colspan="4" class="text-center">
									No Records
								</td>
							</tr>
						</tbody>
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
									>Status</label
								>
								<div class="col-sm-8">
									<select
										class="form-control"
										v-model="branch"
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
										type="date"
										v-model="trndate"
										class="form-control"
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
		};
	},
	metaInfo() {
		return { title: "Item" };
	},
	mounted() {
		this.fetchBranch();
		this.trndate = this.datenow;
		console.log(this.datenow);
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
	},

	methods: {
		handleDownload: function () {
			var data = [];
			for (var i = 0; i < this.getItems.length; i++) {
				data.push({
					ITEMDESC: this.getItems[i]["itemdesc"],
					ITEMCODE: this.getItems[i]["itemcode"],
					EXPDATE: this.getItems[i]["expdate"],
					QTY:
						parseFloat(
							(this.getItems[i]["qty"] / 100).toString()
						).toFixed(2) * 1,
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
			const wb = XLSX.utils.book_new();
			XLSX.utils.book_append_sheet(wb, ws, "data");
			XLSX.writeFile(wb, "demo.xlsx", {
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
			console.log(this.getItems);
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