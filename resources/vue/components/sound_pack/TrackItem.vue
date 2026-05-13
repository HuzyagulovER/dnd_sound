<template>
  <div class="track" :title="title" :class="{active: isActive}">
    <p class="track__title">{{ title }}</p>
    <div class="track__button button" ref="button">
      <div class="button__container">
        <TrackButtons :is_playing="isActive"
                      :is_paused="isPaused"
                      @stop="handleStop"
                      @play="handlePlay"
                      @pause="handlePause"
        />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import {computed, ComputedRef, Ref, ref, watch} from "vue";
import {useSound} from "@vueuse/sound";
import TrackButtons from "@components/common/components/TrackButtons.vue";
import {soundPackStore} from "@stores/sound_pack";

const {src, title, id} = defineProps<{
  id: string,
  src: string,
  title: string,
}>();

const storeSoundPack = soundPackStore();
const {play, stop, isPlaying, pause, sound} = useSound(src, {
  volume: 1,
  onend: () => {
    storeSoundPack.setNextTrackId();
  }
});

const isActive: ComputedRef<boolean> = computed(() => isPlaying?.value);
const isPaused: Ref<boolean> = ref(false);

watch(
    () => storeSoundPack.stopSignal,
    () => {
      if (storeSoundPack.stopSignal) {
        handleStop()
      }
    },
    {
      immediate: true
    }
)

watch(
    () => storeSoundPack.currentTrackId,
    () => {
      if (storeSoundPack.currentTrackId === id) {
        if (!isActive.value) handlePlay()
      } else {
        handleStop()
      }
    }
)

function handlePause() {
  isPaused.value = true;
  pause();
}

function handlePlay() {
  if (!isPaused.value) {
    storeSoundPack.stopAllTracks()
        .then(() => {
          isPaused.value = false;
          play();
        })
        .then(() => {
          storeSoundPack.setCurrentTrackId(id)
        })
  } else {
    isPaused.value = false;
    play();
  }
}

function handleStop() {
  isPaused.value = false;
  stop();
}
</script>

<style lang="scss">
@import "@scss/variables";

.track {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 14rem;
  height: 14rem;
  border: 1px solid $--c__grey;
  border-radius: 1rem;
  overflow: hidden;
  transition: all .3s ease;
  background-color: $--c__active;
  padding: 1rem;
  position: relative;

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