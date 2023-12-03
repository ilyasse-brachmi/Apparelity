<script setup lang="ts">
import { useRouter } from 'vue-router'
import { useAuth } from '@/stores/auth.store'
import Swal from 'sweetalert2'
import { provide, ref } from 'vue';

const router = useRouter()
const store = useAuth()
const logout = () => {
  store.logout()
  Swal.fire({
      text: 'You are logged out !',
      icon: 'success',
      toast: true,
      position: 'top-end',
      timer: 2000,
      showConfirmButton: false,
      customClass: {
        container: 'my-swal'
      }
    })
    .then(() => router.push('/'))
}
const opened = ref(false)
const emit = defineEmits(['sidebarToggle'])
const toggleSidebarEvent = () => {
  opened.value = !opened.value
  emit('sidebarToggle', opened.value)
}
</script>
<template lang="pug">
header(class="flex items-center justify-between p-4 top-0 bg-gray-100 sticky shadow-md z-[99999]")
  .dz-navbar-start
    div(class="flex items-center")
      Icon(icon="mingcute:menu-fill" class="lg:hidden text-2xl cursor-pointer" @click="toggleSidebarEvent")
      a.dz-btn.dz-btn-ghost.text-xl(href='/') LOGO
  div(class="dz-navbar-center")
    div(v-if="!store.isAuth")
      a( href="/login" class="px-4 md:px-8 lg:px-14 py-2 text-white m-2 bg-primary rounded-sm hover:bg-primary/90  hover:shadow-md duration-300") Sign In
    div(v-else class="flex items-center justify-center text-white cursor-pointer font-medium px-4 md:px-8 lg:px-14 py-2 m-2 bg-primary rounded-sm hover:bg-primary/90  hover:shadow-md duration-300" @click="logout")
      a(href="/" class="mx-2") Logout
      Icon(icon="material-symbols:logout")
</template>