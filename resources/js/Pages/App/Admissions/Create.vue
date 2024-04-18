<template>
  <PageTitle title="Admissions" />

  <FormWrapper
    name="Admission"
    description="Only patients with no active admissions can be admitted."
  >
  </FormWrapper>
</template>

<script>
import AuthLayout from '@/Layouts/AuthLayout.vue'
import PageTitle from '@/Components/PageTitle.vue'
import FormWrapper from '@/Components/FormWrapper.vue'
import InputLabel from '@/Components/InputLabel.vue'
import InputText from '@/Components/InputText.vue'
import ErrorMessage from '@/Components/ErrorMessage.vue'

import { useForm } from '@inertiajs/vue3'
import { displayName } from '@/Helpers/displayHelpers'
import notyf from '@/Utils/useNotyf'

export default {

  layout: AuthLayout,

  components: {
    PageTitle,
    FormWrapper,
    InputLabel,
    InputText,
    ErrorMessage
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