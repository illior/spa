<template>
	<div id="user-notification" >
		<div class="notification-header">
			Recently
		</div>
		<div class="notification-list">
			<div class="notice" v-for="notice in this.$store.getters.notices">
				<div class="notice-pic">
					<profile-img :source="notice.photo"></profile-img>
				</div>
				<div class="notice-content">
					<div class="notice-header">
						{{ notice.name }}
					</div>
					<div class="notice-text">
						{{ notice.message }}
					</div>
				</div>
			</div>
			<div class="clear-notice" v-if="this.$store.getters.notices.length == 0">
				So far empty
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		mounted () {
			console.log('NotificationsComponent mounted');
			
			this.$store.dispatch('readAllNotices');
		}
	}
</script>