<script setup lang="ts">
import Input from '@/components/AppInput.vue'
import { $AppAxios } from "@/utils/axiosSingleton"
import { useAuth } from "@/stores/auth.store"
import { useRouter } from "vue-router"
import { computed, onMounted, ref, watch } from 'vue'
import { useField, useForm } from 'vee-validate'
import * as yup from 'yup'
import type { UserCompany } from "@/stores/auth.store"
import Swal from "sweetalert2"

const scheme = computed(() => {
  return yup.object({
    companyName: yup.string().required('Company Name is required'),
    email: yup.string().required('Email is required').email('Email must be valid'),
    tel: yup.string().required('Phone is required'),
    address: yup.string().required('Address is required'),
    zip: yup.number().typeError('Zip must be a Number').required('Zip code is required'),
    // state: yup.string().required('City is required'),
    // country: yup.string().required('Country is required'),
    description: yup.string(),
    acceptTermsPrivacy: yup.boolean().oneOf([true], 'Must be accepted')
  })
})

const store = useAuth()
const router = useRouter()

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

// const {
//   handleChange: stateError,
//   value: state
// } = useField<string>('state')

// const {
//   handleChange: countryError,
//   value: country
// } = useField<string>('country')

const {
  handleChange: descriptionError,
  value: description
} = useField<string>('description')

const {
  handleChange: acceptTermsPrivacyError,
  value: acceptTermsPrivacy
} = useField<string>('acceptTermsPrivacy')

const addCompanySubmit = handleSubmit(async () => {
  const data = { 
    name: companyName.value,
    email: email.value, 
    phone: tel.value, 
    address: address.value,
    zipCode: zip.value,
    country: selectedCountry.value?.value,
    city: selectedState.value?.value,
    description: description.value,
    user_id: store.user.id
   }
   await $AppAxios.post('/api/company', data)
   .then(async (response: { data: UserCompany }) => {
      const company = ref({} as UserCompany)
      company.value = response.data
      store.setCompany(company.value)
      Swal.fire({
        text: 'Your Company is created successfuly !',
        icon: 'success',
        toast: true,
        position: 'top-end',
        timer: 3000,
        showConfirmButton: false,
      })
      router.push('/dashboard')
   })
   .catch((e) => {
    if(e.response) {
      Swal.fire({
        text: e.response.data.message || 'Error !!',
        icon: 'error',
        toast: true,
        position: 'top-end',
        timer: 3000,
        showConfirmButton: false
      })
    }
    })
})
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
const logout = () => {store.logout()}
</script>
<template lang="pug">
div(class="w-screen h-screen flex items-center justify-center px-10 md:px-0")
  div(class="flex items-center justify-center py-12 px-4 lg:px-12 w-full border-2 border-gray-200 rounded-lg shadow-lg shadow-gray-200/50 lg:mx-20 mx-10 lg:max-w-[70rem]")
    div(class="w-full")
      h1(class="text-center text-4xl my-6 sm:text-5xl font-semibold text-primary") Complete Your account
      p(class="text-center text-gray-600 text-lg sm:text-xl my-2 sm:mx-8") Fill Up your Company informations.
      form(method="POST" @submit.prevent="addCompanySubmit" class="flex-col items-center justify-center px-4 sm:px-8")
        div(class="grid md:grid-rows-5 md:grid-cols-2 gap-x-6")
          div(class="mt-4")
            Input(:labelName="'Company Name'" name="Company Name" :type="'text'" :color="'#1d6795'" @input="nameError" :inputError="errors.companyName")
          div(class="mt-4")
            Input(:labelName="'Company Phone'" name="tel" :type="'text'" :icon="'ic:baseline-phone'" :color="'#1d6795'" @input="telError" :inputError="errors.tel")
          div(class="mt-4")
            Input(:labelName="'Company Email'" name="email" :type="'text'" :icon="'ic:outline-email'" :color="'#1d6795'" @input="mailError" :inputError="errors.email")
          div(class="mt-4")
            Input(:labelName="'Company Address'" name="address" :type="'text'" :icon="'entypo:address'" :color="'#1d6795'" @input="addressError" :inputError="errors.address")
          div(class="w-full rounded max-w-[40rem] bg-white mt-4 row-span-3 col-span-1 mt-10")
            label(for="description" class="text-primary ml-2 text-lg") Company Description
            div(class="w-full rounded max-w-[40rem] bg-white mt-2")
              textarea(rows="5" cols="" id="description" placeholder="Optional Description of Your Company..." @input="descriptionError" class="p-4 mt-2 text-lg border-primary border-2 rounded-lg bg-transparent w-full")
            div(v-if="errors.description" class="mt-4 bg-red text-black")
              p {{ errors.description }}
          div(class="mt-4")
            Input(:labelName="'Zip Code'" name="zip" :type="'text'" :icon="'icon-park-outline:zip'" :color="'#1d6795'" @input="zipError" :inputError="errors.zip")
          div(class="mt-4")
            //- Input(:labelName="'Country'" name="country" :type="'text'" :icon="'gis:search-country'" :color="'#1d6795'" @input="countryError" :inputError="errors.country")
            select(class="dz-select dz-select-bordered w-full h-[3.6rem] min-h-[3.6rem]" v-model="selectedCountry")
              option(disabled value="") Select Country
              option(v-for="(country,key) in countries" :key="key" :value="country") {{ country.value }}
          div(class="mt-4")
            select(class="dz-select dz-select-bordered w-full h-[3.6rem] min-h-[3.6rem]" v-model="selectedState")
              option(disabled value="") Select State
              option(v-for="(state,key) in states" :key="key" :value="state") {{ state.value }}
        div(class="mt-10 flex justify-center gap-1 whitespace-nowrap")
          input(type="checkbox" id="acceptTermsPrivacy" name="acceptTermsPrivacy" v-model="acceptTermsPrivacyError")
          label(for="acceptTermsPrivacy" class="ml-1") I have read and accept 
          a(href="/terms-of-service" target="_blank" class="text-primary") terms of Service 
          span , 
          a(href="/privacy-policy" target="_blank" class="text-primary") Privacy Policy
        div(v-if="errors.acceptTermsPrivacy" class="mt-4 bg-red text-black")
          p {{errors.acceptTermsPrivacy}}
        div(class="flex justify-center mt-4")
          button(type="submit" class="border font-bold text-2xl text-white border-white rounded-full w-full py-4 bg-primary hover:shadow-md duration-300") Complete
        div(class="flex items-center justify-center mt-4")
          a(href="/" @click="logout" class="text-gray-400 text-sm cursor-pointer hover:text-primary duration-200") Logout
</template>