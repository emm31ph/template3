<template>
	<div>
		<div class="card shadow mb-4">
			<form
				@submit.prevent="handleSubmit"
				@keydown="form.onKeydown($event)"
			>
				<div class="card-body">
					<div class="form-group mb-0">
						<fieldset class="legend-border col">
							<legend class="w-auto legend-border">
								Customer
							</legend>

							<typeahead
								v-model="form.customer"
								:items="getCustomer"
								filterby="custname"
								title="Customer Name"
								@selected="itemSelected"
								class="form-control form-control-sm"
								:class="{
									'is-invalid': form.errors.has(`customer`),
								}"
								:name="`pricecust`"
								ref="searchName"
							/>

							<has-error :form="form" :field="`customer`" />
						</fieldset>
					</div>

					<div class="row mb-0">
						<div class="col-2">
							<fieldset class="legend-border col">
								<legend class="legend-border w-auto">
									Sales Person
								</legend>

								<input
									disabled
									v-model="salespersonName"
									type="text"
									class="form-control form-control-sm"
									placeholder="Sales Person"
								/>
							</fieldset>
						</div>

						<div class="col-2">
							<fieldset class="legend-border col">
								<legend class="legend-border w-auto">
									S.O. No.:
								</legend>

								<input
									maxlength="20"
									type="text"
									v-model="form.sono"
									class="form-control form-control-sm"
									placeholder="S.O. No."
									:disabled="activeField"
								/>
							</fieldset>
						</div>

						<div class="col-2">
							<fieldset class="legend-border col">
								<legend class="legend-border w-auto">
									P.O. No.:
								</legend>

								<input
									maxlength="20"
									type="text"
									v-model="form.pono"
									class="form-control form-control-sm"
									placeholder="P.O. No."
									:disabled="activeField"
								/>
							</fieldset>
						</div>

						<div class="col-3">
							<fieldset class="legend-border col">
								<legend class="legend-border w-auto">
									Deliver To:
								</legend>

								<input
									type="text"
									v-model="form.deliverto"
									class="form-control form-control-sm"
									placeholder="Deliver To"
									:disabled="activeField"
								/>
							</fieldset>
						</div>

						<div class="col-3">
							<fieldset class="legend-border col">
								<legend class="legend-border w-auto">
									Address:
								</legend>

								<input
									type="text"
									v-model="form.address"
									class="form-control form-control-sm"
									placeholder="Address"
									:disabled="activeField"
								/>
							</fieldset>
						</div>
					</div>

					<div class="form-group mb-0">
						<fieldset class="legend-border col">
							<legend class="w-auto legend-border">
								Items Order
							</legend>

							<div class="row">
								<div class="col-5">
									<typeahead
										v-model="itemcode"
										:items="getCustItem"
										:index="`1`"
										filterby="itemdesc"
										@change="onChangeItems"
										title="Product Description"
										@selected="itemSelectedItem"
										class="form-control form-control-sm"
										:name="`form.itemcode`"
										:disable="activeField"
										ref="itemproduct"
									/>
								</div>

								<div class="col-1">
									<input
										v-model="qty"
										@keypress="isNumber($event)"
										@change="getTotal"
										class="form-control form-control-sm"
										style="text-align: right"
										placeholder="Quantity"
										:disabled="activeField"
									/>
								</div>

								<div class="col-1">
									<select
										id="inputState"
										class="
											form-control form-control-sm
											text-center
										"
										@change="getNewTotal"
										v-model="unit"
										:disabled="activeField"
									>
										<option value="" disabled selected>
											Unit
										</option>

										<option
											v-for="option in getLookup('UOM1')"
											v-bind:value="option.code"
											:key="option.code"
										>
											{{ option.fulltitle }}
										</option>
									</select>
								</div>

								<div class="col-1">
									<money
										@change="getTotal"
										v-model.lazy="unitprice"
										v-bind="money"
										class="form-control form-control-sm"
										style="text-align: right"
										placeholder="Unit Price"
										:disabled="activeField"
									></money>
								</div>

								<div class="col-1">
									<input
										v-model="disc"
										type="number"
										@change="getTotal"
										class="
											form-control form-control-sm
											text-right
										"
										placeholder="Discount"
										:disabled="activeField"
									/>
								</div>

								<div class="col-1">
									<money
										@change="getTotal"
										v-model.lazy="price"
										v-bind="money"
										class="form-control form-control-sm"
										style="text-align: right"
										placeholder="Price"
										disabled
									></money>
								</div>

								<div class="col-1">
									<money
										v-model.lazy="linetotal"
										v-bind="money"
										class="form-control form-control-sm"
										style="text-align: right"
										placeholder="Total"
										disabled
									></money>
								</div>

								<div class="col-1">
									<button
										@click="handleAdd"
										:disabled="
											activeField ||
											(itemcode !== ''
												? false
												: qty !== ''
												? false
												: true)
										"
										type="add"
										class="btn btn-sm btn-primary"
									>
										Add
									</button>
								</div>
							</div>
						</fieldset>
					</div>

					<div>
						<fieldset class="legend-border col">
							<legend class="w-auto legend-border">
								Order List
							</legend>

							<div id="table-scroll" class="table-scroll">
								<table id="main-table" class="main-table table">
									<thead>
										<tr>
											<th class="text-left col-1">
												CODE
											</th>

											<th class="col-3">
												PRODUCT DESCRIPTION
											</th>

											<th class="text-center col-1">
												PACKSIZE
											</th>

											<th class="text-right pr-4 col-1">
												QTY
											</th>

											<th class="text-right pr-4 col-1">
												UNIT
											</th>

											<th class="text-right pr-4 col-1">
												UNIT PRICE
											</th>

											<th class="text-right pr-4 col-1">
												DISCOUNT
											</th>

											<th class="text-right pr-4 col-1">
												PRICE
											</th>
											<th class="text-right pr-4 col-1">
												LINE TOTAL
											</th>

											<th
												class="text-right pr-4 col-1"
											></th>
										</tr>
									</thead>

									<tbody>
										<tr
											v-for="(item, i) in form.items"
											:key="i"
										>
											<td class="">
												{{ item.itemcode }}
											</td>

											<td class="">
												{{ item.itemdesc }}
											</td>

											<td class="text-center">
												{{ item.pckgsize }}
											</td>

											<td class="text-right pr-4">
												{{ item.qty }}
											</td>

											<td class="text-right pr-4">
												{{ item.unit }}
											</td>

											<td class="text-right pr-4">
												{{
													formatPrice(item.unitprice)
												}}
											</td>

											<td class="text-right pr-4">
												{{ item.disc }}
											</td>

											<td class="text-right pr-4">
												{{ formatPrice(item.price) }}
											</td>
											<td class="text-right pr-4">
												{{
													formatPrice(item.linetotal)
												}}
											</td>

											<td class="text-right pr-4">
												<i
													class="
														fas
														fa-trash-alt
														btn btn-danger btn-sm
													"
													@click="deleteRow(i, item)"
												></i>
											</td>
										</tr>
									</tbody>

									<tfoot>
										<tr>
											<td colspan="2" class=""></td>

											<td class="text-right">Quantity</td>

											<td class="text-right pr-4">
												{{ qtytotal }}
											</td>

											<td colspan="4" class="text-right">
												Total
											</td>

											<td class="text-right pr-4">
												{{ formatPrice(items_total) }}
											</td>

											<td class=""></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</fieldset>
					</div>
				</div>
				<div class="card-footer">
					<v-button
						:disabled="items_total == '' ? true : false"
						type="submit"
						:loading="form.busy"
						class="btn btn-primary"
					>
						Process
					</v-button>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
