import type { Product } from "../../domain/entities/Product";
import type { ProductRepository } from "../interfaces/ProductRepository";
import type { Filters } from '@/domain/models/Filters.ts'

export class ProductService {
  constructor(private productRepository: ProductRepository) {}

  async fetchProducts(filters: Filters, page: number): Promise<{ products: Product[]; total: number }> {
    return this.productRepository.fetchProducts(filters, page);
  }

  async addProduct(product: Omit<Product, "id">): Promise<void> {
    return this.productRepository.addProduct(product);
  }
}
