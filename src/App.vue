<template>
	<v-app>

		<!-- 
		|*********************************************************
		| LEFT COLUMN NAVIGATION 
		|*********************************************************
		-->
		<v-navigation-drawer fixed v-model="drawer" app>
			<div class="v-toolbar__content secondary" style="height: 64px;">
				<div class="v-toolbar__title white--text">Main Menu</div>
			</div>

			<v-list class="pa-0">

				<v-list-tile @click="" to="/top-perfs" exact>
					<v-list-tile-action>
						<v-icon class="secondary--text">bookmark</v-icon>
					</v-list-tile-action>
					<v-list-tile-content>
						<v-list-tile-title>{{new Date().getFullYear()}} LEADERS</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>

				<v-divider></v-divider>
				
				<v-list-tile @click="" to="/annual-lists" exact>
					<v-list-tile-action>
						<v-icon class="secondary--text">format_line_spacing</v-icon>
					</v-list-tile-action>
					<v-list-tile-content>
						<v-list-tile-title>ANNUAL LISTS</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>

				<v-divider></v-divider>

				<v-list-tile @click="" to="/all-time-lists" exact>
					<v-list-tile-action>
						<v-icon class="secondary--text">event_note</v-icon>
					</v-list-tile-action>
					<v-list-tile-content>
						<v-list-tile-title>ALL TIME LISTS</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>

				<v-divider></v-divider>

				<v-list-tile @click="" to="/nz-records" exact>
					<v-list-tile-action>
						<v-icon class="secondary--text">timer</v-icon>
					</v-list-tile-action>
					<v-list-tile-content>
						<v-list-tile-title>RECORDS</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>

				<v-divider></v-divider>

				<v-list-tile @click="" to="/profiles" exact>
					<v-list-tile-action>
						<v-icon class="secondary--text">account_circle</v-icon>
					</v-list-tile-action>
					<v-list-tile-content>
						<v-list-tile-title>ATHLETE PROFILES</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>

				<v-divider></v-divider>

			</v-list>
		</v-navigation-drawer>

		<!-- 
		|*********************************************************
		| TOP TOOLBAR NAVIGATION  
		|*********************************************************
		-->
		<v-toolbar color="primary" dark fixed app>
			<v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
			<v-toolbar-title>Athletics NZ Rankings</v-toolbar-title>
			<v-spacer></v-spacer>
			<v-toolbar-items class="hidden-sm-and-down">

				<v-btn flat to="/top-perfs" exact>{{new Date().getFullYear()}} Leaders</v-btn>
				<v-btn flat to="/annual-lists" exact>Annual Lists</v-btn>
				<v-btn flat to="/all-time-lists" exact>All Time Lists</v-btn>
				<v-btn flat to="/nz-records" exact>Records</v-btn>
				<v-btn flat to="/profiles" exact>Profiles</v-btn>

			</v-toolbar-items>
		</v-toolbar>

		<!-- 
		|*********************************************************
		| IMPORT ROUTER-VIEW (CONTENT) 
		|*********************************************************
		-->
		<v-content>
			<v-container fluid >
				<v-layout justify-center align-center>
					<v-flex>
						<router-view></router-view>
					</v-flex>
				</v-layout>
			</v-container>
		</v-content>

		<!-- 
		|*********************************************************
		| GLOBAL FOOTER 
		|*********************************************************
		-->
		<v-footer color="primary" app inset>
			<span class="white--text pl-3">&copy;Copyright {{footerDate}} - Athletics New Zealand</span>
		</v-footer>

	</v-app>
</template>


<script>
	export default {
		data(){
			return {
				drawer: null,
				binding: false,
				footerDate: new Date().getFullYear()
			}
		}
	};
</script>


<style lang="scss">

</style>
