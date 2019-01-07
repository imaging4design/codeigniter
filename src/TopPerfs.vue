<template>
	<div id="top-perfs">
	  	<!-- 
		| WHAT: Top Performances listing
		| DESCRIPTION: A listing of the top performances of teh current year
		| POINTS TO NOTE: Loops through the 'athletes' array (of objects) and display data  
		-->

		<button class="btn btn-info" @click="showTopPerformers('MS')">Men Senior</button>
		<button class="btn btn-info" @click="showTopPerformers('WS')">Women Senior</button>
		<button class="btn btn-info" @click="showTopPerformers('M19')">Men Under 20</button>
		<button class="btn btn-info" @click="showTopPerformers('W19')">Women Under 20</button>
		<button class="btn btn-info" @click="showTopPerformers('M17')">Men Under 17</button>
		<button class="btn btn-info" @click="showTopPerformers('W17')">Women Under 17</button>

		<div class="loadingIcon" v-show="!loadingIcon"><i class="fas fa-cog fa-5x fa-spin"></i></div>

		<table class="table table-responsive-sm table-dark table-hover" v-show="athletes[0]">
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
				//console.log(response.data);
				this.loadingIcon = false;
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
		.loadingIcon {
			position: relative;
			i.fas {
				position: absolute;
				color: #fff;
				left: 50%;
				transform: translate(-50%);
			} 
		}
			
	}
	

</style>