<template>
    <div>
        <div class="text-center">
            <div class="title mb-4">Contact</div>
        </div>
    </div>
</template>

<script>
export default {
    layout: "basic",

    metaInfo() {
        return { title: "Contact" };
    },

    data: () => ({
        title: window.config.appName,
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
