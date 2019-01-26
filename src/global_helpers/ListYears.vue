<template>

	<div class="field">

		<label class="label">Select Year</label>
		<div class="control" v-for="value in years">
			<label>
				<input type="radio" 
				v-bind:checked="value === value"
				v-bind:value="value"
				name="year" 
				v-on:change="$emit('input', $event.target.value)"> {{value}}
			</label>
		</div>

		<!-- <label class="label">Select Year</label>
		<div class="control" v-for="(value, key, index) in year">
			<label>
				<input type="radio" 
				v-bind:checked="key === $route.query.year" 
				v-bind:value="key" 
				name="year" 
				v-on:change="$emit('input', $event.target.value)"> {{value}}
			</label>
		</div> -->
	</div>

		
</template>




<script>
	export default {
		//props: ['year'],
		
		computed : {
			years () {
				const year = new Date().getFullYear()
				return Array.from({length: year - 2012}, (value, index) => 2013 + index)
			}
		}

	};
</script>

<style lang="scss" scoped>
	h1 {
		strong {
			font-size: 30px;
			color: green;
		}
	}
</style>