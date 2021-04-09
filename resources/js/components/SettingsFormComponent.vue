<template>
	<div class="info-form">
		<input type="text" v-model="form.name">
		<p class="settings-message" v-if="formSend">
			{{ message }}
		</p>
		<button type="submit" @click.prevenr="change">Change</button>
	</div>
</template>
<script>
	export default {
		mounted () {
			this.form.name = this.user.name;
		},
		computed: {
			user: function () {
				return this.$store.getters.user;
			}
		},
		data: function () {
			return {
				form: {
					name: ''
				},
				message: '',
				formSend: false
			}
		},
		methods: {
			change: function () {
				this.formSend = true;

				axios.get(`api/user?action=update&name=${this.form.name}`).then(response => {
					if (response.data.status) {
						this.message = 'Success';
						this.$store.dispatch('updateUser', response.data.user);
					} else {
						this.message = response.data.message;
					}
					
				}).catch(error => {
					this.message = 'Error';
				});
			}
		}
	}
</script>