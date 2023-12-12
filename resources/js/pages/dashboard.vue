<script setup lang="ts">
import StoreLayout from '@/layouts/storeLayout.vue'
import AppModal from "@/components/AppModal.vue"
import Exemple from "@/pages/exemple.vue"
import Product from "../../images/jacket.png"
import Card from "@/components/card.vue"
import AppInput from '@/components/AppInput.vue'
import { $AppAxios } from "@/utils/axiosSingleton"
import { useAuth } from "@/stores/auth.store"
import { useRouter } from "vue-router"
import { computed, onMounted, ref, watch } from 'vue'
import { useField, useForm } from 'vee-validate'
import * as yup from 'yup'
import Swal from "sweetalert2"
import type { ProductResponse, Category } from "@/types/index"

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

const selectedFile = ref(null)
const imageUrl = ref(null)
const onFileSelected = (event) => {
  // const file = event.target.files[0];
  selectedFile.value = event.target.files[0];
  //     if (file) {
  //       // Use FileReader to preview the image
  //       const reader = new FileReader();
  //       reader.onload = () => {
  //         imageUrl.value = reader.result;
  //       };
  //       reader.readAsDataURL(file);
  //       selectedFile.value = file
  //       console.log(selectedFile.value)
  // }
}

const date = ref<String>('')
console.log(date.value)
const addProductSubmit = handleSubmit(async () => {
  const formData = new FormData();

  formData.append('name', name.value)
  formData.append('price', price.value)
  formData.append('description', description.value)
  formData.append('company_id', JSON.stringify(store.user.company.id))
  if(selectedFile.value)
    formData.append('image_product', selectedFile.value);
  console.log(selectedFile.value)
  formData.append('production_date', date.value)
  formData.append('category_id', selectedCategory.value)

  console.log([...formData.entries()]);

   await $AppAxios.post('/api/product', formData)
   .then(async (response) => {
      Swal.fire({
      text: 'Your Product is added successfuly!',
      icon: 'success',
      toast: true,
      position: 'top-end',
      timer: 3000,
      showConfirmButton: false,
    })
    await getProducts()
    addModal.value = false
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
     })
})

const data = ref([] as Array<ProductResponse>)

const getProducts = async() => {
  $AppAxios.get('/api/product')
	.then((response) => {
		data.value = response.data
	})
}

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
</script>
<template lang="pug">
StoreLayout
  template(v-slot:addBtn)
    div(v-if="store.isAuth")
      button(class="border flex items-center gap-2 text-white border-white rounded-lg w-full py-4 px-4 bg-primary hover:shadow-md duration-300 cursor-pointer" @click="openAddModal()") 
        p.text-xl.font-semibold Add New Product
        Icon(:icon="'gridicons:add-outline'" class="text-2xl")
      AppModal(v-if="addModal" :title="'Add New Product'" @close="addModal = false")
        div(class="flex items-center justify-center h-full")
          form(method="POST" @submit.prevent="addProductSubmit" class="flex-col items-center justify-center px-4")
            div(class="grid grid-cols-2 gap-4")
              div(class="mt-8")
                AppInput(:labelName="'Product Name'" name="name" :type="'text'" :color="'#1d6795'" @input="nameError" :inputError="errors.name")
              div(class="mt-8")
                AppInput(:labelName="'Product Description'" name="description" :type="'text'" :color="'#1d6795'" @input="descriptionError" :inputError="errors.description")
              div(class="mt-8")
                AppInput(:labelName="'Price'" name="price" :type="'text'" :color="'#1d6795'" :icon="'healthicons:dollar'" @input="priceError" :inputError="errors.price")
              div(class="mt-8")
                AppInput(:labelName="'Material'" name="material" :type="'text'" :color="'#1d6795'")
              div(class="mt-8")
                input(type="text" v-model="store.user.company.name" class="p-4 w-full border rounded-lg border-primary bg-gray-100 text-gray-500" disabled)
              div(class="mt-2")
                label(class="px-2 text-primary text-xs") Production date
                input(type="date" v-model="date" class="w-full p-2 h-[3.6rem] min-h-[3.6rem] cursor-pointer border border-primary rounded-lg")
              div(class="mt-8")
                select(class="dz-select dz-select-bordered w-full h-[3.6rem] min-h-[3.6rem]" v-model="selectedCategory")
                  option(disabled value="") Select category
                  option(v-for="category in categories" :key="category.id" :value="category.id") {{ category.name }}
              div(class="mt-8 flex items-end")
                input(type="file" name="image" @change="onFileSelected($event)" class="dz-file-input dz-file-input-bordered dz-file-input-primary w-full max-w-xs")
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