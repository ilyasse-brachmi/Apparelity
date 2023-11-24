<template lang="pug">
div(class="banner")
  div(class="container mx-auto p-16 sm:p-24 md:p-32")
    h1(class="text-center text-4xl sm:text-6xl xl:text-7xl font-medium text-white") Apparelity
    p(class="text-center text-white font-semibold text-sm sm:text-lg lg:text-xl my-8") Trust In Every Thread, From Source To Finish
    div(class="flex flex-col md:flex-row items-center font-semibold justify-center gap-4")
      a(href="/login"  class="bg-white min-w-[10rem] sm:min-w-[12rem] lg:min-w-[15rem] text-primary rounded-sm px-2 md:px-10 lg:px-14 py-2 hover:bg-white/80 hover:shadow-md duration-300 text-center") Get Started 
      a(href="#searchProduct" class="border border-white min-w-[10rem] sm:min-w-[12rem] lg:min-w-[15rem] text-white rounded-sm px-2 md:px-10 lg:px-14 py-2 hover:bg-primary/80 hover:shadow-md duration-300") Search Product
</template>
<style scoped>
.banner {
  background-image: url("../../images/banner.jpeg");
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}
</style>