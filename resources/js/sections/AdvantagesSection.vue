<script setup lang="ts">
import { Icon } from '@iconify/vue';
import { advantages } from '../data/advantages.data';
</script>
<template lang="pug">
div(class="container mx-auto p-16")
  h1(class="font-semibold text-5xl text-center") Advantages
  div(class="flex items-center justify-center")
    div(class="grid grid-cols-2 gap-x-16 p-16")
      div(v-for="(advantage, index) in advantages" :key="index")
        div(class="flex items-start gap-4 py-4")
          div(class="flex items-start gap-4")
            Icon(:icon="advantage.icon" class="text-white bg-primary text-5xl p-2.5 rounded-full")
          div(class="py-2")
            h1(class="text-primary text-xl font-semibold") {{ advantage.title }}
            div(class="max-w-[30rem]")
              p.py-8.text-gray-500 {{ advantage.description }}
</template>