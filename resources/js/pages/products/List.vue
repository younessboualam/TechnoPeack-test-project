<script setup>
	import { ref } from 'vue'
	import { useApi } from '../../hooks'

	const { execute, results, isLoading, hasError } = useApi()

	function deleteProduct (id) {
		execute({
			url: '/products',
			method: 'delete',
			params: { id }
		})
	}

	execute({
		url: '/products'
	})
</script>

<template>
	<section class="max-w-7xl mx-auto px-4">
		<h1 class="text-4xl flex items-center">
			Products lists

			<router-link :to="{ name: 'Products.Store' }" class="bg-sky-500 py-2 px-3 rounded-md flex ml-auto text-sm items-center">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 stroke-white" fill="none" viewBox="0 0 24 24" stroke-width="2">
				<path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
				</svg>

				<span class="ml-2 text-white">Add new</span>
			</router-link>
		</h1>

		<table class="mt-4 border border-slate-900/20 w-full">
			<thead class="bg-slate-800 text-white text-left">
				<th class="p-2">ID</th>
				<th class="p-2">Image</th>
				<th class="p-2">Title</th>
				<th class="p-2">Price</th>
				<th class="p-2">Quantity</th>
				<th class="p-2">Action</th>
			</thead>

			<tbody class="text-left">
				<tr v-if="hasError">
					<td class="p-2">An error occurented</td>
				</tr>
				
				<tr v-else-if="isLoading">
					<td class="p-2">Loading ...</td>
				</tr>

				<tr v-else v-for="product in results" class="odd:bg-slate-100">
					<td class="p-2">{{ product.id }}</td>
					<td class="p-2">
						<img class="w-10" :src="`images/products/${ product.image }`" alt="">
					</td>
					<td class="p-2">{{ product.title }}</td>
					<td class="p-2">{{ product.price }}</td>
					<td class="p-2">{{ product.quantity }}</td>

					<td class="flex">
						<a href="{{ route('products.edit', ['product' => product.id]) }}" class="text-sky-500">
							<span class="ml-2">Edit</span>
						</a>
						
						<span class="mx-3">|</span>

						<span @click="deleteProduct(product.id)" class="ml-2 text-red-500 cursor-pointer">Delete</span>
					</td>
				</tr>
			</tbody>
		</table>
	</section>
</template>