import Vue from 'vue'
import axios from 'axios'
import VueRouter from 'vue-router'
import {routes} from './routes'
import App from './App.vue'
import Navigation from './Navigation.vue'

// Make axios globally accessible
Vue.prototype.$http = axios;
axios.defaults.baseURL = 'http://localhost/codeigniter/';

// Initialise router
Vue.use(VueRouter);
const router = new VueRouter({
	routes: routes
});

// Register global components
Vue.component('navigation', Navigation);

new Vue({
  el: '#app',
  router: router,
  render: h => h(App)
})
