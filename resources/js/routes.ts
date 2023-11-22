import { createRouter, createWebHistory } from "vue-router";
import Home from "./pages/home.vue"
import Login from "./pages/auth/login.vue"

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router;