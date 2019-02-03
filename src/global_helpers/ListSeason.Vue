<template>
	<div>

		<v-subheader class="pa-0">Select Season</v-subheader>

		<v-select
			v-on:input="$emit('input', select.key)"
			v-model="select"
			:hint="`${select.key}, ${select.value}`"
			:items="items"
			name="in_out"
			item-text="value"
			item-value="key"
			label="Select Season"
			persistent-hint
			return-object
			single-line
			color="blue">
		</v-select>

	</div>
</template>



<script>
  export default {
    data () {
      return {
        select: { key: 'out', value: 'Outdoors' },
        items: [
          { key: 'in', value: 'Indoors' },
          { key: 'out', value: 'Outdoors' }
        ]
      }
    }
  }
</script>