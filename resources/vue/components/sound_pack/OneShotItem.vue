<template>
  <div class="one-shot" :title="title" :class="{active: isActive}" @click="startSound">
    <p class="one-shot__title">{{ title }}</p>
  </div>
</template>

<script setup lang="ts">
import {Ref, ref} from "vue";
import {useSound} from "@vueuse/sound";

const {src, title} = defineProps<{
  src: string,
  title: string,
}>();

const activeSoundIds = ref<Set<number>>(new Set()); // Используем Set для уникальности

const {play, sound, duration} = useSound(src, {
  volume: 1,
  interrupt: false,
});

const isActive: Ref<boolean> = ref(false);
const timeout: Ref<NodeJS.Timeout | null> = ref(null);

// Функция запуска звука (вызывается в разное время)
const startSound = () => {
  isActive.value = true
  play();

  if (timeout.value) {
    clearTimeout(timeout.value as NodeJS.Timeout)
  }

  timeout.value = setTimeout(() => {
    isActive.value = false
  }, duration.value);
};
</script>

<style lang="scss">
@import "@scss/variables";

.one-shot {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 14rem;
  height: 14rem;
  border: 1px solid $--c__grey;
  border-radius: 1rem;
  overflow: hidden;
  transition: all .3s ease;
  background-color: $--c__active;
  padding: 1rem;
  position: relative;
  cursor: pointer;

  &__title {
    color: $--c__white;
  }

  .button {
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;

    &__container {
      .play,
      .stop,
      .pause {
        width: 4rem;
        height: 4rem;
      }
    }
  }

  &.active,
  &:hover {
    background-color: $--c__light-active;
  }

  &.pointer {
    cursor: pointer;
  }
}
</style>