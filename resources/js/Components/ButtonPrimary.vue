<template>
  <button
    class="min-w-24 font-medium text-white bg-blue-600 py-2 px-5 rounded border-none disabled:brightness-150"
  >
    {{ name }}
  </button>
</template>

<script>
export default {

  name: 'ButtonPrimary',

  props: {
    name: {
      type: String,
      required: true
    }
  }
}
</script>

<style>
</style>