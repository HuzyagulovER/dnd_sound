export type SoundPackType = {
    id: string,
    title: string,
    image: string,
    count: number,
    media: {
        tracks: Array<TrackType>,
        ambient: Array<AmbientType>,
        one_shots: Array<OneShotType>,
    },
};

export type BaseMedia = {
    id: string,
    title: string,
    description: string,
    file: string,
    image: string | null,
}

export type TrackType = {} & BaseMedia;

export type AmbientType = {} & BaseMedia;

export type OneShotType = {} & BaseMedia;

export type SoundPacksType = Record<string, SoundPackType>;

export type SoundPackState = {
    sound_packs: SoundPacksType,
    sound_pack: SoundPackType | {},
    stopSignal: boolean,
    currentTrackId: string,
    currentTrackTime: number,
    currentAmbientIds: Array<string>,
};

export type MainState = {
    loader: boolean,
};