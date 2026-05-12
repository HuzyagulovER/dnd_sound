export type SoundPackType = {
    id: string,
    title: string,
    image: string,
    count: number,
};

export type SoundPacksType = Record<string, SoundPackType>;

export type SoundPackState = {
    sound_packs: SoundPacksType
    sound_pack: SoundPackType | {}
};

export type MainState = {
    loader: boolean
};