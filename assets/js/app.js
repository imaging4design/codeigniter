Vue.config.devtools = true;

var app = new Vue({
	el: '#app',
	data: {
		url: 'http://localhost/codeigniter/',
		athletes: [],
		multi: [],
		relays: []
	},
	created() {
		//this.showAll();
		//this.showTopRelays()
	},
	methods: {
		showTopPerformers() {
			axios.get(this.url + 'site/Home_con/showTopPerformers')
			.then((response) => {
				this.athletes = response.data.topPerformers;
				console.log(response.data);
			})
		},
		showTopMultis() {
			axios.get(this.url + 'site/Home_con/showTopMultis')
			.then((response) => {
				this.multi = response.data.topPerformers_Multis;
				console.log(response.data);
			})
		},
		showTopRelays() {
			axios.get(this.url + 'site/Home_con/showTopRelays')
			.then((response) => {
				this.relays = response.data.topPerformers_Relays;
				console.log(response.data);
			})
		}

	} // ENDS methods
});