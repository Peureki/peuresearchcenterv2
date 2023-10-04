import './bootstrap';
import { createApp } from 'vue';
import App from './vue/app.vue';
import router from './vue/router.js'

createApp(App).use(router).mount('#app')