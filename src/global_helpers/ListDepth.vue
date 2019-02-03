<template>

	<div>

		<v-subheader class="pa-0">Select List Depth</v-subheader>

		<v-select
			v-on:input="$emit('input', select.key)"
			v-model="select"
			:hint="`${select.key}, ${select.value}`"
			:items="items"
			name="list_depth"
			item-text="value"
			item-value="key"
			label="Select List Depth"
			persistent-hint
			return-object
			single-line
			solo
			color="primary">
		</v-select>

	</div>

</template>




<script>
	export default {
		//props: ['value'],
		data: function(){
			return {
				select: { key: '50', value: '50' },
		        items: [
		          { key: '10', value: '10' },
		          { key: '50', value: '50' },
		          { key: '250', value: 'ALL' }
		        ]
			}
		}
	};
</script>