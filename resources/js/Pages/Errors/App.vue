<template>
  <main class="grid place-content-center h-screen w-full p-8">
    <img :src="svg" alt="Admission App" class="w-72 md:w-96 mb-5 m-auto" />
    <h1 class="text-5xl md:text-7xl font-semibold text-center">
      <span class="text-blue-600">{{ error.code }}</span> {{ error.title }}
    </h1>
    <h3 class="mt-5 text-3xl md:text-4xl fold-medium text-center">
      {{ error.message }}
    </h3>
    <div class="mt-5 m-auto">
      <Link :href="route('home.index')">
        <ButtonPrimary class="p-3 text-xl">Back to Home</ButtonPrimary>
      </Link>
    </div>
  </main>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import ButtonPrimary from '@/Components/ButtonPrimary.vue'
import svg from '../../../images/app.svg'

export default {

  components: {
    Link,
    ButtonPrimary
  },

  props: {
    error: Object,
  },

  data() {

    return {

      svg,
    }
  },
}
</script>

<style>
</style>