<script setup lang="ts">
import Navbar from "../../components/navbar.vue";
import Input from '@/components/AppInput.vue';
import { $AppAxios } from "@/utils/axiosSingleton";
import { useAuth } from "@/stores/auth.store";
import { useRouter } from "vue-router";
import { computed } from 'vue';
import { useField, useForm } from 'vee-validate'
import * as yup from 'yup';
import Swal from "sweetalert2";

const scheme = computed(() => {
  return yup.object({
    companyName: yup.string().required('Company Name is required'),
    email: yup.string().required('Email is required').email('Email must be valid'),
    tel: yup.string().required('Phone is required'),
    address: yup.string().required('Address is required'),
    zip: yup.number().typeError('Zip must be a Number').required('Zip code is required'),
    city: yup.string().required('City is required'),
    country: yup.string().required('Country is required'),
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

const {
  handleChange: cityError,
  value: city
} = useField<string>('city')

const {
  handleChange: countryError,
  value: country
} = useField<string>('country')

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
    country: country.value,
    city: city.value,
    description: description.value
   }
   await $AppAxios.post('/api/company', data)
   .then(async (response) => {
      store.fetchUser(response.data.token, response.data.user)
      Swal.fire({
      text: 'Your Company is created successfuly !',
      icon: 'success',
      toast: true,
      position: 'top-end',
      timer: 3000,
      showConfirmButton: false,
    })
    .then(function() {
      router.push('/dashboard')
    });
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
    console.log(e.response.data)
    }
    })
})
</script>
<template lang="pug">
div(class="h-screen w-screen flex items-center justify-center")
  div(class="flex items-center justify-center my-8 h-[90vh]")
    div(class="container w-[30rem] sm:w-[60rem] max-h-[68rem] py-2 px-2 sm:px-8 sm:py-4 border-2 border-gray-200 rounded-lg shadow-lg shadow-gray-200/50")
      h1(class="text-center text-4xl sm:text-5xl font-semibold text-primary") Complete Your account
      p(class="text-center text-lg sm:text-xl my-2 sm:mx-8") Fill Up your Company informations.
      form(method="POST" @submit.prevent="addCompanySubmit" class="flex-col items-center justify-center px-4 sm:px-12")
        div(class="grid sm:grid-rows-5 sm:grid-cols-2 gap-x-6")
          div(class="mt-4")
            Input(:labelName="'Company Name'" name="Company Name" :type="'text'" :color="'#1d6795'" @input="nameError" :inputError="errors.companyName")
          div(class="mt-4")
            Input(:labelName="'Company Phone'" name="tel" :type="'text'" :icon="'ic:baseline-phone'" :color="'#1d6795'" @input="telError" :inputError="errors.tel")
          div(class="mt-4")
            Input(:labelName="'Company Email'" name="email" :type="'text'" :icon="'ic:outline-email'" :color="'#1d6795'" @input="mailError" :inputError="errors.email")
          div(class="mt-4")
            Input(:labelName="'Company Address'" name="aposiakodddress" :type="'text'" :icon="'entypo:address'" :color="'#1d6795'" @input="addressError" :inputError="errors.address")
          div(class="w-full rounded max-w-[40rem] bg-white mt-4 row-span-3 col-span-1")
            label(for="description" class="text-primary") Company Description
            textarea(rows="7" cols="" id="description" placeholder="Optional Description of Your Company..." class="px-4 py-2 text-lg border-primary border-2 rouned bg-transparent w-full")
          div(class="mt-4")
            Input(:labelName="'Zip Code'" name="zip" :type="'text'" :icon="'icon-park-outline:zip'" :color="'#1d6795'" @input="zipError" :inputError="errors.zip")
          div(class="mt-4")
            Input(:labelName="'City'" name="city" :type="'text'" :icon="'la:city'" :color="'#1d6795'" @input="cityError" :inputError="errors.city")
          div(class="mt-4")
            Input(:labelName="'Country'" name="country" :type="'text'" :icon="'gis:search-country'" :color="'#1d6795'" @input="countryError" :inputError="errors.country")
        div(class="mt-4 flex justify-center gap-1 whitespace-nowrap")
          input(type="checkbox" id="acceptTermsPrivacy" name="acceptTermsPrivacy" value="true" @input="acceptTermsPrivacyError" :inputError="errors.acceptTermsPrivacy")
          label(for="acceptTermsPrivacy" class="ml-1") I have read and accept 
          a(href="/terms-of-service" target="_blank" class="text-primary") terms of Service 
          span , 
          a(href="/privacy-policy" target="_blank" class="text-primary") Privacy Policy
        div(class="flex justify-center mt-4")
          button(type="submit" class="border font-bold text-2xl text-white border-white rounded-full w-full py-4 bg-primary hover:shadow-md duration-300") Complete
</template>