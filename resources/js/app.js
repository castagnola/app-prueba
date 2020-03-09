/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
/**
 * Imports
 */
import { Form, HasError, AlertError } from 'vform';
import router from './routes';
import Gate from "./Gate/gate";
import swal from 'sweetalert2';
import moment from 'moment';
import Vue from 'vue'

/**
 * Globals uses
 */

Vue.component(AlertError.name, AlertError)
Vue.component(HasError.name, HasError)
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.prototype.$gate = new Gate(window.user);

window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});

window.toast = toast;
window.vm =  new Vue();
window.Form = Form;


Vue.filter('upText', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
});

Vue.filter('myDate',function(created){

    return moment(created).isValid() ?  moment(created).format('MMMM Do YYYY') : 'N/A';
});

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Render app
 * @type {Vue | CombinedVueInstance<Vue, object, object, object, Record<never, any>>}
 */
const app = new Vue({
    el: '#app',
    router,
});
