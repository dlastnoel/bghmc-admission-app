<template>
  <main class="grid grid-cols-2 h-screen w-full">
    <!-- left login -->
    <div class="grid place-content-center w-full">
      <h1 class="text-4xl font-medium text-center">
        <span class="text-blue-600">Admission</span> App
      </h1>
      <div class="rounded-lg shadow border border-grey-50 p-8 mt-5 w-[450px]">
        <h5 class="text-xl font-medium">Welcome back!</h5>
        <p class="text-sm text-gray-400 mt-3">Login to access your account.</p>

        <Form @submit="handleSubmit">
          <div class="my-7">
            <label for="email" class="text-sm text-gray-700 font-medium">
              Email Address
            </label>
            <Field
              v-slot="{ field, errorMessage }"
              name="email"
              label="Email Address"
              rules="required|email"
              v-model="form.email"
            >
              <input
                v-bind="field"
                name="email"
                type="email"
                placeholder="user@bghmc.doh.gov.ph"
                class="mt-1 p-3 text-sm w-full rounded border text-grey-700"
                :class="errorMessage ? 'border-red-500' : 'border-gray-300'"
                :value="field.value"
              />
              <small class="mt-1 text-sm block text-red-500">
                {{ errorMessage }}
              </small>
            </Field>
          </div>
          <div class="mt-7">
            <label for="email" class="text-sm text-gray-700 font-medium">
              Password
            </label>
            <Field
              v-slot="{ field, errorMessage }"
              name="password"
              label="Password"
              rules="required"
              v-model="form.password"
            >
              <input
                v-bind="field"
                name="password"
                type="password"
                placeholder="********"
                class="mt-1 p-3 text-sm w-full rounded border text-grey-700"
                :class="errorMessage ? 'border-red-500' : 'border-gray-300'"
                v-model="field.value"
              />
              <small class="mt-1 text-sm block text-red-500">
                {{ errorMessage }}
              </small>
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
    <div class="grid place-content-center bg-gray-100 w-full">
      <img :src="svg" alt="Admission App" class="w-96" />
    </div>
  </main>
</template>

<script>
import { Field, Form } from 'vee-validate'

import notyf from '@/Utils/useNotyf'
import { useForm } from '@inertiajs/vue3'
import svg from '../../../images/login.svg'

export default {

  components: {
    Form,
    Field
  },

  data() {

    return {

      svg,

      form: useForm({
        email: 'johndoe@example.com',
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