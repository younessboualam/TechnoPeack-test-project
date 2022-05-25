<script setup>
	import { ArrowLeftIcon } from '@heroicons/vue/outline'
	import { ref, computed } from 'vue'
	import { useRouter } from 'vue-router'
	import { useApi } from '@/hooks'
	
	import form from './form'

	const { execute, results } = useApi()
	const router = useRouter()

	const formData = ref(new FormData())
	const image = ref(null)
	const product = ref({})

	const errors = computed(() => results.value.errors)

	function storeProduct () {
		Object.entries(product.value)
			.forEach(([key, value]) => {
				formData.value.set(key, value)
			}
		)

		execute({
			url: '/api/products/store',
			method: 'post',
			data: formData.value
		})

		router.push({ name: 'Products.List' })
	}

	function prevewImage ({ target }) {
    	formData.value.set('image', target.files[0])
		image.value.src = URL.createObjectURL(target.files[0])
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

		<h1 class="text-4xl mt-5 flex items-center">
			Create new product
		</h1>

		<div class="grid grid-cols-4 gap-10">
			<form
				class="mt-5 col-span-2"
				enctype="multipart/form-data"
				@submit.prevent="storeProduct"
			>
				<app-field
					v-for="field in form"
					:key="field.key"
					
					:type="field.type"
					:required="field.required"

					v-model="product[field.key]"
					class="w-full mb-3"

					@file:select="prevewImage"
				>
					<div class="flex mb-1">
						{{ field.label }}
						
						<span v-if="errors" class="ml-auto text-red-500">
							<p v-for="error in errors[field.key]">
								{{ error }}
							</p>
						</span>
					</div>
				</app-field>

				<app-button type="submit">Create</app-button>
			</form>

			<img
				class="border border-slate-200 col-span-2 w-full"
				ref="image" src="/images/products/default.jpg"
			>
		</div>
	</section>

</template>