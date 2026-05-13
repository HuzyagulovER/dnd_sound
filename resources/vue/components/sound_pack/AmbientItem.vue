<template>
  <div class="ambient" :title="title" :class="{active: isActive}" @click="handleClick">
    <p class="ambient__title">{{ title }}</p>
  </div>
</template>

<script setup lang="ts">
import {computed, ComputedRef} from "vue";
import {useSound} from "@vueuse/sound";

const {src, title} = defineProps<{
  src: string,
  title: string,
}>();

const {play, stop, isPlaying} = useSound(src, {
  volume: 1,
  loop: true,
});

const isActive: ComputedRef<boolean> = computed(() => isPlaying?.value);

function handleClick() {
  isPlaying.value ? stop() : play();
}
</script>

<style lang="scss">
@import "@scss/variables";

.ambient {
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

  &.active,
  &:hover {
    background-color: $--c__light-active;
  }

  &.pointer {
    cursor: pointer;
  }
}
</style>