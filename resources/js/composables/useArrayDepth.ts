import type { ForwardAdress } from "@/types";

let prevArray = [] as ForwardAdress[]
let order = 1
export const getObjDepth = (array: ForwardAdress[], item: ForwardAdress, intialize: boolean) => {
  if(intialize === false){
    if(prevArray === [] as ForwardAdress[])
      prevArray = array
    if(array !== prevArray){
      order = order + 1
      prevArray = array
    }
    console.log(order)
    return order
  }
  else{
    order = 1
    prevArray = []
    return order
  }
}
