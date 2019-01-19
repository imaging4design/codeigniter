<template>
	<div>

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

	</div>
</template>

<script>
	export default {
	};
</script>