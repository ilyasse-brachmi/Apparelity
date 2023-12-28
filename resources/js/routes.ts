import { createRouter, createWebHistory } from "vue-router";
import Home from "./pages/home.vue"
import Store from "./pages/store.vue"
import Privacy from "./pages/privacy.vue"
import Terms from "./pages/terms.vue"
import Login from "./pages/auth/login.vue"
import Register from "./pages/auth/register.vue"
import CompleteAccount from "@/pages/auth/completeAccount.vue"
import Dashboard from "@/pages/dashboard.vue"
import Product from "@/pages/product/index.vue"
import { useAuth } from '@/stores/auth.store'
import { useAppa } from "./stores/index.store";

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
      auth: 'Both'
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
  },
  {
    path: '/complete-account',
    name: 'CompleteAccount',
    component: CompleteAccount,
    meta: {
      auth: 'Auth'
    }
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard,
    meta: {
      auth: 'Auth'
    }
  },
  {
    path: '/privacy-policy',
    name: 'PrivacyPolicy',
    component: Privacy,
    meta: {
      auth: 'Both'
    }
  },
  {
    path: '/terms-of-service',
    name: 'TermsOfService',
    component: Terms,
    meta: {
      auth: 'Both'
    }
  },
  {
    path: '/product',
    name: 'Product',
    component: Product,
    meta: {
      auth: 'Auth'
    }
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to) => {
  const store = useAuth()
  const appaStore = useAppa()

  appaStore.isLoading = true
  if(to.meta.auth === 'Auth' && !store.isAuth) return { name: 'Login' }
  if(to.meta.auth === 'Guest' && store.isAuth) return { name: 'Dashboard' }
  if(to.meta.auth === 'Auth' && store.isAuth && !store.hasCompany && to.path !== '/complete-account') return { name: 'CompleteAccount' }
  if(to.path === '/complete-account' && store.isAuth && store.hasCompany) return { name: 'Dashboard' }
  setTimeout(() => {
    appaStore.isLoading = false
  }, 300);

})

export default router;