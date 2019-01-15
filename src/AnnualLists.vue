<template>
	<div id="annual-lists">

		<h1>Annual Lists</h1>
		
		<hr>

		<form v-on:submit.prevent>
			<list-years v-model="queryParams.year"></list-years>
			<list-depth v-model="queryParams.list_depth"></list-depth>
			<list-type v-model="queryParams.list_type"></list-type>
			<list-events v-model="queryParams.eventID"></list-events>
			<list-age-groups-default v-model="queryParams.ageGroup"></list-age-groups-default>

			<button type="submit" @click="fetchFormParams" class="btn btn-info">Submit</button>

		</form>
		<br>
		<strong>Token: </strong>{{token}} <br>

		<p>Current NZ Record</p>
		<ul>
			<li v-for="record in current_nz_record">
				<strong>{{record.nameFirst}}</strong>
				<strong>{{record.nameLast}}</strong> / 
				{{record.ageGroup}} / 
				{{record.result}} / 
				{{record.venue}} / 
				{{record.date}}
			</li>
		</ul>

		<div class="loadingIcon" v-show="loadingIcon"><i class="fas fa-cog fa-5x fa-spin"></i></div>

		<table class="table table-responsive-sm table-dark table-hover" >
			<thead>
				<tr>
					<th>Rank</th>
					<th>Performance</th>
					<th>Wind</th>
					<th>Athlete</th>
					<th>Centre</th>
					<th>DOB</th>
					<th>Competition</th>
					<th>Venue</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(result, index) in resultsList" :key="index">
					
					<!-- Rank No. do not show number if previous performances is same (e.g. 10.38 / 10.38) -->
					<template v-if="resultsList[index-1]">
						<td v-if="result.time == resultsList[index-1].time 
							&& result.distHeight == resultsList[index-1].distHeight
							&& result.points == resultsList[index-1].points"><!-- i.e. the previous perf -->
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
					<td>{{result.wind}}</td>
					<td>{{result.nameFirst}} {{result.nameLast}}</td>
					<td>{{result.centreID}}</td>
					<td>{{result.DOB}}</td>
					<td>{{result.competition}}</td>
					<td>{{result.venue}}</td>
					<td>{{result.date}}</td>

				</tr>
			</tbody>
		</table>

	</div>
</template>



<script>
//import axios from 'axios';
import ListEvents from './global_helpers/ListEvents.vue';
import ListAgeGroupsDefault from './global_helpers/ListAgeGroupsDefault.vue';
import ListYears from './global_helpers/ListYears.vue';
import ListDepth from './global_helpers/ListDepth.vue';
import ListType from './global_helpers/ListType.vue';

export default {
	data() {
		return {
			loadingIcon: false,
			token: null,
			queryParams: {
				ageGroup: 'MS',
				list_depth: '250',
				list_type: '1',
				eventID: '1',
				year: '2019'
			},
			resultsList: [],
			current_nz_record: []
		}
	},

	components: {
		'ListEvents': ListEvents,
		'ListAgeGroupsDefault': ListAgeGroupsDefault,
		'ListYears': ListYears,
		'ListDepth': ListDepth,
		'ListType': ListType
	},

	methods: {

		fetchQueryStringParams() {
			this.queryParams = {
				ageGroup: this.$route.query.ageGroup ? this.$route.query.ageGroup : this.queryParams.ageGroup,
				list_depth: this.$route.query.list_depth ? this.$route.query.list_depth : this.queryParams.list_depth,
				list_type: this.$route.query.list_type ? this.$route.query.list_type : this.queryParams.list_type,
				eventID: this.$route.query.eventID ? this.$route.query.eventID : this.queryParams.eventID,
				year: this.$route.query.year ? this.$route.query.year : this.queryParams.year
			}
			this.fetchFormParams();
		},

		fetchFormParams() {
			this.loadingIcon = true;
			this.$router.push({
				path: '/annual-lists', 
				query: this.queryParams
			});

			this.$http.get('site/Results_con/index', {
				params: this.queryParams
			})
			.then((response) => {
				this.token = response.data.token;
				this.resultsList = response.data.lists;
				this.current_nz_record = response.data.current_nz_record;
				//console.log('RESULTS: ' + response.data.lists)
				this.loadingIcon = false;
			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})

			//console.log(this.queryParams.recordType)
		}
	},

	mounted() {
		this.fetchQueryStringParams();
	},	
}
</script>



<style lang="scss">

	#annual-lists {
		position: relative;
		.loadingIcon {
			width: 100%;
			position: absolute;
			// background: green;
			text-align: center;
			i.fas {
				color: #fff;
				margin: 40px auto;
			} 
		}
		ul {
			li {
				margin: 0;
			}
		}
	}
	

</style>