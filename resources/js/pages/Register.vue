<script setup>
	import { ref, computed } from 'vue'
	import axios from 'axios'

	import { useStore } from 'vuex'
	import { useRouter } from 'vue-router'

	const errors = computed(() => store.getters.errors)
	
	const user = ref({})
	const isProcessing = ref(false)
	
	const store = useStore()
	const router = useRouter()

	function register () {
		isProcessing.value = true
		
		axios.get('/sanctum/csrf-cookie').then(res => {
			store.dispatch('register', user.value)
			isProcessing.value = false
		})
	}
</script>

<template>
	<div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
		<div class="max-w-md w-full space-y-8">
			<div>
				<img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow" />
				<h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Create new account</h2>
			</div>

			<form class="mt-8 space-y-6" @submit.prevent="register">
				<input type="hidden" value="true" />

				<div class="rounded-md shadow-sm -space-y-px">
					<div>
						<label for="name" class="sr-only">Name</label>
						<input id="name" v-model="user.name" type="text" autocomplete="email" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Fullname" />
					</div>
				
					<div>
						<label for="email-address" class="sr-only">Email address</label>
						<input id="email-address" v-model="user.email" type="email" autocomplete="email" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address" />
					</div>

					<div>
						<label for="password" class="sr-only">Password</label>
						<input id="password" v-model="user.password" type="password" autocomplete="current-password" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password" />
					</div>

					<div>
						<label for="password-confirm" class="sr-only">Confirm Password</label>
						<input placeholder="Repeat password" id="password-confirm" type="password" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" required autocomplete="current-password">
					</div>
				</div>

				<ul class="list-disc ml-4">
					<li v-for="error of errors" class="text-red-500 text-sm">{{ error[0] }}</li>
				</ul>

				<div>
					<button :disabled="isProcessing" type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
						<svg v-if="isProcessing" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
						</svg>
						<span class="ml-3">Sign up</span>
					</button>
				</div>
			</form>
		</div>
	</div>
</template>