import { defineStore } from 'pinia'
import { ref } from 'vue'

declare interface User {
  name: string,
  email: string,
  isAdmin : boolean
}

export const useAuth = defineStore('Auth', {
  state: () => {
    return {
      user: ref({} as User),
      token: ref(localStorage.getItem('token') || ''),
      isAuth: ref(false)
    }
  },
  actions: {
    setToken(newToken: string) {
      this.token = newToken
      localStorage.setItem('token', this.token)
    },
    fetchUser(token: string, newUser: User) {
      this.setToken(token)
      this.user = newUser
      this.isAuth = true
    }
  }
})