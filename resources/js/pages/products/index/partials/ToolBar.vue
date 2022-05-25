<script setup>
	import { PlusIcon, TrashIcon,  PencilAltIcon } from '@heroicons/vue/outline'
	import { ref } from 'vue'
	import { useApi } from '@/hooks'
	import { useRouter } from 'vue-router'

	const router = useRouter()
	const { execute } = useApi()

	const emits = defineEmits(['product:delete'])
	const props = defineProps({
		selectedIds: {
			type: Array,
			required: true
		}
	})

	const keyword = ref('')

	function deleteProducts () {
		execute({
			url: `/api/products/delete/${ props.selectedIds.toString() }`,
			method: 'delete'
		})

		emits('product:delete')
	}

	function editProducts () {
		router.push({
			name: 'Products.Edit',
			params: {
				id: props.selectedIds.toString()
			}
		})
	}
</script>

<template>
	<ul class="ml-auto flex items-center space-x-5">
		<li>
			<pencil-alt-icon
				v-if="selectedIds.length > 0" @click="editProducts"
				class="h-6 w-6 stroke-sky-500 cursor-pointer"
			/>
			<pencil-alt-icon v-else class="h-6 w-6 stroke-slate-300" />
		</li>

		<li>
			<trash-icon
				v-if="selectedIds.length > 0" @click="deleteProducts"
				class="h-6 w-6 stroke-red-500 cursor-pointer"
			/>
			<trash-icon v-else class="h-6 w-6 stroke-slate-300" />
		</li>

		<li>
			<slot />
		</li>

		<li>
			<router-link
				:to="{ name: 'Products.Store' }"
				class="bg-sky-500 py-2 px-3 rounded-md flex text-sm items-center"
			>
				<plus-icon class="h-4 w-4 stroke-white" />
			</router-link>
		</li>
	</ul>
</template>