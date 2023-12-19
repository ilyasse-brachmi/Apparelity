<script setup lang="ts">
import AppModal from "@/components/AppModal.vue"
import Card from "@/components/card.vue"
import StoreLayout from '@/layouts/storeLayout.vue'
import { onMounted, ref, watch } from "vue"
import ImageProduct from "../../images/jacket.png"
import type { ProductResponse , ProductMarker } from "@/types/index"
import { $AppAxios } from "@/utils/axiosSingleton";
import { LMap, LTileLayer, LMarker, LPopup, LPolyline } from "@vue-leaflet/vue-leaflet";
import "leaflet/dist/leaflet.css";

const modal = ref(false)

const openModal = (index: number) => {
	currProduct.value = data.value.find((product: ProductResponse) => product.original.id === index )
	modal.value = true
}

const data = ref([] as Array<ProductResponse>)

onMounted(async () => {
	$AppAxios.get('/api/product')
	.then((response) => {
		data.value = response.data
	})
})
const productMarkers: Array<ProductMarker> = [
	{
		markerCoordonates: [47.413220, -1.219482],
		popUp: {
			title: 'Country',
			description: 'this is a description',
			image: ImageProduct
		}
	},
	{
		markerCoordonates: [18.413220, -5.219482],
		popUp: {
			title: 'Country',
			description: 'this is a description',
			image: ImageProduct
		}
	}
]
const currProduct = ref({} as ProductResponse)
const zoom = ref(3)
const center = ref([47.413220, -1.219482])
const minZoom = ref(2)
const typeSort = ref('' as string)
const sorting = (type: string)=>{
	typeSort.value = type
}
watch(
  () => typeSort.value,
  async (newVal) => {
    if (newVal) {
		if(newVal==='asc')
			data.value.sort((product: ProductResponse,product1: ProductResponse)=>product.original.price-product1.original.price)
		if(newVal==='desc')
			data.value.sort((product: ProductResponse,product1: ProductResponse)=>product1.original.price-product.original.price)
    }
  }
)
</script>
<template lang="pug">
StoreLayout(@sortClicked="sorting")
	template(v-slot:cards)
		.flex.items-center.justify-center.h-full.w-full
			div(v-if="data.length" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 py-8 h-full")
				div(v-for="product in data" :key="product.original.id")
					Card(:product="product.original" @openModal="openModal(product.original.id)")
				AppModal(v-if="modal" :title="'Product Traceability'" @close="modal = false")
					div(class="grid grid-cols-5 w-full h-full bg-gray-100 ")
						div(class="col-span-2")
							div(class="w-full p-6 py-6")
								div(class="min-h-[48.7rem]")
									div(class="flex justify-center")
										div(class="w-[15rem] h-[15rem] rounded-full p-2 shadow-md mb-4 border")
											img(:src="`/storage/public/${currProduct.original.product_image.split('public/')[1]}`" class="w-full h-full rounded-full")
									div(class="px-4")
										h1(class="text-primary text-center font-semibold text-xl") {{ currProduct.original.name }}
										div(class="flex items-center justify-center py-2")
											h3(class="px-2 py-1 bg-primary/20 text-sm text-primary rounded-full w-fit") {{ currProduct.original.company_name }}
									div(class="flex justify-center h-full")
										div(class="w-[24rem] h-[25rem] bg-white shadow-md rounded-xl border-4 my-4 border-primar")
						div(class="col-span-3")
							//- Exemple
							div(ref="mapContainer" class="h-full flex items-center justify-center")
								div(class="w-full h-full")
									LMap(:useGlobalLeaflet="false" ref="map" v-model:zoom="zoom" :center="center")
										LTileLayer(url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" layer-type="base" name="OpenStreetMap" :minZoom="minZoom")
										div(v-for="(marker, index) in productMarkers" :key="index")
											LMarker(:latLng="marker.markerCoordonates")
												LPopup(style="width: 15rem; height: 10rem;")
													div(class="w-[10rem] h-[8rem]")
														div(class="flex items-center justify-start gap-2")
															div(class="w-16 h-16 rounded-full border-2 border-black overflow-hidden")
																img(:src="marker.popUp.image" class="w-16 h-16 rounded-full")
															h1(class="font-semibold text-xl") {{ marker.popUp.title }}
														p {{ marker.popUp.description }}	
											LPolyline(:latLngs="[productMarkers[0].markerCoordonates, productMarkers[1].markerCoordonates]" :color="'hsl(0, 100%, 50%)'" :lineCap="'butt'")
			div(v-else class="h-screen flex flex-col items-center pt-[10rem]")
				p(class="text-2xl tracking-wide font-semibold") Opps... It's empty in here 
				p(class="text-base text-slate-500") No offers hase been saved yet.
</template>
