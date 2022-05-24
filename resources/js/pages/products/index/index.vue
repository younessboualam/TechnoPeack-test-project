<script setup>
	import { PlusIcon, TrashIcon, PencilAltIcon, EyeIcon } from '@heroicons/vue/outline'
	import { computed, ref, onMounted } from 'vue'
	import { useApi } from '@/hooks'
	import { useRouter } from 'vue-router'

	const { execute, results, isLoading, hasError } = useApi()
	const selectedIDs = ref([])
	const keyword = ref('')
	const router = useRouter()

	const filtredProducts = computed(() => {
		return results.value.data.filter((el) => {
			return el.title.toLowerCase().includes(keyword.value.toLowerCase())
		})
	})

	function deleteProducts () {
		execute({
			url: `/api/products/delete/${ selectedIDs.value.toString() }`,
			method: 'delete'
		})


		results.value.data = results.value.data.filter((el) => {
			return !selectedIDs.value.includes(el.id)
		})
	}

	function editProducts () {
		router.push({
			name: 'Products.Edit',
			params: {
				id: selectedIDs.value.toString()
			}
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

			<ul class="ml-auto flex items-center space-x-5">
				<li>
					<pencil-alt-icon v-if="selectedIDs.length > 0" @click="editProducts" class="h-6 w-6 stroke-sky-500 cursor-pointer" />
					<pencil-alt-icon v-else class="h-6 w-6 stroke-slate-300" />
				</li>

				<li>
					<trash-icon v-if="selectedIDs.length > 0" @click="editProducts" class="h-6 w-6 stroke-red-500 cursor-poin" />
					<trash-icon v-else class="h-6 w-6 stroke-slate-300" />
				</li>

				<li>
					<app-field
						v-model="keyword"
						class="rounded-full"
						placeholder="Search product"
						type="text"
					></app-field>
				</li>

				<li>
					<router-link :to="{ name: 'Products.Store' }" class="bg-sky-500 py-2 px-3 rounded-md flex text-sm items-center">
						<plus-icon class="h-4 w-4 stroke-white" />
					</router-link>
				</li>
			</ul>
		</h1>

		<table class="mt-4 border border-slate-900/20 w-full">
			<thead class="bg-slate-800 text-white text-left">
				<th class="p-2"></th>
				<th class="p-2">Image</th>
				<th class="p-2">Title</th>
				<th class="p-2">Price</th>
				<th class="p-2">Quantity</th>
				<th class="p-2">View</th>
			</thead>

			<tbody class="text-left">
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

					<td class="p-2" @blur="updateCol" data-col="title" contenteditable>{{ product.title }}</td>
					<td class="p-2" @blur="updateCol" data-col="price" contenteditable>{{ product.price }}</td>
					<td class="p-2" @blur="updateCol" data-col="quantity" contenteditable>{{ product.quantity }}</td>
					<td class="p-2">
						<router-link :to="{ name: 'Products.Show', params: { id: product.id }}">
							<eye-icon class="w-4 h-4 stroke-sky-500" />
						</router-link>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="mt-4">
			<ul class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
				<template 
					v-for="{ url, label, active } in results.links"
					:key="label"
				>
					<li
						v-if="url"
						:class="[
							'bg-white cursor-pointer border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium',
							{ 'bg-indigo-50 border z-10 border-indigo-500 text-indigo-600': active }
						]"

						@click="nextPage(url)"
					>
						<span v-html="label"></span>
					</li>
				</template>
			</ul>
		</div>
	</section>
</template>