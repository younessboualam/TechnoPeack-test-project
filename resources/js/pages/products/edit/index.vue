<script setup>
	import { ArrowLeftIcon } from '@heroicons/vue/outline'
	import { ref } from 'vue'
	
	import { useRouter } from 'vue-router'
	import { useApi } from '@/hooks'

	import form from './form'

	const { results: products, execute, isLoading } = useApi()

	const formData = ref(new FormData())

	const router = useRouter()
	const props = defineProps({
		id: String
	})

	function updateProduct() {
		products.value.forEach(product => {
			Object.entries(product)
				.forEach(([key, value]) => {
					formData.value.append(key + '[]', value)
				}
			)
		})

		execute({
			method: 'put',
			url: `/api/products/update/`,
			// data: products.value,
			data: formData.value,
		})

		router.push({ name: 'Products.List' })
	}

	execute({
		url: `/api/products/edit/${ props.id }`
	})

	function chooseImage ({ target }, index) {
    	formData.value.append('image[]', target.files[0])
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
		<router-link
			class="flex items-center"
			:to="{ name: 'Products.List' }"
		>
			<arrow-left-icon class="w-5 h-5" />
			<span class="ml-4">Go back</span>
		</router-link>

		<form class="mt-6" @submit.prevent="updateProduct">
			<div
				v-for="(product, index) in products" :key="product.id"
				class="mb-5 border border-slate-800 rounded-lg p-4"
			>
				<h1 class="text-2xl mb-4">
					{{ product.title }}
				</h1>

				<div class="flex items-start gap-10">
					<img loading="lazy" :src="`/images/products/${ product.image }`" class="w-52">
					
					<div class="grid grid-cols-4 gap-4">
						<app-field
							type="file"
							class="w-full"

							@file:select="e => chooseImage(e, index)"
						>
							<div class="flex">
								Product image
							</div>
						</app-field>

						<app-field
							v-for="field in form"
							
							:key="field.key"
							:type="field.type"
							class="w-full"
							
							v-model="product[field.key]"
							@update:modelValue="(e) => updateOnce(e, field.key)"
						>
							<div class="flex">
								<span
									v-if="field.key === 'colour'"
									class="block w-6 h-6 rounded-full mr-2"
									:style="`background: ${ product.colour }`"
								></span>
								{{ field.label }}
							</div>
						</app-field>
					</div>
				</div>
			</div>
			
			<app-button>Update</app-button>
		</form>
	</section>
</template>