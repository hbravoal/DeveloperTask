<script lang="ts">
import { defineComponent } from "vue";
import { useProductStore } from "@/presentation/stores/productStore";

export default defineComponent({
  name: "Pagination",
  setup() {
    const productStore = useProductStore();

    const changePage = (page: number) => {
      if (page > 0 && (page - 1) * 10 < productStore.total) {
        productStore.setPage(page);
      }
    };

    return {
      productStore,
      changePage,
    };
  },
});
</script>

<template>
  <div class="pagination">
    <button @click="changePage(productStore.currentPage - 1)" :disabled="productStore.currentPage === 1">
      Anterior
    </button>
    <span>Página {{ productStore.currentPage }}</span>
    <button @click="changePage(productStore.currentPage + 1)" :disabled="productStore.currentPage * 10 >= productStore.total">
      Siguiente
    </button>
  </div>
</template>

<style scoped>
.pagination {
  display: flex;
  justify-content: center;
  gap: 1rem;
}
</style>
