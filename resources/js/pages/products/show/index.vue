<script setup>
	import { useApi } from '@/hooks'

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

			<div class="col-span-3">
				<h1 class="text-4xl">{{ product.title }}</h1>
				
				<dl class="mt-5 space-y-1">
					<dd class="text-lg"><span class="text-sky-500">Price:</span> {{ product.price }}</dd>
					<dd class="text-lg"><span class="text-sky-500">Quantity:</span> {{ product.quantity }}</dd>
					<dd class="text-lg"><span class="text-sky-500">Description:</span> {{ product.description }}</dd>
				</dl>
			</div>
		</div>
	</section>
</template>