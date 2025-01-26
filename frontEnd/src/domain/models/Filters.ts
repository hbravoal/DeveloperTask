// domain/models/Filters.ts
export interface Filters {
  name?: string; // Nombre opcional del producto
  priceRange?: [number, number]; // Rango de precios como una tupla
  category?: string; // Categoría del producto
}
