<template>
    <card class="text-center">
        <h3 class="mb-4">Page not Found</h3>

        <div class="links">
            <router-link :to="{ name: 'home' }"> Back </router-link>
        </div>
    </card>
</template>

<script>
export default {
    name: "NotFound",
};
</script>
