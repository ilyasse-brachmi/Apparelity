<script setup lang="ts">
import MainLayout from './mainLayout.vue';
import Sidebar from "../components/sidebar.vue";
import { provide, ref } from 'vue';
import Navbar from '@/components/navbar.vue';
import Footer from '@/components/footer.vue';
const categories = ['Headwear','Shoes','Bags','Clothes'];
const materials = ['Cotton','Leather','Linen','Nylon'];
const opened = ref(false)
const sidebarToggle = (newVal: boolean) => {
	opened.value = newVal
}
// provide('sidebarToggle', opened.value)
</script>
<template lang="pug">
Navbar(@sidebar-toggle="sidebarToggle")
Sidebar(:categories="categories" :materials="materials" :sidebarToggle="opened")
	div(class="shadow-md bg-gray-50 py-4")
		slot
Footer
</template>