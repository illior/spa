export default{
	state: {
		auth: null,
		appStart: false,
		user: {},
		notices: {},
		unreadNotice: false,
		followers: [],
		followings: []
	},
	getters: {
		auth: state => {
			return state.auth;
		},
		user: state => {
			return state.user;
		},
		notices: state => {
			return state.notices;
		},
		unread: state => {
			return state.unreadNotice;
		},
		followers: state => {
			return state.followers;
		},
		followings: state => {
			return state.followings;
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
		},
		pushNotice: (state, payload) => {
			state.notices.push(payload);
			state.unreadNotice = true;
			if (state.notices.length > 20) {
				state.notices.shift();
			}
		},
		loadNotices: (state, payload) => {
			state.unreadNotice = payload.some(function(notice) {
				return notice.visited == false;
			});

			state.notices = payload;
		}
	},
	actions: {
		startApp: async context => {
			context.state.appStart = true;
			await axios.get('/api/athenticated').then(response => {
				context.state.followers = response.data.relationship.followers;
				context.state.followings = response.data.relationship.followings;
				context.commit('setUser', response.data.user);
				context.commit('setAuthTrue');
			}).catch(error => {
				context.commit('setAuthFalse');
			});

			return context.state.auth;
		},
		loginUser: (context, payload) => {
			context.commit('setUser', payload.user);
			context.state.followers = payload.relationship.followers;
			context.state.followings = payload.relationship.followings;
			context.commit('setAuthTrue');
		},
		updateUser: (context, payload) => {
			context.commit('setUser', payload);
		},
		logoutUser: context => {
			context.commit('clearUser');
			context.commit('setAuthFalse');
			context.state.followers = [];
			context.state.followings = [];
		},
		getAuth: async context => {
			let auth = context.state.auth;
			if (!context.state.appStart) {
				auth = await context.dispatch('startApp');
			}
			return auth;
		},
		pushNotice: (context, payload) => {
			context.commit('pushNotice', payload);
		},
		loadNotices: (context, payload) => {
			context.commit('loadNotices', payload);
		},
		readAllNotices: context => {
			if (context.state.unreadNotice) {
				context.state.unreadNotice = false;

				axios.get('/api/user?action=readAllNotices').then(response => {

				}).catch(error => {

				});
			}
		},
		pushFollower: (context, payload) => {
			context.state.followers.push(payload);
		},
		removeFollower: (context, payload) => {
			context.state.followers.splice(context.state.followers.pos(payload), 1);
		},
		pushFollowing: (context, payload) => {
			context.state.followings.push(payload);
		},
		removeFollowing: (context, payload) => {
			context.state.followings.splice(context.state.followings.indexOf(payload), 1);
		},
	}
}