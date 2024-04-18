<template>
  <label :for="label" class="text-sm text-gray-700 font-medium">
    <slot />
  </label>
</template>

<script setup>
defineProps({
  label: {
    type: String,
    required: true
  }
})
</script>

<style>
</style>