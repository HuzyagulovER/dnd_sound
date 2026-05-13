<script setup lang="ts">
import PlayButton from "@components/common/components/PlayButton.vue";
import StopButton from "@components/common/components/StopButton.vue";
</script>

<template>
  <div class="play-stop">
    <StopButton @stop="$emit('stop')"/>
    <PlayButton @play="$emit('play')"/>
  </div>
</template>

<style lang="scss">
@import "@scss/variables";

.play-stop {
  display: flex;
  gap: 1rem;
  width: 100%;
  height: 100%;
}
</style>