<template>
	<div id="feed-page">
		Feed
	</div>
</template>
<script>
	export default{
		mounted() {
			console.log('Feed component mounted');
		},
		computed: {
			userProfile: function () {
				return this.$store.getters.user;
			}
		},
		methods: {
			
		}
	}
</script>