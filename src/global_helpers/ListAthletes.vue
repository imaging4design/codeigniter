<template>

	<!-- <v-container grid-list-xl>
		<v-layout row wrap>
			<v-flex xs12 md6> -->

				<!-- <v-card
					class="hide-overflow"
					color="secondary"
					hide-selected="true"
					dark>
					<v-card-text> -->
						<v-autocomplete
							v-on:input="onHit(athleteID)"
							v-model="athleteID"
							:items="listOfAthletes"
							:filter="customFilter"
							color="secondary"
							item-value="athleteID"
							item-text="name"
							label="Enter athlete name"
							solo>
						</v-autocomplete>
					<!-- </v-card-text>

				</v-card> -->

			<!-- </v-flex>
		</v-layout>
	</v-container>	 -->

</template>




<script>
export default {
	data () {
		return {
			athleteID:[],
			hasSaved: false,
			isEditing: null,
			model: null,
			listOfAthletes: []
		}
	},

	methods: {

	    onHit (item) {
			// Call the 'athleteData' method on the parent
			this.$parent.getAthleteData(this.athleteID);
		},

		fetchAthletes() {
			console.log('hello')
			this.$http.get('site/Home_con/get_auto_athletes')
			.then((response) => {
				this.listOfAthletes = response.data;
				//console.log(this.listOfAthletes);

			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})
		},

		customFilter (item, queryText, itemText) {
	        const textOne = item.name.toLowerCase()
	        const textTwo = item.athleteID.toLowerCase()
	        const searchText = queryText.toLowerCase()

	        return textOne.indexOf(searchText) > -1 ||
	          textTwo.indexOf(searchText) > -1
	      },
	      save () {
	        this.isEditing = !this.isEditing
	        this.hasSaved = true
	      }
	},

	mounted(){
		this.fetchAthletes();
	}
}

</script>