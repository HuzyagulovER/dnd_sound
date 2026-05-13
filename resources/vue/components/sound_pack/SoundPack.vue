<template>
  <section class="sound-pack">
    <div class="sound-pack__container">
      <TheHeader :title="sound_pack.title"/>

      <div class="sound-pack__lists">
        <div class="sound-pack__row">
          <p class="sound-pack__subtitle subtitle">Tracks</p>
          <div class="sound-pack__row-container">
            <TrackItem v-for="(track) in sound_pack.media?.tracks"
                       :id="(track as TrackType).id"
                       :src="(track as TrackType).file ?? ''"
                       :title="(track as TrackType).title"
            />
          </div>
        </div>
        <div class="sound-pack__row">
          <p class="sound-pack__subtitle subtitle">Ambient</p>
          <div class="sound-pack__row-container">
            <AmbientItem v-for="(ambient) in sound_pack.media?.ambient"
                         :id="(ambient as TrackType).id"
                         :src="(ambient as AmbientType).file ?? ''"
                         :title="(ambient as AmbientType).title"
            />
          </div>
        </div>
        <div class="sound-pack__row">
          <p class="sound-pack__subtitle subtitle">One shots</p>
          <div class="sound-pack__row-container">
            <OneShotItem v-for="(one_shot) in sound_pack.media?.one_shots"
                         :id="(one_shot as TrackType).id"
                         :src="(one_shot as OneShotType).file ?? ''"
                         :title="(one_shot as OneShotType).title"
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
import {onMounted} from "vue";
import {AmbientType, OneShotType, SoundPackType, TrackType} from "@/js/types";

const route = useRoute();
const storeSoundPack = soundPackStore();
const {sound_pack}: {
  sound_pack: SoundPackType
} = storeToRefs(storeSoundPack);
const id: string = route.params.id as string;

const storeIndex = mainStore();

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
      display: grid;
      gap: 2rem;
      grid-template-columns: repeat(auto-fill, 14rem);
      grid-auto-flow: column;
    }
  }
}
</style>