import {defineStore} from 'pinia'
import axios, {InternalAxiosRequestConfig} from "axios";
import {useCookies} from 'vue3-cookies';
import {isEmpty} from 'lodash';
import {SoundPackState, SoundPacksType, SoundPackType, TrackType} from "@/js/types";

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
        stopSignal: false,
        currentTrackId: '',
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

        async stopAllTracks(): Promise<boolean> {
            return new Promise((res): void => {
                this.stopSignal = true;
                setTimeout(() => this.stopSignal = false);

                return res(this.stopSignal);
            })
        },

        setCurrentTrackId(id: string): string {
            this.currentTrackId = id;
            return this.currentTrackId;
        },
        setNextTrackId(): string {
            let ids = (this.sound_pack as SoundPackType).media.tracks.map((item: TrackType) => item.id);

            if (this.currentTrackId === '' && ids.length > 0) {
                return this.setCurrentTrackId(ids[0]);
            }

            if (this.currentTrackId === ids[ids.length - 1]) {
                return this.setCurrentTrackId('');
            }

            return this.setCurrentTrackId(ids[ids.indexOf(this.currentTrackId) + 1]);
        },
    },
})