<template>
	<div>
		<h3>Events</h3>
		<!-- <select v-bind:value="value" v-on:input="$emit('input', $event.target.value)" class="form-control">
			<option disabled value="">Select Age Group</option>
			Loop through the ageGroup options/values pulled in from 'events'
			<option v-for="(value, key, index) in events" v-bind:value="key">{{value}}</option>
		</select> -->

		<div v-for="(value, key, index) in events">
			<label>

				<input type="radio" 
				v-bind:checked="value.eventID === $route.query.eventID" 
				v-bind:value="value.eventID"
				name="eventID" 
				v-on:change="$emit('input', $event.target.value)" > {{value.eventName}}
			</label>
		</div>

	</div>
</template>

<script>
	export default {
		props: ['value.eventID'],

		data: function(){
			return {
				events: []
			}
		},

		methods: {

			fetchEvents() {
				this.$http.get('site/Results_con/getEvents', {
					params: this.queryParams
				})
				.then((response) => {
					this.token = response.data.token;
					this.events = response.data.getEvents;
				})
				.catch((error) => {
					console.error('GAVINS ERROR: ' + error);
				})

				//console.log(this.queryParams.recordType)
			}
		},

		mounted() {
			this.fetchEvents();
		},	

	};


</script>