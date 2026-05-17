<template>
  <div class="stop" @click="stop">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352.22 351.5">
      <path
          d="M175.63,351.5C78.07,350.86-.59,271.77,0,174.89S80-.51,176.59,0c97.47.52,176.34,79.82,175.63,176.59C351.51,273.55,272.18,352.12,175.63,351.5ZM96,175.54q0,26.76,0,53.52c0,16.7,9.86,26.6,26.52,26.6q53.64,0,107.27,0c16.41,0,26.37-10,26.38-26.37q0-53.52,0-107c0-16.43-9.94-26.4-26.34-26.4q-53.64,0-107.27,0c-16.68,0-26.55,9.89-26.56,26.56Q96,149,96,175.54Z"/>
    </svg>
  </div>
</template>

<style lang="scss">
@import "@scss/variables";

.stop {
  width: 100%;
  height: 100%;
  fill: $--c__white;
  cursor: pointer;
  border-radius: 50%;
}
</style>

<script setup lang="ts">
const emit = defineEmits(['stop'])
function stop() {
  emit('stop')
}
</script>