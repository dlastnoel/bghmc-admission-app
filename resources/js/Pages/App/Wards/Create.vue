<template>
  <!-- page info -->
  <PageTitle title="Wards" />

  <FormWrapper name="Ward" description="Name a ward and input capacity.">
    <Form @submit="handleSubmit">
      <FormBody>
        <div class="grid w-full grid-cols-12 gap-x-6 gap-y-8">
          <!--  -->
          <div class="col-span-12">
            <InputLabel label="name">Ward</InputLabel>
            <div class="mt-2">
              <Field
                v-slot="{ field, errorMessage }"
                name="name"
                label="Ward"
                rules="required"
                v-model="form.name"
              >
                <InputText
                  v-bind="field"
                  type="text"
                  name="name"
                  placeholder="Ward"
                  class="w-full"
                  :class="errorMessage ? 'border-red-500' : 'border-gray-300'"
                  :modelValue="field.value"
                />
                <ErrorMessage :message="errorMessage" />
              </Field>
            </div>
          </div>

          <!--  -->
          <div class="col-span-12">
            <InputLabel label="description">Description</InputLabel>
            <div class="mt-2">
              <Field
                v-slot="{ field, errorMessage }"
                name="description"
                label="Description"
                v-model="form.description"
              >
                <InputText
                  v-bind="field"
                  type="text"
                  name="description"
                  placeholder="Description"
                  class="w-full"
                  :class="errorMessage ? 'border-red-500' : 'border-gray-300'"
                  :modelValue="field.value"
                />
                <ErrorMessage :message="errorMessage" />
              </Field>
            </div>
          </div>

          <!--  -->
          <div class="col-span-12">
            <InputLabel label="capacity">Capacity</InputLabel>
            <div class="mt-2">
              <Field
                v-slot="{ field, errorMessage }"
                name="capacity"
                label="Capacity"
                rules="required|numeric"
                v-model="form.capacity"
              >
                <InputText
                  v-bind="field"
                  type="text"
                  name="capacity"
                  placeholder="Capacity"
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
          Create
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
    errors: Object
  },

  data() {

    return {

      form: useForm({
        name: '',
        capacity: '',
        description: '',
      })
    }
  },

  methods: {

    handleSubmit(values, actions) {

      this.form.post(route('wards.store'), {

        preserveState: true,
        preserveScroll: true,

        onError: (errors) => {
          actions.setErrors(errors)
          notyf.toast('Something went wrong.', 'error')
        },

        onSuccess: () => {
          notyf.toast('Patient successfully created.')
        }
      })
    }
  }
}
</script>

<style>
</style>