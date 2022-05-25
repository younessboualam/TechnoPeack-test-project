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
	const classes = 'block px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:ring-indigo-500 focus:border-indigo-500'


	function updateValue ({ target }) {
		emits('update:modelValue', target.value || target.checked)
	}
</script>

<template>
	<div>
		<label class="text-sm mb-3">
			<slot />
		</label>

		<input
			v-if="['text', 'number'].includes(attrs.type)"
			
			:value="modelValue" v-bind="attrs"
			:class="classes"

			@input="updateValue"
		>

		<input
			v-else-if="attrs.type === 'checkbox'"

			:value="modelValue" v-bind="attrs"
			:class="[classes, 'w-6 h-6']"

			@input="updateValue"
		>

		<textarea
			v-else-if="attrs.type === 'textarea'"

			:value="modelValue" v-bind="attrs"
			:class="classes"

			@input="updateValue"
		>{{ modelValue }}</textarea>

		<input
			v-else type="file" v-bind="attrs"
			
			:class="[
				classes,
				'w-full file:bg-transparent file:border-none file:p-0 file:text-indigo-500 file:font-bold file:mr-3',
			]"

			@change="(event) => emits('file:select', event)"
		>
	</div>	
</template>