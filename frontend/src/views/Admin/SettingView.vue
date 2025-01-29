<script setup>
import BusinessAddress from '@/components/Settings/BusinessAddress.vue';
import BusinessHours from '@/components/Settings/BusinessHours.vue';
import BusinessInfo from '@/components/Settings/BusinessInfo.vue';
import BusinessSocial from '@/components/Settings/BusinessSocial.vue';
import { ref } from 'vue';

const step = ref(0);

const items = [{ label: 'Informações do Negócio' }, { label: 'Endereço' }, { label: 'Horário de Funcionamento' }, { label: 'Redes Sociais' }];

function nextStep() {
    if (step.value < items.length - 1) {
        step.value++;
    }
}

function previousStep() {
    if (step.value > 0) {
        step.value--;
    }
}

function finishRegistration() {
    // Lógica para finalizar o cadastro
    console.log('Cadastro finalizado');
}
</script>

<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-6xl p-8">
            <Stepper :value="step + 1">
                <StepList>
                    <Step :value="1">Informações do Negócio</Step>
                    <Step :value="2">Endereço</Step>
                    <Step :value="3">Horário de Funcionamento</Step>
                    <Step :value="4">Redes Sociais</Step>
                </StepList>
            </Stepper>
            <div v-if="step === 0" class="bg-white shadow-lg rounded-lg p-8 card">
                <BusinessInfo @next="nextStep" />
            </div>
            <div v-if="step === 1" class="bg-white shadow-lg rounded-lg p-8 card">
                <BusinessAddress @next="nextStep" @previous="previousStep" />
            </div>
            <div v-if="step === 2" class="bg-white shadow-lg rounded-lg p-8 card">
                <BusinessHours @next="nextStep" @previous="previousStep" />
            </div>
            <div v-if="step === 3" class="bg-white shadow-lg rounded-lg p-8 card">
                <BusinessSocial @finish="finishRegistration" @previous="previousStep" />
            </div>
        </div>
    </div>
</template>

<style scoped>
@media (max-width: 768px) {
    .steps-container {
        display: none;
    }
    .card {
        width: 100%;
        padding: 7px;
    }
    .w-full.max-w-6xl.p-8 {
        padding: 15px;
    }
}
</style>
