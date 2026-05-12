import {createApp} from 'vue';
import App from '@/vue/App.vue';
import router from '@/vue/routes';
import {createPinia} from 'pinia';

const pinia = createPinia();

function trackPluralize(number: number) {
    const lastDigit = number % 10;
    const lastTwoDigits = number % 100;

    if (lastTwoDigits >= 11 && lastTwoDigits <= 19) {
        return `${number} треков`;
    }

    if (lastDigit === 1) {
        return `${number} трек`;
    }

    if (lastDigit >= 2 && lastDigit <= 4) {
        return `${number} трека`;
    }

    return `${number} треков`;
}

createApp(App)
    .use(router)
    .use(pinia)
    .provide('trackPluralize', trackPluralize)
    .mount('#app');