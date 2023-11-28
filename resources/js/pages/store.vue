<script setup lang="ts">
import Product from "../../images/jacket.png"
import StoreLayout from "../layouts/storeLayout.vue";
import Card from "../components/card.vue";

</script>
<template lang="pug">
StoreLayout
    Card(:imageProduct="Product" :productName="'Jacket'" :companyName="'Example Company Name Nike'" :price="'199'")
</template>