<template>
	<div class="user-header">
		<div id="header-notification" v-bind:class="{active: notice}" @click.prevent="showNotice">
			Notifications
		</div>
		<div id="user-notification" v-if="notice" v-click-outside-notice="closeNotice">
			<div class="notification-header">
				Recently
			</div>
			<div class="notification-list">
				<div class="notice">
					<div class="notice-pic">
						<profile-img :source="user.photo"></profile-img>
					</div>
					<div class="notice-content">
						<div class="notice-header">
							SomeBody
						</div>
						<div class="notice-text">
							Do something
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="header-menu" v-bind:class="{active: menu}" @click.prevent="showMenu">
			{{ user.name }} <profile-img :source="user.photo"></profile-img>  <i class="arrow down"></i>
		</div>
		<div id="user-menu" v-if="menu" v-click-outside-menu="closeMenu">
			<ul>
				<li @click="closeMenu">
					<router-link :to="{ name: 'profile', params: { link: user.link } }">Profile</router-link>
				</li>
				<li @click="closeMenu">
					<router-link :to="{ name: 'settings' }">Settings</router-link>
				</li>
				<li>
					<a href="/logout" @click.prevent="logout">Logout</a>
				</li>
			</ul>
		</div>
	</div>
</template>
<script>
	export default{
		mounted() {
			console.log('UserHeader component mounted');
		},
		data: function () {
			return {
				menu: false,
				notice: false
			}
		},
		computed: {
			user: function () {
				return this.$store.getters.user;
			}
		},
		methods: {
			logout: function () {
				this.closeMenu();
				axios.post('/api/logout').then(reponse => {
					this.$store.dispatch('logoutUser');
					this.$router.push({ 'name': 'sign-in' })
				})
			},
			showMenu: function () {
				this.menu = !this.menu;
			},
			closeMenu: function () {
				this.menu = false;
			},
			showNotice: function () {
				this.notice = !this.notice;
			},
			closeNotice: function () {
				this.notice = false;
			}
		},
		directives: {
			'click-outside-menu': {
				bind: function (el, binding, vnode) {
					el.clickOutsideEvent = function (event) {
						// here I check that click was outside the el and his children
						if (!(el == event.target || el.contains(event.target))) {
							let button = document.getElementById('header-menu');

							if (!(event.target == button || button.contains(event.target))) {
								// and if it did, call method provided in attribute value
								vnode.context[binding.expression](event);
							}
						}
					};
					document.body.addEventListener('click', el.clickOutsideEvent)
				},
				unbind: function (el) {
					document.body.removeEventListener('click', el.clickOutsideEvent)
				},
			},
			'click-outside-notice': {
				bind: function (el, binding, vnode) {
					el.clickOutsideEvent = function (event) {
						// here I check that click was outside the el and his children
						if (!(el == event.target || el.contains(event.target))) {
							let button = document.getElementById('header-notification');

							if (!(event.target == button || button.contains(event.target))) {
								// and if it did, call method provided in attribute value
								vnode.context[binding.expression](event);
							}
						}
					};
					document.body.addEventListener('click', el.clickOutsideEvent)
				},
				unbind: function (el) {
					document.body.removeEventListener('click', el.clickOutsideEvent)
				},
			}
		}
	}
</script>