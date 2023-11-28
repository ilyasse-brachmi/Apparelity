<script setup lang="ts">
const props = defineProps({
  productName: {
    type: String,
    required: true
  },
  companyName: {
    type: String,
    required: true
  },
  price: {
    type: Number,
    required: true
  },
  imageProduct: {
    type: String,
    required: true
  }
})
</script>
<template lang="pug">
div(class="max-w-[22rem]").dz-card.px-8.bg-gray-100.shadow-xl.flex-col.flex.items-center
	div(class="relative w-[16rem] h-[20rem] mt-8")
		img(class="rounded-lg" :src="imageProduct")
		div(class="absolute top-[-1rem] end-[-1rem] flex items-start gap-4 p-2 bg-primary rounded-full")
			Icon(icon="carbon:map" class="text-white cursor-pointer text-3xl font-semibold") 
	.dz-card-body.p-4
		h2.dz-card-title {{ productName }}
		p {{ companyName }} 
		.dz-card-actions.justify-end
			.flex.justify-end 
				p.font-semibold {{ price }} $
</template>