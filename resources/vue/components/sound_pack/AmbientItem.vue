<template>
  <div class="ambient media-tile" :title="title" :class="{active: isActive}" @click="handleClick">
    <p class="ambient__title media-tile__title" :class="{'without-image': isNull(image)}">{{ title }}</p>

    <VolumeControlTile class="ambient__volume-control-tile"
                       :storage-key="storageKey"
                       :model-value="currentVolumePercent"
                       @update:model-value="updateCurrentVolumeMultiplier"/>
  </div>
</template>

<script setup lang="ts">
import {computed, ComputedRef, onBeforeUnmount, ref, Ref, watch} from "vue";
import {useSound} from "@vueuse/sound";
import {isNull} from "lodash";
import {soundPackStore} from "@stores/sound_pack";
import VolumeControlTile from "@components/sound_pack/VolumeControlTile.vue";
import {useCookies} from "vue3-cookies";

const {id, src, title, image, groupVolume} = defineProps<{
  id: string,
  src: string,
  title: string,
  image: string | null,
  groupVolume: number,
}>();

const {cookies} = useCookies();
const storageKey = 'ambient.'+id+'.volume';
const storeSoundPack = soundPackStore();
const isActive: ComputedRef<boolean> = computed(() => isPlaying?.value);
const currentVolumePercent: Ref<number> = ref(+cookies.get(storageKey) ?? 100);
const summaryVolume: ComputedRef<number> = computed((): number => {
  return groupVolume * +(currentVolumePercent.value / 100).toFixed(2);
});

const {play, stop, isPlaying, sound} = useSound(src, {
  volume: summaryVolume.value,
  loop: true,
  onload: () => {
    if (storeSoundPack.currentAmbientIds.includes(id)) {
      play();
    }
  }
});

watch(
    summaryVolume,
    () => {
      sound?.value?.volume(summaryVolume.value);
    }
)

function updateCurrentVolumeMultiplier(value: number): void {
  currentVolumePercent.value = value;
}

function calcSummaryVolume(): number {
  return groupVolume * currentVolumePercent.value;
}

function handleClick() {
  isPlaying.value ? handleStop() : handlePlay();
}

function handlePlay() {
  storeSoundPack.addToCurrentAmbientIds(id);
  play();
}

function handleStop() {
  storeSoundPack.removeFromCurrentAmbientIds(id)
  stop();
}

onBeforeUnmount(async function () {
  stop()
})
</script>

<style lang="scss">
@import "@scss/variables";

.ambient {
  justify-content: center;
  cursor: pointer;

  &__volume-control-tile {
    visibility: hidden;
    opacity: 0;
  }

  &:hover {
    .ambient__volume-control-tile {
      visibility: visible;
      opacity: 1;
    }
  }
}
</style>