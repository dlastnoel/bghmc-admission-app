<template>
  <aside
    class="z-20 hidden md:w-56 w-64 overflow-y-auto bg-white md:block flex-shrink-0 shadow"
  >
    <div class="py-4 text-gray-500">
      <h1 class="ml-6 text-lg font-bold text-gray-800">
        <span class="text-blue-600">Admission</span> App
      </h1>
      <ul class="mt-6">
        <li class="relative px-3" v-for="(sidebarLink, i) in links" :key="i">
          <Link
            :href="route(sidebarLink.route)"
            class="rounded-lg mt-4 px-5 py-3 inline-flex items-center w-full text-md font-semibold transition-all duration-100 hover:bg-blue-600 hover:text-white"
            :class="
              sidebarLink.active.includes($page.component)
                ? 'bg-blue-600 text-white'
                : 'bg-white text-gray-800'
            "
          >
            <span v-html="sidebarLink.svg"></span>
            <span class="ml-4">{{ sidebarLink.title }}</span>
          </Link>
        </li>
      </ul>
    </div>
  </aside>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import { sidebarLinks } from '@/Utils/constants.js'

export default {

  components: {
    Link,
  },

  props: {
    sidebarLinks: {
      type: Object,
      required: true
    }
  },

  computed: {
    links() {
      return sidebarLinks
    }
  },
}
</script>

<style>
</style>