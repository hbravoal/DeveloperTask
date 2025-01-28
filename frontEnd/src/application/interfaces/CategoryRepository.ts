import type { Category } from "../../domain/entities/Category";

export interface CategoryRepository {
  fetchCategories(): Promise<{ categories: Category[]; total: number }>;
}
