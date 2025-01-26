import { defineStore } from "pinia";
import  { ProductService } from "../../application/services/ProductService";
import  { ProductRepositoryImpl } from "../../infrastructure/repositories/ProductRepositoryImpl";
import type { Product } from '@/domain/entities/Product.ts'
import type { Filters } from '@/domain/models/Filters.ts'

const productService = new ProductService(new ProductRepositoryImpl());

export const useProductStore = defineStore("productStore", {
  state: () => ({
    products: [] as Product[],
    total: 0,
    currentPage: 1,
    filters: {} as Filters,
  }),
  actions: {
    async fetchProducts() {
      const { products, total } = await productService.fetchProducts(this.filters, this.currentPage);
      this.products = products;
      this.total = total;
    },
    async addProduct(product: Omit<Product, "id">) {
      await productService.addProduct(product);
      this.fetchProducts();
    },
    setFilters(filters: { name?: string; priceRange?: [number, number]; category?: string }) {
      this.filters = { ...this.filters, ...filters };
      this.fetchProducts();
    },
    setPage(page: number) {
      this.currentPage = page;
      this.fetchProducts();
    },
  },
});
