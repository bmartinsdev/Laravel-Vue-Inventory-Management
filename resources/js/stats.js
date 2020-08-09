/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.Vue = require('vue');
 
Vue.component(
  'stats-inv',
  require('./pages/statsinv.vue').default
);

Vue.component(
  'stats-room',
  require('./pages/statsroom.vue').default
);

Vue.component(
  'stats-consumiveis',
  require('./pages/statsconsumiveis.vue').default
);

Vue.component(
  'logs-list',
  require('./pages/logslist.vue').default
);

window.addEventListener('load', function () {
	const app = new Vue({
			el: '#app'
	}).$mount('#app');
})

