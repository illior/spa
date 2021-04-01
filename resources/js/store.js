export default{
	state: {
		auth: null,
		appStart: false,
		user: {}
	},
	getters: {
		auth: state => {
			return state.auth;
		},
		user: state => {
			return state.user;
		}
	},
	mutations: {
		setAuthTrue: state => {
			state.auth = true;
		},
		setAuthFalse: state => {
			state.auth = false;
		},
		setUser: (state, payload) => {
			state.user = payload;
		},
		clearUser: state => {
			state.user = {};
		}
	},
	actions: {
		startApp: async context => {
			context.state.appStart = true;
			await axios.get('/api/athenticated').then(response => {
				context.commit('setUser', response.data.user);
				context.commit('setAuthTrue');
			}).catch(error => {
				context.commit('setAuthFalse');
			});

			return context.state.auth;
		},
		loginUser: (context, payload) => {
			context.commit('setUser', payload);
			context.commit('setAuthTrue');
		},
		logoutUser: context => {
			context.commit('clearUser');
			context.commit('setAuthFalse');
		},
		getAuth: async context => {
			let auth = context.state.auth;
			if (!context.state.appStart) {
				auth = await context.dispatch('startApp');
			}
			return auth;
		}
	}
}