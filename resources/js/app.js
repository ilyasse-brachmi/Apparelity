import './bootstrap';
import router from './routes.js'
import { createApp } from 'vue';
import App from './App.vue';
import { Icon } from '@iconify/vue';

createApp(App)
  .use(router)
  .mount("#app");