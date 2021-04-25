<template>
    <card :title="pagename"> logged in </card>
</template>

<script>
export default {
    middleware: "auth",
    data() {
        return {
            pagename: "dashboard",
        };
    },
    metaInfo() {
        return { title: "dashboard" };
    },
};
</script>
