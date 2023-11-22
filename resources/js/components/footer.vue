<template lang="pug">
footer(class="bg-gradient-to-r from-secondary to-primary")
    div(class="container sm:mx-auto grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 sm:gap-x-8 md:gap-x-16 py-16 px-8 md:py-16 md:px-16 lg:py-20 lg:px-32")
        div 
            div 
                a(href="/" class="text-5xl font-medium text-white") LOGO
            div
                p(class="mt-8 text-white text-justify") Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem ad sit incidunt, illo ipsa qui cupiditate totam architecto, ratione repellendus aut, provident voluptatem rerum eligendi tempore at quas cumque alias?
        div 
            div(class="mt-8 lg:mt-0")
                p(class="text-3xl font-medium text-white") Contact Us
            div(class="w-full rounded max-w-[40rem] bg-white mt-4")
                input(type="text" placeholder="Enter a product name" class="px-4 py-2 text-lg outline-none bg-transparent rouned-full w-full")
            div(class="w-full rounded max-w-[40rem] bg-white mt-4")
                textarea(rows="4" cols="" placeholder="Message..." class="px-4 py-2 text-lg outline-none border-none rouned bg-transparent w-full")
        div.flex.justify-center.text-white.font-medium.text-lg.gap-4(class="col-span-1 sm:col-span-2 mt-8 xl:col-span-1")
            a(href="/").mt-2 Home 
            a(href="#").mt-2 Terms & Privacy
</template>