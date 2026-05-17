<template>
  <section class="sound-pack-create">
    <div class="sound-pack-create__container">
      <TheHeader title="Создание плейлиста"/>

      <div class="sound-pack__lists">
        <div class="sound-pack__row">
          <p class="sound-pack__subtitle subtitle">Tracks</p>
          <div class="sound-pack__row-container">

          </div>
        </div>
        <div class="sound-pack__row">
          <p class="sound-pack__subtitle subtitle">Ambient</p>
          <div class="sound-pack__row-container">

          </div>
        </div>
        <div class="sound-pack__row">
          <p class="sound-pack__subtitle subtitle">One shots</p>
          <div class="sound-pack__row-container">

          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import TheHeader from "@components/common/TheHeader.vue";
</script>

<style scoped lang="scss">
@import "@scss/variables";

.sound-pack-create {
  &__lists {
  }

  &__row {
    & + & {
      margin-top: 2.5rem;
    }

    &-container {
      display: grid;
      gap: 2rem;
      grid-template-columns: repeat(auto-fill, 14rem);
      grid-auto-flow: column;
    }
  }
}
</style>