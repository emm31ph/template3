<template>
	<div>
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Roles  </h6>

				<h6 class="m-0 font-weight-bold text-primary" v-if="can('role-create')">
					<a @click="openModalWindow">
						<i class="fas fa-cogs"></i>
					</a>
				</h6>
			</div>
			<div class="col card-body d-flex flex-wrap">
				<div
					class="col-3 px-1 py-1" 
					v-for="role in filteredRoles"
					:key="role.id"
				>
					<div class="card-body position-relative border">
						<a v-if="can('role-update')"
								href="#"
								@click="editModalWindow(role)"
								class="button is-light position-absolute pr-2"
								style="right: 0px;"
								><i class="fa fa-edit blue"></i></a
							>
						<h5 class="card-title">{{ role.display_name }}</h5>
						
						<h6 class="card-subtitle mb-2 text-muted">
							<em>{{ role.name }}</em>
						</h6>
						<p class="card-text">{{ role.description }}</p>
					</div> 
				</div>
				
			</div>
			<div class="ml-4">
					 
					<vue-plain-pagination
						v-if="allRoles"
						v-model="currentPage"
						:page-count="totalPages"
						:classes="bootstrapPaginationClasses"
						:labels="customLabels"
					/>
				</div>
		</div>

		<!-- Modal -->
		<div v-if="showModal">
			<transition name="modal">
				<div class="modal-mask">
					<div class="modal-wrapper">
						<div class="modal-dialog modal-lg">
							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<h5
										v-show="!editMode"
										class="modal-title"
										id="addNewLabel"
									>
										Add New User
									</h5>
									<h5
										v-show="editMode"
										class="modal-title"
										id="addNewLabel"
									>
										Update User
									</h5>

									<button
										type="button"
										class="close"
										data-dismiss="modal"
										@click="closeModal"
									>
										&times;
									</button>
								</div>
								<form
									@submit.prevent="editMode ? updateUser(form.id) : createRole()"
									@keydown="form.onKeydown($event)"
								>
									<div class="modal-body">
										<div class="row">
											<div class="col-4">
												<h5 class="card-title">
													<b>Role Details:</b>
												</h5>
												<div class="form-group">
													<label for="display_name"
														>Name (Human Readable)</label
													>
													<input
														v-model="form.display_name"
														type="text"
														name="display_name"
														placeholder="Display Name"
														class="form-control"
														:class="{
															'is-invalid': form.errors.has(
																'display_name'
															),
														}"
													/>
													<has-error
														:form="form"
														field="display_name"
													></has-error>
												</div>

												<div class="form-group">
													<label for="name"
														>Slug (Can not be changed)</label
													>
													<input
														v-model="form.name"
														type="test"
														name="name"
														placeholder="Name"
														class="form-control"
														:disabled="editMode"
														:class="{
															'is-invalid': form.errors.has(
																'name'
															),
														}"
													/>
													<has-error
														:form="form"
														field="name"
													></has-error>
												</div>

												<div class="form-group">
													<label for="description"
														>Description</label
													>
													<input
														v-model="form.description"
														type="test"
														name="description"
														placeholder="Description"
														class="form-control"
														:class="{
															'is-invalid': form.errors.has(
																'description'
															),
														}"
													/>
													<has-error
														:form="form"
														field="description"
													></has-error>
												</div>
											</div>
											<div class="col-8">
												<h5 class="card-title">
													<b>Permissions:</b>
												</h5>
												<p class="card-text">
													<ul class="list-group">
														<li class="list-group-item"  v-for="data in getPermissions" :key="data.id">
															
																<div class="form-check">
																<input class="form-check-input" type="checkbox" :value="data.id" v-model="form.permission" :id="data.id">
																<label class="form-check-label" :for="data.id">
																	{{data.display_name}}
																</label>
																</div>
															
															
														</li>
													</ul>
												</p>
											</div>
										</div>
									</div>
									<div class="modal-footer
											d-flex
											flex-row-reverse">
										<button
											type="button"
											class="btn btn-danger"
											data-dismiss="modal"
											@click="closeModal"
										>
											Close
										</button>
										<button
											v-show="editMode"
											type="submit"
											class="btn btn-primary"
										>
											Update
										</button>
										<button
											v-show="!editMode"
											type="submit"
											class="btn btn-primary"
										>
											Create
										</button>
									</div>
			
								</form>
							</div>
						</div>
					</div>
				</div>
			</transition>
		</div> 
	</div>
</template>

