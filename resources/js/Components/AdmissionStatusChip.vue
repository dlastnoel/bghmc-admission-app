<template>
  <span
    class="text-xs px-2 py-1 font-semibold leading-tight rounded-full"
    :class="
      admission.discharged_at
        ? 'bg-red-100 text-red-700'
        : 'text-green-700 bg-green-100'
    "
  >
    {{ admission.discharged_at ? "Discharged" : "Admitted" }}
  </span>
</template>

<script setup>

defineProps({
  admission: {
    type: Object,
    required: true
  }
  })
  
</script>

<style>
</style>