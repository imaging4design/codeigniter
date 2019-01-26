<template>
	<div id="top-perfs">

		<h1>Top Performers</h1>

		<hr>
	  	<!-- 
		| WHAT: Top Performances listing
		| DESCRIPTION: A listing of the top performances of teh current year
		| POINTS TO NOTE: Loops through the 'athletes' array (of objects) and display data  
		-->

		<button class="button is-danger" @click="showTopPerformers('MS')">Men Senior</button>
		<button class="button is-danger" @click="showTopPerformers('WS')">Women Senior</button>
		<button class="button is-danger" @click="showTopPerformers('M19')">Men Under 20</button>
		<button class="button is-danger" @click="showTopPerformers('W19')">Women Under 20</button>
		<button class="button is-danger" @click="showTopPerformers('M17')">Men Under 17</button>
		<button class="button is-danger" @click="showTopPerformers('W17')">Women Under 17</button>

		<br><br>

		<div class="loadingIcon" v-show="loadingIcon"><i class="fas fa-cog fa-5x fa-spin"></i></div>

		<div class="table-container">
			<table class="table is-striped is-fullwidth is-hoverable is-bordered" v-show="athletes[0]">
				<thead>
					<tr>
						<th width="20%">Event</th>
						<th width="20%">Athlete</th>
						<th width="20%">Performance</th>
						<th width="20%">Competition</th>
						<th width="20%">Date</th>
					</tr>
				</thead>
				<tbody v-if="athletes">
					<tr v-for="(athlete, index) in athletes">
						<td><strong>{{athlete.eventName}}</strong></td>
						<td>{{athlete.nameFirst}} {{athlete.nameLast}}</td>
						<td>{{athlete.distHeight | removeLeadZeros}} {{athlete.time | removeLeadZeros}}</td>
						<td>{{athlete.competition}}</td>
						<td>{{athlete.date}}</td>
					</tr>
				</tbody>
			</table>
		</div>

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
//import axios from 'axios';

export default {
	data() {
		return {
			loadingIcon: false,
			queryParams: {
				ageGroup: 'WS'
			},
			athletes: [],
			multi: [],
			relays: []
		}
	},
	
	created() {
		//this.ageGroupOptions();
	},

	methods: {
		showTopPerformers(ageGroup) {
			this.loadingIcon = true;
			this.$http.get('site/Home_con/showTopPerformers', {
				params: {
					ageGroup: ageGroup,
				}
			})
			.then((response) => {
				this.athletes = response.data.topPerformers;
				this.loadingIcon = false;
				//console.log(response.data);
			})
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

<style lang="scss">

	#top-perfs {
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
	}
	

</style>