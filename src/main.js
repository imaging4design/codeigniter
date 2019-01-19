import Vue from 'vue'
import axios from 'axios'
//import Typeahead from 'vue2-typeahead'
import VueRouter from 'vue-router'
import {routes} from './routes'
import App from './App.vue'
import Navigation from './inc/Navigation.vue'

/*
|***********************************************************************
| AXIOS http
|***********************************************************************
*/
// Make axios globally accessible via $http
Vue.prototype.$http = axios;

// Set default URL 
axios.defaults.baseURL = 'http://localhost/codeigniter/';
//axios.defaults.baseURL = 'http://www.dev-anzrankings.org.nz/';

/*
|***********************************************************************
| VUE ROUTER
|***********************************************************************
*/
Vue.config.devtools = true;
// Initialise router
Vue.use(VueRouter);
const router = new VueRouter({
	// hashbang:false,
	// mode: 'history',
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
| VUE GLOBAL FILTERS
|***********************************************************************
*/
Vue.filter('removeLeadZeros', function (value) {
  if (!value) return ''
  value = value.toString()
  return value.replace(/^0+(?!\.|$)/, '');
});

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
