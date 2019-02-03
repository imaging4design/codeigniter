<template>

	<div>
		<v-subheader class="pa-0">Select Year</v-subheader>

		<v-select
			v-on:input="$emit('input', year)"
			v-model="year"
			:hint="`${year}`"
			:items="years"
			name="year"
			item-text="year"
			item-value="year"
			label="Select a Year"
			persistent-hint
			return-object
			single-line
			solo
			color="blue">
        </v-select>

		<!-- <v-select
			v-on:input="$emit('input', select.key)"
			v-model="select"
			:hint="`${select.year}, ${select.year}`"
			:items="years"
			name="ageGroup"
			item-text="year"
			item-value="year"
			label="Select Year"
			persistent-hint
			return-object
			single-line
			color="blue">
		</v-select> -->
	</div>
		
</template>




<script>
	export default {
		//props: ['year'],
		data: function(){
			return {
				year: 2019
			}
		},
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