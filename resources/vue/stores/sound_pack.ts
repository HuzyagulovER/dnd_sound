import {defineStore} from 'pinia'
import axios, {InternalAxiosRequestConfig} from "axios";
import {useCookies} from 'vue3-cookies';
import {isEmpty} from 'lodash';
import {SoundPackState, SoundPacksType, SoundPackType} from "@/js/types";

const api_base: string = 'http://dnd-sound/api/';
const {cookies} = useCookies();

const axiosInstance = axios.create();
axiosInstance.interceptors.request.use((config: InternalAxiosRequestConfig) => {
    config.url = api_base + (config.url as string).replace(/^\/+|\/+$/g, '');

    if (!isEmpty(cookies.get('token'))) {
        config.headers['Authorization'] = 'Bearer ' + cookies.get('token');
    }

    if (config.method && ['PUT', 'PATCH'].includes(config.method.toUpperCase())) {
        config.params._method = config.method;
        config.method = 'POST';
    }

    return config;
});

export const soundPackStore = defineStore('soundPackStore', {
    state: (): SoundPackState => ({
        sound_packs: {},
        sound_pack: {},
    }),
    actions: {
        async getSoundPacks(): Promise<SoundPacksType> {
            return await axiosInstance.get('/').then(
                r => {
                    return this.sound_packs = r.data.data;
                },
                e => {
                    throw e.response.data
                }
            )
        },
        async getSoundPack(id: string): Promise<SoundPackType> {
            return await axiosInstance.get('/' + id).then(
                r => {
                    return this.sound_pack = r.data.data;
                },
                e => {
                    throw e.response.data
                }
            )
        },
    },
})