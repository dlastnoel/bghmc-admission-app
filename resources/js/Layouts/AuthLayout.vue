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
import { isRouteActive } from '@/Utils/routeUtils'
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

  computed: {
    
    sidebarLinks() {
      return [
        {
          title: 'Patients',
          route: 'patients.index',
          svg: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /> </svg>',
          active: 'patients.*'
        },
        {
          title: 'Admissions',
          route: 'admissions.index',
          svg: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" /></svg>',
          active: 'admissions.*'
        }
      ]
    }
  },

  methods: {

    isRouteActive,

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