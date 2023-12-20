<script setup lang="ts">
import { useRouter } from 'vue-router'
import { useAuth } from '@/stores/auth.store'
import Swal from 'sweetalert2'
import { ref } from 'vue';
import { useAppa } from '@/stores/index.store';

const appaStore = useAppa()

const router = useRouter()
const store = useAuth()
const logout = () => {
  appaStore.isLoading = true
  setTimeout(() => {
    store.logout()
    router.push('/')
    appaStore.isLoading = false
  }, 900);
  // Swal.fire({
  //     text: 'You are logged out !',
  //     icon: 'success',
  //     toast: true,
  //     position: 'top-end',
  //     timer: 2000,
  //     showConfirmButton: false,
  //     customClass: {
  //       container: 'my-swal'
  //     }
  //   })
}
const opened = ref(false)
const emit = defineEmits(['sidebarToggle'])
const toggleSidebarEvent = () => {
  opened.value = !opened.value
  emit('sidebarToggle', opened.value)
}
</script>
<template lang="pug">
header(class="flex items-center justify-between p-4 top-0 bg-gray-100 sticky shadow-md z-[999]")
  .dz-navbar-start
    div(class="flex items-center")
      Icon(icon="mingcute:menu-fill" class="lg:hidden text-2xl cursor-pointer" @click="toggleSidebarEvent")
      a.dz-btn.dz-btn-ghost.text-xl(href='/') LOGO
  div(class="dz-navbar-center")
    div(v-if="!store.isAuth")
      a( href="/login" class="px-4 md:px-8 lg:px-14 py-2 text-white m-2 bg-primary rounded-sm hover:bg-primary/90  hover:shadow-md duration-300") Sign In
    div(v-else class="dz-dropdown dz-dropdown-end")
      div(class="flex items-center justify-center")
        div()
          h1(class="font-semibold") {{ store.user.name }}
          p(class="text-sm text-gray-500") {{ store.user.email }}
        div(class="rounded-full border-2 border-gray-500 cursor-pointer mx-4" tabindex="0" )
          img(src="https://i.pravatar.cc/300" class="rounded-full w-12 h-12")
      ul.dz-dropdown-content.p-2.shadow-md.bg-gray-100.rounded-lg.w-64.mt-4(tabindex='0' class='z-[1]')
        li.p-3.text-gray-600(class="hover:font-medium hover:bg-primary/5 px-4 hover:scale-x-105 duration-200 cursor-pointer hover:text-primary")
          a Profile
        li.p-3.text-gray-600(class="hover:font-medium hover:bg-primary/5 px-4 hover:scale-x-105 duration-200 cursor-pointer hover:text-primary" @click="logout")
          a Logout
</template>