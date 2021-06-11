<template>
	<div class="card shadow mb-4">
		<div class="card-header py-3 d-flex justify-content-between">
			<h6 class="m-0 font-weight-bold text-primary">
				Delivery Transaction
			</h6>
		</div>
		<div class="card-body">
			<form
				onsubmit="event.preventDefault();"
				@keydown="form.onKeydown($event)"
			>
				<div class="form-row">
					<div class="col-md-6 form-group row">
						<label
							for="inputCustomer"
							class="
								col-sm-3 col-form-label col-form-label-sm
								text-md-right
							"
							>Reference No :</label
						>
						<div class="col-sm-9">
							<input
								v-model="form.refno"
								type="text"
								class="form-control form-control-sm"
								:class="{
									'is-invalid': form.errors.has('refno'),
								}"
								name="refno"
							/>
							<has-error :form="form" field="refno" />
						</div>
					</div>
					<div class="col-md-6 form-group row">
						<label
							for="inputCustomer"
							class="
								col-sm-4 col-form-label col-form-label-sm
								text-md-right
							"
							>Supporting Document :</label
						>
						<div class="col-sm-8">
							<input
								v-model="form.rono"
								type="text"
								class="form-control form-control-sm"
								:class="{
									'is-invalid': form.errors.has('rono'),
								}"
								name="rono"
							/>
							<has-error :form="form" field="rono" />
						</div>
					</div>

					<div class="col-md-6 form-group row">
						<label
							for="inputCustomer"
							class="
								col-sm-3 col-form-label col-form-label-sm
								text-md-right
							"
							>Issued Date :</label
						>
						<div class="col-sm-9">
							<input
								v-model="form.trndate"
								type="date"
								class="form-control form-control-sm"
								:class="{
									'is-invalid': form.errors.has('trndate'),
								}"
								name="trndate"
							/>
							<has-error :form="form" field="trndate" />
						</div>
					</div>
					<div class="col-md-6 form-group row">
						<label
							for="inputCustomer"
							class="
								col-sm-4 col-form-label col-form-label-sm
								text-md-right
							"
							>Remarks :</label
						>
						<div class="col-sm-8">
							<input
								v-model="form.remarks"
								type="text"
								class="form-control form-control-sm"
								:class="{
									'is-invalid': form.errors.has('remarks'),
								}"
								name="remarks"
							/>
							<has-error :form="form" field="remarks" />
						</div>
					</div>
					<div class="col-md-6 form-group row">
						<label
							for="inputCustomer"
							class="
								col-sm-3 col-form-label col-form-label-sm
								text-md-right
							"
							>Customer :</label
						>
						<div class="col-sm-9">
							<textarea
								v-model="form.customer"
								rows="3"
								class="form-control form-control-sm"
								:class="{
									'is-invalid': form.errors.has('customer'),
								}"
								name="customer"
							/>
							<has-error :form="form" field="customer" />
						</div>
					</div>
				</div>
				<div class="">
					<table class="table table-sm table-striped">
						<thead>
							<tr>
								<th>Item Description</th>
								<th class="text-center" style="width: 15%">
									Exp. Date
								</th>
								<th class="text-center" style="width: 15%">
									Case/Tins
								</th>
								<th class="text-center" style="width: 15%">
									Quantity
								</th>
								<th style="width: 50px"></th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(item, k) in form.items" :key="k">
								<td>
									<typeahead
										v-model="item.itemcode"
										:items="getItemsOut"
										:index="`${k}`"
										filterby="itemdesc"
										addOnDisplay1="expdate"
										addOnDisplay="qtyDesc"
										@change="onChangeItems"
										title="Type Itemdesc"
										@selected="itemSelected"
										:classes="`form-control form-control-sm`"
										:class="{
											'is-invalid': form.errors.has(
												`items.${k}.itemcode`
											),
										}"
										:name="`items.${k}.itemcode`"
									/>
									<has-error
										:form="form"
										:field="`items.${k}.itemcode`"
									/>
								</td>
								<td>
									<input
										disabled="true"
										v-model="item.expdate"
										type="date"
										class="
											form-control form-control-sm
											text-center
										"
										:class="{
											'is-invalid': form.errors.has(
												`items.${k}.expdate`
											),
										}"
										:name="`items.${k}.expdate`"
									/>

									<has-error
										:form="form"
										:field="`items.${k}.expdate`"
									/>
								</td>
								<td>
									<select
										id="inputState"
										class="
											form-control form-control-sm
											text-center
										"
										v-model="item.unit"
										:key="k"
										@change="toTin(k)"
									>
										<option
											v-for="option in unit_options"
											v-bind:value="option.value"
											:key="option.value"
										>
											{{ option.text }}
										</option>
									</select>
								</td>
								<td>
									<input
										v-model="item.qty"
										type="number"
										class="
											form-control form-control-sm
											text-center
										"
										min="0"
										@change="calculateTotal(item), toTin(k)"
										@keypress="validateNumber"
										:class="{
											'is-invalid': form.errors.has(
												`items.${k}.tins`
											),
										}"
										:name="`items.${k}.tins`"
									/>

									<has-error
										class="text-sm"
										:form="form"
										:field="`items.${k}.tins`"
									/>
								</td>
								<td
									class="align-middle text-center text-danger"
								>
									<i
										class="
											fas
											fa-trash-alt
											btn btn-danger btn-sm
										"
										@click="deleteRow(k, item)"
									></i>
								</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="3" class="text-right">Total</td>
								<td class="text-center">{{ items_total }}</td>
								<td></td>
							</tr>
						</tfoot>
					</table>

					<div class="d-flex justify-content-between">
						<button class="btn btn-success" @click="addNewLine">
							Add
						</button>

						<button
							class="btn btn-primary"
							@click="handleSubmitDelivery"
						>
							Submit
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
import Form from "vform";

