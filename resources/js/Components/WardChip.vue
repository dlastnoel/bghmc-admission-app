<template>
  <span
    class="text-xs px-2 py-1 font-semibold leading-tight rounded-full"
    :class="
      type === 'occupied'
        ? 'bg-red-100 text-red-700'
        : 'text-green-700 bg-green-100'
    "
  >
    {{ type === "occupied" ? ward.occupied : ward.vacant }} {{ type }}
  </span>
</template>

<script setup>

defineProps({
  type: {
    type: String,
    required: true
  },
  ward: {
    type: Object,
    required: true
  }
  })
  
</script>

<style>
</style>