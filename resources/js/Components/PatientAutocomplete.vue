<template>
  <Combobox
    :modelValue="modelValue"
    @update:modelValue="(value) => $emit('update:modelValue', value)"
    by="id"
  >
    <div class="relative mt-1">
      <div
        class="relative w-full cursor-default overflow-hidden text-sm text-grey-700 rounded-md text-left sm:text-sm"
      >
        <ComboboxInput
          placeholder="Patient"
          class="w-full p-3 text-sm border border-gray-300 rounded-md shadow-sm"
          :displayValue="(patient) => (patient ? displayName(patient) : '')"
          @change="handleFilter"
        />
        <ComboboxButton
          class="absolute inset-y-0 right-0 flex patients-center pr-2"
        >
        </ComboboxButton>
      </div>
      <TransitionRoot
        leave="transition ease-in duration-100"
        leaveFrom="opacity-100"
        leaveTo="opacity-0"
        @after-leave="query = ''"
      >
        <ComboboxOptions
          class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none"
        >
          <div
            v-if="!patients.data.length && !query"
            class="relative cursor-default select-none px-4 py-2 text-gray-700"
          >
            Nothing found.
          </div>

          <ComboboxOption
            as="template"
            v-for="(patient, i) in patients.data"
            :key="i"
            :value="patient"
            v-slot="{ modelValue, active }"
          >
            <li
              class="relative cursor-default select-none py-2 pl-10 pr-4"
              :class="{
                'bg-blue-600 text-white': active,
                'text-gray-900': !active,
              }"
            >
              <span
                class="block truncate"
                :class="{
                  'font-medium': modelValue,
                  'font-normal': !modelValue,
                }"
              >
                {{ displayName(patient) }}
              </span>
              <span
                v-if="modelValue"
                class="absolute inset-y-0 left-0 flex patients-center pl-3"
                :class="{ 'text-white': active, 'text-blue-600': !active }"
              >
                <!-- <CheckIcon class="h-5 w-5" aria-hidden="true" /> -->
              </span>
            </li>
          </ComboboxOption>
        </ComboboxOptions>
      </TransitionRoot>
    </div>
  </Combobox>
</template>

<script>

import {
  Combobox,
  ComboboxInput,
  ComboboxButton,
  ComboboxOptions,
  ComboboxOption,
  TransitionRoot,
} from '@headlessui/vue'

import { router } from '@inertiajs/vue3'
import debounce from 'lodash/debounce'
import { displayName } from '@/Helpers/displayHelpers'


export default {

  components: {
    Combobox,
    ComboboxInput,
    ComboboxButton,
    ComboboxOptions,
    ComboboxOption,
    TransitionRoot,
  },

  props: {
    patients: {
      type: Object,
      required: true,
    },
    filterRoute: {
      type: String,
      required: true,
    },
    partials: {
      type: Array,
      default: ''
    },
    modelValue: {
      type: String,
      required: '',
    },
  },

  emits: ['update:modelValue'],

  data() {

    return {

      query: ''
    }
  },

  methods: {

    displayName,

    fireFilter: debounce(function() {
        router.post(this.filterRoute, {
        query: this.query
      }, {

        preserveState: true,
        preserveScroll: true,

        only: this.partials
      })
    }, 1000),

    handleFilter(e) {
      this.query = e.target.value
      
      this.fireFilter()
    },
  }
}  
</script>
