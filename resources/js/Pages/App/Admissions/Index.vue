<template>
  <div class="flex justify-between items-center">
    <PageTitle title="Admissions" />
    <Link :href="route('admissions.create')">
      <ButtonPrimary>Admit</ButtonPrimary>
    </Link>
  </div>

  <!-- Cards -->
  <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
    <Card :item="cards[0]" />
  </div>

  <div class="w-full overflow-hidden rounded-lg shadow-xs">
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
              {{ admission.ward }}
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
                <!-- <Link
                  :href="route('admissions.edit', { admission: admission.id })"
                >
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
                </Link> -->
                <button
                  v-if="!admission.discharged_at"
                  @click="setDischarge(admission)"
                  class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 rounded-lg focus:outline-none focus:shadow-outline-gray"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="w-5 h-5"
                  >
                    <path
                      d="M12 1.5a.75.75 0 0 1 .75.75V7.5h-1.5V2.25A.75.75 0 0 1 12 1.5ZM11.25 7.5v5.69l-1.72-1.72a.75.75 0 0 0-1.06 1.06l3 3a.75.75 0 0 0 1.06 0l3-3a.75.75 0 1 0-1.06-1.06l-1.72 1.72V7.5h3.75a3 3 0 0 1 3 3v9a3 3 0 0 1-3 3h-9a3 3 0 0 1-3-3v-9a3 3 0 0 1 3-3h3.75Z"
                    />
                  </svg>
                </button>
              </div>
            </td>
          </tr>
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

import { Link, useForm } from '@inertiajs/vue3'
import { displayName } from '@/Helpers/displayHelpers'
import notyf from '@/Utils/useNotyf'
import moment from 'moment'

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
    Modal
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
      })
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
    }
  }
}
</script>

<style>
</style>