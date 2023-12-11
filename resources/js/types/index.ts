export type Coordinates = [number, number]
export interface ProductPopUp {
  title: string
  description: string
  image: string
}
export interface ProductMarker {
  markerCoordonates: Coordinates,
  popUp: ProductPopUp,

}
export interface ProductMap {
  markers : Array<Coordinates>,

}

export interface Product {
  id: number;
  name: string;
  description: string;
  price: number;
  production_date: Date;
  product_image: string;
  company_id: number;
  category_id: number;
  company_name: string;
  category_name: string;
}

export interface ProductResponse{
  headers: Object;
  original: Product;
  exception: Object | null
}