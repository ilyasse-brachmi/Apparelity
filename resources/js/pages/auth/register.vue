<script setup lang="ts">
import Input from '@/components/AppInput.vue';
import { $AppAxios } from "@/utils/axiosSingleton";
import { useAuth } from "@/stores/auth.store";
import type { UserCompany } from "@/stores/auth.store";
import { useRouter } from "vue-router";
import { computed, ref } from 'vue';
import { useField, useForm } from 'vee-validate'
import * as yup from 'yup';
import Swal from "sweetalert2";
import { useAppa } from '@/stores/index.store';

const scheme = computed(() => {
  return yup.object({
    name: yup.string().required(),
    email: yup.string().required('email is a required field').email('email must be a valid email'),
    password: yup.string().required('password is a required field').min(8, 'password must be at least 8 characters').max(30, 'password must be no more than 30 characters'),
    confirmPassword: yup.string().oneOf([yup.ref('password'), null], 'The confirm password must match the Password'),
  })
})

const appaStore = useAppa()
const store = useAuth()
const router = useRouter()

const { errors, handleSubmit } = useForm({
  validationSchema: scheme
})

const {
  handleChange: nameError,
  value: name
} = useField<string>('name')

const {
  handleChange: mailError,
  value: email
} = useField<string>('email')

const {
  handleChange: passwordError,
  value: password
} = useField<string>('password')

const {
  handleChange: confirmPasswordError,
  value: confirmPassword
} = useField<string>('confirmPassword')

const registerSubmit = handleSubmit(async () => {
  const data = { 
    name: name.value,
    email: email.value, 
    password: password.value
   }
   await $AppAxios.post('/api/register', data)
   .then(async (response) => {
      await store.fetchUser(response.data.token, response.data.user)
      Swal.fire({
        text: 'You are registred in !',
        icon: 'success',
        toast: true,
        position: 'top-end',
        timer: 2000,
        customClass: {
        container: '.swal2-container ',
        },
        showConfirmButton: false,
      })
    .then(function() {
      appaStore.isLoading = false
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
    }
   })
})
</script>
<template lang="pug">
div
  div(class="flex items-center justify-center my-8 h-[90vh]")
    div(class="container w-[26rem] sm:w-[40rem] max-h-[60rem] py-2 px-8 sm:p-8 border-2 border-gray-200 rounded-lg shadow-lg shadow-gray-200/50")
      h1(class="text-center text-4xl sm:text-5xl font-semibold text-primary my-8") Welcome to Apparelity
      p(class="text-center text-lg sm:text-xl my-2 sm:mx-8") Fill Up your personal informations and start journey with us.
      form(method="POST" @submit.prevent="registerSubmit" class="flex-col items-center justify-center px-12")
        div(class="mt-8")
          Input(:labelName="'Name'" name="name" :type="'text'" :color="'#1d6795'" @input="nameError" :inputError="errors.name")
        div(class="mt-8")
          Input(:labelName="'Email'" name="email" :type="'text'" :icon="'ic:outline-email'" :color="'#1d6795'" @input="mailError" :inputError="errors.email")
        div(class="mt-8")
          Input(:labelName="'Password'" name="password" :type="'password'" :color="'#1d6795'" :enbaleCopyPast="false" @input="passwordError" :inputError="errors.password")
        div(class="mt-8")
          Input(:labelName="'Confirm Password'" name="confirmPassword" :type="'password'" :color="'#1d6795'" :enbaleCopyPast="false" @input="confirmPasswordError" :inputError="errors.confirmPassword")
        div(class="flex justify-center mt-12")
          button(type="submit" class="border font-bold text-2xl text-white border-white rounded-full w-full py-4 bg-primary hover:shadow-md duration-300") Sign Up
      div(class="flex flex-col lg:flex-row items-center gap-2 justify-center mt-4")
        p(class="text-lg sm:text-xl") Already have an account ?
        a(href="/login" class="text-lg sm:text-xl font-semibold text-primary") Sign In
      div(class="flex items-center justify-center gap-2 w-full mt-4 hover:underline")
        Icon(icon="lets-icons:back" class="text-primary text-base sm:text-lg")
        a(href="/" class="text-primary text-base sm:text-lg") Back to home
</template>