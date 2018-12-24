<template>
	<div>
		<h3>Age Groups</h3>
		<select v-bind:value="value" v-on:input="$emit('input', $event.target.value)" class="form-control">
			<option disabled value="">Select Age Group</option>
			<!-- Loop through the ageGroup options/values pulled in from 'age_options' -->
			<option v-for="(value, key, index) in age_options" v-bind:value="key">{{value}}</option>
		</select>
	</div>
</template>

<script>
	export default {
		props: ['value'],
		data: function(){
			return {
				age_options: {
					'MS': 'Mens Open',
					'WS': 'Womens Open',
					'M19': 'Junior Men',
					'W19': 'Junior Women'
				}
			}
		}
	};
</script>