import {defineStore} from 'pinia'

export const mainStore = defineStore('mainStore', {
    state: (): State => ({
        title: 'Мои плейлисты',
    }),
    actions: {
    },
})