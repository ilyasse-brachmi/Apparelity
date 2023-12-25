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
  category_name: string
}
export interface Company {
  id: number;
  name: string;
  address: string;
  Description: number;
  zipCode: number;
  country: string;
  city: string;
  phone: string
}

export interface ProductResponse{
  headers: Object;
  original: Product;
  exception: Object | null
}

export interface Category{
  id: number;
  name: string
}

export interface Material{
  id: number;
  product_id: number;
  name: string;
  origin: string;
  supplier: string;
  address: string
}

export interface Category {
  id: number;
  name: string;
  created_at: Date,
  updated_at: Date,
  deleted_at: Date
}

export interface ProductMaterial {
  id: number;
  trace?: string;
  order?: number;
  name: string;
  coordonates?: [number, number];
  address?: string;
  supplier?: string;
  children: ProductMaterial[];
  opened?: boolean;
}

export interface GeoCoordonates {
  town: String;
  country: String;
  region: String;
  road: String;
}

export interface ReverseAdress {
  annotations: {
    DMS: {
      lat: string;
      lng: string;
    };
    MGRS: string;
    Maidenhead: string;
    Mercator: {
      x: number;
      y: number;
    };
    OSM: {
      edit_url: string;
      note_url: string;
      url: string;
    };
    UN_M49: {
      regions: {
        AFRICA: string;
        MA: string;
        NORTHERN_AFRICA: string;
        WORLD: string;
      };
      statistical_groupings: string[];
    };
    callingcode: number;
    currency: {
      alternate_symbols: [];
      decimal_mark: string;
      format: string;
      html_entity: string;
      iso_code: string;
      iso_numeric: string;
      name: string;
      smallest_denomination: number;
      subunit: string;
      subunit_to_unit: number;
      symbol: string;
      symbol_first: number;
      thousands_separator: string;
    };
    flag: string;
    geohash: string;
    qibla: number;
    roadinfo: {
      drive_on: string;
      road: string;
      speed_in: string;
    };
    sun: {
      rise: {
        apparent: number;
        astronomical: number;
        civil: number;
        nautical: number;
      };
      set: {
        apparent: number;
        astronomical: number;
        civil: number;
        nautical: number;
      };
    };
    timezone: {
      name: string;
      now_in_dst: number;
      offset_sec: number;
      offset_string: string;
      short_name: string;
    };
    what3words: {
      words: string;
    };
  };
  bounds: {
    northeast: {
      lat: number;
      lng: number;
    };
    southwest: {
      lat: number;
      lng: number;
    };
  };
  components: {
    ISO_3166_1_alpha_2: string;
    ISO_3166_1_alpha_3: string;
    ISO_3166_2: string[];
    _category: string;
    _type: string;
    bar: string;
    continent: string;
    country: string;
    country_code: string;
    county: string;
    neighbourhood: string;
    postcode: string;
    region: string;
    road: string;
    state_district: string;
    town: string;
  };
  confidence: number;
  formatted: string;
  geometry: {
    lat: number;
    lng: number;
  };
}


export interface ForwardAdress {
  annotations: {
    DMS: {
      lat: string;
      lng: string;
    };
    MGRS: string;
    Maidenhead: string;
    Mercator: {
      x: number;
      y: number;
    };
    OSM: {
      edit_url: string;
      note_url: string;
      url: string;
    };
    UN_M49: {
      regions: {
        AFRICA: string;
        MA: string;
        NORTHERN_AFRICA: string;
        WORLD: string;
      };
      statistical_groupings: string[];
    };
    callingcode: number;
    currency: {
      alternate_symbols: [];
      decimal_mark: string;
      format: string;
      html_entity: string;
      iso_code: string;
      iso_numeric: string;
      name: string;
      smallest_denomination: number;
      subunit: string;
      subunit_to_unit: number;
      symbol: string;
      symbol_first: number;
      thousands_separator: string;
    };
    flag: string;
    geohash: string;
    qibla: number;
    roadinfo: {
      drive_on: string;
      road: string;
      speed_in: string;
    };
    sun: {
      rise: {
        apparent: number;
        astronomical: number;
        civil: number;
        nautical: number;
      };
      set: {
        apparent: number;
        astronomical: number;
        civil: number;
        nautical: number;
      };
    };
    timezone: {
      name: string;
      now_in_dst: number;
      offset_sec: number;
      offset_string: string;
      short_name: string;
    };
    what3words: {
      words: string;
    };
  };
  bounds: {
    northeast: {
      lat: number;
      lng: number;
    };
    southwest: {
      lat: number;
      lng: number;
    };
  };
  components: {
    ISO_3166_1_alpha_2: string;
    ISO_3166_1_alpha_3: string;
    ISO_3166_2: string[];
    _category: string;
    _type: string;
    bar: string;
    continent: string;
    country: string;
    country_code: string;
    county: string;
    neighbourhood: string;
    postcode: string;
    region: string;
    road: string;
    state_district: string;
    town: string;
  };
  confidence: number;
  formatted: string;
  geometry: {
    lat: number;
    lng: number;
  };
};


export interface AppProductMaterials{
  name: string;
  address: string;
  supplier: string; 
}

export interface AppProduct {
  name: string;
  price: number;
  description: string;
  production_date: string;
  supplier: string;
  company_id: number;
  category_id: number;
  address: string;
  image_product: string;
  order?: number;
  id?: number;
  trace?: string;
  opened?: boolean;
  children: AppProductMaterials[]
}