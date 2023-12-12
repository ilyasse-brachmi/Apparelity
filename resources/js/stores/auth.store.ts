import { defineStore } from 'pinia'
import { ref } from 'vue'
import Cookies from 'js-cookie'

export interface UserCompany {
  id: number;
  name: string;
}
declare interface User {
  id: number,
  name: string,
  email: string,
  isAdmin : boolean
  company: UserCompany
}

export const useAuth = defineStore('Auth', {
  state: () => {
    const userCookie = Cookies.get('user');
    return {
      user:  ref(userCookie ? (JSON.parse(userCookie) as User) : {} as User),
      token: ref(Cookies.get('token') || ''),
      isAuth: ref(!!Cookies.get('token'))
    }
  },
  actions: {
    setToken(newToken: string) {
      this.token = newToken;
      Cookies.set('token', newToken, { expires: 1})
    },
    setUser(newUser: User) {
      this.user = newUser;
      Cookies.set('user', JSON.stringify(newUser), { expires: 1})
    },
    fetchUser(token: string, newUser: User) {
      this.setToken(token)
      this.setUser(newUser)
      this.isAuth = true
    },
    setCompany(company: UserCompany) {
      this.user.company.id = company.id
      this.user.company.name = company.name
      Cookies.set('user', JSON.stringify(this.user), { expires: 1})
    },
    logout(){
      this.user = {} as User
      Cookies.remove('token')
      this.isAuth = false
    }
  }
})