import { defineStore } from 'pinia';
import api from '@/service/api';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        token: localStorage.getItem('token') || null,
        tokenExpiration: localStorage.getItem('tokenExpiration') || null,
        message: null
    }),
    actions: {
        async login(credentials) {
            try {
                const response = await api.login(credentials);
                this.token = response.data.token;
                this.user = response.data.user;

                const expirationTime = Date.now() + 60 * 60 * 1000;
                this.tokenExpiration = expirationTime;

                localStorage.setItem('token', this.token);
                localStorage.setItem('tokenExpiration', expirationTime);

                this.startTokenTimeout();
                this.message = 'Login realizado com sucesso';
            } catch (error) {
                this.message = 'Falha no login';
                throw error;
            }
        },
        async register(credentials) {
            try {
                const response = await api.register(credentials);
                this.token = response.data.token;
                this.user = response.data.user;

                const expirationTime = Date.now() + 60 * 60 * 1000;
                this.tokenExpiration = expirationTime;

                localStorage.setItem('token', this.token);
                localStorage.setItem('tokenExpiration', expirationTime);

                this.startTokenTimeout();
                this.message = 'Registro realizado com sucesso';
            } catch (error) {
                this.message = 'Falha no registro';
                throw error;
            }
        },
        async logout() {
            try {
                await api.logout();
                this.clearAuthData();
                this.message = 'Logout realizado com sucesso';
                window.location.href = '/login';
            } catch (error) {
                this.message = 'Falha no logout';
                throw error;
            }
        },
        async forgotPassword(payload) {
            try {
                await api.forgotPassword(payload);
                this.message = 'Solicitação de redefinição de senha enviada com sucesso';
            } catch (error) {
                this.message = 'Erro ao solicitar redefinição de senha';
                throw error;
            }
        },
        async resetPassword(payload) {
            try {
                await api.resetPassword(payload);
                this.message = 'Senha redefinida com sucesso';
            } catch (error) {
                this.message = 'Erro ao redefinir a senha';
                throw error;
            }
        },
        clearAuthData() {
            this.token = null;
            this.user = null;
            this.tokenExpiration = null;
            this.message = null;
            localStorage.removeItem('token');
            localStorage.removeItem('tokenExpiration');
        },
        startTokenTimeout() {
            const timeRemaining = this.tokenExpiration - Date.now();

            if (timeRemaining > 0) {
                setTimeout(() => {
                    this.clearAuthData();
                    this.message = 'Sua sessão expirou. Por favor, faça login novamente.';
                }, timeRemaining);
            } else {
                this.clearAuthData();
            }
        },
        checkTokenValidity() {
            if (this.tokenExpiration && Date.now() > this.tokenExpiration) {
                this.clearAuthData();
                return false;
            }
            return true;
        },
        async validateToken() {
            const token = localStorage.getItem('token');
            if (!token) {
                this.clearAuthData();
                return false;
            }

            if (!this.checkTokenValidity()) {
                return false;
            }

            try {
                const response = await api.getUser();
                this.user = response.data;
                return true;
            } catch (error) {
                this.message = 'Falha na validação do token';
                this.clearAuthData();
                return false;
            }
        },
        async handleSocialAuthCallback(token) {
            try {
                if (!token) {
                    throw new Error('Token não encontrado');
                }

                this.token = token;
                localStorage.setItem('token', token);

                const response = await api.get('/auth/user');
                this.user = response.data.user;

                const expirationTime = Date.now() + 60 * 60 * 1000;
                this.tokenExpiration = expirationTime;
                localStorage.setItem('tokenExpiration', expirationTime);

                this.startTokenTimeout();
                this.message = 'Autenticação social realizada com sucesso';

                window.location.href = '/';
            } catch (error) {
                this.message = 'Falha na autenticação social';
                this.clearAuthData();
                throw error;
            }
        },
        redirectToGoogle() {
            window.location.href = 'http://127.0.0.1:8000/api/auth/google';
        }
    },
    getters: {
        isAuthenticated: (state) => !!state.token && state.checkTokenValidity()
    }
});
