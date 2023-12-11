<script setup lang="ts">
import Sidebar from "../components/sidebar.vue"
import AppModal from "@/components/AppModal.vue"
import { ref } from 'vue'
import { useAuth } from '@/stores/auth.store'
import Navbar from '@/components/navbar.vue'
const categories = ['Headwear','Shoes','Bags','Clothes'];
const materials = ['Cotton','Leather','Linen','Nylon'];
const opened = ref(false)
const sidebarToggle = (newVal: boolean) => {
	opened.value = newVal
}
const store = useAuth()
// provide('sidebarToggle', opened.value)
</script>
<template lang="pug">
Navbar(@sidebar-toggle="sidebarToggle")
Sidebar(:categories="categories" :materials="materials" :sidebarToggle="opened")
	div(:class="store.isAuth? 'flex justify-between':''")
		div
			slot(name="addBtn")
		div(class="flex justify-center lg:justify-end items-center p-6 px-10 bg-gray-50 z-10")
			div(class="flex items-center justify-between max-w-[30rem] px-1 sm:px-2 lg:px-4 py-1 sm:py-2 border-2 border-primary rounded-full")
				input(type="text" placeholder="Search for a Product" class="bg-transparent px-4 py-2 text-sm sm:text-base md:text-lg outline-none border-none w-full")
				Icon(icon="tabler:search" class="text-3xl lg:text-4xl mx-2 text-primary cursor-pointer")
			Icon(icon="iconoir:sort" class="text-4xl text-primary cursor-pointer ml-4")
	div(class="shadow-md bg-gray-50 py-4 w-full h-full")
		slot(name="cards")
</template>