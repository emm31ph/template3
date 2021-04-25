<template>
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form @submit.prevent="handleSubmit">
                            <div class="form-group row">
                                <label
                                    for="email_address"
                                    class="col-md-4 col-form-label text-md-right"
                                    >E-Mail Address</label
                                >
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        id="email_address"
                                        class="form-control"
                                        v-model="email"
                                        autofocus
                                    />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label
                                    for="password"
                                    class="col-md-4 col-form-label text-md-right"
                                    >Password</label
                                >
                                <div class="col-md-6">
                                    <input
                                        type="password"
                                        id="password"
                                        class="form-control"
                                        v-model="password"
                                    />
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
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

export default {
    name: "login",
    middleware: "guest",
    layout: "basic",
    metaInfo() {
        return { title: "Login" };
    },
    data() {
        return {
            email: "administrator@app.com",
            password: "password",
        };
    },
    methods: {
        async handleSubmit() {
            const res = await axios.post("/api/login", {
                email: this.email,
                password: this.password,
            });

            this.$store.dispatch("Auth/saveToken", { token: res.data.token });
            await this.$store.dispatch("Auth/fetchUser");
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
