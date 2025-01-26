import axios from "axios";
import type { Product } from "../../domain/entities/Product";
import type { ProductRepository } from "../../application/interfaces/ProductRepository";

export class ProductRepositoryImpl implements ProductRepository {
  private baseURL = "https://api.example.com/products";

  async fetchProducts(filters: { name?: string; priceRange?: [number, number]; category?: string }, page: number): Promise<{ products: Product[]; total: number }> {
    const response = await axios.get(this.baseURL, { params: { ...filters, page, limit: 10 } });
    return { products: response.data.products, total: response.data.total };
  }

  async addProduct(product: Omit<Product, "id">): Promise<void> {
    await axios.post(this.baseURL, product);
  }
}
