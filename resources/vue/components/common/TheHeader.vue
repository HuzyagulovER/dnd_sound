<template>
  <div class="header">
    <h2 class="header__title">{{ title }}</h2>
    <slot></slot>
  </div>
</template>

<script setup lang="ts">
import {computed, watch} from "vue";
import {useRoute} from "vue-router";

const props = defineProps<{
  title?: string;
}>();
const route = useRoute();

const title = computed(() => {
  return props.title ?? route.meta?.title;
})
const titleElement = <HTMLElement>document.querySelector('head title');

watch(
    title,
    () => {
      titleElement.innerText = title.value;
    }
)
</script>

<style lang="scss" scoped>
.header {
  display: flex;
  align-items: center;

  &__title {
    margin-right: auto;
  }
}
</style>