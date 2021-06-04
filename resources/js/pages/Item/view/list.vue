<template>
	<div>
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">
					List of Items Product
				</h6>

				<h6 class="m-0 font-weight-bold text-primary">
					<a href="#" data-toggle="modal" data-target="#searchModal">
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
						Branch : {{ this.branches ? this.branches : "All" }}
					</div>
					<div class="col-2">
						Date : {{ this.trndatefrom }} - {{ this.trndateto }}
					</div>
				</div>
				<div class="table-responsive">
					<table
						class="table table-sm table-hover table-bordered border-top-0 table-striped"
					>
						<thead class="thead-dark">
							<tr>
								<th
									:class="this.branches ? 'd-none' : ''"
									style="width: 80px"
								>
									Branch
								</th>
								<th
									scope="col"
									class="pl-2"
									v-bind:class="[
										sortBy === 'itemdesc'
											? sortDirection
											: '',
									]"
									@click="sort('itemdesc')"
								>
									Item Description
								</th>
								<th
									scope="col"
									style="width: 220px"
									v-bind:class="[
										sortBy === 'itemcode'
											? sortDirection
											: '',
									]"
									@click="sort('itemcode')"
								>
									Item code
								</th>
								<th
									scope="col"
									class="text-center"
									style="width: 120px"
									v-bind:class="[
										sortBy === 'expdate'
											? sortDirection
											: '',
									]"
									@click="sort('expdate')"
								>
									Expiry Date
								</th>
								<th
									scope="col"
									class="text-center"
									style="width: 120px"
									v-bind:class="[
										sortBy === 'lasttrn'
											? sortDirection
											: '',
									]"
									@click="sort('lasttrn')"
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
								@dblclick="handleTrnHist(item)"
							>
								<td
									:class="branches ? 'd-none' : ''"
									class="pl-2"
								>
									{{ item.branch }}
								</td>

								<td class="pl-2">{{ item.itemdesc }}</td>
								<td class="">{{ item.itemcode }}</td>
								<td class="text-center">
									{{
										item.expdate == "1900-01-01"
											? ""
											: item.expdate
									}}
								</td>
								<td class="text-center">{{ item.lasttrn }}</td>
								<td class="text-right pr-2">
									{{
										formatNumber(
											toCase(item.numperuompu, item.qty)
										)
									}}
								</td>
							</tr>
						</tbody>
						<tbody v-if="!getItems || getItems == 0">
							<tr>
								<td
									:colspan="branches ? '5' : '6'"
									class="text-center"
								>
									<b> No Record</b>
								</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td
									:colspan="branches ? '3' : '4'"
									class="text-right"
								>
									Records :
									<b
										>{{
											this.filteredPosts != 0
												? this.record + 1
												: 0
										}}
									</b>
								</td>
								<td colspan="2" class="text-right">
									Grand Total :
									<b
										>{{
											this.filteredPosts != 0
												? formatNumber(this.drQty)
												: "0"
										}}
									</b>
								</td>
							</tr>
						</tfoot>
					</table>
					<vue-plain-pagination
						v-if="allPosts"
						v-model="currentPage"
						:page-count="totalPages"
						:classes="bootstrapPaginationClasses"
						:labels="customLabels"
					/>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div id="searchModal" class="modal fade" role="dialog">
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
									class="col-sm-3 col-form-label font-weight-bold"
									>Branch</label
								>
								<div class="col-sm-9">
									<select
										class="form-control"
										v-model="branches"
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
									class="col-sm-3 col-form-label font-weight-bold"
									>Date</label
								>
								<div class="col-sm-9">
									<div class="row">
										<div class="col-6">
											<input
												v-model="trndatefrom"
												class="form-control"
												type="date"
											/>
										</div>
										<div class="col-6">
											<input
												v-model="trndateto"
												class="form-control"
												type="date"
											/>
										</div>
									</div>
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

									<a
										class="dropdown-item"
										href="#"
										@click="handleDetailSubmit()"
										data-dismiss="modal"
										>Export Detailed</a
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

		<!-- Modal -->
		<div
			id="trnModal"
			class="modal fade"
			role="dialog"
			data-backdrop="static"
			v-if="trnHistData"
		>
			<div class="modal-dialog modal-lg">
				<!-- Modal content-->
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
					<div class="modal-body pt-4" id="printme">
						<div class="row pb-3">
							<div class="col-8">
								<span class="col-2 font-weight-bold"
									>Branch :
								</span>
								<span class="col-10 font-weight-bold">{{
									trnHistData["branch"]
								}}</span>
							</div>
							<div class="col-4">
								<span class="col-2 font-weight-bold text-right"
									>Balance Qty :</span
								>
								<span class="col-10 font-weight-bold">
									{{
										formatNumber(
											toCase(
												trnHistData["numperuompu"],
												trnHistData["qty"]
											)
										)
									}}</span
								>
							</div>
							<div class="col-8">
								<span class="col-2 font-weight-bold"
									>DESC :</span
								>
								<span class="col-10 font-weight-bold">
									{{ trnHistData["itemdesc"] }}
								</span>
							</div>
							<div class="col-4">
								<span class="col-2 font-weight-bold text-right"
									>SKU :</span
								>
								<span class="col-10 font-weight-bold">
									{{ trnHistData["itemcode"] }}
								</span>
							</div>
							<div class="col-8">
								<span class="col-2 font-weight-bold"
									>LAST UPDATE :</span
								>
								<span class="col-10 font-weight-bold">
									{{ dateF(trnHistData["updated_at"]) }}
								</span>
							</div>
							<div class="col-4 font-weight-bold">
								<span class="col-2 font-weight-bold text-right"
									>EXP. DATE :</span
								>
								<span class="col-10 font-weight-bold">
									{{ trnHistData["expdate"] }}
								</span>
							</div>
						</div>
						<div class="tableFixHead">
							<table class="table table-sm">
								<thead>
									<tr>
										<th
											scope="col"
											style="width: 100px"
											class="text-center"
										>
											TRNDATE
										</th>
										<th
											scope="col"
											style="width: 100px"
											class="text-center"
										>
											TRNTYPE
										</th>
										<th
											scope="col"
											style="width: 100px"
											class="text-right"
										>
											DR QTY
										</th>
										<th
											scope="col"
											style="width: 100px"
											class="text-right"
										>
											CR QTY
										</th>
										<th
											scope="col"
											style="width: 100px"
											class="text-right"
										>
											BALANCE
										</th>
										<th scope="col" class="pl-3">
											REMARKS
										</th>
									</tr>
								</thead>
								<tbody
									style="
										height: 10px !important;
										overflow: scroll;
										flex-direction: column-reverse;
									"
								>
									<tr
										v-for="(item, i) in trnHistData[
											'trn_hist'
										]"
										:key="i"
									>
										<td class="text-center">
											{{ item["trndate"] }}
										</td>
										<td class="text-center">
											{{ item["trntype"] }}
										</td>
										<td class="text-right">
											{{
												formatNumber(
													toCase(
														trnHistData[
															"numperuompu"
														],
														item["drqty"]
													)
												)
											}}
										</td>
										<td class="text-right">
											{{
												formatNumber(
													toCase(
														trnHistData[
															"numperuompu"
														],
														item["crqty"]
													)
												)
											}}
										</td>
										<td class="text-right">
											{{
												formatNumber(
													toCase(
														trnHistData[
															"numperuompu"
														],
														item["curqty"]
													)
												)
											}}
										</td>
										<td>
											<div
												class="col-12 pl-3 remarks d-print-inline-flex"
												id="remarks"
												:title="` ${
													item['refno']
														? 'Ref# - ' +
														  item['refno'] +
														  ' | '
														: ''
												}${
													item['rono']
														? 'RO# - ' +
														  item['rono'] +
														  ' | '
														: ''
												}${
													item['customer']
														? String.fromCharCode(
																13
														  ) +
														  'Customer - ' +
														  item['customer'] +
														  ' | '
														: ''
												}${
													item['from']
														? String.fromCharCode(
																13
														  ) +
														  'FROM - ' +
														  item['from'] +
														  ' | '
														: ''
												} ${
													item['to']
														? 'TO - ' +
														  item['to'] +
														  ' | '
														: ''
												} ${
													item['remarks']
														? String.fromCharCode(
																13
														  ) +
														  'Remarks - ' +
														  item['remarks'] +
														  ' | '
														: ''
												}${
													item['van_no']
														? String.fromCharCode(
																13
														  ) +
														  'Van#  - ' +
														  item['van_no'] +
														  ' | '
														: ''
												}${
													item['seal_no']
														? 'Seal#  - ' +
														  item['seal_no'] +
														  ' | '
														: ''
												}`"
											>
												{{
													item["refno"]
														? item["refno"] + " | "
														: ""
												}}{{
													item["rono"]
														? item["rono"] + " | "
														: ""
												}}{{
													item["customer"]
														? item["customer"] +
														  " | "
														: ""
												}}{{
													item["from"]
														? item["from"] + " | "
														: ""
												}}{{
													item["to"]
														? item["to"] + " | "
														: ""
												}}{{
													item["remarks"]
														? item["remarks"] +
														  " | "
														: ""
												}}{{
													item["van_no"]
														? item["van_no"] + " | "
														: ""
												}}{{
													item["seal_no"]
														? item["seal_no"] +
														  " | "
														: ""
												}}
											</div>
										</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="6"></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>

					<!-- end body -->
					<div class="modal-footer">
						<button
							type="button"
							class="btn btn-secondary"
							data-dismiss="modal"
							@click="handleClose"
						>
							Close
						</button>
						<button
							type="button"
							class="btn btn-primary"
							@click.prevent="printing()"
						>
							<i class="fa fa-print"></i> Print
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import print from "print-js";
import bus from "../../../EventBus";
export default {
	name: "items",
	middleware: "auth",
	data() {
		return {
			query: "",
			pagename: "Item List",
			trndatefrom: "",
			trndateto: "",
			branches: "",
			pages: [],
			page: 1,
			items: 6,
			currentPage: 1,
			postsPerPage: 20,
			action: "preview",
			total: 0,
			record: 0,
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
			sortBy: "qty",
			sortDirection: "asc",
			trnHistData: [],
		};
	},
	metaInfo() {
		return { title: "Item" };
	},
	created() {
		this.isLoggedCheck;
	},
	mounted() {
		this.fetchItems();
		this.fetchBranch();
		this.trndatefrom = this.monthdayyear(this.datenow, -20);
		this.trndateto = this.datenow;
		this.branches = this.isUser.branch;
		this.onLoad;
		this.currentPage = 1;
		bus.$on("send", (data) => {
			this.query = data;
			this.drQty;
		});
	},
	computed: {
		onLoad() {
			this.$store.dispatch("Item/fetchItems", {
				trndatefrom: this.monthdayyear(this.datenow, -20),
				trndateto: this.monthdayyear(this.datenow),
				branch: this.isUser.branch,
			});
		},
		allPosts() {
			if (this.action == "preview") {
				const data = this.getItems ? this.getItems : "";
				if (this.getItems != "undefined ") {
					// this.$emit("change", this.query);
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
								if (this.sortDirection === "desc")
									modifier = -1;
								if (p1[this.sortBy] < p2[this.sortBy])
									return -1 * modifier;
								if (p1[this.sortBy] > p2[this.sortBy])
									return 1 * modifier;
								return 0;
							});
					} else {
						// return Object.keys(data).map((itemcode) => data[itemcode]);
						return Object.keys(data)
							.map((itemcode) => data[itemcode])
							.sort((p1, p2) => {
								let modifier = 1;
								if (this.sortDirection === "desc")
									modifier = -1;
								if (p1[this.sortBy] < p2[this.sortBy])
									return -1 * modifier;
								if (p1[this.sortBy] > p2[this.sortBy])
									return 1 * modifier;
								return 0;
							});
					}
				}
			}
			return false;
		},
		filteredPosts() {
			if (this.action == "preview") {
				var page = this.currentPage;
				var perPage = this.postsPerPage;
				var from = page * perPage - perPage;
				var to = page * perPage;
				return this.allPosts.slice(from, to);
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
			for (var i = 0; i < this.allPosts.length; i++) {
				this.record = +i;
				sum =
					sum +
					this.toCase(
						this.allPosts[i]["numperuompu"],
						this.allPosts[i]["qty"]
					);
			}
			return sum;
		},
	},

	methods: {
		handleDetailSubmit() {
			axios
				.get("/api/items/getItemDetailTran", {
					params: {
						branch: this.branches,
						trndatefrom: this.trndatefrom,
						trndateto: this.trndateto,
					},
				})
				.then((res) => {
					var items = res.data;

					var item = [];

					for (var i = 0; i < items.length; i++) {
						var data = [];
						data["SKU"] = items[i]["itemcode"];
						data["ITEMDESC"] = items[i]["itemdesc"];
						data["EXPDATE"] = items[i]["expdate"];
						data["BRANCH"] = items[i]["branch"];
						data[
							"FWDS " + this.monthday(this.trndatefrom, -1)
						] = this.toCase(
							items[i]["numperuompu"],
							items[i]["preqty"]
						);
						data["BR"] = this.toCase(
							items[i]["numperuompu"],
							items[i]["BR"]
						);
						data["RR"] = this.toCase(
							items[i]["numperuompu"],
							items[i]["RR"]
						);
						data["WP"] = this.toCase(
							items[i]["numperuompu"],
							items[i]["WP"]
						);
						data["OD"] = this.toCase(
							items[i]["numperuompu"],
							items[i]["OD"]
						);
						data[
							"ENDING " + this.monthday(this.trndateto)
						] = this.toCase(
							items[i]["numperuompu"],
							items[i]["qty"]
						);
						data["CASESIZE"] = items[i]["pckgsize"];
						item.push(data);
					}

					var header = [];
					header.push({
						0: "Inventory Detailed",
						1: "Date " + this.trndatefrom + " - " + this.trndateto,
						2: "Branch " + this.branches,
					});
					this.export(this.branches + " detailed", item, header);
				});
		},
		handleDownload: function () {
			var data = [];
			var header = [];
			for (var i = 0; i < this.getItems.length; i++) {
				data.push({
					SKU: this.getItems[i]["itemcode"],
					FSKU: "",
					SHORTDESC: this.getItems[i]["u_skucode"],
					EXPDATE: this.getItems[i]["expdate"],
					P: this.getItems[i]["p"],
					ITEMDESC: this.getItems[i]["itemdesc"],
					WAREHOUSE: this.getItems[i]["branch"],
					QTY: this.toCase(
						this.getItems[i]["numperuompu"],
						this.getItems[i]["qty"]
					),
					CASESIZE: this.getItems[i]["pckgsize"],
				});
			}

			var header = [];
			header.push({
				0: "Inventory Summary",
				1: "Date " + this.trndatefrom + " - " + this.trndateto,
				2: "Branch " + this.branches,
			});
			this.export(this.branches + " summary", data, header);
		},
		export(fileName, data, header) {
			const wb = XLSX.utils.book_new();

			var ws = XLSX.utils.aoa_to_sheet([[header[0][0]]], {
				skipHeader: false,
				origin: "A1",
				raw: false,
				dateNF: "yyyy-mm-dd",
				cellDates: true,
			});
			// const merge = [
			// 	{ s: { c: 0, r: 0 }, e: { c: cnt, r: 0 } }, // <-- The cell A1 represents the range A1:B2
			// 	// 	{ s: { c: 2, r: 0 }, e: { c: 2, r: 1 } }, // <-- The cell C1 represents the range C1:C2
			// 	// 	{ s: { c: 0, r: 2 }, e: { c: 1, r: 2 } }, // <-- The cell A3 represents the range A3:B3
			// 	// 	{ s: { c: 3, r: 0 }, e: { c: 3, r: 1 } }, // <-- The cell D1 represents the range D1:D2
			// 	// 	{ s: { c: 0, r: 3 }, e: { c: 1, r: 3 } },
			// ];
			// ws["!merges"] = merge;

			XLSX.utils.sheet_add_aoa(ws, [[header[0][1]]], { origin: -1 });
			XLSX.utils.sheet_add_aoa(ws, [[header[0][2]]], { origin: -1 });
			XLSX.utils.sheet_add_json(ws, data, { origin: -1 });

			XLSX.utils.book_append_sheet(wb, ws, "data");

			// XLSX.utils.book_append_sheet(wb, ws1, "data");

			XLSX.writeFile(wb, "export " + fileName + ".xlsx", {
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
				trndatefrom: this.trndatefrom,
				trndateto: this.trndateto,
				branch: this.branches,
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
		handleTrnHist(data) {
			$("#trnModal").modal("show");

			axios
				.get("/api/items/getTrnHist", {
					params: {
						branch: data.branch,
						expdate: data.expdate,
						itemcode: data.itemcode,
						trndatefrom: this.trndatefrom,
						trndateto: this.trndateto,
					},
				})
				.then((res) => {
					console.log(res);
					this.trnHistData = res.data[0];
				});

			return true;
		},
		handleClose() {
			$("#trnModal").modal("hide");
		},
		printing() {
			var style = [
				window.location.origin + "/dist/css/app.css",
				// window.location.origin + "/dist/css/print.css",
			];
			printJS({
				name: "_blank",
				specs: ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
				printable: "printme",
				type: "html",
				css: style,
				//style: "@page {size: 5.5in 8.5in;size: landscape;}",
				// style: "@page {size: 5.5in 4.25in;size: landscape;}",
				style: "@page {size: 5.5in 8.5in;}",
				// header: "Multiple Images",
				scanStyles: false,
				onPrintDialogClose: () =>
					console.log("The print dialog was closed"),
				onError: (e) => console.log(e),
			});
		},
		sort: function (s) {
			if (s === this.sortBy) {
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

			return this.filteredPosts.filter(
				(item) => item["itemname"].toLowerCase().startsWith(this.query) //search start left side
				// .includes(this.query.toLowerCase()) //search match letter
			);
		},
	},
};
</script>

<style>
.tableFixHead {
	overflow-y: scroll;
	max-height: 350px;
	width: auto;
	display: flex;
	flex-direction: column-reverse;
}
.tableFixHead thead th {
	position: sticky;
	top: 0;
	z-index: 1;
	background-color: black;
	color: white;
}
.tableFixHead tbody th {
	position: sticky;
	left: 0;
	border-bottom: 1px solid black;
}
</style>