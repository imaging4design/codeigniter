import Vue from 'vue'
import axios from 'axios'
import VueRouter from 'vue-router'
import {routes} from './routes'
import VueMoment from 'vue-moment'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css' // Ensure you are using css-loader
import App from './App.vue'
import Navigation from './inc/Navigation.vue'
import GlobalFooter from './inc/GlobalFooter.vue'

/*
|*********************************************************
| VUE BUEFY CSS & JS
|*********************************************************
*/
//Vue.use(Buefy);
// Helpers
import colors from 'vuetify/es5/util/colors'

Vue.use(Vuetify, {
  theme: {
    primary: colors.grey.darken3, // #E53935
    secondary: colors.red.accent3, // #FFCDD2
    accent: colors.orange // #3F51B5
  }
})

/*
|*********************************************************
| VUE MOMENT js
|*********************************************************
*/
Vue.use(VueMoment);

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
	hashbang:false,
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
Vue.component('global-footer', GlobalFooter);

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

Vue.filter('toUpperCase', function (value) {
	if (!value) return ''
	value = value.toString()
	return value.toUpperCase();
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
