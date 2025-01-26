import axios from '../utils/http';

export default {
  async fetchProducts(filters, page = 1, limit = 10) {
    try {
      const response = await axios.get('/products', {
        params: { ...filters, page, limit },
      });
      return response.data;
    } catch (error) {
      throw new Error('Error fetching products');
    }
  },

  async addProduct(product) {
    try {
      const response = await axios.post('/products', product);
      return response.data;
    } catch (error) {
      throw new Error('Error adding product');
    }
  }
};
