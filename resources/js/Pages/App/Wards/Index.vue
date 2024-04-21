<template>
  <div class="flex justify-between items-center">
    <PageTitle title="Wards" />
    <Link :href="route('wards.create')">
      <ButtonPrimary>Create</ButtonPrimary>
    </Link>
  </div>

  <div
    class="w-full flex flex-col md:flex-row justify-between items-center gap-3"
  >
    <div class="w-full md:w-auto">
      <InputText
        v-model="filterForm.query"
        placeholder="Search"
        class="border-gray-300 w-full md:w-auto"
      >
      </InputText>
    </div>
    <div
      class="flex w-full md:w-auto flex-col md:flex-row justify-end items-center relative gap-3"
    >
      <select
        v-model="filterForm.sort_by"
        class="h-full rounded-md border-gray-300 py-3 text-sm w-full md:w-auto"
      >
        <option value="Date Created">Date Created</option>
        <option value="Name">Name</option>
      </select>
      <select
        v-model="filterForm.direction"
        class="h-full rounded-md border-gray-300 py-3 text-sm w-full md:w-auto"
      >
        <option value="Ascending">Ascending</option>
        <option value="Descending">Descending</option>
      </select>
      <select
        v-model="filterForm.size"
        class="h-full rounded-md border-gray-300 py-3 text-sm w-full md:w-auto"
      >
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="50">50</option>
      </select>
    </div>
  </div>

  <div class="mt-5 w-full overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">
      <table class="w-full whitespace-no-wrap">
        <thead>
          <tr
            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-blue-100"
          >
            <th class="px-4 py-3">Name</th>
            <th class="px-4 py-3">Capacity</th>
            <th class="px-4 py-3"></th>
            <th class="px-4 py-3"></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y">
          <template v-if="wards.data.length">
            <tr class="text-gray-700" v-for="(ward, i) in wards.data" :key="i">
              <td class="px-4 py-3">
                <div>
                  <p class="font-semibold">{{ ward.name }}</p>
                  <p class="text-xs text-gray-600">
                    {{ ward.description }}
                  </p>
                </div>
              </td>
              <td class="px-4 py-3 text-sm">
                <div>
                  <p class="font-semibold">
                    {{ ward.capacity }} Total Capacity
                  </p>
                  <div class="mt-3 flex justify-start items-center gap-2">
                    <WardChip :ward="ward" type="vacant" />
                    <WardChip :ward="ward" type="occupied" />
                  </div>
                </div>
              </td>
              <td class="py-3">
                <button
                  @click="handleAdmitWard(ward)"
                  v-if="ward.vacant"
                  class="flex items-center justify-between px-2 py-2 text-sm leading-5 text-green-700 rounded-lg focus:outline-none focus:shadow-outline-gray"
                >
                  <SquaresPlusIcon class="w-5 h-5" />
                </button>
              </td>
              <td class="px-4 py-3">
                <div class="flex justify-center items-center text-sm gap-2">
                  <Link :href="route('wards.edit', { ward: ward.id })">
                    <button
                      class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-600 rounded-lg focus:outline-none focus:shadow-outline-gray"
                    >
                      <PencilIcon class="w-5 h-5" />
                    </button>
                  </Link>
                </div>
              </td>
            </tr>
          </template>
          <TableNoData :colspan="4" class="px-4 py-3" v-else />
        </tbody>
      </table>
    </div>
    <Pagination :meta="wards.meta" :partials="['wards']" />
  </div>
</template>

<script>
import AuthLayout from '@/Layouts/AuthLayout.vue'
import PageTitle from '@/Components/PageTitle.vue'
import ButtonPrimary from '@/Components/ButtonPrimary.vue'
import ButtonMuted from '@/Components/ButtonMuted.vue'
import ButtonDanger from '@/Components/ButtonDanger.vue'
import Pagination from '@/Components/Pagination.vue'
import Modal from '@/Components/Modal.vue'
import InputLabel from '@/Components/InputLabel.vue'
import InputText from '@/Components/InputText.vue'
import WardChip from '@/Components/WardChip.vue'
import TableNoData from '@/Components/TableNoData.vue'

import { PencilIcon } from '@heroicons/vue/24/solid'
import { SquaresPlusIcon } from '@heroicons/vue/24/solid'
import { TrashIcon } from '@heroicons/vue/24/solid'

import { Link, router } from '@inertiajs/vue3'
import debounce from 'lodash/debounce'

export default {

  layout: AuthLayout,

  components: {
    Link,
    PageTitle,
    ButtonPrimary,
    ButtonMuted,
    ButtonDanger,
    Pagination,
    Modal,
    InputText,
    InputLabel,
    WardChip,
    TableNoData,

    PencilIcon,
    TrashIcon,
    SquaresPlusIcon
  },

  props: {
    wards: Object,
    filters: Object,
  },

  data() {

    return {

      filterForm: {
        query: this.filters.query,
        sort_by: this.filters.sort_by ?? 'Date Created',
        direction: this.filters.direction ?? 'Ascending',
        size: this.filters.size ?? 10,
      },
    }
  },

  watch: {
    filterForm: {
      deep: true,
      handler: debounce(function () {
        this.handleFilter()
      }, 1000)
    }
  },

  methods: {

    handleAdmitWard(ward) {
      router.post(route('admissions.create'), {
        ward_id: ward.id
      })
    },

    handleFilter() {

      router.get(route('wards.index'), this.filterForm, {

        preserveState: true,
        preserveScroll: true,
        only: ['wards'],
      })
    },
  }
}
</script>

<style>
</style>