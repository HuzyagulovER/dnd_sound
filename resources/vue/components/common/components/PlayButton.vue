<template>
  <div class="play" @click="play">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 351.54 352.19">
      <path
          d="M175.59,352.19C78.46,351.94-.39,272.61,0,175.53S79.33-.19,176,0c97.12.19,176,79.56,175.59,176.64S272.17,352.43,175.59,352.19ZM111.93,176.06q0,30.16,0,60.35a33.3,33.3,0,0,0,.66,7.8c4.17,17.37,22.88,25.45,38.62,16.57,14.44-8.14,28.72-16.56,43.07-24.86q31.56-18.25,63.13-36.51c9.19-5.3,14.29-13.14,14.1-23.84-.18-10.22-5.25-17.68-14-22.76-35-20.19-70.09-40.14-104.81-60.76-19.64-11.67-41.66,2.76-40.92,23.66C112.49,135.8,111.93,155.94,111.93,176.06Z"/>
    </svg>
  </div>
</template>

<style lang="scss">
@import "@scss/variables";

.play {
  width: 100%;
  height: 100%;
  fill: $--c__white;
  cursor: pointer;
}
</style>

<script setup lang="ts">
const emit = defineEmits(['play', 'playElement'])

function play() {
  emit('play')
}
</script>