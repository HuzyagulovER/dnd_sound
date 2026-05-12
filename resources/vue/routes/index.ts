import {createRouter, createWebHistory, RouteRecordRaw} from 'vue-router';
import SoundPacks from "@components/sound_packs/SoundPacks.vue";
import SoundPack from "@components/sound_pack/SoundPack.vue";
import SoundPackCreate from "@components/sound_packs/SoundPackCreate.vue";
import {watch} from "vue";

const defaultTitle: string = 'Мои плейлисты'

const routes: Array<RouteRecordRaw> = [
    {
        path: '/',
        name: 'SoundPacks',
        component: SoundPacks,
        meta: {
            title: 'Мои плейлисты'
        }
    },
    {
        path: '/create',
        name: 'SoundPackCreate',
        component: SoundPackCreate,
        meta: {
            title: 'Создание плейлиста'
        }
    },
    {
        path: '/sound_packs/:id',
        name: 'SoundPack',
        component: SoundPack
    },
]

const router = createRouter({
    history: createWebHistory('/'),
    routes
})
router.beforeEach(async (to) => {
    try {
        // if (!cookies.get("session_token")) {
        //     if (to.path !== '/sign-in') {
        //         next({ path: '/sign-in' })
        //         return
        //     } else {
        //         next()
        //     }
        // }
        const titleElement = <HTMLElement>document.querySelector('head title');
        titleElement.innerText = to.meta?.title as string;

        if (to.path === '/sign-in') {
            return '/';
        } else {
            return true;
        }
    } catch (error) {
        console.log(error)
        // next({ path: '/sign-in' })
    }
})

export default router