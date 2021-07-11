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
                                                            style="width: 75px"
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
																mt-5
															"
                                                        >
                                                            Reject Document
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

                                            <div class="row pb-2">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <div class="row">
                                                                <div
                                                                    class="
																		col-1
																		px-0
																	"
                                                                >
                                                                    From :
                                                                </div>
                                                                <div
                                                                    v-if="data"
                                                                    class="
																		col-11
																		border-bottom
																		border-dark
																	"
                                                                >
                                                                    {{
                                                                        this.Ucase(
                                                                            this
                                                                                .data[
                                                                                "from"
                                                                            ]
                                                                        )
                                                                    }}
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div
                                                                    class="
																		col-1
																		px-0
																	"
                                                                >
                                                                    To :
                                                                </div>
                                                                <div
                                                                    v-if="data"
                                                                    class="
																		col-11
																		border-bottom
																		border-dark
																	"
                                                                >
                                                                    {{
                                                                        this.Ucase(
                                                                            this
                                                                                .data[
                                                                                "to"
                                                                            ]
                                                                        )
                                                                    }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
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
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div
                                                            class="col-12 px-0"
                                                            style="height: 70px"
                                                        >
                                                            <span
                                                                class="
																	col-1
																	px-0
																"
                                                            >
                                                                Remarks :
                                                            </span>
                                                            <span
                                                                v-if="data"
                                                                class="
																	col-10
																	pl-4
																"
                                                                >{{
                                                                    this.Ucase(
                                                                        this
                                                                            .data[
                                                                            "remarks"
                                                                        ]
                                                                    )
                                                                }}</span
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row h6">
                                                <div class="col-md-12">
                                                    <table class="mytable">
                                                        <thead>
                                                            <tr>
                                                                <th class="
																		text-uppercase
																		small
																		font-weight-bold
																		text-center
																		h5
																	"
                                                                    style="
																		width: 10%;
																	"
                                                                >
                                                                    DR QTY
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
                                                            <tr
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
                                                                                          "drqty"
                                                                                      ]
                                                                                  ),
                                                                                  0
                                                                              )
                                                                            : item[
                                                                                  "drqty"
                                                                              ] ==
                                                                              0
                                                                            ? ""
                                                                            : item[
                                                                                  "drqty"
                                                                              ]
                                                                    }}
                                                                </td>
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
                                                                v-for="i in countitems"
                                                                :key="i + data['hist'].length"
                                                            >
                                                                <td>&nbsp;</td>
                                                                <td></td>
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
                                                                                .drQtyCase,
                                                                            0
                                                                        )
                                                                    }}
                                                                    {{
                                                                        this
                                                                            .drQtyTin !=
                                                                        0
                                                                            ? " & " +
                                                                              formatNumberD(
                                                                                  this
                                                                                      .drQtyTin,
                                                                                  0
                                                                              )
                                                                            : ""
                                                                    }}
                                                                </td>
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
                                            <div class="container-fluid pt-3">
                                                <div class="row">
                                                    <div
                                                        class="
															col-3
															text-center
														"
                                                    >
                                                        <div class="">
                                                            {{
                                                                this.isUser['name']
                                                            }}
                                                        </div>
                                                        <div
                                                            class="
																border-top
																font-weight-bold
																border-dark
															"
                                                        >
                                                            PREPARED BY
                                                        </div>
                                                    </div>
                                                    <div class="col-3"></div>
                                                    <div class="col-3"></div>
                                                    <div
                                                        class="
															col-3
															text-center
														"
                                                    >
                                                        <div class="">
                                                            &nbsp;
                                                        </div>
                                                        <div
                                                            class="
																border-top
																font-weight-bold
																border-dark
															"
                                                        >
                                                            RECEIVED BY
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
				<!-- <a @click="handleEdit(data['batch'])" v-if="status=='01'  && this.can('items-reject-update')" class="btn-sm btn btn-success"
					><i class="fa fa-edit"></i> Edit</a -->
				> 
				
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
export default {
    name: "report",
    middleware: "auth",
   	props: ["id"] ,
    data() {
        return {
            reportName: "", 
            data: null,
            countitems: 0,
            drtotal: 0,
            crtotal: 0
        };
    },
    metaInfo() {
        return { title: "Report" };
    },
    created() {
        this.handleSubmit();
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
        }
    },
    methods: {
        
        handleEdit(data){},
        handleCancel(data){},
        
        async handleSubmit() {
            const res = await axios.get("/api/items/reportItem", {
                params: { id: this.id }
            });
            this.data = res.data;

            const cnt = 11 - res.data["hist"].length;
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
        } ,
        repType(data) {
			switch (data) {
				case "RJ":
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
