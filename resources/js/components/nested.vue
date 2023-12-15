<script setup lang="ts">
import { ref, computed } from 'vue';
import type { PropType } from 'vue';
import Nested from './nested.vue';
import { useMaterial } from '@/stores/material.store';

interface Material {
  id: number;
  order: number;
  trace: string;
  name: string;
  children: Material[];
  opened: boolean;
}

const store = useMaterial()

defineProps({
  materials: {
    type: Array as PropType<Material[]>,
    required: true,
  },
});
const test = ref<string[]>([])
const addItems = (material: Material) => {
  store.setCurrentMaterial(material)
}
</script>

<template lang="pug">
div(v-for="(item,index) in materials" :key="index")
  div(class="flex items-center gap-x-10")
    h1 {{ item.name }}
    input(v-if="item.opened" type="text" v-model="test[index]" class="border")
    div(class="flex items-center justify-center gap-2 text-white")
      button(type="button" class="p-4 bg-primary rounded-lg" @click="item.opened = true") Add Material
      button(type="button" class="p-4 bg-primary rounded-lg" @click="addItems({id: index, order: item.order, name: test[index], opened: false, trace: item.trace , children: []})") {{ item.trace }}
  div(class="ml-10")
    Nested(v-if="item.children.length" :materials="item.children")
</template>