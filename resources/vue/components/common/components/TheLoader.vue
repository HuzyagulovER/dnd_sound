<script setup lang="ts">
import {mainStore} from "@stores/main";
import {storeToRefs} from "pinia";

const store = mainStore();
const {loader} = storeToRefs(store);
</script>

<template>
  <div class="loader-container" v-if="loader">
    <div class="layout"></div>
    <div class="loader"></div>
  </div>
</template>

<style scoped lang="scss">
@import "@scss/variables";
$time: 1s;

.layout,
.loader-container{
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: $--c__background;
}

.loader {
  &-container {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  width: 150px;
  aspect-ratio: 1;
  display: grid;
  border: 4px solid;
  border-radius: 50%;
  border-color: #ccc #0000;
  animation: l16 $time infinite linear;
}
.loader::before,
.loader::after {
  content: "";
  grid-area: 1/1;
  margin: 8px;
  border: inherit;
  border-radius: 50%;
}
.loader::before {
  border-color: #f03355 #0000;
  animation: inherit;
  animation-duration: .5s;
  animation-direction: reverse;
}
.loader::after {
  margin: 20px;
}
@keyframes l16 {
  100%{transform: rotate(1turn)}
}
</style>