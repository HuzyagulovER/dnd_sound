<script setup lang="ts">
import {RouteLocationRaw} from "vue-router";

const {text, to, is_plus = true} = defineProps<{
  text: string,
  to?: RouteLocationRaw,
  is_plus?: boolean,
}>();
</script>

<template>
  <RouterLink :to="to" class="button-create" v-if="to">
    <div class="button-create__plus" v-if="is_plus"></div>
    <div class="button-create__text">
      <p v-if="text">{{ text }}</p>
      <p v-else>Создать</p>
    </div>
  </RouterLink>
  <div class="button-create" v-else>
    <div class="button-create__plus" v-if="is_plus"></div>
    <div class="button-create__text">
      <p v-if="text">{{ text }}</p>
      <p v-else>Создать</p>
    </div>
  </div>
</template>

<style scoped lang="scss">
@import "@scss/variables";

.button-create {
  $--fz: 1rem;
  $--thickness__plus: 2px;

  display: flex;
  align-items: center;
  background-color: $--c__light-active;
  cursor: pointer;
  padding: 1rem 1.5rem;
  border-radius: 1rem;
  transition: all .2s ease;
  text-decoration: none;

  &__plus {
    position: relative;
    width: $--fz;
    height: $--fz;
    margin-right: .5rem;

    &::before,
    &::after {
      content: '';
      position: absolute;
      background-color: $--c__white;
    }

    &::before {
      width: $--fz;
      height: $--thickness__plus;
      top: 50%;
      left: 0;
      transform: translateY(-50%);
    }

    &::after {
      width: $--thickness__plus;
      height: $--fz;
      top: 0;
      left: 50%;
      transform: translateX(-50%);
    }
  }

  &__text {
    p {
      color: $--c__white;
      font-size: $--fz;
    }
  }

  &:hover {
    background-color: $--c__active;
  }
}
</style>