import { createApp } from 'vue'
import App from '@/App'

import router from '@/router'
import store from '@/store'

import Field from '@/components/base/Field'
import Button from '@/components/base/Button'

const app = createApp(App)

app.component('app-field', Field)
app.component('app-button', Button)

app
	.use(store)
	.use(router)
	.mount("#app")
