<script setup lang="ts">
import Sidebar from "../components/sidebar.vue"
import { onMounted, ref } from "vue"
import { $AppAxios } from "@/utils/axiosSingleton";
import { useAuth } from '@/stores/auth.store'
import Navbar from '@/components/navbar.vue'
import type { Category, Material, ProductResponse } from "@/types/index"
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
const maxPrice = ref(0)
onMounted(async () => {
	$AppAxios.get('/api/category')
		.then((response) => {
			categories.value = response.data
	})
	$AppAxios.get('/api/product')
		.then((response) => {
			maxPrice.value = parseInt(response.data.reduce((max: number, item: ProductResponse) => {
				return (item.original.price > max) ? item.original.price : max
			}, 0))
	})
})
const nameValue = ref('')
const props = defineProps({
	withSearch :{
		type: Boolean,
		default: true
	}
})
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
Sidebar(:categories="categories" :price="maxPrice" :sidebarToggle="opened")
	div(:class="store.isAuth? 'lg:flex justify-between':''")
		div(class="flex justify-center items-center py-2 sm:py-4 px-2 bg-gray-50")
			slot(name="addBtn")
		div(v-if="withSearch" class="flex justify-center lg:justify-end items-center sm:py-4 px-2 bg-gray-50 z-10")
			div(class="flex items-center justify-between max-w-[30rem] bg-primary/5 px-1 sm:px-2 lg:px-4 py-0.5 sm:py-2 rounded-lg")
				input(type="text" @keyup.enter="$emit('NameSearched', {name: nameValue, type: selectedSearch})" v-model="nameValue" placeholder="Search for ..." class="bg-transparent text-sm sm:text-base md:text-lg outline-none border-none w-full")
				//- Icon(icon="tabler:search" class="text-3xl lg:text-4xl mx-2 text-primary cursor-pointer")
				select(v-if="storePage" class="dz-select" v-model="selectedSearch")
					option(value="product") Product
					option(value="company") Company
			Icon(:icon="icon" @click="clicked()" class="text-4xl text-primary cursor-pointer ml-4")
	div(class="shadow-md bg-gray-50 py-4 w-full h-fit min-h-[90vh]")
		slot(name="cards")
</template>