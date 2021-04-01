// Components
import SignIn from './components/views/SignIn.vue';
import SignUp from './components/views/SignUp.vue';
import NotFound from './components/views/NotFound.vue';
import Profile from './components/views/Profile.vue';
import Settings from './components/views/Settings.vue';

// Helpers
import Header from './components/HeaderComponent.vue';
import LeftMenu from './components/LeftMenuComponent.vue';

// Middleware
import guest from './middleware/guest';
import auth from './middleware/auth';

export default{
	mode: 'history',
	routes: [
		{
			path: '/',
			name: 'sign-in',
			components: {
				default: SignIn,
				header: Header,
				sidebar: null
			},
			meta: {
				middleware: [
					guest
				]
			}
		},
		{
			path: '/sign-up',
			name: 'sign-up',
			components: {
				default: SignUp,
				header: Header,
				sidebar: null
			},
			meta: {
				middleware: [
					guest
				]
			}
		},
		{
			path: '/user/:link',
			name: 'profile',
			components: {
				default: Profile,
				header: Header,
				sidebar: LeftMenu
			},
			props: true,
			meta: {
				middleware: [
					auth
				]
			}
		},
		{
			path: '/settings',
			name: 'settings',
			components: {
				default: Settings,
				header: Header,
				sidebar: LeftMenu
			},
			meta: {
				middleware: [
					auth
				]
			}
		},
		{
			path: '*',
			name: 'NotFound',
			components: {
				default: NotFound,
				header: null,
				sidebar: null
			}
		}
	]
}