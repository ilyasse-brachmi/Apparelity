<script setup lang="ts">
import Product from "../../images/jacket.png"
import Card from "@/components/card.vue";
import StoreLayout from '@/layouts/storeLayout.vue';
</script>
<template lang="pug">
StoreLayout
	div(class="flex justify-end items-center my-2 sm:my-4 mr-8 sm:mr-16")
		div(class="flex items-center justify-between max-w-[30rem] px-1 sm:px-2 lg:px-4 py-1 sm:py-2 border-2 border-primary rounded-full")
			input(type="text" placeholder="Search for a Product" class="bg-transparent px-4 py-2 text-sm sm:text-base md:text-lg outline-none border-none w-full")
			Icon(icon="tabler:search" class="text-2xl text-primary cursor-pointer")
		Icon(icon="iconoir:sort" class="text-4xl text-primary cursor-pointer ml-4")
	.flex.items-center.justify-center
		div(class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 p-8")
			Card(:imageProduct="Product" :productName="'Jacket'" :companyName="'Example Company Name Nike'" :price="199")
			Card(:imageProduct="Product" :productName="'Jacket'" :companyName="'Example Company Name Nike'" :price="199")
			Card(:imageProduct="Product" :productName="'Jacket'" :companyName="'Example Company Name Nike'" :price="199")
			Card(:imageProduct="Product" :productName="'Jacket'" :companyName="'Example Company Name Nike'" :price="199")
			Card(:imageProduct="Product" :productName="'Jacket'" :companyName="'Example Company Name Nike'" :price="199")
</template>