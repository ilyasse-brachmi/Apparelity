<script setup lang="ts">
import { Icon } from '@iconify/vue';
import Navbar from "../../components/navbar.vue";
import Input from '@/components/AppInput.vue';

</script>
<template lang="pug">
div
  div(class="flex items-center justify-center my-8 h-[90vh]")
    div(class="container w-[26rem] sm:w-[40rem] max-h-[50rem] py-2 px-8 sm:p-8 border-2 border-gray-200 rounded-lg shadow-lg shadow-gray-200/50")
      h1(class="text-center text-4xl sm:text-5xl font-semibold text-primary my-8") Welcome to Apparelity
      p(class="text-center text-lg sm:text-xl my-2 sm:mx-8") Fill Up your personal informations and start journey with us.
      form(method="POST" class="flex-col items-center justify-center px-12")
        div(class="mt-8")
          Input(:labelName="'Name'" :type="'text'" :color="'#1d6795'")
        div(class="mt-8")
          Input(:labelName="'Email'" :type="'text'" :icon="'ic:outline-email'" :color="'#1d6795'")
        div(class="mt-8")
          Input(:labelName="'Password'" :type="'password'" :color="'#1d6795'")
        div(class="mt-8")
          Input(:labelName="'Confirm Password'" :type="'password'" :color="'#1d6795'")
        div(class="flex justify-center mt-12")
          button(type="submit" class="border font-bold text-2xl text-white border-white rounded-full w-full py-4 bg-primary hover:shadow-md duration-300") Sign Up
      div(class="flex flex-col lg:flex-row items-center gap-2 justify-center mt-4")
        p(class="text-lg sm:text-xl") Already have an account ?
        a(href="/login" class="text-lg sm:text-xl font-semibold text-primary") Sign In
</template>