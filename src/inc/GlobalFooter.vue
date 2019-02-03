<template>
	<v-footer app fixed height="auto" color="blue">
		<v-layout justify-center row wrap>
			<!-- <v-btn v-for="link in links" :key="link" color="white" flat round >
				{{ link }}
			</v-btn> -->
			<v-flex blue darken-1 py-3 text-xs-center white--text xs12 >
				&copy;2019 — <strong>Athletics New Zealand</strong>
			</v-flex>
		</v-layout>
	</v-footer>
</template>

<script>
  export default {
	data: () => ({
	  links: [
		'Home',
		'About Us',
		'Team',
		'Services',
		'Blog',
		'Contact Us'
	  ]
	})
  }
</script>