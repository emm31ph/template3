<template>
	<div class="card shadow mb-4">
		<div class="card-header py-3 d-flex justify-content-between">
			<h6 class="m-0 font-weight-bold text-primary">Import</h6>
			<h6 class="m-0 font-weight-bold text-primary">
				<a @click="showModal = true">
					<i class="fas fa-cogs"></i>
				</a>
			</h6>
		</div>
		<div class="card-body">
			<div class="wrapper">
				<form @submit.prevent="handleSubmit">
					<div class="warp">
						<div class="table-responsive">
							<table
								class="table table-sm table-striped table-hover"
							>
								<thead>
									<tr>
										<th
											class="text-sm text-wrap w-auto"
											style=""
										>
											ITEM DESCRIPTION
										</th>
										<th class="text-sm w-auto">
											ITEM CODE
										</th>
										<th class="text-sm text-center">
											PHYSICAL
										</th>

										<th class="text-sm text-center w-auto">
											EXPIRY DATA
										</th>
										<th class="text-sm text-center w-auto">
											QUANTITY
										</th>
										<th class="text-sm text-center">
											TRNTYPE
										</th>
									</tr>
								</thead>
								<tbody v-if="form.importItems.length">
									<tr
										v-for="(item, i) in form.importItems"
										:key="i"
									>
										<td>
											{{ item.ITEMDESC }}
											<input
												type="hidden"
												:value="item.ITEMDESC"
												readonly
											/>
										</td>
										<td>
											{{ item.ITEMCODE }}
											<input
												type="hidden"
												:value="item.ITEMCODE"
												readonly
											/>
										</td>
										<td class="text-center">
											{{ item.PCNT }}
											<input
												type="hidden"
												:value="item.PCNT"
												readonly
											/>
										</td>

										<td class="text-center">
											{{ item.EXPDATE }}
											<input
												type="hidden"
												:value="item.EXPDATE"
												readonly
											/>
										</td>
										<td class="text-center">
											{{ item.QTY }}
											<input
												type="hidden"
												:value="item.QTY"
												readonly
											/>
										</td>
										<td class="text-center">
											{{ item.TRNTYPE }}
											<input
												type="hidden"
												:value="item.TRNTYPE"
												readonly
											/>
										</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="4"></td>
										<td>{{ formatNumber(this.drQty) }}</td>
										<td></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
					<div class="d-flex justify-content-between">
						<v-button
							type="submit"
							:loading="form.busy"
							class="btn btn-primary"
							:class="
								!form.importItems.length
									? 'btn-secondary'
									: 'btn-primary'
							"
							:disabled="!form.importItems.length"
						>
							Import
						</v-button>

						<div class="p-2 col-6">
							<div class="row">
								<div class="col-9 text-right">
									{{ formatNumber(this.drQty) }}
								</div>
							</div>
						</div>
					</div>
				</form>
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
									<h4 class="modal-title">
										File upload form
									</h4>
									<button
										type="button"
										class="close"
										@click="showModal = false"
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
										Select file :
										<input
											type="file"
											class="h-full w-full"
											id="input-excel"
											name="file"
										/><br />

										<button
											v-on:click="handleFileUpload"
											type="button"
											class="btn btn-info"
											value="Upload"
											data-dismiss="modal"
										>
											Submit
										</button>
									</form>
								</div>
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
export default {
	middleware: "auth",
	name: "import",
	metaInfo() {
		return { title: "Import" };
	},
	data: () => ({
		showModal: false,
		form: new Form({
			importItems: [],
		}),
	}),

	created() {
		this.isLoggedCheck;
	},
	mounted() {
		this.canAuth("items-import");
	},
	methods: {
		handleFileUpload() {
			this.showModal = false;
			this.form.importItems = [];
			var fileUpload = document.getElementById("input-excel");
			if (!fileUpload.value == "") {
				var reader = new FileReader();
				reader.readAsArrayBuffer(fileUpload.files[0]);
				reader.onload = (e) => {
					let data = new Uint8Array(e.target.result);

					var workbook = XLSX.read(data, {
						type: "array",
						cellDates: true,
						cellNF: false,
						cellText: false,
					});
					let worksheet = workbook.Sheets["INVENTORY"];
					if (typeof worksheet != "undefined") {
						var remarks = "";
						var trndate = this.convert(worksheet["F1"].v);
						if (typeof worksheet["H1"] != "undefined") {
							remarks = worksheet["H1"].v;
						}
						var _JsonData = XLSX.utils.sheet_to_json(worksheet, {
							raw: false,
							dateNF: "yyyy-mm-dd",
							header: [
								"SKUCODE",
								"SHORTCODE",
								"ITEMCODE",
								"ITEMDESC",
								"PCNT",
								"EXPDATE",
								"FWD",
								"BR",
								"RR",
								"WP",
								"OD",
								"END",
							],
							range: 4,
							defval: "",
						});

						var e = 0;
						for (var i = 0; i < _JsonData.length - 1; i++) {
							if (_JsonData[i]["ITEMCODE"] != "") {
								if (_JsonData[i]["BR"] != 0) {
									this.form.importItems.push({
										ITEMDESC: _JsonData[i]["ITEMDESC"],
										ITEMCODE: _JsonData[i]["ITEMCODE"],
										SHORTCODE: _JsonData[i]["SHORTCODE"],
										PCNT: _JsonData[i]["PCNT"],
										EXPDATE: _JsonData[i]["EXPDATE"],
										FWD: _JsonData[i]["FWD"],
										END: _JsonData[i]["END"],
										QTY: _JsonData[i]["BR"],
										TRNTYPE: "BR",
										REMARKS: remarks,
										TRNDATE: trndate,
									});
								}
								if (_JsonData[i]["RR"] != 0) {
									this.form.importItems.push({
										ITEMDESC: _JsonData[i]["ITEMDESC"],
										ITEMCODE: _JsonData[i]["ITEMCODE"],
										SHORTCODE: _JsonData[i]["SHORTCODE"],
										PCNT: _JsonData[i]["PCNT"],
										EXPDATE: _JsonData[i]["EXPDATE"],
										FWD: _JsonData[i]["FWD"],
										END: _JsonData[i]["END"],
										QTY: _JsonData[i]["RR"],
										TRNTYPE: "RR",
										REMARKS: remarks,
										TRNDATE: trndate,
									});
								}
								if (_JsonData[i]["WP"] != 0) {
									this.form.importItems.push({
										ITEMDESC: _JsonData[i]["ITEMDESC"],
										ITEMCODE: _JsonData[i]["ITEMCODE"],
										SHORTCODE: _JsonData[i]["SHORTCODE"],
										PCNT: _JsonData[i]["PCNT"],
										EXPDATE: _JsonData[i]["EXPDATE"],
										FWD: _JsonData[i]["FWD"],
										END: _JsonData[i]["END"],
										QTY: _JsonData[i]["WP"],
										TRNTYPE: "WP",
										REMARKS: remarks,
										TRNDATE: trndate,
									});
								}
								if (_JsonData[i]["OD"] != 0) {
									this.form.importItems.push({
										ITEMDESC: _JsonData[i]["ITEMDESC"],
										ITEMCODE: _JsonData[i]["ITEMCODE"],
										SHORTCODE: _JsonData[i]["SHORTCODE"],
										PCNT: _JsonData[i]["PCNT"],
										EXPDATE: _JsonData[i]["EXPDATE"],
										FWD: _JsonData[i]["FWD"],
										END: _JsonData[i]["END"],
										QTY: _JsonData[i]["OD"],
										TRNTYPE: "OD",
										REMARKS: remarks,
										TRNDATE: trndate,
									});
								}
							}
						}
					} else {
						document.getElementById("input-excel").value = null;

						Swal.fire({
							title: "Error!",
							text: "Something error in your data 1",
							icon: "error",
							confirmButtonText: "Ok",
						});
					}
				};
			} else {
				Swal.fire({
					icon: "error",
					title: "Oops...",
					text: "No file selected",
					footer: "<a href>Why do I have this issue?</a>",
				});
			}
		},
		async handleSubmit() {
			if (this.form.importItems.length != 0) {
				const { data } = await axios.get("/api/items/importTrndate", {
					params: {
						trndate: this.form.importItems[0]["TRNDATE"],
					},
				});
				if (data) {
					///
					this.handleSave();
					////
				} else {
					//confirmation on existing
					Swal.fire({
						title: "Are you sure?",
						text:
							this.form.importItems[0]["TRNDATE"] +
							" is already import, You want continue this!",
						icon: "warning",
						showCancelButton: true,
						confirmButtonColor: "#3085d6",
						cancelButtonColor: "#d33",
						confirmButtonText: "Yes",
					}).then((result) => {
						if (result.isConfirmed) {
							/////
							this.handleSave();
							////
						}
					});
				}
			} else {
				Swal.fire({
					title: "Error!",
					text: "No data to be import",
					icon: "error",
					confirmButtonText: "Ok",
				});
			}
		},
		async handleSave() {
			await this.form
				.post("/api/items/import ")
				.then((result) => {
					this.form.importItems = [];
					// document.getElementById("input-excel").value = null;
					if (result.status == 200) {
						// test for status you want, etc
						Swal.fire({
							icon: "success",
							title: "Your work has been saved",
							showConfirmButton: false,
							timer: 1500,
						});
					}
				})
				.catch((err) => {
					Swal.fire({
						title: "Error!",
						text: err.message,
						icon: "error",
						confirmButtonText: "Ok",
					});
				});
		},
		convert(str) {
			var date = new Date(str),
				mnth = ("0" + (date.getMonth() + 1)).slice(-2),
				day = ("0" + date.getDate()).slice(-2);
			return [date.getFullYear(), mnth, day].join("-");
		},
	},
	computed: {
		drQty: function () {
			var sum = 0;
			for (var i = 0; i < this.form.importItems.length; i++) {
				this.record = +i;
				sum = sum + this.form.importItems[i]["QTY"] * 1;
			}
			return sum;
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
