import './bootstrap.js';
import router from './routes.js'
import { createApp } from 'vue';
import { createPinia } from 'pinia'
import App from './App.vue';
import { Icon } from '@iconify/vue';

const pinia = createPinia()

createApp(App)
  .use(router)
  .use(pinia)
  .component("Icon", Icon)
  .mount("#app");