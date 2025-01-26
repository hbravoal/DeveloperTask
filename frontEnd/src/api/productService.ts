import type { Product } from '../models/Product';
import axios from '../utils/http';

interface Filters {
  name: string;
  minPrice: number;
  maxPrice: number;
  category: string;
}

interface ProductResponse {
  products: Product[];
  totalPages: number;
}

export default {
  async fetchProducts(filters: Filters, page: number = 1, limit: number = 10): Promise<ProductResponse> {
    try {
      const response = await axios.get('/products', {
        params: { ...filters, page, limit }
      });
      return response.data;
    } catch (error: unknown) {
      // Manejo del error tipado
      if (error instanceof Error) {
        console.error('Error fetching products:', error.message);
        throw new Error('Error fetching products');
      } else {
        console.error('Unknown error:', error);
        throw new Error('Error fetching products');
      }
    }
  },

  async addProduct(product: Product): Promise<Product> {
    try {
      const response = await axios.post('/products', product);
      return response.data;
    } catch (error: unknown) {
      if (error instanceof Error) {
        console.error('Error adding product:', error.message);
        throw new Error('Error adding product');
      } else {
        console.error('Unknown error:', error);
        throw new Error('Error adding product');
      }
    }
  }
};
