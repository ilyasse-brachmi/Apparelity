import { defineStore } from 'pinia'
import { ref } from 'vue'

interface Material {
  id: number;
  order: number;
  name: string;
  children: Material[];
  opened: boolean;
}


export const useMaterial = defineStore('Material', {
  state: () => {
    const material = ref({} as Material)
    return {
      material,
    }
  },
  actions: {
    setCurrentMaterial(data: Material) {
      console.log('ana f store')
      this.material = data
    }
  }
})