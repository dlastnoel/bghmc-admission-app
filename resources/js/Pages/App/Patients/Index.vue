<template>
  <div class="flex justify-between items-center">
    <PageTitle title="Patients" />
    <Link :href="route('patients.create')">
      <ButtonPrimary>Create</ButtonPrimary>
    </Link>
  </div>

  <div class="w-full flex justify-between items-center">
    <div>
      <InputText
        v-model="filterForm.query"
        placeholder="Search"
        class="border-gray-300"
      ></InputText>
    </div>
    <div class="flex justify-end items-center relative gap-3">
      <select
        v-model="filterForm.sort_by"
        class="rounded-md border-gray-300 py-3 text-sm"
      >
        <option value="Date Created">Date Created</option>
        <option value="Name">Name</option>
      </select>
      <select
        v-model="filterForm.direction"
        class="rounded-md border-gray-300 py-3 text-sm"
      >
        <option value="Ascending">Ascending</option>
        <option value="Descending">Descending</option>
      </select>
      <select
        v-model="filterForm.size"
        class="rounded-md border-gray-300 py-3 text-sm"
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
            <th class="px-4 py-3">Patient</th>
            <th class="px-4 py-3">Date of Birth</th>
            <th class="px-4 py-3">Address</th>
            <th class="px-4 py-3"></th>
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
            <td class="py-3">
              <button
                @click="handleAdmitPatient(patient)"
                v-if="!patient.admission_count"
                class="flex items-center justify-between px-2 py-2 text-sm leading-5 text-green-700 rounded-lg focus:outline-none focus:shadow-outline-gray"
              >
                <UserPlusIcon class="w-5 h-5" />
              </button>
            </td>
            <td class="px-4 py-3">
              <div class="flex justify-center items-center text-sm gap-2">
                <Link :href="route('patients.edit', { patient: patient.id })">
                  <button
                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-600 rounded-lg focus:outline-none focus:shadow-outline-gray"
                  >
                    <PencilIcon class="w-5 h-5" />
                  </button>
                </Link>
                <button
                  @click="setDelete(patient)"
                  class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-400 rounded-lg focus:outline-none focus:shadow-outline-gray"
                  aria-label="Delete"
                >
                  <TrashIcon class="w-5 h-5" />
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <Pagination :meta="patients.meta" :partials="['patients']" />
  </div>

  <Modal
    v-if="isDeleteModalVisible"
    title="Delete Patient"
    :text="`Are you sure you want to delete patient ${
      selectedPatient ? displayName(selectedPatient) : ''
    }?`"
  >
    <template #footer>
      <ButtonDanger @click="handleDelete()">Delete</ButtonDanger>
      <ButtonMuted @click="resetDelete()">Cancel</ButtonMuted>
    </template>
  </Modal>
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

import { PencilIcon } from '@heroicons/vue/24/solid'
import { UserPlusIcon } from '@heroicons/vue/24/solid'
import { TrashIcon } from '@heroicons/vue/24/solid'

import { Link, router } from '@inertiajs/vue3'
import moment from 'moment'
import debounce from 'lodash/debounce'
import { displayName } from '@/Helpers/displayHelpers'
import notyf from '@/Utils/useNotyf'

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

    PencilIcon,
    TrashIcon,
    UserPlusIcon
  },

  props: {
    patients: Object,
    filters: Object,
  },

  data() {

    return {
      
      isDeleteModalVisible: false,
      selectedPatient: {},

      filterForm: {
        query: this.filters.query,
        sort_by: this.filters.sort_by ?? 'Date Created',
        direction: this.filters.direction ?? 'Descending',
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

    displayName,
    moment,

    setDelete(patient) {
      this.selectedPatient = patient
      this.isDeleteModalVisible = true
    },

    resetDelete() {
      this.selectedPatient = {}
      this.isDeleteModalVisible = false
    },

    handleAdmitPatient(patient) {
      router.post(route('admissions.create'), {
        patient_id: patient.id
      })
    },

    handleDelete() {
      router.delete(route('patients.destroy', { patient: this.selectedPatient.id }), {

        preserveState: true,
        preserveScroll: true,
        only: ['patients'],

        onSuccess: () => {
          notyf.toast(`Patient ${displayName(this.selectedPatient)} successfully deleted.`)
          this.resetDelete()
        }
      })
    },

    handleFilter() {

      router.get(route('patients.index'), this.filterForm, {

        preserveState: true,
        preserveScroll: true,
        only: ['patients'],
      })
    },
  }
}
</script>

<style>
</style>