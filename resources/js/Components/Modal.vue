<template>
  <div
    class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
  >
    <div
      class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg sm:rounded-lg sm:m-4 sm:max-w-xl"
    >
      <div class="mt-4 mb-6" v-if="$slots.content">
        <slot name="content" />
      </div>
      <div class="mt-4 mb-6" v-if="title">
        <p class="mb-2 text-lg font-semibold text-gray-700">
          {{ title }}
        </p>
        <p class="text-sm text-gray-700" v-if="text">{{ text }}</p>
      </div>
      <footer
        v-if="$slots.footer"
        class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50"
      >
        <slot name="footer" />
      </footer>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    default: ''
  },
  text: {
    type: String,
    default: ''
  }
})
</script>