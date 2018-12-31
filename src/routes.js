/*
|***********************************************************************
| Import components
|***********************************************************************
*/
//import ListAgeGroups from './global_helpers/ListAgeGroups';
//import ListRecordType from './global_helpers/ListRecordType';
import App from './App';
import TopPerfs from './TopPerfs';
import Records from './Records';

/*
|***********************************************************************
| Set up array of routes (pointing to the relavant component)
|***********************************************************************
*/
export const routes = [
	{ path: '/', component: Records },
	{ path: '/records', component: Records },
	{ path: '/top-perfs', component: TopPerfs },
	{ path: '*', redirect: '/' }

]


