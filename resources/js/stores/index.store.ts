import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useAppa = defineStore('Apparelity', {
  state: () => {
    return {
      isLoading: ref(false)
    }
  }
})