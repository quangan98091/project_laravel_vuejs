require('./bootstrap');
window.Vue = require('vue');

import 'viewerjs/dist/viewer.css'
import Viewer from 'v-viewer'
Vue.use(Viewer)

import moment from 'moment';
import { Form, HasError, AlertError } from 'vform';
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);

import tinymce from 'vue-tinymce-editor'
Vue.component('tinymce', tinymce)

import Multiselect from 'vue-multiselect'
Vue.component('multiselect', Multiselect)

import ScrollLoader from 'vue-scroll-loader'
Vue.use(ScrollLoader)

import swal from 'sweetalert2'
window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;

import VueRouter from 'vue-router';
Vue.use(VueRouter);
import routes from './routesFontend';
const router = new VueRouter({
    //mode: 'history',
    routes
});

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '5px'
})

import VueCarousel from 'vue-carousel';
Vue.use(VueCarousel);

import VueSocialSharing from 'vue-social-sharing'
Vue.use(VueSocialSharing);

import { ToggleButton } from 'vue-js-toggle-button'
Vue.component('ToggleButton', ToggleButton)

Vue.filter('upText', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
});
Vue.filter('myDate',function(created){
    return moment(created).format('L'); //27/01/2021
});
Vue.filter('historyDate',function(created){
    return moment(created).format('h:mm a, 	DD/MM/YYYY');
});
Vue.filter('historyDay',function(created){
    return moment(created).format('LT');
});


window.Fire =  new Vue();

Vue.component('pagination', require('laravel-vue-pagination'));

Vue.component(
    'not-found',
    require('./components/backend/NotFoundComponent.vue').default
);

import Home from './components/IndexFontend.vue';

const app = new Vue({
    el: '#app',
    router,
    render: h => h(Home),

});
