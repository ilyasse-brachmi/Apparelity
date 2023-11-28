<script setup lang="ts">
import MainLayout from './mainLayout.vue';
import Sidebar from "../components/sidebar.vue";

</script>
<template lang="pug">
MainLayout
	Sidebar()
		slot
</template>