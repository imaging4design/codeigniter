<template>
	<div>

		
	  	<!-- 
		| WHAT: Top Performances listing
		| DESCRIPTION: A listing of the top performances of teh current year
		| POINTS TO NOTE: Loops through the 'athletes' array (of objects) and display data  
		-->
		<v-container grid-list-xl>

			<v-layout row wrap>
				<v-flex xs12>
					<h1>Top Performers</h1>
				</v-flex>
			</v-layout>

			<v-layout row wrap>
				<v-flex xs12 md2>
					<v-btn flat outline block color="secondary" @click="showTopPerformers('MS')">Men Senior</v-btn>
				</v-flex>
				<v-flex xs12 md2>
					<v-btn flat outline block color="secondary" @click="showTopPerformers('WS')">Women Senior</v-btn>
				</v-flex>
				<v-flex xs12 md2>
					<v-btn flat outline block color="secondary" @click="showTopPerformers('M19')">Men U20</v-btn>
				</v-flex>
				<v-flex xs12 md2>
					<v-btn flat outline block color="secondary" @click="showTopPerformers('W19')">Women U20</v-btn>
				</v-flex>
				<v-flex xs12 md2>
					<v-btn flat outline block color="secondary" @click="showTopPerformers('M17')">Men U17</v-btn>
				</v-flex>
				<v-flex xs12 md2>
					<v-btn flat outline block color="secondary" @click="showTopPerformers('W17')">Women U17</v-btn>
				</v-flex>
			</v-layout>
		</v-container>



		<v-data-table
			:headers="headers"
			:items="athletes"
			:loading="loading"
			:expand="expand"
			item-key="eventName"
		>

			<v-progress-linear slot="progress" color="secondary" indeterminate></v-progress-linear>

			<template slot="items" slot-scope="props">
				<tr @click="props.expanded = !props.expanded">
				<td>{{ props.item.eventName }}</td>
				<td class="text-xs-left">{{ props.item.nameFirst }} {{ props.item.nameLast }}</td>
				<td class="text-xs-left">{{ props.item.distHeight | removeLeadZeros}} {{ props.item.time | removeLeadZeros}}</td>
				<td class="text-xs-left">{{ props.item.competition }}</td>
				<td class="text-xs-left">{{ props.item.date }}</td>
				</tr>
			</template>
			<template slot="expand" slot-scope="props">
				<v-card flat>
					<v-card-text>IAAF Standard 10.12 | IAAF Standard 10.12</v-card-text>
				</v-card>
			</template>

		</v-data-table>

		<modal>
			<span slot="header">Recent Results</span>
			<span slot="body">Recent Results display the latest performances by men and women over a specified number of days. Performances are grouped by event and are in descending order of result achieved.</span>
		</modal>


		<hr>

		<button class="button is-danger" @click="showTopMultis">Show Multis</button>
		<ul>
			<li v-if="multi">
				<strong>{{multi.eventName}}</strong> {{multi.nameFirst}} {{multi.nameLast}} {{multi.points}}
			</li>
		</ul>

		<p v-if="!multi">No multis listings at this time</p>

		<hr>

		<button class="button is-danger" @click="showTopRelays">Show Relays</button>
		<ul>
			<li v-if="relays" v-for="relay in relays">
				<strong>{{relay.eventName}}</strong> {{relay.nameFirst}} {{relay.nameLast}} {{relay.distHeight}} {{relay.time}} {{relay.athlete01}}, {{relay.athlete02}}, {{relay.athlete03}}, {{relay.athlete04}}
			</li>
		</ul>

		<p v-if="!relays">No relays listings at this time</p>

	</div>
</template>




<script>

import Modal from '../global_helpers/Modal.vue';

export default {
	data() {
		return {
			queryParams: {
				ageGroup: 'WS'
			},
			athletes: [],
			multi: [],
			relays: [],

			loading: false,
			expand: false,
			headers: [
				{ text: 'Event',
					align: 'left',
					sortable: false,
					value: 'eventName'},
				{ text: 'Athlete', value: 'nameFirst', sortable: false},
				{ text: 'Performance', value: 'performance', sortable: false},
				{ text: 'Competition', value: 'competition', sortable: false},
				{ text: 'Date', value: 'date', sortable: false}
			]
		}
	},

	components: {
		'Modal': Modal,
	},
	
	created() {
		//this.ageGroupOptions();
	},

	methods: {
		showTopPerformers(ageGroup) {
			this.loading = true;
			this.$http.get('site/Home_con/showTopPerformers', {
				params: {
					ageGroup: ageGroup,
				}
			})
			.then((response) => {
				this.athletes = response.data.topPerformers;
			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})
			.finally(() => this.loading = false);
		},
		showTopMultis() {
			this.$http.get('site/Home_con/showTopMultis', {
				params: {
					ageGroup: this.ageGroup,
				}
			})
			.then((response) => {
				this.multi = response.data.topPerformers_Multis;
			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})
		},
		showTopRelays() {
			this.$http.get('site/Home_con/showTopRelays', {
				params: {
					ageGroup: this.ageGroup,
				}
			})
			.then((response) => {
				this.relays = response.data.topPerformers_Relays;
			})
		}
	}
	
};
</script>

<style lang="scss">

</style>