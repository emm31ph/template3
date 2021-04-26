<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "item",
    middleware: "auth",
};
</script>

<style>
</style>