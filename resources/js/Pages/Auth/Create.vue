<template>
  <main class="grid grid-cols-1 lg:grid-cols-2 h-screen w-full">
    <!-- left login -->
    <div class="grid place-content-center w-full">
      <!-- image for mobile -->
      <img
        :src="svg"
        alt="Admission App"
        class="lg:hidden w-72 md:w-96 mb-5 m-auto"
      />

      <!-- title -->
      <h1 class="text-4xl font-medium text-center">
        <span class="text-blue-600">Admission</span> App
      </h1>

      <!-- card login -->
      <div
        class="rounded-lg shadow border border-grey-50 p-8 mt-5 w-[400px] md:w-[450px]"
      >
        <h5 class="text-xl font-medium">Welcome back!</h5>
        <p class="text-sm text-gray-400 mt-3">Login to access your account.</p>
        <Form @submit="handleSubmit">
          <div class="my-7">
            <InputLabel :label="email">Email Address</InputLabel>
            <Field
              v-slot="{ field, errorMessage }"
              name="email"
              label="Email Address"
              rules="required|email"
              v-model="form.email"
            >
              <InputText
                v-bind="field"
                name="email"
                type="email"
                placeholder="user@bghmc.doh.gov.ph"
                class="w-full"
                :class="errorMessage ? 'border-red-500' : 'border-gray-300'"
                :modelValue="field.value"
              />
              <ErrorMessage :message="errorMessage" />
            </Field>
          </div>
          <div class="mt-7 relative">
            <InputLabel :label="password">Password</InputLabel>
            <Field
              v-slot="{ field, errorMessage }"
              name="password"
              label="Password"
              rules="required"
              v-model="form.password"
            >
              <InputText
                v-bind="field"
                name="password"
                :type="isPasswordVisible ? 'text' : 'password'"
                placeholder="********"
                class="w-full"
                :class="errorMessage ? 'border-red-500' : 'border-gray-300'"
                :modelValue="field.value"
              />
              <button
                @click.prevent="isPasswordVisible = !isPasswordVisible"
                class="absolute top-11 right-4 hover:cursor-pointer"
              >
                <EyeIcon v-if="isPasswordVisible" class="w-5 h-5 text-black" />
                <EyeSlashIcon v-else class="w-5 h-5 text-black" />
              </button>
              <ErrorMessage :message="errorMessage" />
            </Field>
          </div>
          <div class="mt-7">
            <button
              :disabled="form.processing"
              type="submit"
              class="w-full font-medium text-white bg-blue-600 p-2 rounded border-none disabled:brightness-150"
            >
              Login
            </button>
          </div>
        </Form>
      </div>
    </div>

    <!-- right image -->
    <div class="hidden lg:grid place-content-center bg-gray-100 w-full">
      <img :src="svg" alt="Admission App" class="w-96" />
    </div>
  </main>
</template>

<script>
import { Field, Form } from 'vee-validate'
import InputText from '@/Components/InputText.vue'
import InputLabel from '@/Components/InputLabel.vue'
import ErrorMessage from '@/Components/ErrorMessage.vue'

import { EyeIcon, EyeSlashIcon } from  '@heroicons/vue/24/solid'

import notyf from '@/Utils/useNotyf'
import { useForm } from '@inertiajs/vue3'
import svg from '../../../images/app.svg'

export default {

  components: {
    Form,
    Field,
    InputText,
    InputLabel,
    ErrorMessage,

    EyeIcon,
    EyeSlashIcon
  },

  data() {

    return {

      svg,

      form: useForm({
        email: 'useradmin@example.com',
        password: 'password'
      }),

      isPasswordVisible: false,
    }
  },

  methods: {

    handleSubmit() {

      this.form.post(route('auth.store'), {

        preserveState: true,
        preserveScroll: true,

        onError: (errors) => {
          for(const i in errors){
            notyf.toast(errors[i], 'error')
          }
        },

        onSuccess: () => {
          notyf.toast('Welcome!')
        }
      })
    }
  }
}
</script>

<style>
</style>