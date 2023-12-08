<script setup lang="ts">
import { breakpointsTailwind, useBreakpoints } from '@vueuse/core'

const breakpoints = useBreakpoints(breakpointsTailwind)
const xs = breakpoints.smaller('sm')
const xse = breakpoints.smallerOrEqual('sm')
const sm = breakpoints.between('sm', 'md')
const md = breakpoints.between('md', 'lg')
const lg = breakpoints.between('lg', 'xl')
const xl = breakpoints.between('xl', '2xl')

const props = defineProps({
  title: {
    type: String,
    required: false
  }
})

defineEmits(['close'])
</script>
<template lang="pug">
div(class="fixed top-0 left-0 bg-black/60 h-screen w-screen z-[9999] flex items-center justify-center")
  div(:class="[xse ? 'w-[20rem]' : sm ? 'w-[35rem]' : md ? 'w-[40rem]' : lg ? 'w-[55rem]' : xl ? 'w-[64rem]' : 'w-[72rem]']" class="h-[90%] bg-white z-[99999] fixed  rounded overflow-hidden")
    div(class="flex flex-col h-full w-full")
      div(class="flex items-center justify-between p-6 px-8 w-full shadow-sm")
        h1(v-if="props.title" class="font-semibold text-xl") {{ props.title }}
        Icon(icon="material-symbols:close" class="text-3xl cursor-pointer text-gray-600" @click="$emit('close')")
      div(class="w-full h-full overflow-y-auto")
        slot
</template>