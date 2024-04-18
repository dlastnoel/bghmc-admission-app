<template>
  <div class="flex justify-between items-center">
    <PageTitle title="Patients" />
    <Link :href="route('patients.create')">
      <ButtonPrimary>Create</ButtonPrimary>
    </Link>
  </div>

  <div class="w-full overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">
      <table class="w-full whitespace-no-wrap">
        <thead>
          <tr
            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-blue-100"
          >
            <th class="px-4 py-3">Patient</th>
            <th class="px-4 py-3">Date of Birth</th>
            <th class="px-4 py-3">Address</th>
            <th class="px-4 py-3"></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y">
          <tr
            class="text-gray-700"
            v-for="(patient, i) in patients.data"
            :key="i"
          >
            <td class="px-4 py-3">
              <div>
                <p class="font-semibold">{{ displayName(patient) }}</p>
                <p class="text-xs text-gray-600">{{ patient.age }} yrs old</p>
              </div>
            </td>
            <td class="px-4 py-3 text-sm">
              {{ moment(patient.date_of_birth).format("YYYY-MM-DD") }}
            </td>
            <td class="px-4 py-3 text-sm">
              {{ patient.address }}
            </td>
            <td class="px-4 py-3">
              <div class="flex items-center space-x-4 text-sm">
                <Link :href="route('patients.edit', { patient: patient.id })">
                  <button
                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-600 rounded-lg focus:outline-none focus:shadow-outline-gray"
                  >
                    <svg
                      class="w-5 h-5"
                      aria-hidden="true"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                      ></path>
                    </svg>
                  </button>
                </Link>
                <button
                  class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-600 rounded-lg focus:outline-none focus:shadow-outline-gray"
                  aria-label="Delete"
                >
                  <svg
                    class="w-5 h-5"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <Pagination :meta="patients.meta" :partials="['patients']" />
  </div>
</template>

<script>
import AuthLayout from '@/Layouts/AuthLayout.vue'
import PageTitle from '@/Components/PageTitle.vue'
import ButtonPrimary from '@/Components/ButtonPrimary.vue'
import Pagination from '@/Components/Pagination.vue'

import { Link } from '@inertiajs/vue3'
import { displayName } from '@/Helpers/displayHelpers'
import moment from 'moment'

export default {

  layout: AuthLayout,

  components: {
    Link,
    PageTitle,
    ButtonPrimary,
    Pagination
  },

  props: {
    patients: Object,
    filters: Object,
  },

  data() {

    return {
      
    }
  },

  methods: {

    displayName,
    moment,
  }
}
</script>

<style>
</style>