<template>

	<div class="field">
		<label class="label">Events</label>
		<div class="control">
			<div class="select">
				<select v-bind:value="value" v-on:input="$emit('input', $event.target.value)">
					<option disabled value="">Select Age Group</option>
					Loop through the ageGroup options/values pulled in from 'events'
					<option v-for="(value, key, index) in events" v-bind:value="value.eventID">{{value.eventName}}</option>
				</select>
			</div>
		</div>
	</div>
	
		


</template>

<script>
	export default {
		props: ['value'],

		data: function(){
			return {
				events: []
			}
		},

		methods: {

			fetchEvents() {
				this.$http.get('site/Results_con/getEvents')
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