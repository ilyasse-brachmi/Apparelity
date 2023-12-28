// axiosInstance.ts

import axios, { AxiosInstance, AxiosRequestConfig, AxiosResponse } from 'axios';
import { useAuth } from "@/stores/auth.store"

// Create a new class to manage the singleton instance
class AxiosSingleton {
  private static instance: AxiosSingleton;
  private axiosInstance: AxiosInstance;

  private constructor() {
    // Create a new instance of axios with custom configurations
    this.axiosInstance = axios.create({
      baseURL: 'http://127.0.0.1:8000', // Replace with your API base URL
      timeout: 5000, // Set the timeout for requests (in milliseconds)
      // headers: {
      //   'Content-Type': 'application/json',
      //   // Add any other default headers you need
      // },
    });

    this.axiosInstance.interceptors.request.use(
      (config: AxiosRequestConfig) => {
        const store = useAuth()
        // Set Authorization header with the current token
        config.headers.Authorization = `Bearer ${store.token}`;
        return config;
      },
      (error) => {
        return Promise.reject(error);
      }
    );

    this.axiosInstance.interceptors.response.use(
      (response: AxiosResponse) => {
        // Do something with the response data
        return response;
      },
      (error) => {
        // Do something with response error
        return Promise.reject(error);
      }
    );
  }

  // Method to get the singleton instance
  public static getInstance(): AxiosSingleton {
    if (!AxiosSingleton.instance) {
      AxiosSingleton.instance = new AxiosSingleton();
    }
    return AxiosSingleton.instance;
  }

  // Method to get the AxiosInstance
  public getAxiosInstance(): AxiosInstance {
    return this.axiosInstance;
  }
}

// Export an instance of the AxiosSingleton class
const axiosSingleton = AxiosSingleton.getInstance();
export const $AppAxios = axiosSingleton.getAxiosInstance();