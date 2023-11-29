import { defineStore } from 'pinia'
import { ref } from 'vue'
import Cookies from 'js-cookie';

declare interface User {
  name: string,
  email: string,
  isAdmin : boolean
}

export const useAuth = defineStore('Auth', {
  state: () => {
    return {
      user: ref({} as User),
      token: ref(Cookies.get('token') || ''),
      isAuth: ref(!!Cookies.get('token'))
    }
  },
  actions: {
    setToken(newToken: string) {
      this.token = newToken;
      Cookies.set('token', newToken, { expires: 1 })
    },
    fetchUser(token: string, newUser: User) {
      this.setToken(token)
      this.user = newUser
      this.isAuth = true
    },
    logout(){
      this.user = {} as User
      Cookies.remove('token')
      this.isAuth = false
    }
  }
})