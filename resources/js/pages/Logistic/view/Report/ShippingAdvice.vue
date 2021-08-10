<template>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Print Preview</h6>
        </div>
        <div class="card-body">
            <div class="warp">
                <div id="printme">
                    <page v-if="data">
                        <div class="row p-2">
                            <div class="col-12">
                                <div class="card border-0">
                                    <div class="card-body p-0">
                                        <div
                                            class="
													container-fluid
													py-0
													pl-0
												"
                                        >
                                            <div class="row mb-2">
                                                <div class="col-3">
                                                    <img
                                                        src="/img/logo.png"
                                                        class="
																rounded
																float-left
																img-thumbnail
																mr-2
															"
                                                        style="width: 150px"
                                                    />
                                                </div>
                                                <div
                                                    class="
															col-6
															text-center
															position-relative
														"
                                                >
                                                    <p
                                                        class="
																h4
																font-weight-bold
																mb-1 
                                                                mt-2
															"
                                                    >
                                                        SHIPPING ADVICE
                                                    </p>
                                                    <div
                                                        class=""
                                                        style="font-size: 10px;"
                                                    >
                                                        <b
                                                            >117 Quirino Higway,
                                                            Beasa Novaliches
                                                            QC</b
                                                        >
                                                    </div>

                                                    <div
                                                        class=""
                                                        style="font-size: 10px;"
                                                    >
                                                        <b>Tel: </b>(833) 42855
                                                        to 57 &nbsp;
                                                        <b>Email: </b
                                                        >logiststics@tosenfoods.com
                                                    </div>
                                                </div>
                                                <div class="col-3 text-right">
                                                    <p
                                                        class="
																font-weight-bold
																mb-1
															"
                                                    >
                                                        {{ this.data["batch"] }}
                                                    </p>
                                                    <sub
                                                        class="
																text-muted
																mb-1
															"
                                                    >
                                                        Printed Date :
                                                        {{ this.dateTime }}
                                                    </sub>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="my-2" />
                                        <div class="pb-1 px-2 py-2">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div
                                                            class="
																	col-4
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            PACKING LIST :
                                                        </div>
                                                        <div class="col-8">
                                                            {{
                                                                this.Ucase(
                                                                    this.data[
                                                                        "packlist"
                                                                    ]
                                                                )
                                                            }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div
                                                            class="
																	col-6
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            DATE :
                                                        </div>
                                                        <div class="col-6">
                                                            {{
                                                                this.data[
                                                                    "trndate"
                                                                ]
                                                            }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div
                                                            class="
																	col-4
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            CONSIGNEE :
                                                        </div>
                                                        <div class="col-8">
                                                            {{
                                                                this.Ucase(
                                                                    this.data[
                                                                        "consignee"
                                                                    ]
                                                                )
                                                            }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div
                                                            class="
																	col-6
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            PICK UP DATE :
                                                        </div>
                                                        <div class="col-6">
                                                            {{
                                                                this.Ucase(
                                                                    this.data[
                                                                        "shippingdate"
                                                                    ]
                                                                )
                                                            }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div
                                                            class="
																	col-4
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            Address :
                                                        </div>
                                                        <div class="col-8">
                                                            {{
                                                                this.Ucase(
                                                                    this.data[
                                                                        "address"
                                                                    ]
                                                                )
                                                            }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div
                                                            class="
																	col-6
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            SA No. :
                                                        </div>
                                                        <div class="col-6">
                                                            {{
                                                                this.data[
                                                                    "sa_no"
                                                                ]
                                                            }}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div
                                                            class="
																	col-6
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            DR No. :
                                                        </div>
                                                        <div class="col-6">
                                                            {{
                                                                this.Ucase(
                                                                    this.data[
                                                                        "dr_no"
                                                                    ]
                                                                )
                                                            }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div
                                                            class="
																	col-4
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            CONTACT :
                                                        </div>
                                                        <div class="col-8">
                                                            {{
                                                                this.Ucase(
                                                                    this.data[
                                                                        "contactperson"
                                                                    ]
                                                                )
                                                            }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div
                                                            class="
																	col-6
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            PO No.:
                                                        </div>
                                                        <div class="col-6">
                                                            {{
                                                                this.Ucase(
                                                                    this.data[
                                                                        "po_no"
                                                                    ]
                                                                )
                                                            }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div
                                                            class="
																	col-4
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            SHIPPING LINE :
                                                        </div>
                                                        <div class="col-8">
                                                            {{
                                                                this.Ucase(
                                                                    this.data[
                                                                        "shippingline"
                                                                    ]
                                                                )
                                                            }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div
                                                            class="
																	col-6
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            SO No.:
                                                        </div>
                                                        <div class="col-6">
                                                            {{
                                                                this.Ucase(
                                                                    this.data[
                                                                        "so_no"
                                                                    ]
                                                                )
                                                            }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div
                                                            class="
																	col-4
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            STOCK REQUEST :
                                                        </div>
                                                        <div class="col-8">
                                                            {{
                                                                this.Ucase(
                                                                    this.data[
                                                                        "stockrequest"
                                                                    ]
                                                                )
                                                            }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div
                                                            class="
																	col-6
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            SHIPPING METHOD:
                                                        </div>
                                                        <div class="col-6">
                                                            {{
                                                                this.Ucase(
                                                                    this.data[
                                                                        "shippingmethod"
                                                                    ]
                                                                )
                                                            }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- start  -->

                                        <div class="row mt-1 mb-3">
                                            <div class="col p-3 d-flex justify-content-center">
                                                  <div
                                                    style="width:90%"
                                                >
                                                    <table
                                                        class="mytable w-100 "
                                                    >
                                                        <thead
                                                            style="font-size:16px"
                                                        >
                                                            <tr
                                                                class=" text-uppercase 
																	font-weight-bold
																"
                                                            >
                                                                <th
                                                                    class="text-center"
                                                                >
                                                                    QUANTITY
                                                                </th>

                                                                <th
                                                                    class="text-center"
                                                                >
                                                                    Item
                                                                    Description
                                                                </th>
                                                                <th
                                                                    class="text-center 
																		text-right
                                                                        pr-2
																	"
                                                                >
                                                                    UNIT PRICE
                                                                </th>
                                                                <th    
                                                                style="width:200px"
                                                                    class="text-center 
																		text-right
                                                                        pr-2
																	"
                                                                >
                                                                    TOTAL
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr style="line-height: 15px;"
                                                                v-for="(item,
                                                                i) in data[
                                                                    'items'
                                                                ]"
                                                                :key="i"
                                                            >
                                                                <td
                                                                    class="
																		text-center
																	"
                                                                >
                                                                    {{
                                                                        item[
                                                                            "qty"
                                                                        ]
                                                                    }}
                                                                    {{
                                                                        item[
                                                                            "unit"
                                                                        ]
                                                                    }}S
                                                                </td>
                                                                <td class="">
                                                                    {{
                                                                        Ucase(
                                                                            item[
                                                                                "itemdesc"
                                                                            ]
                                                                        )
                                                                    }}
                                                                </td>

                                                                <td
                                                                    class="text-right 
                                                                        pr-2"
                                                                >
                                                                    {{
                                                                        formatNumber(
                                                                            item[
                                                                                "price"
                                                                            ] /
                                                                                100
                                                                        )
                                                                    }}
                                                                </td>
                                                                <td
                                                                    class="
																		text-right
                                                                        pr-2
																	"
                                                                >
                                                                    {{
                                                                        formatNumber(
                                                                            item[
                                                                                "total"
                                                                            ] /
                                                                                100
                                                                        )
                                                                    }}
                                                                </td>
                                                            </tr> 
                                                             
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td
                                                                    class="text-center"
                                                                >
                                                                    <b
                                                                        >TOTAL :
                                                                        {{
                                                                            this
                                                                                .totalQty
                                                                        }}
                                                                    </b>
                                                                </td>
                                                                <td
                                                                    colspan="2"
                                                                > </td>
                                                                <td
                                                                    class="text-right pr-2"
                                                                >
                                                                    <b>
                                                                        TOTAL :
                                                                        {{
                                                                            formatNumber(
                                                                                this
                                                                                    .totalAmount
                                                                            )
                                                                        }}
                                                                    </b>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div> 
                                            </div>
                                        </div>
                                        <!--  end -->
                                        <hr class="my-2" />
                                        <div class="pb-1 px-2 py-2">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="row">
                                                        <div
                                                            class="
																	col-2
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            CONTROL :
                                                        </div>
                                                        <div class="col-10">
                                                            {{
                                                                this.Ucase(
                                                                    this.data[
                                                                        "control_no"
                                                                    ]
                                                                )
                                                            }}
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div
                                                            class="
																	col-2
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            SEAL No. :
                                                        </div>
                                                        <div class="col-10">
                                                            {{
                                                                this.Ucase(
                                                                    this.data[
                                                                        "seal_no"
                                                                    ]
                                                                )
                                                            }}
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div
                                                            class="
																	col-2
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            TRUCKING NO. :
                                                        </div>
                                                        <div class="col-10">
                                                            {{
                                                                this.Ucase(
                                                                    this.data[
                                                                        "trucking_no"
                                                                    ]
                                                                )
                                                            }}
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div
                                                            class="
																	col-2
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            PICK-UP AT :
                                                        </div>
                                                        <div class="col-10">
                                                            {{
                                                                this.Ucase(
                                                                    this.data[
                                                                        "pickup"
                                                                    ]
                                                                )
                                                            }}
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div
                                                            class="
																	col-2
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            GROSS WT :
                                                        </div>
                                                        <div class="col-10">
                                                            {{
                                                                this.Ucase(
                                                                    this.data[
                                                                        "gross"
                                                                    ]
                                                                )
                                                            }}
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div
                                                            class="
																	col-2
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            REMARKS :
                                                        </div>
                                                        <div class="col-10">
                                                            {{
                                                                this.Ucase(
                                                                    this.data[
                                                                        "remarks"
                                                                    ]
                                                                )
                                                            }}
                                                        </div>
                                                    </div>

                                                    <div class="row"  v-if="status==='99'">
                                                        <div
                                                            class="
																	col-2
																	text-right
																	font-weight-bold
																"
                                                        >
                                                            STATUS :
                                                        </div>
                                                        <div class="col-10">
                                                           CANCELLED
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- signatories -->
                                        <div
                                            class="meprint pb-5"
                                        >
                                            <div
                                                class="d-flex justify-content-around mt-4"
                                            >
                                                <div
                                                    v-for="(data,
                                                    i) in getSignatories"
                                                    :key="i"
                                                    class=" text-center col-4    text-uppercase 
																	font-weight-bold
																"
                                                >
                                                    <div class="col">
                                                        {{ data.signatories }}
                                                    </div>
                                                    <div class="mt-4">
                                                        {{ data.signee }}
                                                    </div>
                                                    <div
                                                        class="border-top mx-5"
                                                    >
                                                        {{ data.designation }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </page>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-sm btn-primary" @click.prevent="printing()">
                <i class="fa fa-print"></i> Print
            </button>
            <!-- <a
                @click="handleEdit(data['batch'])"
                v-if="status == '01' && this.can('shipping-advice-update')"
                class="btn-sm btn btn-success"
                ><i class="fa fa-edit"></i> Edit</a
            > -->
 
              <a
                @click="handleApprove(data['batch'])"
                v-if="status == '02' && this.can('shipping-advice-approve') || status != '99' && this.can('shipping-approve')" 
                class="btn-sm btn btn-success"
                ><i class="fa fa-edit"></i> Approve</a
            >
 
            <a
                @click="handleCancel(data['batch'])"
                v-if="status == '02' && this.can('transaction-cancel') && status != '99' "
                class="btn-sm btn btn-danger"
                ><i class="fa fa-trash"></i> Cancel</a
            >
            <a @click="$router.back()" class="btn btn-sm btn-secondary">Back</a> 
        </div>
    </div>
</template>

<script>
import print from "print-js";
import Form from "vform";
export default {
    name: "report",
    middleware: "auth",
    props: ["id"],
    data() {
        return {
            totalCol:0, 
            data: null,
            status: "",
            countitems: 0,
            drtotal: 0,
            crtotal: 0,
			status:'',
            form: new Form({
                items: []
            }),
            
            form2: new Form({
                 batch:'',
                 trnmode:'',
                 os_no:'',
            })
        };
    },
    metaInfo() {
        return { title: "Report" };
    },

    computed: {
        totalAmount: function() {
            let sum = 0;

            this.data["items"].forEach(function(item) {
                sum += parseFloat(item.total);
            });
            return sum / 100;
        },

        totalQty: function() {
            let sum = 0;

            this.data["items"].forEach(function(item) {
                sum += parseFloat(item.qty);
            });
            return sum;
        },
        onLoad() {
            this.$store.dispatch("Settings/fetchSignatories", {
                trnmode: "print",
                trntype: "SH001"
            });
        }
    },
    methods: {
       async handleApprove(data){
            const { value: os_no } = await Swal.fire({
                title: 'Enter Order Slip Number',
                input: 'text',
                inputLabel: 'Order Slip Number',
                
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value) {
                    return 'Invalid Order Slip Number'
                    }
                }
            })

            
            if (os_no) {
                this.form2.batch = data;
                this.form2.trnmode = 'log-sp-approved';
                this.form2.os_no = os_no; 
                     Swal.fire({
								position: 'top-end',
								icon: 'success',
								toast:true,
								title: 'successful approved',
								showConfirmButton: false,
								timer: 2500
							})
                await this.form2.post("/api/process/logistic").then((res) => { 
                     this.$router.push({
                        name: "log-shipping-list", 
                    }); 
                 }); 
                // Swal.fire(`Your IP address is ${data}`)
            }

        },
        repType(data) {
            switch (data) {
                case "SH":
                    return true;
                    break;
                default:
                    this.$router.push({
                        name: "dashboard"
                    });
            }
        },
        async handleSubmit() {
            const res = await axios.get("/api/process/logistic", {
                params: { trnmode: "log-sp-report", trntrntype: "", id: this.id }
            });
			this.status = res.data.status;
            this.data = res.data;
            this.totalCol = (40 - res.data['items'].length) <= 0?0:40 - res.data['items'].length;
             
        },
        printing() {
            var style = [
                window.location.origin + "/dist/css/app.css",
                window.location.origin + "/dist/css/print.css"
            ];
            printJS({
                name: "_blank",
                specs: ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
                printable: "printme",
                type: "html",
                css: style,
                //style: "@page {size: 5.5in 8.5in;size: landscape;}",
                // style: "@page {size: 5.5in 4.25in;size: landscape;}",
                style:  "@page {size: 5.5in 8.5in; padding:10px  }",
                // header: "Multiple Images",
                scanStyles: false,
                onPrintDialogClose: () =>
                    console.log("The print dialog was closed"),
                onError: e => console.log(e)
            });
        },
        handleCancel(data){
			Swal.fire({
				title: "Are you sure?",
				text: "You won't be able to revert this!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, delete it!",
			}).then((result) => { 
				if (result.value) { 
                   	this.form.batch= data; 
					this.form.trnmode= "log-sp-cancel";
                    this.form.post("/api/process/logistic")
                    .then(resp =>{
                        this.status = '99' 
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            toast:true,
                            title: 'successful process',
                            showConfirmButton: false,
                            timer: 2500
                        }) 
                           this.$router.push({
                                name: "log-shipping-list", 
                            }); 
						 
					});   
				}
			});
		},
        printVisit(id) {
            this.$htmlToPaper("printme");
            this.$htmlToPaper("printme", () => {
                console.log("Printing completed or was cancelled!");
            });
        }
    },
    mounted() {  
        this.onLoad;
        
        if (this.id == undefined) {
            this.$router.push({
                name: "dashboard"
            });
        } else {
            this.repType(this.id.slice(0, this.id.search("-")));
            this.handleSubmit();
        }
    }
};
</script>

<style></style>
