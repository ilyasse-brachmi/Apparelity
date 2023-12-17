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
const addItems = (material: ProductMaterial) => {
  store.setCurrentMaterial(material)
}

const checked = ref(false)
</script>

<template lang="pug">
div(v-for="(item,index) in materials" :key="index")
  div(class="flex items-center gap-x-10")
    Icon(icon="ci:arrow-sub-down-right" class="text-primary text-7xl ")
    h1(class="whitespace-nowrap text-primary font-semibold") {{ item.name }}
    .dz-collapse.dz-collapse-arrow.bg-gray-50(@click="checked = !checked")
      input(type='radio' name='my-accordion-2' :checked='checked')
      .dz-collapse-title.text-xl.font-medium
        AppInput(:type="'text'" :labelName="'Material name'" :color="'#1d6795'" v-model="test[index]")
      .dz-collapse-content
        
        h1 Adress 
        h1 Adress 
        h1 Adress 
        h1 Adress
    //- input(v-if="item.opened" type="text" v-model="test[index]" class="border")
    div(class="flex items-center justify-center gap-2 text-white")
      //- Icon(icon="carbon:add-filled" class="text-primary text-3xl cursor-pointer" @click="item.opened = true") Add Material
      button(v-if="test[index]" type="button" class="p-4 bg-primary rounded-lg" @click="addItems({id: index, order: item.order, name: test[index], opened: false, trace: item.trace, coordonates: '40/31', supplier: 'Apparelity', children: []})") Submit
  div(class="ml-20")
    Nested(v-if="item.children.length" :materials="item.children")
</template>