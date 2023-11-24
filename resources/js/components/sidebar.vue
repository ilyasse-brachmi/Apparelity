<script setup lang="ts">
const categories = {1:'Headwear', 2:'Shoes', 3:'Bags', 4:'Clothes'};
const materials = {1:'Cotton', 2:'Leather', 3:'Linen', 4:'Nylon'};
defineProps(['categories','price', 'materials'])
</script>
<template lang="pug">
aside(class="overflow-y-auto h-screen duration-200 ltr:left-0 rtl:right-0 shadow-xl bg-white")
	div(class="text-gray-600 min-w-[20rem] h-full w-fit duration-200")
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