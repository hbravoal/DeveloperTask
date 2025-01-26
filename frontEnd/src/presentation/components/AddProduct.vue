<script lang="ts">
import { defineComponent, ref } from "vue";
import { useProductStore } from "@/presentation/stores/productStore";

export default defineComponent({
  name: "AddProduct",
  setup() {
    const productStore = useProductStore();
    const name = ref("");
    const price = ref(0);
    const category = ref("");

    const addProduct = async () => {
      if (!name.value || !price.value || !category.value) {
        alert("Todos los campos son obligatorios");
        return;
      }

      await productStore.addProduct({ name: name.value, price: price.value, category: category.value });
      name.value = "";
      price.value = 0;
      category.value = "";
    };

    return {
      name,
      price,
      category,
      addProduct,
    };
  },
});
</script>

<template>
  <div class="add-product">
    <h3>Añadir Producto</h3>
    <label>
      Nombre:
      <input v-model="name" type="text" placeholder="Nombre del producto" />
    </label>
    <label>
      Precio:
      <input v-model.number="price" type="number" placeholder="Precio" />
    </label>
    <label>
      Categoría:
      <select v-model="category">
        <option value="" disabled>Selecciona una categoría</option>
        <option value="electronics">Electrónica</option>
        <option value="furniture">Muebles</option>
        <!-- Agrega más categorías aquí -->
      </select>
    </label>
    <button @click="addProduct">Añadir</button>
  </div>
</template>

<style scoped>
.add-product {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}
</style>
