<template>
  <div class="track"></div>
</template>

<script setup lang="ts">

const props = defineProps<{
  src,
}>();

console.log(props.src)
</script>

<style scoped lang="scss">
@import "@scss/variables";

.track {
  display: flex;
  flex-direction: column;
  width: 14rem;
  height: 14rem;
  border: 1px solid $--c__grey;
  border-radius: 1rem;
  overflow: hidden;
  cursor: pointer;
  transition: all .3s ease;
  background-color: $--c__active;

  &:hover {
    background-color: $--c__light-active;
  }
}
</style>