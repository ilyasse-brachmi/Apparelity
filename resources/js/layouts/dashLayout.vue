<script setup lang="ts">
import Sidebar from "../components/sidebar.vue"
import { ref } from 'vue'
import Navbar from '@/components/navbar.vue'
const opened = ref(false)
const sidebarToggle = (newVal: boolean) => {
	opened.value = newVal
}
// provide('sidebarToggle', opened.value)
</script>
<template lang="pug">
Navbar(@sidebar-toggle="sidebarToggle")
Sidebar(:categories="['']" :materials="['']" :sidebarToggle="opened")
	div(class="bg-gray-50 py-4")
		slot
</template>