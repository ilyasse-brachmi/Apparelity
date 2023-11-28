<script setup lang="ts">
import { advantages } from '../data/advantages.data';

</script>
<template lang="pug">
div(class="container mx-auto p-4")
  h1(class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-semibold text-center my-8") Advantages
  div(class="flex items-center justify-center")
    div(class="grid grid-cols-1 sm:grid-cols-2 sm:gap-x-8 md:gap-x-16 p-4 md:p-8 lg:p-16")
      div(v-for="(advantage, index) in advantages" :key="index")
        div(class="flex items-start gap-4 py-4")
          div(class="flex items-start gap-4")
            Icon(:icon="advantage.icon" class="text-white bg-primary text-5xl p-2.5 rounded-full")
          div(class="py-2")
            h1(class="text-primary text-xl font-semibold") {{ advantage.title }}
            div(class="max-w-[30rem]")
              p(class="py-2 md:py-4 lg:py-8 text-gray-500") {{ advantage.description }}
</template>