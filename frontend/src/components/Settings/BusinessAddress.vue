<script setup>
import axios from 'axios';
import { Button, InputText } from 'primevue';
import { computed, ref } from 'vue';

const businessZip = ref('');
const businessStreet = ref('');
const businessNeighborhood = ref('');
const businessCity = ref('');
const businessState = ref('');
const businessNumber = ref('');
const businessComplement = ref('');

function maskCEP(value) {
    return value
        .replace(/\D/g, '')
        .replace(/^(\d{5})(\d)/, '$1-$2')
        .slice(0, 9);
}

function fetchAddress(cep) {
    axios
        .get(`https://viacep.com.br/ws/${cep}/json/`)
        .then((response) => {
            const data = response.data;
            businessStreet.value = data.logradouro;
            businessNeighborhood.value = data.bairro;
            businessCity.value = data.localidade;
            businessState.value = data.uf;
        })
        .catch((error) => {
            console.error('Erro ao buscar o endereço:', error);
        });
}

const maskedBusinessZip = computed({
    get() {
        return businessZip.value;
    },
    set(value) {
        const maskedValue = maskCEP(value);
        businessZip.value = maskedValue;
        if (maskedValue.length === 9) {
            fetchAddress(maskedValue.replace('-', ''));
        }
    }
});

const isNextButtonDisabled = computed(() => {
    return businessZip.value.length !== 9 || !businessStreet.value || !businessNeighborhood.value || !businessCity.value || !businessState.value || !businessNumber.value;
});
</script>

<template>
    <div class="card p-4">
        <div class="font-semibold text-xl mb-4">Endereço</div>
        <p class="mb-4">
            Preencha o CEP para autocompletar os campos de endereço. Caso não saiba o CEP, <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" target="_blank" class="text-blue-500 underline">clique aqui para buscar o CEP</a>.
        </p>
        <div class="grid grid-cols-12 gap-2">
            <div class="col-span-12 lg:col-span-4">
                <label for="businessZip">CEP <span class="text-red-500">*</span></label>
                <InputText id="businessZip" type="text" class="w-full" v-model="maskedBusinessZip" maxlength="9" placeholder="Digite o CEP" />
            </div>
            <div class="col-span-12 lg:col-span-4">
                <label for="businessStreet">Rua <span class="text-red-500">*</span></label>
                <InputText id="businessStreet" type="text" class="w-full" v-model="businessStreet" placeholder="Digite a rua" />
            </div>
            <div class="col-span-12 lg:col-span-4">
                <label for="businessNumber">Número <span class="text-red-500">*</span></label>
                <InputText id="businessNumber" type="text" class="w-full" v-model="businessNumber" placeholder="Digite o número" />
            </div>
            <div class="col-span-12 lg:col-span-4">
                <label for="businessComplement">Complemento</label>
                <InputText id="businessComplement" type="text" class="w-full" v-model="businessComplement" placeholder="Digite o complemento" />
            </div>
            <div class="col-span-12 lg:col-span-4">
                <label for="businessNeighborhood">Bairro <span class="text-red-500">*</span></label>
                <InputText id="businessNeighborhood" type="text" class="w-full" v-model="businessNeighborhood" placeholder="Digite o bairro" />
            </div>
            <div class="col-span-12 lg:col-span-4">
                <label for="businessCity">Cidade <span class="text-red-500">*</span></label>
                <InputText id="businessCity" type="text" class="w-full" v-model="businessCity" placeholder="Digite a cidade" />
            </div>
            <div class="col-span-12 lg:col-span-4">
                <label for="businessState">Estado <span class="text-red-500">*</span></label>
                <InputText id="businessState" type="text" class="w-full" v-model="businessState" placeholder="Digite o estado" />
            </div>
        </div>
        <div class="col-span-12 flex justify-between mt-4">
            <Button label="Voltar" @click="$emit('previous')" />
            <Button label="Próximo" :disabled="isNextButtonDisabled" @click="$emit('next')" v-tooltip.bottom="'Preencha todos os campos corretamente para habilitar o botão Próximo.'" v-if="isNextButtonDisabled" />
            <Button label="Próximo" :disabled="isNextButtonDisabled" @click="$emit('next')" v-else />
        </div>
    </div>
</template>
