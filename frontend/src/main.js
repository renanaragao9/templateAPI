import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

import Aura from '@primevue/themes/aura';
import PrimeVue from 'primevue/config';
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';

import { createPinia } from 'pinia';

import '@/assets/styles.scss';
import '@/assets/tailwind.css';

const app = createApp(App);
const pinia = createPinia();

const authStore = pinia.state.value.auth;
if (authStore && authStore.token) {
    authStore.validateToken().then((isValid) => {
        if (!isValid) {
            console.log('Token inválido ou expirado. Redirecionando para login...');
            window.location.href = '/login';
        }
    });
}

app.use(router);
app.use(pinia);
app.use(PrimeVue, {
    theme: {
        preset: Aura,
        options: {
            darkModeSelector: '.app-dark'
        }
    }
});
app.use(ToastService);
app.use(ConfirmationService);

app.mount('#app');
