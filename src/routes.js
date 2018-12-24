import ListAgeGroups from './global_helpers/ListAgeGroups';
import ListRecordType from './global_helpers/ListRecordType';
import Cmp from './Cmp';
// array of routes
export const routes = [
	{ path: '', component: ListAgeGroups },
	{ path: '/test', component: ListRecordType },
	{ path: '/routes', component: Cmp }
]