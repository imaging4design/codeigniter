import Vue from 'vue'
import VueRouter from 'vue-router'
import {routes} from './routes'
import App from './App.vue'
//import ListRecordType from './ListRecordType.vue'
//import ListAgeGroups from './ListAgeGroups.vue'

Vue.use(VueRouter);

const router = new VueRouter({
	routes: routes
});

//Vue.component('list-record-type', ListRecordType);
//Vue.component('list-age-groups', ListAgeGroups);

new Vue({
  el: '#app',
  router: router,
  render: h => h(App)
})
