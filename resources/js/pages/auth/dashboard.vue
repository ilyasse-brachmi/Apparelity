<script setup lang="ts">
import DashLayout from '@/layouts/dashLayout.vue'
import Input from '@/components/AppInput.vue'
import { $AppAxios } from "@/utils/axiosSingleton"
import { useAuth } from "@/stores/auth.store"
import { useRouter } from "vue-router"
import { computed } from 'vue'
import { useField, useForm } from 'vee-validate'
import * as yup from 'yup'
import Swal from "sweetalert2"

var fileSelected: { value: File; } ;
const onFileSelected = ((e: Event & { target: HTMLInputElement })=>{
  fileSelected.value = e.target.files[0];
})

const scheme = computed(() => {
  return yup.object({
    name: yup.string().required('Name is a required field'),
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

const addProductSubmit = handleSubmit(async () => {
  const data = { 
    name: name.value,
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
</script>
<template lang="pug">
DashLayout
	div(class="flex items-center justify-center h-[90vh]")
		div
			h1(class="text-center text-2xl sm:text-3xl font-semibold text-primary my-4") Add New Product
			form(method="POST" @submit.prevent="addProductSubmit" class="flex-col items-center justify-center px-4")
				div(class="grid grid-cols-2 gap-4")
					div(class="mt-8")
						Input(:labelName="'Product Name'" name="name" :type="'text'" :color="'#1d6795'" @input="nameError" :inputError="errors.name")
					div(class="mt-8")
						Input(:labelName="'Product Description'" name="description" :type="'text'" :color="'#1d6795'")
					div(class="mt-8")
						Input(:labelName="'Category'" name="category" :type="'text'" :color="'#1d6795'")
					div(class="mt-8")
						Input(:labelName="'Price'" name="price" :type="'text'" :color="'#1d6795'" :icon="'healthicons:dollar'")
					div(class="mt-8")
						Input(:labelName="'Product Image'" name="name" :type="'text'" :color="'#1d6795'")
					div(class="mt-8")
						input(type="file" @change="onFileSelected")
					div(class="mt-8")
						Input(:labelName="'Material'" name="material" :type="'text'" :color="'#1d6795'")
				div(class="flex justify-center mt-8")
					button(type="submit" class="border font-bold text-2xl text-white border-white rounded-full px-16 sm:px-48 py-4 bg-primary hover:shadow-md duration-300") Add
</template>	