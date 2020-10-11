/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import { Form, HasError, AlertError } from 'vform'
import moment from 'moment';

import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast;
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

window.Vue = require('vue');

import Vue from 'vue';
import VueRouter from 'vue-router';
import { routes } from './routes';

Vue.use(VueRouter)


// import Select2 Component
import Select2 from 'v-select2-component';
Vue.component('Select2', Select2);

// import bootstrap-vue
import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'


// import multiselect 
import Multiselect from 'vue-multiselect'

Vue.component('multiselect', Multiselect)

//International Phone Numbers
// import TelInput from "vue-tel-input";
// import "vue-tel-input/dist/vue-tel-input.css";
import VueTelInput from 'vue-tel-input';
Vue.use(VueTelInput)

//scroll horizontal when mouse drag
import VueDragscroll from 'vue-dragscroll'
Vue.use(VueDragscroll)

// progress-bar
import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
});

// ck-editor
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import VueCkeditor from 'vue-ckeditor5';

const options = {
    editors: {
      classic: ClassicEditor,
    },
    name: 'ckeditor'
  }
Vue.use(VueCkeditor.plugin, options);

Vue.filter('myDate', function (date) {
    if (date) {
      return moment(date).format("D MMM YYYY");
    }
    return '';
    
  
  });
  Vue.filter('myDateTime', function (cretaed) {
    if(cretaed) {
    return moment(cretaed).format("D MMM YYYY" + ' hh:mm:ss');
    }
    return '';
  });


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

import menuCount from './components/count/MenuCount.vue';
Vue.component('menu-count', menuCount)



const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

window.fire = new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import global from './mixins/Global';
Vue.mixin(global);

import store from '../js/store';

const app = new Vue({
    el: '#app',
    store,
    router
});
