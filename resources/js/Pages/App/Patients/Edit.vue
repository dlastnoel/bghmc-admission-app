<template>
  <div class="flex justify-between items-center">
    <PageTitle title="Patients" />
  </div>

  <div class="space-y-10 divide-y divide-gray-900/10">
    <div class="grid grid-cols-1 gap-x-8 gap-y-8 pt-10 md:grid-cols-3">
      <div class="px-4 sm:px-0">
        <h2 class="text-base font-semibold leading-7 text-gray-900">
          Personal Information
        </h2>
        <p class="mt-1 text-sm leading-6 text-gray-600">
          This information will be displayed publicly so be careful what you
          share.
        </p>
      </div>

      <Form
        @submit="handleSubmit"
        class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2"
      >
        <div class="px-4 py-6 sm:p-8">
          <div class="grid w-full grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-3">
              <label
                for="firstname"
                class="block text-sm font-medium leading-6 text-gray-900"
              >
                First Name
              </label>
              <div class="mt-2">
                <Field
                  v-slot="{ field, errorMessage }"
                  name="firstname"
                  label="First Name"
                  rules="required"
                  v-model="form.firstname"
                >
                  <input
                    v-bind="field"
                    type="text"
                    name="firstname"
                    placeholder="First Name"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    :class="errorMessage ? 'ring-red-300' : ''"
                    :value="field.value"
                  />
                  <small class="ml-1 mt-1 text-sm text-left block text-red-500">
                    {{ errorMessage }}
                  </small>
                </Field>
              </div>
            </div>

            <div class="sm:col-span-3">
              <label
                for="middlename"
                class="block text-sm font-medium leading-6 text-gray-900"
              >
                Middle Name
              </label>
              <div class="mt-2">
                <Field
                  v-slot="{ field, errorMessage }"
                  name="middlename"
                  label="Middle Name"
                  v-model="form.middlename"
                >
                  <input
                    v-bind="field"
                    type="text"
                    name="middlename"
                    placeholder="Middle Name"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    :class="errorMessage ? 'ring-red-300' : ''"
                    :value="field.value"
                  />
                  <small class="ml-1 mt-1 text-sm text-left block text-red-500">
                    {{ errorMessage }}
                  </small>
                </Field>
              </div>
            </div>

            <div class="sm:col-span-3">
              <label
                for="lastname"
                class="block text-sm font-medium leading-6 text-gray-900"
              >
                Last Name
              </label>
              <div class="mt-2">
                <Field
                  v-slot="{ field, errorMessage }"
                  name="lastname"
                  label="Last Name"
                  rules="required"
                  v-model="form.lastname"
                >
                  <input
                    v-bind="field"
                    type="text"
                    name="lastname"
                    placeholder="Last Name"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    :class="errorMessage ? 'ring-red-300' : ''"
                    :value="field.value"
                  />
                  <small class="ml-1 mt-1 text-sm text-left block text-red-500">
                    {{ errorMessage }}
                  </small>
                </Field>
              </div>
            </div>

            <div class="sm:col-span-3">
              <label
                for="Suffix"
                class="block text-sm font-medium leading-6 text-gray-900"
              >
                Suffix
              </label>
              <div class="mt-2">
                <Field
                  v-slot="{ field, errorMessage }"
                  name="suffix"
                  label="Suffix"
                  v-model="form.suffix"
                >
                  <input
                    v-bind="field"
                    type="text"
                    name="suffix"
                    placeholder="Suffix"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    :class="errorMessage ? 'ring-red-300' : ''"
                    :value="field.value"
                  />
                  <small class="ml-1 mt-1 text-sm text-left block text-red-500">
                    {{ errorMessage }}
                  </small>
                </Field>
              </div>
            </div>

            <div class="sm:col-span-4">
              <label
                for="date_of_birth"
                class="block text-sm font-medium leading-6 text-gray-900"
                >Date of Birth</label
              >
              <div class="mt-2">
                <Field
                  v-slot="{ field, errorMessage }"
                  name="date_of_birth"
                  label="Date of Birth"
                  rules="required"
                  v-model="form.date_of_birth"
                >
                  <input
                    v-bind="field"
                    name="date_of_birth"
                    type="date"
                    :max="moment().format('YYYY-MM-DD')"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    :class="errorMessage ? 'ring-red-300' : ''"
                    :value="field.value"
                  />
                  <small class="ml-1 mt-1 text-sm text-left block text-red-500">
                    {{ errorMessage }}
                  </small>
                </Field>
              </div>
            </div>

            <div class="col-span-full">
              <label
                for="address"
                class="block text-sm font-medium leading-6 text-gray-900"
              >
                Address
              </label>
              <div class="mt-2">
                <Field
                  v-slot="{ field, errorMessage }"
                  name="address"
                  label="Address"
                  rules="required"
                  v-model="form.address"
                >
                  <input
                    v-bind="field"
                    type="text"
                    name="address"
                    placeholder="Address"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    :class="errorMessage ? 'ring-red-300' : ''"
                    :value="field.value"
                  />
                  <small class="ml-1 mt-1 text-sm text-left block text-red-500">
                    {{ errorMessage }}
                  </small>
                </Field>
              </div>
            </div>
          </div>
        </div>
        <div class="flex items-center justify-end gap-x-6 px-4 py-4 sm:px-8">
          <ButtonPrimary
            type="submit"
            name="Update"
            :disabled="form.processing"
          />
        </div>
      </Form>
    </div>
  </div>
</template>

<script>
import AuthLayout from '@/Layouts/AuthLayout.vue'
import PageTitle from '@/Components/PageTitle.vue'
import ButtonPrimary from '@/Components/ButtonPrimary.vue'

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
  },

  props: {
    errors: Object,
    patient: Object
  },

  data() {

    return {

      form: useForm({
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

      this.form.put(route('patients.update', { patient: this.patient.data.id }), {

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