/*
|***********************************************************************
| Import components
|***********************************************************************
*/
import ListAgeGroups from './global_helpers/ListAgeGroups';
import ListRecordType from './global_helpers/ListRecordType';
import TestVue from './TestVue';

/*
|***********************************************************************
| Set up array of routes (pointing to the relavant component)
|***********************************************************************
*/
export const routes = [
	{ path: '', component: ListAgeGroups },
	{ path: '/test', component: ListRecordType },
	{ path: '/routes', component: TestVue }
]