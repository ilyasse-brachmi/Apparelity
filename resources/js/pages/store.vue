<script setup lang="ts">
import Product from "../../images/jacket.png"
import Sidebar from "@/components/sidebar.vue";
import Card from "@/components/card.vue";
import StoreLayout from '@/layouts/storeLayout.vue';


</script>
<template lang="pug">
StoreLayout
    div(class="grid grid-cols-4 gap-4 p-8")
        Card(:imageProduct="Product" :productName="'Jacket'" :companyName="'Example Company Name Nike'" :price="'199'")
</template>