<script setup>
	const emits = defineEmits(['button:click'])
</script>

<template>

	<button
		:class="[
			'focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500',
			'py-2 px-4 text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700'
		]"

		v-bind="$attrs"
		@click="emits('button:click')"
	>
		<slot />
	</button>
</template>