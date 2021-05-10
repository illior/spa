<template>
	<div id="profile-page">
		<div class="profile-column">
			<div class="profile-img">
				<div class="img-container">
					<img v-src="'profile/' + userProfile.photo">
				</div>
			</div>
			<div class="profile-follow" v-if="user.id != userProfile.id">
				<button @click.prevent="follow" v-if="!$store.getters.followings.includes(userProfile.id)">
					Add to Friends
				</button>
				<button @click.prevent="unfollow" v-if="$store.getters.followings.includes(userProfile.id)">
					Remove from friends
				</button>
			</div>
		</div>
		<div class="profile-column">
			<div class="profile-info">
				<div class="info-header">
					{{ userProfile.name }}
				</div>
				<div class="info-body">
					Information
				</div>
				<div class="info-footer">
					<div class="footer-column">
						Followers: {{ userProfile.followers }}
					</div>
					<div class="footer-column">
						Followings: {{ userProfile.followings }}
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	export default{
		mounted () {
			console.log('Profile component mounted');
			this.user = this.$store.getters.user;
			if (this.user.link == this.link) {
				this.userProfile = this.$store.getters.user;
			} else {
				this.getUser(this.link);
			}
		},
		beforeRouteUpdate (to, from, next) {
			if (this.user.link == to.params.link) {
				this.userProfile = this.$store.getters.user;
			} else {
				this.getUser(to.params.link);
			}
			next();
		},
		props: [
			'link'
		],
		data: function () {
			return {
				user: {},
				userProfile: {}
			}
		},
		methods: {
			getUser: function (link) {
				axios.get(`/api/user?action=getByLink&link=${link}`).then(response => {
					if (response.data.user == null) {
						this.$router.replace({ name: 'notFound', params: { '0': this.$route.path } });
					}
					this.userProfile = response.data.user;
				}).catch(error => {
					this.$router.replace({ name: 'notFound', params: { '0': this.$route.path } });
				});
			},
			follow: function () {
				axios.get(`/api/user?action=follow&id=${this.userProfile.id}`).then(response => {
					this.$store.dispatch('pushFollowing', this.userProfile.id);
				}).catch(error => {

				});
			},
			unfollow: function () {
				axios.get(`/api/user?action=unfollow&id=${this.userProfile.id}`).then(response => {
					this.$store.dispatch('removeFollowing', this.userProfile.id);
				}).catch(error => {

				});
			}
		}
	}
</script>