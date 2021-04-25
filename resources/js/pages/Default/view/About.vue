<template>
    <div>
        <div class="top-right links">
            <router-link :to="{ name: 'home' }"> Home </router-link>

            <router-link :to="{ name: 'about' }"> about </router-link>
            <router-link :to="{ name: 'contact' }"> contact </router-link>
        </div>

        <div class="text-center">
            <div class="title mb-4">About</div>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    layout: "basic",

    metaInfo() {
        return { title: "About" };
    },

    data: () => ({
        title: window.config.appName,
    }),

    computed: mapGetters({
        authenticated: "auth/check",
    }),
};
</script>

<style scoped>
.top-right {
    position: absolute;
    right: 10px;
    top: 18px;
}

.title {
    font-size: 85px;
}
</style>
