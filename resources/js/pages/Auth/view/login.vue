<template>
	<div class="cotainer">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">Login</div>
					<div class="card-body">
						<form
							@submit.prevent="handleSubmit"
							@keydown="form.onKeydown($event)"
						>
							<div class="form-group row">
								<label
									class="
										col-md-3 col-form-label
										text-md-right
									"
									>Username</label
								>
								<div class="col-md-7">
									<input
										v-model="form.email"
										:class="{
											'is-invalid':
												form.errors.has('email'),
										}"
										class="form-control"
										type="text"
										name="email"
									/>
									<has-error :form="form" field="email" />
								</div>
							</div>

							<!-- Password -->
							<div class="form-group row">
								<label
									class="
										col-md-3 col-form-label
										text-md-right
									"
									>Password</label
								>
								<div class="col-md-7">
									<input
										v-model="form.password"
										:class="{
											'is-invalid':
												form.errors.has('password'),
										}"
										class="form-control"
										type="password"
										name="password"
									/>
									<has-error :form="form" field="password" />
								</div>
							</div>

							<div class="col-md-6 offset-md-4">
								<v-button
									type="submit"
									:loading="form.busy"
									class="btn btn-primary"
								>
									Login
								</v-button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import Cookies from "js-cookie";

import Form from "vform";
export default {
	name: "login",
	middleware: "guest",
	layout: "basic",
	metaInfo() {
		return { title: "Login" };
	},
	data: () => ({
		form: new Form({
			email: "",
			password: "",
		}),
		remember: false,
	}),
	methods: {
		async handleSubmit() {
			const val = [];
			await this.form
				.post("/api/login")
				.then((res) => {
					this.$store.dispatch("Auth/saveToken", {
						token: res.data.token,
					});
					this.$store.dispatch("Auth/fetchUser");
				})
				.catch((error) => {
					Swal.fire({
						position: "top-end",
						icon: "error",
						toast: true,
						title: "Unauthorized",
						showConfirmButton: false,
						timer: 2500,
					});
				});

			this.redirect();
		},
		redirect() {
			const intendedUrl = Cookies.get("intended_url");
			if (intendedUrl) {
				Cookies.remove("intended_url");
				this.$router.push({
					path: intendedUrl,
				});
			} else {
				this.$router.push({
					name: "dashboard",
				});
			}
		},
	},
};
</script>

<style></style>
