<template>
	<div>
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Booking List</h6>
			</div>
			<div class="card-body">
				<div class="warp">
					<div id="printme" ref="testHtml">
						<page v-if="data">
							<div class="row p-2">
								<div class="col-12">
									<div class="card border-0">
										<div class="card-body p-3">
											<print-header
												class="meprint"
												title="Order Slip"
												:docno="id"
											/>
											<div class="row">
												<table
													class="mytable w-100"
													style="font-size: 11px"
												>
													<tr>
														<td>
															Customer :
															{{
																this.form
																	.customer[0][
																	"custname"
																]
															}}
														</td>
														<td>
															Date :
															{{
																this.form
																	.trndate
															}}
														</td>
														<td>
															S.O No. :
															{{ this.form.sono }}
														</td>
														<td
															class="
																text-center
																align-text-top
															"
															rowspan="2"
														>
															Order Acknowledge By
														</td>
														<td
															class="
																text-center
																align-text-top
															"
															rowspan="2"
														>
															Recommending
															Approval
														</td>
														<td
															class="
																text-center
																align-text-top
															"
															rowspan="2"
														>
															Override/Approved
														</td>
													</tr>

													<tr>
														<td>
															Address :
															{{
																this.form
																	.address
															}}
														</td>
														<td>
															Salesman :
															{{
																this.form
																	.salesperson[0][
																	"salespersonname"
																]
															}}
														</td>
														<td>
															P.O. No. :
															{{ this.form.pono }}
														</td>
														<!-- <td></td>
																<td></td>
																<td></td> -->
													</tr>
													<tr>
														<td>
															Deliver To :
															{{
																this.form
																	.delivery_to
															}}
														</td>
														<td>
															Delivery Date :
															{{
																this.form
																	.deliverydate
															}}
														</td>
														<td>
															Terms :
															{{
																this.form.terms
															}}
														</td>
														<td class="text-center">
															Customer Printed
															Name/ Signature
														</td>
														<td class="text-center">
															Credit & Collection
														</td>
														<td class="text-center">
															Approving Officer
														</td>
													</tr>
												</table>
											</div>
											<!-- start  -->
											<div class="row mb-3">
												<div
													class="
														col
														py-2
														px-0
														d-flex
														justify-content-center
													"
												>
													<table
														class="mytable w-100"
														style="font-size: 11px"
													>
														<thead>
															<tr
																class="
																	text-uppercase
																	font-weight-bold
																"
															>
																<th
																	class="
																		text-center
																	"
																>
																	QTY
																</th>
																<th
																	class="
																		text-center
																	"
																>
																	UNIT
																</th>
																<th
																	class="
																		text-center
																	"
																>
																	CODE
																</th>
																<th
																	class="
																		text-center
																	"
																>
																	Item
																	Description
																</th>
																<th
																	style="
																		width: 100px;
																	"
																	class="
																		text-center
																		pr-2
																	"
																>
																	UNIT PRICE
																</th>
																<th
																	class="
																		text-center
																		pr-2
																	"
																>
																	DISC.
																</th>
																<th
																	class="
																		text-center
																		pr-2
																	"
																>
																	AMOUNT
																</th>
															</tr>
														</thead>
														<tbody>
															<tr
																style="
																	line-height: 15px;
																"
																v-for="(
																	item, k
																) in form.items"
																:key="k"
															>
																<td
																	class="
																		text-center
																	"
																>
																	{{
																		item.qty
																	}}
																</td>
																<td
																	class="
																		text-center
																	"
																>
																	{{
																		item.unit
																	}}
																</td>
																<td
																	class="
																		text-center
																	"
																>
																	{{
																		item[
																			"shortcode"
																		]
																	}}
																</td>
																<td class="">
																	<typeahead
																		ref="itemproduct"
																		v-model="
																			item.itemcode
																		"
																		:items="
																			getCustItem
																		"
																		:index="`${k}`"
																		:datavalue="
																			item.itemdesc
																		"
																		filterby="itemdesc"
																		filterby2="itemcode"
																		filterby3="u_stockcode"
																		addOnDisplay1="expdate"
																		addOnDisplay="qtyDesc"
																		@change="
																			onChangeItems
																		"
																		title="Itemdesc"
																		@selected="
																			itemSelectedItem
																		"
																		class="
																			form-control
																			form-control-sm
																		"
																		:class="{
																			'is-invalid':
																				form.errors.has(
																					`items.${k}.itemcode`
																				),
																		}"
																		:name="`items.${k}.itemcode`"
																	/>
																	<has-error
																		:form="
																			form
																		"
																		:field="`items.${k}.itemcode`"
																	/>
																	<has-error
																		:form="
																			form
																		"
																		:field="`items.${k}.itemcode`"
																	/>
																</td>

																<td
																	class="
																		pr-2
																		text-right
																	"
																>
																	{{
																		formatPrice(
																			item.unitprice /
																				100,
																			2
																		)
																	}}
																</td>
																<td
																	class="
																		pr-2
																		text-right
																	"
																>
																	{{
																		formatNumberD(
																			item.discount
																				? item.discount
																				: 0
																		)
																	}}
																</td>
																<td
																	class="
																		pr-2
																		text-right
																	"
																>
																	{{
																		formatPrice(
																			item.linetotal /
																				100,
																			2
																		)
																	}}
																</td>
															</tr>
														</tbody>
														<!-- <tfoot>
																	<tr>
																		<td
																			class="
																				text-center
																			"
																		>
																			<b
																				>TOTAL
																				:
																				{{
																					this
																						.totalQty
																				}}
																			</b>
																		</td>
																		<td
																			colspan="3"
																		></td>
																	</tr>
																</tfoot> -->
													</table>
												</div>
											</div>
											<!-- signatories -->
											<div
												class="
													footer
													container-fluid
													py-0
												"
											>
												<div
													class="row mb-2"
													style="font-size: 11px"
												>
													<div class="col-6">
														Remarks :
														{{
															this.data["remarks"]
														}}
													</div>

													<div class="col-6">
														<div class="row">
															<div class="col-4">
																<div
																	class="row"
																>
																	<div
																		class="
																			col-6
																		"
																	>
																		TOTAL
																		CASES:
																	</div>

																	<div
																		class="
																			col-6
																			pr-2
																			border-bottom
																		"
																	>
																		{{
																			totalQty
																		}}
																	</div>
																</div>
															</div>
															<div class="col-8">
																<div
																	class="row"
																>
																	<div
																		class="
																			col-8
																			text-right
																		"
																	>
																		GRANT
																		TOTAL
																		AMOUNT:
																	</div>
																	<div
																		class="
																			col-4
																			text-right
																			pr-2
																			border-bottom
																		"
																	>
																		{{
																			formatPrice(
																				total
																			)
																		}}
																	</div>
																	<div
																		class="
																			col-8
																			text-right
																		"
																	>
																		REGULAR
																		DISCOUNT:
																	</div>
																	<div
																		class="
																			col-4
																			text-right
																			pr-2
																			border-bottom
																		"
																	>
																		{{
																			discount !=
																			0
																				? formatPrice(
																						discount
																				  )
																				: ""
																		}}
																	</div>
																	<div
																		class="
																			col-8
																			text-right
																		"
																	>
																		NET
																		AMOUNT:
																	</div>
																	<div
																		class="
																			col-4
																			text-right
																			pr-2
																			border-bottom
																		"
																	>
																		{{
																			formatPrice(
																				nettotal
																			)
																		}}
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</page>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<div class="d-inline-flex">
					<div class="px-1">
						<button
							class="btn btn-sm btn-primary"
							@click.prevent="printing()"
						>
							<i class="fa fa-print"></i> Print
						</button>
					</div>
					<div class="px-1">
						<a
							@click="handleCancel(data['batch'])"
							v-if="
								status == '02' &&
								this.can('transaction-cancel') &&
								status != '99'
							"
							class="btn-sm btn btn-danger"
							><i class="fa fa-trash"></i> Cancel</a
						>
					</div>
					<div class="px-1">
						<a
							@click="$router.back()"
							class="btn btn-sm btn-secondary"
							>Back</a
						>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

    <script>
