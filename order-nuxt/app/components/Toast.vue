<template>
  <div class="fixed top-4 right-4 space-y-2 z-50">
    <transition-group name="fade" tag="div">
      <div
        v-for="toast in toasts"
        :key="toast.id"
        :class="[
          'px-4 py-2 rounded-lg shadow text-white',
          toast.type === 'success' ? 'bg-green-600' : 'bg-red-600'
        ]"
      >
        {{ toast.text }}
      </div>
    </transition-group>
  </div>
</template>

<script setup lang="ts">
import { useToast } from "../composables/useToast"
const { toasts } = useToast()
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>
