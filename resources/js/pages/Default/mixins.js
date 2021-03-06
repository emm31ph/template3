import Vue from 'vue'
import store from '~/store'
import axios from 'axios'
const today = new Date();
const date = (
    today.getFullYear() +
    "-" +
    ("0" + (today.getMonth() + 1)).slice(-2) +
    "-" +
    today.getDate()
).toString();
var moment = require('moment');
Vue.mixin({
    data() {
        return {
            datenow: moment(today).format('YYYY-MM-DD'),
            dateTime: moment(today).format('DD MMMM, YYYY h:mm a')
        }
    },
    methods: {
        pluck(objs, name) {
            var sol = [];
            for (var i in objs) {
                if (objs[i].hasOwnProperty(name)) { 
                    sol.push(objs[i][name]);
                }
            }
            return sol;
        },
        signalChange: function (evt) {
            (this.$emit("change", evt));
        },
        dateF(date) {
            return moment(date).format('YYYY-MM-DD')
        },
        longDate(date) { return moment(date).format('DD MMMM, YYYY h:mm a') },
        monthday(date, addless) {
            if (addless < 0) {
                return moment(date).add(addless, 'd').format('MMMM DD')
            } else {
                return moment(date).subtract(addless, 'd').format('MMMM DD')
            }

        },
        monthdayyear(date, addless) {
            if (addless < 0) {
                return moment(date).add(addless, 'd').format('YYYY-MM-DD')
            } else {
                return moment(date).subtract(addless, 'd').format('YYYY-MM-DD')
            }

        },
        toIntR(data){
          
            return data.toString().replace(/[^0-9]/g,'');
        },
        isNumber: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
              evt.preventDefault();;
            } else {
              return true;
            }
          },
          formatPrice(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }
    }


});