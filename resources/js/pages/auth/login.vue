<script setup lang="ts">
import { Icon } from '@iconify/vue';
import Navbar from "../../components/navbar.vue";
</script>
<template lang="pug">
div
  Navbar
  div(class="flex items-center justify-center my-8")
    div(class="container w-[26rem] sm:w-[40rem] max-h-[40rem] py-2 px-8 sm:p-8 border-2 border-gray-200 rounded-lg shadow-lg shadow-gray-200/50")
      h1(class="text-center text-4xl sm:text-5xl font-semibold text-primary") Hey There!
      p(class="text-center text-xl sm:text-2xl mt-8") Welcome back.
      p(class="text-center text-xl sm:text-2xl my-2") Your are just one step away to your feed.
      form(method="POST" class="flex-col items-center justify-center")
        div(class="flex justify-center mt-8")
          div(class="flex items-center justify-between w-full px-8 py-4 border-b-2 border-primary max-w-[30rem]")
            input(type="text" placeholder="Enter Email" class="bg-transparent px-4 py-2 text-lg outline-none border-none w-full")
            Icon(icon="ic:outline-email" class="text-3xl sm:text-4xl text-primary")
        div(class="flex justify-center mt-2")
          div(class="flex items-center justify-between w-full px-8 py-4 border-b-2 border-primary max-w-[30rem]")
            input(type="text" placeholder="Enter Password" class="bg-transparent px-4 py-2 text-lg outline-none border-none w-full")
            Icon(icon="ri:eye-off-line" class="text-3xl sm:text-4xl text-primary cursor-pointer")
            //- ri:eye-line
        div(class="flex justify-center mt-16")
          button(type="Submit" class="border font-bold text-2xl text-white border-white rounded-full px-16 sm:px-48 py-4 bg-primary hover:shadow-md duration-300") Sign In
      div(class="flex flex-col lg:flex-row items-center justify-center gap-2 justify-center mt-4")
        p(class="text-lg sm:text-xl") Don't have an account ? 
        a(href="#" class="text-lg sm:text-xl font-semibold text-primary") Sign Up
</template>