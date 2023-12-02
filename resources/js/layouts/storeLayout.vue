<script setup lang="ts">
import MainLayout from './mainLayout.vue';
import Sidebar from "../components/sidebar.vue";
const categories = ['Headwear','Shoes','Bags','Clothes'];
const materials = ['Cotton','Leather','Linen','Nylon'];

</script>
<template lang="pug">
MainLayout
	Sidebar(:categories="categories" :materials="materials")
		slot
</template>