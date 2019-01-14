<template>
	<div>
		<h3>Years</h3>

		<div v-for="(value, key, index) in year">
			<label>
				<input type="radio" 
				v-bind:checked="key === $route.query.year" 
				v-bind:value="key" 
				name="year" 
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
				year: {
					'2012': '2012',
					'2013': '2013',
					'2014': '2014',
					'2015': '2015',
					'2016': '2016',
					'2017': '2017',
					'2018': '2018',
					'2019': '2019'
				}
			}
		}
	};
</script>