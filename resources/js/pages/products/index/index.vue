<script setup>
	import { StarIcon, EyeIcon } from '@heroicons/vue/outline'
	import { computed, ref, onMounted } from 'vue'
	import { useApi } from '@/hooks'

	import ToolBar from './partials/ToolBar'

	const { execute, results, isLoading, hasError } = useApi()
	const selectedIDs = ref([])
	const keyword = ref('')

	const headings = [
		'check', 'Image', 'Title', 'Colour', 'Category',
		'Price', 'Quantity', 'Featured', 'View'
	]

	const filtredProducts = computed(() => {
		return results.value.data.filter((el) => {
			return el.title.toLowerCase().includes(keyword.value.toLowerCase())
		})
	})

	function onDeleted () {
		results.value.data = results.value.data.filter((el) => {
			return !selectedIDs.value.includes(el.id)
		})
	}

	function updateCol ({ target }) {
		const id = target.parentElement.dataset.id,
				key = target.dataset.col,
				value = target.textContent

		execute({
			url: `/api/products/update/${ id }`,
			method: 'put',
			data: {
				[key]: value 
			}
		})
	}

	function nextPage (url) {
		execute({
			url
		})
	}

	onMounted(() => execute({ url: '/api/products' }))
</script>

<template>
	<section class="max-w-7xl mx-auto px-4">
		<h1 class="text-4xl flex items-center">
			Products lists

			<tool-bar
				:selected-ids="selectedIDs"
				@product:delete="onDeleted"
			>
				<app-field
					v-model="keyword"
					class="rounded-full"
					placeholder="Search product"
					type="text"
				></app-field>
			</tool-bar>
		</h1>

		<data-table :headings="headings" :results="results">
			<tr v-if="hasError">
				<td class="p-2">An error occurented</td>
			</tr>
			
			<tr v-else-if="isLoading">
				<td class="p-2" colspan="6">
					<loading />
				</td>
			</tr>

			<tr v-else-if="results.data.length == 0">
				<td class="p-2">No product available</td>
			</tr>

			<tr
				v-else
				v-for="product in filtredProducts"
				:key="product.id"
				:data-id="product.id"
				class="odd:bg-slate-100"
			>
				<td class="p-2">
					<input v-model="selectedIDs" :value="product.id" type="checkbox">
				</td>

				<td class="p-2">
					<img loading="lazy" class="w-10" :src="`images/products/${ product.image }`" alt="">
				</td>

				<td class="p-2" @blur="updateCol" data-col="title" contenteditable>
					{{ product.title }}
				</td>
				
				<td class="p-2" @blur="updateCol" data-col="category" contenteditable>
					{{ product.category }}
				</td>
				
				<td class="p-2" @blur="updateCol" data-col="price" contenteditable>
					{{ product.price }}
				</td>
				
				<td class="p-2" @blur="updateCol" data-col="quantity" contenteditable>
					{{ product.quantity }}
				</td>
				
				<td class="p-2">
					<span class="block rounded-lg w-5 h-5" :style="`background: ${ product.colour }`"></span>	
				</td>

				<td class="p-2">
					<star-icon
						v-if="product.featured"
						class="block w-4 h-4 fill-yellow-500 stroke-yellow-500"
					></star-icon>
				</td>

				<td class="p-2">
					<router-link
						:to="{ name: 'Products.Show', params: { id: product.id }}"
					>
						<eye-icon class="w-5 h-5 stroke-sky-500" />
					</router-link>
				</td>
			</tr>				
		</data-table>
	</section>
</template>