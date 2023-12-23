<script setup lang="ts">
import { ref, type PropType, onMounted } from 'vue';
import type { ProductMaterial } from "@/types/index"
import { LMarker, LPopup, LPolyline, LCircleMarker } from "@vue-leaflet/vue-leaflet";
import { getReverseAdress } from "@/composables/usegeoCodingAdress"
import type { ReverseAdress } from "@/types/index"

declare type ParentMaterial = 'parent'

const props = defineProps({
  materials: {
    type: Array as PropType<ProductMaterial[]>,
    required: true
  },
  parentMaterial: {
    type: Object as PropType<ProductMaterial | ParentMaterial>,
    default: {} as ProductMaterial
  },
  image: {
    type: String,
    required: false
  }
})

const reverseAdress = ref<Array<ReverseAdress[]>>([])

onMounted(() => {
  props.materials.forEach(async (marker, index) => {
    if (marker.coordonates[0] !== undefined && marker.coordonates[1] !== undefined) {
      reverseAdress.value[index] = await getReverseAdress(marker.coordonates[0] as number, marker.coordonates[1] as number)
    }
  })
  console.log("eeeeeeeee" + reverseAdress.value.length)
})

</script>
<template lang="pug">
div(v-for="(marker, index) in materials" :key="index" class="")
  LCircleMarker(v-if="parentMaterial == 'parent'" :latLng="marker.coordonates" :radius="23" :color="'orange'")
  LMarker(:latLng="marker.coordonates")
    LPopup(style="width: 15rem; height: 10rem;")
      div(class="w-full h-full flex flex-col gap-4")
        div(class="flex items-center justify-start gap-x-2 w-full h-fit")
          div(v-if="image" class="w-16 h-16 min-h-16 min-w-16 rounded-full border-2 border-black overflow-hidden")
            img(:src="image" class="w-16 h-16 rounded-full")
          div(v-else class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center")
            Icon(icon="academicons:open-materials" class="text-5xl text-primary")
          div(class="flex flex-col justify-start max-w-[10rem]")
            h1(class="font-semibold text-xl !m-0 w-full text-primary") {{ marker.name }}
            div(class="flex items-start justify-center gap-x-1 w-full text-base font-semibold")
              p(class="!m-0 truncate") {{ reverseAdress[index][0].components.country }}
              p(class="!m-0") {{ reverseAdress[index][0].annotations.flag }}
        div
          p(class="!m-0 font-semibold") {{ marker.supplier }}
          p(class="!m-0 w-full text-gray-500") {{ reverseAdress[index][0].formatted }}
        //- p(v-else) Coordinates not available  
        LPolyline(v-if="parentMaterial !== 'parent' && parentMaterial.coordonates" :latLngs="[parentMaterial.coordonates, marker.coordonates]" :color="`hsl(0, 100%, ${10 + (marker.order * 15)}%)`" :lineCap="'butt'")
  showMaterials(:materials="marker.children" :parentMaterial="marker")
</template>