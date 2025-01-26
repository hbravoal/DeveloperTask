import axios from 'axios';

const http = axios.create({
  baseURL: '',
});

http.interceptors.response.use(
  (response) => response,
  (error) => {
    console.error('API Error:', error);
    return Promise.reject(error);
  }
);

export default http;
