<template>
  <section class="sound-pack">
    <div class="sound-pack__container">
      <TheHeader :title="sound_pack.title"/>

      <div class="sound-pack__lists">
        <div class="sound-pack__row">
          <div class="sound-pack__row-container">
            <p class="sound-pack__subtitle subtitle">Tracks</p>

            <VolumeControlGroup class="sound-pack__group-volume unbordered"
                                @update:model-value="updateTracksGroupVolumePercent"
                                @volume-change=""
                                storage-key="tracks-volume"
                                :model-value="tracksGroupVolumePercent"/>
          </div>
          <div class="sound-pack__row-grid-container">
            <TrackItem v-for="(track) in sound_pack.media?.tracks"
                       :key="(track as TrackType).id"
                       :id="(track as TrackType).id"
                       :src="(track as TrackType).file ?? ''"
                       :title="(track as TrackType).title"
                       :image="(track as TrackType).image"
                       :startTime="0"
                       :group-volume="tracksGroupVolumeMultiplier"
            />
          </div>
        </div>
        <div class="sound-pack__row">
          <div class="sound-pack__row-container">
            <p class="sound-pack__subtitle subtitle">Ambient</p>

            <VolumeControlGroup class="sound-pack__group-volume unbordered"
                                @update:model-value="updateAmbientGroupVolumePercent"
                                @volume-change=""
                                storage-key="ambient-group-volume"
                                :model-value="ambientGroupVolumePercent"/>
          </div>
          <div class="sound-pack__row-grid-container">
            <AmbientItem v-for="(ambient) in sound_pack.media?.ambient"
                         :key="(ambient as AmbientType).id"
                         :id="(ambient as AmbientType).id"
                         :src="(ambient as AmbientType).file ?? ''"
                         :title="(ambient as AmbientType).title"
                         :image="(ambient as AmbientType).image"
                         :group-volume="ambientGroupVolumeMultiplier"
            />
          </div>
        </div>
        <div class="sound-pack__row">
          <div class="sound-pack__row-container">
            <p class="sound-pack__subtitle subtitle">One shots</p>

            <VolumeControlGroup class="sound-pack__group-volume unbordered"
                                @update:model-value="updateOneShotsGroupVolumePercent"
                                @volume-change=""
                                storage-key="one-shots-group-volume"
                                :model-value="oneShotsGroupVolumePercent"/>
          </div>
          <div class="sound-pack__row-grid-container">
            <OneShotItem v-for="(one_shot) in sound_pack.media?.one_shots"
                         :key="(one_shot as OneShotType).id"
                         :id="(one_shot as OneShotType).id"
                         :src="(one_shot as OneShotType).file ?? ''"
                         :title="(one_shot as OneShotType).title"
                         :image="(one_shot as OneShotType).image"
                         :group-volume="oneShotsGroupVolumeMultiplier"
            />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import TheHeader from "@components/common/TheHeader.vue";
import TrackItem from "@components/sound_pack/TrackItem.vue";
import OneShotItem from "@components/sound_pack/OneShotItem.vue";
import AmbientItem from "@components/sound_pack/AmbientItem.vue";
import {storeToRefs} from "pinia";
import {soundPackStore} from "@stores/sound_pack";
import {useRoute} from "vue-router";
import {mainStore} from "@stores/main";
import {computed, ComputedRef, onBeforeMount, onMounted, Ref, ref} from "vue";
import {AmbientType, OneShotType, SoundPackType, TrackType} from "@/js/types";
import {useCookies} from "vue3-cookies";
import VolumeControlGroup from "@components/sound_pack/VolumeControlGroup.vue";

const {cookies} = useCookies();
const route = useRoute();
const storeSoundPack = soundPackStore();
const storeIndex = mainStore();
const {sound_pack}: {
  sound_pack: SoundPackType
} = storeToRefs(storeSoundPack);
const id: string = route.params.id as string;

const tracksGroupVolumePercent: Ref<number> = ref(50);
const tracksGroupVolumeMultiplier: ComputedRef<number> = computed(() => convertPercentToMultiplier(tracksGroupVolumePercent.value));

const ambientGroupVolumePercent: Ref<number> = ref(50);
const ambientGroupVolumeMultiplier: ComputedRef<number> = computed(() => convertPercentToMultiplier(ambientGroupVolumePercent.value));

const oneShotsGroupVolumePercent: Ref<number> = ref(50);
const oneShotsGroupVolumeMultiplier: ComputedRef<number> = computed(() => convertPercentToMultiplier(oneShotsGroupVolumePercent.value));

function convertPercentToMultiplier(percent: number): number {
  return +(percent / 100).toFixed(2)
}

function updateTracksGroupVolumePercent(value: number) {
  tracksGroupVolumePercent.value = value;
}

function updateAmbientGroupVolumePercent(value: number) {
  ambientGroupVolumePercent.value = value;
}

function updateOneShotsGroupVolumePercent(value: number) {
  oneShotsGroupVolumePercent.value = value;
}

onBeforeMount(async () => {
  await Promise.all([
    storeSoundPack.initCurrentTrackTime(),
    storeSoundPack.initCurrentAmbientIds(),
    storeSoundPack.initCurrentTrackId(),
  ])
})

onMounted(async () => {
  storeIndex.enableLoader()

  await storeSoundPack.getSoundPack(id)
      .then(() => storeIndex.disableLoader());
});
</script>

<style scoped lang="scss">
@import "@scss/variables";

.sound-pack {
  &__lists {
  }

  &__row {
    & + & {
      margin-top: 2.5rem;
    }

    &-container {
      display: flex;
      align-items: center;
    }

    &-grid-container {
      display: grid;
      gap: 2rem;
      grid-template-columns: repeat(auto-fill, 14rem);
      grid-auto-flow: column;
    }
  }

  &__subtitle {
    margin-bottom: 0;
  }

  &__group-volume {
    margin-left: auto;
  }
}
</style>