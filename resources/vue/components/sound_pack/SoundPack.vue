<template>
  <section class="sound_pack">
    <div class="sound_pack__container main-container">
      <TheHeader :title="sound_pack.title" />
    </div>
  </section>
</template>

<script setup lang="ts">
import TheHeader from "@components/common/TheHeader.vue";
import {storeToRefs} from "pinia";
import {soundPackStore} from "@stores/sound_pack";
import {useRoute} from "vue-router";
import {mainStore} from "@stores/main";

const route = useRoute();
const storeSoundPack = soundPackStore();
const {sound_pack} = storeToRefs(storeSoundPack);
const id: string = route.params.id as string;

const storeIndex = mainStore();

storeIndex.enableLoader()

storeSoundPack.getSoundPack(id)
    .then(() => storeIndex.disableLoader());
</script>

<style scoped lang="scss">
@import "@scss/variables";

.sound_pack {
  &__list {
    list-style: none;
  }

  &__item {
    cursor: pointer;

    & + & {
      margin-top: .5rem;
    }

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