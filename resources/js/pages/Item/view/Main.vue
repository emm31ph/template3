<template>
    <div>
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Items</h1>

        <router-view></router-view>
    </div>
</template>

<script>
export default {
    middleware: "auth",
};
</script>

<style>
</style>