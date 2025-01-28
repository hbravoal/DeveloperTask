<template>
  <div class="product-page">
    <h1>Gestión de Productos</h1>
    <AddProduct />
    <ProductFilters />
    <div class="product-list">
      <div v-for="product in productStore.products" :key="product.id">
        <h3>{{ product.name }}</h3>
        <p>{{ product.price }}</p>
        <p>{{ product.category }}</p>
      </div>
    </div>
    <Pagination />
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { useProductStore } from "@/presentation/stores/productStore";
import AddProduct from "@/presentation/components/AddProduct.vue";
import ProductFilters from "@/presentation/components/ProductFilters.vue";
import Pagination from "@/presentation/components/Pagination.vue";

export default defineComponent({
  name: "ProductPage",
  components: { AddProduct, ProductFilters, Pagination },
  setup() {
    const productStore = useProductStore();
    productStore.fetchProducts();

    return { productStore };
  },
});
</script>

