<template>

	<div>

		<v-subheader class="pa-0">Select List Type</v-subheader>

		<v-select
			v-on:input="$emit('input', select.key)"
			v-model="select"
			:hint="`${select.key}, ${select.value}`"
			:items="items"
			name="list_type"
			item-text="value"
			item-value="key"
			label="Select List Type"
			persistent-hint
			return-object
			single-line
			solo
			color="blue">
		</v-select>

	</div>
		
</template>




<script>
	export default {
		//props: ['value'],
		data: function(){
			return {
				select: { key: '0', value: 'Athlete' },
		        items: [
		          { key: '0', value: 'Athlete' },
		          { key: '1', value: 'Performance' }
		        ]
			}
		}
	};
</script>