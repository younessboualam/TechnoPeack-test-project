<script setup>
	import { RefreshIcon } from '@heroicons/vue/outline'
	import { ref, computed } from 'vue'

	import { useStore } from 'vuex'
	import { useApi } from '@/hooks'
	
	const store = useStore()
	const { execute } = useApi()

	const user = ref({})
	const isProcessing = ref(false)
	
	const errors = computed(() => store.getters.errors)

	function login () {
		isProcessing.value = true

		execute({
			url: '/sanctum/csrf-cookie'
		})

		store.dispatch('login', user.value)
		isProcessing.value = false

		user.value = {}
	}
</script>

<template>
	<div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
		<div class="max-w-md w-full space-y-8">
			<div>
				<img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow" />
				<h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Sign in to your account</h2>
			</div>

			<form class="mt-8 space-y-6" @submit.prevent="login">
				<input type="hidden" name="remember" value="true" />

				<div class="rounded-md shadow-sm -space-y-px">
					<div>
						<label for="email-address" class="sr-only">Email address</label>
						<input id="email-address" v-model="user.email" type="email" autocomplete="email" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address" />
					</div>
					
					<div>
						<label for="password" class="sr-only">Password</label>
						<input id="password" v-model="user.password" type="password" autocomplete="current-password" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password" />
					</div>
				</div>

				<div class="flex items-center justify-between">
					<div class="flex items-center">
						<input id="remember-me" v-model="user.remember_me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
						<label for="remember-me" class="ml-2 block text-sm text-gray-900"> Remember me </label>
					</div>

					<div class="text-sm">
						<a href="#" class="font-medium text-indigo-600 hover:text-indigo-500"> Forgot your password? </a>
					</div>
				</div>

				<p v-if="errors" class="text-red-500">{{ errors }}</p>

				<div>
					<app-button :disabled="isProcessing" type="submit" class="w-full flex items-center justify-center">
						<refresh-icon v-if="isProcessing" class="h-4 w-4 animate-spin" />
						<span class="ml-3">Sign in</span>
					</app-button>
				</div>
			</form>
		</div>
	</div>
</template>