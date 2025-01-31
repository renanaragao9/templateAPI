<script setup>
import FloatingConfigurator from '@/components/FloatingConfigurator.vue';
import { ref, computed, onMounted } from 'vue';
import { useAuthStore } from '@/stores/authStore';
import { useToast } from 'primevue/usetoast';
import { useRoute } from 'vue-router';

const newPassword = ref('');
const confirmPassword = ref('');
const email = ref('');
const token = ref('');
const isLoading = ref(false);
const isRedirecting = ref(false);
const showPasswordRules = ref(false);
const showConfirmPasswordRules = ref(false);

const authStore = useAuthStore();
const toast = useToast();
const route = useRoute();

onMounted(() => {
    email.value = route.query.email || '';
    token.value = route.query.token || '';
});

const passwordRules = computed(() => {
    return {
        length: newPassword.value.length >= 8,
        uppercase: /[A-Z]/.test(newPassword.value),
        lowercase: /[a-z]/.test(newPassword.value),
        number: /[0-9]/.test(newPassword.value),
        special: /[!@#$%^&*(),.?":{}|<>]/.test(newPassword.value)
    };
});

const passwordsMatch = computed(() => {
    return newPassword.value === confirmPassword.value;
});

const isFormValid = computed(() => {
    return Object.values(passwordRules.value).every((rule) => rule) && passwordsMatch.value;
});

const handleResetPassword = async () => {
    if (!newPassword.value || !confirmPassword.value) {
        toast.add({ severity: 'warn', summary: 'Atenção', detail: 'Por favor, preencha todos os campos.', life: 3000 });
        return;
    }

    if (!passwordsMatch.value) {
        toast.add({ severity: 'warn', summary: 'Atenção', detail: 'As senhas não coincidem.', life: 3000 });
        return;
    }

    isLoading.value = true;
    try {
        await authStore.resetPassword({
            email: email.value,
            password: newPassword.value,
            password_confirmation: confirmPassword.value,
            token: token.value
        });
        toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Senha redefinida com sucesso!', life: 3000 });
        isRedirecting.value = true;
        setTimeout(() => {
            window.location.href = '/login';
        }, 2000);
    } catch (error) {
        const errorMessage = error.response?.data?.message || 'Erro ao redefinir a senha';
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
                        <div class="text-surface-900 dark:text-surface-0 text-3xl font-medium mb-4">Redefinir Senha</div>
                        <span class="text-muted-color font-medium">Insira sua nova senha</span>
                    </div>

                    <div>
                        <label for="newPassword" class="block text-surface-900 dark:text-surface-0 text-xl font-medium mb-2">Nova senha</label>
                        <Password id="newPassword" v-model="newPassword" placeholder="********" :toggleMask="true" class="mb-4" fluid :feedback="false" @focus="showPasswordRules = true" @blur="showPasswordRules = false"></Password>

                        <div v-if="showPasswordRules" class="password-rules-card">
                            <p :class="{ 'text-green-500': passwordRules.length, 'text-red-500': !passwordRules.length }">Mínimo de 8 caracteres</p>
                            <p :class="{ 'text-green-500': passwordRules.uppercase, 'text-red-500': !passwordRules.uppercase }">Pelo menos uma letra maiúscula</p>
                            <p :class="{ 'text-green-500': passwordRules.lowercase, 'text-red-500': !passwordRules.lowercase }">Pelo menos uma letra minúscula</p>
                            <p :class="{ 'text-green-500': passwordRules.number, 'text-red-500': !passwordRules.number }">Pelo menos um número</p>
                            <p :class="{ 'text-green-500': passwordRules.special, 'text-red-500': !passwordRules.special }">Pelo menos um caractere especial</p>
                        </div>

                        <label for="confirmPassword" class="block text-surface-900 dark:text-surface-0 text-xl font-medium mb-2">Confirmar senha</label>
                        <Password
                            id="confirmPassword"
                            v-model="confirmPassword"
                            placeholder="********"
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

                        <Button :label="isLoading ? (isRedirecting ? 'Redirecionando...' : 'Redefinindo...') : 'Redefinir senha'" class="w-full" :disabled="!isFormValid || isLoading || isRedirecting" @click="handleResetPassword">
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

.password-rules-card {
    background-color: var(--surface-0);
    border: 1px solid var(--primary-color);
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
}

footer {
    color: var(--text-color);
    background-color: var(--surface-50);
    padding: 1rem;
}
</style>
