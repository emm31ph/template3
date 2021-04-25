import Vue from 'vue'
import store from '~/store'


const mixinsContext = require.context('~/pages/', true, /\/.*mixins.js$/)

mixinsContext.keys().forEach(fileName => {

    import ('~/pages/' + fileName.replace('./', ''));
})