<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    New Packing List
                </h6>
            </div>
            <div class="card-body">
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
                                active: current_step == 2,
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
                                active: current_step == 3,
                            }"
                            href="#"
                            >Detials</a
                        >
                    </li>
                </ul>
                <div>
                    <div class="tab-pane" v-show="current_step == 1">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm mb-1 row">
                                    <label
                                        for="inputContactPerson"
                                        class="
                                            col-md-3
                                            col-form-label
                                            col-form-label-sm
                                        "
                                        >Contact Person :</label
                                    >
                                    <div class="col-md-9">
                                        <input
                                            v-model="form.contactPerson"
                                            type="text"
                                            class="form-control form-control-sm"
                                            :class="
                                                contactPersonIsValid == false
                                                    ? 'is-invalid'
                                                    : ''
                                            "
                                            id="inputContactPerson"
                                            placeholder="Contact Person"
                                        />
                                    </div>
                                </div>

                                <div class="form-group form-group-sm mb-1 row">
                                    <label
                                        for="inputConsignee"
                                        class="
                                            col-md-3
                                            col-form-label
                                            col-form-label-sm
                                        "
                                        >Consignee:</label
                                    >
                                    <div class="col-md-9">
                                        <input
                                            v-model="form.consignee"
                                            type="text"
                                            class="form-control form-control-sm"
                                            :class="
                                                consigneeIsValid == false
                                                    ? 'is-invalid'
                                                    : ''
                                            "
                                            id="inputConsignee"
                                            placeholder="Consignee"
                                        />
                                    </div>
                                </div>
                                <div class="form-group form-group-sm mb-2 row">
                                    <label
                                        for="inputAddress"
                                        class="
                                            col-md-3
                                            col-form-label
                                            col-form-label-sm
                                        "
                                        >Address:</label
                                    >
                                    <div class="col-md-9">
                                        <textarea
                                            v-model="form.address"
                                            class="form-control form-control-sm"
                                            :class="
                                                addressIsValid == false
                                                    ? 'is-invalid'
                                                    : ''
                                            "
                                            placeholder="Address"
                                            id="exampleFormControlTextarea1"
                                            rows="3"
                                        ></textarea>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm mb-1 row">
                                    <label
                                        for="inputShippingLine"
                                        class="
                                            col-md-3
                                            col-form-label
                                            col-form-label-sm
                                        "
                                        >Shipping Line:</label
                                    >
                                    <div class="col-md-9">
                                        <input
                                            v-model="form.shippingLine"
                                            type="text"
                                            class="form-control form-control-sm"
                                            id="inputShippingLine"
                                            placeholder="Shipping Line"
                                        />
                                    </div>
                                </div>

                                <div class="form-group form-group-sm mb-1 row">
                                    <label
                                        for="inputPickUpAt"
                                        class="
                                            col-md-3
                                            col-form-label
                                            col-form-label-sm
                                        "
                                        >Destination:</label
                                    >
                                    <div class="col-md-9">
                                        <input
                                            v-model="form.pickup"
                                            type="text"
                                            class="form-control form-control-sm"
                                            :class="
                                                pickupIsValid == false
                                                    ? 'is-invalid'
                                                    : ''
                                            "
                                            id="inputPickUpAt"
                                            placeholder="Port of destination"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-sm mb-1 row">
                                    <label
                                        for="inputDate"
                                        class="
                                            col-md-2
                                            col-form-label
                                            col-form-label-sm
                                        "
                                        >Date:</label
                                    >
                                    <div class="col-md-4">
                                        <input
                                            v-model="form.trndate"
                                            type="date"
                                            class="form-control form-control-sm"
                                            id="inputDate"
                                            placeholder="Date"
                                        />
                                    </div>

                                    <label
                                        for="inputShipping"
                                        class="
                                            col-md-2
                                            col-form-label
                                            col-form-label-sm
                                            pr-0
                                        "
                                        ><small>Shipping Date:</small></label
                                    >
                                    <div class="col-md-4">
                                        <input
                                            v-model="form.shippingDate"
                                            :class="
                                                shippingDateIsValid == false
                                                    ? 'is-invalid'
                                                    : ''
                                            "
                                            type="date"
                                            class="form-control form-control-sm"
                                            id="inputShippingDate"
                                            placeholder="Shipping/ Pick up date"
                                        />
                                    </div>
                                </div>

                                <div class="form-group form-group-sm mb-1 row">
                                    <label
                                        for="inputSONo"
                                        class="
                                            col-md-2
                                            col-form-label
                                            col-form-label-sm
                                        "
                                        >RO No.:</label
                                    >
                                    <div class="col-md-4">
                                        <input
                                            v-model="form.ro_no"
                                            type="text"
                                            class="form-control form-control-sm"
                                            :class="
                                                ro_noIsValid == false
                                                    ? 'is-invalid'
                                                    : ''
                                            "
                                            id="inputSONo"
                                            placeholder="RO No."
                                        />
                                    </div>
                                    <label
                                        for="inputSONo"
                                        class="
                                            col-md-2
                                            col-form-label
                                            col-form-label-sm
                                        "
                                        >PO No.:</label
                                    >
                                    <div class="col-md-4">
                                        <input
                                            v-model="form.po_no"
                                            type="text"
                                            class="form-control form-control-sm"
                                            placeholder="PO No."
                                        />
                                    </div>
                                </div>
                                <div class="form-group form-group-sm mb-2 row">
                                    <label
                                        for="inputDR"
                                        class="
                                            col-md-2
                                            col-form-label
                                            col-form-label-sm
                                        "
                                        >DR:</label
                                    >
                                    <div class="col-md-4">
                                        <textarea
                                            v-model="form.dr_no"
                                            class="form-control form-control-sm"
                                            placeholder="DR No."
                                            id="exampleFormControlTextarea1"
                                            rows="3"
                                        ></textarea>
                                    </div>
                                    <label
                                        for="inputPO"
                                        class="
                                            col-md-2
                                            col-form-label
                                            col-form-label-sm
                                        "
                                        >SO No.:</label
                                    >
                                    <div class="col-md-4">
                                        <textarea
                                            v-model="form.so_no"
                                            class="form-control form-control-sm"
                                            placeholder="SO No."
                                            id="exampleFormControlTextarea1"
                                            rows="3"
                                        ></textarea>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm mb-1 row">
                                    <label
                                        for="inputStockRequest"
                                        class="
                                            col-md-3
                                            col-form-label
                                            col-form-label-sm
                                        "
                                        >Booking No.:</label
                                    >
                                    <div class="col-md-9">
                                        <input
                                            v-model="form.booking_no"
                                            type="text"
                                            class="form-control form-control-sm"
                                            id="inputStockRequest"
                                            placeholder="Booking No."
                                        />
                                    </div>
                                </div>
                                <div class="form-group form-group-sm mb-1 row">
                                    <label
                                        for="inputShipmentMethod"
                                        class="
                                            col-md-3
                                            col-form-label
                                            col-form-label-sm
                                        "
                                    >
                                        <small>Shipment Method:</small>
                                    </label>
                                    <div class="col-md-9">
                                        <input
                                            v-model="form.shipmentMethod"
                                            type="text"
                                            class="form-control form-control-sm"
                                            id="inputShipmentMethod"
                                            placeholder="Shipment Method"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" v-show="current_step == 2">
                        <div class="row mt-2">
                            <div class="col-6">
                                <div class="form-group form-group-sm mb-1 row">
                                    <label
                                        for="inputControlNo"
                                        class="
                                            col-md-3
                                            col-form-label
                                            col-form-label-sm
                                        "
                                        >Control No:</label
                                    >
                                    <div class="col-md-9">
                                        <input
                                            v-model="form.control_no"
                                            type="text"
                                            :class="
                                                control_noIsValid == false
                                                    ? 'is-invalid'
                                                    : ''
                                            "
                                            class="form-control form-control-sm"
                                            id="inputControlNo"
                                            placeholder="Control No"
                                        />
                                    </div>
                                </div>
                                <div class="form-group form-group-sm mb-1 row">
                                    <label
                                        for="inputSealNo"
                                        class="
                                            col-md-3
                                            col-form-label
                                            col-form-label-sm
                                        "
                                        >Seal No:</label
                                    >
                                    <div class="col-md-9">
                                        <input
                                            v-model="form.seal_no"
                                            type="text"
                                            :class="
                                                seal_noIsValid == false
                                                    ? 'is-invalid'
                                                    : ''
                                            "
                                            class="form-control form-control-sm"
                                            id="inputSealNo"
                                            placeholder="Seal No"
                                        />
                                    </div>
                                </div>
                                <div class="form-group form-group-sm mb-1 row">
                                    <label
                                        for="inputTrurkingNo"
                                        class="
                                            col-md-3
                                            col-form-label
                                            col-form-label-sm
                                        "
                                        >Trucking #:</label
                                    >
                                    <div class="col-md-9">
                                        <input
                                            v-model="form.trucking"
                                            :class="
                                                truckingIsValid == false
                                                    ? 'is-invalid'
                                                    : ''
                                            "
                                            type="text"
                                            class="form-control form-control-sm"
                                            id="inputTrurkingNo"
                                            placeholder="Trucking #"
                                        />
                                    </div>
                                </div>

                                <div class="form-group form-group-sm mb-1 row">
                                    <label
                                        for="inputGrossWT"
                                        class="
                                            col-md-3
                                            col-form-label
                                            col-form-label-sm
                                        "
                                        >Gross wt:</label
                                    >
                                    <div class="col-md-9">
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
                                <div class="form-group form-group-sm mb-1 row">
                                    <label
                                        for="inputRemarks"
                                        class="
                                            col-md-3
                                            col-form-label
                                            col-form-label-sm
                                        "
                                        >Remarks:</label
                                    >
                                    <div class="col-md-9">
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
                                    <div class="col-4">
                                        <!-- :items="getItemsOut" -->
                                        <typeahead
                                            v-model="itemcode"
                                            :items="getAllItems"
                                            :index="`1`"
                                            filterby="itemdesc"
                                            addOnDisplay1="expdate"
                                            addOnDisplay="qtyDesc"
                                            @change="onChangeItems"
                                            title="Itemdesc"
                                            @selected="itemSelected"
                                            class="form-control form-control-sm"
                                            ref="itemproduct"
                                            :class="{
                                                'is-invalid':
                                                    form.errors.has(`itemcode`),
                                            }"
                                            :name="`itemcode`"
                                        />
                                        <has-error
                                            :form="form"
                                            :field="`itemcode`"
                                        />
                                    </div>
                                    <div class="col-1">
                                        <input
                                            v-model="qty"
                                            @change="getTotal"
                                            class="
                                                form-control form-control-sm
                                                text-right
                                            "
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
                                            <option value="" disabled selected>
                                                Unit
                                            </option>
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
                                            v-model="expdate"
                                            type="date"
                                            class="form-control form-control-sm"
                                            placeholder="expdate"
                                            :disabled="activeField"
                                        />
                                    </div>

                                    <div class="col-3">
                                        <input
                                            v-model="remarks"
                                            type="text"
                                            class="form-control form-control-sm"
                                            placeholder="Remarks"
                                            :disabled="activeField"
                                        />
                                    </div>

                                    <div class="col-1">
                                        <button
                                            @click="handleAdd"
                                            :disabled="
                                                qty == ''
                                                    ? true
                                                    : qty !== '0'
                                                    ? false
                                                    : true
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
                                        class="
                                            main-table
                                            table
                                            col-form-label-sm
                                            table-sm
                                        "
                                    >
                                        <thead>
                                            <tr>
                                                <th>CODE</th>
                                                <th>PRODUCT DESCRIPTION</th>
                                                <th class="text-right">
                                                    PACKSIZE
                                                </th>
                                                <th class="text-right pr-4">
                                                    QTY
                                                </th>
                                                <th class="text-right pr-4">
                                                    UNIT
                                                </th>
                                                <th class="text-right pr-4">
                                                    EX. DATE
                                                </th>
                                                <th class="text-right pr-4">
                                                    REMARKS
                                                </th>
                                                <th
                                                    class="text-right pr-4"
                                                ></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(data, i) in form.items"
                                                :key="i"
                                            >
                                                <td class="pr-4">
                                                    {{ data.itemcode }}
                                                </td>
                                                <td class="pr-4">
                                                    {{ data.itemdesc }}
                                                </td>
                                                <td class="text-right pr-4">
                                                    {{ data.pckgsize }}
                                                </td>
                                                <td class="text-right pr-4">
                                                    {{ data.qty }}
                                                </td>
                                                <td class="text-right pr-4">
                                                    {{ data.unit }}
                                                </td>
                                                <td class="text-right pr-4">
                                                    {{ data.expdate }}
                                                </td>
                                                <td class="text-right pr-4">
                                                    {{ data.remarks }}
                                                </td>
                                                <td class="text-right pr-4">
                                                    <i
                                                        class="
                                                            fas
                                                            fa-trash-alt
                                                            btn
                                                            btn-danger
                                                            btn-sm
                                                        "
                                                        @click="
                                                            deleteRow(i, data)
                                                        "
                                                    ></i>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" class=""></td>
                                                <td class="text-right">
                                                    Quantity
                                                </td>
                                                <td class="text-right pr-4">
                                                    {{
                                                        this.formatNumberD(
                                                            this.grandQtyTotal,
                                                            0
                                                        )
                                                    }}
                                                </td>
                                                <td
                                                    colspan="3"
                                                    class="text-right"
                                                ></td>
                                                <td class=""></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <button
                    class="btn btn-sm btn-primary"
                    @click="advanceStep"
                    :disabled="
                        max_step === 3
                            ? grandQtyTotal !== '0'
                                ? false
                                : true
                            : false
                    "
                >
                    <span v-if="max_step === 3">Submit</span>
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
    computed: {},
    data() {
        return {
            activeField: true,
            page: 1,
            consignee: "",
            errors: [],
            max_step: 1,
            current_step: 1,
            itemcode: "",
            expdate: "",
            itemdesc: "",
            pckgsize: "",
            unit: "",
            remarks: "",
            qty: "",
            grandTotal: 0,
            grandQtyTotal: 0,

            form: new Form({
                trnmode: "log-pl-create",
                contactPerson: "",
                consignee: "",
                address: "",
                shippingLine: "",
                pickup: "",
                trndate: "",
                shippingDate: "",
                dr_no: "",
                po_no: "",
                so_no: "",
                ro_no: "",
                booking_no: "",
                shipmentMethod: "",
                control_no: "",
                remarks: "",
                seal_no: "",
                trucking: "",
                grosswt: "",
                items: [],
            }),
        };
    },

    mounted() {
        this.canAuth("packing-list-create");
        this.form.userid = this.isUser.id;
        this.form.trndate = this.datenow;
        this.fetchItemsOut();
    },
    methods: {
        fetchItemsOut() {
            this.$store.dispatch("Item/fetchItemsOut", {
                branch: this.isUser.branch,
            });
        },

        getTotal() {
            let calTaxTotal =
                parseInt(this.price ? this.price : 0) *
                parseInt(this.qty ? this.qty : 0);
            this.total = this.formatNumberDis(calTaxTotal);
        },
        itemSelected(item) {
            this.itemcode = item.itemcode;
            this.pckgsize = item.pckgsize;
            this.itemdesc = item.itemdesc;
            this.expdate = item.expdate;
            this.unit = "CASE";
            this.activeField = false;

            //this.form.items[item.id].itemcode = item.itemcode;
        },
        handleAdd() {
            this.form.items.push({
                qty: this.formatNumberD(this.qty, 0),
                expdate: this.expdate,
                pckgsize: this.pckgsize,
                remarks: this.remarks,
                trntype: "PL",
                itemcode: this.itemcode,
                itemdesc: this.itemdesc,
                unit: this.unit,
            });
            this.clearItems();
            this.calculateTotal();
        },
        clearItems() {
            this.activeField = true;
            this.itemcode = "";
            this.expdate = "";
            this.itemdesc = "";
            this.pckgsize = "";
            this.unit = "";
            this.remarks = "";
            this.qty = "";
            this.$refs.itemproduct.selectedItem = "";
        },
        calculateTotal() {
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
                //  console.log(res.data);
                this.$router.push({
                    name: "log-report-pl",
                    params: { id: res.data },
                });
            });
        },

        validate() {
            if (this.current_step === 1) {
                if (
                    _.isEmpty(this.form.contactPerson) ||
                    _.isEmpty(this.form.consignee) ||
                    _.isEmpty(this.form.address) ||
                    _.isEmpty(this.form.shippingDate) ||
                    _.isEmpty(this.form.ro_no)
                ) {
                    return false;
                }
            }
            if (this.current_step === 2) {
                if (
                    _.isEmpty(this.form.control_no) ||
                    _.isEmpty(this.form.seal_no) ||
                    _.isEmpty(this.form.trucking)
                ) {
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
    computed: {
        contactPersonIsValid() {
            return !!this.form.contactPerson;
        },
        consigneeIsValid() {
            return !!this.form.consignee;
        },
        addressIsValid() {
            return !!this.form.address;
        },
        shippingDateIsValid() {
            return !!this.form.shippingDate;
        },
        ro_noIsValid() {
            return !!this.form.ro_no;
        },
        control_noIsValid() {
            return !!this.form.control_no;
        },
        seal_noIsValid() {
            return !!this.form.seal_no;
        },
        truckingIsValid() {
            return !!this.form.trucking;
        },
        pickupIsValid() {
            return !!this.form.pickup;
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
