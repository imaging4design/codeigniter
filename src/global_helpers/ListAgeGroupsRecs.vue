<template>
	<div>
		<h3>Age Groups</h3>
		<!-- <select v-bind:value="value" v-on:input="$emit('input', $event.target.value)" class="form-control">
			<option disabled value="">Select Age Group</option>
			Loop through the ageGroup options/values pulled in from 'age_options'
			<option v-for="(value, key, index) in age_options" v-bind:value="key">{{value}}</option>
		</select> -->

		<div v-for="(value, key, index) in age_options">
			<label>
				<input type="radio" 
				v-bind:checked="key === $route.query.ageGroup" 
				v-bind:value="key" 
				name="ageGroup" 
				v-on:change="$emit('input', $event.target.value)" > {{value}}
			</label>
		</div>

	</div>
</template>

<script>
	export default {
		props: ['value'],
		data: function(){
			return {
				age_options: {
					'MS': 'Mens Open',
					'M19': 'Men under 20',
					'M18': 'Men under 19',
					'M17': 'Men under 18',
					'M16': 'Men under 17',
					'WS': 'Womens Open',
					'W19': 'Women under 20',
					'W18': 'Women under 19',
					'W17': 'Women under 18',
					'W16': 'Women under 17'
				}
			}
		}
	};


</script>