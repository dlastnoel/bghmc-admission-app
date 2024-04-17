<template>
  <h2 class="my-6 text-2xl font-semibold text-gray-700">
    {{ title }}
  </h2>
</template>

<script>
export default {

  name: 'PageTitle',

  props: {
    title: {
      type: String,
      required: true
    }
  }

}
</script>

<style>
</style>