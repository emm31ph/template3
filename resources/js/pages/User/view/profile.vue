<template>
    <card :title="`Update Profile`">
        <form @submit.prevent="update" @keydown="form.onKeydown($event)">
            <alert-success :form="form" message="Update" />

            <!-- Name -->
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right"
                    >Name</label
                >
                <div class="col-md-7">
                    <input
                        v-model="form.name"
                        :class="{ 'is-invalid': form.errors.has('name') }"
                        class="form-control"
                        type="text"
                        name="name"
                    />
                    <has-error :form="form" field="name" />
                </div>
            </div>

            <!-- Email -->
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right"
                    >Email Address</label
                >
                <div class="col-md-7">
                    <input
                        v-model="form.email"
                        :class="{ 'is-invalid': form.errors.has('email') }"
                        class="form-control"
                        type="email"
                        name="email"
                    />
                    <has-error :form="form" field="email" />
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group row">
                <div class="col-md-9 ml-md-auto">
                    <v-button :loading="form.busy" type="success">
                        Update
                    </v-button>
                </div>
            </div>
        </form>
    </card>
</template>

<script>
import Form from "vform";
export default {
    scrollToTop: false,

    metaInfo() {
        return { title: "Settings " };
    },

    data: () => ({
        form: new Form({
            name: "",
            email: "",
        }),
    }),

    created() {
        // Fill the form with user data.
        this.form.keys().forEach((key) => {
            this.form[key] = this.isUser[key];
        });
    },

    methods: {
        async update() {
            const { data } = await this.form.patch("/api/settings/profile");
            this.$store.dispatch("Auth/updateUser", { user: data });
        },
    },
};
</script>
