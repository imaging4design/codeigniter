<template>
	<v-app>

		<!-- Include navigation component -->
		<navigation></navigation>

		<v-container fluid class="mt-5 mb-5">
			<v-layout>
				<v-flex>
					<v-card class="elevation-0">
						
						<!-- Include page contents -->
						<router-view></router-view>

					</v-card>
				</v-flex>
			</v-layout>
		</v-container>

		<!-- Include global footer -->
		<!-- <global-footer></global-footer> -->

	</v-app>
</template>


<script>
	export default {
		data(){
			return {
				binding: false
			}
		}
	};
</script>


<style lang="scss">

</style>
