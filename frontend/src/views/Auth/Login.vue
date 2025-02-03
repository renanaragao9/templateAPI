<script setup>
import { ref, onMounted } from 'vue';
import { useToast } from 'primevue/usetoast';
import { useAuthStore } from '@/stores/authStore';

const email = ref('');
const password = ref('');
const isLoading = ref(false);
const toast = useToast();
const authStore = useAuthStore();

const handleLogin = async () => {
    if (!email.value || !password.value) {
        toast.add({ severity: 'warn', summary: 'Atenção', detail: 'Por favor, preencha todos os campos.', life: 3000 });
        return;
    }

    isLoading.value = true;
    try {
        await authStore.login({
            email: email.value,
            password: password.value
        });
        toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Login realizado com sucesso!', life: 3000 });
        window.location.href = '/';
    } catch (error) {
        const errorMessage = error.response?.data?.message || 'Erro no login';
        toast.add({ severity: 'error', summary: 'Erro', detail: 'Erro no login: ' + errorMessage, life: 3000 });
    } finally {
        isLoading.value = false;
    }
};

const handleGoogleLogin = () => {
    authStore.redirectToGoogle();
};

// Captura o token da URL e chama handleSocialAuthCallback
onMounted(async () => {
    const urlParams = new URLSearchParams(window.location.search);
    const token = urlParams.get('token');
    if (token) {
        try {
            await authStore.handleSocialAuthCallback(token);
            toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Autenticação social realizada com sucesso!', life: 3000 });
            window.location.href = '/';
        } catch (error) {
            toast.add({ severity: 'error', summary: 'Erro', detail: 'Falha na autenticação social', life: 3000 });
        }
    }
});
</script>

<template>
    <FloatingConfigurator />
    <Toast />
    <div class="bg-surface-50 dark:bg-surface-950 flex items-center justify-center min-h-screen min-w-[100vw] overflow-hidden">
        <div class="flex flex-col items-center justify-center mt-3">
            <div style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">
                <div class="w-full bg-surface-0 dark:bg-surface-900 py-20 px-8 sm:px-20" style="border-radius: 53px">
                    <div class="text-center mb-8">
                        <div class="text-surface-900 dark:text-surface-0 text-3xl font-medium mb-4">Bem-vindo ao Joga Junto!</div>
                        <span class="text-muted-color font-medium">Faça login para continuar</span>
                    </div>

                    <div>
                        <label for="email1" class="block text-surface-900 dark:text-surface-0 text-xl font-medium mb-2">Email</label>
                        <InputText id="email1" type="text" placeholder="Endereço de email" class="w-full md:w-[30rem] mb-8" v-model="email" />

                        <label for="password1" class="block text-surface-900 dark:text-surface-0 font-medium text-xl mb-2">Senha</label>
                        <Password id="password1" v-model="password" placeholder="Senha" :toggleMask="true" class="mb-4" fluid :feedback="false"></Password>

                        <div class="flex items-center justify-between mt-2 mb-8 gap-8">
                            <div class="flex items-center">
                                <Checkbox v-model="checked" id="rememberme1" binary class="mr-2"></Checkbox>
                                <label for="rememberme1">Lembrar-me</label>
                            </div>
                            <router-link to="/redefinir-senha" class="font-medium no-underline ml-2 text-right cursor-pointer text-primary">Esqueceu a senha?</router-link>
                        </div>
                        <Button :label="isLoading ? 'Entrando...' : 'Entrar'" class="w-full" :disabled="isLoading" @click="handleLogin">
                            <i v-if="isLoading" class="pi pi-spinner pi-spin"></i>
                        </Button>
                    </div>
                    <div class="w-full md:w-2/12 my-4">
                        <Divider layout="horizontal" class="!flex md:!hidden" align="center"><b>OU</b></Divider>
                    </div>
                    <div class="flex flex-col md:flex-row items-center justify-center gap-4">
                        <Button label="Login com Google" class="w-full md:w-auto" icon="pi pi-google" @click="handleGoogleLogin" />
                        <Button label="Login com Outlook" class="w-full md:w-auto" icon="pi pi-microsoft" />
                    </div>
                    <div class="text-center mt-4">
                        <span>Ou se não possui cadastro, </span>
                        <router-link to="/register" class="font-medium no-underline text-primary">cadastre-se aqui!</router-link>
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
