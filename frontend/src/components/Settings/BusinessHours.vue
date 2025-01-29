<script setup>
import { Button, InputText, ToggleButton } from 'primevue';
import { computed, ref } from 'vue';

// Definindo os dias da semana com horários de abertura e fechamento padrão
const days = ref([
    { day: 'Segunda-feira', openingTime: '00:00', closingTime: '00:00', isClosed: false },
    { day: 'Terça-feira', openingTime: '00:00', closingTime: '00:00', isClosed: false },
    { day: 'Quarta-feira', openingTime: '00:00', closingTime: '00:00', isClosed: false },
    { day: 'Quinta-feira', openingTime: '00:00', closingTime: '00:00', isClosed: false },
    { day: 'Sexta-feira', openingTime: '00:00', closingTime: '00:00', isClosed: false },
    { day: 'Sábado', openingTime: '00:00', closingTime: '00:00', isClosed: false },
    { day: 'Domingo', openingTime: '00:00', closingTime: '00:00', isClosed: false }
]);

// Gerando opções de horários em intervalos de 30 minutos
const timeOptions = ref([]);
for (let h = 0; h < 24; h++) {
    for (let m = 0; m < 60; m += 30) {
        const hour = h.toString().padStart(2, '0');
        const minute = m.toString().padStart(2, '0');
        timeOptions.value.push({ label: `${hour}:${minute}`, value: `${hour}:${minute}` });
    }
}

// Função para lidar com a mudança do estado de "Fechado"
function handleToggleChange(day) {
    if (day.isClosed) {
        day.openingTime = '00:00';
        day.closingTime = '00:00';
    }
}

// Computed property para verificar se todos os dias estão preenchidos corretamente
const isFormValid = computed(() => {
    return days.value.every((day) => day.isClosed || (day.openingTime !== '00:00' && day.closingTime !== '00:00'));
});
</script>

<template>
    <div class="card p-4">
        <div class="font-semibold text-xl mb-4">Horário de Funcionamento</div>
        <div class="text-sm text-gray-600 mb-4">Preencha os horários de abertura e fechamento para cada dia da semana. Utilize o botão de alternância para marcar o dia como "Fechado".</div>
        <div class="grid grid-cols-12 gap-2">
            <!-- Loop através dos dias da semana -->
            <div v-for="(day, index) in days" :key="index" class="col-span-12 flex flex-col lg:flex-row items-start gap-2">
                <!-- Campo de texto para o nome do dia da semana (desabilitado) -->
                <InputText :value="day.day" disabled class="w-full lg:w-auto" />
                <!-- Seção para selecionar o horário de abertura -->
                <div class="flex flex-col sm:flex-row items-start gap-2 col-span-12 lg:col-span-6">
                    <label for="openingTime" class="mr-2">Abertura</label>
                    <select v-model="day.openingTime" class="p-inputtext p-component w-full sm:w-auto" :disabled="day.isClosed">
                        <option v-for="option in timeOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                    </select>
                </div>
                <!-- Seção para selecionar o horário de fechamento -->
                <div class="flex flex-col sm:flex-row items-start gap-2 col-span-12 lg:col-span-6">
                    <label for="closingTime" class="mr-2">Fechamento</label>
                    <select v-model="day.closingTime" class="p-inputtext p-component w-full sm:w-auto" :disabled="day.isClosed">
                        <option v-for="option in timeOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                    </select>
                </div>
                <!-- Botão de alternância para marcar o dia como fechado -->
                <ToggleButton v-model="day.isClosed" onLabel="Fechado" offLabel="Aberto" @change="handleToggleChange(day)" class="w-full lg:w-auto" />
            </div>
        </div>
        <!-- Botões para navegação -->
        <div class="col-span-12 flex justify-between mt-4">
            <Button label="Voltar" @click="$emit('previous')" />
            <Button label="Próximo" :disabled="!isFormValid" @click="$emit('next')" v-tooltip.bottom="!isFormValid ? 'Preencha todos os horários ou marque como fechado.' : ''" />
        </div>
    </div>
</template>
