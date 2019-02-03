<template>
	<div id="records">

		<!-- 
		| WHAT: Form to select records
		| DESCRIPTION: Displays a form on page to allow the user to select records based on 'age group' and 'record type'
		| POINTS TO NOTE:
		| Prevent the default action of the form 'v-on:submit.prevent'
		| Loop through the 'record_options' data object as key/values in the 'Record' type dropdown
		| Loop through the 'age_options' data object as key/values in the 'Age Group' type dropdown
		| On submit: call the records() function
		-->		

		<form v-on:submit.prevent>

			<v-container grid-list-xl>
				<v-layout row wrap>
					<v-flex>
						<h1>NZ Records</h1>
					</v-flex>
				</v-layout>

				<v-layout row wrap>
					<v-flex xs12 md4>
						<list-age-groups-recs v-model="queryParams.ageGroup"></list-age-groups-recs>
					</v-flex>
					<v-flex xs12 md4>
						<list-season v-model="queryParams.in_out"></list-season>
					</v-flex>
					<v-flex xs12 md4>
						<list-record-types v-model="queryParams.recordType"></list-record-types>
					</v-flex>
				</v-layout>
			</v-container>

			<!-- <div class="columns">

				<div class="column">
					<div class="field">
						<label class="label">Season</label>
						<div class="control">
							<div class="select">
								<select v-model="queryParams.in_out" class="form-control">
									<option disabled value="">Please select one</option>
									Loop through the record option/values pulled in from 'record_options'
									<option v-for="(value, key, index) in inOutOptions" :value="key">{{value}}</option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="column">
					
				</div>

				<div class="column">
					
				</div>
				<div class="column">
					
				</div>
			</div> -->

			<v-btn type="submit" @click="fetchFormParams" color="success">Submit</v-btn>		

		
		</form>

		<br>

		<strong>Token: </strong>{{token}} <br>

		<h3 v-show="! recordsNew">No records to display</h3>


			<div class="table-container">
				<table class="table is-striped is-fullwidth is-hoverable is-bordered" v-show="recordsNew">
					<thead>
						<tr>
							<th>Event</th>
							<th>Athlete</th>
							<th>Performance</th>
							<th>Country</th>
							<th>Venue</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(record, index) in recordsNew" :key="index">
							<td><strong>{{record.eventName}}</strong></td>
							<td>{{record.nameFirst}} {{record.nameLast}}</td>
							<td>{{record.result | removeLeadZeros}}</td>
							<td>{{record.country}}</td>
							<td>{{record.venue}}</td>
							<td>{{record.date}}</td>
						</tr>
					</tbody>
				</table>
			</div>

	</div>

</template>

<script>
//import axios from 'axios';
import ListSeason from '../global_helpers/ListSeason.vue';
import ListRecordTypes from '../global_helpers/ListRecordTypes.vue';
import ListAgeGroupsRecs from '../global_helpers/ListAgeGroupsRecs.vue';

export default {

	data() {
		return {
			recordsNew: [],
			token: null,
			queryParams: {
				recordType: 'NN',
				ageGroup: 'MS',
				in_out: 'out',
			},
			inOutOptions: { 
				'out': 'Outdoors',
				'in': 'Indoors'
			}
		}
	},

	components: {
		'ListSeason': ListSeason,
		'ListAgeGroupsRecs': ListAgeGroupsRecs,
		'ListRecordTypes': ListRecordTypes
	},

	methods: {

		fetchQueryStringParams() {
			this.queryParams = {
				recordType: this.$route.query.recordType ? this.$route.query.recordType : this.queryParams.recordType,
				ageGroup: this.$route.query.ageGroup ? this.$route.query.ageGroup : this.queryParams.ageGroup,
				in_out: this.$route.query.in_out ? this.$route.query.in_out : this.queryParams.in_out
			}
			this.fetchFormParams()
		},

		fetchFormParams() {
			this.$router.push({
				path: '/nz-records', 
				query: this.queryParams
			});

			this.$http.get('site/Records_con/index', {
				params: this.queryParams
			})
			.then((response) => {
				this.token = response.data.token;
				this.recordsNew = response.data.get_records;
				//console.log('FULL RESPONSE: ', response.data.get_records)
			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})

			console.log(this.queryParams.in_out)
		}
	},

	mounted() {
		this.fetchQueryStringParams();
	},	

	// filters: {
	// 	removeLeadZeros(value) {
	// 		if (!value) { return ''; }
	// 		value = value.toString();
	// 		return value.replace(/^0+(?!\.|$)/, '');
	// 	}
	// } // ENDS filters
};
</script>