import { createApp } from 'vue'
import App from '@/App'

import { store, router } from '@/plugins'

import Field from '@/components/base/Field'
import Button from '@/components/base/Button'
import Loading from '@/components/base/Loading'
import DataTable from '@/components/base/DataTable'

const app = createApp(App)

app.component('app-field', Field)
app.component('app-button', Button)
app.component('loading', Loading)
app.component('data-table', DataTable)

app
	.use(store)
	.use(router)
	.mount("#app")
