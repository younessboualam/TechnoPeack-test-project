<script setup>
	const emits = defineEmits(['file:select', 'update:modelValue'])

	const props = defineProps({
		modelValue: String,
		classList: String,
		
		required: {
			type: Boolean,
			default: false
		},

		fKey: {
			type: String,
			required: true
		},

		type: {
			type: String,
			default: "text"
		}
	})

	function updateValue ({ target }) {
		emits('update:modelValue', target.value)
	}
</script>

<template>
	<div class="mb-5 last:mb-0">
		<label class="text-sm mb-3" :for="fKey">
			<slot />
		</label>

		<input
			v-if="!['file', 'textarea'].includes(type)"
			:value="modelValue" :required="required" :id="fKey" :type="type"

			:class="[
				{ 'w-full': type !== 'checkbox'  },
				'block px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900',
				'focus:ring-indigo-500 focus:border-indigo-500', classList
			]"

			@input="updateValue"
		>

		<textarea
			v-else-if="type === 'textarea'"
			
			:class="[
				{ 'w-full': type !== 'checkbox'  },
				'block px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900',
				'focus:ring-indigo-500 focus:border-indigo-500', classList
			]"

			:required="required" :id="fKey" :type="type"
			@input="updateValue"
		>{{ modelValue }}</textarea>

		<input
			v-else type="file" :id="fKey"
			
			:class="[
				'w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900',
				'file:bg-transparent file:border-none file:p-0 file:text-indigo-500 file:font-bold file:mr-3',
				'focus:ring-indigo-500 focus:border-indigo-500', classList
			]"

			@change="(event) => emits('file:select', event)"
		>
	</div>	
</template>