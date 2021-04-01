<template>
	<div class="login-header">
		<div class="header-link">
			<router-link :to="($route.name != 'sign-in') ? '/' : '/sign-up'">
				{{ ($route.name != 'sign-in') ? 'Sign In' : 'Sign Up' }}
			</router-link>
		</div>
	</div>
</template>
<script>
	export default{
		mounted() {
			console.log('LoginHeader component mounted');
		}
	}
</script>