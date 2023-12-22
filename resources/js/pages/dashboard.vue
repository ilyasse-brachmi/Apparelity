<script setup lang="ts">
import StoreLayout from '@/layouts/storeLayout.vue'
import AppModal from "@/components/AppModal.vue"
import Exemple from "@/pages/exemple.vue"
import Card from "@/components/card.vue"
import AppInput from '@/components/AppInput.vue'
import { $AppAxios } from "@/utils/axiosSingleton"
import { useAuth } from "@/stores/auth.store"
import { onMounted, ref, watch } from 'vue'
import type { ProductResponse, Category } from "@/types/index"
import Swal from 'sweetalert2'

const store = useAuth()
const data = ref([] as Array<ProductResponse>)

const getProducts = async() => {
  $AppAxios.get(`/api/product/${store.company.id}`)
	.then((response) => {
		data.value = response.data
	})
}

const nameSearched = ref('' as string)
const searchedName = (name: any)=>{
	nameSearched.value = name
}
watch(nameSearched, () => {
	$AppAxios.get(`/api/product/${store.company.id}/search/product=${nameSearched.value}`)
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
onMounted(async () => {
	getProducts()
})

const modal = ref(false)
const openModal = (index: number) => {
	modal.value = true
}

const addModal = ref(false)
const openAddModal = () => {
	addModal.value = true
}
const selectedCategory = ref('')
const categories = ref([] as Category[])
watch(
  () => addModal.value,
  async (newVal) => {
    if (newVal) {
      await $AppAxios.get('/api/category')
      .then((response: { data: Category[]}) => categories.value = response.data)
    }
  }
)
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
StoreLayout(@sortClicked="sorting" @NameSearched="searchedName")
  template(v-slot:addBtn)
    div(v-if="store.isAuth")
      a(href="/product"  class="border flex items-center gap-2 text-white border-white rounded-lg w-full py-4 px-4 bg-primary hover:shadow-md duration-300 cursor-pointer") 
        p(class="text-sm").font-semibold Add Product
        Icon(:icon="'gridicons:add-outline'" class="text-2xl")
      AppModal(v-if="addModal" :title="'Add New Product'" @close="addModal = false")
        //- Material(:name="testName")
        //- div(class="flex items-center justify-center h-full py-8")
        //-   form(method="POST" @submit.prevent="addProductSubmit" class="h-full flex-col items-center justify-center px-8")
        //-     div(class="w-full flex items-center justify-center")
        //-       label(class="flex items-center flex-col gap-3" for="product_image")
        //-         img(v-if="imageUrl" :src="imageUrl" class="w-40 h-40 cursor-pointer rounded-full p-2 border")
        //-         input(type="file" name="image" @change="onFileSelected($event)" id="product_image" class="hidden")
        //-         p(class="text-center") {{ selectedFile ? selectedFile.name :  "Here Your product image" }}
        //-         p(class="bg-primary/20 text-primary px-4 py-1 rounded-full text-sm") {{ store.company.name }}
        //-     div(class="grid grid-cols-1 md:grid-cols-2 gap-4")
        //-       div(class="mt-8")
        //-         AppInput(:labelName="'Product Name'" name="name" :type="'text'" :color="'#1d6795'" @input="nameError" :inputError="errors.name")
        //-       div(class="mt-8")
        //-         AppInput(:labelName="'Product Description'" name="description" :type="'text'" :color="'#1d6795'" @input="descriptionError" :inputError="errors.description")
        //-       div(class="mt-8")
        //-         AppInput(:labelName="'Price'" name="price" :type="'text'" :color="'#1d6795'" :icon="'healthicons:dollar'" @input="priceError" :inputError="errors.price")
        //-       div(class="mt-8")
        //-         AppInput(:labelName="'Material'" name="material" :type="'text'" :color="'#1d6795'")
        //-       div(class="mt-2")
        //-         label(class="px-2 text-primary text-xs") Production date
        //-         input(type="date" v-model="date" class="w-full p-2 h-[3.6rem] min-h-[3.6rem] cursor-pointer border border-primary rounded-lg")
        //-       div(class="mt-8")
        //-         select(class="dz-select dz-select-bordered w-full h-[3.6rem] min-h-[3.6rem]" v-model="selectedCategory")
        //-           option(disabled value="") Select category
        //-           option(v-for="category in categories" :key="category.id" :value="category.id") {{ category.name }}
        //-     div(class="flex justify-center mt-16")
        //-       button(type="submit" class="border font-bold text-2xl text-white border-white rounded-full px-16 sm:px-48 py-4 bg-primary hover:shadow-md duration-300") Add
  template(v-slot:cards)
    .flex.items-center.justify-center
      div(v-if="data.length" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 py-8 h-full")
        div(v-for="product in data" :key="product.original.id")
          Card(:product="product.original" @openModal="openModal(index)")
        AppModal(v-if="modal" :title="'Product Traceability'" @close="modal = false")
          div(class="grid grid-cols-5 w-full h-full")
            div(class="col-span-2")
              div(class="bg-gray-100 w-full p-6 py-6")
                div(class="min-h-[48.7rem]")
                  div(class="px-4")
                    h1(class="text-primary font-semibold text-xl") Jacket
                  div(class="flex justify-center")
                    div(class="w-[24rem] h-[20rem] bg-white shadow-md rounded-xl border-4 my-4 border-primar")
                  div(class="flex justify-center h-full")
                    div(class="w-[24rem] h-[25rem] bg-white shadow-md rounded-xl border-4 my-4 border-primar")
            div(class="col-span-3")
              Exemple
      div(v-else class="h-screen flex flex-col items-center pt-[10rem]")
        p(class="text-xl tracking-wide font-bold") Opps... It's empty in here 
        p(class="text-base text-slate-500") No offers hase been saved yet.
</template>	