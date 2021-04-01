<template>
	<a @click.prevent="logout">Logout</a>
</template>
<script>
	export default{
		mounted() {
			console.log('UserHeader component mounted');
		},
		computed: {
			user: function () {
				return this.$store.getters.user;
			}
		},
		methods: {
			logout: function () {
				axios.post('/api/logout').then(reponse => {
					this.$store.dispatch('logoutUser');
					this.$router.push({ 'name': 'sign-in' })
				})
			}
		}
	}
</script>