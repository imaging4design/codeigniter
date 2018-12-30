import Vue from 'vue'
import axios from 'axios'
import VueRouter from 'vue-router'
import {routes} from './routes'
import App from './App.vue'
import Navigation from './Navigation.vue'

/*
|***********************************************************************
| AXIOS http
|***********************************************************************
*/
// Make axios globally accessible
Vue.prototype.$http = axios;
// Set default URL
axios.defaults.baseURL = 'http://localhost/codeigniter/';
//axios.defaults.baseURL = 'http://www.dev-anzrankings.org.nz/';

/*
|***********************************************************************
| VUE ROUTER
|***********************************************************************
*/
// Initialise router
Vue.use(VueRouter);
const router = new VueRouter({
	mode: 'history',
	routes: routes
});

/*
|***********************************************************************
| VUE GLOBAL COMPONENTS
|***********************************************************************
*/
// Register global components
Vue.component('navigation', Navigation);

/*
|***********************************************************************
| VUE INSTANCE
|***********************************************************************
*/
new Vue({
  el: '#app',
  router: router,
  render: h => h(App)
})
