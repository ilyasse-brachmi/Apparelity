<script setup lang="ts">
import { computed, ref } from 'vue'
import type { Category } from "@/types/index"

const props = defineProps({
	categories: {
		type: Array<Category>,
		required: true
	},
	sidebarToggle: {
		type: Boolean,
		default: false
	},
	price: {
		type: Number,
		required: true
	}

})
const checked = ref(true)
const priceRange = ref(37)
const opened = computed(() => props.sidebarToggle)
defineEmits(['categorieClicked', 'priceClicked'])
</script>
<template lang="pug">
div(class="w-full dz-drawer lg:dz-drawer-open")
	input(id="my-drawer" type="checkbox" v-model="opened" class="dz-drawer-toggle")
	div(class="dz-drawer-content flex flex-col items-center justify-center")
		div.max-h-screen.h-full.w-full.overflow-y-auto
			slot
	div(class="dz-drawer-side min-w-[20rem] shadow-md")
		label(for="my-drawer" aria-label="close sidebar" class="dz-drawer-overlay")
		div(class="bg-white min-w-[20rem] shadow-md lg:pt-0 pt-24 h-full overflow-y-auto z-[999999]")
			div.flex.items-enter.justify-between.py-6.px-4.border-b-2
				p.text-xl.font-medium.text-gray-700 Filter 
				p(class="text-primary/70 cursor-pointer text-lg") Clear All
			.dz-collapse.dz-collapse-plus.text-primary
				input(type='checkbox' name='my-accordion-3' :checked="checked")
				.dz-collapse-title.text-xl.font-medium.border-b-2
					h1 Categories
				.dz-collapse-content
					ul
						li(v-for="(category, index) in categories" :key="index" @click="$emit('categorieClicked', {id: category.id, name: category.name})" class="p-4 cursor-pointer hover:bg-primary/10 duration-200 text-gray-600 hover:scale-x-105 hover:text-primary")
							h3(class="text-lg") {{ category.name }}
			.dz-collapse.dz-collapse-plus.text-primary
				input(type='checkbox' name='my-accordion-3' :checked="checked")
				.dz-collapse-title.text-xl.font-medium.border-b-2
					h1 Price
				.dz-collapse-content
					div(class="p-4")
						div(class="flex items-center justify-center gap-x-2")
							h3(class="py-4 text-gray-500") Price range : 
							h3.text-gray-500 {{ priceRange }} $
						input(type="range" min="0" :max="price" value="40" v-model="priceRange" @click="$emit('priceClicked', priceRange)" class="dz-range dz-range-primary")
</template>