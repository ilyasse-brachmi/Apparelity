<script setup lang="ts">
import Product from "../../images/jacket.png"
import Sidebar from "@/components/sidebar.vue";
import Card from "@/components/card.vue";
import StoreLayout from '@/layouts/storeLayout.vue';
</script>
<template lang="pug">
StoreLayout
	.flex.items-center.justify-center
		div(class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 p-8")
			Card(:imageProduct="Product" :productName="'Jacket'" :companyName="'Example Company Name Nike'" :price="'199'")
			Card(:imageProduct="Product" :productName="'Jacket'" :companyName="'Example Company Name Nike'" :price="'199'")
			Card(:imageProduct="Product" :productName="'Jacket'" :companyName="'Example Company Name Nike'" :price="'199'")
			Card(:imageProduct="Product" :productName="'Jacket'" :companyName="'Example Company Name Nike'" :price="'199'")
			Card(:imageProduct="Product" :productName="'Jacket'" :companyName="'Example Company Name Nike'" :price="'199'")
</template>