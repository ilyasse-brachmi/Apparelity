<template lang="pug">
div(class="bg-gradient-to-r from-secondary to-primary")
    div(class="container sm:mx-auto grid grid-cols-1 sm:grid-cols-3 sm:gap-x-8 md:gap-x-16 py-16 px-8 md:py-20 md:px-16 lg:py-24 lg:px-32")
        div 
            div 
                a(href="#" class="text-5xl font-medium text-white") LOGO
            div
                p(class="mt-8 text-white text-justify") Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem ad sit incidunt, illo ipsa qui cupiditate totam architecto, ratione repellendus aut, provident voluptatem rerum eligendi tempore at quas cumque alias?
        div 
            div 
                p(class="text-3xl font-medium text-white") Contact Us
            div(class="w-full rounded-full max-w-[40rem] mt-4")
                input(type="text" placeholder="Enter a product name" class="px-4 py-2 text-lg outline-none rouned-full w-full")
            textarea(rows="4" cols="" class="mt-4 px-4 py-2 text-lg outline-none border-none rouned-full w-full")
        div.flex.justify-center.text-white.font-medium.text-lg.py-4
            div
                p.mt-2 Home 
                p.mt-2 Terms & Privacy
</template>