import print from "print-js";
import Form from "vform";
export default {
	name: "report",
	middleware: "auth",
	props: ["id"],
	data() {
		return {
			data: null,
			status: "",
			countitems: 0,
			drtotal: 0,
			crtotal: 0,
			status: "",
			total: 0,
			discount: 0,
			nettotal: 0,
			getCustItem: [],
			form: new Form({
				trnmode: "preapprove",
				custno: "",
				customer: "",
				branch: "",
				salesperson: "",
				terms: "",
				sono: "",
				pono: "",
				address: "",
				deliverto: "",
				trndate: "",
				items: [],
				remarks: "",
				deliverydate: "",
				creditcollection: "",
				totalamount: "",
				totaldiscount: "",
				acknowledge: "",
				userid: "",
			}),
			search: new Form({
				custno: "",
				pricelist: "",
			}),

			form2: new Form({
				batch: "",
				trnmode: "",
				os_no: "",
			}),
		};
	},
	metaInfo() {
		return {
			title: "Report",
		};
	},

	computed: {
		totalAmount: function () {
			let sum = 0;

			this.data["items"].forEach(function (item) {
				sum += parseFloat(item.total);
			});
			return sum / 100;
		},

		totalQty: function () {
			let sum = 0;

			this.data["items"].forEach(function (item) {
				sum += parseFloat(item.qty);
			});
			return sum;
		},
		onLoad() {
			this.$store.dispatch("Settings/fetchSignatories", {
				trnmode: "print",
				trntype: "PL001",
			});

			this.$store.dispatch("Customer/fetchCustomer", {
				branch: this.isUser.branch,
			});
		},
	},
	methods: {
		async handleApprove(data) {
			const { value: os_no } = await Swal.fire({
				title: "Enter Order Slip Number",
				input: "text",
				inputLabel: "Order Slip Number",

				showCancelButton: true,
				inputValidator: (value) => {
					if (!value) {
						return "Invalid Order Slip Number";
					}
				},
			});

			if (os_no) {
				this.form2.batch = data;
				this.form2.trnmode = "log-sp-approved";
				this.form2.os_no = os_no;
				Swal.fire({
					position: "top-end",
					icon: "success",
					toast: true,
					title: "successful approved",
					showConfirmButton: false,
					timer: 2500,
				});
				await this.form2.post("/api/process/logistic").then((res) => {
					this.$router.push({
						name: "bookinglist",
					});
				});
				// Swal.fire(`Your IP address is ${data}`)
			}
		},
		repType(data) {
			switch (data) {
				case "BK":
					return true;
					break;
				default:
					this.$router.push({
						name: "bookinglist",
					});
			}
		},
		async handleSubmit() {
			const res = await axios.get("/api/invoice/process", {
				params: {
					trnmode: "report1",
					trntrntype: "",
					id: this.id,
				},
			});
			this.form.fill(res.data);
			this.status = res.data.status;
			this.data = res.data;
			console.log(this.form);
			this.form.userid = this.isUser.id;
			this.form.trndate = this.datenow;

			var item = {
				cid: res.data.cid,
				branch: res.data.branch,
				custno: res.data.custno,
				custname: res.data.customer[0]["custname"],
				pricelist: res.data.customer[0]["pricelist"],
				status: res.data.customer[0]["status"],
				region: res.data.customer[0]["region"],
				salesperson: res.data.customer[0]["salesperson"],
			};
			// this.$refs.searchName.selectedItem = item;

			this.itemSelected(item);
		},
		itemSelectedItem(item) {
			this.form.items[item.id].itemcode = item.itemcode;
			this.form.items[item.id].expdate = item.expdate;
			// this.form.items[item.id].bal = item.qty;
			this.form.items[item.id].numperuompu = item.numperuompu;
			this.form.items[item.id].shortcode = item.u_stockcode;
			console.log(item);
			// this.toTin(item.id);
			// this.calculateTotal();
		},
		itemSelected(item) {
			this.form.branch = this.isUser.branch;
			this.form.custno = item.custno;
			this.form.term = item.term;
			this.search.custno = item.custno;
			this.search.pricelist = item.pricelist;
			this.search.trnmode = "items-list";
			this.search.post("/api/invoice/process").then((res) => {
				this.getCustItem = res.data;
			});

			// 	this.salespersonName = this.getSalesPerson(item.salesperson);

			// 	this.form.salesperson = item.salesperson;

			// 	this.activeField = false;
		},
		printing() {
			var style = [
				window.location.origin + "/dist/css/app.css",
				window.location.origin + "/dist/css/print.css",
			];
			printJS({
				name: "_blank",
				specs: ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
				printable: "printme",
				type: "html",
				targetStyles: ["*"],
				css: style,
				//style: "@page {size: 5.5in 8.5in;size: landscape;}",
				//style: "@page {size: 5.5in 8.5in;size: landscape;}",
				//style: "@page {size: 5.5in 8.5in; padding:10px  }",
				style: "@page { size: legal landscape; }",
				// style: "@page { size: legal landscape; }",
				// header: "Multiple Images",
				scanStyles: false,
				onPrintDialogClose: () =>
					console.log("The print dialog was closed"),
				onError: (e) => console.log(e),
			});
		},
		handleCancel(data) {
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
					this.form.batch = data;
					this.form.trnmode = "bookingcancel";
					this.form.post("/api/invoice/process").then((resp) => {
						this.status = "99";
						Swal.fire({
							position: "top-end",
							icon: "success",
							toast: true,
							title: "successful process",
							showConfirmButton: false,
							timer: 2500,
						});
						this.$router.push({
							name: "log-packing-list",
						});
					});
				}
			});
		},
		printVisit(id) {
			this.$htmlToPaper("printme");
			this.$htmlToPaper("printme", () => {
				console.log("Printing completed or was cancelled!");
			});
		},
	},
	mounted() {
		this.onLoad;
		// this.id = "BK-MAIN-00000000002";
		if (this.id == undefined) {
			this.$router.push({
				name: "bookinglist",
			});
		} else {
			this.repType(this.id.slice(0, this.id.search("-")));
			this.handleSubmit();
		}
	},
};
</script>

    <style>
</style>