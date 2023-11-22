<template lang="pug">
header(class="flex items-center justify-between p-4 top-0 bg-gray-100 sticky shadow-md")
  .dz-navbar-start
    .dz-dropdown
      label.dz-btn.dz-btn-ghost(tabindex='0' class='lg:hidden')
        svg.h-5.w-5(xmlns='http://www.w3.org/2000/svg' fill='none' viewbox='0 0 24 24' stroke='currentColor')
          path(stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 6h16M4 12h8m-8 6h16')
      ul.dz-menu.dz-menu-lg.dz-dropdown-content.rounded-md.mt-4.p-2.shadow-md.bg-gray-100(tabindex='0' class='z-[1] w-[12rem] sm:w-[30rem] md:w-[40rem]')
        li
          a(href="#" class="px-14 py-2.5 border-2 m-1 border-primary text-primary rounded-sm font-medium hover:bg-primary/20 hover:shadow-md duration-300") Home
        li
          a(href="#" class="px-12 py-2.5 text-white m-1 bg-primary rounded-sm hover:bg-primary/40 font-medium hover:shadow-md duration-300") Sign In
    a.dz-btn.dz-btn-ghost.text-xl(href='/') LOGO

  div(class="dz-navbar-center hidden lg:flex")
    a(href="#" class="px-14 py-2 border-2 border-primary m-2 text-primary rounded-sm hover:bg-primary/20 hover:shadow-md duration-300") Home
    a(href="/login" class="px-14 py-2 text-white m-2 bg-primary rounded-sm hover:bg-primary/90  hover:shadow-md duration-300") Sign In
</template>