export default {
	middleware: "auth",
	name: "inv-delivery",
	metaInfo() {
		return { title: "Delivery Transaction" };
	},
	data: () => ({
		form: new Form({
			trndate: "",
			trnmode: "DELIVERY",
			customer: "",
			userid: "",
			rono: "",
			refno: "",
			remarks: "",
			items: [
				{
					qty: 0,
					trntype: "OD",
					itemcode: null,
					expdate: null,
					unit: "CASE",
					bal: 0,
					tins: 0,
					numperuompu: 0,
				},
			],
		}),
		btn: false,
		allerrors: [],
		success: false,
		items_total: "0",
		unit_options: [
			{
				text: "Case",
				value: "CASE",
			},
			{
				text: "Tins",
				value: "TIN",
			},
		],
	}),

	created() {
		this.isLoggedCheck;
	},
	mounted() {
		this.canAuth("items-delivery");
		this.form.userid = this.isUser.id;
		this.form.trndate = this.datenow;

		this.fetchItemsOut();
	},
	methods: {
		itemSelected(item) {
			this.form.items[item.id].itemcode = item.itemcode;
			this.form.items[item.id].expdate = item.expdate;
			this.form.items[item.id].bal = item.qty;
			this.form.items[item.id].numperuompu = item.numperuompu;
			this.toTin(item.id);
			console.log(this.form.items);
			this.calculateTotal();
		},
		customerSelected(customer) {
			// this.form.custid = customer.cid;
		},
		async handleSubmitDelivery() {
			const { value: result } = await Swal.fire({
				title: "Are you sure?",
				text: "You won't be able to revert this!",
				icon: "info",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, processed!",
			});
			if (result) {
				const res = await this.form.post("/api/items/dlvry-trans");
				console.log(res);
				this.$router.push({
					name: "report-dlvry",
					params: { id: res.data.id },
				});
				this.resetForm();
			}
		},
		addNewLine() {
			this.form.items.push({
				qty: 0,
				bal: 0,
				tins: 0,
				numperuompu: 0,
				trntype: "OD",
				itemcode: null,
				expdate: null,
				unit: "CASE",
			});
			this.checkBtn();
		},
		deleteRow(index, item) {
			var idx = this.form.items.indexOf(item);
			if (idx > -1) {
				this.form.items.splice(idx, 1);
			}
			this.checkBtn();
		},
		resetForm() {
			this.$children[0].selectItem = [];
			var self = this; //you need this because *this* will refer to Object.keys below`
			this.keywords = null;
			this.seen = true;
			//Iterate through each object field, key is name of the object field`
			Object.keys(this.form).forEach(function (key, index) {
				self.form[key] = "";
			});
			this.form.items = [];
			this.items_total = 0;
			this.data_customers = [];
			this.$children[0].selectedItem = null;
			this.form.userid = this.isUser.id;
		},
		calculateTotal() {
			var subtotal;
			console.log(this.form.items);
			subtotal = this.form.items.reduce(function (sum, item) {
				var lineTotal = parseFloat(item.qty);
				if (!isNaN(lineTotal)) {
					return sum + lineTotal;
				}
				return sum;
			}, 0);
			this.items_total = subtotal;
			this.checkBtn();
		},

		toTin(k) {
			if (this.form.items[k].unit == "CASE") {
				this.form.items[k].tins =
					this.form.items[k].qty * this.form.items[k].numperuompu;
			} else {
				this.form.items[k].tins = this.form.items[k].qty;
			}

			// console.log(this.form.items[k].tins);
		},

		checkBtn() {
			const even = (element) =>
				element.qty === 0 || element.itemdesc === null;
			this.btn = this.form.items.some(even);
		},
	},
};
</script>

<style>
</style>