<template>
	<div>
		<!-- 
		| WHAT: Form to select records
		| DESCRIPTION: Displays a form on page to allow the user to select records based on 'age group' and 'record type'
		| POINTS TO NOTE:
		| Prevent the default action of the form 'v-on:submit.prevent'
		| Loop through the 'record_options' data object as key/values in the 'Record' type dropdown
		| Loop through the 'age_options' data object as key/values in the 'Age Group' type dropdown
		| On submit: call the records() function
		 -->

		<p>{{this.$route.query.recordType}}</p>
		<p>{{this.$route.query.ageGroup}}</p>
		<p>{{this.$route.query.in_out}}</p>

		<form v-on:submit.prevent>

			<select v-model="in_out" class="form-control">
				<option disabled value="">Please select one</option>
				<!-- Loop through the record option/values pulled in from 'record_options' -->
				<option v-for="(value, key, index) in inOutOptions" :value="key">{{value}}</option>
			</select>

			<list-record-type v-model="recordType"></list-record-type>
			<list-age-groups v-model="ageGroup"></list-age-groups>	

			<button type="submit" @click="records" class="btn btn-info">Submit</button>
		
		</form>

		<br>

		<strong>Token: </strong>{{token}} <br>

		<transition name="fade">
			<h3 v-show="! recordsNew">No records to display</h3>
		</transition>

		<transition name="fade">
			<table class="table table-responsive-sm table-dark table-hover" v-show="recordsNew">
				<thead>
					<tr>
						<th>Rank</th>
						<th>Event</th>
						<th>Athlete</th>
						<th>Performance</th>
						<th>Country</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(record, index) in recordsNew" :key="index">
						
						<!-- Rank No. do not show number if previous performances is same (e.g. 10.38 / 10.38) -->
						<template v-if="recordsNew[index-1]">
							<td v-if="record.country == recordsNew[index-1].country"><!-- i.e. the previous perf -->
								&nbsp;
							</td>
							<td v-else>
								{{index + 1}}
							</td>
						</template>
						<template v-else>
							<td>{{index + 1}}</td>
						</template>

						<td><strong>{{record.eventName}}</strong></td>
						<td>{{record.nameFirst}} {{record.nameLast}}</td>
						<td>{{record.result | removeLeadZeros}}</td>
						<td>{{record.country}}</td>
						<td>{{record.date}}</td>

					</tr>
				</tbody>
			</table>
		</transition>
	</div>

</template>

<script>
//import axios from 'axios';
import ListRecordType from './global_helpers/ListRecordType.vue';
import ListAgeGroups from './global_helpers/ListAgeGroups.vue';

export default {

	data() {
		return {
			recordsNew: [],
			token: null,
			recordType: 'NN',
			ageGroup: 'MS',
			in_out: 'out',
			inOutOptions: { 
				'out': 'Outdoors',
				'in': 'Indoors'
			}
		}
	},

	components: {
		'ListAgeGroups': ListAgeGroups,
		'ListRecordType': ListRecordType
	},

	methods: {
		records() {
			this.$http.get('site/Records_con/index', {
				params: {
					recordType: this.$route.query.recordType ? this.$route.query.recordType : this.recordType,
					ageGroup: this.$route.query.ageGroup ? this.$route.query.ageGroup : this.ageGroup,
					in_out: this.$route.query.in_out ? this.$route.query.in_out : this.in_out
				}
			})
			.then((response) => {
				this.token = response.data.token;
				this.recordsNew = response.data.get_records;
				//console.log(response.data);
			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})
		}
	},

	created() {
		this.records();
	},

	filters: {
		removeLeadZeros(value) {
			if (!value) { return ''; }
			value = value.toString();
			return value.replace(/^0+(?!\.|$)/, '');
		}
	} // ENDS filters
};
</script>