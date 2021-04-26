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

Vue.mixin({
    data() {
        return {
            datenow: date
        }
    }

});