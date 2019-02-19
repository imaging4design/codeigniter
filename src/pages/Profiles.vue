<template>
	
	<div id="profile">

		

		<list-athletes></list-athletes>





		<!-- 
		|*********************************************************
		| GET ATHLETE EVENTS 
		|*********************************************************
		-->
		<form v-on:submit.prevent>

			<v-container grid-list-xl v-show="athleteData.athleteID">
				<v-layout row wrap>
					<v-flex xs12 md6>
						<h1>{{athleteData.nameFirst}} {{athleteData.nameLast}}: {{athleteData.athleteID}}</h1>
						<ul >
							<li><strong>Athlete: </strong>{{athleteData.nameFirst}} {{athleteData.nameLast}} {{athleteData.athleteID}}</li>
							<!-- <li><strong>Date of Birth: </strong>{{athleteData.birthDate}}</li> -->
							<li><strong>Date of Birth: </strong>{{athleteData.DOB}} ({{formatDuration(athleteData.DOB)}})</li>
							<li><strong>Centre: </strong>{{athleteData.clubName}} ({{athleteData.centreName}})</li>
							<li v-show="athleteData.coach"><strong>Coach: </strong>{{athleteData.coach}}</li>
							<li v-show="athleteData.coach_former"><strong>Former Coach/s: </strong>{{athleteData.coach_former}}</li>
						</ul>
					</v-flex>
		
					
					<v-flex xs12 md6>
						
						<v-subheader class="pa-0">Select Event</v-subheader>

						<v-select
							v-model="queryParams.eventID"
							v-on:change="getAthletePerformances"
							:items="athleteEvents"
							name="queryParams.event"			
							item-text="eventName"
							item-value="eventID"
							label="Select an Event"
							single-line
							solo
							color="blue">
						</v-select>

						<list-years-all v-model="queryParams.year"></list-years-all>

						<v-radio-group v-model="queryParams.order_by" :mandatory="false" v-on:change="getAthletePerformances">
							<v-radio label="Performance" value="0"></v-radio>
							<v-radio label="Latest" value="1"></v-radio>
						</v-radio-group>
						
					</v-flex>
						

				</v-layout>
			</v-container>

		</form>

		

		

		<!-- 
		|*********************************************************
		| BEST PERFORMANCES 
		|*********************************************************
		-->
		<v-data-table
			:headers="headers"
			:items="rankedItems"
			:loading="loading"
			:expand="expand"
			item-key="resultID"
		>

			<v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>

			<template slot="items" slot-scope="props">
				<tr @click="props.expanded = !props.expanded">
					<td>{{ props.item.rank }}</td>
					<td class="text-xs-left">{{ props.item.time | removeLeadZeros }} {{ props.item.distHeight | removeLeadZeros }} {{ props.item.points | removeLeadZeros }} </td>
					<td class="text-xs-left">{{ props.item.wind }} {{ props.item.implement }}</td>
					<td class="text-xs-left">{{ props.item.record }}</td>
					<td class="text-xs-left">{{ props.item.placing }}</td>
					<td class="text-xs-left">{{ props.item.competition }}</td>
					<td class="text-xs-left">{{ props.item.venue }}</td>
					<td class="text-xs-left">{{ props.item.date }}</td>
				</tr>

			</template>
			<template slot="expand" slot-scope="props">
				<v-card flat>
					<v-card-text>IAAF Standard 10.12 | IAAF Standard 10.12</v-card-text>
				</v-card>
			</template>

		</v-data-table>
	
	</div><!-- ENDS profile -->

</template>



<script>
import ListAthletes from '../global_helpers/ListAthletes.vue';
import ListYearsAll from '../global_helpers/ListYearsAll.vue';
//var moment = require('moment')
import moment from 'moment';
export default {
	data() {
		return {
			token: null,

			queryParams: {
				athleteID: null,
				eventID: null,
				year: '0',
				order_by: '1'
			},

			athleteEvents: [],
			athleteData: [],
			bestPerformances: [],

			loading: false,
			expand: false,
			headers: [
				{ text: 'Rank', value: 'rank', sortable: false},
				{ text: 'Perf', align: 'left', sortable: false, value: 'time'},
				{ text: 'Wind', value: 'wind', sortable: false},
				{ text: 'Record', value: 'record', sortable: false},
				{ text: 'Placing', value: 'placing', sortable: false},
				{ text: 'Competition', value: 'competition', sortable: false},
				{ text: 'Venue', value: 'venue', sortable: false},
				{ text: 'Date', value: 'date', sortable: false}
			]
		}
	},

	components: {
		'ListAthletes': ListAthletes,
		'ListYearsAll': ListYearsAll
	},

	computed: {

		rankedItems() {
        	const items = [];
	        if (this.bestPerformances.length > 0) {
	            items[0] = this.bestPerformances[0];
	            items[0].rank = 1;
	            items[0].perf = 1;
	            for (let index = 1; index < this.bestPerformances.length; index++) {
	                items[index] = this.bestPerformances[index];

	                if (items[index].time === items[index - 1].time 
	                	&& items[index].distHeight === items[index - 1].distHeight
	                	&& items[index].points === items[index - 1].points ) {
	                    items[index].rank = "";
	                } else {
	                    items[index].rank = index + 1;
	                }
	            }
	        }
	        return items;
	    }

	},

	methods: {

		formatDuration(val) {
			this.duration = moment.duration(moment().diff(val))
			if(val) {
				return this.duration.years() + ' years, ' 
			    	+ this.duration.months() + ' months, ' 
			    	+ this.duration.days() + ' days';
			}
	
		},

		getAthleteData(athleteID) {
			this.loadingIcon = true;
			this.queryParams.athleteID = athleteID;
			this.queryParams.eventID = []; // reset eventID
			this.queryParams.order_by = '0'; // reset order_by
			this.bestPerformances = []; // remove existing data
			// this.$router.push({
			// 	path: '/profiles', 
			// 	query: this.queryParams
			// });

			this.$http.get('site/Profiles_con/athlete', {
				params: this.queryParams
			})
			.then((response) => {
				//this.token = response.data.token;
				this.athleteData = response.data.athlete_data;
				this.athleteEvents = response.data.get_athlete_events;
				this.loadingIcon = false;
				console.log(this.athleteEvents)
			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})
		},

		getAthletePerformances() {
			this.loadingIcon = true;
			// this.$router.push({
			// 	path: '/profiles', 
			// 	query: this.queryParams
			// });

			this.$http.get('site/Profiles_con/athlete_data', {
				params: this.queryParams
			})
			.then((response) => {
				this.token = response.data.token;
				//this.athleteData = response.data.athlete_data;
				this.bestPerformances = response.data.athlete;
				this.loadingIcon = false;
				this.$router.push({
					path: '/profiles', 
					query: this.queryParams
				});
			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})
		}
	},

	mounted() {
		//this.athleteHelpers();
		//this.getAthletePerformances();
	}
}

</script>


<style lang="scss">
	
</style>