<template>
  <v-card
    class="hide-overflow"
    color="purple lighten-1"
    dark
  >
    <v-toolbar
      card
      color="purple"
    >
      <v-icon>mdi-account</v-icon>
      <v-toolbar-title class="font-weight-light">User Profile</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn
        color="purple darken-3"
        fab
        small
        @click="isEditing = !isEditing"
      >
        <v-icon v-if="isEditing">mdi-close</v-icon>
        <v-icon v-else>mdi-pencil</v-icon>
      </v-btn>
    </v-toolbar>
    <v-card-text>
      <v-text-field
        :disabled="!isEditing"
        color="white"
        label="Name"
      ></v-text-field>
      <v-autocomplete
      	@change="pushOrRemoveStates"
      	v-model="selected"
        :disabled="!isEditing"
        :items="states"
        :filter="customFilter"
        color="white"
        item-text="name"
        item-value="key"
        label="State"
        return-object
      ></v-autocomplete>
    </v-card-text>
    <v-divider></v-divider>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn
        :disabled="!isEditing"
        color="success"
        @click="save"
      >
        Save
      </v-btn>
    </v-card-actions>
    <v-snackbar
      v-model="hasSaved"
      :timeout="2000"
      absolute
      bottom
      left
    >
      Your profile has been updated
    </v-snackbar>
  </v-card>
</template>




<script>
export default {
	data () {
		return {
			selected:['goo'],
			hasSaved: false,
			isEditing: null,
			model: null,
			//states: []
			states: [
	          { name: 'Florida', abbr: 'FL', id: 1 },
	          { name: 'Georgia', abbr: 'GA', id: 2 },
	          { name: 'Nebraska', abbr: 'NE', id: 3 },
	          { name: 'California', abbr: 'CA', id: 4 },
	          { name: 'New York', abbr: 'NY', id: 5 }
	        ]
		}
	},

	methods: {

		pushOrRemoveStates(){
	      alert(this.selected);
	    },

		fetchAthletes() {
			console.log('hello')
			this.$http.get('site/Home_con/get_auto_athletes')
			.then((response) => {
				this.states = response.data;
				console.log(this.states);

			})
			.catch((error) => {
				console.error('GAVINS ERROR: ' + error);
			})
		},

		customFilter (item, queryText, itemText) {
			 const textOne = item.name.toLowerCase()
	        const textTwo = item.abbr.toLowerCase()
	        const searchText = queryText.toLowerCase()

			return textOne.indexOf(searchText) > -1 || textTwo.indexOf(searchText) > -1
		},

		save () {
			this.isEditing = !this.isEditing
			this.hasSaved = true
		}
	},

	mounted(){
		//this.fetchAthletes();
	}
}

</script>