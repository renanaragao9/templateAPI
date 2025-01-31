import axios from 'axios';

const apiClient = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {
        'Content-Type': 'application/json'
    }
});

apiClient.interceptors.request.use((config) => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

export default {
    register(userData) {
        return apiClient.post('/register', userData);
    },
    login(credentials) {
        return apiClient.post('/login', credentials);
    },
    logout() {
        return apiClient.post('/logout');
    },
    getUser() {
        return apiClient.get('/user');
    },
    forgotPassword(payload) {
        return apiClient.post('/password/email', payload);
    },
    resetPassword(payload) {
        return apiClient.post('/password/reset', payload);
    }
};
