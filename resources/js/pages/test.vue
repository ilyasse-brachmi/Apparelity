<script setup lang="ts">
import { reactive, ref, computed, watch } from 'vue';
import Nested from '@/components/nested.vue';
import { useMaterial } from '@/stores/material.store';

interface Material {
  id: number;
  trace: string;
  order: number;
  name: string;
  children: Material[];
  opened: boolean;

}

const store = useMaterial()

watch(
  () => store.material,
  (newVal) => addMaterial(newVal) 
)

const materials = ref<Material[]>([
  {
    id: 0,
    order: 1,
    trace: '01',
    name: "first",
    opened: false,
    children: [
      // {
      //   id: 0,
      //   order: 2,
      //   trace: '0102',
      //   name: "second",
      //   opened: false,
      //   children: [
      //   ]
      // },
      // {
      //   id: 1,
      //   order: 2,
      //   trace: '0112',
      //   name: "second2",
      //   opened: false,
      //   children: []
      // }
    ]
  }
])

const addMaterial = (material: Material, array = [...materials.value] as Material[]) => {
  console.log(material)
  if (array.length) {
    array.forEach(element => {
      if (element.trace === material.trace) {
          console.log(element.trace + '---' + material.trace)
          element.children.push({ id: element.children.length, order: material.order + 1, name: material.name, children: material.children, opened:material.opened, trace: material.trace + element.children.length + (material.order + 1) })
      }
      else {
        console.log('elese')
        if (element.children.length) {
          console.log('3ndo')
          addMaterial(material, element.children)
        }
        else {
          console.log('ma3ndo')
          console.log(element.trace + '---' + material.trace)
          // element.children.push({ id: element.children.length, order: material.order + 1, name: material.name, children: material.children, opened:material.opened, trace: material.trace + element.children.length + (material.order + 1)  })
        }
      }
    });
  }
  else console.log('aaaaaaaa')
  // console.log(materials)
}

watch(
  () => materials.value,
  (newVal) => materials.value = newVal,
  { deep: true }
)
const data = ref([] as Material[])
const getData = () => {
  data.value = materials.value
}
const test = ref('')
</script>

<template lang="pug">
div(class="my-20")
  button(@click="getData") Get data
  p(v-if="data") {{ data }}
div(v-for="item in materials" :key="item.id" class="w-screen h-screen flex items-center justify-center")
  div
    h1 {{ item.name }}
    input(v-if="item.opened" type="text" v-model="test" class="border")
    div(class="flex items-center justify-center gap-2 text-white")
      button(type="button" class="p-4 bg-primary rounded-lg" @click="item.opened = true") Add Material
      button(type="button" class="p-4 bg-primary rounded-lg" @click="addMaterial({id: item.id, order: item.order, name: test, opened: false, trace: item.trace , children: []})") {{ item.trace }}
    div(class="ml-20")
      Nested(v-if="item.children?.length" :materials="item.children")
</template>