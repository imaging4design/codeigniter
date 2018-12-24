<template>
	<div>
		<h3>Record Type</h3>
		<select v-bind:value="value" v-on:input="$emit('input', $event.target.value)" class="form-control">
			<option disabled value="">Select Record Type</option>
			<!-- Loop through the ageGroup options/values pulled in from 'recordType' -->
			<option v-for="(value, key, index) in recordType" v-bind:value="key">{{value}}</option>
		</select>
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