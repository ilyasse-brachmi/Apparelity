<script setup lang="ts">
import { ref, type PropType, onMounted } from 'vue';
import type { ForwardAdress, ProductMaterial } from "@/types/index"
import { LMarker, LPopup, LPolyline, LCircleMarker } from "@vue-leaflet/vue-leaflet";
import { getForwardAdress } from "@/composables/usegeoCodingAdress"

declare type ParentMaterial = 'parent'

const props = defineProps({
  materials: {
    type: Array as PropType<ProductMaterial[]>,
    required: true
  },
  parentMaterial: {
    type: Array as PropType<[Number, Number]> || String as PropType<ParentMaterial>,
    default: {} as ProductMaterial
  },
  image: {
    type: String,
    required: false
  }
})

const forwardAdress = ref<ForwardAdress[]>([])

onMounted(async () => {
  props.materials.forEach(async (marker, index) => {
    const forwardResult = ref({} as ForwardAdress)
    forwardResult.value = await getForwardAdress(marker.address!)
    forwardAdress.value.push(forwardResult.value)
  })
})

</script>
<template lang="pug">
div(v-for="(marker, index) in forwardAdress" :key="index" class="")
  LCircleMarker(v-if="parentMaterial == 'parent' && marker.geometry" :latLng="[marker.geometry.lat, marker.geometry.lng]" :radius="23" :color="'orange'")
  LMarker(v-if="marker.geometry" :latLng="[marker.geometry.lat, marker.geometry.lng]")
    LPopup(style="width: 15rem; height: 10rem;")
      div(class="w-full h-full flex flex-col gap-4")
        div(class="flex items-center justify-start gap-x-2 w-full h-fit")
          div(v-if="image" class="w-16 h-16 min-h-16 min-w-16 rounded-full border-2 border-black overflow-hidden")
            img(:src="image" class="w-16 h-16 rounded-full")
          div(v-else class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center")
            Icon(icon="academicons:open-materials" class="text-5xl text-primary")
          div(class="flex flex-col justify-start max-w-[10rem]")
            h1(class="font-semibold text-xl !m-0 w-full text-primary") {{ materials[index].name }}
            div(v-if="marker" class="flex items-start justify-center gap-x-1 w-full text-base font-semibold")
              p(class="!m-0 truncate") {{ marker.components.country }}
              p(class="!m-0") {{ marker.annotations.flag }}
        div
          p(class="!m-0 font-semibold") {{ materials[index].supplier }}
          p(v-if="marker" class="!m-0 w-full text-gray-500") {{ marker.formatted }}
          div(class="flex items-center gap-x-2")
            p Lat : {{ marker.geometry.lat }}
            p Lang : {{ marker.geometry.lng }}
        //- p(v-else) Coordinates not available  
        LPolyline(v-if="parentMaterial !== 'parent' && parentMaterial" :latLngs="[parentMaterial, [marker.geometry.lat, marker.geometry.lng]]" :color="`hsl(0, 100%,50%)`" :lineCap="'butt'")
  showMaterials(:materials="materials[index].children" :parentMaterial="[marker.geometry.lat, marker.geometry.lng]")
</template>