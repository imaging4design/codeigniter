<template>
	<div>
		<h2>{{myData}}</h2>
		<hr>
		<list-record-type v-model="recordType"></list-record-type>
		<hr>
	</div>
</template>

<script>
	import ListRecordType from './global_helpers/ListRecordType.vue'
	export default {
		data: function(){
			return {
				myData: 'Gavins data',
				recordType: 'NN'
			}
		},
		components: {
			'ListRecordType': ListRecordType
		}
	};
</script>