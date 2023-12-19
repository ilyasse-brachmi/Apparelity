<script setup lang="ts">
import { useAppa } from "@/stores/index.store"

const store = useAppa()

</script>
<template lang="pug">
div(v-if="store.isLoading" class="relative")
  div(class="w-full h-full bg-white/80 fixed top-0 left-0 z-[99999] flex items-center justify-center")
    span(class="dz-loading dz-loading-infinity w-[7rem] text-primary")
div
  router-view
</template>