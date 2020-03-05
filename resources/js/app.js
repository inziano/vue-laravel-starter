require('./bootstrap');

import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'

import router from './routes'
import store from './store'

import App from './components/AppComponent'

Vue.use(VueRouter)
Vue.use(Vuex)


const app = new Vue({
    el: '#app',
    components: {App},
    router: router,
    store
})