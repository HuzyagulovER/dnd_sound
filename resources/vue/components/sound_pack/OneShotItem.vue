<template>
  <div class="one-shot media-tile" :title="title" :class="{active: isActive}" @click="startSound">
    <p class="one-shot__title media-tile__title" :class="{'without-image': isNull(image)}">{{ title }}</p>

    <VolumeControlTile class="one-shot__volume-control-tile"
                       :storage-key="storageKey"
                       :model-value="currentVolumePercent"
                       @update:model-value="updateCurrentVolumeMultiplier"/>
  </div>
</template>

<script setup lang="ts">
import {computed, ComputedRef, onBeforeUnmount, Ref, ref, watch} from "vue";
import {useSound} from "@vueuse/sound";
import {isNull} from "lodash";
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
const storageKey = 'one_shot.'+id+'.volume';
const isActive: Ref<boolean> = ref(false);
const timeout: Ref<NodeJS.Timeout | null> = ref(null);
const currentVolumePercent: Ref<number> = ref(+cookies.get(storageKey) ?? 100);
const summaryVolume: ComputedRef<number> = computed((): number => {
  return groupVolume * +(currentVolumePercent.value / 100).toFixed(2);
});

const {play, sound, stop, duration} = useSound(src, {
  volume: summaryVolume.value,
  interrupt: false,
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

onBeforeUnmount(async function(){
  stop()
})
</script>

<style lang="scss">
@import "@scss/variables";

.one-shot {
  justify-content: center;
  cursor: pointer;

  &__volume-control-tile {
    visibility: hidden;
    opacity: 0;
  }

  &:hover {
    .one-shot__volume-control-tile {
      visibility: visible;
      opacity: 1;
    }
  }
}
</style>