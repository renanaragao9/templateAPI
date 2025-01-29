<script setup>
import { PhotoService } from '@/service/PhotoService';
import ToggleButton from 'primevue/togglebutton';
import { useToast } from 'primevue/usetoast';
import { onMounted, ref } from 'vue';

const toast = useToast();
const fileupload = ref();
const images = ref([]); // Preencher com dados das imagens
const days = ref([
    { day: 'Segunda-feira', openingTime: '00:00', closingTime: '00:00', isClosed: false },
    { day: 'Terça-feira', openingTime: '00:00', closingTime: '00:00', isClosed: false },
    { day: 'Quarta-feira', openingTime: '00:00', closingTime: '00:00', isClosed: false },
    { day: 'Quinta-feira', openingTime: '00:00', closingTime: '00:00', isClosed: false },
    { day: 'Sexta-feira', openingTime: '00:00', closingTime: '00:00', isClosed: false },
    { day: 'Sábado', openingTime: '00:00', closingTime: '00:00', isClosed: false },
    { day: 'Domingo', openingTime: '00:00', closingTime: '00:00', isClosed: false }
]);

const timeOptions = ref([]);
for (let h = 0; h < 24; h++) {
    for (let m = 0; m < 60; m += 30) {
        const hour = h.toString().padStart(2, '0');
        const minute = m.toString().padStart(2, '0');
        timeOptions.value.push({ label: `${hour}:${minute}`, value: `${hour}:${minute}` });
    }
}

onMounted(() => {
    // Preencher com dados das imagens
    PhotoService.getImages().then((data) => (images.value = data));
});

function upload() {
    fileupload.value.upload();
}

function onUpload() {
    toast.add({ severity: 'info', summary: 'Sucesso', detail: 'Imagem Alterada', life: 3000 });
}

function handleToggleChange(day) {
    if (day.isClosed) {
        day.openingTime = '00:00';
        day.closingTime = '00:00';
    }
}

// Funções de máscara
function maskCNPJ(value) {
    return value
        .replace(/\D/g, '')
        .replace(/^(\d{2})(\d)/, '$1.$2')
        .replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3')
        .replace(/\.(\d{3})(\d)/, '.$1/$2')
        .replace(/(\d{4})(\d)/, '$1-$2')
        .slice(0, 18);
}

function maskPhone(value) {
    return value
        .replace(/\D/g, '')
        .replace(/^(\d{2})(\d)/, '($1) $2')
        .replace(/(\d{4})(\d)/, '$1-$2')
        .slice(0, 14);
}

function maskCEP(value) {
    return value
        .replace(/\D/g, '')
        .replace(/^(\d{5})(\d)/, '$1-$2')
        .slice(0, 9);
}
</script>

