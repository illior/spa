<template>
	<div id="profile-page">
		Name: {{ userProfile.name }}
	</div>
</template>
<script>
	export default{
		mounted() {
			console.log('Profile component mounted');
		},
		props: [
			'link'
		],
		computed: {
			userProfile: function () {
				return this.$store.getters.user;
			}
		},
		methods: {
			
		}
	}
</script>