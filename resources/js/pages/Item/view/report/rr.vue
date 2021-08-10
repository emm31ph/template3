<template>
    <div>
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
																h5
																font-weight-bold
																mb-1
																mt-2
															"
                                                        >
                                                            Recieving Report Transaction
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="col-3 text-right"
                                                    >
                                                        <p
                                                            class="
																font-weight-bold
																mb-1
															"
                                                        >
                                                            {{
                                                                this.data[
                                                                    "batch"
                                                                ]
                                                            }}
                                                        </p>
                                                        <sub
                                                            class="
																text-muted
																mb-1
															"
                                                        >
                                                            Printed Date:
                                                            {{ this.dateTime }}
                                                        </sub>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="my-2" />

                                            <div class="row pb-2">
                                                <div class="container-fluid">
                                                    <div class="row">
														<div class="col-6">
															<div class="row">
																<div
																	class="
																		col-2
																		px-0
																	"
																>
																	Supplier :
																</div>
																<div
																	v-if="data"
																	class="
																		col-10
																		border-bottom
																		border-dark
																	"
																>
																	{{
																		this.Ucase(
																			this
																				.data[
																				"customer"
																			]
																		)
																	}}
																</div>
															</div>
															<div class="row">
																<div
																	class="
																		col-2
																		px-0
																	"
																>
																	Van No. :
																</div>
																<div
																	v-if="data"
																	class="
																		col-10
																		border-bottom
																		border-dark
																	"
																>
																	{{
																		this.Ucase(
																			this
																				.data[
																				"van_no"
																			]
																		)
																	}}
																</div>
															</div>
															<div class="row">
																<div
																	class="
																		col-2
																		px-0
																	"
																>
																	Seal No. :
																</div>
																<div
																	v-if="data"
																	class="
																		col-10
																		border-bottom
																		border-dark
																	"
																>
																	{{
																		this.Ucase(
																			this
																				.data[
																				"seal_no"
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
																		col-3
																		text-right
																	"
																>
																	Date :
																</div>
																<div
																	v-if="data"
																	class="
																		col-9
																		border-bottom
																		border-dark
																	"
																>
																	{{
																		this
																			.data[
																			"trndate"
																		]
																	}}
																</div>
															</div>
															<div class="row">
																<div
																	class="
																		col-3
																		text-right
																	"
																>
																	RS No :
																</div>
																<div
																	v-if="data"
																	class="
																		col-9
																		border-bottom
																		border-dark
																	"
																>
																	{{
																		this.Ucase(
																			this
																				.data[
																				"refno"
																			]
																		)
																	}}
																</div>
															</div>

															<div class="row">
																<div
																	class="
																		col-3
																		text-right
																	"
																>
																	Remarks :
																</div>
																<div
																	v-if="data"
																	class="
																		col-9
																		border-dark
																	" 
																>
																	{{
																		this.Ucase(
																			this
																				.data[
																				"remarks"
																			]
																		)
																	}}                
																</div>
															</div>
														</div>
													</div>
                                                </div>
                                            </div>

 <!-- start  -->
                                        <div class="row mt-1 mb-3">
                                            <div class="col p-3 d-flex justify-content-center">
                                                  <div  style="width:90%" >
                                                    <table class="mytable  w-100 " >
                                                        <thead>
                                                            <tr> 
                                                                <th
                                                                    class="
																		text-uppercase
																		small
																		font-weight-bold
																		text-center
																	"
                                                                    style="
																		width: 10%;
																	"
                                                                >
                                                                    CR QTY
                                                                </th>
                                                                <th
                                                                    class="
																		text-uppercase
																		small
																		font-weight-bold
																		text-center
																	"
                                                                    style="
																		width: 10%;
																	"
                                                                >
                                                                    UNIT
                                                                </th>
                                                                <th
                                                                    class="
																		text-uppercase
																		small
																		font-weight-bold
																		text-center
																	"
                                                                >
                                                                    Description
                                                                </th>
                                                                <th
                                                                    class="
																		text-uppercase
																		small
																		font-weight-bold
																		text-center
																	"
                                                                    style="
																		width: 10%;
																	"
                                                                >
                                                                    EXPIRY DATE
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody v-if="data">
                                                             <tr style="line-height: 15px;"
                                                                class="
																	text-center
																"
                                                                v-for="(item,
                                                                i) in data[
                                                                    'hist'
                                                                ]"
                                                                :key="i"
                                                            > 
                                                                <td> 
                                                                    {{
                                                                        item[
                                                                            "unit"
                                                                        ] !=
                                                                        "TIN"
                                                                            ? formatNumberD(
                                                                                  toCase(
                                                                                      item[
                                                                                          "numperuompu"
                                                                                      ],
                                                                                      item[
                                                                                          "crqty"
                                                                                      ]
                                                                                  ),
                                                                                  0
                                                                              )
                                                                            : item[
                                                                                  "crqty"
                                                                              ] ==
                                                                              0
                                                                            ? ""
                                                                            : item[
                                                                                  "crqty"
                                                                              ]
                                                                    }}
                                                                </td>
                                                                <td>
                                                                    {{
                                                                        Ucase(
                                                                            item[
                                                                                "unit"
                                                                            ]
                                                                        )
                                                                    }}
                                                                </td>
                                                                <td
                                                                    class="
																		text-left
																	"
                                                                >
                                                                    {{
                                                                        Ucase(
                                                                            item[
                                                                                "itemdesc"
                                                                            ]
                                                                        )
                                                                    }}
                                                                </td>
                                                                <td>
                                                                    {{
                                                                        item[
                                                                            "expdate"
                                                                        ]
                                                                    }}
                                                                </td>
                                                            </tr>
                                                            <tr
                                                                v-for="e in countitems"
                                                                :key="e + data['hist'].length"
                                                            >
                                                                <td>&nbsp;</td> 
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot
                                                            class="
																text-center
																font-weight-bold
															"
                                                        >
                                                            <tr> 
                                                                <td>
                                                                    {{
                                                                        formatNumberD(
                                                                            this
                                                                                .crQtyCase,
                                                                            0
                                                                        )
                                                                    }}
                                                                    {{
                                                                        this
                                                                            .crQtyTin !=
                                                                        0
                                                                            ? " & " +
                                                                              formatNumberD(
                                                                                  this
                                                                                      .crQtyTin,
                                                                                  0
                                                                              )
                                                                            : ""
                                                                    }}
                                                                </td>
                                                                <td
                                                                    colspan="3"
                                                                    style="
																		border-bottom: 0px;
																		border-right: 0px;
																	"
                                                                ></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- signatories -->
                                                <div class="meprint pb-5"  >
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
                 <button
					class="btn btn-sm btn-primary"
					@click.prevent="printing()"
				>
					<i class="fa fa-print"></i> Print
				</button>  
				<!-- <a @click="handleEdit(data['batch'])" v-if="status=='01'  && this.can('items-rr-update')" class="btn-sm btn btn-success"
					><i class="fa fa-edit"></i> Edit</a> -->
			 
				
				<a @click="handleCancel(data['batch'])" v-if="status=='01'  && this.can('transaction-cancel')" class="btn-sm btn btn-danger"
					><i class="fa fa-trash"></i> Cancel</a
				> 
				<a @click="$router.back()" class="btn btn-sm btn-secondary" >Back</a>
            </div>
        </div>
    </div>
</template>

<script>
import print from "print-js";
import Form from "vform";
export default {
    name: "report",
    middleware: "auth",
   	props: ["id"] ,
    data() {
        return {
            reportName: "",
            // id: this.$route.params.id,
            data: null,
            countitems: 0,
            itemlen: 0,
            drtotal: 0,
            crtotal: 0,
            status:'',
            form: new Form({
				items:[], 
			}),
        };
    },
    metaInfo() {
        return { title: "Report" };
    }, 
    computed: {
        
        drQtyCase: function() {
            let sum = 0;

            this.data["hist"].forEach(function(item) {
                if (item.unit != "TIN") {
                    sum += parseFloat(
                        (item.drqty > 0 ? 1 : -1) *
                            (Math.floor(
                                item.drqty /
                                    ((item.drqty >= 0 ? 1 : -1) *
                                        item.numperuompu)
                            ) +
                                (item.drqty %
                                    ((item.drqty >= 0 ? 1 : -1) *
                                        item.numperuompu)) /
                                    ((item.drqty >= 0 ? 1 : -1) * 100))
                    );
                }
            });
            return sum;
        },
        drQtyTin: function() {
            let sum = 0;

            this.data["hist"].forEach(function(item) {
                if (item.unit == "TIN") {
                    sum += parseFloat(item.drqty);
                }
            });
            return sum;
        },
        crQtyCase: function() {
            let sum = 0;

            this.data["hist"].forEach(function(item) {
                if (item.unit != "TIN") {
                    sum += parseFloat(
                        (item.crqty > 0 ? 1 : -1) *
                            (Math.floor(
                                item.crqty /
                                    ((item.crqty >= 0 ? 1 : -1) *
                                        item.numperuompu)
                            ) +
                                (item.crqty %
                                    ((item.crqty >= 0 ? 1 : -1) *
                                        item.numperuompu)) /
                                    ((item.crqty >= 0 ? 1 : -1) * 100))
                    );
                }
            });
            return sum;
        },
        crQtyTin: function() {
            let sum = 0;

            this.data["hist"].forEach(function(item) {
                if (item.unit == "TIN") {
                    sum += parseFloat(item.crqty);
                }
            });
            return sum;
        },
        onLoad() { 
            this.$store.dispatch("Settings/fetchSignatories", {
                trnmode: "print",
                trntype: "RR001"
            });
        }

    },
    methods: {
        handleEdit(data){},
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
						axios.get("/api/items/reportItem", {
						params: { id: data },
					}).then(res => {
						 
						this.form.batch= data;
						this.form.trndate= this.datenow;
						this.form.trnmode= "CANCEL";
						this.form.customer= res.data.customer;
						this.form.userid= this.isUser.id;
						this.form.rono= res.data.rono;
						this.form.refno= res.data.refno;
						this.form.from= res.data.from;
						this.form.to= res.data.to;
						this.form.van_no= res.data.van_no;
						this.form.seal_no= res.data.seal_no; 
						this.form.remarks= 'Base '+data;
						for (let i = 0; i < res.data.hist.length; i++) {
						this.form.items.push( 
							{
								drqty: res.data.hist[i].crQtyCase,
								crqty: res.data.hist[i].drQtyCase,
								trntype: "CN",
								itemdesc: res.data.hist[i].itemdesc,
								branch: res.data.hist[i].branch,
								itemcode: res.data.hist[i].itemcode,
								expdate: res.data.hist[i].expdate,
								unit: res.data.hist[i].unit,
								numperuompu: res.data.hist[i].numperuompu
							})
						};
							this.form.post("/api/items/cancel-trans")
							.then(resp =>{ 
                                	 Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        toast:true,
                                        title: 'successful process',
                                        showConfirmButton: false,
                                        timer: 2500
                                    })
                                    this.$router.push({
                                        name: "report-can",
                                        params: { id: resp.data.id },
                                    }); 
							});
					});   
				}
			});
        },
        async handleSubmit() {
            const res = await axios.get("/api/items/reportItem", {
                params: { id: this.id }
            });
            this.data = res.data; 
            this.status = res.data.status;
            const cnt = 11 - res.data["hist"].length;
            this.itemlen = res.data["hist"].length;
            this.countitems = cnt > 0 ? cnt : 0;
           
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
                style: "@page {size: 5.5in 8.5in;size: portrait}",
                // header: "Multiple Images",
                scanStyles: false,
                onPrintDialogClose: () =>
                    console.log("The print dialog was closed"),
                onError: e => console.log(e)
            });
        },
        printVisit(id) {
            this.$htmlToPaper("printme");
            this.$htmlToPaper("printme", () => {
                console.log("Printing completed or was cancelled!");
            });
        },
        repType(data) {
			switch (data) {
				case "RR":
					return true;
					break; 
				default:
					this.$router.push({
						name: "dashboard" 
					});
			}
		}, 
    },
    mounted(){  
        this.onLoad;
        if(this.id==undefined){
        	this.$router.push({
				name: "dashboard" 
			});
        }else{ 
            this.repType(this.id.slice(0, this.id.search("-")));
			this.handleSubmit(); 
        }
    }
};
</script>

<style></style>
