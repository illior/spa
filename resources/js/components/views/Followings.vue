<template>
	<div id="followers-page">
		<div class="followers-header">
			Followings:
		</div>
		<div class="followers-body">
			<div class="follower" v-for="user in followings">
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
			console.log('Followings component mounted ');

			axios.get(`/api/user?action=getFollowings&id=${this.id}`).then(response => {
				this.followings = response.data.followings;
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
				followings: {}
			}
		},
		methods: {
			
		}
	}
</script>