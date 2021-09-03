<template>
	<div>
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Booking List</h6>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table
						class="
							table table-sm table-hover
							text-uppercase
							col-form-label-sm
						"
					>
						<thead class="thead-dark">
							<tr>
								<th
									v-bind:class="[
										sortBy === 'batch' ? sortDirection : '',
									]"
									@click="sort('batch')"
								>
									BATCH
								</th>
								<th
									v-bind:class="[
										sortBy === 'custname'
											? sortDirection
											: '',
									]"
									@click="sort('custname')"
								>
									CUSTOMER
								</th>

								<th
									class="text-center"
									v-bind:class="[
										sortBy === 'trndate'
											? sortDirection
											: '',
									]"
									@click="sort('trndate')"
								>
									TRN DATE
								</th>
								<th
									v-bind:class="[
										sortBy === 'sono' ? sortDirection : '',
									]"
									@click="sort('sono')"
								>
									S.O No.
								</th>
								<th
									v-bind:class="[
										sortBy === 'pono' ? sortDirection : '',
									]"
									@click="sort('pono')"
								>
									P.O. No.
								</th>
								<th class="text-center">AMOUNT</th>
								<th class="text-center">Status</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							<tr
								v-for="data in filteredInvoiceList"
								:key="data.id"
								@dblclick="handleClick(data)"
							>
								<td class="text-capitalize">
									{{ data.batch }}
								</td>
								<td class="text-capitalize">
									{{ data.custname }}
								</td>
								<td class="text-center">{{ data.trndate }}</td>
								<td>{{ data.sono }}</td>
								<td>{{ data.pono }}</td>
								<td class="text-right">
									{{ formatPrice(data.totalamount / 100) }}
								</td>
								<td class="text-center">
									<span
										class="badge"
										:class="
											data.status == '99'
												? ' badge-danger'
												: data.status == '02'
												? ' badge-warning'
												: ' badge-success'
										"
									>
										{{
											data.status == "99"
												? "Cancelled"
												: data.status == "02"
												? "Pending"
												: "Approved"
										}}</span
									>
								</td>
								<td>a</td>
							</tr>
						</tbody>
					</table>
					<vue-plain-pagination
						v-if="allInvoiceList"
						v-model="currentPage"
						:page-count="totalPages"
						:classes="bootstrapPaginationClasses"
						:labels="customLabels"
					/>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import Form from "vform";
import bus from "../../../EventBus";

import { VMoney } from "v-money";
export default {
	name: "BookingList",
	middleware: "auth",
	directives: { money: VMoney },
	data() {
		return {
			money: {
				decimal: ".",
				thousands: ",",
				prefix: "",
				suffix: "",
				precision: 2,
				masked: false /* doesn't work with directive */,
			},
			pagename: "Booking List",

			query: "",
			page: 1,
			items: 6,
			currentPage: 1,
			postsPerPage: 20,
			sortBy: "itemdesc",
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
		this.onLoad;
	},
	metaInfo() {
		return { title: "Booking List" };
	},
	methods: {
		handleClick(data) {
			console.log(data);
			this.$router.push({
				name: "preapprove",
				params: { id: data.batch },
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
			return this.filteredInvoiceList.filter(
				(item) => item["itemdesc"].toLowerCase().startsWith(this.query) //search start left side
				// .includes(this.query.toLowerCase()) //search match letter
			);
		},
	},

	mounted() {
		this.isAbleToAuth(["invoice-read"]);
		this.onLoad;
		this.currentPage = 1;
		bus.$on("send", (data) => {
			this.query = data;
		});
	},

	computed: {
		onLoad() {
			this.$store.dispatch("Invoice/fetchInvoiceList", {
				trnmode: "listproces",
				branch: this.isUser.branch,
			});
		},
		allInvoiceList() {
			const data = this.getList ? this.getList : "";

			if (this.getList != "undefined ") {
				this.$emit("change", this.query);
				if (!this.query == "") {
					return data
						.filter((item) =>
							// item["contactperson"]
							//     .toLowerCase()
							//     // .startsWith(this.query) //search start left side
							//     .includes(this.query.toLowerCase()) //search match letter
							{
								if (
									item["contactperson"]
										.toLowerCase()
										// .startsWith(this.query) //search start left side
										.includes(this.query.toLowerCase())
								) {
									return (
										item["contactperson"]
											.toLowerCase()
											// .startsWith(this.query) //search start left side
											.includes(this.query.toLowerCase())
									);
								}
								if (
									item["consignee"]
										.toLowerCase()
										// .startsWith(this.query) //search start left side
										.includes(this.query.toLowerCase())
								) {
									return (
										item["consignee"]
											.toLowerCase()
											// .startsWith(this.query) //search start left side
											.includes(this.query.toLowerCase())
									);
								}
							}
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
		filteredInvoiceList() {
			var page = this.currentPage;
			var perPage = this.postsPerPage;
			var from = page * perPage - perPage;
			var to = page * perPage;
			return this.allInvoiceList.slice(from, to);
		},
		totalPages() {
			return Math.ceil(this.allInvoiceList.length / this.postsPerPage);
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
