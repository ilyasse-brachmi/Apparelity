<script setup lang="ts">
import { reactive, ref, computed, watch } from 'vue';
import Nested from '@/components/nested.vue';
import { useMaterial } from '@/stores/material.store';
import AppModal from '@/components/AppModal.vue';
import AppInput from '@/components/AppInput.vue';

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
  (newVal) => addMaterial(newVal as Material) 
)



const addMaterial = (material: Material, array = [...materials.value] as Material[]) => {
  opened.value = false
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
const opened = ref(false)
</script>

<template lang="pug">
div(class="my-20")
  button(@click="getData") Get data
  p(v-if="data") {{ data }}
div(v-for="item in materials" :key="item.id" class="w-screen h-screen flex flex-col items-center justify-center m-4")
  AppModal(v-if="opened" :title="'Materials'" @close="opened = false")
    div(class="p-12")
      AppInput(:labelName="'Name'" name="name" :type="'text'" v-model="test" :color="'#1d6795'")
      div(class="flex items-center justify-end my-8")
        button(type="button" class="bg-primary text-white p-4 rounded-lg" @click="addMaterial({id: item.id, order: item.order, name: test, opened: false, trace: item.trace , children: []})") Submit
  div(class="flex items-center justify-center gap-x-6")
    h1 {{ item.name }}
    //- input(v-if="item.opened" type="text" v-model="test" class="border")
    div(class="flex items-center justify-center gap-2 text-white")
      Icon(icon="carbon:add-filled" class="text-primary text-4xl cursor-pointer" @click="opened = true")
      //- button(type="button" class="px-4 py-2 bg-primary rounded-lg") Submit
  div(class="ml-40")
    Nested(v-if="item.children?.length" :materials="item.children")
</template>