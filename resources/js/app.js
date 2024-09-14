import './bootstrap';
import { createApp } from 'vue';
import App from './vue/app.vue';
import router from './vue/router.js'
import VueGtag from "vue-gtag";


createApp(App).use(router).use(VueGtag, {
    config: {id: 'G-8SPGK01QKX'}
}).mount('#app')