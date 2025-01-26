import { ActionContext } from 'vuex';
import productService from '../../api/productService';
import { RootState } from '../index';
import { Product } from '../../models/Product';

interface ProductState {
  products: Product[];
  filters: Record<string, any>;
  page: number;
  totalPages: number;
}

export const fetchProducts = async (
  { commit, state }: ActionContext<ProductState, RootState>
) => {
  try {
    const data = await productService.fetchProducts(state.filters, state.page);
    commit('SET_PRODUCTS', data.products);
    commit('SET_TOTAL_PAGES', data.totalPages);
  } catch (error) {
    console.error('Error fetching products:', error);
  }
};

export const addProduct = async (
  { dispatch }: ActionContext<ProductState, RootState>,
  product: Product
) => {
  try {
    await productService.addProduct(product);
    dispatch('fetchProducts');
  } catch (error) {
    console.error('Error adding product:', error);
  }
};
