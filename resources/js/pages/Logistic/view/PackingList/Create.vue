<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    New Packing List
                </h6>
            </div>
            <div class="card-body ">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a
                            @click.prevent="goToStep(1)"
                            class="nav-link"
                            :class="{ active: current_step == 1 }"
                            href="#"
                            >Information</a
                        >
                    </li>
                    <li class="nav-item" role="presentation">
                        <a
                            @click.prevent="goToStep(2)"
                            class="nav-link"
                            :class="{
                                disabled: max_step < 2,
                                active: current_step == 2
                            }"
                            href="#"
                            >Tracking</a
                        >
                    </li>
                    <li class="nav-item" role="presentation">
                        <a
                            @click.prevent="goToStep(3)"
                            class="nav-link"
                            :class="{
                                disabled: max_step < 3,
                                active: current_step == 3
                            }"
                            href="#"
                            >Detials</a
                        >
                    </li>
                </ul>
                <div>
                    <div class="tab-pane" v-show="current_step == 1">
                        <div class="row mt-2">
                            <div class="col-6">
                                <div class="form-group form-group-sm mb-0 row">
                                    <label
                                        for="inputPackingList"
                                        class="col-sm-2 col-form-label text-right"
                                        >Packing List:</label
                                    >
                                    <div class="col-sm-10">
                                        <input   
                                            v-model="form.packlist"
                                            type="text"
                                            class="form-control form-control-sm"
                                            id="inputPackingList"
                                            placeholder="Packing List"
                                        />
                                    </div>
                                </div>
                                <div class="form-group form-group-sm mb-0 row">
                                    <label
                                        for="inputContactPerson"
                                        class="col-sm-2 col-form-label text-right"
                                        >Contact Person:</label
                                    >
                                    <div class="col-sm-10">
                                        <input 
                                            v-model="form.contactPerson"
                                            type="text"
                                            class="form-control form-control-sm "
                                            :class="contactPersonIsValid==false?'is-invalid':''"
                                            id="inputContactPerson"
                                            placeholder="Contact Person"
                                            
                                        />
                                    </div>
                                </div>

                                <div class="form-group form-group-sm mb-0 row">
                                    <label
                                        for="inputConsignee"
                                        class="col-sm-2 col-form-label text-right"
                                        >Consignee:</label
                                    >
                                    <div class="col-sm-10">
                                        <input 
                                            v-model="form.consignee"
                                            type="text"
                                            class="form-control form-control-sm  "
                                            :class="consigneeIsValid==false?'is-invalid':''"
                                            id="inputConsignee"
                                            placeholder="Consignee"
                                        />
                                    </div>
                                </div>
                                <div class="form-group form-group-sm mb-0 row">
                                    <label
                                        for="inputAddress"
                                        class="col-sm-2 col-form-label text-right"
                                        >Address:</label
                                    >
                                    <div class="col-sm-10">
                                        <textarea
                                            v-model="form.address"
                                            class="form-control form-control-sm  "
                                            :class="addressIsValid==false?'is-invalid':''"
                                            placeholder="Address"
                                            id="exampleFormControlTextarea1"
                                            rows="3"
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group form-group-sm mb-0 row">
                                    <label
                                        for="inputDate"
                                        class="col-sm-2 col-form-label text-right"
                                        >Date:</label
                                    >
                                    <div class="col-sm-4">
                                        <input
                                            v-model="form.trndate"
                                            type="date"
                                            class="form-control form-control-sm"
                                            id="inputDate"
                                            placeholder="Date"
                                        />
                                    </div>

                                    <label
                                        for="inputSANo"
                                        class="col-sm-2 col-form-label text-right"
                                        >SA No:</label
                                    >
                                    <div class="col-sm-4">
                                        <input
                                            v-model="form.sa_no"
                                            type="text"
                                            class="form-control form-control-sm"
                                            id="inputSANo"
                                            placeholder="SA No."
                                        />
                                    </div>
                                </div>

                                <div class="form-group form-group-sm mb-0 row">
                                    <label
                                        for="inputDR"
                                        class="col-sm-2 col-form-label text-right"
                                        >DR:</label
                                    >
                                    <div class="col-sm-4">
                                        <input
                                            v-model="form.dr_no"
                                            type="text"
                                            class="form-control form-control-sm"
                                            id="inputDR"
                                            placeholder="DR"
                                        />
                                    </div>
                                    <label
                                        for="inputPO"
                                        class="col-sm-2 col-form-label text-right"
                                        >PO:</label
                                    >
                                    <div class="col-sm-4">
                                        <input
                                            v-model="form.po_no"
                                            type="text"
                                            class="form-control form-control-sm"
                                            id="inputPO"
                                            placeholder="PO"
                                        />
                                    </div>
                                </div>
                                <div class="form-group form-group-sm mb-0 row">
                                    <label
                                        for="inputSONo"
                                        class="col-sm-2 col-form-label text-right"
                                        >SO No.:</label
                                    >
                                    <div class="col-sm-4">
                                        <input
                                            v-model="form.so_no"
                                            type="text"
                                            class="form-control form-control-sm "
                                            :class="so_noIsValid==false?'is-invalid':''"
                                            id="inputSONo"
                                            placeholder="SO No."
                                        />
                                    </div>
                                    <label
                                        for="inputShipping"
                                        class="col-sm-2 col-form-label text-right"
                                        >Shipping Date:</label
                                    >
                                    <div class="col-sm-4">
                                        <input
                                            v-model="form.shippingDate"
                                            type="date"
                                            class="form-control form-control-sm"
                                            id="inputShipping"
                                            placeholder="Shipping/ Pick up date"
                                        />
                                    </div>
                                </div>
                                <div class="form-group form-group-sm mb-0 row">
                                    <label
                                        for="inputStockRequest"
                                        class="col-sm-2 col-form-label text-right"
                                        >Stock Request:</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            v-model="form.shippingRequest"
                                            type="text"
                                            class="form-control form-control-sm"
                                            id="inputStockRequest"
                                            placeholder="Stock Request"
                                        />
                                    </div>
                                </div>
                                <div class="form-group form-group-sm mb-0 row">
                                    <label
                                        for="inputShippingLine"
                                        class="col-sm-2 col-form-label text-right"
                                        >Shipping Line:</label
                                    >
                                    <div class="col-sm-4">
                                        <input
                                            v-model="form.shippingLine"
                                            type="text"
                                            class="form-control form-control-sm"
                                            id="inputShippingLine"
                                            placeholder="Shipping Line"
                                        />
                                    </div>
                                    <label
                                        for="inputShippingMethod"
                                        class="col-sm-2 col-form-label text-right"
                                    >
                                        <small>Shipping Method:</small>
                                    </label>
                                    <div class="col-sm-4">
                                        <input
                                            v-model="form.shippingMethod"
                                            type="text"
                                            class="form-control form-control-sm"
                                            id="inputShippingMethod"
                                            placeholder="Shipping Method"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" v-show="current_step == 2">
                        <div class="row mt-2">
                            <div class="col-6">
                                <div class="form-group form-group-sm mb-0 row">
                                    <label
                                        for="inputControlNo"
                                        class="col-sm-2 col-form-label text-right"
                                        >Control No:</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            v-model="form.control_no"
                                            type="text"
                                            class="form-control form-control-sm"
                                            id="inputControlNo"
                                            placeholder="Control No"
                                        />
                                    </div>
                                </div>
                                <div class="form-group form-group-sm mb-0 row">
                                    <label
                                        for="inputSealNo"
                                        class="col-sm-2 col-form-label text-right"
                                        >Seal No:</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            v-model="form.seal_no"
                                            type="text"
                                            class="form-control form-control-sm"
                                            id="inputSealNo"
                                            placeholder="Seal No"
                                        />
                                    </div>
                                </div>
                                <div class="form-group form-group-sm mb-0 row">
                                    <label
                                        for="inputTrurkingNo"
                                        class="col-sm-2 col-form-label text-right"
                                        >Trucking #:</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            v-model="form.trucking"
                                            type="text"
                                            class="form-control form-control-sm"
                                            id="inputTrurkingNo"
                                            placeholder="Trurking #"
                                        />
                                    </div>
                                </div>
                                <div class="form-group form-group-sm mb-0 row">
                                    <label
                                        for="inputPickUpAt"
                                        class="col-sm-2 col-form-label text-right"
                                        >Pick Up At:</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            v-model="form.pickup"
                                            type="text"
                                            class="form-control form-control-sm "
                                            :class="pickupIsValid==false?'is-invalid':''"
                                            id="inputPickUpAt"
                                            placeholder="Pick Up At"
                                        />
                                    </div>
                                </div>
                                <div class="form-group form-group-sm mb-0 row">
                                    <label
                                        for="inputGrossWT"
                                        class="col-sm-2 col-form-label text-right"
                                        >Gross wt:</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            v-model="form.grosswt"
                                            type="text"
                                            class="form-control form-control-sm"
                                            id="inputGrossWT"
                                            placeholder="Gross wt"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group form-group-sm mb-0 row">
                                    <label
                                        for="inputRemarks"
                                        class="col-sm-2 col-form-label text-right"
                                        >Remarks:</label
                                    >
                                    <div class="col-sm-10">
                                        <textarea
                                        v-model="form.remarks"
                                            class="form-control"
                                            placeholder="Remarks"
                                            id="exampleFormControlTextarea1"
                                            rows="4"
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" v-show="current_step == 3">
                        <div class="form-group mb-0">
                            <fieldset class="legend-border col">
                                <legend class="w-auto legend-border">
                                    Items Order
                                </legend>
                                <div class="row col-12">
                                    <div class="col-5">
                                        <typeahead
                                            v-model="itemcode"
                                            :items="getAllItems"
                                            :index="`1`"
                                            filterby="itemdesc"
                                            @change="onChangeItems"
                                            title="Product Description"
                                            
							                ref="itemproduct"
                                            @selected="itemSelectedItem"
                                            class="form-control form-control-sm"
                                            :name="`itemcode`" 
                                        />
                                    </div>
                                    <div class="col-1">
                                        <input
                                            v-model="qty"
                                            @change="getTotal"
                                            class="form-control form-control-sm text-right"
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
                                            v-model="unit"
                                            :disabled="activeField"
                                        >
                                            <option value="" disabled selected
                                                >Unit</option
                                            >
                                            <option
                                                v-for="option in getLookup(
                                                    'UOM1'
                                                )"
                                                v-bind:value="option.code"
                                                :key="option.code"
                                            >
                                                {{ option.fulltitle }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-2">
                                        <input
                                            @change="getTotal"
                                            v-model="price"
                                            class="form-control form-control-sm  text-right"
                                            placeholder="Unit Price" 
                                            :disabled="activeField"
                                        />
                                    </div>

                                    <div class="col-2">
                                        <input
                                            v-model="total"
                                            
                                            class="form-control form-control-sm text-right"
                                            placeholder="Total"
                                            disabled
                                        />
                                    </div>

                                    <div class="col-1">
                                        <button
                                            @click="handleAdd"
                                            :disabled="
                                                (total==''?true:(total!=='0.00'?false:true))
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
                            <fieldset class="legend-border col-12">
                                <legend class="w-auto legend-border">
                                    Order List
                                </legend>
                                <div id="table-scroll" class="table-scroll">
                                    <table
                                        id="main-table"
                                        class="main-table table"
                                    >
                                        <thead>
                                            <tr>
                                                <th class="text-left col-1">
                                                    CODE
                                                </th>
                                                <th class="col-3">
                                                    PRODUCT DESCRIPTION
                                                </th>
                                                <th class="text-right col-1">
                                                    PACKSIZE
                                                </th>
                                                <th
                                                    class="text-right pr-4 col-1"
                                                >
                                                    QTY
                                                </th>
                                                <th
                                                    class="text-right pr-4 col-1"
                                                >
                                                    UNIT
                                                </th>
                                                <th
                                                    class="text-right pr-4 col-1"
                                                >
                                                    UNIT PRICE
                                                </th> 
                                                <th
                                                    class="text-right pr-4 col-1"
                                                >
                                                    TOTAL
                                                </th>
                                                <th
                                                    class="text-right pr-4 col-1"
                                                ></th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            <tr 
                                                v-for="(data, i ) in form.items"  
                                                :key="i"
                                            > 
                                                <td class="pr-4">
                                                    {{ data.itemcode}}
                                                </td>
                                                <td class="pr-4"> 
                                                    {{ data.itemdesc}}
                                                </td>
                                                <td class="text-right pr-4">
                                                    {{ data.pckgsize}}
                                                </td>
                                                <td class="text-right pr-4">
                                                    {{ data.qty}}
                                                </td>
                                                <td class="text-right pr-4">
                                                    {{ data.unit}}
                                                </td>
                                                <td class="text-right pr-4">
                                                    {{ data.price}}
                                                </td>
                                                <td class="text-right pr-4">
                                                    {{ data.total }}
                                                </td>
                                                <td class="text-right pr-4">
                                                  <i
                                                    class="
                                                        fas
                                                        fa-trash-alt
                                                        btn btn-danger btn-sm
                                                    "
                                                    @click="deleteRow(i, data)"
                                                ></i>   
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" class=""></td>
                                                <td class="text-right ">
                                                    Quantity
                                                </td>
                                                <td class="text-right pr-4">
                                                    {{ this.formatNumberD(this.grandQtyTotal,0) }}
                                                </td>
                                                <td
                                                    colspan="2"
                                                    class="text-right"
                                                >
                                                    Total
                                                </td>
                                                <td class="text-right pr-4">
                                                    {{ this.formatNumberDis(this.grandTotal) }}
                                                </td>
                                                <td class=""></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <button class="btn btn-sm btn-primary" @click="advanceStep" :disabled="max_step === 3?(grandTotal==''?true:(grandTotal!=='0.00'?false:true)):false">
                    <span v-if="max_step === 3"
                     >Submit</span>
                    <span v-else>Next</span>
                </button>

                 
            </div>
        </div>
    </div>
</template>

<script> 
import Form from "vform";
export default {
    name: "PackingList",
    layout: "default",
    middleware: "auth",
    metaInfo() {
        return { title: "New Packing List" };
    },

    created() {
        this.isLoggedCheck;
    },
    mounted() {
        this.form.trndate = this.datenow;
    },
     computed: {
         
     },
    data() {
        return {
            activeField: true,
            page: 1,
            consignee: "",
            errors: [],
            max_step: 1,
            current_step: 1,
            itemcode: "", 
            price: "",
            itemdesc: "",
            pckgsize:'',
            unit: "",
            total: "",
            qty: "",
            grandTotal:0,
            grandQtyTotal:0,
            
            form: new Form({
                trnmode: "log-pl-create",
                packlist: "",
                contactPerson: "",
                consignee: "",
                address: "",
                trndate: "",
                control_no: "",
                sa_no: "",
                dr_no: "",
                po_no: "",
                so_no: "",
                shippingRequest: "",
                shippingDate: "",
                shippingLine: "",
                shippingMethod: "",
                remarks: "",
                seal_no: "",
                trucking: "",
                pickup: "",
                grosswt: "",
                items: []
            })
        };
    },
    
    methods: { 
        getTotal() { 
            let calTaxTotal =
                parseInt(this.price?this.price:0) *
                parseInt(this.qty?this.qty:0)   
            this.total = this.formatNumberDis(calTaxTotal);
        },
        itemSelectedItem(item) {
            this.itemcode = item.itemcode;
            this.pckgsize = item.pckgsize;
            this.itemdesc = item.itemdesc; 
            this.unit = 'CASE';
            this.activeField = false;
             
            //this.form.items[item.id].itemcode = item.itemcode;
            
        },
        handleAdd() { 
            this.form.items.push({
				qty:  this.formatNumberD(this.qty,0),
                price: this.formatNumberDis(this.price),
                pckgsize: this.pckgsize,
				trntype: "SHA",
				itemcode:  this.itemcode,
				itemdesc:  this.itemdesc,
				unit:  this.unit,
				total:  this.formatNumberDis(this.qty*this.price),
			});
            this.clearItems();
            this.calculateTotal(); 
        },
        clearItems(){
            this.activeField=true;
            this.itemcode= "";
            this.price= "";
            this.itemdesc= "";
            this.pckgsize = "";
            this.unit= "";
            this.total= "";
            this.qty= "";
            this.$refs.itemproduct.selectedItem = ""
        },
        calculateTotal() {
			var totalPrice;
			totalPrice = this.form.items.reduce(function (sum, item) {
                 
            let price = (item.price).replace(',',''); 
            let qty = (item.qty).replace(',',''); 
                
				var lineTotal = parseFloat(price) * parseFloat(qty); 
				if (!isNaN(lineTotal)) {
					return sum + lineTotal;
				}
				return sum;
			}, 0);
			this.grandTotal = totalPrice;    
            
			var totalQty;
			totalQty = this.form.items.reduce(function (sum, item) {
				var lineTotal = parseFloat(item.qty);
				if (!isNaN(lineTotal)) {
					return sum + lineTotal;
				}
				return sum;
			}, 0);
			this.grandQtyTotal = totalQty; 
		},
        advanceStep() {
            if (!this.validate()) {
                return;
            }

            if (this.max_step === 3) {
                return this.submitForm();
            }

            this.current_step++;

            if (this.max_step < this.current_step) {
                this.max_step = this.current_step;
            }
     
        },
        goToStep(value) {
            if (!this.validate()) {
                return;
            }
            this.current_step = value;
              this.max_step = this.current_step;
        },
        submitForm() {
        this.form.post("/api/process/logistic").then((res) => { 
            this.$router.push({
                name: "log-report-sh",
                params: { id: res.data },
            }); 
        });
			 
        },

        validate() { 
            if (this.current_step === 1) {
                if (
                    _.isEmpty(this.form.contactPerson) ||
                    _.isEmpty(this.form.consignee) ||
                    _.isEmpty(this.form.address)||
                    _.isEmpty(this.form.so_no)
                ) {
                    return false;
                }
            }
            if (this.current_step === 2) {
                if (_.isEmpty(this.form.pickup)) {
                    return false;
                }
            }
            //  if(this.current_step ===3 ){
            //     if(_.isEmpty(this.form.items)){
            //         return false;
            //     }
            // }

            return true;
        },
        deleteRow(index, item) {
			var idx = this.form.items.indexOf(item);
			if (idx > -1) {
				this.form.items.splice(idx, 1);
                this.calculateTotal();
			} 
		},
        
    },
    computed:{
        contactPersonIsValid(){
            return !!this.form.contactPerson
        },
        consigneeIsValid(){
            return !!this.form.consignee},
        addressIsValid(){
            return !!this.form.address},
        so_noIsValid(){
            return !!this.form.so_no},
        pickupIsValid(){
            return !!this.form.pickup},
    }
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
