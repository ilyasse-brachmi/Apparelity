<script setup lang="ts">
import Sidebar from "../components/sidebar.vue"
import { onMounted, ref } from "vue"
import { $AppAxios } from "@/utils/axiosSingleton";
import { useAuth } from '@/stores/auth.store'
import Navbar from '@/components/navbar.vue'
import type { Category, Material } from "@/types/index"
import router from "@/routes";

const opened = ref(false)
const sidebarToggle = (newVal: boolean) => {
	opened.value = newVal
}
const store = useAuth()
const modal = ref(false)
const openModal = () => {
	modal.value = true
}
const categories = ref([] as Array<Category>)
const materials = ref([] as Array<Material>)
onMounted(async () => {
	$AppAxios.get('/api/category')
		.then((response) => {
			categories.value = response.data
	})
	$AppAxios.get('/api/material')
		.then((response) => {
			materials.value = response.data
	})
})
const nameValue = ref('')
const props = defineProps({
	withSearch :{
		type: Boolean,
		default: true
	}
})
// provide('sidebarToggle', opened.value)
const icon = ref('iconoir:sort-up')
const clicked = () => {
	if(icon.value === 'iconoir:sort-up'){
		icon.value = 'iconoir:sort-down'
		emits('sortClicked', 'desc')
	}
	else{
		icon.value = 'iconoir:sort-up'
		emits('sortClicked', 'asc')
	}
}
const selectedSearch = ref('product')
const emits = defineEmits(['sortClicked','NameSearched'])
const storePage = router.currentRoute.value.name=="Store"? true: false
</script>
<template lang="pug">
Navbar(@sidebar-toggle="sidebarToggle")
Sidebar(:categories="categories" :materials="materials" :sidebarToggle="opened")
	div(:class="store.isAuth? 'lg:flex justify-between':''")
		div(class="flex justify-center items-center py-2 sm:py-4 px-2 bg-gray-50")
			slot(name="addBtn")
		div(v-if="withSearch" class="flex justify-center lg:justify-end items-center sm:py-4 px-2 bg-gray-50 z-10")
			div(class="flex items-center justify-between max-w-[30rem] bg-primary/5 px-1 sm:px-2 lg:px-4 py-0.5 sm:py-2 rounded-lg")
				input(type="text" @keyup.enter="$emit('NameSearched', nameValue, selectedSearch)" v-model="nameValue" placeholder="Search for a Product" class="bg-transparent text-sm sm:text-base md:text-lg outline-none border-none w-full")
				//- Icon(icon="tabler:search" class="text-3xl lg:text-4xl mx-2 text-primary cursor-pointer")
				select(v-if="storePage" class="px-4 py-2 bg-transparent border-0 border-b-2 border-gray-200" v-model="selectedSearch")
					option(value="product") Product
					option(value="company") Company
			Icon(:icon="icon" @click="clicked()" class="text-4xl text-primary cursor-pointer ml-4")
	div(class="shadow-md bg-gray-50 py-4 w-full h-fit min-h-[90vh]")
		slot(name="cards")
		//- slot(name="cards" :test="'test'")
</template>