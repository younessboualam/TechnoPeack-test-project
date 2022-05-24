<script setup>
	import { ref } from 'vue'
	
	import { useRouter } from 'vue-router'
	import { useApi } from '@/hooks'

	import form from './form'

	const { results: products, execute, isLoading } = useApi()

	const router = useRouter()
	const props = defineProps({
		id: String
	})

	function updateProduct() {
		execute({
			method: 'put',
			url: `/api/products/update/`,
			data: products.value
		})

		router.push({ name: 'Products.List' })
	}

	execute({ url: `/api/products/edit/${ props.id }` })

	function chooseImage ({ target }, index) {
		products.value[index].image = target.files[0].name
	}

	function updateOnce (value, key) {
		products.value = products.value.map(current => {
			return { ...current, [key]: value}
		})
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
					<tr v-if="isLoading">
						<td colspan="4">
							<loading />
						</td>
					</tr>

					<tr
						v-else
						v-for="(product, index) in products"
						:key="product.id"
					>
						<td>
							<app-field id="id" type="hidden" v-model="product.id"></app-field>
						</td>

						<td class="flex items-center space-x-4">
							<img loading="lazy" :src="`/images/products/${ product.image }`" class="w-12 h-12">
							<app-field id="image" type="file" @file:select="(e) => chooseImage(e, index)"></app-field>
						</td>

						<td>
							<app-field
								@update:modelValue="(e) => updateOnce(e, 'title')"
								id="title" required v-model="product.title"></app-field>
						</td>
						
						<td>
							<app-field
								@update:modelValue="(e) => updateOnce(e, 'price')"
								id="price" required v-model="product.price"></app-field>
						</td>
						
						<td>
							<app-field
								@update:modelValue="(e) => updateOnce(e, 'quantity')"
								id="quantity" required v-model="product.quantity"></app-field>
						</td>
						
						<td>
							<app-field
								@update:modelValue="(e) => updateOnce(e, 'description')"
								id="description" v-model="product.description"></app-field>
						</td>
						
						<td>
							<app-field
								class="w-6 h-6 ml-4" checked="product.featured"
								@update:modelValue="(e) => updateOnce(e, 'featured')"
								id="featured" v-model="product.featured" type="checkbox"></app-field>
						</td>
					</tr>
				</tbody>
			</table>

			<app-button class="mt-6" type="submit">Update</app-button>
		</form>
	</section>
</template>