<template>
  <section class="sound-packs">
    <div class="sound-packs__container">
      <TheHeader>
        <ButtonCreate text="Создать плейлист" :to="{name: 'SoundPackCreate'}" />
      </TheHeader>
      <div class="sound-packs__list">
        <div class="sound-packs__item" v-for="(sound_pack) in sound_packs" :key='sound_pack.id'>
          <SoundPackItem :id="sound_pack.id"
                         :title="sound_pack.title"
                         :image="sound_pack.image"
                         :count="sound_pack.count"
          />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import TheHeader from "@components/common/TheHeader.vue";
import SoundPackItem from "./SoundPacksItem.vue";
import ButtonCreate from "@components/common/components/ButtonCreate.vue";
import {soundPackStore} from "@stores/sound_pack";
import {storeToRefs} from "pinia";
import {mainStore} from "@stores/main";

const storeSoundPack = soundPackStore();
const {sound_packs} = storeToRefs(storeSoundPack);
const storeIndex = mainStore();

storeIndex.enableLoader()

storeSoundPack.getSoundPacks()
    .then(() => storeIndex.disableLoader());
</script>

<style scoped lang="scss">
@import "@scss/variables";

.sound-packs {
  &__list {
    display: grid;
    grid-template: auto / repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem 0;
  }

  &__item {
    display: flex;
    justify-content: center;

    a {
      text-decoration: none;
      color: $--c__white;
    }

    &:hover {
      a {
        color: $--c__white;
      }
    }
  }
}
</style>