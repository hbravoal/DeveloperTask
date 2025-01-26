<script lang="ts">
import { defineComponent } from "vue";
import { useProductStore } from "@/presentation/stores/productStore";

export default defineComponent({
  name: "ProductList",
  setup() {
    const productStore = useProductStore();

    productStore.fetchProducts();

    const applyFilters = () => {
      productStore.setFilters({
        name: "Laptop",
        priceRange: [500, 1500],
        category: "electronics",
      });
    };

    const changePage = (page: number) => {
      productStore.setPage(page);
    };

    return {
      productStore,
      applyFilters,
      changePage,
    };
  },
});
</script>

<template>
  <div>
    <div class="filters">
      <button @click="applyFilters">Aplicar Filtros</button>
    </div>

    <div class="products">
      <div v-for="product in productStore.products" :key="product.id">
        <h3>{{ product.name }}</h3>
        <p>{{ product.price }}</p>
        <p>{{ product.category }}</p>
      </div>
    </div>

    <div class="pagination">
      <button @click="changePage(productStore.currentPage - 1)" :disabled="productStore.currentPage === 1">
        Anterior
      </button>
      <span>Página {{ productStore.currentPage }}</span>
      <button @click="changePage(productStore.currentPage + 1)" :disabled="productStore.products.length < 10">
        Siguiente
      </button>
    </div>
  </div>
</template>
