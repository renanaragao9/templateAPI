<script setup>
import { Button, InputText, Textarea } from 'primevue';
import { ref, watch } from 'vue';

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
        .replace(/(\d{5})(\d)/, '$1-$2')
        .slice(0, 15);
}

function maskCPF(value) {
    return value
        .replace(/\D/g, '')
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d{1,2})$/, '$1-$2')
        .slice(0, 14);
}

const businessCNPJ = ref('');
const businessPhone = ref('');
const ownerCPF = ref('');

function applyMaskCNPJ(event) {
    businessCNPJ.value = maskCNPJ(event.target.value);
}

function applyMaskPhone(event) {
    businessPhone.value = maskPhone(event.target.value);
}

function applyMaskCPF(event) {
    ownerCPF.value = maskCPF(event.target.value);
}

// Watchers to force the mask application
watch(businessCNPJ, (newValue) => {
    businessCNPJ.value = maskCNPJ(newValue);
});

watch(businessPhone, (newValue) => {
    businessPhone.value = maskPhone(newValue);
});

watch(ownerCPF, (newValue) => {
    ownerCPF.value = maskCPF(newValue);
});
</script>

<template>
    <div class="card p-4">
        <div class="font-semibold text-xl mb-4">Informações do Negócio</div>
        <div class="text-lg mb-4">
            Bem-vindo ao Joga Junto! Por favor, preencha as informações abaixo para completar seu cadastro. Certifique-se de fornecer todos os detalhes necessários, incluindo o nome do seu negócio, CNPJ, telefone de contato, email, nome do
            proprietário e CPF. Essas informações são essenciais para que possamos oferecer a melhor experiência possível.
        </div>
        <div class="grid grid-cols-12 gap-2">
            <div class="col-span-12 lg:col-span-4">
                <label for="businessName">Nome do Negócio <span class="text-red-500">*</span></label>
                <InputText id="businessName" type="text" class="w-full" />
                <small>Preencha com o nome oficial do seu negócio.</small>
            </div>
            <div class="col-span-12 lg:col-span-4">
                <label for="businessCNPJ">CNPJ </label>
                <InputText id="businessCNPJ" type="text" class="w-full" v-model="businessCNPJ" @input="applyMaskCNPJ" maxlength="18" />
                <small>Informe o CNPJ do seu negócio.</small>
            </div>
            <div class="col-span-12 lg:col-span-4">
                <label for="businessPhone">Telefone <span class="text-red-500">*</span></label>
                <InputText id="businessPhone" type="text" class="w-full" v-model="businessPhone" @input="applyMaskPhone" maxlength="15" />
                <small>Digite o telefone de contato do seu negócio.</small>
            </div>
            <div class="col-span-12 lg:col-span-4">
                <label for="businessEmail">Email <span class="text-red-500">*</span></label>
                <InputText id="businessEmail" type="text" class="w-full" />
                <small>Informe o email de contato do seu negócio.</small>
            </div>
            <div class="col-span-12 lg:col-span-4">
                <label for="ownerName">Nome do Proprietário <span class="text-red-500">*</span></label>
                <InputText id="ownerName" type="text" class="w-full" />
                <small>Preencha com o nome completo do proprietário do negócio.</small>
            </div>
            <div class="col-span-12 lg:col-span-4">
                <label for="ownerCPF">CPF do Proprietário <span class="text-red-500">*</span></label>
                <InputText id="ownerCPF" type="text" class="w-full" v-model="ownerCPF" @input="applyMaskCPF" maxlength="14" />
                <small>Informe o CPF do proprietário do negócio. Este campo é obrigatório.</small>
            </div>
            <div class="col-span-12 lg:col-span-12">
                <label for="businessDescription">Descrição</label>
                <Textarea id="businessDescription" rows="4" class="w-full" />
                <small>Descreva brevemente o seu negócio, incluindo os principais produtos ou serviços oferecidos.</small>
            </div>
        </div>
        <Button label="Próximo" @click="$emit('next')" class="mt-4" />
    </div>
</template>
