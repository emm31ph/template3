<template>
    <div class="meprint1 pb-5">
        <div class="d-flex justify-content-around mt-4">
            <div
                v-for="(data, i) in getSignatories"
                :key="i"
                class="text-center col-4 font-weight-bold"
            >
                <div class="col">
                   &nbsp; {{ data.signatories }} &nbsp;
                </div>
                <div class="mt-4">
                 &nbsp; {{ data.signee }} &nbsp;
                </div>
                <div class="border-top mx-5">
                   &nbsp; {{ data.designation }} &nbsp;
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {};
</script>

<style>
</style>