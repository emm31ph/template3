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
					<slot name="header"> Select Branch </slot>
					<button
						type="button"
						class="btn-close"
						@click="close"
						aria-label="Close modal"
					>
						x
					</button>
				</header>

				<section class="modal-body  d-flex justify-content-center" id="modalDescription">
					<slot name="body">
						<div class="col-md-6">
							<div class="panel panel-default mb-2">
								<form
									method="POST"
									onsubmit="event.preventDefault();"
									enctype="multipart/form-data"
								>

                                <fieldset class="col">
										<legend>Branch</legend>

										<div class="  d-flex justify-content-center">
											<ul class="list-group col-6" v-if="isUser.myBranch">
                                                <li v-for="(item,i) in isUser.myBranch" :key="i" 
                                                @dblclick="handleDBClick(item)"
                                                class="list-group-item list-group-item-action">
                                                {{item.branchname}}    
                                                </li> 
                                            </ul>
										</div>
									</fieldset>
								 
								</form>
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
			trndate: "",
			datas: [],
			form: new Form({ 
				
			})
		};
	},
	mounted() {
		this.trndate = this.datenow;
        this.fetchBranch(); 
	},
	methods: {
        async handleDBClick(data){
            this.$store.state.Auth.user.branch =data.branch;  
				// const res = await this.form.post("/api/settings/profile");
			this.form.branch = data.branch;
			this.form.id = this.isUser.id; 

			const  userData  = await this.form.patch("/api/user/updateBranch");
			// console.log(userData.data );
			this.$store.dispatch("Auth/updateUser", { user: userData.data });


			this.close();
			if(this.$route.name!='dashboard'){
				this.$router.push({
					name: "dashboard"
				});  
			}
        },
		close() {
			this.$emit("close");
		},
		handleSubmit() {
			axios
				.get("/api/items/myTrn", {
					params: {
						trndate: this.trndate,
					},
				})
				.then((result) => {
				 
					this.datas = result.data;

				})
				.catch((err) => {});
		},
		handleClick(data) { 
			 
			this.datas = [];
			this.$router.push({
				name: "report-view",
				params: { batch: data.batch }
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
	max-height: 700px;
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