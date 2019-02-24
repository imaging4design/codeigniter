<template>

	<div>
		<v-subheader class="pa-0">Select Year</v-subheader>

		<v-select
			v-on:input="$emit('input', year)"
			v-model="year"
			:hint="`${year}`"
			:items="years"
			name="year"
			item-text="value"
			item-value="key"
			label="Select a Year"
			persistent-hint
			single-line
			solo
			color="secondary">
		</v-select>

	</div>
		
</template>




<script>
export default {
	data: function(){
		return {
			year: new Date().getFullYear() // Current year
		}
	},
	computed : {
		years () {
			const currentYear = new Date().getFullYear(); // Current year
			return Array.from({length: currentYear - 2012}, (value, index) => 2013 + index).reverse();
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