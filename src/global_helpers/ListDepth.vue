<template>

	<section v-on:change="$emit('input', $event.target.value)">

		<b-field >
			<b-radio-button 
				v-for="(value, key, index) in list_depth"
				v-model="radio"				 
				v-bind:native-value="key"
				v-bind:key="key"
				v-bind:checked="key === $route.query.list_depth"
				name="list_depth">
				{{value}}
			</b-radio-button>
		</b-field>

			<b>Selection:</b> {{ radio }}

	</section>

	<!-- <div class="field">
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
	</div> -->

</template>




<script>
	export default {
		//props: ['value'],
		data: function(){
			return {
				radio: '50',
				list_depth: {
					'10': '10',
					'50': '50',
					'250': 'ALL'
				}
			}
		}
	};
</script>