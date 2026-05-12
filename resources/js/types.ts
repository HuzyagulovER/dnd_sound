export type SoundPackType = {
    id: string,
    title: string,
    image: string,
    count: number,
    media: {
        tracks: TrackType,
        ambient: AmbientType,
        one_shots: OneShotType,
    },
};

export type TrackType = {
    id: string,
    title: string,
    description: string,
    file: string,
};

export type AmbientType = {
    id: string,
    title: string,
    description: string,
    file: string,
};

export type OneShotType = {
    id: string,
    title: string,
    description: string,
    file: string,
};

export type SoundPacksType = Record<string, SoundPackType>;

export type SoundPackState = {
    sound_packs: SoundPacksType
    sound_pack: SoundPackType | {}
};

export type MainState = {
    loader: boolean
};