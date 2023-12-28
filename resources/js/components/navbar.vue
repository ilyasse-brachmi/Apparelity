<script setup lang="ts">
import { useRouter } from 'vue-router'
import { useAuth } from '@/stores/auth.store'
import Swal from 'sweetalert2'
import AppModal from '@/components/AppModal.vue'
import type { UserCompany } from "@/stores/auth.store"
import Input from '@/components/AppInput.vue'
import { useAppa } from '@/stores/index.store'
import { $AppAxios } from '@/utils/axiosSingleton'
import type { Company } from '@/types'
import { computed, onMounted, ref, watch } from 'vue'
import { useField, useForm } from 'vee-validate'
import * as yup from 'yup'

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
const modal = ref(false)
const companyConnected = ref({} as Company)
const openModal = async() => {
  $AppAxios.get(`/api/company/${store.company.id}`)
	.then((response) => {
		companyConnected.value = response.data
    console.log(response.data)
	})
	modal.value = true
}

const status = ref("Display")
const edit =()=>{
  status.value="Edit"
}

const scheme = computed(() => {
  return yup.object({
    companyName: yup.string().required('Company Name is required'),
    email: yup.string().required('Email is required').email('Email must be valid'),
    tel: yup.string().required('Phone is required'),
    address: yup.string().required('Address is required'),
    zip: yup.string().required('Zip code is required'),
    description: yup.string(),
    acceptTermsPrivacy: yup.boolean().oneOf([true], 'Must be accepted')
  })
})
const { errors, handleSubmit } = useForm({
  validationSchema: scheme
})
const {
  handleChange: nameError,
  value: companyName
} = useField<string>('companyName')
const {
  handleChange: mailError,
  value: email
} = useField<string>('email')
const {
  handleChange: telError,
  value: tel
} = useField<string>('tel')
const {
  handleChange: addressError,
  value: address
} = useField<string>('address')
const {
  handleChange: zipError,
  value: zip
} = useField<string>('zip')
const {
  handleChange: descriptionError,
  value: description
} = useField<string>('description')
interface StateCountry {
  key: string
  value: string
}
const selectedState = ref<StateCountry>()
const states = ref([] as StateCountry[])
const selectedCountry = ref<StateCountry>()
const countries =ref([] as StateCountry[])
onMounted(async () => {
  await $AppAxios.get('/api/countries')
  .then((response: { data: []}) => {
    countries.value = response.data
  })
})
watch(
  () => selectedCountry.value,
  async (newVal) => {
    if (newVal) {
      await $AppAxios.get(`/api/states?codeIso=${newVal.key}`)
      .then((response: { data: []}) => states.value = response.data)
    }
  }
)
const editCompanySubmit = handleSubmit(async () => {
  // const data = { 
  //   name: companyName.value,
  //   email: email.value, 
  //   phone: tel.value, 
  //   address: address.value,
  //   zipCode: zip.value,
  //   country: selectedCountry.value?.value,
  //   city: selectedState.value?.value,
  //   description: description.value,
  //   user_id: store.user.id
  //  }
   console.log('teeeest')
  //  await $AppAxios.post('/api/company', data)
  //  .then(async (response: { data: UserCompany }) => {
  //     const company = ref({} as UserCompany)
  //     company.value = response.data
  //     store.setCompany(company.value)
  //     Swal.fire({
  //       text: 'Your Company is created successfuly !',
  //       icon: 'success',
  //       toast: true,
  //       position: 'top-end',
  //       timer: 3000,
  //       showConfirmButton: false,
  //     })
  //     router.push('/dashboard')
  //  })
  //  .catch((e) => {
  //   if(e.response) {
  //     Swal.fire({
  //       text: e.response.data.message || 'Error !!',
  //       icon: 'error',
  //       toast: true,
  //       position: 'top-end',
  //       timer: 3000,
  //       showConfirmButton: false
  //     })
  //   }
  //   })
  status.value="Display"
})
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
        li.p-3.text-gray-600(class="hover:font-medium hover:bg-primary/5 px-4 hover:scale-x-105 duration-200 cursor-pointer hover:text-primary" @click="logout")
          a Logout
      AppModal(v-if="modal" :title="'Profile Details'" @close="modal = false")
        div(class="flex flex-col justify-center px-24 gap-y-10 w-full h-full")
          div(class="flex justify-center")
            div(class="w-full h-full bg-white shadow-md rounded-xl border-4 my-4")
              h1(class="text-primary font-semibold text-xl text-center py-8") Company Owner :
              div(class="grid grid-cols-2 gap-y-2 mx-8 text-lg")
                label.font-semibold Name :
                p {{ store.user.name }}
                label.font-semibold E-mail :
                p {{ store.user.email }}
          div(v-if="status==='Display'" class="flex justify-center")
            div(class="w-full h-full bg-white shadow-md rounded-xl border-4 my-4")
              h1(class="text-primary font-semibold text-xl text-center py-8") Company Details :
              div(class="grid grid-cols-2 gap-y-2 mx-8 text-lg")
                label.font-semibold Name :
                p {{ companyConnected.name }}
                label.font-semibold Address :
                p {{ companyConnected.address }}
                label.font-semibold Description :
                p {{ companyConnected.Description? companyConnected.Description: 'No Description Available'  }} 
                label.font-semibold ZipCode :
                p {{ companyConnected.zipCode }}
                label.font-semibold Country :
                p {{ companyConnected.country }}
                label.font-semibold City :
                p {{ companyConnected.city }}
                label.font-semibold Phone :
                p {{ companyConnected.phone }}
          div(v-if="status==='Edit'" class="flex justify-center")
            div(class="w-full h-full bg-white shadow-md rounded-xl border-4 my-4")
              h1(class="text-primary font-semibold text-xl text-center py-8") Company Details :
              div(class="px-8 w-full")
                form(method="POST" @submit.prevent="editCompanySubmit" class="flex-col items-center justify-center")
                  div(class="grid md:grid-rows-5 md:grid-cols-2 gap-x-6")
                    div(class="mt-4")
                      Input(:value="companyConnected.name" :labelName="'Company Name'" name="Company Name" :type="'text'" :color="'#1d6795'" @input="nameError" :inputError="errors.companyName")
                    div(class="mt-4")
                      Input(:value="companyConnected.phone" :labelName="'Company Phone'" name="tel" :type="'text'" :icon="'ic:baseline-phone'" :color="'#1d6795'" @input="telError" :inputError="errors.tel")
                    div(class="mt-4")
                      Input(:value="companyConnected.address" :labelName="'Company Address'" name="address" :type="'text'" :icon="'entypo:address'" :color="'#1d6795'" @input="addressError" :inputError="errors.address")
                    div(class="w-full rounded max-w-[40rem] bg-white mt-4 row-span-3 col-span-1 mt-10")
                      label(for="description" class="text-primary ml-2 text-lg") Company Description
                      div(class="w-full rounded max-w-[40rem] bg-white mt-2")
                        textarea(rows="5" cols="" id="description" placeholder="Optional Description of Your Company..." @input="descriptionError" class="p-4 mt-2 text-lg border-primary border-2 rounded-lg bg-transparent w-full") {{ companyConnected.Description?companyConnected.Description:"" }}
                      div(v-if="errors.description" class="mt-4 bg-red text-black")
                        p {{ errors.description }}
                    div(class="mt-4")
                      Input(:value="companyConnected.zipCode" :labelName="'Zip Code'" name="zip" :type="'text'" :icon="'icon-park-outline:zip'" :color="'#1d6795'" @input="zipError" :inputError="errors.zip")
                    div(class="mt-4")
                      select(class="dz-select dz-select-bordered w-full h-[3.6rem] min-h-[3.6rem]" v-model="selectedCountry")
                        option(disabled :value="companyConnected.country") {{companyConnected.country}}
                        option(v-for="(country,key) in countries" :key="key" :value="country") {{ country.value }}
                    div(class="mt-4")
                      select(class="dz-select dz-select-bordered w-full h-[3.6rem] min-h-[3.6rem]" v-model="selectedState")
                        option(selected) {{companyConnected.city}}
                        option(v-for="(state,key) in states" :key="key" :value="state") {{ state.value }}
                  div(class="flex justify-center mt-4")
                    button(type="submit" class="border font-bold text-2xl text-white border-white rounded-full w-full py-4 bg-primary hover:shadow-md duration-300") Done
          div(class="flex items-center justify-end mb-4")
            a(v-if="status==='Display'" @click="edit" class="px-4 md:px-8 lg:px-14 py-2 text-white m-2 bg-primary rounded-md hover:bg-primary/90  hover:shadow-md duration-300 font-semibold") Edit</template>