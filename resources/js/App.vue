<script setup>
	import AppHeader from './components/Header.vue'
	import { useStore } from 'vuex'

	const store = useStore()
	store.dispatch('init')
</script>

<template>
	<app-header />

	<main class="py-5">
		<router-view />
	</main>
</template>