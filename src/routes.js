/*
|***********************************************************************
| Import components
|***********************************************************************
*/
//import ListAgeGroups from './global_helpers/ListAgeGroups';
//import ListRecordType from './global_helpers/ListRecordType';
import App from './App';
import AnnualLists from './pages/AnnualLists';
import TopPerfs from './pages/TopPerfs';
import Records from './pages/Records';
import Profiles from './pages/Profiles';

/*
|***********************************************************************
| Set up array of routes (pointing to the relavant component)
|***********************************************************************
*/
export const routes = [
	{ path: '/', name: 'Default', component: Records },
	{ path: '/annual-lists', name: 'AnnualLists', component: AnnualLists },
	{ path: '/nz-records', name: 'Records', component: Records },
	{ path: '/top-perfs', name: 'TopPerfs', component: TopPerfs },
	{ path: '/profiles', name: 'Profiles', component: Profiles },
	{ path: '*', redirect: '/' }

]


