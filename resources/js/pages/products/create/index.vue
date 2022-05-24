<script setup>
	import { ref } from 'vue'
	import { useRouter } from 'vue-router'
	import { useApi } from '@/hooks'
	
	import form from './form'

	const { execute, results } = useApi()
	const router = useRouter()

	const dataForm = ref(new FormData())
	const image = ref(null)
	const product = ref({})

	function storeProduct () {
		execute({
			url: '/api/products/store',
			method: 'post',
			data: product.value
		})

		router.push({ name: 'Products.List' })
	}

	function prevewImage ({ target }) {
		product.value.image = target.files[0].name
    	dataForm.value.append('image', target.files[0].name)
    	
		image.value.src = URL.createObjectURL(target.files[0])
	}
</script>

<template>
	<section class="max-w-7xl mx-auto px-4">
		<router-link :to="{ name: 'Products.List' }">Go back</router-link>

		<h1 class="text-4xl flex items-center">Create new product</h1>

		<div class="grid grid-cols-4 gap-10">
			<form
				class="mt-5 col-span-2"
				enctype="multipart/form-data"
				@submit.prevent="storeProduct"
			>
				<app-field
					v-for="field in form"
					:key="field.key"
					
					:f-key="field.key"
					:type="field.type"
					:required="field.required"

					v-model="product[field.key]"

					@file:select="prevewImage"
				>
					{{ field.label }}
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