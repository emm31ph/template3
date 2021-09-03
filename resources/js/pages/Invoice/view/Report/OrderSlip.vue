<template>
	<transition name="modal-fade">
		<div class="modal-backdrop">
			<div
				class="modal"
				role="dialog"
				aria-labelledby="modalTitle"
				aria-describedby="modalDescription"
			>
				<header class="modal-header" id="modalTitle">
					<h6 class="m-0 font-weight-bold text-primary">
						Print Preview
					</h6>

					<button
						type="button"
						class="btn-close"
						@click="close"
						aria-label="Close modal"
					>
						x
					</button>
				</header>

				<div class="card shadow m-2 h-100">
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
															class="
																mytable
																w-100
															"
															style="
																font-size: 11px;
															"
														>
															<tr>
																<td>
																	Customer :
																	{{
																		this
																			.data[
																			"customer"
																		][0][
																			"custname"
																		]
																	}}
																</td>
																<td>
																	Date :
																	{{
																		this
																			.data[
																			"trndate"
																		]
																	}}
																</td>
																<td>
																	S.O No. :
																	{{
																		this
																			.data[
																			"sono"
																		]
																	}}
																</td>
																<td
																	class="
																		text-center
																		align-text-top
																	"
																	rowspan="2"
																>
																	Order
																	Acknowledge
																	By
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
																		this
																			.data[
																			"address"
																		]
																	}}
																</td>
																<td>
																	Salesman :
																	{{
																		this
																			.data[
																			"salesperson"
																		][0][
																			"salespersonname"
																		]
																	}}
																</td>
																<td>
																	P.O. No. :
																	{{
																		this
																			.data[
																			"pono"
																		]
																	}}
																</td>
																<!-- <td></td>
																<td></td>
																<td></td> -->
															</tr>
															<tr>
																<td>
																	Deliver To :
																	{{
																		this
																			.data[
																			"deliver_to"
																		]
																	}}
																</td>
																<td>
																	Delivery
																	Date :
																	{{
																		this
																			.data[
																			"deliver_to"
																		]
																	}}
																</td>
																<td>
																	Terms :
																	{{
																		this
																			.data[
																			"terms"
																		]
																	}}
																</td>
																<td
																	class="
																		text-center
																	"
																>
																	Customer
																	Printed
																	Name/
																	Signature
																</td>
																<td
																	class="
																		text-center
																	"
																>
																	Credit &
																	Collection
																</td>
																<td
																	class="
																		text-center
																	"
																>
																	Approving
																	Officer
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
																class="
																	mytable
																	w-100
																"
																style="
																	font-size: 11px;
																"
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
																			UNIT
																			PRICE
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
																			item,
																			i
																		) in data[
																			'items'
																		]"
																		:key="i"
																	>
																		<td
																			class="
																				text-center
																			"
																		>
																			{{
																				item[
																					"qty"
																				]
																			}}
																		</td>
																		<td
																			class="
																				text-center
																			"
																		>
																			{{
																				item[
																					"unit"
																				]
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
																		<td
																			class=""
																		>
																			{{
																				Ucase(
																					item[
																						"itemdesc"
																					]
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
																					item[
																						"unitprice"
																					] /
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
																					item[
																						"discount"
																					]
																						? item[
																								"discount"
																						  ]
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
																					item[
																						"linetotal"
																					] /
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
															style="
																font-size: 11px;
															"
														>
															<div class="col-6">
																Remarks :
																{{
																	this.data[
																		"remarks"
																	]
																}}
															</div>

															<div class="col-6">
																<div
																	class="row"
																>
																	<div
																		class="
																			col-4
																		"
																	>
																		<div
																			class="
																				row
																			"
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
																	<div
																		class="
																			col-8
																		"
																	>
																		<div
																			class="
																				row
																			"
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
				</div>

				<footer class="modal-footer d-inline-flex">
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

					<!-- <button
    
                            type="button"
    
                            class="btn-green"
    
                            @click="close"
    
                            aria-label="Close modal"
    
                        >
    
                            Close me!
    
                        </button> -->
				</footer>
			</div>
		</div>
	</transition>
</template>

    <script>
import print from "print-js";

import { jsPDF } from "jspdf";
import printPDF from "./print";
import Form from "vform";
export default {
	name: "report",
	middleware: "auth",
	props: ["id"],
	data() {
		return {
			totalCol: 0,
			data: null,
			status: "",
			countitems: 0,
			drtotal: 0,
			crtotal: 0,
			status: "",
			total: 0,
			discount: 0,
			nettotal: 0,
			form: new Form({
				items: [],
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

			console.log(res.data);
			this.status = res.data.status;
			this.data = res.data;
			this.totalCol =
				40 - res.data["items"].length <= 0
					? 0
					: 40 - res.data["items"].length;
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
		close() {
			this.$emit("close");
		},
	},
	mounted() {
		this.onLoad;
		// this.id = "BK-MAIN-00000000001";
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
.modal {
	background: #ffffff;
	box-shadow: 2px 2px 20px 1px;
	overflow-x: auto;
	display: flex;
	flex-direction: column;
}

.modal-header,
.modal-footer {
	padding: 15px;
	display: flex;
}

.modal-header {
	position: relative;
	border-bottom: 1px solid #eeeeee;
	color: #4aae9b;
	justify-content: space-between;
}

.modal-footer {
	border-top: 1px solid #eeeeee;
	/* flex-direction: column; */
}

.modal-body {
	position: relative;
	padding: 20px 10px;
}

.btn-close {
	position: absolute;
	top: 0;
	right: 0;
	border: none;
	font-size: 20px;
	padding: 10px;
	cursor: pointer;
	font-weight: bold;
	color: #4aae9b;
	background: transparent;
}

.btn-green {
	color: white;
	background: #4aae9b;
	border: 1px solid #4aae9b;
	border-radius: 2px;
}

.modal-fade-enter,
.modal-fade-leave-to {
	opacity: 0;
}

.modal-fade-enter-active,
.modal-fade-leave-active {
	transition: opacity 0.5s ease;
}
</style>