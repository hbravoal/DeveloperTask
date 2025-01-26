<template>
  <div>
    <label>
      Nombre:
      <input
        type="text"
        @input="handleNameInput"
        placeholder="Buscar por nombre"
      />
    </label>

    <label>
      Rango de precio:
      <input
        type="number"
        v-model="priceRange.min"
        placeholder="Precio mínimo"
        @input="handlePriceRangeInput"
      />
      <input
        type="number"
        v-model="priceRange.max"
        placeholder="Precio máximo"
        @input="handlePriceRangeInput"
      />
    </label>

    <label>
      Categoría:
      <select v-model="category" @change="handleCategoryChange">
        <option value="">Seleccione una categoría</option>
        <option value="electronics">Electrónica</option>
        <option value="clothing">Ropa</option>
        <option value="home">Hogar</option>
      </select>
    </label>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import { useProductStore } from '@/presentation/stores/productStore';

export default defineComponent({
  name: 'ProductFilters',
  setup() {
    const productStore = useProductStore();

    const priceRange = ref({ min: 0, max: 1000 });
    const category = ref<string>('');

    const handleNameInput = (event: Event) => {
      const target = event.target as HTMLInputElement | null;
      if (target) {
        productStore.setFilters({ name: target.value });
      }
    };

    const handlePriceRangeInput = () => {
      productStore.setFilters({
        priceRange: [priceRange.value.min, priceRange.value.max]
      });
    };

    const handleCategoryChange = () => {
      productStore.setFilters({ category: category.value });
    };

    return {
      priceRange,
      category,
      handleNameInput,
      handlePriceRangeInput,
      handleCategoryChange,
    };
  }
});
</script>

<style scoped>
/* Estilos del componente */
label {
  display: block;
  margin-bottom: 8px;
}

input,
select {
  margin-left: 10px;
  padding: 5px;
}
</style>
