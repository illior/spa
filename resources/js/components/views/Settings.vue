<template>
	<div id="settings-page">
		Settings
	</div>
</template>
<script>
	export default{
		mounted() {
			console.log('Settings component mounted');
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