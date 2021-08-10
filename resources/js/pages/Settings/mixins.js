import Vue from 'vue'
import store from '~/store'
import axios from 'axios'


import camelCase from 'lodash/camelCase'
import upperFirst from 'lodash/upperFirst'

var moment = require('moment');

Vue.mixin({

    computed: {
        getSignatories() {
            if (this.isUser) { 
                var getSignatories = store.getters['Settings/signatories']
                if (getSignatories) {
                    return getSignatories
                }
            }
            return []
        },
        getBranch() {
            if (this.isUser) { 
                var getBranch = store.getters['Settings/branch']
                if (getBranch) {
                    return getBranch
                }
            }
            return []
        },
        
        getSalesperson() {
            if (this.isUser) { 
                const getSalesperson = store.getters['Settings/salesperson']
                if (getSalesperson) {
                    return getSalesperson
                }
            }
            return []
        },
        getPriceCat() {
            if (this.isUser) { 
                const getPriceCategory = store.getters['Settings/pricecat']
                
                    return getPriceCategory 
            }
            return []
        },
    },
    methods: { 
        getSalesPerson(data){
            if(data){ 
            let val = this.getSalesperson; 
            let val1 = val.filter(el => el.salesperson===data);
                if(val1.length){ 
                    return val1[0]['salespersonname'];
                }  
            }
            return []
        },
        isEmpty(val){
            return (val === undefined || val == null || val.length <= 0) ? true : false;
        },
        getLookup(data){       
            const lookup = store.getters['Settings/lookup'] 
            if(lookup){
            return lookup.filter(el => el.lookup === data)
            }
            return [];
        },
        async fetchLookupMixins() { 
            await this.$store.dispatch("Settings/fetchLookup");
        },

        
        async fetchSalesPerson() { 
            await this.$store.dispatch("Settings/fetchSalesPerson");
        },

        async fetchPriceCategory() {
         
            await this.$store.dispatch("Settings/fetchPriceCategory");
        },
        dataF(value) {
            return moment(value).format('YYYY-MM-DD');
        },
        Ucase(value) {
            return (value || '').toUpperCase()
        },
        async fetchBranch() {
            await this.$store.dispatch("Settings/fetchBranch");
        },
        formatNumber(value) {
            if (value == 0) {
                return null;
            }
            return value.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        },
        formatNumberDis(value) {
            let value1 = Number(value!=null?value:0);
             
            if (value1 == 0) {
                return (0.00).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
            }
            return value1.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        },

        formatNumberD(value, dicimal) {
            if (value == 0) {
                return null;
            }
            if(dicimal==0){

                return value.toLocaleString()
            }
            
            return value.toFixed(dicimal).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        },
        printme() {
            this.$htmlToPaper('printMe')
        },
        validateNumber: (event) => {
            let keyCode = event.keyCode;
            if (keyCode < 48 || keyCode > 57) {
                event.preventDefault();
            }
        },

    }
});