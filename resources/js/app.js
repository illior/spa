/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import VueRouter from 'vue-router';
import routes from './routes';
import Vuex from 'vuex';
import store from './store';

Vue.component('login-header', require('./components/LoginHeaderComponent.vue').default);
Vue.component('user-header', require('./components/UserHeaderComponent.vue').default);
Vue.component('login-form', require('./components/LoginFormComponent.vue').default);
Vue.component('register-form', require('./components/RegisterFormComponent.vue').default);
Vue.component('settings-from', require('./components/SettingsFormComponent.vue').default);
Vue.component('profile-img', require('./components/ProfileImgComponent.vue').default);

Vue.use(VueRouter);
const VueRoutes = new VueRouter(routes);

Vue.use(Vuex);
const VueStore = new Vuex.Store(store);

import middlewarePipeline from './middleware/middlewarePipeline'

VueRoutes.beforeEach((to, from, next) => {
	if (!to.meta.middleware) {
		return next();
	}
	const middleware = to.meta.middleware;

	const context = {
		to,
		from,
		next,
		store: VueStore
	}

	return middleware[0]({
		...context,
		nextMiddleware: middlewarePipeline(context, middleware, 1)
	})
});

Vue.directive('src', {
	bind: function (el, binding) {
		el.src = 'http://app.test/storage/' + binding.value;
	},
	update: function (el, binding) {
		el.src = 'http://app.test/storage/' + binding.value;
	}
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
	el: '#app',
	router: VueRoutes,
	store: VueStore,
});
