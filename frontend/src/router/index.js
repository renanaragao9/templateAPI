import AppLayout from '@/layout/AppLayout.vue';
import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '@/stores/authStore';

const routes = [
    {
        path: '/',
        component: AppLayout,
        children: [
            {
                path: '/',
                name: 'dashboard',
                component: () => import('@/views/Dashboard.vue'),
                meta: { requiresAuth: true }
            },
            {
                path: '/pdv',
                name: 'pdv',
                component: () => import('@/views/Admin/PDVView.vue'),
                meta: { requiresAuth: true }
            },
            {
                path: '/configuracao',
                name: 'settings',
                component: () => import('@/views/Admin/Business.vue'),
                meta: { requiresAuth: true }
            },
            {
                path: '/espacos',
                name: 'spaces',
                component: () => import('@/views/Admin/space.vue'),
                meta: { requiresAuth: true }
            },
            {
                path: '/produtos',
                name: 'products',
                component: () => import('@/views/Admin/space.vue'),
                meta: { requiresAuth: true }
            },
            {
                path: '/categorias-de-produtos',
                name: 'productCategory',
                component: () => import('@/views/Admin/productCategory.vue'),
                meta: { requiresAuth: true }
            },
            {
                path: '/mensagens',
                name: 'messages',
                component: () => import('@/views/Admin/MessageView.vue'),
                meta: { requiresAuth: true }
            },
            {
                path: '/chamados',
                name: 'tickets',
                component: () => import('@/views/Admin/TicketView.vue'),
                meta: { requiresAuth: true }
            }
        ]
    },
    {
        path: '/auth/login',
        name: 'login',
        component: () => import('@/views/pages/auth/Login.vue'),
        meta: { requiresAuth: false }
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('@/views/Auth/Login.vue')
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('@/views/Auth/Register.vue')
    },
    {
        path: '/redefinir-senha',
        name: 'ForgotPassword',
        component: () => import('@/views/Auth/ForgotPassword.vue')
    },
    {
        path: '/nova-senha',
        name: 'ResetPassword',
        component: () => import('@/views/Auth/ResetPassword.vue')
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();

    if (to.meta.requiresAuth) {
        const isValid = await authStore.validateToken();
        if (!isValid) {
            next('/login');
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;
