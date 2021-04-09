<template>
	<div id="friends-page">
		Friends
	</div>
</template>
<script>
	export default{
		mounted() {
			console.log('Friends component mounted');
		},
		props: [
			'id'
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