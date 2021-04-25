<template>
    <div>
        <div class="text-center">
            <div class="title mb-4">
                {{ title }}
            </div>
        </div>
        <slot />
    </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    layout: "basic",

    metaInfo() {
        return { title: "Home" };
    },

    data: () => ({
        title: window.config.appName,
    }),

    computed: mapGetters({
        authenticated: "Auth/check",
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
