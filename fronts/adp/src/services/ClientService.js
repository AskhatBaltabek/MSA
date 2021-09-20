import axios from 'axios'
import store from '../store/index';

const apiClient = axios.create({
    // baseURL: 'https://my-json-server.typicode.com/bipinstha7/vue-design-pattern',
    baseUrl: 'http://localhost:3000',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    },
    timeout: 30000 // throw error if API call takes longer than 10 seconds
});

const getAuthToken = () => 'Bearer '+localStorage.getItem('user-token');

const interceptor = (config) => {
    config.headers['Authorization'] = getAuthToken();
    return config;
}

apiClient.interceptors.request.use(
    interceptor,
    async error => {
        return Promise.reject(error);
    }
);

apiClient.interceptors.response.use(
    (response) => {
        return response
    },
    async error => {
        if (error.response.status === 401) {
            // eslint-disable-next-line no-unused-vars
            const resp = await store.dispatch('REFRESH_TOKEN')
            return apiClient(error.config);
        } else {
            return Promise.reject(error);
        }
    }
);

export default apiClient;