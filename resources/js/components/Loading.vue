<template>
	<div v-bind="$attrs">
		<span class="mb-2 block">Loading ... plaise wait</span>
		<div class="relative h-1 rounded-full overflow-hidden bg-slate-100">
			<div class="absolute w-full h-full bg-sky-500 animate-loading"></div>
		</div>
	</div>
</template>