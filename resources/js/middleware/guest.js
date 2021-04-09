export default async function guest ({ next, store, nextMiddleware }){
	let auth = await store.dispatch('getAuth');

	if (auth) {
		return next({
			name: 'profile',
			params: {
				link: store.getters.user.link
			}
		});
	}

	return nextMiddleware()
}