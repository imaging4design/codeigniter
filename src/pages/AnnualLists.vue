<template>
	<div id="annual-lists">

		<!-- 
		|*********************************************************
		| PAGE TITLE
		|*********************************************************
		-->
		<v-container grid-list-xl fluid pa-0>
			<v-layout row wrap>
				<v-flex>
					<h1 class="display-1 font-weight-light primary--text">Annual Lists</h1>
				</v-flex> 
			</v-layout>
		</v-container>

		
		<!-- 
		|*********************************************************
		| SEARCH FORM
		|*********************************************************
		-->
		<form v-on:submit.prevent>

			<v-container grid-list-xl fluid pa-0>
				
				<v-layout row wrap>
					<v-flex xs12 md3 sm3 py-0>
						<list-events v-model="queryParams.eventID"></list-events>
					</v-flex>
					<v-flex xs12 md3 sm3 py-0>
						<list-age-groups-default v-model="queryParams.ageGroup"></list-age-groups-default>
					</v-flex>
					<v-flex xs12 md2 sm2 py-0>
						<list-years v-model="queryParams.year"></list-years>
					</v-flex>
					<v-flex xs12 md2 sm2 py-0>
						<list-type v-model="queryParams.list_type"></list-type>
					</v-flex>
					<v-flex xs12 md2 sm2 py-0>
						<list-depth v-model="queryParams.list_depth"></list-depth>
					</v-flex>
				</v-layout>

				<v-layout row wrap>
					<v-flex xs12 md3>
						<v-btn type="submit" @click="fetchFormParams" color="secondary" class="elevation-0 mx-0">Show List</v-btn>
					</v-flex>
				</v-layout>

			</v-container>

		</form>

		<hr>


		<!-- 
		|*********************************************************
		| NZ RECORDS 
		|*********************************************************
		-->
		<div class="columns">

			<div class="column">
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


				<!-- 
				|*********************************************************
				| LEGAL PERFORMANCES TABLE
				|*********************************************************
				-->
				
				<!-- START DESKTOP VIEW (v-data-table) -->
				<div v-if="!isMobile">

					<v-data-table
						:headers="headers"
						:items="resultsList"
						:loading="loading"
						:expand="expand"
							:hide-headers="isMobile" 
							:class="{mobile: isMobile}"
						item-key=resultID>
						<v-progress-linear slot="progress" color="secondary" indeterminate></v-progress-linear>
						<template slot="items" slot-scope="props">
							<tr>
								<td v-if="resultsList[props.index -1] 
									&& resultsList[props.index -1].time === props.item.time
									&& resultsList[props.index -1].distHeight === props.item.distHeight">=</td>
								<td v-else>{{ props.index + 1}}</td>
								<td>{{props.item.time | removeLeadZeros}} {{props.item.distHeight | removeLeadZeros}} {{props.item.points | removeLeadZeros}} {{props.item.record}} {{(props.item.in_out == 'in') ? '(i)' : ''}}</td>
								<td class="text-xs-left">{{ props.item.wind }}</td>
								<td class="text-xs-left">{{ props.item.nameFirst }} {{ props.item.nameLast }} </td>
								<td class="text-xs-left">{{ props.item.centreID }}</td>
								<td class="text-xs-left">{{ props.item.DOB }}</td>
								<td class="text-xs-left">{{ props.item.placing }}</td>
								<td class="text-xs-left">{{ props.item.competition | toUpperCase}}</td>
								<td class="text-xs-left">{{ props.item.venue | toUpperCase}}</td>
								<td class="text-xs-left">{{ props.item.date }}</td>
							</tr>
						</template>
					</v-data-table>

				</div>

				<!-- START MOBILE VIEW (v-expansion-panel) -->
				<div v-else>

					<v-expansion-panel class="elevation-0" :class="{mobile: isMobile}">
						<v-expansion-panel-content v-for="(item, index) in resultsList" :key="index" ripple>
							<div slot="header">

								<strong v-if="resultsList[index -1] 
									&& resultsList[index -1].time === item.time
									&& resultsList[index -1].distHeight === item.distHeight
									&& resultsList[index -1].points === item.points">=</strong>
								<strong v-else>{{ index + 1}}</strong>

								{{ item.time | removeLeadZeros }} {{ item.distHeight | removeLeadZeros }} {{ item.points | removeLeadZeros }} {{item.record}} {{(item.in_out == 'in') ? '(i)' : ''}}<br>
								{{ item.nameFirst }} {{ item.nameLast }}

							</div>
							<v-card>
								<v-card-text>
									<ul class="flex-content">
									<li class="flex-item" data-label="Wind">{{ item.wind }}</li>
									<li class="flex-item" data-label="Centre">{{ item.centreID }}</li>
									<li class="flex-item" data-label="DOB">{{ item.DOB }}</li>
									<li class="flex-item" data-label="Place">{{ item.placing }}</li>
									<li class="flex-item" data-label="Comp">{{ item.competition }}</li>
									<li class="flex-item" data-label="Venue">{{ item.venue }}</li>
									<li class="flex-item" data-label="Date">{{ item.date }}</li>
								</ul>
								</v-card-text>
							</v-card>
						</v-expansion-panel-content>
					</v-expansion-panel>

				</div>










				<!-- 
				|*********************************************************
				| ILLEGAL WIND PERFORMANCES 
				|*********************************************************
				-->
				<h1>Illegal Wind</h1>
				<div class="table-container" style="display: none;">
					<table class="table is-striped is-fullwidth is-hoverable is-bordered" v-if="illegal_wind">
						<thead>
							<tr>
								<th>Rank</th>
								<th>Performance</th>
								<th>Wind</th>
								<th>Athlete</th>
								<th>Centre</th>
								<th>DOB</th>
								<th>Place</th>
								<th>Competition</th>
								<th>Venue</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(result, index) in illegal_wind" :key="index">
								
								<!-- Rank No. do not show number if previous performances is same (e.g. 10.38 / 10.38) -->
								<template v-if="illegal_wind[index-1]">
									<td v-if="result.time == illegal_wind[index-1].time 
										&& result.distHeight == illegal_wind[index-1].distHeight
										&& result.points == illegal_wind[index-1].points"><!-- i.e. the previous perf -->
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
								<td>{{result.placing}}</td>
								<td>{{result.competition}}</td>
								<td>{{result.venue}}</td>
								<td>{{result.date}}</td>

							</tr>
						</tbody>
					</table>
				</div>

			</div><!-- ENDS column -->

		</div><!-- ENDS columns -->

	</div>
