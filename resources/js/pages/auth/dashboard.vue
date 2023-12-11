<script setup lang="ts">
import StoreLayout from '@/layouts/storeLayout.vue'
import AppModal from "@/components/AppModal.vue"
import Exemple from "@/pages/exemple.vue"
import Product from "../../../images/jacket.png"
import Card from "@/components/card.vue"
import Input from '@/components/AppInput.vue'
import { $AppAxios } from "@/utils/axiosSingleton"
import { useAuth } from "@/stores/auth.store"
import { useRouter } from "vue-router"
import { computed, onMounted, ref } from 'vue'
import { useField, useForm } from 'vee-validate'
import * as yup from 'yup'
import Swal from "sweetalert2"
import type { ProductResponse } from "@/types/index"

const scheme = computed(() => {
  return yup.object({
    name: yup.string().required('Name is a required field'),
    price: yup.string().required('Price is a required field'),
    description: yup.string().required('Description is a required field'),
  })
})

const store = useAuth()
const router = useRouter()

const { errors, handleSubmit } = useForm({
  validationSchema: scheme
})

const {
  handleChange: nameError,
    value: name
} = useField<string>('name')

const {
  handleChange: priceError,
    value: price
} = useField<string>('price')

const {
  handleChange: descriptionError,
    value: description
} = useField<string>('description')

const selectedFile= ref()
const onFileSelected = ((event: UIEvent & { target: HTMLInputElement & { files: Array<string> } })=>{
  selectedFile.value = event.target.files[0];
})

const addProductSubmit = handleSubmit(async () => {
  const imageFile = new FormData();
  imageFile.append('image', selectedFile.value)
  const data = { 
    name: name.value,
    price: price.value,
    description: description.value,
    image: imageFile
   }
   await $AppAxios.post('/api/product', data)
   .then(async (response) => {
      store.fetchUser(response.data.token, response.data.user)
      Swal.fire({
      text: 'Your Product is added successfuly!',
      icon: 'success',
      toast: true,
      position: 'top-end',
      timer: 3000,
      showConfirmButton: false,
    })
    .then(function() {
        console.log('success')
     });
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
    console.log(e.response.data)
    }
     })
})

const data = ref([] as Array<ProductResponse>)

onMounted(async () => {
	$AppAxios.get('/api/product')
	.then((response) => {
		data.value = response.data
	})
})

const modal = ref(false)
const openModal = (index: number) => {
	modal.value = true
}

const AddModal = ref(false)
const openAddModal = () => {
	AddModal.value = true
}
</script>
<template lang="pug">
StoreLayout
  template(v-slot:addBtn)
    div(v-if="store.isAuth" class="flex justify-center lg:justify-end items-center p-6 px-10 bg-gray-50 z-10")
      button(class="border flex items-center font-bold text-lg text-white border-white rounded-lg w-full py-2 px-4 bg-primary hover:shadow-md duration-300" @click="openAddModal()") 
        p Add New Product
        //- Icon(:icon="'gridicons:add-outline'" class="text-white absolute end-4 top-4 text-3xl cursor-pointer")
      AppModal(v-if="AddModal" :title="'Add New Product'" @close="AddModal = false")
        div(class="flex items-center justify-center h-[90vh]")
          form(method="POST" @submit.prevent="addProductSubmit" class="flex-col items-center justify-center px-4")
            div(class="grid grid-cols-2 gap-4")
              div(class="mt-8")
                Input(:labelName="'Product Name'" name="name" :type="'text'" :color="'#1d6795'" @input="nameError" :inputError="errors.name")
              div(class="mt-8")
                Input(:labelName="'Product Description'" name="description" :type="'text'" :color="'#1d6795'" @input="descriptionError" :inputError="errors.description")
              div(class="mt-8")
                Input(:labelName="'Category'" name="category" :type="'text'" :color="'#1d6795'")
              div(class="mt-8")
                Input(:labelName="'Price'" name="price" :type="'text'" :color="'#1d6795'" :icon="'healthicons:dollar'" @input="priceError" :inputError="errors.price")
              div(class="mt-8")
                Input(:labelName="'Image'" name="image" :type="'file'" :color="'#1d6795'" @change="onFileSelected")
              div(class="mt-8")
                Input(:labelName="'Material'" name="material" :type="'text'" :color="'#1d6795'")
            div(class="flex justify-center mt-8")
              button(type="submit" class="border font-bold text-2xl text-white border-white rounded-full px-16 sm:px-48 py-4 bg-primary hover:shadow-md duration-300") Add
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