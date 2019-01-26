<template>

	<section>

		<div class="field" v-for="(value, key, index) in list_type" v-on:change="$emit('input', $event.target.value)">

			<b-radio 
				v-model="radio"				 
				v-bind:native-value="key"
				v-bind:value="key"
				v-bind:checked="key === $route.query.list_type"
				type="is-sucess"
				name="list_type">
				{{value}}
			</b-radio>

		</div>

		
			<b>Selection:</b>
			{{ radio }}
		

	</section>
		

	
	<!-- <div class="field">
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
	</div> -->
		
</template>




<script>
	export default {
		//props: ['value'],
		data: function(){
			return {
				radio: '0',
				list_type: {
					'0': 'Athlete',
					'1': 'Performances'
				}
			}
		}
	};
</script>