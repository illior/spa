<template>
	<div class="login-form">
		<input type="email" placeholder="Email" v-model="form.email">
		<input type="password" placeholder="Password" v-model="form.password">
		<p v-if="error" class="login-error">
			{{ message }}
		</p>
		<button type="submit" @click.prevent="login">Sign in</button>
	</div>
</template>
<script>
	export default{
		mounted () {
			console.log('LoginForm component mounted');
		},
		data: function () {
			return {
				form: {
					email: '',
					password: ''
				},
				error: false,
				message: 'Hello'
			}
		},
		methods: {
			login: function () {
				axios.post('/api/login', this.form).then(response => {
					if (response.data.status == true) {
						this.$store.dispatch('loginUser', response.data.user);
						this.$router.push({ name: 'profile', params: { link: response.data.user.link } })
					} else {
						this.error = true;
						this.message = response.data.message;
					}
				}).catch(error => {
					console.log(error);
				})
			}
		}
	}
</script>