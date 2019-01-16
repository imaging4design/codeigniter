<template>

	<div class="field">
		<label class="label">List Depth</label>
		<div class="control" v-for="(value, key, index) in list_depth">
			<label>
				<input type="radio" 
				v-bind:checked="key === $route.query.list_depth" 
				v-bind:value="key" 
				name="list_depth" 
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
				list_depth: {
					'10': '10',
					'50': '50',
					'250': 'ALL'
				}
			}
		}
	};
</script>