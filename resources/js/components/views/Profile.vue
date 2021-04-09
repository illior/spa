<template>
	<div id="profile-page">
		<div class="profile-column">
			<div class="profile-img">
				<div class="img-container">
					<img v-src="'profile/' + userProfile.photo">
				</div>
			</div>
			<div class="profile-follow" v-if="user.id != userProfile.id">
				<button @click.prevent="follow">
					Add to Friends
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
					Not yet
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

				}).catch(error => {

				});
			}
		}
	}
</script>