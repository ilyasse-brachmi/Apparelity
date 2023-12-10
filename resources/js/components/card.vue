<script setup lang="ts">
import { ref } from 'vue';

const props = defineProps({
  productName: {
    type: String,
    required: true
  },
  companyName: {
    type: String,
    required: true
  },
  price: {
    type: Number,
    required: true
  },
  imageProduct: {
    type: String,
    required: true
  }
})
defineEmits(['openModal'])
</script>
<template lang="pug">
div(class="bg-gray-100 rounded p-10 sm:w-[18rem] 2xl:w-[19rem] h-[27rem] transition duration-700")
  div(class="relative max-h-[20rem]")
    img(:src="imageProduct" alt="Product Image" class="h-full w-full")
    div(class="absolute top-[-1rem] end-[-1rem] flex items-start gap-4 p-2 bg-primary hover:scale-110 duration-200 hover:bg-primary/90 rounded-full")
      Icon(icon="carbon:map" class="text-white cursor-pointer text-3xl font-semibold" @click="$emit('openModal')") 
  div(class="py-2")
    p(class="text-sm text-gray-500 ") {{ companyName }}
  div(class="")
    h1(class="text-xl text-gray-800 font-medium") {{ productName }}
    p(class="text-lg font-medium text-red-500 text-end") {{ price }} $
</template>