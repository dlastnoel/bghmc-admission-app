<template>
  <div class="flex justify-between items-center">
    <PageTitle title="Admissions" />
    <Link :href="route('admissions.create')">
      <ButtonPrimary>Admit</ButtonPrimary>
    </Link>
  </div>

  <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
    <Card :item="cards[0]" />
  </div>

  <div
    class="w-full flex flex-col md:flex-row justify-between items-center gap-3"
  >
    <div
      class="flex w-full md:w-auto flex-col md:flex-row justify-end items-center relative gap-3"
    >
      <div class="w-full md:w-auto">
        <InputText
          v-model="filterForm.patient"
          placeholder="Patient"
          class="border-gray-300 w-full md:w-auto"
        ></InputText>
      </div>
      <div class="w-full md:w-auto">
        <InputText
          v-model="filterForm.ward"
          placeholder="Ward"
          class="border-gray-300 w-full md:w-auto"
        ></InputText>
      </div>
    </div>
    <div
      class="flex w-full md:w-auto flex-col md:flex-row justify-end items-center relative gap-3"
    >
      <select
        v-model="filterForm.status"
        class="rounded-md border-gray-300 py-3 text-sm w-full md:w-auto"
      >
        <option value="All">All</option>
        <option value="Admitted">Admitted</option>
        <option value="Discharged">Discharged</option>
      </select>
      <select
        v-model="filterForm.direction"
        class="rounded-md border-gray-300 py-3 text-sm w-full md:w-auto"
      >
        <option value="Latest">Latest</option>
        <option value="Oldest">Oldest</option>
      </select>
      <select
        v-model="filterForm.size"
        class="rounded-md border-gray-300 py-3 text-sm w-full md:w-auto"
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
            <th class="px-4 py-3">Ward</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Admitted at</th>
            <th class="px-4 py-3">Discharged at</th>
            <th class="px-4 py-3"></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y">
          <template v-if="admissions.data.length">
            <tr
              class="text-gray-700"
              v-for="(admission, i) in admissions.data"
              :key="i"
            >
              <td class="px-4 py-3">
                <div>
                  <p class="font-semibold">
                    {{ displayName(admission.patient) }}
                  </p>
                  <p class="text-xs text-gray-600">
                    {{ admission.patient.age }} yrs old
                  </p>
                </div>
              </td>
              <td class="px-4 py-3 text-sm">
                {{ admission.ward.name }}
              </td>
              <td class="px-4 py-3">
                <AdmissionStatusChip :admission="admission" />
              </td>
              <td class="px-4 py-3 text-sm">
                {{
                  moment(admission.admitted_at).format("YYYY-MM-DD hh:mm:ss A")
                }}
              </td>
              <td class="px-4 py-3 text-sm">
                {{
                  admission.discharged_at
                    ? moment(admission.discharged_at).format(
                        "YYYY-MM-DD hh:mm:ss A"
                      )
                    : "N/A"
                }}
              </td>
              <td class="px-4 py-3">
                <div class="flex items-center space-x-4 text-sm">
                  <button
                    v-if="!admission.discharged_at"
                    @click="setDischarge(admission)"
                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-pink-700 rounded-lg focus:outline-none focus:shadow-outline-gray"
                  >
                    <ArchiveBoxXMarkIcon class="w-5 h-5" />
                  </button>
                </div>
              </td>
            </tr>
          </template>
          <TableNoData :colspan="6" class="px-4 py-3" v-else />
        </tbody>
      </table>
    </div>
    <Pagination :meta="admissions.meta" :partials="['admissions']" />
  </div>

  <Modal
    v-if="isDischargeModalVisible"
    title="Discharge admission"
    :text="`Are you sure you want to discharge the admission of ${
      selectedAdmission ? displayName(selectedAdmission.patient) : ''
    }?`"
  >
    <template #footer>
      <ButtonDanger @click="handleDischarge()">Discharge</ButtonDanger>
      <ButtonMuted @click="resetDischarge()">Cancel</ButtonMuted>
    </template>
  </Modal>
</template>

<script>
import AuthLayout from '@/Layouts/AuthLayout.vue'
import PageTitle from '@/Components/PageTitle.vue'
import ButtonPrimary from '@/Components/ButtonPrimary.vue'
import ButtonDanger from '@/Components/ButtonDanger.vue'
import ButtonMuted from '@/Components/ButtonMuted.vue'
import Card from '@/Components/Card.vue'
import Pagination from '@/Components/Pagination.vue'
import AdmissionStatusChip from '@/Components/AdmissionStatusChip.vue'
import Modal from '@/Components/Modal.vue'
import InputText from '@/Components/InputText.vue'
import TableNoData from '@/Components/TableNoData.vue'

import { ArchiveBoxXMarkIcon } from '@heroicons/vue/24/solid'

import { Link, useForm, router } from '@inertiajs/vue3'
import { displayName } from '@/Helpers/displayHelpers'
import notyf from '@/Utils/useNotyf'
import moment from 'moment'
import debounce from 'lodash/debounce'

export default {

  layout: AuthLayout,

  components: {
    Link,
    PageTitle,
    ButtonPrimary,
    ButtonDanger,
    ButtonMuted,
    Pagination,
    Card,
    AdmissionStatusChip,
    Modal,
    InputText,
    TableNoData,

    ArchiveBoxXMarkIcon
  },

  props: {
    admissions: Object,
    filters: Object,
    admissions_today: Number,
  },

  data() {

    return {

      cards: [
        {
          title: 'Admissions Today',
          value: this.admissions_today,
          svg: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" /></svg>'
        }
      ],

      isDischargeModalVisible: false,
      selectedAdmission: {},
      dischargeForm: useForm({
        id: ''
      }),

      filterForm: {
        patient: this.filters.patient,
        ward: this.filters.ward,
        status: this.filters.status ?? 'All',
        direction: this.filters.direction ?? 'Latest',
        size: this.filters.size ?? 10
      }
    }
  },
  
  watch: {

    filterForm: {
      deep: true,
      handler: debounce(function() {
        this.handleFilter()
      }, 1000)
    }
  },

  methods: {

    displayName,
    moment,

    setDischarge(admission) {
      this.selectedAdmission = admission
      this.dischargeForm.id = admission.id
      this.isDischargeModalVisible = true
    },

    resetDischarge() {
      this.selectedAdmission = {}
      this.dischargeForm.id = ''
      this.isDischargeModalVisible = false
    },

    handleDischarge() {

      this.dischargeForm.post(route('discharge-admissions.store'), {

        preserveState: true,
        preserveScroll: true,
        only: ['admissions'],

        onSuccess: () => {
          notyf.toast(`Admission of ${displayName(this.selectedAdmission.patient)} discharged successfully.`)
          this.resetDischarge()
        }
      })
    },

    handleFilter() {

      router.get(route('admissions.index'), this.filterForm , {
        
        preserveState: true,
        preserveScroll: true,
        only: ['admissions']
      })
    }
  }
}
</script>

<style>
</style>