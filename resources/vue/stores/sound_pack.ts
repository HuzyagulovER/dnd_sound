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
        currentTrackTime: 0,
        currentAmbientIds: [],
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

        async stopCurrentTrack(): Promise<void> {
            return new Promise((res): void => {
                this.stopSignal = true;
                setTimeout(() => this.stopSignal = false);

                return res(this.stopSignal);
            }).then((): void => {
                this.removeCurrentTrackId();
                this.removeCurrentTrackTime();
                this.removeCurrentTrackTimeFromCookies();
            })
        },

        async initCurrentTrackId(): Promise<string> {
            return new Promise((resolve): void => {
                let id = cookies.get('track.currentTrackId');

                if (id) {
                    this.setCurrentTrackId(id);
                }

                return resolve(id);
            })
        },
        setCurrentTrackId(id: string): string {
            this.currentTrackId = id;
            this.saveCurrentTrackIdToCookies()
            return this.currentTrackId;
        },
        removeCurrentTrackId(): void {
            this.setCurrentTrackId('');
            this.removeCurrentTrackIdFromCookies();
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
        saveCurrentTrackIdToCookies(): void {
            cookies.set('track.currentTrackId', this.currentTrackId)
        },
        removeCurrentTrackIdFromCookies(): void {
            cookies.remove('track.currentTrackId');
        },

        async initCurrentTrackTime(): Promise<number> {
            return new Promise((res): void => {
                let time = +cookies.get('track.time');

                if (time) {
                    this.setCurrentTrackTimeToCookies(time)
                }

                return res(time);
            })
        },
        setCurrentTrackTime(time: number | string): void {
            this.currentTrackTime = +time;
        },
        removeCurrentTrackTime(): void {
            this.setCurrentTrackTime(0);
        },
        setCurrentTrackTimeToCookies(time: number | string): number {
            this.currentTrackTime = +time;
            return this.saveCurrentTrackTimeToCookies();
        },
        saveCurrentTrackTimeToCookies(): number {
            cookies.set('track.time', this.currentTrackTime.toString())

            return this.currentTrackTime;
        },
        removeCurrentTrackTimeFromCookies(): void {
            cookies.remove('track.time');
        },

        async initCurrentAmbientIds(): Promise<Array<string>> {
            return new Promise((res): void => {
                let ids = cookies.get('ambient.currentAmbientIds');

                if (ids) {
                    this.setCurrentAmbientIds(JSON.parse(ids));
                }

                return res(ids ? JSON.parse(ids) : []);
            })
        },
        setCurrentAmbientIds(ids: Array<string>): void {
            this.currentAmbientIds = ids;
        },
        addToCurrentAmbientIds(id: string): void {
            if (!this.currentAmbientIds.includes(id)) {
                this.currentAmbientIds.push(id);
                this.saveCurrentAmbientIdsToCookies();
            }
        },
        removeFromCurrentAmbientIds(id: string): void {
            this.currentAmbientIds = this.currentAmbientIds.filter((item: string) => item !== id);
            this.saveCurrentAmbientIdsToCookies();
        },
        saveCurrentAmbientIdsToCookies(): void {
            cookies.set('ambient.currentAmbientIds', JSON.stringify(this.currentAmbientIds))
        },
    },
})