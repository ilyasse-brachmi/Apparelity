import { createRouter, createWebHistory } from "vue-router";
import Home from "./pages/home.vue"
import Store from "./pages/store.vue"
import Login from "./pages/auth/login.vue"
import Register from "./pages/auth/register.vue"

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/store',
    name: 'Store',
    component: Store,
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router;