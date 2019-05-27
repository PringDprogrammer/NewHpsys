require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import {routes} from './routes';
import StoreData from './store';
import MainApp from './components/MainApp.vue';
import {initialize} from './helpers/general';
import excel from 'vue-excel-export';
import VueHtmlToPaper from 'vue-html-to-paper';



Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(excel);
Vue.use(VueHtmlToPaper);


Vue.directive('uppercase', {
	update (el) {
		el.value = el.value.toUpperCase()
	},
});
const store = new Vuex.Store(StoreData);

const router = new VueRouter({
    routes,
    mode: 'history'
});

initialize(store, router);

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        MainApp
    }
});