</template>



<script>
//import axios from 'axios';
import ListEvents from '../global_helpers/ListEvents.vue';
import ListAgeGroupsDefault from '../global_helpers/ListAgeGroupsDefault.vue';
import ListYears from '../global_helpers/ListYears.vue';
import ListDepth from '../global_helpers/ListDepth.vue';
import ListType from '../global_helpers/ListType.vue';

export default {
	data() {
		return {
			token: null,
			isMobile: false,
			queryParams: {
				ageGroup: 'MS',
				list_depth: '250',
				list_type: '0',
				eventID: '1',
				year: '2019'
			},
			
			resultsList: [],
			illegal_wind: [],
			current_nz_record: [],

			loading: false,
			expand: false,
			headers: [
				{ text: 'Rank', value: 'resultID', sortable: false},
				{ text: 'Perf', value: 'performance', sortable: false},
				{ text: 'Wind', value: 'wind', sortable: false},
				{ text: 'Athlete', value: 'athlete', sortable: false, width: '200px'},
				{ text: 'Centre', value: 'center', sortable: false},
				{ text: 'DOB', value: 'center', sortable: false},
				{ text: 'Place', value: 'placing', sortable: false},
				{ text: 'Comp', value: 'competition', sortable: false},
				{ text: 'Venue', value: 'venue', sortable: false},
				{ text: 'Date', value: 'date', sortable: false}
			]
		}
	},

	components: {
		'ListEvents': ListEvents,
		'ListAgeGroupsDefault': ListAgeGroupsDefault,
		'ListYears': ListYears,
		'ListDepth': ListDepth,
		'ListType': ListType
	},

	computed: {

		// rankedItems() {
  //       	const items = [];
	 //        if (this.resultsList.length > 0) {
	 //            items[0] = this.resultsList[0];
	 //            items[0].rank = 1;
	 //            for (let index = 1; index < this.resultsList.length; index++) {
	 //                items[index] = this.resultsList[index];
	 //                if (items[index].time === items[index - 1].time 
	 //                	&& items[index].distHeight === items[index - 1].distHeight
	 //                	&& items[index].points === items[index - 1].points ) {
	 //                    items[index].rank = "";
	 //                } else {
	 //                    items[index].rank = index + 1;
	 //                }
	 //            }
	 //        }
	 //        return items;
	 //    }
	},

	methods: {

		onResize() {
          if (window.innerWidth < 769)
            this.isMobile = true;
          else
            this.isMobile = false;
        },

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
			this.loading = true;
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
				this.illegal_wind = response.data.illegal_wind;
			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})
			.finally(() => this.loading = false);

		}
	},

	mounted() {
		this.fetchQueryStringParams();
		this.fetchFormParams();
		this.onResize();
	},	
}
</script>



<style lang="scss">

	#annual-lists {

		
	}

		

	@media screen and (max-width: 768px) {

		#annual-lists {

			.v-expansion-panel__header {
				padding: 5px 15px;
			}
			.mobile.v-expansion-panel .v-expansion-panel__container:nth-child(even)  {
				border-left: 6px solid #FF9800;
			}
			.mobile.v-expansion-panel .v-expansion-panel__container:nth-child(odd)  {
				border-left: 6px solid #00bcd4;
			}
			.mobile ul.flex-content li:before {
				content: attr(data-label)':';
				padding-right: 10px;
				text-align: left;
				color: #999;
			}
			.mobile ul.flex-content {
				list-style: none;
				padding-left: 0
			}
		}
	}

</style>