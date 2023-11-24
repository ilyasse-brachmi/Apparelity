<script setup lang="ts">
import { Icon } from '@iconify/vue';
</script>
<template lang="pug">
div(id="searchProduct" class="bg-gray-100")
  div(class="container mx-auto p-8 lg:p-16")
    h1(class="text-2xl sm:text-4xl lg:text-5xl xl:text-6xl font-semibold text-center") Find Your Product
    div(class="flex justify-center my-8 sm:my-16")
      div(class="flex items-center justify-between w-full px-2 sm:px-4 lg:px-8 py-2 sm:py-4 border-2 border-black rounded-full max-w-[60rem]")
        input(type="text" placeholder="Enter a product name" class="bg-transparent px-4 py-2 text-sm sm:text-base md:text-lg outline-none border-none w-full")
        Icon(icon="tabler:search" class="text-4xl text-gray-800 cursor-pointer")
    p(class="text-center text-gray-500 text-xs sm:text-sm") Enter the product name to inquire about the traceability of its productions raw materials
</template>