import type { CategoryRepository } from '@/application/interfaces/CategoryRepository.ts'
import type { Category } from '@/domain/entities/Category.ts'

export class CategoryService {
  constructor(private categoryRepository: CategoryRepository) {}

  async fetchCategories(): Promise<{ categories: Category[]; total: number }> {
    return this.categoryRepository.fetchCategories();
  }

}
