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
                  <div class="mt-4" v-if="data.signatories =='Approved By'">
                    <input type="text" class="form-control border-0 text-center font-weight-bold" :value="data.signee">
                </div>  
                <div class="mt-4" v-else>
                 
                    <input type="text" class="form-control border-0 text-center font-weight-bold bg-white" readonly :value="data.signee">
                </div> 
                <div class="mx-lg-5 border-10" >
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
.border-10{
    border-top: 1px solid black;
  }
</style>