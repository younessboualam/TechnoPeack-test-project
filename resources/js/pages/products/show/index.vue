<script setup>
	import { useApi } from '@/hooks'

	const attributes = {
		title: 'Title',
		price: 'Price',
		quantity: 'Quantity',
		colour: 'Colour',
		category: 'Category',
		description: 'Description',
	}

	const { results: product, execute, isLoading } = useApi()
	const props = defineProps({
		id: String
	})	

	execute({ url: `/api/products/${ props.id }` })
</script>

<template>
	<section class="max-w-7xl mx-auto px-4">
		<router-link :to="{ name: 'Products.List' }">Go back</router-link>

		<loading class="my-5" v-if="isLoading"/>

		<div v-else class="grid grid-cols-4 gap-14 mt-5">
			<img :src="`/images/products/${ product.image }`">

			<div class="col-span-2">
				<h1 class="text-4xl">{{ product.title }}</h1>
				
				<ul class="mt-5 space-y-1">
					<li
						v-for="(value, key) of attributes"
						:key="key" class="text-lg"
					>
						<span class="text-sky-500">{{ value }}:</span>
						{{ product[key] }}
					</li>
				</ul>
			</div>
		</div>
	</section>
</template>