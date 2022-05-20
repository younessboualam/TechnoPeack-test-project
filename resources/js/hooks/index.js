import { ref, onMounted } from 'vue'
import axios from 'axios'

export function useApi () {
	const results = ref([])
	const isLoading = ref(true)
	const hasError = ref(false)

	const client = axios.create({
		baseURL: "/api",
		headers: {
			'X-Requested-With': 'XMLHttpRequest',
			'Accept': 'application/json',
			'Authorization': 'Bearer ' + localStorage.getItem('token')
		}
	})

	function execute ({
		url, method = 'get', data = {}
	}) {
		client({
			method,
			url,
			data
		}).then(({ data }) => {
			results.value = data
			isLoading.value = false
		}).catch(function (error) {
			hasError.value = true
		})
	}

	return {
		execute,
		results,
		isLoading,
		hasError
	}
}