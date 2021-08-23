<template>
    <transition name="modal-fade">
        <div class="modal-backdrop">
            <div
                class="modal"
                role="dialog"
                aria-labelledby="modalTitle"
                aria-describedby="modalDescription"
            >
                <header class="modal-header" id="modalTitle">
                    <slot name="header"> Activity Log </slot>
                    <button
                        type="button"
                        class="btn-close"
                        @click="close"
                        aria-label="Close modal"
                    >
                        x
                    </button>
                </header>

                <section class="modal-body" id="modalDescription">
                    <slot name="body">
                        <div class="col-md-12">
                            <div class="panel panel-default mb-2">
                                <form
                                    @submit.prevent="handleSubmit"
                                    @keydown="form.onKeydown($event)"
                                >
                                    <fieldset class="col-md-3 pb-0">
                                        <legend>Select Date</legend>

                                        <div class="input-group mb-3">
                                            <input
                                                type="date"
                                                class="form-control"
                                                placeholder="Recipient's username"
                                                aria-label="Recipient's username"
                                                aria-describedby="basic-addon2"
                                                v-model="form.trndate"
                                                name="trndate"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.has(
                                                            'trndate'
                                                        ),
                                                }"
                                            />

                                            <div class="input-group-append">
                                                <v-button
                                                    class="
                                                        btn
                                                        btn-outline-secondary
                                                    "
                                                    type="submit"
                                                    :loading="form.busy"
                                                >
                                                    Generate
                                                </v-button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card rounded">
                                <div class="tableFixHead1">
                                    <table
                                        class="table table-hover table-sm"
                                        id="dev-table"
                                    >
                                        <thead>
                                            <tr>
                                                <th>TRN</th>
                                                <th>TRNMODE</th>
                                                <th>
                                                    Customer/Supplier/From&To
                                                </th>
                                                <th>REF#/RS#/PO#</th>
                                                <th>Remarks</th>
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
                                                v-for="(data, i) in datas"
                                                :key="i"
                                                @dblclick="handleClick(data)"
                                            >
                                                <td>{{ data.batch }}</td>
                                                <td>
                                                    {{
                                                        data.trnType == "001"
                                                            ? "Delivery"
                                                            : data.trnType ==
                                                              "002"
                                                            ? "FPTD"
                                                            : data.trnType ==
                                                              "003"
                                                            ? "RR"
                                                            : data.trnType ==
                                                              "004"
                                                            ? "RRM"
                                                            : data.trnType ==
                                                              "005"
                                                            ? "Reject"
                                                            : data.trnType ==
                                                              "007"
                                                            ? "REVERSAL"
                                                            : data.trnType ==
                                                              "008"
                                                            ? "Import"
                                                            : data.trnType ==
                                                              "009"
                                                            ? "Adjust"
                                                            : ""
                                                    }}
                                                </td>
                                                <td>
                                                    {{ data.customer
                                                    }}{{
                                                        data.from
                                                            ? data.from +
                                                              " -> " +
                                                              data.to
                                                            : ""
                                                    }}
                                                </td>
                                                <td>
                                                    {{
                                                        "".concat(
                                                            data.refno == null
                                                                ? " "
                                                                : data.refno +
                                                                      "/ ",
                                                            data.rono == null
                                                                ? " "
                                                                : data.rono +
                                                                      "/ ",
                                                            data.van_no == null
                                                                ? " "
                                                                : data.van_no +
                                                                      "/ ",
                                                            data.seal_no == null
                                                                ? " "
                                                                : data.seal_no +
                                                                      "/ "
                                                        )
                                                    }}
                                                </td>
                                                <td>{{ data.remarks }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </slot>
                </section>
                <footer class="modal-footer">
                    <button
                        type="button"
                        class="btn-green"
                        @click="close"
                        aria-label="Close modal"
                    >
                        Close me!
                    </button>
                </footer>
            </div>
        </div>
    </transition>
</template>

<script>
import Form from "vform";
export default {
    name: "Modal",
    data() {
        return {
            form: new Form({
                trndate: "",
            }),
            // trndate: "",
            datas: [],
        };
    },
    mounted() {
        this.trndate = this.datenow;
    },
    methods: {
        close() {
            this.$emit("close");
        },
        handleSubmit() {
            this.form
                .post("/api/items/myTrn", {
                    params: {
                        trndate: this.form.trndate,
                        branch: this.isUser.branch,
                    },
                })
                .then((result) => {
                    this.datas = result.data;
                    if (result.data.length === 0) {
                        Swal.fire({
                            position: "top-end",
                            icon: "info",
                            toast: true,
                            title: "no record found",
                            showConfirmButton: false,
                            timer: 2500,
                        });
                    }
                })
                .catch((err) => {
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        toast: true,
                        title: "error process",
                        showConfirmButton: false,
                        timer: 2500,
                    });
                });
        },
        handleClick(data) {
            this.datas = "";

            this.$router.push({
                name: "report-view",
                params: { batch: data.batch },
            });
            this.close();
            // 	this.$router.push({
            // 	name: "report-dlvry",
            // 	params: { id: res.data.id },
            // });
        },
    },
};
</script>

<style>
.tableFixHead1 {
    overflow-y: scroll;
    max-height: 500px;
    width: auto;
    display: flex;
    flex-direction: column-reverse;
    bottom: 0;
    top: 0;
}
.tableFixHead1 thead th {
    position: sticky;
    top: 0;
    z-index: 1;
    background-color: black;
    color: white;
}
.tableFixHead1 tbody th {
    position: sticky;
    left: 0;
    border-bottom: 1px solid black;
}
.modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal {
    background: #ffffff;
    box-shadow: 2px 2px 20px 1px;
    overflow-x: auto;
    display: flex;
    flex-direction: column;
}

.modal-header,
.modal-footer {
    padding: 15px;
    display: flex;
}

.modal-header {
    position: relative;
    border-bottom: 1px solid #eeeeee;
    color: #4aae9b;
    justify-content: space-between;
}

.modal-footer {
    border-top: 1px solid #eeeeee;
    flex-direction: column;
}

.modal-body {
    position: relative;
    padding: 20px 10px;
}

.btn-close {
    position: absolute;
    top: 0;
    right: 0;
    border: none;
    font-size: 20px;
    padding: 10px;
    cursor: pointer;
    font-weight: bold;
    color: #4aae9b;
    background: transparent;
}

.btn-green {
    color: white;
    background: #4aae9b;
    border: 1px solid #4aae9b;
    border-radius: 2px;
}

.modal-fade-enter,
.modal-fade-leave-to {
    opacity: 0;
}

.modal-fade-enter-active,
.modal-fade-leave-active {
    transition: opacity 0.5s ease;
}
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