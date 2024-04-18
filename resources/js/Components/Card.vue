<template>
  <div class="flex items-center p-4 bg-white rounded-lg shadow">
    <div class="p-3 mr-4 text-blue-600 bg-blue-100 rounded-full">
      <span v-html="item.svg"></span>
    </div>
    <div>
      <p class="mb-2 text-sm font-medium text-gray-600">{{ item.title }}</p>
      <p class="text-lg font-semibold text-gray-700">{{ item.value }}</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  item: {
    type: Object,
    required: true
  }
})
</script>

<style>
</style>