<template>

	<div>

		<!-- <v-subheader class="pa-0">Select Year</v-subheader> -->
		<v-select
			v-on:change="onHit()"
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
			year: 0
		}
	},
	computed : {
		years () {
			const currentYear = new Date().getFullYear();
			const listYears = Array.from({length: currentYear - 2007}, (value, index) => 2008 + index).reverse();
			console.log(listYears)
			const year=[];
			
			year.push({key: 0, value: "All Years"});

			for(var i=0; i<listYears.length; i++)  {
				year.push({key: listYears[i], value: listYears[i]});
			}
			return year;
		}
	},
	methods: {
		onHit () {
			// Call the 'athleteData' method on the parent
			this.$parent.getAthletePerformances();
		},
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