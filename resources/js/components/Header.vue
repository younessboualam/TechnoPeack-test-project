<script setup>
	import { useStore } from 'vuex'
	import { computed } from 'vue'
	import { useApi } from '../hooks'

	const store = useStore()
	const { execute, results } = useApi()
	
	const loggedIn = computed(() => {
		return store.getters.authenticated
	})
	
	const user = computed(() => {
		return store.getters.user
	})

	function logout () {
		execute({
			url: '/api/logout',
			method: 'post'
		})

		results.value = []
		store.dispatch('logout')
	}
</script>

<template>
	<div class="max-w-7xl mx-auto px-4 sm:px-6">
		<div class="flex justify-between items-center border-b-2 border-gray-100 py-6 md:justify-start md:space-x-10">
			<div class="flex justify-start lg:w-0 lg:flex-1">
				<a href="#">
					<img class="h-8 w-auto sm:h-10" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="" />
				</a>
			</div>

			<div v-if="!loggedIn && user" class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">
				<router-link :to="{ name: 'Login' }" class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900">Sign in</router-link>
				<router-link :to="{ name: 'Register' }" class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">Sign up</router-link>
			</div>

			<div v-else class="flex items-center">
				<div class="flex-shrink-0">
					<img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
				</div>
		
				<div class="ml-3">
					<div class="text-base font-medium leading-none">{{ user.name }}</div>
					<div class="text-sm font-medium leading-none text-gray-400">{{ user.email }}</div>
				</div>

				<app-button
					@button:click="logout"
					class="ml-8 whitespace-nowrap"
				>
					Logout
				</app-button>
			</div>
		</div>
	</div>
</template>