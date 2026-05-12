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
@import "@scss/variables";

.header {
  display: flex;
  align-items: center;
  margin-bottom: 2rem;

  &__title {
    margin-right: auto;
    color: $--c__white;
    font-weight: 600;
    font-size: 3rem;
  }
}
</style>