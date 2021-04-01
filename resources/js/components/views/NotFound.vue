<template>
	<div id="notfound">
		<div class="notfound-column">
			<h2>
				404
			</h2>
			<a @click.prevent="goBack">Go back</a>
		</div>
	</div>
</template>
<script>
	export default{
		mounted() {
			console.log('NotFound component mounted');
		},
		methods: {
			goBack: function () {
				window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/');
			}
		}
	}
</script>