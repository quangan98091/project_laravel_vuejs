require('./bootstrap');
window.Vue = require('vue');

import moment from 'moment';
import { Form, HasError, AlertError } from 'vform';
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);


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
import routes from './routes';
const router = new VueRouter({
    // mode: 'history',
    routes
});

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
})


Vue.filter('upText', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
});
Vue.filter('myDate',function(created){
    return moment(created).format('L');
});

window.Fire =  new Vue();

Vue.component('pagination', require('laravel-vue-pagination'));

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

Vue.component(
    'not-found',
    require('./components/backend/NotFoundComponent.vue').default
);

const app = new Vue({
    el: '#app',
    router,
    data: {
        search: ''
    },
    methods: {
        // searchIt: _.debounce(() => {
        //     Fire.$emit('searching');
        // },1000) // có độ trễ
        searchIt() { //không có độ trễ
            Fire.$emit('searching');
        }
    }
});
