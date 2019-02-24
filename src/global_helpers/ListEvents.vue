<template>

	<div>

		<v-subheader class="pa-0">Select Event</v-subheader>

		<v-select
			v-on:input="$emit('input', event.eventID)"
			v-model="event"
			:hint="`${event.eventID}, ${event.eventName}`"
			:items="events"
			name="event"			
			item-text="eventName"
			item-value="eventID"
			label="Select an Event"
			persistent-hint
			return-object
			single-line
			solo
			color="secondary">
		</v-select>

	</div>

</template>

<script>
	export default {
		//props: ['value'],
		data: function(){
			return {
				events: [],
				event: {
					eventID: '1',
					eventName: '100m'
				}
			}
		},

		methods: {

			test() {
				alert(this.value);
			},

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