<template>
	<header id="header-component">
		<div class="header-row container">
			<div class="header-logo">
				<h1><router-link to="/">My App</router-link></h1>
			</div>
			<div class="header-content">
				<login-header v-if="!$store.getters.auth"></login-header>
				<user-header v-if="$store.getters.auth"></user-header>
			</div>
		</div>
	</header>
</template>
<script>
	export default{
		mounted() {
			console.log('Header component mounted');
		}
	}
</script>