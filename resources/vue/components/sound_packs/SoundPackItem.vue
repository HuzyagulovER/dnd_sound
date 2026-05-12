<template>
  <RouterLink :to="{name:'SoundPack', params: {id: props.id}}" class="sound_pack-item">
    <div class="sound_pack-item__image image">
      <div class="image__element"
           :style="{backgroundImage: 'url('+image+')'}"
      ></div>
    </div>
    <div class="sound_pack-item__info">
      <p class="sound_pack-item__title">
        {{ title }}
      </p>
      <p class="sound_pack-item__count">
        {{ trackPluralize(count) }}
      </p>
    </div>
  </RouterLink>
</template>

<script setup lang="ts">
import {computed, inject} from "vue";

const props = defineProps<{
  id: string,
  title?: string,
  image?: string,
  count?: number,
}>();

const trackPluralize: Function = <Function>inject("trackPluralize");
const title = computed(() => {
  return props.title ?? 'Без названия';
})
</script>

<style scoped lang="scss">
@import "@scss/variables";

.sound_pack-item {
  display: flex;
  flex-direction: column;
  width: 14rem;
  height: 20rem;
  border: 1px solid $--c__grey;
  border-radius: 1rem;
  overflow: hidden;
  cursor: pointer;
  transition: all .3s ease;

  &__image {
    height: 75%;
    width: 100%;
    overflow: hidden;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      pointer-events: none;
    }
  }

  .image {
    &__element {
      width: 100%;
      height: 100%;
      background-size: cover;
      pointer-events: none;
      transition: all .3s ease;
    }
  }

  &__info {
    display: flex;
    flex-direction: column;
    padding: 1rem 1.5rem;
    justify-content: space-between;
    height: 25%;
  }

  &__title {
    font-size: 1.2rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  &__count {
    color: $--c__light-grey;
  }

  &:hover {
    border-color: $--c__light-grey;

    .image .image__element {
      transform: scale(1.3);
    }
  }
}
</style>