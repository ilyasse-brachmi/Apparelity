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
import type { ProductMaterial, Category } from "@/types/index"
import Placeholder from "../../../images/placeholder.jpg"
import { useMaterial } from '@/stores/material.store';


const store = useAuth()
const router = useRouter()

const scheme = computed(() => {
  return yup.object({
    name: yup.string().required('Name is a required field'),
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
} = useField<string>('price')

const {
  handleChange: descriptionError,
  value: description
} = useField<string>('description')


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

const addProductSubmit = handleSubmit(async () => {
  const formData = new FormData();

  formData.append('name', name.value)
  formData.append('price', price.value)
  formData.append('description', description.value)
  formData.append('company_id', JSON.stringify(store.company.id))
  if (selectedFile.value)
    formData.append('image_product', selectedFile.value);
  formData.append('production_date', date.value)
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
})


const MaterailStore = useMaterial()

watch(
  () => MaterailStore.material,
  (newVal) => addMaterial(newVal as ProductMaterial)
)



const addMaterial = (material: ProductMaterial, array = [...materials.value] as ProductMaterial[]) => {
  opened.value = false
  console.log(material.trace)
  if (array.length) {
    array.forEach(element => {
      if (element.trace === material.trace) {
        // console.log(element.trace + '---' + material.trace)
        element.children.push({ id: material.id, order: material.order + 1, name: material.name, children: material.children, opened: material.opened, trace: material.trace + element.children.length + (material.order + 1) })
      }
      else {
        console.log('elese')
        if (element.children.length) {
          console.log('3ndo')
          addMaterial(material, element.children)
        }
        else {
          console.log('ma3ndo')
          console.log(element.trace + '---' + material.trace)
          // element.children.push({ id: element.children.length, order: material.order + 1, name: material.name, children: material.children, opened:material.opened, trace: material.trace + element.children.length + (material.order + 1)  })
        }
      }
    });
  }
  else console.log('aaaaaaaa')
  // console.log(materials)
}

// const addMaterial = (material: ProductMaterial, array = [...materials.value] as ProductMaterial[]) => {
//   console.log(material)
//   opened.value = false
//   if (array.length) {
//     array.forEach(element => {
//       if (element.trace === material.trace) {
//           console.log(element.trace + '---' + material.trace)
//           element.children.push({ id: element.children.length, order: material.order + 1, name: material.name, children: material.children, opened:material.opened, trace: material.trace + element.children.length + (material.order + 1) })
//         if (element.children.length) {
//           console.log('3ndo')
//           addMaterial(material, element.children)
//         }
//         else {
//           console.log('ma3ndo')
//           console.log(element.trace + '---' + material.trace)
//           // element.children.push({ id: element.children.length, order: material.order + 1, name: material.name, children: material.children, opened:material.opened, trace: material.trace + element.children.length + (material.order + 1)  })
//         }
//       }
//     });
//   }
//   else console.log('aaaaaaaa')
//   // console.log(materials)
// }


const materials = ref<ProductMaterial[]>([
  {
    id: 0,
    order: 1,
    trace: '01',
    name: "Final Product",
    coordonates: '40/39',
    supplier: 'Apparelity',
    opened: false,
    children: [
    ]
  }
])  // {} as ProductMaterial,
  // {
  //   id: 0,
  //   order: 1,
  //   trace: '01',
  //   name: name.value,
  //   opened: false,
  //   children: []
  // }
watch(
  () => materials.value,
  (newVal) => {
    materials.value = newVal
  },
  { deep: true }
)

const customMaterials = [...materials.value]

const opened = ref(false)
const content = ref('')
const selectedCategory = ref('')
const categories = ref([] as Category[])

const addItems = (material: ProductMaterial) => {
  console.log(material.trace)
  MaterailStore.setCurrentMaterial(material)
  opened.value = false
}

const addMaterials = ref(false)
const newMaterail = ref({id: 0, children: [], name: '', opened: false, order: 1, coordonates: '40/31', supplier: 'Apparelity', trace: '01'} as ProductMaterial)

const openMaterials = (newMaterail: ProductMaterial) => {
  if (name.value) {
    materials.value.push(newMaterail)
    materials.value[materials.value.length - 1].name = name.value
    addMaterials.value = true
  }
}

onMounted(async () => {
  await $AppAxios.get('/api/category')
    .then((response: { data: Category[] }) => categories.value = response.data)
})
const checked = ref(false)
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
        AppInput(:labelName="'Material'" name="material" :type="'text'" :color="'#1d6795'")
      div(class="mt-2")
        label(class="px-2 text-primary text-xs") Production date
        input(type="date" v-model="date" class="w-full p-2 h-[3.6rem] min-h-[3.6rem] cursor-pointer border border-primary rounded-lg")
      div(class="mt-8")
        select(class="dz-select dz-select-bordered w-full h-[3.6rem] min-h-[3.6rem]" v-model="selectedCategory")
          option(disabled value="") Select category
          option(v-for="category in categories" :key="category.id" :value="category.id") {{ category.name }}
    div(class="mt-8")
      button(@click="console.log(materials)") CLICK
      div(class="")
        //- button(@click="getData") Get data
        //- p(v-if="data") {{ data }}
      div(v-for="item in materials" :key="item.id" class="flex flex-col gap-y-8 items-center justify-center")
        div(class="w-full flex items-center gap-x-4")
          h1(class="whitespace-nowrap text-primary font-semibold") {{ item.name }}
          .dz-collapse.dz-collapse-arrow.bg-gray-50(@click="checked = !checked")
            input(type='radio' name='my-accordion-2' :checked='checked')
            .dz-collapse-title.text-xl.font-medium
              AppInput(:type="'text'" :labelName="'Material name'" :color="'#1d6795'" v-model="content")
            .dz-collapse-content
              h1 Adress 
              h1 Adress 
              h1 Adress 
              h1 Adress 
          div(class="flex items-center justify-center gap-2 text-white")
            //- Icon(icon="carbon:add-filled" class="text-primary text-3xl cursor-pointer" @click="item.opened = true") Add Material
            button(v-if="content" type="button" class="p-4 bg-primary rounded-lg" @click="addMaterial({id: item.id, order: item.order, name: content, opened: false, coordonates: '40/31', supplier: 'Apparelity', trace: item.trace , children: []})") Submit
        div(class="ml-20")
          Nested(v-if="item.children?.length" :materials="item.children")
    div(class="flex justify-center mt-16")
      button(type="submit" class="border font-bold text-2xl text-white border-white rounded-full px-16 sm:px-48 py-4 bg-primary hover:shadow-md duration-300") Add
</template>
