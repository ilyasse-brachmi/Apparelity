<script setup lang="ts">
import { ref } from 'vue';
import type { PropType } from 'vue';
import Nested from './nested.vue';
import AppInput from '@/components/AppInput.vue'
import AppModal from '@/components/AppModal.vue'
import { useMaterial } from '@/stores/material.store';
import type { ProductMaterial } from "@/types/index"


const store = useMaterial()

defineProps({
  materials: {
    type: Array as PropType<ProductMaterial[]>,
    required: true,
  },
});
const test = ref<string[]>([])
const prodCoordonates = ref<string[]>([])
const prodSupliar = ref<string[]>([])
const addItems = (material: ProductMaterial) => {
  store.setCurrentMaterial(material)
}
const checked = ref(false)
</script>

<template lang="pug">
div(v-for="(item,index) in materials" :key="index")
  div(class="flex items-center gap-x-10 py-4")
    Icon(icon="ci:arrow-sub-down-right" class="text-primary text-7xl ")
    h1(class="whitespace-nowrap text-primary font-semibold") {{ item.name }}
    div(class="dz-collapse bg-gray-50")
      input(type="checkbox" v-model="checked")
      div(class="dz-collapse-title text-xl font-medium flex items-center")
        AppInput(:type="'text'" :labelName="'Material name'" :color="'#1d6795'" v-model="test[index]")
        Icon(icon="mingcute:down-line" :class="checked ? 'rotate-180' : ''" class="text-3xl text-primary ml-4")
      .dz-collapse-content
        AppInput(:type="'text'" :labelName="'Coordonates'" :color="'#1d6795'" v-model="prodCoordonates[index]" class="my-6")
        AppInput(:type="'text'" :labelName="'Suppliar'" :color="'#1d6795'" v-model="prodSupliar[index]" class="my-6")
    div(class="flex items-center justify-center gap-2 text-white")
      button(v-if="test[index]" type="button" class="p-4 bg-primary rounded-lg" @click="addItems({id: index, order: item.order, name: test[index], opened: false, trace: item.trace, coordonates: prodCoordonates[index], supplier: prodSupliar[index], children: []})") Submit
  div(class="ml-20")
    Nested(v-if="item.children.length" :materials="item.children")
</template>