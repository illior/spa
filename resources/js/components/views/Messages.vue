<template>
	<div id="messages-page">
		Messages
	</div>
</template>
<script>
	export default{
		mounted() {
			console.log('Messages component mounted');
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