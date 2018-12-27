<template>
	<div>
		<ul class="nav nav-pills">
			<!-- <li class="nav-item">
				<router-link to="/" class="nav-link" exact>Home</router-link>
			</li> -->
			<li class="nav-item">
				<router-link to="/records" class="nav-link">Records</router-link>
			</li>
			<li class="nav-item">
				<router-link to="/top-perfs" class="nav-link">Top Performances</router-link>
			</li>
		</ul>

		<router-view></router-view>
	</div>
</template>

<script>
	export default {
	};
</script>