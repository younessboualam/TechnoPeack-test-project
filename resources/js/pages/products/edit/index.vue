<script setup>
	import { ref } from 'vue'
	import { useRouter, useRoute } from 'vue-router'
	import { useApi } from '@/hooks'

	import form from './form'

	const { results: products, execute } = useApi()

	const router = useRouter()
	const { id } = useRoute().params

	function updateProduct() {
		execute({
			method: 'put',
			url: `/products/update/`,
			data: products.value
		})

		router.push({ name: 'Products.List' })
	}

	execute({ url: `/products/edit/${ id }` })

	function chooseImage ({ target }) {
		product.value.image = target.files[0].name
	}
</script>

<template>
	<section class="max-w-7xl mx-auto px-4">
		<router-link :to="{ name: 'Products.List' }">Go back</router-link>

		<form @submit.prevent="updateProduct">
			<table class="w-full mt-5">
				<thead class="text-left">
					<th>Id</th>
					<th class="p-2">Image</th>
					<th class="p-2">Title</th>
					<th class="p-2">Price</th>
					<th class="p-2">Quantity</th>
					<th class="p-2">Description</th>
					<th class="p-2">Featured</th>
				</thead>

				<tbody>
					<tr v-for="product in products">
						<td><app-field f-key="id" type="hidden" v-model="product.id"></app-field></td>

						<td class="flex items-center space-x-4">
							<img :src="`/images/products/${ product.image }`" class="w-12 h-12">
							<app-field f-key="image" type="file" @file:select="chooseImage"></app-field>
						</td>

						<td><app-field f-key="title" required v-model="product.title"></app-field></td>
						<td><app-field f-key="price" required v-model="product.price"></app-field></td>
						<td><app-field f-key="quantity" required v-model="product.quantity"></app-field></td>
						<td><app-field f-key="description" v-model="product.description"></app-field></td>
						<td><app-field f-key="featured" v-model="product.featured" type="checkbox"></app-field></td>
					</tr>
				</tbody>
			</table>

			<button class="mt-6 group relative flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type="submit">Update</button>
		</form>
	</section>
</template>