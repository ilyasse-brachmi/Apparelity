<script setup lang="ts">
import { ref, computed } from 'vue';
import type { PropType } from 'vue';
import Nested from './nested.vue';

interface Material {
  id: number;
  order: number;
  name: string;
  children: Material[];
  opened: boolean;
}

defineProps({
  materials: {
    type: Array as PropType<Material[]>,
    required: true,
  },
});
// const materials = computed<Material[]>(() => [
//   {
//     id: 1,
//     name: "first",
//     children: []
//   }
// ])
// const addMaterial = (material: Material) => {
//   materials.value.forEach(element => {
//     if(element.id === material.id)
//       element.children.push(material)
//   });
//   console.log(materials.value)
// }
const emits = defineEmits(['itemAdded'])
// const created = ref<boolean[]>([])
// const addInput = (id: number) => {
//   created.value[id] = true
//   // emits('addInput', id)
// }
const test = ref<string[]>([])
const addItems = (material: Material) => {
  emits('itemAdded', material)
}
</script>

<template lang="pug">
//- div(v-for="material in materials" :key="material.name" )
//-   div(class="m-10")
//-     h1() {{ material.name }}
//-     input(type="text" v-model="material.name" class="border")
//-     div(class="ml-10")
//-       Nested(:materials="material.children")
//- input(type="text" v-model="curMaterial" class="border")
div(v-for="(item,index) in materials" :key="index")
  div(class="flex items-center gap-x-10")
    h1 {{ item.id }} {{ item.order }}
    h1 {{ item.name }} {{ index }}
    input(v-if="item.opened" type="text" v-model="test[index]" class="border")
    div(class="flex items-center justify-center gap-2 text-white")
      button(type="button" class="p-4 bg-primary rounded-lg" @click="item.opened = true") Add Material
      button(type="button" class="p-4 bg-primary rounded-lg" @click="addItems({id: index, order: item.order, name: test[index], opened: false, children: []})") {{ index }} {{ item.order }} {{ test[index] }} 
  div(class="ml-10")
    Nested(v-if="item.children.length" :materials="item.children")
</template>