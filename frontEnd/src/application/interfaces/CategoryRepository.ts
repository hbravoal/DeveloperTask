import type { Product } from "../../domain/entities/Product";

export interface ProductRepository {
  fetchProducts(filters: { name?: string; priceRange?: [number, number]; category?: string }, page: number): Promise<{ products: Product[]; total: number }>;
  addProduct(product: Omit<Product, "id">): Promise<void>;
}
