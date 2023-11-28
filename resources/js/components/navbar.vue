<script setup lang="ts">
import { useRoute } from 'vue-router'
const route = useRoute()
const authPage = (route.name?.toString().includes('register') || route.name?.toString().includes('login') )? true: false
</script>
<template lang="pug">
header(class="flex items-center justify-between p-4 top-0 bg-gray-100 sticky shadow-md")
  .dz-navbar-start
    div(v-if="!authPage")
      a.dz-btn.dz-btn-ghost.text-xl(href='/') LOGO
  div(v-if="!authPage" class="dz-navbar-center")
    a( href="/login" class="px-4 md:px-8 lg:px-14 py-2 text-white m-2 bg-primary rounded-sm hover:bg-primary/90  hover:shadow-md duration-300") Sign In
</template>