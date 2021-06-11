<template>
	<div>
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Print Preview</h6>
			</div>
			<div class="card-body">
				<div class="warp">
					<div id="printme">
						<page v-if="data">
							<div class="row p-2">
								<div class="col-12">
									<div class="card border-0">
										<div class="card-body p-0">
											<div
												class="
													container-fluid
													py-0
													pl-0
												"
											>
												<div class="row mb-2">
													<div class="col-3">
														<img
															src="/img/logo.png"
															class="
																rounded
																float-left
																img-thumbnail
																mr-2
															"
															style="width: 75px"
														/>
														<p
															class="
																h2
																font-weight-bold
																mb-0
																pb-0
															"
														>
															TOSEN
														</p>

														<sub> FOODS, INC. </sub>
													</div>
													<div
														class="
															col-6
															text-center
															position-relative
														"
													>
														<p
															class="
																h5
																font-weight-bold
																mb-1
																mt-5
															"
														>
															Recieving Report
															Transaction
														</p>
													</div>
													<div
														class="col-3 text-right"
													>
														<p
															class="
																font-weight-bold
																mb-1
															"
														>
															{{
																this.data[
																	"batch"
																]
															}}
														</p>
														<sub
															class="
																text-muted
																mb-1
															"
														>
															Printed Date:
															{{ this.dateTime }}
														</sub>
													</div>
												</div>
											</div>

											<div class="row pb-2">
												<div class="container-fluid">
													<div class="row">
														<div class="col-6">
															<div class="row">
																<div
																	class="
																		col-2
																		px-0
																	"
																>
																	Supplier :
																</div>
																<div
																	v-if="data"
																	class="
																		col-10
																		border-bottom
																		border-dark
																	"
																>
																	{{
																		this.Ucase(
																			this
																				.data[
																				"customer"
																			]
																		)
																	}}
																</div>
															</div>
															<div class="row">
																<div
																	class="
																		col-2
																		px-0
																	"
																>
																	Van No. :
																</div>
																<div
																	v-if="data"
																	class="
																		col-10
																		border-bottom
																		border-dark
																	"
																>
																	{{
																		this.Ucase(
																			this
																				.data[
																				"van_no"
																			]
																		)
																	}}
																</div>
															</div>
															<div class="row">
																<div
																	class="
																		col-2
																		px-0
																	"
																>
																	Seal No. :
																</div>
																<div
																	v-if="data"
																	class="
																		col-10
																		border-bottom
																		border-dark
																	"
																>
																	{{
																		this.Ucase(
																			this
																				.data[
																				"seal_no"
																			]
																		)
																	}}
																</div>
															</div>
														</div>
														<div class="col-6">
															<div class="row">
																<div
																	class="
																		col-3
																		text-right
																	"
																>
																	Date :
																</div>
																<div
																	v-if="data"
																	class="
																		col-9
																		border-bottom
																		border-dark
																	"
																>
																	{{
																		this
																			.data[
																			"trndate"
																		]
																	}}
																</div>
															</div>
															<div class="row">
																<div
																	class="
																		col-3
																		text-right
																	"
																>
																	RS No :
																</div>
																<div
																	v-if="data"
																	class="
																		col-9
																		border-bottom
																		border-dark
																	"
																>
																	{{
																		this.Ucase(
																			this
																				.data[
																				"refno"
																			]
																		)
																	}}
																</div>
															</div>

															<div class="row">
																<div
																	class="
																		col-3
																		text-right
																	"
																>
																	Remarks :
																</div>
																<div
																	v-if="data"
																	class="
																		col-9
																		border-dark
																	"
																	style="
																		height: 70px;
																	"
																>
																	{{
																		this.Ucase(
																			this
																				.data[
																				"remark"
																			]
																		)
																	}}
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="row h6">
												<div class="col-md-12">
													<table class="mytable">
														<thead>
															<tr>
																<th
																	v-if="
																		repType ==
																		2
																	"
																	class="
																		text-uppercase
																		small
																		font-weight-bold
																		text-center
																		h5
																	"
																	style="
																		width: 10%;
																	"
																>
																	DR QTY
																</th>

																<th
																	class="
																		text-uppercase
																		small
																		font-weight-bold
																		text-center
																	"
																	style="
																		width: 10%;
																	"
																>
																	CR QTY
																</th>
																<th
																	class="
																		text-uppercase
																		small
																		font-weight-bold
																		text-center
																	"
																	style="
																		width: 10%;
																	"
																>
																	UNIT
																</th>
																<th
																	class="
																		text-uppercase
																		small
																		font-weight-bold
																		text-center
																	"
																>
																	Description
																</th>
																<th
																	class="
																		text-uppercase
																		small
																		font-weight-bold
																		text-center
																	"
																	style="
																		width: 10%;
																	"
																>
																	EXPIRY DATE
																</th>
															</tr>
														</thead>
														<tbody v-if="data">
															<tr
																class="
																	text-center
																"
																v-for="(
																	item, i
																) in data[
																	'hist'
																]"
																:key="i"
															>
																<td
																	v-if="
																		repType ==
																		2
																	"
																>
																	{{
																		item[
																			"unit"
																		] !=
																		"TIN"
																			? formatNumberD(
																					toCase(
																						item[
																							"items"
																						][
																							"numperuompu"
																						],
																						item[
																							"drqty"
																						]
																					),
																					0
																			  )
																			: item[
																					"drqty"
																			  ] ==
																			  0
																			? ""
																			: item[
																					"drqty"
																			  ]
																	}}
																</td>
																<td>
																	{{
																		item[
																			"unit"
																		] !=
																		"TIN"
																			? formatNumberD(
																					toCase(
																						item[
																							"items"
																						][
																							"numperuompu"
																						],
																						item[
																							"crqty"
																						]
																					),
																					0
																			  )
																			: item[
																					"crqty"
																			  ] ==
																			  0
																			? ""
																			: item[
																					"crqty"
																			  ]
																	}}
																</td>
																<td>
																	{{
																		Ucase(
																			item[
																				"unit"
																			]
																		)
																	}}
																</td>
																<td>
																	{{
																		Ucase(
																			item[
																				"items"
																			][
																				"itemdesc"
																			]
																		)
																	}}
																</td>
																<td>
																	{{
																		item[
																			"expdate"
																		]
																	}}
																</td>
															</tr>
															<tr
																v-for="i in this
																	.countitems"
																:key="i + 1"
															>
																<td>&nbsp;</td>
																<td
																	v-if="
																		repType ==
																		2
																	"
																></td>
																<td></td>
																<td></td>
																<td></td>
															</tr>
														</tbody>
														<tfoot
															class="
																text-center
																font-weight-bold
															"
														>
															<tr>
																<td
																	v-if="
																		repType ==
																		2
																	"
																>
																	{{
																		formatNumberD(
																			this
																				.drQtyCase,
																			0
																		)
																	}}
																	{{
																		this
																			.drQtyTin !=
																		0
																			? " & " +
																			  formatNumberD(
																					this
																						.drQtyTin,
																					0
																			  )
																			: ""
																	}}
																</td>
																<td>
																	{{
																		formatNumberD(
																			this
																				.crQtyCase,
																			0
																		)
																	}}
																	{{
																		this
																			.crQtyTin !=
																		0
																			? " & " +
																			  formatNumberD(
																					this
																						.crQtyTin,
																					0
																			  )
																			: ""
																	}}
																</td>
																<td
																	colspan="3"
																	style="
																		border-bottom: 0px;
																		border-right: 0px;
																	"
																></td>
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
											<div class="container-fluid pt-3">
												<div class="row">
													<div
														class="
															col-3
															text-center
														"
													>
														<div class="">
															{{
																this.Ucase(
																	this.isUser
																		.name
																)
															}}
														</div>
														<div
															class="
																border-top
																font-weight-bold
																border-dark
															"
														>
															Whse. In-Charge
														</div>
													</div>
													<div class="col-3"></div>
													<div class="col-3"></div>
													<div
														class="
															col-3
															text-center
														"
													>
														<div class="">
															&nbsp;
														</div>
														<div
															class="
																border-top
																font-weight-bold
																border-dark
															"
														>
															RECEIVED BY
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
				<button
					class="btn btn-sm btn-primary"
					@click.prevent="printing()"
				>
					<i class="fa fa-print"></i> Print
				</button>
				<a @click="$router.back()" class="btn btn-sm btn-secondary"
					>back</a
				>
			</div>
		</div>
	</div>
