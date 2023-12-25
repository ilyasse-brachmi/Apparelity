import { $AppAxios } from "@/utils/axiosSingleton"
import type { ReverseAdress, ForwardAdress } from "@/types/index"
const myGeoToken = 'cd4a3b985cf04a9da8744687b983b48a' 

export async function getReverseAdress(lat: number, lang: number): Promise<ReverseAdress> {
  return await $AppAxios.get(`https://api.opencagedata.com/geocode/v1/json?q=${lat}+${lang}&key=${myGeoToken}`)
    .then((response) => {
      return response.data.results[0]
    })
    .catch((error) => {
      return error.message
    })
}

export async function getForwardAdress(adress: string): Promise<ForwardAdress> {
  return await $AppAxios.get(`https://api.opencagedata.com/geocode/v1/json?q=${adress}&key=${myGeoToken}`)
    .then((response) => {
      return response.data.results[0]
    })
    .catch((error) => {
      return error.message
    })
}