import { createRouter, createWebHistory } from "vue-router";
import Home from "./pages/home.vue"
import Store from "./pages/store.vue"
import Privacy from "./pages/privacy.vue"
import Terms from "./pages/terms.vue"
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
    name: 'login',
    component: Login,
    meta: {
      auth: 'Guest'
    }
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
    meta: {
      auth: 'Guest'
    }
  },
  {
    path: '/privacy-policy',
    name: 'Privacy Policy',
    component: Privacy,
    meta: {
      auth: 'Guest'
    }
  },
  {
    path: '/terms-of-service',
    name: 'Terms of Service',
    component: Terms,
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

  if(to.meta.auth === 'Auth' && !store.isAuth){
    return { name: 'login' }
  }
})

export default router;