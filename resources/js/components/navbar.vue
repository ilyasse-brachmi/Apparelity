<script setup lang="ts">
import { useRouter, useRoute } from 'vue-router'
import { useAuth } from '@/stores/auth.store'
import Swal from 'sweetalert2'
import AppModal from '@/components/AppModal.vue'
import { ref, watch } from 'vue'
import { useAppa } from '@/stores/index.store'
import { $AppAxios } from '@/utils/axiosSingleton'
import type { Company } from '@/types'
import _ from 'lodash';
import { removeProperties } from '@/composables/useFiltredObject'


const appaStore = useAppa()

const router = useRouter()
const route = useRoute()
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
const modal = ref(false)
const data = ref({} as Company)
const openModal = async() => {
  $AppAxios.get(`/api/company/${store.company.id}`)
	.then((response) => {
		data.value = response.data
	})
	modal.value = true
}

const submitEdit = () => {
  Swal.fire({
  title: "Do you want to save the changes?",
  showCancelButton: true,
  confirmButtonText: "Yes",
}).then(async(result) => {
  if (result.isConfirmed) {
    const result = removeProperties(data.value, ['created_at', 'deleted_at', 'updated_at', 'user_id'])
    await $AppAxios.put('/api/company', result)
    .then(() => {
      modal.value = false
      Swal.fire("Saved!", "", "success");
    })
    .catch((e) => {
      const errorMessages = Object.keys(e.response.data.errors).reduce((acc, key) => {
        acc[key] = e.response.data.errors[key][0];
        return acc[key];
      }, {})
      Swal.fire("Ooops!", errorMessages as string, "error");
    })
  }
});
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
      a( href="/login" class="px-4 md:px-8 lg:px-14 py-2 text-white m-2 bg-primary rounded-md hover:bg-primary/90  hover:shadow-md duration-300") Sign In
    div(v-else class="dz-dropdown dz-dropdown-end")
      div(class="flex items-center justify-center")
        div()
          h1(class="font-semibold") {{ store.user.name }}
          p(class="text-sm text-gray-500") {{ store.user.email }}
        div(class="rounded-full relative border-2 border-gray-500 cursor-pointer mx-4" tabindex="0" )
          div(class="absolute right-0 top-0 bg-green-500 w-3 h-3 rounded-full")
          img(src="https://i.pravatar.cc/300" class="rounded-full w-12 h-12")
      ul.dz-dropdown-content.p-2.shadow-md.bg-gray-100.rounded-lg.w-64.mt-4(tabindex='0' class='z-[1]')
        li.p-3.text-gray-600(class="hover:font-medium hover:bg-primary/5 px-4 hover:scale-x-105 duration-200 cursor-pointer hover:text-primary" @click="openModal")
          a Profile
        li.p-3.text-gray-600(v-if="route.path!=='/dashboard'" class="hover:font-medium hover:bg-primary/5 px-4 hover:scale-x-105 duration-200 cursor-pointer hover:text-primary" @click="logout")
          a(href="/dashboard") My Dashboard
        li.p-3.text-gray-600(class="hover:font-medium hover:bg-primary/5 px-4 hover:scale-x-105 duration-200 cursor-pointer hover:text-primary" @click="logout")
          a Logout
      AppModal(v-if="modal" :title="'Profile Details'" @close="modal = false")
        div(class="flex flex-col justify-center px-24 gap-y-10 w-full h-fit")
          div(class="flex justify-center")
            div(class="w-full h-full bg-white shadow-md rounded-xl border-4 my-4 border-primar py-8")
              h1(class="text-primary font-semibold text-xl text-center mb-8") Company Owner :
              div(class="grid grid-cols-2 gap-y-2 mx-8 text-lg pl-8")
                label.font-semibold Name :
                p {{ store.user.name }}
                label.font-semibold E-mail :
                p {{ store.user.email }}
          div(class="flex justify-center")
            div(class="w-full h-full bg-white shadow-md rounded-xl border-4 my-4 border-primar py-8")
              h1(class="text-primary font-semibold text-xl text-center mb-8") Company Details :
              div(class="grid grid-cols-2 gap-y-2 mx-8 text-lg pl-8")
                label.font-semibold Name :
                input(type="text" v-model="data.name" placeholder="Name" class="p-4 border border-gray-400 rounded-lg ")
                label.font-semibold Address :
                input(type="text" v-model="data.address" placeholder="Address" class="p-4 border border-gray-400 rounded-lg ")
                label.font-semibold Description :
                input(type="text" v-model="data.Description" placeholder="Description" class="p-4 border border-gray-400 rounded-lg ")
                label.font-semibold ZipCode :
                input(type="text" v-model="data.zipCode" placeholder="Description" class="p-4 border border-gray-400 rounded-lg ")
                label.font-semibold Country :
                input(type="text" v-model="data.country" placeholder="Country" class="p-4 border border-gray-400 rounded-lg ")
                label.font-semibold City :
                input(type="text" v-model="data.city" placeholder="City" class="p-4 border border-gray-400 rounded-lg ")
                label.font-semibold Phone :
                input(type="text" v-model="data.phone" placeholder="Phone" class="p-4 border border-gray-400 rounded-lg ")
          div(class="flex items-center justify-end mb-4 gap-x-4")
            button(type="button" class="bg-gray-300 text-gray-600 p-4 px-8 rounded-lg font-semibold" @click="modal = false") Cancel
            button(type="button" class="bg-primary text-white p-4 px-8 rounded-lg font-semibold" @click="submitEdit") Submit
</template>