<script>
import Form from "vform";
import bus from "../../../EventBus";
export default {
    name: "UsersList",
    middleware: "auth",
    data() {
        return {
            showModal: false,
            pagename: "Users",
            editMode: false,
            value: [],

            form: new Form({
                id: "",
                display_name: "",
                name: "",
                description: "",
                permission: [],
            }),
            query: "",
            page: 1,
            items: 6,
            currentPage: 1,
            postsPerPage: 20,
            sortBy: "",
            sortDirection: "desc",
            bootstrapPaginationClasses: {
                // http://getbootstrap.com/docs/4.1/components/pagination/
                ul: "pagination",
                li: "page-item",
                liActive: "active",
                liDisable: "disabled",
                button: "page-link",
            },
            customLabels: {
                first: "First",
                prev: "Previous",
                next: "Next",
                last: "Last",
            },
        };
    },

    created() {
        this.isLoggedCheck;
    },
    metaInfo() {
        return { title: "Users" };
    },
    methods: {
        editModalWindow(role) {
            this.form.clear();
            this.form.reset();
            this.editMode = true;
            this.showModal = true;
            this.form.fill(role);

            this.form.permission = this.pluck(role.permissions, "id");
        },
        async updateUser(id) {
            await this.form.put("/api/roles/" + id).then((response) => {
                Swal.fire({
                    title: "User created successfully",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1500,
                });
                this.fetchRoles();
                this.closeModal();
            });
        },
        openModalWindow() {
            this.showModal = true;
            this.editMode = false;
            this.form.reset();
        },
        createRole() {
            this.form.post("/api/roles").then((res) => {
                Swal.fire({
                    title: "Role created successfully",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1500,
                });
                this.fetchRoles();
                this.closeModal();
            });
        },
        closeModal() {
            this.showModal = false;
            this.form.errors.errors = "";
        },
        deleteRole(id) {
            // Swal.fire({
            // 	title: "Are you sure?",
            // 	text: "You won't be able to revert this!",
            // 	icon: "warning",
            // 	showCancelButton: true,
            // 	confirmButtonColor: "#3085d6",
            // 	cancelButtonColor: "#d33",
            // 	confirmButtonText: "Yes, delete it!",
            // }).then((result) => {
            // 	if (result.value) {
            // 		//Send Request to server
            // 		this.form
            // 			.delete("/api/user/" + id)
            // 			.then((response) => {
            // 				Swal.fire(
            // 					"Deleted!",
            // 					"User deleted successfully",
            // 					"success"
            // 				);
            // 				this.fetchRoles();
            // 			})
            // 			.catch(() => {
            // 				Swal.fire({
            // 					icon: "error",
            // 					title: "Oops...",
            // 					text: "Something went wrong!",
            // 					footer: "<a href>Why do I have this issue?</a>",
            // 				});
            // 			});
            // 	}
            // });
        },
        sort: function (s) {
            if (s.toLowerCase() === this.sortBy) {
                this.sortDirection =
                    this.sortDirection === "asc" ? "desc" : "asc";
            }
            this.sortBy = s;
        },
        matches() {
            this.$emit("change", this.query);
            if (this.query == "") {
                return [];
            }

            return this.filteredRoles.filter(
                (item) =>
                    item["display_name"].toLowerCase().startsWith(this.query) //search start left side
                // .includes(this.query.toLowerCase()) //search match letter
            );
        },
    },

    mounted() {
        this.isAbleToAuth(["role-*"]);
        this.fetchRoles();
        this.fetchPermissions();

        this.currentPage = 1;
        bus.$on("send", (data) => {
            this.query = data;
        });
    },

    computed: {
        allRoles() {
            const data = this.getRoles ? this.getRoles : "";

            if (this.getRoles != "undefined ") {
                this.$emit("change", this.query);
                if (!this.query == "") {
                    return data
                        .filter(
                            (item) =>
                                item["name"]
                                    .toLowerCase()
                                    // .startsWith(this.query) //search start left side
                                    .includes(this.query.toLowerCase()) //search match letter
                        )
                        .sort((p1, p2) => {
                            let modifier = 1;
                            if (p1[this.sortBy] != undefined) {
                                if (this.sortDirection === "desc")
                                    modifier = -1;
                                if (parseInt(p1[this.sortBy])) {
                                    if (p1[this.sortBy] < p2[this.sortBy])
                                        return -1 * modifier;
                                    if (p1[this.sortBy] > p2[this.sortBy])
                                        return 1 * modifier;
                                } else {
                                    if (
                                        p1[this.sortBy]
                                            .toString()
                                            .toLowerCase() <
                                        p2[this.sortBy].toString().toLowerCase()
                                    )
                                        return -1 * modifier;
                                    if (
                                        p1[this.sortBy]
                                            .toString()
                                            .toLowerCase() >
                                        p2[this.sortBy].toString().toLowerCase()
                                    )
                                        return 1 * modifier;
                                }
                            }
                            return 0;
                        });
                } else {
                    // return Object.keys(data).map((itemcode) => data[itemcode]);
                    return Object.keys(data)
                        .map((name) => data[name])
                        .sort((p1, p2) => {
                            let modifier = 1;
                            if (p1[this.sortBy] != undefined) {
                                if (this.sortDirection === "desc")
                                    modifier = -1;
                                if (parseInt(p1[this.sortBy])) {
                                    if (p1[this.sortBy] < p2[this.sortBy])
                                        return -1 * modifier;
                                    if (p1[this.sortBy] > p2[this.sortBy])
                                        return 1 * modifier;
                                } else {
                                    if (
                                        p1[this.sortBy]
                                            .toString()
                                            .toLowerCase() <
                                        p2[this.sortBy].toString().toLowerCase()
                                    )
                                        return -1 * modifier;
                                    if (
                                        p1[this.sortBy]
                                            .toString()
                                            .toLowerCase() >
                                        p2[this.sortBy].toString().toLowerCase()
                                    )
                                        return 1 * modifier;
                                }
                            }
                            return 0;
                        });
                }
            }

            return false;
        },
        filteredRoles() {
            var page = this.currentPage;
            var perPage = this.postsPerPage;
            var from = page * perPage - perPage;
            var to = page * perPage;
            return this.allRoles.slice(from, to);
        },
        totalPages() {
            return Math.ceil(this.allRoles.length / this.postsPerPage);
        },
    },
};
</script> 

<style>
.list-group {
    max-height: 400px;
    margin-bottom: 10px;
    overflow-y: scroll;
    -webkit-overflow-scrolling: touch;
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
