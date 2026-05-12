<template>
  <TheNavbar/>
  <main class="main">
    <div class="main__container">
      <div class="main__view view">
        <RouterView v-slot="{ Component }">
          <Component :is="Component"/>
        </RouterView>
      </div>
    </div>
  </main>
  <TheLoader />
</template>

<script setup lang="ts">
import TheNavbar from "@components/TheNavbar.vue";
import TheLoader from "@components/common/components/TheLoader.vue";
</script>

<style lang="scss" scoped>
@import "@scss/base";

.main {
  display: flex;
  flex-grow: 1;
  width: 100%;

  &__container {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    width: 100%;
  }
}

.view {
  flex-grow: 1;
}
</style>