</template>

<script>
import print from "print-js";
export default {
	name: "report",
	middleware: "auth",
	data() {
		return {
			id: this.$route.params.id,
			data: null,
			countitems: 0,
			drtotal: 0,
			crtotal: 0,
		};
	},
	metaInfo() {
		return { title: "Report" };
	},
	created() {
		this.handleSubmit();
	},
	computed: {
		repType() {
			switch (this.id.slice(0, this.id.search("-"))) {
				case "RR":
					return true;
					break;
				// 	case "WP":
				// 		return true;
				// 		break;
				// 	case "RR":
				// 		return true;
				// 		break;
				default:
					this.$router.push({
						name: "report-dlvry",
						params: { id: this.id },
					});
			}
			// this.$router.push({
			// 	name: "inv-delivery-report",
			// 	params: { id: response.data.batch },
			// });
		},
		drQtyCase: function () {
			let sum = 0;

			this.data["hist"].forEach(function (item) {
				if (item.unit != "TIN") {
					sum += parseFloat(
						(item.drqty > 0 ? 1 : -1) *
							(Math.floor(
								item.drqty /
									((item.drqty >= 0 ? 1 : -1) *
										item.items.numperuompu)
							) +
								(item.drqty %
									((item.drqty >= 0 ? 1 : -1) *
										item.items.numperuompu)) /
									((item.drqty >= 0 ? 1 : -1) * 100))
					);
				}
			});
			return sum;
		},
		drQtyTin: function () {
			let sum = 0;

			this.data["hist"].forEach(function (item) {
				if (item.unit == "TIN") {
					sum += parseFloat(item.drqty);
				}
			});
			return sum;
		},
		crQtyCase: function () {
			let sum = 0;

			this.data["hist"].forEach(function (item) {
				if (item.unit != "TIN") {
					sum += parseFloat(
						(item.crqty > 0 ? 1 : -1) *
							(Math.floor(
								item.crqty /
									((item.crqty >= 0 ? 1 : -1) *
										item.items.numperuompu)
							) +
								(item.crqty %
									((item.crqty >= 0 ? 1 : -1) *
										item.items.numperuompu)) /
									((item.crqty >= 0 ? 1 : -1) * 100))
					);
				}
			});
			return sum;
		},
		crQtyTin: function () {
			let sum = 0;

			this.data["hist"].forEach(function (item) {
				if (item.unit == "TIN") {
					sum += parseFloat(item.crqty);
				}
			});
			return sum;
		},
	},
	methods: {
		async handleSubmit() {
			const res = await axios.get("/api/items/reportItem", {
				params: { id: this.id },
			});
			this.data = res.data;
			this.countitems = 11 - res.data["hist"].length;
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
		printVisit(id) {
			this.$htmlToPaper("printme");
			this.$htmlToPaper("printme", () => {
				console.log("Printing completed or was cancelled!");
			});
		},
	},
};
</script>

<style>
</style>