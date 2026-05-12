import {defineStore} from 'pinia'
import {MainState} from "@/js/types";

export const mainStore = defineStore('mainStore', {
    state: (): MainState => ({
        loader: false
    }),
    actions: {
        enableLoader() {
            this.loader = true;
        },
        disableLoader() {
            this.loader = false;
        },
        toggleLoader() {
            this.loader = !this.loader;
        },
    },
})