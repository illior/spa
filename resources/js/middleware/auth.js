export default async function auth ({ next, store, nextMiddleware }){
	//let auth = await store.dispatch('getAuth');
	let auth = await store.dispatch('getAuth');
	console.log(auth);

	if (!auth) {
		return next({
			name: 'sign-in'
		});
	}

	return nextMiddleware()
}