<template>
	<div>
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">
					Customer Prices
				</h6>
				<ul class="navbar-nav float-right">
					<li class="nav-item dropdown">
						<a
							id="my-dropdown"
							data-toggle="dropdown"
							aria-haspopup="true"
							aria-expanded="false"
							class="nav-link"
						>
							<i class="fas fa-cogs"></i>
						</a>
						<div
							aria-labelledby="my-dropdown"
							class="dropdown-menu dropdown-menu-right"
							style=""
						>
							<!-- <a 	class="dropdown-item" v-if="can('price-cat-create')" @click="openModalGenerateWindow">
									New  Customer Prices
								</a> -->

							<a
								class="dropdown-item"
								v-if="!can('price-cust-copy')"
								@click="openModalGenerateWindow"
							>
								Re-Gerate Customer Price from EBT
							</a>
						</div>
					</li>
				</ul>
			</div>
			<div class="card-body">
				<div class="card-body mt-0 mb-0 pb-0 pt-0">
					<div class="form-group form-group-sm row">
						<label for="inputEmail3" class="col-sm-1 col-form-label"
							>Customer</label
						>
						<div class="col-sm-5">
							<typeahead
								v-model="pricecust"
								:items="getCustomer"
								filterby="custname"
								title="Customer Name"
								@selected="itemSelected"
								class="form-control form-control-sm"
								:class="{
									'is-invalid': form.errors.has(`pricecust`),
								}"
								:name="`pricecust`"
								ref="customer"
							/>
							<has-error :form="form" :field="`pricecust`" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-4 ">
						<label for="staticItemdesc" class="sr-only">Item Description</label>
						<typeahead
							v-model="itemcode"
							:items="getAllItems"
							:index="`1`"
							:datavalue="itemdesc"
							filterby="itemdesc" 
							title="Itemdesc"
							@selected="itemSelectedProduct"
							class="form-control form-control-sm" 
							:name="`itemcode`"
							ref="itemproduct"
							:disable="itemDisable"
							
						/> 
					</div>
					<div class="form-group col-1 ">
						<label for="inputUnitprice" class="sr-only">Unit Price</label>
						<currency-input :disable="itemEnable" @input="addEvent" @change="addEvent"   v-model="unitprice" :classes="`form-control form-control-sm text-right`" />
					</div> 
					<div class="form-group col-1 ">
						<label for="inputUnitprice" class="sr-only">Disc (%)</label>
						<currency-input :disable="itemEnable" @input="addEvent" @change="addEvent"  v-model="discount" :classes="`form-control form-control-sm text-right`"/>
					</div> 
					<div class="form-group col-1 ">
						<label for="inputUnitprice" class="sr-only">Disc (%)</label>
						<currency-input :disable="itemEnable" @input="addEvent" @change="addEvent"   v-model="discount2" :classes="`form-control form-control-sm text-right`"/>
					</div> 
					<div class="form-group col-1 ">
						<label for="inputUnitprice" class="sr-only">Disc (%)</label>
						<currency-input :disable="itemEnable" @input="addEvent" @change="addEvent"   v-model="discount3" :classes="`form-control form-control-sm text-right`"/>
					</div> 
					<div class="form-group col-1 ">
						<label for="inputUnitprice" class="sr-only">Disc (%)</label>
						<currency-input :disable="itemEnable" @input="addEvent" @change="addEvent"   v-model="discount4" :classes="`form-control form-control-sm text-right`"/>
					</div> 
					<div class="form-group col-1 ">
						<label for="inputUnitprice" class="sr-only">Disc (%)</label>
						<currency-input :disable="itemEnable" @input="addEvent" @change="addEvent"   v-model="discount5" :classes="`form-control form-control-sm text-right`"/>
					</div> 
					<div class="form-group col-1 ">
						<label for="inputUnitprice" class="sr-only">Price</label>
						<currency-input :disable="true" v-model="price" :classes="`form-control form-control-sm text-right`"/>
					</div> 
					
					<div class="form-group col-1 ">
						<button class="btn btn-sm btn-outline-success" :disabled="(price=='0')?true:false"   type="button"
                                        @click="addNewRow">Add </button>
					</div>
				 
				</div>
				<div class="tableFixHead">
					<table class="table table-sm table-hover">
						<thead class="thead-dark">
							<tr>
								<th style="width:100px">Item Code</th>
								<th>Item Description</th>
								<th class="text-right">Unit Price</th>
								<th class="text-right">DISC(%)</th>
								<th class="text-right">DISC(%)</th>
								<th class="text-right">DISC(%)</th>
								<th class="text-right">DISC(%)</th>
								<th class="text-right">DISC(%)</th>
								<th class="text-right">Price</th>
								<th class="text-right">Action</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(product, i) in form.items" :key="i">
								<td class="text-capitalize">
									{{ product.itemcode }}
									<input
										type="hidden"
										v-model="product.itemcode"
									/>
										<input
										type="hidden"
										v-model="product.custno"
									/>
								</td>
								<td class="text-capitalize">
									{{ product.itemdesc }}
								</td>
								<td class="text-right">
									<input
										type="hidden"
										v-model="product.unitprice" 
									/>
									
									{{ product.unitprice }} 
								</td>
								<td class="text-right">
									<input
										type="hidden"
										v-model="product.discount"  
									/>
									{{ product.discount }} 
								</td>
								<td class="text-right">
									<input
										type="hidden"
										v-model="product.discount2" 
									/>
									{{ product.discount2 }} 
								</td>
								<td class="text-right">
									<input
										type="hidden"
										v-model="product.discount3" 
									/>
									{{ product.discount3 }} 
								</td>
								<td class="text-right">
									<input
										type="hidden"
										v-model="product.discount4" 
									/>
									{{ product.discount4 }} 
								</td>
								<td class="text-right">
									<input
										type="hidden"
										v-model="product.discount5" 
									/>
									{{ product.discount5 }} 
								</td>
								<td class="text-right">
									<input
										type="hidden"
										v-model="product.price" 
									/>
									{{ product.price }} 
								</td>
								<td class="text-center">
									<div> 
										<a
											href="#"
											@click="deleteRow(i, product)"
											v-if="can('users-delete')"
										>
											<i
												class="fa fa-trash text-danger"
											></i>
										</a>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<button
					class="btn btn-sm btn-primary"
					:disabled="!form.items.length"
					@click="handleSave"
				>
					Update
				</button>
			</div>
		</div>
	</div>
