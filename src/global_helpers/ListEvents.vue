<template>

	<!-- <div class="field">
		<label class="label">Events</label>
		<div class="control">
			<div class="select">
				<select v-on:input="$emit('input', $event.target.value)">
					<option disabled value="">Select Age Group</option>
					Loop through the ageGroup options/values pulled in from 'events'
					<option v-for="(value, key, index) in events" v-bind:value="value.eventID">{{value.eventName}}</option>
				</select>
			</div>
		</div>
	</div> -->

	<section>
		<b-field label="Select Event">
            <b-select placeholder="Select an event" v-model="event.eventID" v-on:input="$emit('input', event.eventID)">
                <option
                    v-for="event in events"
					v-bind:key="event.eventID"
					v-bind:value="event.eventID">
                    {{ event.eventName }}
                </option>
            </b-select>
        </b-field>
	</section>
		


</template>

<script>
	export default {
		//props: ['value'],

		data: function(){
			return {
				events: [],
				event: {
					eventID: '1',
					eventName: null
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