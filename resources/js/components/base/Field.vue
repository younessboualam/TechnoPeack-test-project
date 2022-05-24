<script>
	export default {
		inheritAttrs: false
	}
</script>

<script setup>
	import { useAttrs } from 'vue'

	const attrs = useAttrs()
	const emits = defineEmits(['file:select', 'update:modelValue'])
	const props = defineProps(['modelValue'])

	function updateValue ({ target }) {
		emits('update:modelValue', target.value)
	}
</script>

<template>
	<div class="mb-5 last:mb-0">
		<label class="text-sm mb-3">
			<slot />
		</label>

		<input
			v-if="!['file', 'textarea'].includes(attrs.type)"
			:value="modelValue" v-bind="attrs"

			:class="[
				{ 'w-full': attrs.type != 'checkbox', 'w-6 h-6': attrs.type == 'checkbox' },
				'block px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900',
				'focus:ring-indigo-500 focus:border-indigo-500',
			]"

			@input="updateValue"
		>

		<textarea
			v-else-if="attrs.type === 'textarea'"
			:value="modelValue" v-bind="attrs"
			
			:class="[
				'w-full block px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900',
				'focus:ring-indigo-500 focus:border-indigo-500',
			]"

			@input="updateValue"
		>{{ modelValue }}</textarea>

		<input
			v-else type="file" v-bind="attrs"
			
			:class="[
				'w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900',
				'file:bg-transparent file:border-none file:p-0 file:text-indigo-500 file:font-bold file:mr-3',
				'focus:ring-indigo-500 focus:border-indigo-500',
			]"

			@change="(event) => emits('file:select', event)"
		>
	</div>	
</template>