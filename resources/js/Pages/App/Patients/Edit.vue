<template>
  <div class="flex justify-between items-center">
    <PageTitle title="Patients" />
  </div>

  <FormWrapper
    name="Patient Information"
    description="This information will be displayed publicly so be careful what you
          share."
  >
    <Form @submit="handleSubmit">
      <FormBody>
        <div class="grid w-full grid-cols-12 gap-x-6 gap-y-8">
          <div class="col-span-12 md:col-span-6">
            <InputLabel label="firstname">First Name</InputLabel>
            <div class="mt-2">
              <Field
                v-slot="{ field, errorMessage }"
                name="firstname"
                label="First Name"
                rules="required"
                v-model="form.firstname"
              >
                <InputText
                  v-bind="field"
                  type="text"
                  name="firstname"
                  placeholder="First Name"
                  class="w-full"
                  :class="errorMessage ? 'border-red-500' : 'border-gray-300'"
                  :modelValue="field.value"
                />
                <ErrorMessage :message="errorMessage" />
              </Field>
            </div>
          </div>

          <div class="col-span-12 md:col-span-6">
            <InputLabel label="middlename">Middle Name</InputLabel>
            <div class="mt-2">
              <Field
                v-slot="{ field, errorMessage }"
                name="middlename"
                label="Middle Name"
                v-model="form.middlename"
              >
                <InputText
                  v-bind="field"
                  type="text"
                  name="middlename"
                  placeholder="Middle Name"
                  class="w-full"
                  :class="errorMessage ? 'border-red-500' : 'border-gray-300'"
                  :modelValue="field.value"
                />
                <ErrorMessage :message="errorMessage" />
              </Field>
            </div>
          </div>

          <div class="col-span-12 md:col-span-6">
            <InputLabel label="lastname">Last Name</InputLabel>
            <div class="mt-2">
              <Field
                v-slot="{ field, errorMessage }"
                name="lastname"
                label="Last Name"
                rules="required"
                v-model="form.lastname"
              >
                <InputText
                  v-bind="field"
                  type="text"
                  name="lastname"
                  placeholder="Last Name"
                  class="w-full"
                  :class="errorMessage ? 'border-red-500' : 'border-gray-300'"
                  :modelValue="field.value"
                />
                <ErrorMessage :message="errorMessage" />
              </Field>
            </div>
          </div>

          <div class="col-span-12 md:col-span-6">
            <InputLabel label="suffix">Suffix</InputLabel>
            <div class="mt-2">
              <Field
                v-slot="{ field, errorMessage }"
                name="suffix"
                label="Suffix"
                v-model="form.suffix"
              >
                <InputText
                  v-bind="field"
                  type="text"
                  name="suffix"
                  placeholder="Suffix"
                  class="w-full"
                  :class="errorMessage ? 'border-red-500' : 'border-gray-300'"
                  :modelValue="field.value"
                />
                <ErrorMessage :message="errorMessage" />
              </Field>
            </div>
          </div>

          <div class="col-span-12">
            <InputLabel label="date_of_birth">Date of Birth</InputLabel>
            <div class="mt-2">
              <Field
                v-slot="{ field, errorMessage }"
                name="date_of_birth"
                label="Date of Birth"
                rules="required"
                v-model="form.date_of_birth"
              >
                <InputText
                  v-bind="field"
                  name="date_of_birth"
                  type="date"
                  :max="moment().format('YYYY-MM-DD')"
                  class="w-full"
                  :class="errorMessage ? 'border-red-500' : 'border-gray-300'"
                  :modelValue="field.value"
                />
                <ErrorMessage :message="errorMessage" />
              </Field>
            </div>
          </div>

          <div class="col-span-12">
            <InputLabel label="address">Address</InputLabel>
            <div class="mt-2">
              <Field
                v-slot="{ field, errorMessage }"
                name="address"
                label="Address"
                rules="required"
                v-model="form.address"
              >
                <InputText
                  v-bind="field"
                  type="text"
                  name="address"
                  placeholder="Address"
                  class="w-full"
                  :class="errorMessage ? 'border-red-500' : 'border-gray-300'"
                  :modelValue="field.value"
                />
                <ErrorMessage :message="errorMessage" />
              </Field>
            </div>
          </div>
        </div>
      </FormBody>
      <FormFooter>
        <ButtonPrimary type="submit" :disabled="form.processing">
          Update
        </ButtonPrimary>
      </FormFooter>
    </Form>
  </FormWrapper>
</template>

<script>
import AuthLayout from '@/Layouts/AuthLayout.vue'
import PageTitle from '@/Components/PageTitle.vue'
import ButtonPrimary from '@/Components/ButtonPrimary.vue'
import FormWrapper from '@/Components/FormWrapper.vue'
import FormBody from '@/Components/FormBody.vue'
import FormFooter from '@/Components/FormFooter.vue'
import InputLabel from '@/Components/InputLabel.vue'
import InputText from '@/Components/InputText.vue'
import ErrorMessage from '@/Components/ErrorMessage.vue'

import { useForm } from '@inertiajs/vue3'
import { Field, Form } from 'vee-validate'
import moment from 'moment'
import notyf from '@/Utils/useNotyf'

export default {

  layout: AuthLayout,

  components: {
    Form,
    Field,
    PageTitle,
    ButtonPrimary,
    FormWrapper,
    FormBody,
    FormFooter,
    InputLabel,
    InputText,
    ErrorMessage
  },

  props: {
    errors: Object,
    patient: Object
  },

  data() {

    return {

      form: useForm({
        id: this.patient.data.id,
        firstname: this.patient.data.firstname,
        middlename: this.patient.data.middlename,
        lastname: this.patient.data.lastname,
        suffix: this.patient.data.suffix,
        date_of_birth: this.patient.data.date_of_birth,
        address: this.patient.data.address,
      })
    }
  },

  methods: {

    moment,

    handleSubmit(values, actions) {

      this.form.put(route('patients.update', { patient: this.form.id }), {

        preserveState: true,
        preserveScroll: true,

        onError: (errors) => {
          actions.setErrors(errors)
          notyf.toast('Something went wrong.', 'error')
        },

        onSuccess: () => {
          notyf.toast('Patient successfully updated.')
        }
      })
    }
  }
}
</script>

<style>
</style>