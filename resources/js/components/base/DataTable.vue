<script setup>
	const emits = defineEmits(['next'])
	const props = defineProps({
		headings: {
			type: Array,
			required: true
		},

		results: {
			type: Object,
			required: true
		}
	})
</script>

<template>
	<table class="mt-4 border border-slate-900/20 w-full">
		<thead class="bg-slate-800 text-white text-left">
			<th v-for="heading in headings" class="p-2">
				{{ heading }}
			</th>
		</thead>

		<tbody class="text-left">
			<slot />
		</tbody>
	</table>

	<div class="mt-4">
		<ul
			class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
			aria-label="Pagination"
		>
			<template 
				v-for="{ url, label, active } in results.links"
				:key="label"
			>
				<li
					v-if="url"
					:class="[
						{ 'bg-indigo-50 border z-10 border-indigo-500 text-indigo-600': active },
						'bg-white cursor-pointer border-gray-300 text-gray-500 hover:bg-gray-50',
						'relative inline-flex items-center px-4 py-2 border text-sm font-medium'
					]"

					@click="emits('next', url)"
				>
					<span v-html="label"></span>
				</li>
			</template>
		</ul>
	</div>	
</template>