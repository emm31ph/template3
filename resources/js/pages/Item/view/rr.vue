<template>
	<div class="card shadow mb-4">
		<div class="card-header py-3 d-flex justify-content-between">
			<h6 class="m-0 font-weight-bold text-primary">
				Recieving Report Transaction
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
							>Customer :</label
						>
						<div class="col-sm-9">
							<input
								v-model="form.customer"
								type="text"
								class="form-control form-control-sm"
								:class="{
									'is-invalid': form.errors.has('customer'),
								}"
								name="customer"
							/>
							<has-error :form="form" field="customer" />
						</div>
					</div>
					<div class="col-md-6 form-group row">
						<label
							for="inputCustomer"
							class="
								col-sm-4 col-form-label col-form-label-sm
								text-md-right
							"
							>Date :</label
						>
						<div class="col-sm-8">
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
								col-sm-3 col-form-label col-form-label-sm
								text-md-right
							"
							>Van No. :</label
						>
						<div class="col-sm-9">
							<input
								v-model="form.van_no"
								type="text"
								class="form-control form-control-sm"
								:class="{
									'is-invalid': form.errors.has('van_no'),
								}"
								name="van_no"
							/>
							<has-error :form="form" field="van_no" />
						</div>
					</div>
					<div class="col-md-6 form-group row">
						<label
							for="inputCustomer"
							class="
								col-sm-4 col-form-label col-form-label-sm
								text-md-right
							"
							>PO No :</label
						>
						<div class="col-sm-8">
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
								col-sm-3 col-form-label col-form-label-sm
								text-md-right
							"
							>Seal No. :</label
						>
						<div class="col-sm-9">
							<input
								v-model="form.seal_no"
								type="text"
								class="form-control form-control-sm"
								:class="{
									'is-invalid': form.errors.has('seal_no'),
								}"
								name="seal_no"
							/>
							<has-error :form="form" field="seal_no" />
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
							<textarea
								v-model="form.remarks"
								rows="3"
								class="form-control form-control-sm"
								:class="{
									'is-invalid': form.errors.has('remarks'),
								}"
								name="remarks"
							/>
							<has-error :form="form" field="remarks" />
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
										:items="getAllItems"
										:index="`${k}`"
										filterby="itemdesc"
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
										v-model="item.expdate"
										type="date"
										:maxlength="max"
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
										@change="calculateTotal(item)"
										@keypress="validateNumber"
										:class="{
											'is-invalid': form.errors.has(
												`items.${k}.qty`
											),
										}"
										:name="`items.${k}.qty`"
									/>
									<has-error
										:form="form"
										:field="`items.${k}.qty`"
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
								<td class="text-center">
									{{ items_total }}
								</td>

								<td></td>
							</tr>
						</tfoot>
					</table>
					<has-error :form="form" field="crqty_total" />
					<div class="d-flex justify-content-between">
						<button class="btn btn-success" @click="addNewLine">
							Add
						</button>

						<button class="btn btn-primary" @click="handleSubmit">
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
		return { title: "Recieving Report Transaction" };
	},
	data: () => ({
		max: 10,
		form: new Form({
			userid: "",
			trndate: "",
			trnmode: "RR",
			customer: "",
			van_no: "",
			seal_no: "",
			refno: "",
			remarks: "",
			items: [
				{
					qty: 0,
					trntype: "RR",
					itemcode: null,
					expdate: null,
					unit: "CASE",
				},
			],
		}),
		btn: false,
		success: false,
		items_total: 0,
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
		this.canAuth("items-rr");
		this.form.userid = this.isUser.id;
		this.form.trndate = this.datenow;
		this.fetchAllItems();
	},
	methods: {
		itemSelected(item) {
			this.form.items[item.id].itemcode = item.itemcode;
			this.calculateTotal();
		},

		async handleSubmit() {
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
				// const res = await this.form.post("/api/items/rr-trans");
				await this.form.post("/api/items/rr-trans").then((res) => {
					this.$router.push({
						name: "report-rr",
						params: { id: res.data.id },
					});
					this.resetForm();
				}).catch(error => {
					console.log(error)
				});
			}
		},
		addNewLine() {
			this.form.items.push({
				qty: 0,
				trntype: "RR",
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
			var subtotaldr;
			subtotaldr = this.form.items.reduce(function (sum, item) {
				var lineTotal = parseFloat(item.qty);
				if (!isNaN(lineTotal)) {
					return sum + lineTotal;
				}
				return sum;
			}, 0);
			this.items_total = subtotaldr;
			this.checkBtn();
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