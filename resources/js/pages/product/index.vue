<script setup lang="ts">
import Nested from '@/components/nested.vue';
import { useAuth } from "@/stores/auth.store"
import { useRouter } from "vue-router"
import * as yup from 'yup'
import { $AppAxios } from "@/utils/axiosSingleton"
import AppInput from '@/components/AppInput.vue'
import AppModal from '@/components/AppModal.vue'
import { useField, useForm } from 'vee-validate'
import { computed, onMounted, ref, watch } from 'vue'
import Swal from "sweetalert2"
import type { ProductMaterial, Category, AppProduct } from "@/types/index"
import Placeholder from "../../../images/placeholder.jpg"
import { useMaterial } from '@/stores/material.store';
import { removeProperties } from "@/composables/useFiltredObject"

const store = useAuth()
const router = useRouter()

const scheme = computed(() => {
  return yup.object({
    name: yup.string().required('Name is a required field'),
    address: yup.string().required('Address is a required field'),
    price: yup.number().typeError('Must be a number').required('Price is a required field'),
    description: yup.string().required('Description is a required field'),
  })
})

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
} = useField<number>('price')

const {
  handleChange: descriptionError,
  value: description
} = useField<string>('description')


const {
  handleChange: addressError,
  value: address
} = useField<string>('address')


const date = ref<String>('')

const selectedFile = ref(null)
const imageUrl = ref(Placeholder)


const onFileSelected = (event) => {
  selectedFile.value = event.target.files[0];

  if (selectedFile.value) {
    const reader = new FileReader();
    reader.onload = () => {
      imageUrl.value = reader.result;
    };
    reader.readAsDataURL(selectedFile.value);
  }
}

