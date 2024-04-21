<template>
  <div
    class="flex h-screen bg-gray-50"
    :class="{ 'overflow-hidden': isSideMenuOpen }"
  >
    <SidebarDesktop :sidebarLinks="sidebarLinks" />

    <SidebarMobile
      :sidebarLinks="sidebarLinks"
      v-if="isSidebarForMobileVisible"
    />

    <div class="flex flex-col flex-1 w-full">
      <header class="z-10 py-4 bg-white shadow">
        <div
          class="container flex items-center justify-between h-full px-3 mx-auto text-blue-400"
        >
          <button
            @click="isSidebarForMobileVisible = !isSidebarForMobileVisible"
            class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple"
            aria-label="Menu"
          >
            <Bars3Icon class="w-6 h-6" />
          </button>
          <div class="flex justify-center flex-1 lg:mr-32">
            <div
              class="relative w-full max-w-xl mr-6 focus-within:text-purple-500"
            ></div>
          </div>
          <ul class="flex items-center flex-shrink-0 space-x-6">
            <li class="flex justify-center items-center gap-2">
              <span class="text-sm text-gray-800 font-medium">
                {{ $page.props.auth.user.name }}
              </span>
              <button
                @click="handleLogout()"
                class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none"
              >
                <ArrowRightEndOnRectangleIcon class="w-5 h-5 text-gray-800" />
              </button>
            </li>
          </ul>
        </div>
      </header>

      <!-- MAIN -->
      <main class="h-full overflow-y-auto pb-10">
        <div class="container px-6 mx-auto grid">
          <slot />
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import SidebarMobile from '@/Components/SidebarMobile.vue'
import SidebarDesktop from '@/Components/SidebarDesktop.vue'

import { ArrowRightEndOnRectangleIcon, Bars3Icon } from '@heroicons/vue/24/solid'

import { Link, router } from '@inertiajs/vue3'
import notyf from '@/Utils/useNotyf'

export default {

  components: {
    Link,
    SidebarMobile,
    SidebarDesktop,

    ArrowRightEndOnRectangleIcon,
    Bars3Icon
  },

  data() {

    return {

      isSidebarForMobileVisible: false,
    }
  },

  methods: {

    handleLogout() {
      router.delete(route('auth.destroy'), {

        onSuccess: () => {
          notyf.toast('Logout successful.')
        }
      })
    }
  }
}
</script>

<style>
</style>