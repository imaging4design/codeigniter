<template>

	<div class="field">
		<label class="label">Record Type</label>
		<div class="control" v-for="(value, key, index) in recordType">
			<label>
				<input type="radio" 
				v-bind:checked="key === $route.query.recordType" 
				v-bind:value="key" 
				name="recordType" 
				v-on:change="$emit('input', $event.target.value)"> {{value}}
			</label>
		</div>
	</div>

</template>




<script>
	export default {
		props: ['value'],
		data: function(){
			return {
				recordType: {
					'AC': 'Allcomers',
					'NN': 'NZ National',
					'RR': 'NZ Resident'
				}
			}
		}
	};
</script>