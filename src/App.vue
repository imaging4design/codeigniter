<template>
	<div id="app">
		<header>
			<p>This is my header</p>
		</header>
		<navigation></navigation>
		<router-view></router-view>
		<footer>
			<p>this is my footer</p>
		</footer>
	</div>
</template>

<script>

export default {
};
</script>





<style lang="scss">
#app {
	//font-family: 'Avenir', Helvetica, Arial, sans-serif;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	text-align: left;
	color: #2c3e50;
	margin-top: 60px;

	ul {
		list-style-type: none;
		padding: 0;
	}

	li {
		margin: 0 10px;
	}

	li a.router-link-active,
	li a.router-link-exact-active {
		color: #fff;
		background-color: #17a2b8;
		cursor: pointer;
	}

	.fade-enter-active, .fade-leave-active {
		transition: opacity .9s;
	}
	.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
		opacity: 0;
	}
}

</style>
