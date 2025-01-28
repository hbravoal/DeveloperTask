import axios from "axios";
import type { Category } from "../../domain/entities/Category";
import type { CategoryRepository } from "../../application/interfaces/CategoryRepository";

export class CategoryRepositoryImpl implements CategoryRepository {
  private baseURL = "http://127.0.0.1:8000/api/categories";

  async fetchCategories(): Promise<{ categories: Category[]; total: number }> {
    const response = await axios.get(this.baseURL, { });
    console.log('response category',response.data)
    return { categories: response.data.data, total: response.data.total };
  }

}
