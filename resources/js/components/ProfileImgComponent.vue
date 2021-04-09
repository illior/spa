<template>
	<div class="img-ico">
		<img v-src="'profile/' + source">
	</div>
</template>
<script>
	export default {
		mounted () {

		},
		props: [
			'source'
		]
	}
</script>