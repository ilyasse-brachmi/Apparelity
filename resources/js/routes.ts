import { createRouter, createWebHistory } from "vue-router";
import Home from "./pages/home.vue"
import Store from "./pages/store.vue"
import Privacy from "./pages/privacy.vue"
import Terms from "./pages/terms.vue"
import Login from "./pages/auth/login.vue"
import Register from "./pages/auth/register.vue"
import Example from "@/pages/exemple.vue"
import CompleteAccount from "@/pages/auth/completeAccount.vue"
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
    path: '/example',
    name: 'Example',
    component: Example,
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

  if(to.meta.auth === 'Auth' && !store.isAuth) return { name: 'Login' }
  if(to.meta.auth === 'Guest' && store.isAuth) return { name: 'Store' }
})

export default router;