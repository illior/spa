<template>
	<div id="left-menu">
		<ul>
			<li>
				<router-link :to="{ name: 'profile', params: { link: user.link}}">Profile</router-link>
			</li>
			<li>
				<router-link :to="{ name: 'settings' }">Settings</router-link>
			</li>
			<li>
				<router-link :to="{ name: 'profile', params: { link: user.link}}">Profile</router-link>
			</li>
		</ul>
	</div>
</template>
<script>
	export default{
		mounted() {
			console.log('LeftMenu component mounted');
		},
		computed: {
			user: function () {
				return this.$store.getters.user;
			}
		},
		methods: {

		}
	}
</script>