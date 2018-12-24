<template>
	<div>
		<h1>Hi I am a template</h1>
		<ul>
			<li v-for="(value, key, index) in age_options">{{value}}</li>
		</ul>
	</div>
</template>

<script>
	export default {
		data: function(){
			return {
				age_options: {
					'MS': 'Mens Open',
					'WS': 'Womens Open',
					'M19': 'Junior Men',
					'W19': 'Junior Women'
				}
			}
		}
	};
</script>