<template>
	<div id="settings-page">
		<div class="settings-header">
			Settings
		</div>
		<div class="settings-form">
			<settings-from></settings-from>
		</div>
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