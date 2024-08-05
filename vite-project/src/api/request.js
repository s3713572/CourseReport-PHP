import axios from 'axios';
import { message } from 'antd';

const service = axios.create({
  withCredentials: false,
  timeout: 90 * 1000,
})

if (import.meta.env.VITE_API_BASE_URL) {
  service.defaults.baseURL = import.meta.env.VITE_API_BASE_URL;
}

service.interceptors.request.use(
  (config) => {

    config.headers['Content-Type'] = 'application/json';
    return config;
  },
  (error) => {
    message.error({
      content: error.message || 'Request Error',
      duration: 5 * 1000,
    });
    return Promise.reject(error);
  }

)
// add response interceptors
service.interceptors.response.use(
  (response) => {
    return response.data;
  },
  (error) => {
    // Request failed，such as timeout
    if (!error.response) {
      console.error('Request failed to call.');

      return Promise.reject(error);
    }

    // 4xx expected errors, should inform user
    if (error.response.status >= 400 && error.response.status <= 499) {
      return Promise.reject(error);
    }

    // 5xx response, internal erros
    if (error.response.status >= 500 && error.response.status <= 599) {
      return Promise.reject(error);
    }

    return Promise.reject(error);
  }
);

export default service;
