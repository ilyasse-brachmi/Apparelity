<script setup lang="ts">
import AppModal from "@/components/AppModal.vue";
import Product from "../../images/jacket.png"
import Card from "@/components/card.vue";
import StoreLayout from '@/layouts/storeLayout.vue';
import { ref } from "vue";
import Exemple from "@/pages/exemple.vue"

const modal = ref(false)

const openModal = (index: number) => {
	modal.value = true
}
</script>
<template lang="pug">
StoreLayout
	div(class="flex justify-center lg:justify-end items-center my-2 sm:my-4 mr-8 sm:mr-16")
		div(class="flex items-center justify-between max-w-[30rem] px-1 sm:px-2 lg:px-4 py-1 sm:py-2 border-2 border-primary rounded-full")
			input(type="text" placeholder="Search for a Product" class="bg-transparent px-4 py-2 text-sm sm:text-base md:text-lg outline-none border-none w-full")
			Icon(icon="tabler:search" class="text-3xl lg:text-4xl mx-2 text-primary cursor-pointer")
		Icon(icon="iconoir:sort" class="text-4xl text-primary cursor-pointer ml-4")
	.flex.items-center.justify-center
		div(class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 p-8")
			div(v-for="index in 6" :key="index")
				Card(:imageProduct="Product" :productName="'Jacket'" :companyName="'Example Company Name Nike'" :price="199" @openModal="openModal(index)")
	AppModal(v-if="modal" :title="'Product Traceability'" @close="modal = false")
		div(class="grid grid-cols-5 w-full h-full")
			div(class="col-span-2")
				div(class="bg-gray-100 w-full p-6 py-6")
					div(class="min-h-[48.7rem]")
						div(class="px-4")
							h1(class="text-primary font-semibold text-xl") Jacket
						div(class="flex justify-center")
							div(class="w-[24rem] h-[20rem] bg-white shadow-md rounded-xl border-4 my-4 border-primar")
						div(class="flex justify-center h-full")
							div(class="w-[24rem] h-[25rem] bg-white shadow-md rounded-xl border-4 my-4 border-primar")
						//- img(:src="Product" class="w-full h-[27rem]")
			div(class="col-span-3")
				Exemple
</template>