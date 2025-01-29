<script setup>
import { ProductService } from '@/service/ProductService';
import { onMounted, ref } from 'vue';

const products = ref(null);

function formatCurrency(value) {
    return value.toLocaleString('pt-PT', { style: 'currency', currency: 'EUR' });
}

onMounted(() => {
    ProductService.getProductsSmall().then((data) => (products.value = data));
});
</script>

<template>
    <div class="card">
        <div class="font-semibold text-xl mb-4">Campos recentemente alugados</div>
        <DataTable :value="products" :rows="5" :paginator="true" responsiveLayout="scroll">
            <Column style="width: 15%" header="Imagem">
                <template #body="slotProps">
                    <img :src="`https://primefaces.org/cdn/primevue/images/product/${slotProps.data.image}`" :alt="slotProps.data.image" width="50" class="shadow" />
                </template>
            </Column>
            <Column field="name" header="Nome" :sortable="true" style="width: 35%"></Column>
            <Column field="price" header="Preço" :sortable="true" style="width: 35%">
                <template #body="slotProps">
                    {{ formatCurrency(slotProps.data.price) }}
                </template>
            </Column>
            <Column style="width: 15%" header="Ver">
                <template #body>
                    <Button icon="pi pi-search" type="button" class="p-button-text"></Button>
                </template>
            </Column>
        </DataTable>
    </div>
</template>
