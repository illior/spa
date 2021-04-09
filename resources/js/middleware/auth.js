export default async function auth ({ next, store, nextMiddleware }){
	let auth = await store.dispatch('getAuth');

	if (!auth) {
		return next({
			name: 'sign-in'
		});
	}

	return nextMiddleware()
}