<script setup lang="ts">
import MainLayout from './mainLayout.vue';
import Sidebar from "../components/sidebar.vue";

</script>
<template lang="pug">
MainLayout
	div(class="flex items-center")
		Sidebar
		slot
</template>