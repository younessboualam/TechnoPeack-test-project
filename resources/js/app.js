import { createApp } from 'vue'
import App from '@/App'

import router from '@/router'
import store from '@/store'

import Field from '@/components/base/Field'
import Button from '@/components/base/Button'
import Loading from '@/components/Loading'

const app = createApp(App)

app.component('app-field', Field)
app.component('app-field', Field)
app.component('loading', Loading)

app
	.use(store)
	.use(router)
	.mount("#app")
