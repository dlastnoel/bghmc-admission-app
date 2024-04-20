<template>
  <div
    v-if="meta.links.length > 3"
    class="flex flex-col justify-start items-start md:flex-row md:justify-between md:items-center px-4 py-3 text-xs md:text-sm font-semibold tracking-wide text-gray-500 uppercase border-t bg-gray-50 gap-2"
  >
    <div class="col-span-3">
      Showing {{ meta.from }} - {{ meta.to }} of
      {{ meta.total }}
    </div>
    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
      <nav>
        <ul class="inline-flex items-center">
          <li v-for="(link, i) in meta.links" :key="i">
            <Link
              :href="link.url"
              v-if="link.url"
              preserve-scroll
              :only="partials"
            >
              <button
                class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-blue"
                :class="{ 'bg-blue-600 text-white': link.active }"
                v-html="link.label"
              ></button>
            </Link>
            <button
              v-else
              class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-blue"
              v-html="link.label"
            ></button>
          </li>
        </ul>
      </nav>
    </span>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  meta: {
    type: Object,
    required: true,
  },
  partials: {
    type: Array,
    default: []
  } 
})
</script>