import Form from "vform";
import { VMoney } from "v-money";
import { Money } from "v-money";
export default {
	components: { Money },
	name: "Invoice",
	layout: "default",
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

			check: true,
			activeField: true,
			itemcode: "",
			disc: "",
			unitprice: "",
			qty: "",
			price: "",
			linetotal: "",
			discOld: "",
			priceOld: "",
			priceEmitted: "",
			uom: "",
			numperuompu: "",
			items_total: "",
			unit: "",
			qtytotal: "",
			getCustItem: [],
			salespersonName: "",
			search: new Form({
				custno: "",
				pricelist: "",
			}),
			form: new Form({
				trnmode: "newbooking",
				custno: "",
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
		};
	},
	metaInfo() {
		return { title: "Invoice - Create Order" };
	},
	mounted() {
		this.canAuth("invoice-create");
		this.onLoad;
		this.form.userid = this.isUser.id;
		this.form.trndate = this.datenow;

		// var item = {
		// 	cid: 1658,
		// 	branch: "MAIN",
		// 	custno: "000163",
		// 	custname: "REYSON'S EXIM INTERNATIONAL, INC.",
		// 	pricelist: "75",
		// 	status: "1",
		// 	region: "NCR",
		// 	salesperson: "143",
		// 	created_at: null,
		// 	updated_at: null,
		// 	id: "",
		// 	index: "",
		// };
		// this.$refs.searchName.selectedItem = item;

		// this.itemSelected(item);
		// this.activeField = false;
	},
	created() {
		this.isLoggedCheck;
	},
	computed: {},
	methods: {
		onLoad() {
			this.$store.dispatch("Customer/fetchCustomer", {
				branch: this.isUser.branch,
			});
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

			this.salespersonName = this.getSalesPerson(item.salesperson);

			this.form.salesperson = item.salesperson;

			this.activeField = false;
		},
		itemSelectedItem(item) {
			this.itemcode = item.itemcode;
			this.itemdesc = item.itemdesc;
			this.pckgsize = item.pckgsize;
			this.numperuompu = item.numperuompu;
			this.qty = 1;
			this.unit = "CASE";
			this.unitprice = item.price / 100;
			this.price = item.price / 100;
			this.disc = item.discount;
			this.priceOld = item.price / 100;
			this.discOld = item.discount;
			this.linetotal = item.price / 100;
			this.getTotal();
		},
		getTotal(e) {
			let linetotal =
				this.unit == "CASE"
					? this.unitprice
					: this.unitprice / 100 / this.numperuompu;

			this.price = this.unitprice - this.unitprice * (this.disc / 100);
			this.linetotal = this.price * this.qty;

			if (this.unit == "CASE") {
				this.priceOld = this.unitprice;
			} else {
				this.priceOld = this.priceOld * this.numperuompu;
			}
		},
		getNewTotal() {
			this.unitprice =
				this.unit == "CASE"
					? this.unitprice * this.numperuompu
					: this.priceOld / this.numperuompu;

			this.price = this.unitprice - this.unitprice * (this.disc / 100);

			this.linetotal = this.price * this.qty;
		},
		getGranTotal() {
			var subtotal;
			subtotal = this.form.items.reduce(function (sum, item) {
				var lineTotal = parseFloat(item.linetotal);
				if (!isNaN(lineTotal)) {
					return sum + lineTotal;
				}
				return sum;
			}, 0);
			this.items_total = subtotal;

			var subtotal;
			subtotal = this.form.items.reduce(function (sum, item) {
				var lineTotal = parseFloat(item.qty);
				if (!isNaN(lineTotal)) {
					return sum + lineTotal;
				}
				return sum;
			}, 0);
			this.qtytotal = subtotal;
		},
		handleAdd() {
			this.check = true;
			const data = this.form.items;
			for (let i = 0; i < data.length; i++) {
				if (data[i]["itemcode"] === this.itemcode) {
					var idx = this.form.items.indexOf(data[i]);
					if (idx > -1) {
						this.form.items[i].qty = this.formatNumberD(
							this.qty,
							0
						);
						this.form.items[i].unit = this.unit;
						this.form.items[i].unitprice = this.unitprice;
						this.form.items[i].price = this.price;
						this.form.items[i].disc = this.disc;
						this.form.items[i].linetotal = this.linetotal;
						//this.form.items.splice(idx, 1);
						//if already exist
						this.check = false;
					}
				}
			}
			if (this.check) {
				this.form.items.push({
					itemcode: this.itemcode,
					itemdesc: this.itemdesc,
					numperuompu: this.numperuompu,
					qty: this.formatNumberD(this.qty, 0),
					unit: this.unit,
					pckgsize: this.pckgsize,
					unitprice: this.unitprice,
					price: this.price,
					disc: this.disc,
					linetotal: this.linetotal,
				});
			}
			this.getGranTotal();
			this.clearItems();
		},
		clearItems() {
			//this.activeField = true;
			this.activeField = this.search.custno ? false : true;
			this.itemcode = "";
			this.itemdesc = "";
			this.unit = "";
			this.unitprice = "";
			this.disc = "";
			this.priceOld = "";
			this.discOld = "";
			this.qty = "";
			this.price = "";
			this.linetotal = "";
			this.$refs.itemproduct.selectedItem = "";
		},
		deleteRow(index, item) {
			var idx = this.form.items.indexOf(item);
			if (idx > -1) {
				this.form.items.splice(idx, 1);
			}

			this.getGranTotal();
		},
		handleSubmit() {
			Swal.fire({
				title: "Are you sure?",
				text: "You won't be able to revert this!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, confirm it!",
			}).then((result) => {
				if (result.value) {
					Swal.fire({
						position: "top-end",
						icon: "success",
						toast: true,
						title: "successful process",
						showConfirmButton: false,
						timer: 2500,
					});

					this.form.post("/api/invoice/process").then((res) => {
						this.clearItems();
						this.$refs.searchName.selectedItem = "";
						this.form.custno = "";
						this.search.clear;
						this.form.pono = "";
						this.form.sono = "";
						this.form.address = "";
						this.form.deliverto = "";
						this.form.remarks = "";
						this.form.address = "";
						this.salespersonName = "";
						this.form.items = [];
						this.activeField = true;
						this.items_total = 0;
						this.qtytotal = 0;
					});
				}
			});
		},
	},
};
</script>

<style>
.table-scroll {
	position: relative;
	width: 100%;
	z-index: 1;
	margin: auto;
	overflow: auto;
	height: 350px;
}

.table-scroll table {
	width: 100%;
	min-width: 1280px;
	margin: auto;
	border-collapse: separate;
	border-spacing: 0;
}

.table-wrap {
	position: relative;
}

.table-scroll th,
.table-scroll td {
	padding: 5px 10px;
	background: #fff;
	vertical-align: top;
}

.table-scroll thead th {
	background: #888;
	color: #fff;
	position: -webkit-sticky;
	position: sticky;
	top: 0;
}

/* safari and ios need the tfoot itself to be position:sticky also */

.table-scroll tfoot,
.table-scroll tfoot th,
.table-scroll tfoot td {
	position: -webkit-sticky;
	position: sticky;
	bottom: 0;
	background: #888;
	color: #fff;
	z-index: 4;
}

th:first-child {
	position: -webkit-sticky;
	position: sticky;
	left: 0;
	z-index: 2;
	background: #ccc;
}

thead th:first-child,
tfoot th:first-child {
	z-index: 5;
}
</style>
