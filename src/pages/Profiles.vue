<template>
	
	<div id="profile">

		{{loadingIcon}}

		<list-athletes></list-athletes>

		<!-- 
		|*********************************************************
		| GET ATHLETE EVENTS 
		|*********************************************************
		-->
		<form v-on:submit.prevent>
			<div class="field">
				<label class="label">Events</label>
				<div class="control">
					<div class="select">
						<select v-bind:value="value" v-model="queryParams.eventID">
							<option disabled value="">Select Events</option>
							<!-- Loop through the ageGroup options/values pulled in from 'events' -->
							<option v-for="(value, key, index) in athleteEvents" v-bind:value="value.eventID">{{value.eventName}}</option>
						</select>
					</div>
				</div>
			</div>

			<button type="submit" @click="athletePerformances" class="button is-danger">Submit</button>

		</form>

		<!-- <button class="button is-danger" @click="athletePerformances">Go</button> -->

		<ul>
			<li><strong>Athlete: </strong>{{athleteData.nameFirst}} {{athleteData.nameLast}}</li>
			<li><strong>Date of Birth: </strong>{{athleteData.DOB}} ({{athleteData.birthDate}})</li>
			<li><strong>Centre: </strong>{{athleteData.centreName}}</li>
			<li><strong>Club: </strong>{{athleteData.clubName}}</li>
			<li><strong>Coach: </strong>{{athleteData.coach}}</li>
			<li><strong>Former Coach/s: </strong>{{athleteData.coach_former}}</li>
		</ul>

		

		<!-- 
		|*********************************************************
		| BEST PERFORMANCES 
		|*********************************************************
		-->
		<div class="table-container">
			<table class="table is-striped is-fullwidth is-hoverable is-bordered" v-if="bestPerformances">
				<thead>
					<tr>
						<th>Rank</th>
						<th>Performance</th>
						<th>Wind</th>
						<th>Note</th>
						<th>Place</th>
						<th>Competition</th>
						<th>Venue</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(result, index) in bestPerformances" :key="index">
						
						<!-- Rank No. do not show number if previous performances is same (e.g. 10.38 / 10.38) -->
						<template v-if="bestPerformances[index-1]">
							<td v-if="result.time == bestPerformances[index-1].time 
								&& result.distHeight == bestPerformances[index-1].distHeight
								&& result.points == bestPerformances[index-1].points"><!-- i.e. the previous perf -->
								&nbsp;
							</td>
							<td v-else>
								{{index + 1}}
							</td>
						</template>
						<template v-else>
							<td>{{index + 1}}</td>
						</template>

						<td>{{result.time | removeLeadZeros}} {{result.distHeight | removeLeadZeros}} {{result.points | removeLeadZeros}}</td>
						<td>{{result.wind}} {{result.implement}}</td>
						<td>{{result.record}}</td>
						<td>{{result.placing}}</td>
						<td>{{result.competition}}</td>
						<td>{{result.venue}}</td>
						<td>{{result.date}}</td>

					</tr>
				</tbody>
			</table><!-- ENDS table -->
		</div><!-- ENDS table-container -->
	
	</div><!-- ENDS profile -->

</template>



<script>
import ListAthletes from '../global_helpers/ListAthletes.vue';
export default {
	data() {
		return {
			loadingIcon: false,
			token: null,
			value: [],
			queryParams: {
				athleteID: '521419',
				eventID: '',
				year: '0',
				order_by: '0'
			},
			athleteEvents: [],
			athleteData: [],
			bestPerformances: []
		}
	},

	methods: {

		athleteHelpers() {
			this.loadingIcon = true;
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
			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})

			//console.log(this.queryParams.recordType)
		},

		athletePerformances() {
			this.loadingIcon = true;
			this.$router.push({
				path: '/profiles', 
				query: this.queryParams
			});

			this.$http.get('site/Profiles_con/athlete_data', {
				params: this.queryParams
			})
			.then((response) => {
				this.token = response.data.token;
				//this.athleteData = response.data.athlete_data;
				this.bestPerformances = response.data.athlete;
				this.loadingIcon = false;
			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})

			//console.log(this.queryParams.recordType)
		}
	},

	components: {
		'ListAthletes': ListAthletes
	},

	mounted() {
		this.athleteHelpers();
		//this.athletePerformances();
	}
}

</script>


<style lang="scss">
	
</style>