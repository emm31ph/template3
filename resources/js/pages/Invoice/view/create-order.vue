<template>
    <div>
        <div class="card shadow mb-4">
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
                                'is-invalid': form.errors.has(`customer`)
                            }"
                            :name="`pricecust`"
                            ref="customer"
                        />
                        <has-error :form="form" :field="`customer`" />
                    </fieldset>
                </div>

                <div class="row  mb-0">
                    <div class="col-2">
                        <fieldset class="legend-border col">
                            <legend class="legend-border w-auto">
                                Sales Person
                            </legend>

                            <input
                                disabled
                                v-model="form.salesperson"
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
                                type="text"
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
                                type="text"
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
                            <div class="col-6">
                                <typeahead
                                    v-model="itemcode"
                                    :items="getAllItems"
                                    :index="`1`"
                                    filterby="itemdesc"
                                    @change="onChangeItems"
                                    title="Product Description"
                                    @selected="itemSelectedItem"
                                    class="form-control form-control-sm" 
                                    :name="`form.itemcode`"
                                    :disable="activeField"
                                /> 
                            </div>
                            <div class="col-1">
                                <input
                                    v-model="qty"
                                    class="form-control form-control-sm" 
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
                                        v-for="option in getLookup('UOM1')"
                                        v-bind:value="option.code"
                                        :key="option.code"
                                    >
                                        {{ option.fulltitle }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-1">
                                <input
                                    v-model="price"
                                    class="form-control form-control-sm" 
                                    placeholder="Unit Price"
                                    disabled
                                /> 
                            </div>

                            <div class="col-1">
                                <input
                                    v-model="disc"
                                    class="form-control form-control-sm text-right" 
                                    placeholder="Discount"
                                    disabled
                                /> 
                            </div>

                            <div class="col-1">
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
                                    :disabled="activeField || (itemcode!==''?false:true)"
                                    type="add"
                                    class="btn btn-sm btn-primary"
                                >
                                    Submit
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
                        <th class="text-left col-1">CODE</th>
                        <th class="col-3">PRODUCT DESCRIPTION</th>
                        <th class="text-center col-1">PACKSIZE</th>
                        <th class="text-right pr-4 col-1">QTY</th>
                        <th class="text-right pr-4 col-1">UNIT</th>
                        <th class="text-right pr-4 col-1">UNIT PRICE</th>
                        <th class="text-right pr-4 col-1">DISCOUNT</th>
                        <th class="text-right pr-4 col-1">TOTAL</th>
                        <th class="text-right pr-4 col-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="index in 10" :key="index">
                        <td class="">aaaaaa</td>
                        <td class="">Varun tdakur</td>
                        <td class="text-center">30</td>
                        <td class="text-right pr-4">1</td>
                        <td class="text-right pr-4">CASE</td>
                        <td class="text-right pr-4">1.00</td>
                        <td class="text-right pr-4">0.00</td>
                        <td class="text-right pr-4">1.00</td>
                        <td class="text-right pr-4">1.00</td>
                    </tr> 

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class=""></td> 
                        <td class="text-right ">Quantity</td>
                        <td class="text-right pr-4">10</td>
                        <td colspan="3" class="text-right">Total</td>
                        <td class="text-right pr-4" >1000.00</td>
                        <td class=""></td> 
                    </tr>
                </tfoot>
            </table>
        </div>
                     </fieldset>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Form from "vform";
export default {
    name: "Invoice",
    layout: "default",
    middleware: "auth",
    data() {
        return {
            activeField: true,
            itemcode: "",
            disc: "",
            price: "",
            amount: "",
            unit: "",
            total:"",
            qty: "",
            form: new Form({
                customer: "",
                salesperson: "",
                SONo: "",
                PONo: "",
                addresss: "",
                deliverto: "",
                trndate: "",
                items: [
                    {
                        itemcode: "",
                        disc: "",
                        price: "",
                        amount: "",
                        unit: "",
                        total:"",
                        qty: "",
                    }
                ],
                cid: "",
                salesperson: []
            })
        };
    },
    metaInfo() {
        return { title: "Invoice - Create Order" };
    },
    mounted() {
        this.canAuth("invoice-create");
    },
    created() {
        this.isLoggedCheck;
    },
    methods: {
        itemSelected(item) { 
            this.form.salesperson = this.getSalesPerson(item.salesperson);
            
            this.activeField = false;
        },
        itemSelectedItem(item) {
            this.itemcode = item.itemcode
            //this.form.items[item.id].itemcode = item.itemcode; 
        },
        handleAdd() {}
    }
};
</script>

<style>
 .table-scroll {
  position: relative;
  width:100%;
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
  z-index:4;
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
