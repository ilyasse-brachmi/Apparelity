<script setup lang="ts">
import type { Product } from '@/types';
import type { PropType } from 'vue';
const props = defineProps({
  product: {
    type: Object as PropType<Product>
  }
})
defineEmits(['openModal'])
</script>
<template lang="pug">
div(class="bg-gray-100 rounded p-10 sm:w-[18rem] 2xl:w-[19rem] h-[27rem] transition duration-700")
  div(class="relative max-h-[20rem]")
    img(v-if="product?.product_image" :src="`/storage/home/${product.product_image.split('home/')[1]}`" alt="Product Image" class="h-full w-full max-h-[15rem] max-w-[15rem] rounded-lg hover:scale-105 cursor-pointer duration-200")
    div(v-else class="w-[15rem] h-[15rem] rounded-lg bg-gray-400 flex items-center justify-center")
      p Image not found
    div(class="absolute top-[-1rem] end-[-1rem] flex items-start gap-4 p-2 bg-primary hover:scale-110 duration-200 hover:bg-primary/90 rounded-full")
      Icon(icon="carbon:map" class="text-white cursor-pointer text-3xl font-semibold" @click="$emit('openModal')") 
  div(class="py-3")
    p(class="text-xs rounded-full px-2 w-fit text-primary py-1 bg-primary/20") {{ product?.category_name }}
  div(class="")
    h1(class="text-xl text-primary font-semibold tracking-wide") {{ product?.name }}
    h3(class="text-gray-500 text-sm") {{ product?.company_name }}
    p(class="text-lg font-medium text-red-500 text-end") {{ product?.price }} $
</template>