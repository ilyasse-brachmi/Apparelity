<script setup lang="ts">
import { Icon } from '@iconify/vue';
import Navbar from "../../components/navbar.vue";
import Input from '@/components/AppInput.vue';
import { ref } from 'vue';

</script>
<template lang="pug">
div
  div(class="flex items-center justify-center my-8 h-[90vh]")
    div(class="container w-[26rem] sm:w-[40rem] max-h-[40rem] py-2 px-8 sm:p-8 border-2 border-gray-200 rounded-lg shadow-lg shadow-gray-200/50")
      h1(class="text-center text-4xl sm:text-5xl font-semibold text-primary") Hey There!
      p(class="text-center text-lg sm:text-xl mt-8") Welcome back.
      p(class="text-center text-lg sm:text-xl my-2") Your are just one step away to your feed.
      form(method="POST" class="flex-col items-center justify-center px-12")
        div(class="mt-8")
          Input(:labelName="'Email'" :type="'text'" :icon="'ic:outline-email'" :color="'#1d6795'")
        div(class="mt-8")
          Input(:labelName="'Password'" :type="'password'" :color="'#1d6795'")
            //- ri:eye-line
        div(class="flex justify-center mt-16")
          button(type="Submit" class="border font-bold text-2xl text-white border-white rounded-full px-16 sm:px-48 py-4 bg-primary hover:shadow-md duration-300") Sign In
      div(class="flex flex-col lg:flex-row items-center gap-2 justify-center mt-4")
        p(class="text-lg sm:text-xl") Don't have an account ? 
        a(href="/register" class="text-lg sm:text-xl font-semibold text-primary") Sign Up
</template>