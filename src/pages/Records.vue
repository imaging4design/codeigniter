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

				<v-layout row>
					<v-btn type="submit" @click="fetchFormParams" color="teal">Submit</v-btn>
				</v-layout>
			</v-container>

		</form>

		<br>

		<!-- <strong>Token: </strong>{{token}} <br> -->

		<h3 v-show="! recordsNew">No records to display</h3>


		<v-data-table
			:headers="headers"
			:items="recordsNew"
			:loading="loading"
			:expand="expand"
			item-key="recordID"
		>

			<v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>

			<template slot="items" slot-scope="props">
				<tr @click="props.expanded = !props.expanded">
				<td>{{ props.item.eventName }}</td>
				<td class="text-xs-left">{{ props.item.nameFirst }} {{ props.item.nameLast }}</td>
				<td class="text-xs-left">{{ props.item.result}}</td>
				<td class="text-xs-left">{{ props.item.country }}</td>
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
			},

			loading: false,
			expand: false,
			headers: [
				{ text: 'Event', align: 'left', sortable: false, value: 'eventName'},
				{ text: 'Athlete', value: 'nameFirst', sortable: false},
				{ text: 'Performance', value: 'result', sortable: false},
				{ text: 'Country', value: 'country', sortable: false},
				{ text: 'Venue', value: 'venue', sortable: false},
				{ text: 'Date', value: 'date', sortable: false}
			]
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