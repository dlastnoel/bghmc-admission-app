<template>
  <small class="mt-1 text-sm block text-red-500">
    {{ message }}
  </small>
</template>

<script setup>
defineProps({
  message: {
    type: String,
    default: ''
  }
})
</script>

<style>
</style>