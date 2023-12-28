import { defineStore } from 'pinia'
import { ref } from 'vue'

declare interface Filter{
  category: number | null,
  price: number | null
}

export const useAppa = defineStore('Apparelity', {
  state: () => {
    return {
      isLoading: ref(false),
      filter: ref({category: null, price: null } as Filter)
    }
  },
  actions:{
    setFilter(filtredCriteria: Filter) {
      this.filter = filtredCriteria
    }
  }
})