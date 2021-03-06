
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./JQCloud');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//global components
//flash used for notifications
Vue.component('flash', require('./components/Flash.vue'));
//thread-view used in threads.show as inline template
Vue.component('thread-view', require('./pages/Thread.vue'));
//global pagination
Vue.component('paginator', require('./components/Paginator.vue'));
Vue.component('user-notifications', require('./components/UserNotifications.vue'));
Vue.component('tag-cloud', require('./cloud/Tagcloud.vue'));
Vue.component('date-picker', require('./datepicker/Datepicker.vue'));

const app = new Vue({
    el: '#app'
});