const addProductSubmit = async () => {
  const formData = new FormData();

  const materialResults = await getMaterials(materials.value)
  formData.append('name', name.value)
  formData.append('price', price.value)
  formData.append('description', description.value)
  formData.append('company_id', JSON.stringify(store.company.id))
  if (selectedFile.value)
    formData.append('image_product', selectedFile.value);
  formData.append('production_date', date.value)
  formData.append('address', address.value)
  formData.append('materials', JSON.stringify(materialResults))
  formData.append('category_id', selectedCategory.value)


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
      router.push('/dashboard')
    })
    .catch((e) => {
      if (e.response) {
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
}


const MaterailStore = useMaterial()

watch(
  () => MaterailStore.material,
  (newVal) => addMaterial(newVal as ProductMaterial)
)



const addMaterial = (material: ProductMaterial, array = [...materials.value] as AppProduct[]) => {
  opened.value = false
  if (array.length) {
    array.forEach(element => {
      if (element.trace === material.trace) {
        element.children.push({ id: material.id, order: material.order + 1, name: material.name, children: material.children, trace: material.trace + element.children.length + (material.order + 1), address: material.address, supplier: material.supplier })
      }
      else {
        if (element.children.length) {
          addMaterial(material, element.children)
        }
      }
    });
  }
}

const materials = ref<AppProduct[]>([
  {
    id: 0,
    category_id: 0,
    company_id: 0,
    description: '',
    image_product: '',
    price: 0,
    production_date: "2024-03-14",
    order: 1,
    trace: '01',
    name: "Final Product",
    address: '',
    supplier: '',
    opened: false,
    children: [
    ]
  }
])
watch(
  () => materials.value,
  (newVal) => {
    materials.value = newVal
  },
  { deep: true }
)

const opened = ref(false)
const content = ref('')
const newProd = ref<{Address: String, Supplier: String}>({Address: '', Supplier: ''})
const selectedCategory = ref(0)
const categories = ref([] as Category[])
const checked = ref(false)


const getMaterials = (array: AppProduct[]) => {
  array[0].children.forEach(element => {
    if(element)
      element = removeProperties(element, ['id', 'order', 'trace', 'opened'])
  });
  return array[0].children
}


onMounted(async () => {
  await $AppAxios.get('/api/category')
    .then((response: { data: Category[] }) => categories.value = response.data)
})
</script>
<template lang="pug">
div(class="flex items-center justify-center h-screen w-screen py-8")
  form(method="POST" @submit.prevent="addProductSubmit" class="h-full flex-col items-center justify-center px-8")
    div(class="w-full flex items-center justify-center")
      label(class="flex items-center flex-col gap-3" for="product_image")
        img(v-if="imageUrl" :src="imageUrl" class="w-40 h-40 cursor-pointer rounded-full p-2 border")
        input(type="file" name="image" @change="onFileSelected($event)" id="product_image" class="hidden")
        p(class="text-center") {{ selectedFile ? selectedFile.name :  "Here Your product image" }}
        p(class="bg-primary/20 text-primary px-4 py-1 rounded-full text-sm") {{ store.company.name }}
    div(class="grid grid-cols-1 md:grid-cols-2 gap-4")
      div(class="mt-8")
        AppInput(:labelName="'Product Name'" name="name" :type="'text'" :color="'#1d6795'" @input="nameError" :inputError="errors.name")
      div(class="mt-8")
        AppInput(:labelName="'Product Description'" name="description" :type="'text'" :color="'#1d6795'" @input="descriptionError" :inputError="errors.description")
      div(class="mt-8")
        AppInput(:labelName="'Price'" name="price" :type="'text'" :color="'#1d6795'" :icon="'healthicons:dollar'" @input="priceError" :inputError="errors.price")
      div(class="mt-8")
        AppInput(:labelName="'Address'" name="address" :type="'text'" :color="'#1d6795'" @input="addressError" :inputError="errors.address")
      div(class="mt-2")
        label(class="px-2 text-primary text-xs") Production date
        input(type="date" v-model="date" class="w-full p-2 h-[3.6rem] min-h-[3.6rem] cursor-pointer border border-primary rounded-lg")
      div(class="mt-8")
        select(class="dz-select dz-select-bordered w-full h-[3.6rem] min-h-[3.6rem]" v-model="selectedCategory")
          option(disabled value="") Select category
          option(v-for="category in categories" :key="category.id" :value="category.id") {{ category.name }}
    div(class="mt-8")
      div(v-for="item in materials" :key="item.id" class="flex flex-col gap-y-8 items-center justify-center")
        div(class="w-full flex items-center gap-x-4")
          h1(class="whitespace-nowrap text-primary font-semibold") {{ item.name }}
          div(class="dz-collapse bg-gray-50")
            input(type="checkbox" v-model="checked")
            div(class="dz-collapse-title text-xl font-medium flex items-center")
              AppInput(:type="'text'" :labelName="'Material name'" :color="'#1d6795'" v-model="content")
              Icon(icon="mingcute:down-line" :class="checked ? 'rotate-180' : ''" class="text-3xl text-primary ml-4")
            .dz-collapse-content
              AppInput(:type="'text'" :labelName="'Address'" :color="'#1d6795'" v-model="newProd.Address" class="my-6")
              AppInput(:type="'text'" :labelName="'Suppliar'" :color="'#1d6795'" v-model="newProd.Supplier" class="my-6")
          div(class="flex items-center justify-center gap-2 text-white")
            //- Icon(icon="carbon:add-filled" class="text-primary text-3xl cursor-pointer" @click="item.opened = true") Add Material
            button(v-if="content && newProd.Address && newProd.Supplier" type="button" class="p-4 bg-primary rounded-lg" @click="addMaterial({id: item.id, order: item.order, name: content, opened: false, address: newProd.Address, supplier: newProd.Supplier, trace: item.trace , children: []})") Submit
        div(class="ml-20")
          Nested(v-if="item.children?.length" :materials="item.children")
    div(class="flex justify-center mt-16")
      button(type="submit" class="border font-bold text-2xl text-white border-white rounded-full px-16 sm:px-48 py-4 bg-primary hover:shadow-md duration-300") Add
</template>
