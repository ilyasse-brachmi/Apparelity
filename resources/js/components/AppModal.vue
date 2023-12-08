<script setup lang="ts">
import { breakpointsTailwind, useBreakpoints } from '@vueuse/core'

const breakpoints = useBreakpoints(breakpointsTailwind)
const xs = breakpoints.smaller('sm')
const xse = breakpoints.smallerOrEqual('sm')
const sm = breakpoints.between('sm', 'md')
const md = breakpoints.between('md', 'lg')
const lg = breakpoints.between('lg', 'xl')
const xl = breakpoints.between('xl', '2xl')

defineEmits(['close'])
</script>
<template lang="pug">
div(class="fixed top-0 left-0 bg-black/60 h-screen w-screen z-[9999] flex items-center justify-center")
  div(:class="[xse ? 'w-[20rem]' : sm ? 'w-[35rem]' : md ? 'w-[40rem]' : lg ? 'w-[55rem]' : xl ? 'w-[64rem]' : 'w-[72rem]']" class="h-[90%] bg-white z-[99999] fixed  rounded overflow-hidden")
    div(class="flex flex-col h-full w-full")
      div(class="flex items-center justify-end h-[5rem] w-full shadow-sm")
        Icon(icon="material-symbols:close" class="text-3xl mx-4 cursor-pointer text-gray-600" @click="$emit('close')")
      div(class="w-full h-full")
        slot
</template>