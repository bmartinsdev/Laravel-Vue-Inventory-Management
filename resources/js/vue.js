/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.Vue = require('vue');

/**
 * Lodash
 */
window._debounce = require('lodash/debounce');
window._throttle = require('lodash/throttle');
window._tail = require('lodash/tail');
window._unionBy = require('lodash/unionBy');
 
/**
 * Notifications
 */
import Notifications from 'vue-notification'
Vue.use(Notifications)

/**
 * LOADING BAR
 */

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
  color: '#414141',
  failedColor: '#874b4b',
  thickness: '5px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  location: 'top',
  inverse: false
})

/**
 * VUE ROUTER 
 */
import VueRouter from 'vue-router'
Vue.use(VueRouter)

let routes = [
    { path: '/', component: require('./pages/inventario.vue').default },
    { path: '/consumiveis', component: require('./pages/consumiveis.vue').default },
		{ path: '/cacifos', component: require('./pages/cacifos.vue').default },
		{ path: '/*', component: require('./pages/lostpage.vue').default }
  ]

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes
})

const app = new Vue({
    el: '#app',
    router,
}).$mount('#app');

