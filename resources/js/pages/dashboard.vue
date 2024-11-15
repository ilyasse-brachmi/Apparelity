<script setup lang="ts">
import { LMap, LTileLayer } from "@vue-leaflet/vue-leaflet";
import "leaflet/dist/leaflet.css";
import ShowMaterials from "@/components/showMaterials.vue"
import StoreLayout from '@/layouts/storeLayout.vue'
import AppModal from "@/components/AppModal.vue"
import Card from "@/components/card.vue"
import { $AppAxios } from "@/utils/axiosSingleton"
import { useAuth } from "@/stores/auth.store"
import { onMounted, ref, watch } from 'vue'
import type { ProductResponse , ProductMaterial, Product, ForwardAdress } from "@/types/index"
import { getForwardAdress, getReverseAdress } from "@/composables/usegeoCodingAdress"
import Swal from 'sweetalert2'
import { getObjDepth } from "@/composables/useArrayDepth"
import { useAppa } from "@/stores/index.store"

const store = useAuth()
const data = ref([] as Array<ProductResponse>)

const nameSearched = ref('' as string)
const searchedName = (name: any)=>{
	nameSearched.value = name
}
onMounted(async () => {
	$AppAxios.get(`/api/product/${store.company.id}`)
	.then((response) => {
		data.value = response.data
	})
})
watch(nameSearched, () => {
  $AppAxios.get(`/api/product/${store.company.id}/search?product=${nameSearched.value}`)
  .then((response) => {
    data.value = response.data
  })
  .catch((e) => {
    if(e.response) {
      Swal.fire({
        text: e.response.data.error || 'Error !!',
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

const finalProduct = ref<ForwardAdress>({} as ForwardAdress)
const curProdMaterials = ref([] as ProductMaterial[]) 
const forwardAdress = ref([] as ForwardAdress[])
const currProduct = ref({} as Product)
const zoom = ref(3)
const center = ref([47.413220, -1.219482])
const minZoom = ref(2)
const modal = ref(false)
const getFAdress = async(data: ProductMaterial[]) => {
	data.forEach(async (marker, index) => {
    const forwardResult = ref({} as ForwardAdress)
    forwardResult.value = await getForwardAdress(marker.address!)
    forwardAdress.value.push(forwardResult.value)
		if(marker.children.length > 0) getFAdress(marker.children)
  })
}
const openModal = async(product: Product) => {
	currProduct.value = product
	await $AppAxios.get(`/api/material/${product.id}`)
	.then((response) => {
		curProdMaterials.value.push(response.data.data.product)
	})
	getFAdress(curProdMaterials.value)
	modal.value = true
	finalProduct.value = await getForwardAdress(curProdMaterials.value[0].address!)
}
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
const AppaStore = useAppa()
const filteredSet = new Set<String>([])
const filtredPrice = ref(0)
const filtredCategory = ref(0)
const filtredData = ref([] as ProductResponse[])
const foundedFilter = ref({filtred: null as boolean | null, criteria: filteredSet})
watch(
	() => AppaStore.filter,
	(newVal) => {
		AppaStore.isLoading = true
		setTimeout(() => {
			AppaStore.isLoading = false
		}, 200)
		if(typeof(newVal.category) == 'number' || typeof(newVal.price) == 'number'){
			filtredPrice.value = newVal.price !== null ? newVal.price : 0
			filtredCategory.value = newVal.category !== null ? (newVal.category as number) : 0
			if(foundedFilter.value.criteria.values.length){
				if(filtredCategory.value === 0) {
					filtredData.value =  filtredData.value.filter((item) => item.original.price <= filtredPrice.value)
				}
				else if(filtredPrice.value === 0) {
					filtredData.value =  filtredData.value.filter((item) => item.original.category_id === filtredCategory.value)
				}
				else{
					filtredData.value =  filtredData.value.filter((item) => item.original.category_id === filtredCategory.value && item.original.price <= filtredPrice.value)
				}
				foundedFilter.value.filtred = filtredData.value.length > 0 ? true : false
			}
			else{
				if(filtredCategory.value === 0) {
					filtredData.value =  data.value.filter((item) => item.original.price <= filtredPrice.value)
				}
				else if(filtredPrice.value === 0) {
					filtredData.value =  data.value.filter((item) => item.original.category_id === filtredCategory.value)
				}
				else{
					filtredData.value =  data.value.filter((item) => item.original.category_id === filtredCategory.value && item.original.price <= filtredPrice.value)
				}
				foundedFilter.value.filtred = filtredData.value.length > 0 ? true : false
			}
		}
		else{
			foundedFilter.value.filtred = null
			foundedFilter.value.criteria.clear()
		} 
			
	},
	{ deep: true }
)

const closeModal = () => {
	modal.value = false
	finalProduct.value = {} as ForwardAdress
	curProdMaterials.value = []
	forwardAdress.value = []
  getObjDepth([] as ForwardAdress[], {} as ForwardAdress, true)

}
</script>
<template lang="pug">
StoreLayout(@sortClicked="sorting" @NameSearched="searchedName")
  template(v-slot:addBtn)
    div(v-if="store.isAuth" class="flex items-center gap-x-16")
      a(href="/product"  class="border flex items-center gap-2 text-white border-white rounded-lg w-full py-4 px-4 bg-primary hover:shadow-md duration-300 cursor-pointer") 
        p(class="text-sm").font-semibold Add Product
        Icon(:icon="'gridicons:add-outline'" class="text-2xl")
      a(href="/store" class="text-primary text-lg duration-200 hover:underline") Store
  template(v-slot:cards)
    .flex.items-center.justify-center
      div(v-if="data.length || typeof(foundedFilter.filtred) === 'object'" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 py-8 h-full")
        div(v-for="product in (typeof(foundedFilter.filtred) === 'boolean' ? filtredData : data)" :key="product.original.id")
          Card(:product="product.original" @openModal="openModal(product.original)")
        AppModal(v-if="modal" :title="'Product Traceability'" @close="closeModal")
          div(class="grid grid-cols-5 w-full h-full bg-gray-100 ")
            div(class="col-span-2 h-full")
              div(class="w-full p-6 py-6")
                div(class="min-h-[48.7rem]")
                  div(class="flex justify-center")
                    div(class="w-[15rem] h-[15rem] rounded-full p-2 shadow-md mb-4 border")
                      img(:src="`/storage/public/${currProduct.product_image.split('public/')[1]}`" class="w-full h-full rounded-full")
                  div(class="px-4")
                    h1(class="text-primary text-center font-semibold text-xl") {{ currProduct.name }}
                    div(class="flex items-center justify-center py-2")
                      h3(class="px-2 py-1 bg-primary/20 text-sm text-primary rounded-full w-fit") {{ currProduct.company_name }}
                  div(class="flex justify-center h-full")
                    ul(class="w-fit h-fit min-w-[25rem] bg-white shadow-md rounded-xl border-4 my-4 px-2 border-primary/20 overflow-auto max-h-[32rem]")
                      li(v-if="forwardAdress.length" v-for="(item, index) in forwardAdress" :key="index" class="bg-gray-100 w-full cursor-pointer hover:bg-primary/10 duration-200 rounded-lg h-fit p-4 my-2")
                        div(class="flex items-center justify-between")
                          div(class="flex items-center gap-x-2")
                            h1(v-if="item.components" class="text-xl font-medium") {{ item.components.country }}
                            p(v-if="item.annotations" class="text-xl") {{ item.annotations.flag }}
                          div(v-if="item.formatted === finalProduct.formatted" class="")
                            p(class="text-primary text-xs bg-primary/10 px-2 py-1 border border-primary rounded-full whitespace-nowrap") Product
                        p(v-if="item.formatted" class="text-gray-500 text-sm") {{ item.formatted }}
                      div(v-else class="w-full h-full min-w-[17rem] min-h-[27rem] flex items-center justify-center bg-white")
                        span(class="dz-loading dz-loading-infinity w-[10rem] text-primary")
            div(class="col-span-3")
              //- Exemple
              div(ref="mapContainer" class="h-full flex items-center justify-center")
                div(class="w-full h-full")
                  LMap(:useGlobalLeaflet="false" ref="map" v-model:zoom="zoom" :center="center")
                    LTileLayer(url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" layer-type="base" name="OpenStreetMap" :minZoom="minZoom")
                    ShowMaterials(:materials="curProdMaterials" :parent-material="'parent'" :image="`/storage/public/${currProduct.product_image.split('public/')[1]}`")
      div(v-if="!data.length || foundedFilter.filtred === false" class="h-screen flex flex-col items-center pt-[10rem]")
        p(class="text-xl tracking-wide font-bold") Opps... It's empty in here 
        p(class="text-base text-slate-500") No offers hase been saved yet.
</template>	