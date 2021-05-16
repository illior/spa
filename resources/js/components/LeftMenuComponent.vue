<template>
	<div id="left-menu">
		<ul>
			<li>
				<router-link :to="{ name: 'profile', params: { link: user.link }}">Profile</router-link>
			</li>
			<li>
				<router-link :to="{ name: 'feed' }">Feed</router-link>
			</li>
			<li>
				<router-link :to="{ name: 'messages' }">Messages</router-link>
			</li>
			<li>
				<router-link :to="{ name: 'followers', params: { id: user.id }}">Followers</router-link>
			</li>
			<li>
				<router-link :to="{ name: 'followings', params: { id: user.id }}">Followings</router-link>
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