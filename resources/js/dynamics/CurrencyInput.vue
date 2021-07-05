<template>
   <div>
         <input type="text" v-model="displayValue"   
            @blur="onBlurHandler"
            @input="onInputHandler"
            @focus="onFocusHandler"
            @change="onChangeHandler"/>
    </div>
</template>

<script>
export default {
    name:'CurrencyInput',
    props: ["value"],
    data: function() {
        return {
            amount: '',
            isInputActive: false
        }
    },
    computed: {
        
        }
    
}
</script>

<style>
input{
    width: 100%;
    height: 100%;
    top:0;
    border: 0;
}
</style>