<script lang="ts">
import { defineComponent, ref, onMounted } from "vue";
import { useProductStore } from "@/presentation/stores/productStore";
import { useCategoryStore } from "@/presentation/stores/categoryStore";

export default defineComponent({
  name: "ProductList",
  setup() {
    const productStore = useProductStore();
    const categoryStore = useCategoryStore();

    // Valor del rango (precio)
    const priceValue = ref(0);
    // Posición en porcentaje para el valor del rango
    const position = ref(0);

    // Filtro de búsqueda (nombre)
    const searchName = ref("");

    // Filtro de categoría
    const selectedCategory = ref("");

    // Función para cargar productos y categorías
    const fetchData = async () => {
      await productStore.fetchProducts();
      await categoryStore.fetchCategories();
    };

    // Cargar datos al montar el componente
    onMounted(() => {
      fetchData();
    });

    // Actualiza el valor y la posición en el slider
    const updatePriceValue = () => {
      // Calculamos la posición del valor en porcentaje
      position.value = (priceValue.value / 1000000) * 100;
    };
console.log('prce',priceValue.value);

    const applyFilters = () => {


      const priceRangeValue = priceValue.value !== 0 ? Number(priceValue.value) : null; // Parseamos a número y evitamos el 0

      const filters: Record<string, any> = {
        name: searchName.value, // Filtro por nombre
        category: selectedCategory.value, // Filtro por categoría
      };

      // Solo agregamos priceRange si tiene un valor válido
      if (priceRangeValue !== null) {
        filters.priceRange = [0, priceRangeValue]; // Asegúrate de usar el rango adecuado
      }

      // Aplicamos los filtros
      productStore.setFilters(filters);

      productStore.fetchProducts();
    };

    // Cambiar de página
    const changePage = (page: number) => {
      productStore.setPage(page);
    };

    return {
      productStore,
      applyFilters,
      changePage,
      categoryStore,
      priceValue, // Valor de precio
      position, // Posición del valor
      updatePriceValue, // Función para actualizar el valor
      searchName, // Valor del campo de búsqueda
      selectedCategory, // Valor de la categoría seleccionada
    };
  },
});
</script>

<template>
  <v-container>
    <!-- Encabezado centrado -->
    <div class="flex justify-center items-center mb-3 mt-1 pl-3 pr-3">
      <div class="w-full max-w-2xl flex justify-between items-center space-x-4">
        <!-- Filtro de búsqueda -->
        <div class="w-full max-w-sm min-w-[200px] relative">
          <div class="relative">
            <input
              v-model="searchName"
              class="bg-white w-full pr-11 h-10 pl-3 py-2 bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md"
              placeholder="Search for invoice..."
            />
            <button
              class="absolute h-8 w-8 right-1 top-1 my-auto px-2 flex items-center bg-white rounded"
              type="button"
            >
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-8 h-8 text-slate-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Filtro de rango de precio -->
        <div class="w-full max-w-sm min-w-[200px]">
          <div class="mb-4">
            <label for="price-range" class="block text-sm font-medium text-slate-700">Precio (rango de precios)</label>
            <div class="relative">
              <!-- Rango de precios -->
              <input
                id="price-range"
                type="range"
                min="0"
                max="10000"
                step="10"
                v-model="priceValue"
                @input="updatePriceValue"
                class="w-full h-2 bg-gray-300 rounded-lg appearance-none cursor-pointer"
              />
              <!-- Valor mostrado en hover -->
              <span
                v-bind:style="{ left: position + '%' }"
                class="absolute top-[-30px] bg-black text-white px-2 py-1 text-sm rounded-md"
              >
                {{ priceValue }}
              </span>
            </div>
          </div>

          <!-- Filtro de categoría -->
          <div class="relative">
            <select
              v-model="selectedCategory"
              class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm appearance-none cursor-pointer"
            >
              <option value="" selected>Select Category</option>
              <option v-for="category in categoryStore.categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </select>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="h-5 w-5 ml-1 absolute top-2.5 right-2.5 text-slate-700">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
            </svg>
          </div>
        </div>

        <!-- Botón de aplicar filtros -->
        <button
          class="rounded-md bg-slate-800 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-slate-700 focus:shadow-none active:bg-slate-700 hover:bg-slate-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
          type="button"
          @click="applyFilters"
        >
          Aplicar filtros
        </button>
      </div>
    </div>

    <!-- Tabla de productos -->
    <div class="relative flex flex-col w-full h-full overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
      <table class="w-full text-left table-auto min-w-max">
        <thead>
        <tr class="border-b border-slate-300 bg-slate-50">
          <th class="p-4 text-sm font-normal leading-none text-slate-500">Product</th>
          <th class="p-4 text-sm font-normal leading-none text-slate-500">Name</th>
          <th class="p-4 text-sm font-normal leading-none text-slate-500">Price</th>
          <th class="p-4 text-sm font-normal leading-none text-slate-500">Category</th>
          <th class="p-4 text-sm font-normal leading-none text-slate-500"></th>
        </tr>
        </thead>
        <tbody>
        <!-- Lista de productos -->
        <tr v-for="product in productStore.products" :key="product.id" class="hover:bg-slate-50">
          <td class="p-4 border-b border-slate-200 py-5">
            <img src="https://demos.creative-tim.com/corporate-ui-dashboard-pro/assets/img/michael-oxendine-GHCVUtBECuY-unsplash.jpg" alt="Product 3" class="w-16 h-16 object-cover rounded" />
          </td>
          <td class="p-4 border-b border-slate-200 py-5">
            <p class="block font-semibold text-sm text-slate-800">{{ product.name }}</p>
          </td>
          <td class="p-4 border-b border-slate-200 py-5">
            <p class="text-sm text-slate-500">{{ product.price }}</p>
          </td>
          <td class="p-4 border-b border-slate-200 py-5">
            <p class="text-sm text-slate-500">{{ product.category_name }}</p>
          </td>
          <td class="p-4 border-b border-slate-200 py-5">
            <button type="button" class="text-slate-500 hover:text-slate-700">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>

    <!-- Paginación -->
    <div class="flex items-center justify-between p-3">
      <p class="block text-sm text-slate-500">
        Page {{ productStore.currentPage }} of {{ productStore.total }}
      </p>
      <div class="flex gap-1">
        <button
          class="rounded border border-slate-300 py-2.5 px-3 text-center text-xs font-semibold text-slate-600 transition-all hover:opacity-75 focus:ring focus:ring-slate-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
          type="button"
          @click="changePage(productStore.currentPage - 1)"
          :disabled="productStore.currentPage === 1"
        >
          Previous
        </button>
        <button
          class="rounded border border-slate-300 py-2.5 px-3 text-center text-xs font-semibold text-slate-600 transition-all hover:opacity-75 focus:ring focus:ring-slate-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
          type="button"
          @click="changePage(productStore.currentPage + 1)"
          :disabled="productStore.currentPage === productStore.total"
        >
          Next
        </button>
      </div>
    </div>
  </v-container>
</template>
