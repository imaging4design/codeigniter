<template>

	<div>

		<v-navigation-drawer 
			v-model="drawer" 
			temporary 
			absolute 
			width = "200"
			id = "drawer">
		</v-navigation-drawer>
		
		<v-toolbar fixed scroll-off-screen color="primary" dark>
			<v-toolbar-side-icon  @click.stop="drawer = !drawer" class="hidden-md-and-up"></v-toolbar-side-icon>
			<!-- <v-toolbar-side-icon></v-toolbar-side-icon> -->
			<v-toolbar-title>Athletics NZ Rankings</v-toolbar-title>
			<v-spacer></v-spacer>
			<v-toolbar-items class="hidden-sm-and-down">

				<v-btn flat to="/annual-lists" exact>Annual Lists</v-btn>
				<v-btn flat to="/all-time-lists" exact>All Time Lists</v-btn>
				<v-btn flat to="/nz-records" exact>Records</v-btn>
				<v-btn flat to="/top-perfs" exact>Top Lists</v-btn>
				<v-btn flat to="/profiles" exact>Profiles</v-btn>

			</v-toolbar-items>
		</v-toolbar>

		

	</div>


	<!-- <div>

		<nav class="navbar" role="navigation" aria-label="main navigation">
			<div class="navbar-brand">
				<a class="navbar-item" href="https://bulma.io">
					<img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
				</a>

				<a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
					<span aria-hidden="true"></span>
					<span aria-hidden="true"></span>
					<span aria-hidden="true"></span>
				</a>
			</div>

			<div id="navbarBasicExample" class="navbar-menu">
				<div class="navbar-start">
					<router-link to="/annual-lists" class="navbar-item">Annual Lists</router-link>
					<router-link to="/nz-records" class="navbar-item">Records</router-link>
					<router-link to="/top-perfs" class="navbar-item">Top Performances</router-link>
					<router-link to="/profiles" class="navbar-item">Profiles</router-link>
				</div>
			</div>
		</nav>

	</div> -->


</template>

<script>
	export default {
		data() {
			return {
				drawer: null
			}
		}
	};
</script>