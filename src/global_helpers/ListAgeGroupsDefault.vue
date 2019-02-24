<template>

	<div>
		<v-subheader class="pa-0">Select Age Group</v-subheader>

		<v-select
			v-on:input="$emit('input', select.key)"
			v-model="select"
			:hint="`${select.key}, ${select.value}`"
			:items="items"
			name="ageGroup"
			item-text="value"
			item-value="key"
			label="Select Age Group"
			persistent-hint
			return-object
			single-line
			solo
			color="secondary">
		</v-select>
	</div>




	
</template>

<script>
	export default {
		props: ['value'],
		data: function(){
			return {
        		select: { key: 'MS', value: 'Mens Open' },
				items: [
					{ key: 'MS', value: 'Mens Open' },
					{ key: 'M19', value: 'Men under 20' },
					{ key: 'M17', value: 'Men under 18' },
					{ key: 'WS', value: 'Womens Open' },
					{ key: 'W19', value: 'Women under 20' },
					{ key: 'W17', value: 'Women under 18' },
				]
			}
		}
	};


</script>