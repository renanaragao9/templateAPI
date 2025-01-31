<script setup>
import FloatingConfigurator from '@/components/FloatingConfigurator.vue';
import { ref, onMounted } from 'vue';
import { useAuthStore } from '@/stores/authStore';
import { useToast } from 'primevue/usetoast';

const email = ref('');
const isLoading = ref(false);
const isRedirecting = ref(false);

const authStore = useAuthStore();
const toast = useToast();

onMounted(() => {
    if (authStore.isAuthenticated) {
        window.location.href = '/';
    }
});

const handleForgotPassword = async () => {
    if (!email.value) {
        toast.add({ severity: 'warn', summary: 'Atenção', detail: 'Por favor, preencha o campo de email.', life: 3000 });
        return;
    }

    isLoading.value = true;
    try {
        await authStore.forgotPassword({ email: email.value });
        toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Solicitação de redefinição de senha enviada com sucesso!', life: 3000 });
        isRedirecting.value = true;
        setTimeout(() => {
            window.location.href = '/login';
        }, 3000);
    } catch (error) {
        const errorMessage = error.response?.data?.message || 'Erro ao solicitar redefinição de senha';
        toast.add({ severity: 'error', summary: 'Erro', detail: 'Erro: ' + errorMessage, life: 3000 });
    } finally {
        isLoading.value = false;
    }
};
</script>

<template>
    <FloatingConfigurator />
    <Toast />
    <div class="bg-surface-50 dark:bg-surface-950 flex items-center justify-center min-h-screen min-w-[100vw] overflow-hidden">
        <div class="flex flex-col items-center justify-center">
            <div style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">
                <div class="w-full bg-surface-0 dark:bg-surface-900 py-20 px-8 sm:px-20" style="border-radius: 53px">
                    <div class="text-center mb-8">
                        <div class="text-surface-900 dark:text-surface-0 text-3xl font-medium mb-4">Bem-vindo ao Joga Junto!</div>
                        <span class="text-muted-color font-medium">Recupere sua senha</span>
                    </div>

                    <div>
                        <label for="email1" class="block text-surface-900 dark:text-surface-0 text-xl font-medium mb-2">Email</label>
                        <InputText id="email1" type="text" placeholder="Endereço de email" class="w-full mb-8" v-model="email" />

                        <div class="flex items-center justify-between mb-4 gap-8">
                            <router-link to="/login" class="font-medium no-underline ml-2 text-right cursor-pointer text-primary">Voltar para login</router-link>
                        </div>

                        <Button :label="isLoading ? (isRedirecting ? 'Redirecionando...' : 'Enviando...') : 'Enviar'" class="w-full" :disabled="isLoading || isRedirecting" @click="handleForgotPassword">
                            <i v-if="isLoading" class="pi pi-spinner pi-spin"></i>
                        </Button>
                    </div>
                    <footer class="text-center mt-8">
                        <p>Todos os direitos reservados do Joga Junto</p>
                        <p>Theme based on PrimeVue</p>
                    </footer>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.pi-eye {
    transform: scale(1.6);
    margin-right: 1rem;
}

.pi-eye-slash {
    transform: scale(1.6);
    margin-right: 1rem;
}

footer {
    color: var(--text-color);
    background-color: var(--surface-50);
    padding: 1rem;
}
</style>
