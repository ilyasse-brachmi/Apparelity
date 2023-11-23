<template lang="pug">
div(class="bg-gradient-to-r from-secondary to-primary")
  div(class="container mx-auto p-16 sm:p-24 md:p-32")
    h1(class="text-center text-4xl sm:text-6xl xl:text-7xl font-medium text-white") Apparelity
    p(class="text-center text-white text-sm sm:text-lg lg:text-xl my-8") Trust In Every Thread, From Source To Finish
    div(class="flex flex-col md:flex-row items-center justify-center gap-4")
      a(href="/login"  class="bg-white min-w-[10rem] sm:min-w-[12rem] lg:min-w-[15rem] text-primary rounded-sm px-2 md:px-10 lg:px-14 py-2 hover:bg-white/80 hover:shadow-md duration-300 text-center") Get Started 
      button(type="button" class="border border-white min-w-[10rem] sm:min-w-[12rem] lg:min-w-[15rem] text-white rounded-sm px-2 md:px-10 lg:px-14 py-2 hover:bg-primary/80 hover:shadow-md duration-300") Search Product
</template>
<style scoped>
.banner {
  background: linear-gradient('#000', '#023', url("../../images/banner.jpg"));
}
</style>