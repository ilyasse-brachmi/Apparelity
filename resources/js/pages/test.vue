<template lang="pug">
StoreLayout
    template(v-slot:cards)
        .flex.items-center.justify-center.h-full.w-full
            div(v-if="data.length" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 py-8 h-full")
                div(v-for="product in data" :key="product.original.id")
                    Card(:product="product.original" :price="199" @openModal="openModal(index)")
            div(v-else class="w-full h-full flex flex-col items-start pt-[10rem] justify-center")
				p(class="text-2xl tracking-wide font-semibold") Opps... It's empty in here 
				p(class="text-base text-slate-500") No offers hase been saved yet.
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
</template>