<template>
  <PageTitle title="Admissions" />

  <FormWrapper
    name="Admission"
    description="Only patients with no active admissions can be admitted."
  >
    <Form @submit="handleSubmit">
      <FormBody>
        <div class="grid w-full grid-cols-12 gap-x-6 gap-y-8">
          <!--  -->
          <div class="col-span-12">
            <InputLabel label="patient_id">Patient</InputLabel>
            <Field
              v-slot="{ field, errorMessage }"
              name="patient_id"
              label="Patient"
              rules="required"
              v-model="form.patient_id"
            >
              <PatientAutocomplete
                v-bind="field"
                :modelValue="field.value"
                :patients="patients"
                :filterRoute="route('admissions.create')"
                :class="errorMessage ? 'border-red-500' : 'border-gray-300'"
                :partials="['patients']"
              />
              <ErrorMessage :message="errorMessage" />
            </Field>
          </div>

          <!--  -->
          <div class="col-span-12">
            <InputLabel for="ward">Ward</InputLabel>
            <Field
              v-slot="{ field, errorMessage }"
              name="ward"
              label="Ward"
              rules="required"
              v-model="form.ward"
            >
              <InputText
                v-bind="field"
                placeholder="Ward"
                class="w-full"
                :class="errorMessage ? 'border-red-500' : 'border-gray-300'"
                :modelValue="field.value"
              >
              </InputText>
              <ErrorMessage :message="errorMessage" />
            </Field>
          </div>
        </div>
      </FormBody>
      <FormFooter>
        <ButtonPrimary type="submit" :disabled="form.processing">
          Admit
        </ButtonPrimary>
      </FormFooter>
    </Form>
  </FormWrapper>
</template>

<script>
import AuthLayout from '@/Layouts/AuthLayout.vue'
import PageTitle from '@/Components/PageTitle.vue'
import FormWrapper from '@/Components/FormWrapper.vue'
import FormBody from '@/Components/FormBody.vue'
import FormFooter from '@/Components/FormFooter.vue'
import InputLabel from '@/Components/InputLabel.vue'
import InputText from '@/Components/InputText.vue'
import ErrorMessage from '@/Components/ErrorMessage.vue'
import PatientAutocomplete from '@/Components/PatientAutocomplete.vue'
import ButtonPrimary from '@/Components/ButtonPrimary.vue'

import { useForm } from '@inertiajs/vue3'
import { Form, Field } from 'vee-validate'
import { displayName } from '@/Helpers/displayHelpers'
import notyf from '@/Utils/useNotyf'

export default {

  layout: AuthLayout,

  components: {
    Form,
    Field,
    PageTitle,
    FormWrapper,
    FormBody,
    FormFooter,
    InputLabel,
    InputText,
    ErrorMessage,
    PatientAutocomplete,
    ButtonPrimary
  },

  props: {
    patients: Object,
  },

  data() {

    return {

      form: useForm({
        patient_id: this.patients.data.length ? this.patients.data[0] : '',
        ward: ''
      }),
    }
  },

  methods: {
    
    displayName,

    handleSubmit(values, actions) {

      this.form.transform((data) => ({
        patient_id: data.patient_id.id,
        ward: data.ward
      })).post(route('admissions.store'), {

        preserveState: true,
        preserveScroll: true,

        only: ['patients'],

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