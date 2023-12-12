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
}


export const useAuth = defineStore('Auth', {
  state: () => {
    const userCookie = Cookies.get('user');
    const companyCookie = Cookies.get('company');
    return {
      user:  ref(userCookie ? (JSON.parse(userCookie) as User) : {} as User),
      token: ref(Cookies.get('token') || ''),
      isAuth: ref(!!Cookies.get('token')),
      company: ref(companyCookie ? (JSON.parse(companyCookie) as UserCompany) : {} as UserCompany),
      hasCompany: ref(!!Cookies.get('company'))
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
      this.company = company
      Cookies.set('company', JSON.stringify(company), { expires: 1})
      this.hasCompany = true
    },
    logout(){
      Cookies.remove('token')
      Cookies.remove('user')
      Cookies.remove('company')
      this.isAuth = false
      this.hasCompany = false
    }
  }
})