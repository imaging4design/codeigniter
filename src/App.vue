<template>
	<div id="app">
		
		<ul class="nav nav-pills">
			<li class="nav-item">
				<router-link to="/" exact class="nav-link">Home</router-link>
			</li>
			<li class="nav-item">
				<router-link to="/test" class="nav-link">Test</router-link>
			</li>
			<li class="nav-item">
				<router-link to="/routes" class="nav-link">Routes</router-link>
			</li>
		</ul>

		<router-view></router-view>

		<h1>Records</h1>
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

			<select v-model="in_out" class="form-control">
				<option disabled value="">Please select one</option>
				<!-- Loop through the record option/values pulled in from 'record_options' -->
				<option v-for="(value, key, index) in inOutOptions" :value="key">{{value}}</option>
			</select>

			<list-record-type v-model="recordType" ></list-record-type>
			<list-age-groups v-model="ageGroup" ></list-age-groups>	

			<button type="submit" @click="records" class="btn btn-info">Submit</button>
		
		</form>

		<br>

		<strong>Token: </strong>{{token}} <br>

		<transition name="fade">
			<h3 v-show="! recordsNew">No records to display</h3>
		</transition>

		<transition name="fade">
			<table class="table table-responsive table-sm table-dark table-hover" v-show="recordsNew">
				<thead>
					<tr>
						<th>Event</th>
						<th>Athlete</th>
						<th>Performance</th>
						<th>Country</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(record, index) in recordsNew">
						<td><strong>{{record.eventName}}</strong></td>
						<td>{{record.nameFirst}} {{record.nameLast}}</td>
						<td>{{record.result | removeLeadZeros}}</td>
						<td>{{record.country}}</td>
						<td>{{record.date}}</td>
					</tr>
				</tbody>
			</table>
		</transition>

		
			

		<!-- 
		| WHAT: Top Performances listing
		| DESCRIPTION: A listing of the top performances of teh current year
		| POINTS TO NOTE: Loops through the 'athletes' array (of objects) and display data  
		 -->
		<button class="btn btn-info" @click="showTopPerformers">Results</button>
		<table class="table table-responsive table-sm table-dark table-hover" v-show="athletes[0]">
			<thead>
				<tr>
					<th>Event</th>
					<th>Athlete</th>
					<th>Performance</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(athlete, index) in athletes">
					<td><strong>{{athlete.eventName}}</strong></td>
					<td>{{athlete.nameFirst}} {{athlete.nameLast}}</td>
					<td>{{athlete.distHeight | removeLeadZeros}} {{athlete.time | removeLeadZeros}}</td>
				</tr>
			</tbody>
		</table>

		<hr>

		<button class="btn btn-info" @click="showTopMultis">Show Multis</button>
		<ul>
			<li>
				<strong>{{multi.eventName}}</strong> {{multi.nameFirst}} {{multi.nameLast}} {{multi.points}}
			</li>
		</ul>

		<hr>

		<button class="btn btn-info" @click="showTopRelays">Show Relays</button>
		<ul>
			<li v-for="relay in relays">
				<strong>{{relay.eventName}}</strong> {{relay.nameFirst}} {{relay.nameLast}} {{relay.distHeight}} {{relay.time}} {{relay.athlete01}}, {{relay.athlete02}}, {{relay.athlete03}}, {{relay.athlete04}}
			</li>
		</ul>

	</div>
</template>



<script>

import axios from 'axios';
import ListRecordType from './global_helpers/ListRecordType.vue';
import ListAgeGroups from './global_helpers/ListAgeGroups.vue';

export default {
	name: 'app',
	data () {
		return {
			url: 'http://localhost/codeigniter/',
			//url: 'http://www.dev-anzrankings.org.nz/',
			athletes: [],
			multi: [],
			relays: [],
			recordsNew: [],
			token: null,
			recordType: 'NN',
			ageGroup: 'MS',
			inOutOptions: { 
				'out': 'Outdoors',
				'in': 'Indoors'
			},
			in_out: 'out'
		}
	},
	
	created() {
		//this.ageGroupOptions();
	},

	components: {
		'ListAgeGroups': ListAgeGroups,
		'ListRecordType': ListRecordType
	},

	methods: {

		records() {
			axios.get(this.url + 'site/Records_con/index', {
				params: {
					recordType: this.recordType,
					ageGroup: this.ageGroup,
					in_out: this.in_out
				}
			}).then((response) => {
				this.token = response.data.token;
				this.recordsNew = response.data.get_records;
				//console.log(response.data);
			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})
		},
		showTopPerformers() {
			axios.get(this.url + 'site/Home_con/showTopPerformers', {
				params: {
					ageGroup: this.ageGroup,
				}
			})
			.then((response) => {
				this.athletes = response.data.topPerformers;
				//console.log(response.data);
			})
		},
		showTopMultis() {
			axios.get(this.url + 'site/Home_con/showTopMultis', {
				params: {
					ageGroup: this.ageGroup,
				}
			})
			.then((response) => {
				this.multi = response.data.topPerformers_Multis;
				//console.log(response.data);
			})
		},
		showTopRelays() {
			axios.get(this.url + 'site/Home_con/showTopRelays', {
				params: {
					ageGroup: this.ageGroup,
				}
			})
			.then((response) => {
				this.relays = response.data.topPerformers_Relays;
				//console.log(response.data);
			})
		}

	}, // ENDS methods

	filters: {
		removeLeadZeros(value) {
			if (!value) { return ''; }
			value = value.toString();
			return value.replace(/^0+(?!\.|$)/, '');
		}
	} // ENDS filters
};

</script>





<style lang="scss">
#app {
	//font-family: 'Avenir', Helvetica, Arial, sans-serif;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	text-align: left;
	color: #2c3e50;
	margin-top: 60px;

	

	ul {
		list-style-type: none;
		padding: 0;
	}

	li {
		margin: 0 10px;
	}

	li a.router-link-active,
	li a.router-link-exact-active {
		color: #fff;
		background-color: #17a2b8;
		cursor: pointer;
	}

	.fade-enter-active, .fade-leave-active {
		transition: opacity .9s;
	}
	.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
		opacity: 0;
	}
}

</style>
