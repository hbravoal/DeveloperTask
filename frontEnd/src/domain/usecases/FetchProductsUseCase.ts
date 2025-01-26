import type { Product } from "../entities/Product";

export interface FetchProductsUseCase {
  execute(filters: { name?: string; priceRange?: [number, number]; category?: string }, page: number): Promise<{ products: Product[]; total: number }>;
}
