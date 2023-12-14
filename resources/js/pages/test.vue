<script setup lang="ts">
import { reactive, ref, computed, watch } from 'vue';
import Nested from '@/components/nested.vue';

interface Material {
  id: number;
  order: number;
  name: string;
  children?: Material[];
  opened: boolean;

}

const materials = ref<Material[]>([
  {
    id: 0,
    order: 1,
    name: "first",
    opened: false,
    children: [
      {
        id: 0,
        order: 2,
        name: "second",
        opened: false,
        children: [
          {
            id: 0,
            order: 3,
            name: "third",
            opened: false,
            children: [
              {
                id: 0,
                order: 4,
                name: "third",
                opened: false,
                children: []
              }
            ]
          }
        ]
      },
      {
        id: 1,
        order: 2,
        name: "second2",
        opened: false,
        children: []
      }
    ]
  }
])
// const addMaterial = (material: Material, array = materials) => {
//   console.log(material)
//   array.value.forEach(element => {
//     if(element.id === material.id)
//       element.children.push(material)
//     else if(element.children.length > 0) {
//       addMaterial(material, element.children)
//     }
//   });
//   console.log(materials.value)
// }
const addMaterial = (material: string) => {

  console.log(material)
  // materials.value.forEach(element => {
  //   if (element.id === material.id)
  //     element.children.push(material)
  //   else if (element.children.length > 0) {
  //     if (element.id === material.id)
  //       element.children.push(material)
  //     // addMaterial(material)
  //   }
  // });
  // console.log(materials.value)
}

// const addMaterial = (material: Material, array = [...materials.value] as Material[]) => {
//   if (array.length) {
//     array.forEach(element => {
//       if (element.order === material.order) {
//         if (element.id === material.id) {
//           element.children.push({ id: element.children.length, order: material.order + 1, name: material.name, children: material.children })
//         }
//       }
//       else {
//         console.log('elese')
//         if (element.children.length) {
//           console.log('3ndo')
//           console.log(element.children)
//           addMaterial(material, element.children)
//         }
//         else {
//           console.log('ma3ndo')
//           element.children.push({ id: element.children.length, order: material.order + 1, name: material.name, children: material.children })
//         }
//       }
//     });
//   }
//   else console.log('aaaaaaaa')
//   // console.log(materials)
// }

watch(
  () => materials.value,
  (newVal) => materials.value = newVal,
  { deep: true }
)
const curId = ref(0)
</script>

<template lang="pug">
div(v-for="item in materials" :key="item.id" class="w-screen h-screen flex items-center justify-center")
  div
    h1 {{ item.id }} {{ item.order }}
    h1 {{ item.name }}
    div(class="ml-20")
      Nested(v-if="item.children?.length" :materials="item.children" @itemAdded="addMaterial")
</template>