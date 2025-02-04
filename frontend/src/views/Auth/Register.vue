<script setup>
import FloatingConfigurator from '@/components/FloatingConfigurator.vue';
import { ref, computed, onMounted } from 'vue';
import { useAuthStore } from '@/stores/authStore';
import { useToast } from 'primevue/usetoast';
import ProgressSpinner from 'primevue/progressspinner';

const name = ref('');
const email = ref('');
const password = ref('');
const confirmPassword = ref('');
const checked = ref(false);
const isLoading = ref(false);
const showPasswordRules = ref(false);
const showConfirmPasswordRules = ref(false);
const showSuccessLoader = ref(false);
const showGoogleRegister = ref(false);
const showMicrosoftRegister = ref(false);

const authStore = useAuthStore();
const toast = useToast();

onMounted(() => {
    if (authStore.isAuthenticated) {
        window.location.href = '/';
    }
});

const passwordRules = computed(() => {
    return {
        length: password.value.length >= 8,
        uppercase: /[A-Z]/.test(password.value),
        lowercase: /[a-z]/.test(password.value),
        number: /[0-9]/.test(password.value),
        special: /[!@#$%^&*(),.?":{}|<>]/.test(password.value)
    };
});

const passwordsMatch = computed(() => {
    return password.value === confirmPassword.value;
});

const isFormValid = computed(() => {
    return Object.values(passwordRules.value).every((rule) => rule) && passwordsMatch.value;
});

const buttonLabel = computed(() => {
    if (isLoading.value) {
        return 'Registrando...';
    }
    if (!isFormValid.value) {
        return 'Preencha todos os dados';
    }
    return 'Registrar';
});

const handleRegister = async () => {
    if (!name.value || !email.value || !password.value || !confirmPassword.value) {
        toast.add({ severity: 'warn', summary: 'Atenção', detail: 'Por favor, preencha todos os campos.', life: 3000 });
        return;
    }

    if (!passwordsMatch.value) {
        toast.add({ severity: 'warn', summary: 'Atenção', detail: 'As senhas não coincidem.', life: 3000 });
        return;
    }

    isLoading.value = true;
    try {
        await authStore.register({
            name: name.value,
            email: email.value,
            password: password.value
        });
        toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Registro realizado com sucesso! Redirecionando...', life: 3000 });
        showSuccessLoader.value = true;
        setTimeout(() => {
            window.location.href = '/login';
        }, 4000);
    } catch (error) {
        const errorMessage = error.response?.data?.message || 'Erro no registro';
        toast.add({ severity: 'error', summary: 'Erro', detail: 'Erro no registro: ' + errorMessage, life: 3000 });
    } finally {
        isLoading.value = false;
    }
};

const redirectToGoogle = () => {
    authStore.redirectToGoogle();
};
</script>

<template>
    <FloatingConfigurator />
    <Toast />
    <div class="bg-surface-50 dark:bg-surface-950 flex items-center justify-center min-h-screen min-w-[100vw] overflow-hidden">
        <div class="flex flex-col items-center justify-center mt-3">
            <div style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">
                <div class="w-full bg-surface-0 dark:bg-surface-900 py-20 px-8 sm:px-20" style="border-radius: 53px">
                    <div class="text-center mb-8">
                        <div class="text-surface-900 dark:text-surface-0 text-3xl font-medium mb-4">Crie sua conta no Joga Junto!</div>
                        <span class="text-muted-color font-medium">Preencha os campos abaixo para se registrar</span>
                    </div>

                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 md:col-span-6">
                            <label for="name" class="block text-surface-900 dark:text-surface-0 text-xl font-medium mb-2">Nome</label>
                            <InputText id="name" type="text" placeholder="Seu nome" class="w-full mb-8" v-model="name" />
                        </div>

                        <div class="col-span-12 md:col-span-6">
                            <label for="email" class="block text-surface-900 dark:text-surface-0 text-xl font-medium mb-2">Email</label>
                            <InputText id="email" type="text" placeholder="Endereço de email" class="w-full mb-8" v-model="email" />
                        </div>

                        <div class="col-span-12 md:col-span-6">
                            <label for="password" class="block text-surface-900 dark:text-surface-0 font-medium text-xl mb-2">Senha</label>
                            <Password id="password" v-model="password" placeholder="Senha" :toggleMask="true" class="mb-4" fluid :feedback="false" @focus="showPasswordRules = true" @blur="showPasswordRules = false"></Password>

                            <div v-if="showPasswordRules" class="password-rules-card">
                                <p :class="{ 'text-green-500': passwordRules.length, 'text-red-500': !passwordRules.length }">Mínimo de 8 caracteres</p>
                                <p :class="{ 'text-green-500': passwordRules.uppercase, 'text-red-500': !passwordRules.uppercase }">Pelo menos uma letra maiúscula</p>
                                <p :class="{ 'text-green-500': passwordRules.lowercase, 'text-red-500': !passwordRules.lowercase }">Pelo menos uma letra minúscula</p>
                                <p :class="{ 'text-green-500': passwordRules.number, 'text-red-500': !passwordRules.number }">Pelo menos um número</p>
                                <p :class="{ 'text-green-500': passwordRules.special, 'text-red-500': !passwordRules.special }">Pelo menos um caractere especial</p>
                            </div>
                        </div>

                        <div class="col-span-12 md:col-span-6">
                            <label for="confirmPassword" class="block text-surface-900 dark:text-surface-0 font-medium text-xl mb-2">Confirme a senha</label>
                            <Password
                                id="confirmPassword"
                                v-model="confirmPassword"
                                placeholder="Confirme a senha"
                                :toggleMask="true"
                                class="mb-4"
                                fluid
                                :feedback="false"
                                @focus="showConfirmPasswordRules = true"
                                @blur="showConfirmPasswordRules = false"
                            ></Password>

                            <div v-if="showConfirmPasswordRules" class="password-rules-card">
                                <p :class="{ 'text-green-500': passwordRules.length, 'text-red-500': !passwordRules.length }">Mínimo de 8 caracteres</p>
                                <p :class="{ 'text-green-500': passwordRules.uppercase, 'text-red-500': !passwordRules.uppercase }">Pelo menos uma letra maiúscula</p>
                                <p :class="{ 'text-green-500': passwordRules.lowercase, 'text-red-500': !passwordRules.lowercase }">Pelo menos uma letra minúscula</p>
                                <p :class="{ 'text-green-500': passwordRules.number, 'text-red-500': !passwordRules.number }">Pelo menos um número</p>
                                <p :class="{ 'text-green-500': passwordRules.special, 'text-red-500': !passwordRules.special }">Pelo menos um caractere especial</p>
                                <p :class="{ 'text-green-500': passwordsMatch, 'text-red-500': !passwordsMatch }">{{ passwordsMatch ? 'As senhas coincidem' : 'As senhas não coincidem' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-2 mb-8 gap-8">
                        <div class="flex items-center">
                            <Checkbox v-model="checked" id="terms" binary class="mr-2"></Checkbox>
                            <label for="terms">Aceito os termos e condições</label>
                        </div>
                    </div>
                    <Button :label="buttonLabel" class="w-full" :disabled="!isFormValid || isLoading" @click="handleRegister">
                        <i v-if="isLoading" class="pi pi-spinner pi-spin"></i>
                    </Button>
                    <div class="w-full md:w-2/12 my-4">
                        <Divider layout="horizontal" class="!flex md:!hidden" align="center"><b>OU</b></Divider>
                    </div>
                    <div class="flex flex-col md:flex-row items-center justify-center gap-4">
                        <Button v-if="showGoogleRegister" label="Registrar com Google" class="w-full md:w-auto" icon="pi pi-google" @click="redirectToGoogle" target="_blank" />
                        <Button v-if="showMicrosoftRegister" label="Registrar com Microsoft" class="w-full md:w-auto" icon="pi pi-microsoft" />
                    </div>
                    <div class="text-center mt-4">
                        <span>Ou se já possui cadastro, </span>
                        <router-link to="/login" class="font-medium no-underline text-primary">faça login aqui!</router-link>
                    </div>
                    <footer class="text-center mt-8">
                        <p>Todos os direitos reservados do Joga Junto</p>
                        <p>Theme based on PrimeVue</p>
                    </footer>
                </div>
            </div>
        </div>
    </div>
    <div v-if="showSuccessLoader" class="flex items-center justify-center min-h-screen">
        <ProgressSpinner />
        <p class="ml-4">Redirecionando...</p>
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

.password-rules-card {
    background-color: var(--surface-0);
    border: 1px solid var(--primary-color);
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
    transition: transform 0.3s ease-in-out;
}

.password-rules-card:hover {
    transform: translateY(10px);
    opacity: 1;
}
</style>
