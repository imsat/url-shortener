import './bootstrap';
import  {createApp} from "vue";
import { createPinia } from 'pinia'
import '../scss/styles.scss'
import { VueClipboard } from '@soerenmartius/vue3-clipboard'

import App from './pages/App.vue'
import Validation from './components/Validation.vue'
import router from "./routes";
const store = createPinia()
const app = createApp(App)

app.use(router)
app.use(store)
app.use(VueClipboard)
app.component('Validation', Validation)
app.mount('#app')
