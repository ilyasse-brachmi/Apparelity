import { createRouter, createWebHistory } from "vue-router";
import Home from "./pages/home.vue"
import Store from "./pages/store.vue"
import Login from "./pages/auth/login.vue"
import Register from "./pages/auth/register.vue"
import { useAuth } from '@/stores/auth.store'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: {
      auth: 'Guest'
    }
  },
  {
    path: '/store',
    name: 'Store',
    component: Store,
    meta: {
      auth: 'Auth'
    }
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: {
      auth: 'Guest'
    }
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
    meta: {
      auth: 'Guest'
    }
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from) => {
  const store = useAuth()

  if(to.meta.auth === 'Auth' && !store.isAuth) return { name: 'Login' }
  if(to.meta.auth === 'Guest' && store.isAuth) return { name: 'Store' }
})

export default router;