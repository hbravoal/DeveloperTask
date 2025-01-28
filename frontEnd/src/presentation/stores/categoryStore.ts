import { defineStore } from "pinia";
import  { CategoryService } from "../../application/services/CategoryService.ts";
import  { CategoryRepositoryImpl } from "../../infrastructure/repositories/CategoryRepositoryImpl";
import type { Category } from '@/domain/entities/Category.ts'

const categoryService = new CategoryService(new CategoryRepositoryImpl());

export const useCategoryStore = defineStore("CategoryStore", {
  state: () => ({
    categories: [] as Category[],
    total: 0,
    selectedCategory: undefined
  }),
  actions: {
    async fetchCategories() {
      const { categories, total } = await categoryService.fetchCategories();
      this.categories = categories;
      this.total = total;
      console.log('this.Category',this.categories)
    }
  },
});
