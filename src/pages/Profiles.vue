<template>
	
	<div id="profile">

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
	
export default {
	data() {
		return {
			loadingIcon: false,
			token: null,
			queryParams: {
				athleteID: '529349',
				eventID: '33',
				year: '0',
				order_by: '0'
			},
			athleteData: [],
			bestPerformances: []
		}
	},

	methods: {

		fetchAthleteData() {
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
				this.athleteData = response.data.athlete_data;
				this.bestPerformances = response.data.athlete;
				this.loadingIcon = false;
			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})

			//console.log(this.queryParams.recordType)
		}
	},

	mounted() {
		this.fetchAthleteData();
	}
}

</script>


<style lang="scss">
	
</style>