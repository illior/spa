// Components
import SignIn from './components/views/SignInComponent.vue';
import NotFound from './components/views/NotFound.vue';

export default{
	mode: 'history',
	routes: [
		{
			path: '/',
			name: 'sign-in',
			component: SignIn
		},
		{
			path: '*',
			name: 'NotFound',
			component: NotFound
		}
	]
}