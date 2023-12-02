<script setup lang="ts">
const props = defineProps({
  materials: {
    type: Array,
    required: true
  },
  categories: {
    type: Array,
    required: true
  },
//   price: {
//     type: Number,
//     required: true
//   }
})
</script>
<template lang="pug">
div(class="lg:flex lg:items-center lg:bg-white lg:h-screen lg:overflow-hidden")
	div(class="lg:max-h-screen ltr:left-0 rtl:right-0 lg:shadow-xl lg:overflow-y-auto lg:h-screen lg:text-gray-600 lg:min-w-[20rem] lg:w-fit dz-drawer lg:dz-drawer-open")
		input(id="my-drawer" type="checkbox" class="dz-drawer-toggle")
		div(class="dz-drawer-content flex flex-col items-center justify-center")
			//- Normaly this div for page content (cards..) it should be placed here but i got some issues with it
			//- div.max-h-screen.h-full.w-full.overflow-y-auto
			//- 	slot
			label(for="my-drawer" class="lg:hidden") test 
		div(class="dz-drawer-side")
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
	//- Also in this place it gave me some issues as in the screen
	div.max-h-screen.h-full.w-full.overflow-y-auto
		slot
</template>