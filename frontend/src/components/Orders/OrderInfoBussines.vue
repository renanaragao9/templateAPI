<script setup>
import { PhotoService } from '@/service/PhotoService';
import { format } from 'date-fns';
import { ptBR } from 'date-fns/locale';
import { onMounted, ref } from 'vue';

const images = ref([]); // Preencher com dados das imagens
const businessInfo = ref({
    name: 'Nome do Negócio',
    cnpj: '00.000.000/0000-00',
    phone: '(00) 0000-0000',
    email: 'email@negocio.com',
    ownerName: 'Nome do Proprietário',
    ownerCPF: '000.000.000-00',
    description: 'Descrição do negócio'
});

const currentDate = ref(format(new Date(), 'dd/MM/yyyy', { locale: ptBR }));
const currentTime = ref(format(new Date(), 'HH:mm:ss', { locale: ptBR }));
const currentDayOfWeek = ref(format(new Date(), 'EEEE', { locale: ptBR }));
const isOpen = ref(true); // Estado para controlar se o negócio está aberto ou fechado

onMounted(() => {
    // Preencher com dados das imagens
    PhotoService.getImages().then((data) => (images.value = data));

    // Atualizar a hora atual a cada segundo
    setInterval(() => {
        currentTime.value = format(new Date(), 'HH:mm:ss', { locale: ptBR });
    }, 1000);
});
</script>

<template>
    <div :class="['card p-4 grid grid-cols-12 gap-8', isOpen ? 'border-green-500' : 'border-red-500']" :style="{ borderWidth: '2px' }">
        <div class="col-span-full lg:col-span-4 flex flex-col items-center">
            <!-- Preencher com a URL da imagem do negócio -->
            <img src="https://primefaces.org/cdn/primevue/images/galleria/galleria10.jpg" alt="Imagem do Negócio" class="mb-4 w-3/4 h-auto" />
            <div class="flex items-center mt-4">
                <label class="mr-4 text-2xl font-bold">{{ isOpen ? 'Aberto' : 'Fechado' }}</label>
                <ToggleSwitch v-model="isOpen" class="transform scale-125" />
            </div>
        </div>
        <div class="col-span-full lg:col-span-8">
            <div class="grid grid-cols-12 gap-2">
                <div class="col-span-12 lg:col-span-4">
                    <label class="text-lg">Data Atual</label>
                    <p class="font-bold text-gray-700 text-xl dark:text-white">{{ currentDate }}</p>
                </div>
                <div class="col-span-12 lg:col-span-4">
                    <label class="text-lg">Hora Atual</label>
                    <p class="font-bold text-gray-700 text-xl dark:text-white">{{ currentTime }}</p>
                </div>
                <div class="col-span-12 lg:col-span-4">
                    <label class="text-lg">Dia da Semana</label>
                    <p class="font-bold text-gray-700 text-xl dark:text-white">{{ currentDayOfWeek }}</p>
                </div>
                <div class="col-span-12 lg:col-span-4">
                    <label>Nome do Negócio</label>
                    <p>{{ businessInfo.name }}</p>
                </div>
                <div class="col-span-12 lg:col-span-4">
                    <label>CNPJ</label>
                    <p>{{ businessInfo.cnpj }}</p>
                </div>
                <div class="col-span-12 lg:col-span-4">
                    <label>Telefone</label>
                    <p>{{ businessInfo.phone }}</p>
                </div>
                <div class="col-span-12 lg:col-span-4">
                    <label>Email</label>
                    <p>{{ businessInfo.email }}</p>
                </div>
                <div class="col-span-12 lg:col-span-4">
                    <label>Nome do Proprietário</label>
                    <p>{{ businessInfo.ownerName }}</p>
                </div>
                <div class="col-span-12 lg:col-span-4">
                    <label>CPF do Proprietário</label>
                    <p>{{ businessInfo.ownerCPF }}</p>
                </div>
                <div class="col-span-12 lg:col-span-12">
                    <label>Descrição</label>
                    <p>{{ businessInfo.description }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
