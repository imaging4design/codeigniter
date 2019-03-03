<template>
	
	<div id="profile">

		<!-- 
		|*********************************************************
		| Search for athletes (Autocomplete) 
		|*********************************************************
		-->
		<v-container grid-list-xl fluid pa-0>
			<v-layout row wrap>
				<v-flex>
					<h1 class="display-1 font-weight-light primary--text">Profiles</h1>
				</v-flex> 
			</v-layout>
		</v-container>

		<!-- 
		|*********************************************************
		| GET ATHLETE EVENTS 
		|*********************************************************
		-->
		<form v-on:submit.prevent>

			<v-container grid-list-xl px-0>

				<v-layout row wrap>
					
					<v-flex xs12 md6>

						<v-alert
							v-model="alert"
							dismissible
							type="warning"
							color="secondary">
							This is a success alert that is closable.
						</v-alert>

						<list-athletes></list-athletes>
						
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
							color="secondary">
						</v-select>

						<list-years-all v-model="queryParams.year"></list-years-all>

						<v-radio-group v-model="queryParams.order_by" :mandatory="false" v-on:change="getAthletePerformances">
							<v-radio color="secondary" label="Performance" value="0"></v-radio>
							<v-radio color="secondary" label="Latest" value="1"></v-radio>
						</v-radio-group>
					</v-flex>

					<v-flex xs12 md6 v-show="athleteData.athleteID">
						<h1>{{athleteData.nameFirst}} {{athleteData.nameLast}}: {{athleteData.athleteID}}</h1>
						<ul >
							<li><strong>Athlete: </strong>{{athleteData.nameFirst}} {{athleteData.nameLast}} {{athleteData.athleteID}}</li>
							<li><strong>Date of Birth: </strong>{{athleteData.DOB}} ({{convertAge(athleteData.DOB)}})</li>
							<li><strong>Centre: </strong>{{athleteData.clubName}} ({{athleteData.centreName}})</li>
							<li v-show="athleteData.coach"><strong>Coach: </strong>{{athleteData.coach}}</li>
							<li v-show="athleteData.coach_former"><strong>Former Coach/s: </strong>{{athleteData.coach_former}}</li>
						</ul>
					</v-flex>	

				</v-layout>
			</v-container>

		</form>



		<!-- 
		|*********************************************************
		| NZ CHAMPS DATA
		|*********************************************************
		-->
		<v-container grid-list-xl px-0>
			<v-layout row wrap>
				<v-flex xs12 md6>

					

					<v-expansion-panel>
						<v-expansion-panel-content>
							<div slot="header"><v-icon left size="18" light>schedule</v-icon> NZ Championships</div>
							<v-card>
								<v-card-text>
									<ul>
										<li v-for="data in nzChampsData">{{data.year}} {{data.ageGroup}} {{data.eventName}} {{data.performance}} {{data.position | medal}}</li>
									</ul>
								</v-card-text>
							</v-card>
						</v-expansion-panel-content>

						<v-expansion-panel-content>
							<div slot="header"><v-icon left size="18" light>event_note</v-icon> Progressions</div>
							<v-card>
								<v-card-text>
									<ul>
										<li v-for="data in nzChampsData">{{data.year}} {{data.ageGroup}} {{data.eventName}} {{data.performance}} {{data.position | medal}}</li>
									</ul>
								</v-card-text>
							</v-card>
						</v-expansion-panel-content>
					</v-expansion-panel>
					
					
				</v-flex>
			</v-layout>
		</v-container>
		
		
		<!-- 
		|*********************************************************
		| BEST PERFORMANCES 
		|*********************************************************
		-->
		<v-data-table v-if="bestPerformances && bestPerformances.length"
			:headers="headers"
			:items="rankedItems"
			:loading="loading"
			:expand="expand"
			item-key="resultID">

			<v-progress-linear slot="progress" color="secondary" indeterminate></v-progress-linear>

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

		<v-snackbar
			v-model="snackbar"
			:bottom="y === 'bottom'"
			:left="x === 'left'"
			:multi-line="mode === 'multi-line'"
			:right="x === 'right'"
			:timeout="timeout"
			:top="y === 'top'"
			:vertical="mode === 'vertical'"
			color="white--text">
			{{ text }}
			<v-btn flat @click="snackbar=false">Close</v-btn>
		</v-snackbar>


		

		
	
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
			// Snackbar
			snackbar: false,
			y: 'top',
			x: null,
			mode: 'multi-line',
			timeout: 3000,
			text: 'No results found',

			alert: false,

			// Token
			token: null,

			// Query Params
			queryParams: {
				athleteID: null,
				eventID: null,
				year: '0',
				order_by: '1'
			},

			// Athlete data
			athleteEvents: [],
			athleteData: [],
			bestPerformances: [],
			nzChampsData: [],

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

		/*
		|***********************************************************************
		| Adds the 'rank' column to the performance data
		| Also skips the rank number for equal = performances
		|***********************************************************************
		*/
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
	            return items;
	        }
	    }

	},

	methods: {

		/*
		|***********************************************************************
		| Converts athlete age (DOB 21/10/1967 to 51 years, 6 months, 3 days
		|***********************************************************************
		*/
		convertAge(val) {
			this.duration = moment.duration(moment().diff(val))
			if(val) {
				return this.duration.years() + ' years, ' 
			    	+ this.duration.months() + ' months, ' 
			    	+ this.duration.days() + ' days';
			}
		},

		/*
		|***********************************************************************
		| Assign queryParams from either data or url $route 
		|***********************************************************************
		*/
		fetchQueryStringParams() {
			this.queryParams = {
				athleteID: this.$route.query.athleteID ? this.$route.query.athleteID : this.queryParams.athleteID,
				eventID: this.$route.query.eventID ? this.$route.query.eventID : this.queryParams.eventID,
				year: this.$route.query.year ? this.$route.query.year : this.queryParams.year,
				order_by: this.$route.query.order_by ? this.$route.query.order_by : this.queryParams.order_by
			}
			this.getAthleteData(this.athleteID);
		},

		/*
		|***********************************************************************
		| Retrieves the athlete's personal data (age, club, coach etc)
		|***********************************************************************
		*/
		getAthleteData(athleteID) {
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
				console.log(this.athleteEvents)

				this.getNZChamps();
			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})
		},

		/*
		|***********************************************************************
		| Retrieves athletes performance data
		|***********************************************************************
		*/
		getAthletePerformances() {
			this.loading = true;
			// this.bestPerformances = []; // remove existing data
			// this.$router.push({
			// 	path: '/profiles', 
			// 	query: this.queryParams
			// });

			this.$http.get('site/Profiles_con/athlete_data', {
				params: this.queryParams
			})
			.then((response) => {
				this.token = response.data.token;
				this.bestPerformances = response.data.athlete;
				this.$router.push({
					path: '/profiles', 
					query: this.queryParams
				});

				if( ! this.bestPerformances){
					this.snackbar = true;
					//this.alert = true;
				}
			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})
			.finally(() => this.loading = false);
		},

		/*
		|***********************************************************************
		| Retrieves athletes NZ Championship honours history
		|***********************************************************************
		*/
		getNZChamps() {
			this.loading = true;
			this.$http.get('site/Profiles_con/get_nzchamps', {
				params: {
					athleteID: this.queryParams.athleteID
				}
			})
			.then((response) => {
				//this.token = response.data.token;
				this.nzChampsData = response.data.nz_champs_data;
				console.log('Champs Data: ' + this.nzChampsData);
			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})
			.finally(() => this.loading = false);
		}

	},

	filters: {
		/*
		|***********************************************************************
		| Converts NZ Champs placings (1st - 3rd) into medals
		|***********************************************************************
		*/
		medal(value){
			if (!value) return ''
			switch(value) {
				case '1':
					return 'gold';
				break;
				case '2':
					return 'silver'
				break;
				case '3':
					return 'bronze'
				break;
				default:
					return value
			}
		}
	},

	mounted() {
		//this.fetchQueryStringParams();
		//this.getAthletePerformances();
	}
}

</script>


<style lang="scss">
	
</style>