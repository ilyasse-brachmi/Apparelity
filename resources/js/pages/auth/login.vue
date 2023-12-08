<script setup lang="ts">
import Navbar from "../../components/navbar.vue";
import Input from '@/components/AppInput.vue';
import { $AppAxios } from "@/utils/axiosSingleton";
import { computed } from 'vue';
import { useAuth } from '@/stores/auth.store'
import Swal from 'sweetalert2'
import { useField, useForm } from 'vee-validate'
import { useRouter } from "vue-router";
import * as yup from 'yup';

const router = useRouter()
const store = useAuth()

const scheme = computed(() => {
  return yup.object({
    email: yup.string().required('email is a required field').email('email must be a valid email'),
    password: yup.string().required('password is a required field').min(8, 'password must be at least 8 characters').max(30, 'password must be no more than 30 characters'),
  })
})

const { errors, handleSubmit } = useForm({
  validationSchema: scheme
})

const {
  handleChange: mailError,
  value: email
} = useField<string>('email')

const {
  handleChange: passwordError,
  value: password
} = useField<string>('password')

const submit = handleSubmit(async () => {
  const data = { email: email.value, password: password.value }
  await $AppAxios.post('/api/login', data)
  .then(async (response) => {
    await store.fetchUser(response.data.token, response.data.user)
    Swal.fire({
      text: 'You are logged in !',
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
  .catch((e) => 
    Swal.fire({
      text: e.response.data.errorMessage || 'Error !!',
      icon: 'error',
      toast: true,
      position: 'top-end',
      timer: 3000,
      showConfirmButton: false
    })
  )
})

</script>
<template lang="pug">
div
  div(class="flex items-center justify-center my-8 h-[90vh]")
    div(class="container w-[26rem] sm:w-[40rem] max-h-[40rem] py-2 px-8 sm:p-8 border-2 border-gray-200 rounded-lg shadow-lg shadow-gray-200/50")
      h1(class="text-center text-4xl sm:text-5xl font-semibold text-primary") Hey There!
      p(class="text-center text-lg sm:text-xl mt-8") Welcome back.
      p(class="text-center text-lg sm:text-xl my-2") Your are just one step away to your feed.
      form(method="POST" @submit.prevent="submit" class="flex-col items-center justify-center px-12")
        div(class="mt-8")
          Input(:labelName="'Email'" name="email" :type="'text'" :icon="'ic:outline-email'" :color="'#1d6795'" @input="mailError" :inputError="errors.email")
        div(class="mt-8")
          Input(:labelName="'Password'" name="password" :type="'password'" :color="'#1d6795'" @input="passwordError" :inputError="errors.password")
            //- ri:eye-line
        div(class="flex justify-center mt-16")
          button(type="submit" class="border font-bold text-2xl text-white border-white rounded-full px-16 sm:px-48 py-4 bg-primary hover:shadow-md duration-300") Sign In
      div(class="flex flex-col lg:flex-row items-center gap-2 justify-center mt-4")
        p(class="text-lg sm:text-xl") Don't have an account ? 
        a(href="/register" class="text-lg sm:text-xl font-semibold text-primary") Sign Up
      div(class="flex items-center justify-center gap-2 w-full mt-4 hover:underline")
        Icon(icon="lets-icons:back" class="text-primary text-base sm:text-lg")
        a(href="/" class="text-primary text-base sm:text-lg") Back to home
</template>