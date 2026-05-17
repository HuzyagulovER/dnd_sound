<template>
  <div class="volume-control-tile" @click.prevent.stop="null">
    <button
        class="volume-control-tile__volume-button"
        @click="toggleMute"
        :title="isMuted ? 'Включить звук' : 'Выключить звук'"
    >
      <!-- Иконка динамика -->
      <svg v-if="isMuted || volume === 0" viewBox="0 0 24 24" width="24" height="24">
        <path fill="currentColor"
              d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.2.05-.41.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51C20.63 14.91 21 13.5 21 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71zM4.27 3L3 4.27 7.73 9H3v6h4l5 5v-6.73l4.25 4.25c-.67.52-1.42.93-2.25 1.18v2.06c1.38-.31 2.63-.95 3.69-1.81L19.73 21 21 19.73l-9-9L4.27 3zM12 4L9.91 6.09 12 8.18V4z"/>
      </svg>
      <svg v-else-if="volume < 0.5" viewBox="0 0 24 24" width="24" height="24">
        <path fill="currentColor"
              d="M18.5 12c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM5 9v6h4l5 5V4L9 9H5z"/>
      </svg>
      <svg v-else viewBox="0 0 24 24" width="24" height="24">
        <path fill="currentColor"
              d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
      </svg>
    </button>

    <div class="volume-control-tile__slider-container">
      <input
          type="range"
          class="volume-control-tile__volume-slider"
          min="0"
          max="100"
          :value="displayVolume"
          @input="handleVolumeChange"
      />
      <div class="volume-control-tile__volume-level" :style="{ width: displayVolume + '%' }"></div>
    </div>

    <span class="volume-control-tile__volume-value">{{ displayVolume }}%</span>
  </div>
</template>

<script setup lang="ts">
import {ref, computed, watch} from 'vue'
import {useCookies} from "vue3-cookies";

const {cookies} = useCookies();
const volumeDefault: number = 50;

const {modelValue = volumeDefault, storageKey = 'app-volume'} = defineProps<{
  modelValue: number,
  storageKey: string,
}>();

const emit = defineEmits(['update:model-value', 'volume-change'])

const volume = ref(modelValue)
const previousVolume = ref(modelValue)
const isMuted = ref(false)

const displayVolume = computed(() => {
  return isMuted.value ? 0 : volume.value
})

// Загрузка сохраненной громкости из Cookie
const loadSavedVolume = () => {
  try {
    const saved = cookies.get(storageKey);

    if (saved !== '') {
      const savedVolume = parseInt(saved)
      if (!isNaN(savedVolume) && savedVolume >= 0 && savedVolume <= 100) {
        volume.value = savedVolume
        emit('update:model-value', savedVolume)
      }
    }
  } catch (e) {
    console.warn('Не удалось загрузить сохраненную громкость:', e)
  }
}

// Сохранение громкости в Cookie
const saveVolume = (value) => {
  try {
    cookies.set(storageKey, value.toString());
  } catch (e) {
    console.warn('Не удалось сохранить громкость:', e)
  }
}

const handleVolumeChange = (event) => {
  const newVolume = parseInt(event.target.value)
  volume.value = newVolume

  if (newVolume > 0) {
    isMuted.value = false
  }

  emit('update:model-value', newVolume)
  emit('volume-change', newVolume)
  saveVolume(newVolume)
}

const toggleMute = () => {
  if (isMuted.value) {
    isMuted.value = false
    volume.value = previousVolume.value || volumeDefault
    emit('update:model-value', volume.value)
    emit('volume-change', volume.value)
  } else {
    previousVolume.value = volume.value
    isMuted.value = true
    emit('update:model-value', 0)
    emit('volume-change', 0)
  }
}

// Следим за внешними изменениями
watch(() => modelValue, (newVal) => {
  volume.value = newVal
  if (newVal > 0) {
    isMuted.value = false
  }
})

// Инициализация
loadSavedVolume()
</script>

<style scoped lang="scss">
.volume-control-tile {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 8px 8px;
  border-radius: 12px;
  transform: rotate(-90deg) translate(-29px, -29px);
  transform-origin: left center;
  position: absolute;
  top: 0;
  left: 100%;
  background: rgba(255, 255, 255, 0);
  backdrop-filter: blur(0);
  border: 0 solid rgba(255, 255, 255, 0.2);
  transition: all 0.1s ease;

  &:hover {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-width: 1px;

    .volume-control-tile {
      &__slider-container,
      &__volume-slider,
      &__volume-level,
      &__volume-value {
        visibility: visible;
        opacity: 1;
      }
    }
  }

  &.unbordered {
    background: unset;
    border: unset;
  }

  &__volume-button {
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px;
    color: #ffffff;
    transition: all 0.3s ease;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transform: rotate(90deg);

    &:hover {
      background: rgba(255, 255, 255, 0.1);
      transform: scale(1.1) rotate(90deg);
    }
  }

  &__slider-container {
    position: relative;
    flex: 1;
    width: 100%;
    min-width: 100px;
    height: 6px;
    visibility: hidden;
    opacity: 0;
  }

  &__volume-slider {
    -webkit-appearance: none;
    appearance: none;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 3px;
    outline: none;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
    cursor: pointer;
    visibility: hidden;
    opacity: 0;

    &::-webkit-slider-thumb {
      -webkit-appearance: none;
      appearance: none;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      background: #4CAF50;
      cursor: pointer;
      border: 2px solid #ffffff;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease;
    }

    &::-webkit-slider-thumb:hover {
      transform: scale(1.2);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    &::-moz-range-thumb {
      width: 18px;
      height: 18px;
      border-radius: 50%;
      background: #4CAF50;
      cursor: pointer;
      border: 2px solid #ffffff;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
  }

  &__volume-level {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 6px;
    background: linear-gradient(90deg, #4CAF50, #8BC34A);
    border-radius: 3px;
    z-index: 1;
    pointer-events: none;
  }

  &__volume-value {
    font-size: 14px;
    color: #ffffff;
    font-weight: 500;
    min-width: 40px;
    text-align: center;
    transform: rotate(90deg);
    visibility: hidden;
    opacity: 0;
  }
}
</style>