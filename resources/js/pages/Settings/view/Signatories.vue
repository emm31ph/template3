<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Signatories</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <slot name="body">
                        <div class="col-md-12">
                            <div class="panel panel-default mb-2">
                                <form
                                    @submit.prevent="handleSubmit"
                                    @keydown="form.onKeydown($event)"
                                >
                                    <fieldset class="col-md-6 pb-0">
                                        <legend>Select Report Signatory</legend>

                                        <div></div>
                                        <div class="input-group mb-3">
                                            <typeahead
                                                v-model="signa"
                                                :items="getLookup('R01')"
                                                filterby="fulltitle"
                                                filterby2="fulldesc"
                                                title="Reports"
                                                @selected="itemSelected"
                                                class="
                                                    form-control form-control-sm
                                                "
                                                :name="`fulltitle`"
                                                ref="fulltitle"
                                            />
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-12" style="min-height: 400px">
                            <div class="card rounded">
                                <div class="tableFixHead1">
                                    <table
                                        class="table table-hover table-sm"
                                        id="dev-table"
                                    >
                                        <thead>
                                            <tr>
                                                <th>Signatories</th>
                                                <th>Signee</th>
                                                <th>Designation</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            style="
                                                height-max: 100px !important;
                                                overflow: scroll;
                                                flex-direction: column-reverse;
                                            "
                                        >
                                            <tr
                                                v-for="(
                                                    item, i
                                                ) in getSignatories"
                                                :key="i"
                                            >
                                                <td>
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            form.signatories
                                                        "
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                        "
                                                    />
                                                </td>
                                                <td>
                                                    <!-- <input
                                                        type="text"
                                                        v-model="form.signee"
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                        "
                                                    /> -->
                                                </td>
                                                <td>
                                                    <!-- <input
                                                        type="text"
                                                        v-model="
                                                            form.designation
                                                        "
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                        "
                                                    /> -->
                                                </td>
                                                <td>
                                                    <i
                                                        class="
                                                            fas
                                                            fa-trash-alt
                                                            btn
                                                            btn-danger
                                                            btn-sm
                                                        "
                                                        @click="
                                                            deleteRow(i, item)
                                                        "
                                                    ></i>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Form from "vform";
export default {
    name: "Signatories",
    layout: "default",
    middleware: "auth",
    data() {
        return {
            signa: "",
            form: new Form({
                items: [{ signatories: "", signee: "", designation: "" }],
            }),
            // trndate: "",
            datas: [],
        };
    },
    metaInfo() {
        return { title: "Signatories" };
    },

    created() {
        this.isLoggedCheck;
    },
    mounted() {
        this.form.items = [];
        this.datas = {};
    },
    computed: {},
    methods: {
        handleSubmit() {},
        itemSelected(data) {
            this.$store.dispatch("Settings/fetchSignatories", {
                trnmode: "print",
                trntype: data.code,
            });
            this.getValue();
        },

        deleteRow(index, item) {
            var idx = this.form.items.indexOf(item);
            if (idx > -1) {
                this.form.items.splice(idx, 1);
            }
        },
    },
};
</script>

<style>
fieldset {
    border: 1px solid #ddd !important;
    margin: 0;
    min-width: 0;
    padding: 10px;
    position: relative;
    border-radius: 4px;
    background-color: #f5f5f5;
    padding-left: 10px !important;
}

legend {
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 0px;
    width: 35%;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px 5px 5px 10px;
    background-color: #ffffff;
}
</style>