</template>

<script>
import Form from "vform";
import bus from "../../../EventBus";
import Button from "../../../components/Button.vue";
export default {
	name: "CustomerPrice", 
	Buttonmiddleware: "auth",
	data() {
		return {
			pagename: "Customer Price", 
			pricecust: [], 
			itemcode:'',
			itemdesc:'', 
			price:0,
			discount:0,
			discount2:0,
			discount3:0,
			discount4:0,
			discount5:0,
			unitprice:0,
			custno:'', 
			itemEnable:true,
			itemDisable:true,
			form: new Form({
				items: [],
				trntype: "pricecust",
				trnmode: "custlistdetailsUpdate",
			}),
			query: "",
		};
	},

	created() {
		this.isLoggedCheck; 
		this.fetchCustomer();
		this.fetchAllItems(); 
	},
	metaInfo() {
		return { title: "Customer Price" };
	},
	methods: { 
		addEvent (event) {

			let val = 0;  
		 	val = val + (this.unitprice*(this.discount)); 
		 	val = val + (this.unitprice*(this.discount2)); 
		 	val = val + (this.unitprice*(this.discount3)); 
		 	val = val + (this.unitprice*(this.discount4)); 
		 	val = val + (this.unitprice*(this.discount5)); 

		 this.price = this.unitprice - val
		   
		   //this.itemEnable = (this.itemcode!='')?(val==0)?true:false:false;
		},
		addNewRow() {

			this.form.items.push({
				custno: this.custno,
				branch: this.isUser.branch,
				itemcode: this.itemcode,
				itemdesc: this.itemdesc,
				price: 	this.formatNumberDis(this.price),
				discount: this.formatNumberDis(this.discount),
				discount2: this.formatNumberDis(this.discount2),
				discount3: this.formatNumberDis(this.discount3),
				discount4: this.formatNumberDis(this.discount4),
				discount5: this.formatNumberDis(this.discount5),
				unitprice: this.formatNumberDis(this.unitprice),
				// discount: (res.data.result[index].discount),
			});
		// console.log(this.$refs.itemproduct.selectedItem);
		  this.$refs.itemproduct.selectedItem = '';
		  this.itemdesc ='';
		  this.itemcode ='';
		  this.discount =0;
		  this.discount2 =0;
		  this.discount3 =0;
		  this.discount4 =0;
		  this.discount5 =0;
		  this.price =0;
		  this.unitprice =0;
		},
		deleteRow(index, product) {
                    var idx = this.form.items.indexOf(product);
                    
                    if (idx > -1) {
                        this.form.items.splice(idx, 1);
                    }

                },
		handleSave() { 
			Swal.fire({
				title: "Checking...",
				text: "Please wait",
				showConfirmButton: false,
				allowOutsideClick: false,
				willOpen: () => {
					Swal.showLoading();
				},
			});
			this.form.post("/api/settings/price").then((res) => {
				 console.log(res.data);
				Swal.fire({
					position: "top-end",
					icon: "success",
					toast: true,
					title: "successful process",
					showConfirmButton: false,
					timer: 2500,
				});
				this.$refs.customer.selectedItem = '';
				this.$refs.itemproduct.selectedItem = '';
				this.pricecust = "";
				this.form.reset();
			});
			Swal.close();
		},
		openModalGenerateWindow() {
			Swal.fire({
				title: "Are you sure?",
				text: "The data will be Overwrite!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, Confirm!",
			}).then((result) => {
				if (result.isConfirmed) {
					Swal.fire({
						title: "Checking...",
						text: "Please wait",
						showConfirmButton: false,
						allowOutsideClick: false,
						willOpen: () => {
							Swal.showLoading();
						},
					});

					axios
						.post("/api/settings/price", {
							trntype: "generate-cust-price",
						})
						.then((res) => {
							Swal.fire({
								position: "top-end",
								icon: "success",
								toast: true,
								title: "successful process",
								showConfirmButton: false,
								timer: 2500,
							});
							this.fetchCustomer();
							this.$refs.customer.selectedItem = '';
							this.$refs.itemproduct.selectedItem = '';
							this.pricecust = "";
							this.form.reset();
						});
				}
			});
			// Swal.close();
		},
		itemSelectedProduct(item){

			this.itemdesc = item.itemdesc;
			this.itemcode = item.itemcode;  
			this.itemEnable = false;

			
		},
		itemSelected(item) {
			this.form.reset();
			axios
				.get("/api/settings/price", {
					params: {
						trntype: "pricecust",
						trnmode: "custlistdetails",
						custno: item.custno,
					},
				})
				.then((res) => {
					this.custno = item.custno;
					this.itemDisable = false;
					// this.form.custno = res.data.result[0].custno
					for (
						let index = 0;
						index < res.data.result.length;
						index++
					) {
						this.form.items.push({
							custno: item.custno,
							branch: res.data.result[index].branch,
							itemcode: res.data.result[index].itemcode,
							itemdesc: res.data.result[index].items[0].itemdesc,
							price: this.formatNumberDis(
								res.data.result[index].price / 100
							),
							discount: this.formatNumberDis(
								res.data.result[index].discount / 100
							),
							discount2: this.formatNumberDis(
								res.data.result[index].discount2 / 100
							),
							discount3: this.formatNumberDis(
								res.data.result[index].discount3 / 100
							),
							discount4: this.formatNumberDis(
								res.data.result[index].discount4 / 100
							),
							discount5: this.formatNumberDis(
								res.data.result[index].discount5 / 100
							),
							unitprice: this.formatNumberDis(
								res.data.result[index].unitprice / 100
							),
							// discount: (res.data.result[index].discount),
						});

						
					}
 
				});
		},

		stripTheGarbage(e) {
		 
			if ((e.keyCode < 48 && e.keyCode !== 46) || e.keyCode > 59) {
				e.preventDefault();
			} 
		},
		formatDollars() {
			if (this.unitprice!= "") {
				var num = this.unitprice.replace(",", "");
				num = isNaN(num) ? 0 : num;
				num = Number(num);

				var countDecimals = function (value) {
					if (Math.floor(value) === value) return 0;
					return value.toString().split(".")[1].length || 0;
				};

				var decimal = countDecimals(num);

				if (decimal < 2) {
					num = num.toFixed(2);
				}

				if (decimal > 2) {
					num = num.toFixed(decimal);
				}

				if (parseInt(num) < 1) {
					num = "0." + String(num).split(".")[1];
				}

				this.unitprice = this.formatNumberDis(num);
			}
		},
		calculateLineTotal(val) {
			console.log(val);
			 

		}
	},
	mounted() {
		this.isAbleToAuth(["price-cust-*"]);
		// this.$refs.itemproduct.selectedItem = {id: "1",
		// 	index: "1",
		// 	itemclass: "001",
		// 	itemcode: "FPARSNO0001010",
		// 	itemdesc: "ARBELLA SPAGHETTI NOODLES 10/1Kg",
		// 	numperuompu: "10",
		// 	pckgsize: "10/1Kg",
		// 	shortcode: "",
		// 	status: "0",
		// 	u_stockcode: "",
		// 	uompu: "CASE"
		// 	}
		this.currentPage = 1;
		bus.$on("send", (data) => {
			this.query = data;
		});
	},

	computed: {},
};
</script> 

<style>
.tableFixHead {
	overflow-y: scroll;
	max-height: 550px;
	width: auto;
	display: flex;
	flex-direction: column-reverse;
	border: 1px solid black;
	margin-bottom: 3px;
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