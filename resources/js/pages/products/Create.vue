<script setup>
	import { ref } from 'vue'

	import { useRouter } from 'vue-router'
	import { useApi } from '../../hooks'

	const { execute, results, isLoading, hasError } = useApi()


	const image = ref(null)
	const product = ref({})
	const router = useRouter()

	function storeProduct () {
		execute({
			url: '/products',
			method: 'post',
			data: product.value
		})

		router.push({ name: 'Products.List' })
	}

	function prevewImage ({ target }) {
		product.value.product_image = target.files[0].name
		image.value.src = URL.createObjectURL(target.files[0])
	}
</script>

<template>
	<section class="max-w-7xl mx-auto px-4">
		<router-link :to="{ name: 'Products.List' }">Go back</router-link>

		<h1 class="text-4xl flex items-center">Create new product</h1>

		<div class="grid grid-cols-4 gap-10">
			<form class="mt-5 col-span-2" @submit.prevent="storeProduct">
				<div class="">
					<label for="product-title">Product title</label>
					<input id="product-title" type="text" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" v-model="product.product_name">
				</div>

				<div class="mt-3">
					<label for="product-title">Product image</label>
					<input id="product-title" type="file" @change="prevewImage" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
				</div>

				<div class="mt-3">
					<label for="product-price">Product price</label>
					<input id="product-price" type="number" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" v-model="product.product_price">
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

			<img class="border border-slate-200 col-span-2 w-full" ref="image" src="/images/products/default.jpg" alt="">
		</div>
	</section>

</template>