<template>
    <div class="grid grid-cols-12 gap-8">
        <div class="col-span-full lg:col-span-4">
            <div class="card p-4">
                <div class="font-semibold text-xl mb-4">Imagem do Negócio</div>
                <!-- Preencher com a URL da imagem do negócio -->
                <img src="https://primefaces.org/cdn/primevue/images/galleria/galleria10.jpg" alt="Imagem do Negócio" class="mb-4 w-full h-auto" />
                <div class="card flex flex-col gap-6 items-center justify-center">
                    <Toast />
                    <FileUpload ref="fileupload" mode="basic" name="demo[]" accept="image/*" :maxFileSize="1000000" @uploader="onUpload" customUpload chooseLabel="Escolher" />
                    <Button label="Alterar Imagem" @click="upload" severity="secondary" />
                </div>
            </div>
            <div class="card mt-8 p-4">
                <div class="font-semibold text-xl mb-4">Redes Sociais</div>
                <div class="flex flex-col gap-2">
                    <label for="facebook">Facebook</label>
                    <!-- Preencher com o link do Facebook -->
                    <InputText id="facebook" type="text" />
                </div>
                <div class="flex flex-col gap-2">
                    <label for="instagram">Instagram</label>
                    <!-- Preencher com o link do Instagram -->
                    <InputText id="instagram" type="text" />
                </div>
                <div class="flex flex-col gap-2">
                    <label for="twitter">Twitter</label>
                    <!-- Preencher com o link do Twitter -->
                    <InputText id="twitter" type="text" />
                </div>
            </div>
            <div class="card mt-8 p-4">
                <div class="font-semibold text-xl mb-4">Últimas Sessões</div>
                <div class="flex flex-col gap-2">
                    <!-- Adicione aqui o conteúdo das últimas sessões -->
                </div>
            </div>
        </div>
        <div class="col-span-full lg:col-span-8">
            <div class="card p-4">
                <div class="font-semibold text-xl mb-4">Informações do Negócio</div>
                <div class="grid grid-cols-12 gap-2">
                    <div class="col-span-12 lg:col-span-4">
                        <label for="businessName">Nome do Negócio</label>
                        <!-- Preencher com o nome do negócio -->
                        <InputText id="businessName" type="text" class="w-full" />
                    </div>
                    <div class="col-span-12 lg:col-span-4">
                        <label for="businessCNPJ">CNPJ</label>
                        <!-- Preencher com o CNPJ do negócio -->
                        <InputText id="businessCNPJ" type="text" class="w-full" @input="(event) => (event.target.value = maskCNPJ(event.target.value))" />
                    </div>
                    <div class="col-span-12 lg:col-span-4">
                        <label for="businessPhone">Telefone</label>
                        <!-- Preencher com o telefone do negócio -->
                        <InputText id="businessPhone" type="text" class="w-full" @input="(event) => (event.target.value = maskPhone(event.target.value))" />
                    </div>
                    <div class="col-span-12 lg:col-span-4">
                        <label for="businessEmail">Email</label>
                        <!-- Preencher com o email do negócio -->
                        <InputText id="businessEmail" type="text" class="w-full" />
                    </div>
                    <div class="col-span-12 lg:col-span-4">
                        <label for="ownerName">Nome do Proprietário</label>
                        <!-- Preencher com o nome do proprietário do negócio -->
                        <InputText id="ownerName" type="text" class="w-full" />
                    </div>
                    <div class="col-span-12 lg:col-span-4">
                        <label for="ownerCPF">CPF do Proprietário</label>
                        <!-- Preencher com o CPF do proprietário do negócio -->
                        <InputText id="ownerCPF" type="text" class="w-full" @input="(event) => (event.target.value = maskCPF(event.target.value))" />
                    </div>
                    <div class="col-span-12 lg:col-span-12">
                        <label for="businessDescription">Descrição</label>
                        <!-- Preencher com a descrição do negócio -->
                        <Textarea id="businessDescription" rows="4" class="w-full" />
                    </div>
                </div>
            </div>
            <div class="card mt-8 p-4">
                <div class="font-semibold text-xl mb-4">Horário de Funcionamento</div>
                <div class="grid grid-cols-12 gap-2">
                    <div v-for="(day, index) in days" :key="index" class="col-span-12 flex flex-col lg:flex-row items-start gap-2">
                        <InputText :value="day.day" disabled class="w-full lg:w-auto" />
                        <div class="flex flex-col sm:flex-row items-start gap-2 col-span-12 lg:col-span-6">
                            <label for="openingTime" class="mr-2">Abertura</label>
                            <!-- Preencher com o horário de abertura -->
                            <select v-model="day.openingTime" class="p-inputtext p-component w-full sm:w-auto" :disabled="day.isClosed">
                                <option v-for="option in timeOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                            </select>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start gap-2 col-span-12 lg:col-span-6">
                            <label for="closingTime" class="mr-2">Fechamento</label>
                            <!-- Preencher com o horário de fechamento -->
                            <select v-model="day.closingTime" class="p-inputtext p-component w-full sm:w-auto" :disabled="day.isClosed">
                                <option v-for="option in timeOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                            </select>
                        </div>
                        <ToggleButton v-model="day.isClosed" onLabel="Fechado" offLabel="Aberto" @change="handleToggleChange(day)" class="w-full lg:w-auto" />
                    </div>
                </div>
            </div>
            <div class="card mt-8 p-4">
                <div class="font-semibold text-xl mb-4">Endereço</div>
                <div class="grid grid-cols-12 gap-2">
                    <div class="col-span-12 lg:col-span-4">
                        <label for="businessZip">CEP</label>
                        <!-- Preencher com o CEP do negócio -->
                        <InputText id="businessZip" type="text" class="w-full" @input="(event) => (event.target.value = maskCEP(event.target.value))" />
                    </div>
                    <div class="col-span-12 lg:col-span-4">
                        <label for="businessStreet">Rua</label>
                        <!-- Preencher com a rua do negócio -->
                        <InputText id="businessStreet" type="text" class="w-full" />
                    </div>
                    <div class="col-span-12 lg:col-span-4">
                        <label for="businessNumber">Número</label>
                        <!-- Preencher com o número do endereço do negócio -->
                        <InputText id="businessNumber" type="text" class="w-full" />
                    </div>
                    <div class="col-span-12 lg:col-span-4">
                        <label for="businessNeighborhood">Bairro</label>
                        <!-- Preencher com o bairro do negócio -->
                        <InputText id="businessNeighborhood" type="text" class="w-full" />
                    </div>
                    <div class="col-span-12 lg:col-span-4">
                        <label for="businessCity">Cidade</label>
                        <!-- Preencher com a cidade do negócio -->
                        <InputText id="businessCity" type="text" class="w-full" />
                    </div>
                    <div class="col-span-12 lg:col-span-4">
                        <label for="businessState">Estado</label>
                        <!-- Preencher com o estado do negócio -->
                        <InputText id="businessState" type="text" class="w-full" />
                    </div>
                    <div class="col-span-12 lg:col-span-4">
                        <label for="businessCountry">País</label>
                        <!-- Preencher com o país do negócio -->
                        <InputText id="businessCountry" type="text" class="w-full" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
