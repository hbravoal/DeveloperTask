import type { Product } from "../entities/Product";

export interface AddProductUseCase {
  execute(product: Omit<Product, "id">): Promise<void>;
}
