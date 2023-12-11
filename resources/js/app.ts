import './bootstrap.js';
import router from './routes.js'
import { createApp } from 'vue';
import { createPinia } from 'pinia'
import App from './App.vue';
import { Icon } from '@iconify/vue';
import "leaflet/dist/leaflet.css";


const pinia = createPinia()

createApp(App)
  .use(router)
  .use(pinia)
  .component("Icon", Icon)
  .mount("#app");