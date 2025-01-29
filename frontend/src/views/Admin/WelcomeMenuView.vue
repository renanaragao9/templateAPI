<script setup>
import { ref } from 'vue';

const email = ref('');
const password = ref('');
const checked = ref(false);
</script>

<template>
    <div class="bg-surface-50 dark:bg-surface-950 flex items-center justify-center min-h-screen min-w-[100vw] overflow-hidden">
        <div class="flex flex-col items-center justify-center w-full max-w-md mx-auto">
            <div style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">
                <div class="w-full bg-surface-0 dark:bg-surface-900 py-20 px-8 sm:px-20" style="border-radius: 53px">
                    <div class="text-center mb-8">
                        <div class="text-surface-900 dark:text-surface-0 text-3xl font-medium mb-4">Bem-vindo ao Joga Junto!</div>
                        <span class="text-muted-color font-medium">Escolha uma rede social para continuar</span>
                    </div>

                    <div class="grid grid-cols-1 gap-8">
                        <div class="card">
                            <div class="card-header">
                                <i class="pi pi-instagram text-6xl text-primary mx-auto"></i>
                            </div>
                            <div class="card-body text-center">
                                <h3 class="text-xl font-medium">Instagram</h3>
                                <p class="text-muted-color">Conecte-se com o nosso Instagram</p>
                                <Button label="Conectar" class="w-full mt-4" icon="pi pi-instagram" />
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <i class="pi pi-facebook text-6xl text-primary mx-auto"></i>
                            </div>
                            <div class="card-body text-center">
                                <h3 class="text-xl font-medium">Facebook</h3>
                                <p class="text-muted-color">Conecte-se com o nosso Facebook</p>
                                <Button label="Conectar" class="w-full mt-4" icon="pi pi-facebook" />
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <i class="pi pi-twitter text-6xl text-primary mx-auto"></i>
                            </div>
                            <div class="card-body text-center">
                                <h3 class="text-xl font-medium">Twitter</h3>
                                <p class="text-muted-color">Conecte-se com o nosso Twitter</p>
                                <Button label="Conectar" class="w-full mt-4" icon="pi pi-twitter" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center mt-8">
        <p>Todos os direitos reservados do Joga Junto</p>
        <p>Theme based on PrimeVue</p>
    </footer>
</template>

<style scoped>
.card {
    background-color: var(--surface-0);
    border-radius: 12px;
    padding: 1rem;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-header {
    margin-bottom: 1rem;
}

footer {
    color: var(--text-color);
    background-color: var(--surface-50);
    padding: 1rem;
}
</style>
