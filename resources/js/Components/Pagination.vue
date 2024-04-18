<template>
  <div
    v-if="meta.links.length > 3"
    class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t bg-gray-50 sm:grid-cols-9"
  >
    <span class="flex items-center col-span-3">
      Showing {{ meta.from }} - {{ meta.to }} of
      {{ meta.total }}
    </span>
    <span class="col-span-2"></span>
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