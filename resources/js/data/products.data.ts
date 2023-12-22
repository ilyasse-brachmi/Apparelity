import { computed } from "vue"
import type { ProductMaterial } from "@/types/index"


export const materials = computed<ProductMaterial[]>(() => [
  {
    id: 1,
    name: "Shirt",
    coordonates: [42.21477621706092, -102.8209947946883],
    opened: false,
    supplier: "Apparelity",
    order: 1,
    trace: '01',
    children: [
      {
        id: 0,
        name: "tissu",
        coordonates: [35.619003301816036, -5.271179278755428],
        opened: false,
        supplier: "Apparelity",
        order: 2,
        trace: '0102',
        children: [
          {
            id: 0,
            name: "Fil",
            coordonates: [65.21650181027768, 18.45065083588576],
            opened: false,
            supplier: "Apparelity",
            order: 3,
            trace: '0102',
            children: [
              {
                id: 0,
                name: "Fil",
                coordonates: [-23.619003301816036,19.271179278755428],
                opened: false,
                supplier: "Apparelity",
                order: 4,
                trace: '0102',
                children: [
        
                ]
              },
            ]
          },
        ]
      },
      {
        id: 1,
        name: "Coton",
        coordonates: [-27.19511075841805, 130.94718213266472],
        opened: false,
        supplier: "Apparelity",
        order: 2,
        trace: '0102',
        children: [

        ]
      }
    ]
  }
])