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
    }

});