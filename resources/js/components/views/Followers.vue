<template>
	<div id="followers-page">
		<div class="followers-header">
			Followers:
		</div>
		<div class="followers-body">
			<div class="follower" v-for="user in followers">
				<div class="follower-img">
					<img v-src="'profile/' + user.photo">
				</div>
				<div class="follower-title">
					<router-link :to="{ name: 'profile', params: { link: user.link }}">{{ user.name }}</router-link>
					<div class="follower-menu">
						<div class="menu">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	export default{
		mounted() {
			console.log('Followers component mounted ');

			axios.get(`/api/user?action=getFollowers&id=${this.id}`).then(response => {
				this.followers = response.data.followers;
			}).catch(error => {

			});
		},
		props: [
			'id'
		],
		computed: {
			userProfile: function () {
				return this.$store.getters.user;
			}
		},
		data: function () {
			return {
				followers: {}
			}
		},
		methods: {
			
		}
	}
</script>