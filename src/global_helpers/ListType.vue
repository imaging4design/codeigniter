<template>
	
	<div class="field">
		<label class="label">List Type</label>
		<div class="control" v-for="(value, key, index) in list_type">
			<label>
				<input type="radio" 
				v-bind:checked="key === $route.query.list_type" 
				v-bind:value="key" 
				name="list_type" 
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
				list_type: {
					'0': 'Athlete',
					'1': 'Performances'
				}
			}
		}
	};
</script>