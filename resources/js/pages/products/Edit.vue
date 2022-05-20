<script setup>
	import { useApi } from '../../hooks'

	import { ref, onMounted } from 'vue'
	import { useRouter, useRoute } from 'vue-router'

	const { execute } = useApi()

	const product = ref({})
	const router = useRouter()
	const { id } = useRoute().params

	function updateProduct() {
		execute({
			url: `/products/update`,
			method: 'put',
			params: { id },
			data: product.value
		})
	}

	execute({
		url: `/products/edit`,
		params: { id }
	})
</script>

<template>
	<section class="max-w-7xl mx-auto px-4">
		<h1 class="text-4xl flex items-center">Edit "{{ product.title }}"</h1>

		<div class="grid grid-cols-4 gap-10">
			<form class="mt-5 col-span-2" @submit.prevent="updateProduct">
				<div class="">
					<label for="product-title">Product title</label>
					<input id="product-title" type="text" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" v-model="product.product_name">
				</div>

				<div class="mt-3">
					<label for="product-title">Product image</label>
					<input id="product-title" type="file" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
				</div>

				<div class="flex mt-3 gap-10">
					<div class="w-full">
						<label for="product-price">Product old price</label>
						<input id="product-price" type="number" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" v-model="product.product_old_price">
					</div>

					<div class="w-full">
						<label for="product-price">Product price</label>
						<input id="product-price" type="number" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" v-model="product.product_price">
					</div>
				</div>

				<div class="mt-3">
					<label for="product-quantity">Product quantity</label>
					<input id="product-quantity" type="number" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" v-model="product.product_quantity">
				</div>

				<div class="mt-3">
					<label for="product-quantity">Product description</label>
					<textarea id="product-quantity" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" v-model="product.product_description"></textarea>
				</div>

				<div class="mt-3 flex items-center">
					<input type="checkbox" id="product-quantity" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" v-model="product.product_featured">
					<label for="product-quantity" class="ml-4">featured product</label>
				</div>

				<button class="mt-6 group relative flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type="submit">Create</button>
			</form>

			<img src="/images/products/default.jpg" alt="">
		</div>
	</section>

</template>