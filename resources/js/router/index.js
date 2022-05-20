import { createRouter, createWebHistory } from 'vue-router'

import Login from '../pages/Login.vue'
import Register from '../pages/Register.vue'

import List from '../pages/products/List.vue'
import Create from '../pages/products/Create.vue'
import Edit from '../pages/products/Edit.vue'

const routes = [{
	path: '/',
	redirect: 'Login',
}, {
	path: '/login',
	name: 'Login',
	component: Login,
	meta: { guest: true }
}, {
	path: '/register',
	name: 'Register',
	component: Register,
	meta: { guest: true }
}, {
	path: '/products',
	name: 'Products.List',
	component: List,
	meta: { requiresAuth: true }
}, {
	path: '/products/create',
	name: 'Products.Store',
	component: Create,
	meta: { requiresAuth: true }
}, {
	path: '/products/:id',
	name: 'Products.Edit',
	component: Edit,
	meta: { requiresAuth: true }
}, 
// {
// 	path: '/:pathMatch(.*)*',
// 	redirect: 'Login'
// }
]

const router = createRouter({
	history: createWebHistory(),
	routes
})

router.beforeEach((to, from, next) => {
	const token = localStorage.getItem("token")
	
	if (to.meta.requiresAuth && !token) {
		next({ name: 'Login' })
	}

	if (to.meta.guest && token) {
		next({ name: 'Products.List' })
	}

	next()
})

export default router