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
										<div class="card-body p-3">
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
															style="width: 150px"
														/> 
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
																mt-2
															"
														>
															IMPORT DOCUMENT
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
														<div class="col-8">
															<div
																class="
																	col-12
																	px-0
																"
																style="
																	height: 70px;
																"
															>
																<span
																	class="
																		col-1
																		px-0
																	"
																>
																	Remarks :
																</span>
																<span
																	v-if="data"
																	class="
																		col-10
																		pl-4
																	"
																	>{{
																		this.Ucase(
																			this
																				.data[
																				"remarks"
																			]
																		)
																	}}</span
																>
															</div>
														</div>
														<div class="col-4">
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
																	class="text-uppercase small font-weight-bold
																		text-center
																		h5
																	"
																	style="
																		width: 10%;
																	"
																>
																	Quantity
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
																	TRN TYPE
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
																	class="
																		text-right
																		pr-3
																	" 
																>
																	{{
																		formatNumber(
																			toCase(
																				item[
																					"numperuompu"
																				],
																				item[
																					"drqty"
																				] +
																					item[
																						"crqty"
																					]
																			)
																		)
																	}}
																</td> 
																<td>
																	{{
																		Ucase(
																			item[
																				"trntype"
																			]
																		)
																	}}
																</td>
																<td
																	class="
																		text-left
																	"
																>
																	{{
																		Ucase(
																			item[
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
																v-for="i in countitems"
																:key="i + data['hist'].length"
															>
																<td>&nbsp;</td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
															</tr>
														</tbody>
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
																 this.isUser['name']
															}}
														</div>
														<div
															class="
																border-top
																font-weight-bold
																border-dark
															"
														>
															PREPARED BY
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
   	props: ["id"] ,
	data() {
		return {
			reportName: "",
			 
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
		 
		drQtyCase: function () {
			let sum = 0;

			this.data["hist"].forEach(function (item) {
				if (item.unit != "TIN") {
					sum += parseFloat(
						(item.drqty > 0 ? 1 : -1) *
							(Math.floor(
								item.drqty /
									((item.drqty >= 0 ? 1 : -1) *
										item.numperuompu)
							) +
								(item.drqty %
									((item.drqty >= 0 ? 1 : -1) *
										item.numperuompu)) /
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
										item.numperuompu)
							) +
								(item.crqty %
									((item.crqty >= 0 ? 1 : -1) *
										item.numperuompu)) /
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

			const cnt = 11 - res.data["hist"].length;
			this.countitems = cnt > 0 ? cnt : 0;
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
				style: "@page {size: 5.5in 8.5in;size: portrait} @page :top { margin-top: 3cm;}",
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
		},repType(data) {
			switch (data) {
				case "IMP":
					return true;
					break; 
				default:
					this.$router.push({
						name: "dashboard" 
					});
			}
		},
    },
    mounted(){  
        if(this.id==undefined){
        	this.$router.push({
				name: "dashboard" 
			});
        }else{ 
            this.repType(this.id.slice(0, this.id.search("-")));
			this.handleSubmit(); 
        }
    
	},
};
</script>

<style>
</style>