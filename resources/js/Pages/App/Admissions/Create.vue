<template>
  <PageTitle title="Admissions" />
</template>

<script>
import AuthLayout from '@/Layouts/AuthLayout.vue'
import PageTitle from '@/Components/PageTitle.vue'

import { useForm } from '@inertiajs/vue3'
import { displayName } from '@/Helpers/displayHelpers'
import notyf from '@/Utils/useNotyf'

export default {

  layout: AuthLayout,

  components: {
    PageTitle,
  },

  props: {
    patients: Object,
  },

  data() {

    return {

      form: useForm({
        patient_id: '',
        ward: ''
      }),

      selectedFilters: {
        patient: this.patients.length ? this.patients.length[0] : ''
      },

      patientFilterForm: useForm({
        patient: ''
      }),
    }
  },

  methods: {
    displayName,

    handleSubmit(values, actions) {

      this.form.post(route('admissions.create'), {

        preserveState: true,
        preserveScroll: true,

        onError: (errors) => {
          actions.serErrors(errors)
        },

        onSuccess: () => {
          notyf.toast('Patient successfully admitted.')
        }
      })
    }
  }
}
</script>

<style>
</style>