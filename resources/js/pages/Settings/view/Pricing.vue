<template>
	<div>
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">
					Price List
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
								<a 	class="dropdown-item" v-if="can('price-cat-create')" @click="openModalGenerateWindow">
									New Price Category
								</a>
								 
								 	<a 	class="dropdown-item" v-if="!can('price-cat-copy')" @click="openModalGenerateWindow">
									Re-Gerate Price Item List from EBT
								</a>
							</div>
							
							 
						</li>
						
					</ul> 
			</div>
			<div class="card-body">
				<div class="card-body mt-0 mb-0 pb-0 pt-0">
                  	<div class="form-group form-group-sm row">
                    	<label for="inputEmail3" class="col-sm-1 col-form-label">Price Category</label>
						<div class="col-sm-5"> 
							<typeahead
										v-model="pricecat"
										:items="getPriceCat" 
										filterby="fulltitle"  
										title="Itemdesc"
										@selected="itemSelected"
										class="form-control form-control-sm"
										:class="{
											'is-invalid': form.errors.has(
												`pricecat`
											),
										}"
										:name="`pricecat`"
										ref='pricecatlist'
									/>
									<has-error
										:form="form"
										:field="`pricecat`"
									/>
						</div>
                    </div>  
                </div>
				<div class="tableFixHead">
					<table class="table table-sm table-hover">
						<thead class="thead-dark">
							<tr>
								<th >
									Item Code
								</th>
								<th>
									Item Description
								</th>
								<th class="text-right">
									Price
								</th> 
								 
							</tr>
						</thead>
						<tbody>
							<tr
								v-for="(product,i) in form.items"
								:key="i"
								>
								<td class="text-capitalize">
									{{ product.itemcode2 }}
									<input type="hidden" v-model="product.itemcode">
									 
								</td>
								<td class="text-capitalize">
									{{ product.itemdesc }}
								</td>
								<td class="text-capitalize "> 
										<input type="text" v-model="product.price" @focus="$event.target.select()" @keypress="stripTheGarbage($event,i)" @blur="formatDollars(i)"  class="form-control form-control-sm text-right"  >
								</td> 
							</tr>
						</tbody>
						 
					</table>
					 
				</div>
				<button class="btn btn-sm btn-primary" :disabled="!form.items.length" @click="handleSave">Save</button>
			</div>
		</div>

	 
	</div>
</template>

<script>
import Form from "vform";
import bus from "../../../EventBus";
import Button from '../../../components/Button.vue';
export default {
	name: "PriceList",
	
Buttonmiddleware: "auth",
	data() {
		return { 
			pagename: "Price List", 
			data:[], 
			pricecat:[],
			oldval:0,
			form: new Form({
				priceID:'',
				items:[],
				trntype: "pricecat",
				trnmode: "catlistdetailsUpdate",
			}),
			query: "",
			 
		};
	},

	created() {
		this.isLoggedCheck;
		this.fetchPriceCategory(); 
	},
	metaInfo() {
		return { title: "Price List" };
	},
	methods: {
		handleSave(){
			Swal.fire({
					title: "Checking...",
					text: "Please wait",
					showConfirmButton: false,
					allowOutsideClick: false,
					willOpen: () => {
						Swal.showLoading();
					},
				});
			this.form.post('/api/settings/price')
			.then(res =>{
				 Swal.fire({
					position: 'top-end',
					icon: 'success',
					toast:true,
					title: 'successful process',
					showConfirmButton: false,
					timer: 2500
				})
				this.$refs.pricecatlist.selectedItem = ''; 
				this.form.reset(); 
			}); 
			 Swal.close();
		},
		openModalGenerateWindow(){
			Swal.fire({
				title: 'Are you sure?',
				text: "The data will be Overwrite!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, Confirm!'
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

				axios.post('/api/settings/price', {
					trntype: 'generate-price-list', 
					}).then(res =>{
						 Swal.fire({
							position: 'top-end',
							icon: 'success',
							toast:true,
							title: 'successful process',
							showConfirmButton: false,
							timer: 2500
						}) 
						
				this.$refs.pricecatlist.selectedItem = ''; 
							this.fetchPriceCategory(); 
						}) 
					}
				})
					// Swal.close();
		}, 
		 
		itemSelected(item) {
			this.form.reset();
			axios.get('/api/settings/price', {
                params: {
					trntype: 'pricecat',
                    trnmode: 'catlistdetails',
					pricelist: item.pricelist 
                }
            }).then(res => {
			
			this.form.priceID = item.pricelist 
			for (let index = 0; index < res.data.result.length; index++) {
				 
				this.form.items.push({
						itemcode2:res.data.result[index].itemcode2,
						itemdesc:res.data.result[index].itemdesc,
						price: this.formatNumberDis(res.data.result[index].price),
						discount: (res.data.result[index].discount),
					})
			}
			

			}) 
		},

	stripTheGarbage(e,i) { 
		let val = this.form.items[i].price 
		if(val=='0.00'){
			this.form.items[i].price = e.key;
		} 
		if (e.keyCode < 48 && e.keyCode !== 46 || e.keyCode > 59) {
			e.preventDefault()
		}
			// restrict to 2 decimal places
		if(val!=null && val.indexOf(".")>-1 && (val.split('.')[1].length > 1)){
		e.preventDefault()
		}
    },
    formatDollars(i) {
		 
      if (this.form.items[i].price != '') {
        var num =(this.form.items[i].price).replace(',',''); 
          num = isNaN(num) ? 0: num
        num = Number(num);
		 
        var countDecimals = function (value) {
          if(Math.floor(value) === value) return 0;
          return value.toString().split(".")[1].length || 0; 
        }
        
        var decimal = countDecimals(num);
        
        if (decimal < 2) {
          num = num.toFixed(2)
        }
         
        if (decimal > 2) {
          num = num.toFixed(decimal)
        }
         
        if (parseInt(num) < 1) {
          num = "0." + String(num).split(".")[1];
        } 

        this.form.items[i].price = this.formatNumberDis(num);
      }
    }

	}, 
	mounted() {
		this.isAbleToAuth(["price-list-*"]); 
		this.currentPage = 1;
		bus.$on("send", (data) => {
			this.query = data;
		});
	},

	computed: {  
		 
	},
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