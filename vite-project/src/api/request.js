import axios from 'axios';

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
    Message.error({
      content: error.message || 'Request Error',
      duration: 5 * 1000,
    });
    return Promise.reject(error);
  }

)
// add response interceptors
service.interceptors.response.use(
  (response) => {
    console.log(response)
    return response.data;
  },
  (error) => {
    // 无响应处理，比如 timeout
    if (!error.response) {
      // Message.error({
      //   content: `请求失败，${error.message}`,
      //   duration: 5 * 1000,
      // });

      // 返回一个 pending 的 Promise，防止执行功能的 then 方法，但又不需要额外 catch 处理。
      // 直接抛异常的话，有些 event 事件最后不手动 catch，会有警告
      // return new Promise(() => {});
      return Promise.reject(error); // 不处理，直接抛异常给业务层处理
    }

    // 4xx 响应处理
    if (error.response.status >= 400 && error.response.status <= 499) {
      // Message.error({
      //   content: `操作失败，${
      //     error.response.data.message || error.response.status
      //   }`, // 当 4xx 错误是由 Web 服务器或者应用服务器触发的，此时没有 message 值，这里要特殊处理一下
      //   duration: 5 * 1000,
      // });
      // return new Promise(() => {});
      return Promise.reject(error); // 不处理，直接抛异常给业务层处理
    }

    // 5xx 响应处理
    if (error.response.status >= 500 && error.response.status <= 599) {
      // Message.error({
      //   content: `处理失败，${error.response.status}`,
      //   duration: 5 * 1000,
      // });
      // return new Promise(() => {});
      return Promise.reject(error); // 不处理，直接抛异常给业务层处理
    }

    // 6xx+ 响应不处理，所有失败最终都抛出异常，阻止传播到 then 方法
    return Promise.reject(error); // 不处理，直接抛异常给业务层处理
  }
);

export default service;