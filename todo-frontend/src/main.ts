import { createApp } from 'vue'
import PrimeVue from 'primevue/config'
import ToastService from 'primevue/toastservice'

// PrimeVue styles
import 'primevue/resources/themes/lara-light-blue/theme.css'
import 'primeicons/primeicons.css'

// Tailwind styles
import './assets/css/tailwind.css'

import App from './App.vue'
import router from './router'

const app = createApp(App)
app.use(router)

app.use(PrimeVue, { ripple: true })
app.use(ToastService)

app.mount('#app')