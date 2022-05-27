import { createRouter, createWebHistory } from 'vue-router'

import Login from '@/pages/Login.vue'
import Register from '@/pages/Register.vue'

import Index from '@/pages/products/index'
import Create from '@/pages/products/create'
import Show from '@/pages/products/show'
import Edit from '@/pages/products/edit'

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
	component: Index,
	meta: { requiresAuth: true }
}, {
	path: '/products/create',
	name: 'Products.Store',
	component: Create,
	meta: { requiresAuth: true }
}, {
	props: true,
	path: '/products/:id',
	name: 'Products.Show',
	component: Show,
	meta: { requiresAuth: true }
}, {
	props: true,
	path: '/products/edit/:id',
	name: 'Products.Edit',
	component: Edit,
	meta: { requiresAuth: true }
}, {
	path: '/:pathMatch(.*)*',
	redirect: 'Login'
}]

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