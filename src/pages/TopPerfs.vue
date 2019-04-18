<template>
	<div>


		<v-container grid-list-xl fluid pa-0>
			<v-layout row wrap>
				<v-flex xs12 md3>
					<h1 class="display-1 font-weight-light primary--text">{{new Date().getFullYear()}} Leaders</h1>
				</v-flex>
			</v-layout>
		</v-container>


					

		
	  	<!-- 
		| WHAT: Top Performances listing
		| DESCRIPTION: A listing of the top performances of teh current year
		| POINTS TO NOTE: Loops through the 'individuals' array (of objects) and display data  
		-->
		<form v-on:submit.prevent>
			<v-container grid-list-xl fluid pa-0>
				<v-layout row wrap>
					<v-flex xs12 md3>
						<list-age-groups-default v-model="queryParams.ageGroup" @input="showTopPerformers"></list-age-groups-default>
					</v-flex>
					<v-flex xs12 md3>
						<modal>
							<span slot="header">Recent Results</span>
							<span slot="body">Recent Results display the latest performances by men and women over a specified number of days. Performances are grouped by event and are in descending order of result achieved.</span>
						</modal>
					</v-flex>
				</v-layout>
			</v-container>
		</form>



		<v-data-table
			:headers="headers"
			:items="individualsNew"
			:loading="loading"
			:expand="expand"
			item-key="eventName"
		>

			<v-progress-linear slot="progress" color="secondary" indeterminate></v-progress-linear>

			<template slot="items" slot-scope="props">
				<tr @click="props.expanded = !props.expanded">
				<td>{{ props.item.eventName }}</td>
				<td class="text-xs-left">{{ props.item.distHeight | removeLeadZeros}} {{ props.item.time | removeLeadZeros}} {{ props.item.points | removeLeadZeros}}</td>
				<td class="text-xs-left">{{ props.item.nameFirst }} {{ props.item.nameLast }}</td>
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

		


		

		<!-- <button class="button is-danger" @click="showTopMultis">Show Multis</button>
		<ul>
			<li v-if="multi">
				<strong>{{multi.eventName}}</strong> {{multi.nameFirst}} {{multi.nameLast}} {{multi.points}}
			</li>
		</ul>

		<p v-if="!multi">No multis listings at this time</p> -->

		

		<!-- <button class="button is-danger" @click="showTopRelays">Show Relays</button> -->
		<h2 class="display-1 font-weight-light primary--text">Relays</h2>

		<v-data-table
			:headers="headers"
			:items="relays"
			:loading="loading"
			:expand="expand"
			item-key="eventName"
		>

			<!-- <v-progress-linear slot="progress" color="secondary" indeterminate></v-progress-linear> -->

			<template slot="items" slot-scope="props">
				<tr @click="props.expanded = !props.expanded">
				<td>{{ props.item.eventName }}</td>
				<td class="text-xs-left">{{ props.item.distHeight | removeLeadZeros}} {{ props.item.time | removeLeadZeros}} {{ props.item.points | removeLeadZeros}}</td>
				<td class="text-xs-left">{{ props.item.athlete01 }}, {{ props.item.athlete02 }}, {{ props.item.athlete03 }}, {{ props.item.athlete04 }}</td>
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

		<!-- <ul>
			<li v-if="relays" v-for="relay in relays">
				<strong>{{relay.eventName}}</strong> {{relay.nameFirst}} {{relay.nameLast}} {{relay.distHeight}} {{relay.time}} {{relay.athlete01}}, {{relay.athlete02}}, {{relay.athlete03}}, {{relay.athlete04}}
			</li>
		</ul> -->

		<p v-if="!relays">No relays listings at this time</p>

	</div>
</template>




<script>

import Modal from '../global_helpers/Modal.vue';
import ListAgeGroupsDefault from '../global_helpers/ListAgeGroupsDefault.vue';

export default {
	data() {
		return {
			queryParams: {
				ageGroup: 'WS'
			},
			individuals: [],
			multi: [],
			relays: [],

			individualsMultis: [],

			loading: false,
			expand: false,
			headers: [
				{ text: 'Event',
					align: 'left',
					sortable: false,
					value: 'eventName'},
				{ text: 'Performance', value: 'performance', sortable: false},
				{ text: 'Athlete(s)', value: 'nameFirst', sortable: false},
				{ text: 'Competition', value: 'competition', sortable: false},
				{ text: 'Date', value: 'date', sortable: false}
			]
		}
	},

	components: {
		'Modal': Modal,
		'ListAgeGroupsDefault': ListAgeGroupsDefault,
	},
	
	created() {
		//this.ageGroupOptions();
	},

	computed: {
		// Combine both the individual and multi results
		individualsNew(){
			return this.individualsMultis = this.individuals.concat(this.multi);
		}
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
				this.individuals = response.data.topPerformers;
			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})
			.finally(() => this.loading = false);

			this.showTopMultis(ageGroup);
			this.showTopRelays(ageGroup);
		},
		showTopMultis(ageGroup) {
			this.$http.get('site/Home_con/showTopMultis', {
				params: {
					ageGroup: ageGroup,
				}
			})
			.then((response) => {
				this.multi = response.data.topPerformers_Multis;
			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})
		},
		showTopRelays(ageGroup) {
			this.$http.get('site/Home_con/showTopRelays', {
				params: {
					ageGroup: ageGroup,
				}
			})
			.then((response) => {
				this.relays = response.data.topPerformers_Relays;
				console.log(this.relays)
			})
		}
	},
	mounted() {
		this.showTopPerformers();
	}
	
};
</script>

<style lang="scss">

</style>