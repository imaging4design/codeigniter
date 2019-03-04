<template>
	<div id="all-time-lists">

		<!-- 
		|*********************************************************
		| PAGE TITLE
		|*********************************************************
		-->
		<v-container grid-list-xl fluid pa-0>
			<v-layout row wrap>
				<v-flex>
					<h1 class="display-1 font-weight-light primary--text">All Time Lists</h1>
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
					<v-flex xs12 md4 sm4 py-0>
						<list-events v-model="queryParams.eventID"></list-events>
					</v-flex>
					<v-flex xs12 md4 sm4 py-0>
						<list-age-groups-all-time v-model="queryParams.ageGroup"></list-age-groups-all-time>
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

								{{ item.time | removeLeadZeros }} {{ item.distHeight | removeLeadZeros }} {{ item.points | removeLeadZeros }}<br>
								{{ item.nameFirst }} {{ item.nameLast }}

							</div>
							<v-card>
								<v-card-text>
									<ul class="flex-content">
									<li class="flex-item" data-label="Wind">{{ item.wind }}</li>
									<li class="flex-item" data-label="Centre">{{ item.centreID }}</li>
									<li class="flex-item" data-label="DOB">{{ item.DOB }}</li>
									<li class="flex-item" data-label="Venue">{{ item.venue }}</li>
									<li class="flex-item" data-label="Date">{{ item.date }}</li>
								</ul>
								</v-card-text>
							</v-card>
						</v-expansion-panel-content>
					</v-expansion-panel>

				</div>

			</div><!-- ENDS column -->

		</div><!-- ENDS columns -->

	</div>	

</template>



<script>
import ListEvents from '../global_helpers/ListEvents.vue';
import ListAgeGroupsAllTime from '../global_helpers/ListAgeGroupsAllTime.vue';

export default {
	data() {
		return {
			token: null,
			isMobile: false,
			queryParams: {
				ageGroup: 'MS',
				list_depth: '50',
				list_type: '0',
				eventID: '1',
				year: 1900,
				searchType: 'allTime'
			},
			
			resultsList: [],

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
		'ListAgeGroupsAllTime': ListAgeGroupsAllTime
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
	 //                    items[index].rank = '=';
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
				year: this.$route.query.year ? this.$route.query.year : this.queryParams.year,
				searchType: this.$route.query.searchType ? this.$route.query.searchType : this.queryParams.searchType
			}
			this.fetchFormParams();
		},

		fetchFormParams() {
			this.loading = true;
			this.$router.push({
				path: '/all-time-lists', 
				query: this.queryParams
			});

			this.$http.get('site/Results_con/index', {
				params: this.queryParams
			})
			.then((response) => {
				this.token = response.data.token;
				this.resultsList = response.data.lists;
				console.log(this.resultsList)
			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})
			.finally(() => this.loading = false);

		}
	},

	mounted() {
		this.fetchQueryStringParams();
		// this.fetchFormParams();
		this.onResize();
	},
}
</script>



<style lang="scss">

	#all-time-lists {

		
	}

		

	@media screen and (max-width: 768px) {

		#all-time-lists {

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