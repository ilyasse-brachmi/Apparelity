<script setup lang="ts">
import AppModal from "@/components/AppModal.vue"
import Card from "@/components/card.vue"
import StoreLayout from '@/layouts/storeLayout.vue'
import { onMounted, ref, watch } from "vue"
import ImageProduct from "../../images/jacket.png"
import type { ProductResponse , ProductMarker, ProductMaterial, ReverseAdress } from "@/types/index"
import { $AppAxios } from "@/utils/axiosSingleton";
import { LMap, LTileLayer, LMarker, LPopup, LPolyline } from "@vue-leaflet/vue-leaflet";
import "leaflet/dist/leaflet.css";
import ShowMaterials from "@/components/showMaterials.vue"
import { materials } from "@/data/products.data"
import { getReverseAdress } from "@/composables/useReverseAdress"
import Swal from "sweetalert2"
import router from "@/routes"



const modal = ref(false)

const openModal = (index: number) => {
	currProduct.value = data.value.find((product: ProductResponse) => product.original.id === index )
	modal.value = true
}

const nameSearched = ref('' as string)
const selectedSearch = ref('product')
const searchedName = (name: any,type: any)=>{
	selectedSearch.value = type
	nameSearched.value = name
}
const nameFromRoute = ref()
const typeFromRoute = ref()
nameFromRoute.value = router.currentRoute.value.query.name
typeFromRoute.value=router.currentRoute.value.query.type
watch(nameSearched, () => {
	$AppAxios.get(`/api/product/search?${selectedSearch.value}=${nameSearched.value}`)
	.then((response) => {
		data.value = response.data
	})
	.catch((e) => {
		if(e.response) {
			Swal.fire({
				text: e.response.data.message || 'Error !!',
				icon: 'error',
				toast: true,
				position: 'top-end',
				timer: 3000,
				showConfirmButton: false
			})
		}
	}
	)
})
const data = ref([] as Array<ProductResponse>)

onMounted(async () => {
	if(nameFromRoute.value && typeFromRoute.value) {
		$AppAxios.get(`/api/product/search?${typeFromRoute.value}=${nameFromRoute.value}`)
		.then((response) => {
			data.value = response.data
		})
		.catch((e) => {
			if(e.response) {
				Swal.fire({
					text: e.response.data.message || 'Error !!',
					icon: 'error',
					toast: true,
					position: 'top-end',
					timer: 3000,
					showConfirmButton: false
				})
			}
		}
		)
	}
	else{
		$AppAxios.get('/api/product')
		.then((response) => {
			data.value = response.data
		})
	}
	getAllCoordonates(materials.value)
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

const reverseAdress = ref([] as Array<ReverseAdress[]>)

const lat = materials.value[0].coordonates[0]
const lang = materials.value[0].coordonates[1]

watch(
	() => modal.value,
	async(newVal) => {
		if(newVal === true){
			coordonatesQueries.forEach(async element => {	
				const result = await getReverseAdress(element[0][0] as number, element[0][1] as number)
				if(result)
					reverseAdress.value.push(result)
			})
		}
	}
)
const coordonatesQueries: Array<[string | [number, number], ProductMaterial]> = []

const getAllCoordonates = (data: ProductMaterial[]) => {
	data.forEach(element => {
		coordonatesQueries.push([element.coordonates, element])
		if(element.children.length > 0) getAllCoordonates(element.children)
	});
}


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

const closeModal = () => {
	modal.value = false
	while (reverseAdress.value.length > 0) {
  reverseAdress.value.pop();
}
}
</script>
<template lang="pug">
StoreLayout(@NameSearched="searchedName" @sortClicked="sorting")
	template(v-slot:cards)
		.flex.items-center.justify-center.h-full.w-full
			div(v-if="data.length" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 py-8 h-full")
				div(v-for="product in data" :key="product.original.id")
					Card(:product="product.original" @openModal="openModal(product.original.id)")
				AppModal(v-if="modal" :title="'Product Traceability'" @close="closeModal")
					div(class="grid grid-cols-5 w-full h-full bg-gray-100 ")
						div(class="col-span-2 h-full")
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
										ul(class="w-fit h-fit min-w-[17rem] min-h-[27rem] bg-white shadow-md rounded-xl border-4 my-4 px-2 border-primar overflow-auto max-h-[32rem]")
											li(v-if="reverseAdress.length" v-for="(item, index) in reverseAdress" :key="index" class="bg-gray-100 w-full cursor-pointer hover:bg-primary/10 duration-200 rounded-lg h-full p-4 my-2")
												div(class="flex items-center justify-between")
													div(class="flex items-center gap-x-2")
														h1( class="text-xl font-medium") {{ item[0].components.country }}
														p(class="text-xl") {{ item[0].annotations.flag }}
													div(v-if="Math.floor(item[0].geometry.lat) === Math.floor(materials[0].coordonates[0]) && Math.floor(item[0].geometry.lng) === Math.floor(materials[0].coordonates[1])" class="")
														p(class="text-primary text-xs bg-primary/10 px-2 py-1 border border-primary rounded-full whitespace-nowrap") Product
												p(class="text-gray-500 text-sm") {{ item[0].formatted }}
											div(v-else class="w-full h-full min-w-[17rem] min-h-[27rem] flex items-center justify-center bg-white")
												span(class="dz-loading dz-loading-infinity w-[10rem] text-primary")
						div(class="col-span-3")
							//- Exemple
							div(ref="mapContainer" class="h-full flex items-center justify-center")
								div(class="w-full h-full")
									LMap(:useGlobalLeaflet="false" ref="map" v-model:zoom="zoom" :center="center")
										LTileLayer(url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" layer-type="base" name="OpenStreetMap" :minZoom="minZoom")
										div(v-for="(marker, index) in materials" :key="index")
											ShowMaterials(:materials="materials" :parent-material="'parent'" :image="`/storage/public/${currProduct.original.product_image.split('public/')[1]}`")
			div(v-else class="h-screen flex flex-col items-center pt-[10rem]")
				p(class="text-2xl tracking-wide font-semibold") Opps... It's empty in here 
				p(class="text-base text-slate-500") No offers hase been saved yet.
</template>
