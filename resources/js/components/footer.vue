<script setup lang="ts">
import WhiteLogo from "../../images/whiteLogo.png"
</script>
<template lang="pug">
footer.dz-footer.dz-footer-center.p-20.rounded(class="bg-gradient-to-r from-secondary to-primary text-white")
  nav.grid.grid-flow-col.gap-4
    a(href="/" class="hover:underline hover:font-semibold") Home 
    a(href="/privacy-policy" class="hover:underline hover:font-semibold") Privacy Policy
    a(href="/terms-of-service" class="hover:underline hover:font-semibold") Terms of Service
  div(class="flex flex-col items-center justify-center")
    a(href="/" class="text-6xl font-semibold cursor-pointer")
      img(:src="WhiteLogo" alt="Apparelity Logo" class="w-[25rem] lg:w-[30rem]")
    h1(class="text-sm font-medium") Apparelity
  aside
    p Copyright &copy; 2023 - All right reserved by Apparelity
</template>