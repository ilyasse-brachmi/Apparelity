<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps({
  materials: {
    type: Array,
    required: true
  },
  categories: {
    type: Array,
    required: true
  },
	sidebarToggle: {
		type: Boolean,
		default: false
	}

//   price: {
//     type: Number,
//     required: true
//   }
})
// defineProps(['modelValue'])
// defineEmits(['update:modelValue'])
const opened = computed(() => props.sidebarToggle)
</script>
<template lang="pug">
div(class="lg:max-h-screen w-full dz-drawer lg:dz-drawer-open")
	input(id="my-drawer" type="checkbox" v-model="opened" class="dz-drawer-toggle")
	div(class="dz-drawer-content flex flex-col items-center justify-center")
		div.max-h-screen.h-full.w-full.overflow-y-auto
			slot
	div(class="dz-drawer-side min-w-[20rem] shadow-md")
		label(for="my-drawer" aria-label="close sidebar" class="dz-drawer-overlay")
		div(class="bg-white min-w-[20rem] shadow-md lg:pt-0 pt-24 h-full z-[999999]")
			div.flex.items-enter.justify-between.p-4.border-b-2
				p.text-xl.font-semibold Filter 
				p(class="text-primary/70 mx-6 cursor-pointer text-lg") Clear All
			div.my-2.mx-4
				p(class="text-base sm:text-lg text-primary font-semibold") Categories
				ul(class="mt-2 ml-2")
					li(v-for="category in categories" class="hover:text-primary/70") {{ category }} 
			div.mx-4
				p(class="text-base sm:text-lg text-primary font-semibold") Price
				.range-input
					input(type='range' min='100' max='5000' value='3500' step='100')
			div.mx-4
				p(class="text-base sm:text-lg text-primary font-semibold") Materials
				ul(class="mt-2 ml-2")
					li(v-for="material in materials" class="hover:text-primary/70") {{ material }}
</template>