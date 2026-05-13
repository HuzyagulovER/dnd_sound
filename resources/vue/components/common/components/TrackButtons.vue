<script setup lang="ts">
import PauseButton from "@components/common/components/PauseButton.vue";
import PlayButton from "@components/common/components/PlayButton.vue";
import StopButton from "@components/common/components/StopButton.vue";

const {is_playing = false, is_paused = false} = defineProps<{
  is_playing: boolean,
  is_paused: boolean,
}>();

const emit = defineEmits(['stop', 'play', 'pause', 'playElement'])

function handleStop() {
  emit('stop');
}

function handlePause() {
  emit('pause');
}

function handlePlay() {
  emit('play');
}
</script>

<template>
  <div class="media-buttons">
    <PauseButton v-if="is_playing"
                 @pause="handlePause"/>
    <PlayButton v-if="!is_playing"
                @play="handlePlay"/>
    <StopButton v-if="!is_playing && is_paused"
                @stop="handleStop"/>
  </div>
</template>

<style lang="scss">
@import "@scss/variables";

.media-buttons {
  display: flex;
  gap: 1rem;
  width: 100%;
  height: 100%;
}
</style>