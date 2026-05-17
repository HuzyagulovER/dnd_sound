<template>
  <div class="track media-tile" :title="title" :class="{active: isActive}" :style="{backgroundImage: 'url('+image+')'}">
    <p class="track__title media-tile__title" :class="{'without-image': isNull(image)}">{{ title }}</p>
    <div class="track__button button" ref="button">
      <div class="button__container">
        <TrackButtons :is_playing="isActive"
                      :is_paused="isPaused"
                      @stop="handleStopClick"
                      @play="handlePlay"
                      @pause="handlePause"
        />
      </div>
    </div>

    <VolumeControlTile class="track__volume-control-tile"
                       :storage-key="storageKey"
                       :model-value="currentVolumePercent"
                       @update:model-value="updateCurrentVolumeMultiplier"/>
  </div>
</template>

<script setup lang="ts">
import TrackButtons from "@components/common/components/TrackButtons.vue";
import {computed, ComputedRef, onBeforeUnmount, Ref, ref, watch} from "vue";
import {useSound} from "@vueuse/sound";
import {soundPackStore} from "@stores/sound_pack";
import {isNull} from "lodash";
import VolumeControlTile from "@components/sound_pack/VolumeControlTile.vue";
import {useCookies} from "vue3-cookies";

const {id, src, title, image, groupVolume = .5} = defineProps<{
  id: string,
  src: string,
  title: string,
  image: string | null,
  startTime: number,
  groupVolume: number,
}>();

const {cookies} = useCookies();
const storeSoundPack = soundPackStore();
const storageKey = 'track.'+id+'.volume';
const interval: Ref<NodeJS.Timeout | null> = ref(null);
const currentVolumePercent: Ref<number> = ref(+cookies.get(storageKey) ?? 100);
const summaryVolume: ComputedRef<number> = computed((): number => {
  return groupVolume * +(currentVolumePercent.value / 100).toFixed(2);
});

const {play, stop, isPlaying, pause, sound} = useSound(src, {
  volume: summaryVolume.value,
  onload: () => {
    if (storeSoundPack.currentTrackId === id) {
      seekAndPlay();
    }
  },
  onplay: () => {
    intervalStart();
  },
  onstop: () => {
    intervalClear();
  },
  onend: () => {
    intervalClear();
    storeSoundPack.removeCurrentTrackTimeFromCookies();
    storeSoundPack.setNextTrackId();
  },
});

watch(
    summaryVolume,
    () => {
      sound?.value?.volume(summaryVolume.value);
    }
)

const isActive: ComputedRef<boolean> = computed(() => isPlaying?.value);
const isPaused: Ref<boolean> = ref(false);

watch(
    () => storeSoundPack.stopSignal,
    () => {
      if (storeSoundPack.stopSignal) {
        if (storeSoundPack.currentTrackId === id) {
          handleStop();
        }
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

function updateCurrentVolumeMultiplier(value: number): void {
  currentVolumePercent.value = value;
}

function intervalClear() {
  if (!isNull(interval.value)) {
    clearInterval(interval.value as NodeJS.Timeout);
    interval.value = null;
  }
}

function intervalStart() {
  interval.value = setInterval(() => storeSoundPack.setCurrentTrackTimeToCookies(sound.value?.seek()), 1000);
}

function handlePause() {
  isPaused.value = true;
  pause();
}

function handlePlay() {
  if (!isPaused.value) {
    storeSoundPack.stopCurrentTrack()
        .then(() => {
          isPaused.value = false;
          seekAndPlay();
        })
        .then(() => {
          storeSoundPack.setCurrentTrackId(id)
        })
  } else {
    isPaused.value = false;
    play();
  }
}

function seekAndPlay() {
  sound.value?.seek(storeSoundPack.currentTrackTime);
  play();
}

function handleStop() {
  isPaused.value = false;
  stop();
}

function handleStopClick() {
  storeSoundPack.removeCurrentTrackId();
  storeSoundPack.removeCurrentTrackTime();
  storeSoundPack.removeCurrentTrackTimeFromCookies();
  handleStop();
}

onBeforeUnmount(async function () {
  handleStop()
})
</script>

<style lang="scss">
@import "@scss/variables";

.track {
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

  &__volume-control-tile {
    visibility: hidden;
    opacity: 0;
  }

  &:hover {
    .track__volume-control-tile {
      visibility: visible;
      opacity: 1;
    }
  }
}
</style>