<script setup lang="ts">
import Navbar from "../components/navbar.vue"
import Footer from "../components/footer.vue"
</script>
<template lang="pug">
div
  Navbar
  slot
  Footer
</template>